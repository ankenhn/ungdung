<?php
/**
 * Author: Keith.
 * Email: coder.notepad@gmail.com
 * Date: 12/20/13
 * Time: 2:57 PM
 */

class Users_model extends BF_Model {

    protected $table_name = 'users';
    protected $roles_table = 'roles';
    protected $date_format = 'datetime';
    protected $target_url = '/settings/users/profile/';
    protected $customer_id =true;

    public function __construct()
    {
        parent::__construct();

    }//end __construct()

    public function loadTable($kTable) {

        //check role user manage
        $this->load->model('roles/role_model');
        $roles = $this->role_model->find_all();
        $rolesManage = array();
        if(!empty($roles)) {
            foreach($roles as $role) {
                if(has_permission('Site.'.$role->role_name.'.Manage')) {
                    $rolesManage[] = $role->role_id;
                }
            }
        }

        //set column you want select.
        $kTable['columns'][] = 'id';
        //get data fill to table
        parent::select($kTable['columns']);
        parent::select("CONCAT(first_name, ' ', last_name) AS full_name",false);
        //build where query
        $strWhere = null;
        if(!empty($kTable['where'])) {
            foreach($kTable['where'] as $where) {
                $key = array_shift(array_keys($where));
                $value = array_shift(array_values($where));
                $strWhere .= " {$key} LIKE '%{$value}%' OR";
            }
            $strWhere = "(".substr($strWhere,0,-2).")";
        }
        //list all data
        $data= parent::join($this->roles_table,$this->roles_table.'.role_id='.$this->table_name.'.role_id')->where_in($this->table_name.'.role_id',$rolesManage)->where($strWhere,null,false)->order_by($kTable['order_by'],$kTable['sort_by'])->limit($kTable['limit'],$kTable['offset'])->find_all();

        // total rows found.
        $totalDisplayRecords = parent::join($this->roles_table,$this->roles_table.'.role_id='.$this->table_name.'.role_id')->where_in($this->table_name.'.role_id',$rolesManage)->where($strWhere,null,false)->find_all();

        //total rows in database
        $totalRecords = $this->db->join($this->roles_table,$this->roles_table.'.role_id='.$this->table_name.'.role_id')->where_in($this->table_name.'.role_id',$rolesManage)->get($this->table_name)->num_rows();

        $result = array(
            "sEcho" => $kTable['sEcho'],
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalDisplayRecords,
            "aaData" => array()
        );
        if(!empty($data)) {
            foreach($data as $k=> $var) {
                $var = array (
                    '__NO__SELECT__full_name'=> anchor(MODULE_URL.'/edit/'.$var->id,$var->full_name),
                    'email'=> $var->email,
                    'role_name'=> $var->role_name,
                    'last_login'=> ($var->last_login!='0000-00-00 00:00:00' ? date("d/m/Y H:i",strtotime($var->last_login)) : '- - -'),
                    'active' => showStatus($var->active),
                    "DT_RowId"  =>  $var->id,
                );
                $result['aaData'][$k] = $var;
            }
        }
        return $result;
    }


    public function save($id=false,$data=array()) {
        $data = $this->assignData($data);
        if(!$id) {
            $this->action = 'created a user';
            return parent::insert($data);
        }
        $this->action = 'updated a user';
        $result = parent::update($id,$data);
        if($result) {
            return $id;
        }
        return false;
    }

    private function assignData($data = array()) {
        $data['birthday']  =  strToDate($data['birthday']);

        if(isset($data['password']) AND $data['password']!='') {
            //generate password
            $password = $this->auth->hash_password($data['password']);
            if(isset($password['hash'])) $data['password_hash']=$password['hash'];
        }

        //set role_id
        if(isset($data['role_id']) AND has_permission('Permission.Users.Manage')) {
            $roleName = $this->db->where('role_id',$data['role_id'])->get('roles')->row('role_name');
            if(has_permission('Site.Roles.Manage') AND has_permission('Site.' . $roleName . '.Manage')) {
                $data['role_id'] = $data['role_id'];
            }
        }
        return $data;
    }


} 