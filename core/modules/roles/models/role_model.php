<?php if (!defined('BASEPATH')) exit('No direct script access allowed');




class Role_model extends BF_Model
{

	protected $table_name	= 'roles';
    protected $table_users  = 'users';
	protected $key			= 'role_id';

	protected $soft_deletes	= TRUE;

	protected $date_format = 'datetime';

	protected $set_created = FALSE;

	protected $set_modified = FALSE;

	//--------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();

		if ( ! class_exists('Permission_model'))
		{
			$this->load->model('permissions/permission_model');
		}

	}//end __construct()

	//--------------------------------------------------------------------
    public function loadTable($kTable) {

        $roles = $this->db->get($this->table_name)->result();
        $rolesManage = array();
        if(!empty($roles)) {
            foreach($roles as $role) {
                if(has_permission('Site.'.$role->role_name.'.Manage')) {
                    $rolesManage[] = $role->role_id;
                }
            }
        }

        //set column you want select.
        $kTable['columns'][] = $this->table_name.'.role_id';
        //get data fill to table
        $this->db->select($kTable['columns']);

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

        $data= $this->db->select(array($this->table_name.'.*','COUNT(id) as total_user'))->join($this->table_users,$this->table_users.'.role_id='.$this->table_name.'.role_id','left')->where_in($this->table_name.'.role_id',$rolesManage)->where($strWhere,null,false)->order_by($kTable['order_by'],$kTable['sort_by'])->group_by($this->key)->limit($kTable['limit'],$kTable['offset'])->get($this->table_name)->result();

        // total rows in database (with search).
        $this->db->select($kTable['columns']);

        $totalDisplayRecords = $this->db->join($this->table_users,$this->table_users.'.role_id='.$this->table_name.'.role_id','left')->where_in($this->table_name.'.role_id',$rolesManage)->where($strWhere,null,false)->group_by($this->key)->get($this->table_name)->num_rows();

        //total rows in database
        $totalRecords = $this->db->where_in($this->table_name.'.role_id',$rolesManage)->where($strWhere,null,false)->get($this->table_name)->num_rows();

        $result = array(
            "sEcho" => $kTable['sEcho'],
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalDisplayRecords,
            "aaData" => array()
        );
        if(!empty($data)) {
            foreach($data as $k=> $var) {
                $var = array (
                    'role_name'=> anchor(MODULE_URL.'/edit/'.$var->role_id,$var->role_name),
                    '__NO__SELECT__total_user'=> $var->total_user,
                    "DT_RowId"  =>  $var->role_id,
                );
                $result['aaData'][$k] = $var;
            }
        }
        return $result;
    }

	public function find($id=NULL)
	{
		$role = parent::find($id);
		if ($role == FALSE)
		{
			return FALSE;
		}

		$this->get_role_permissions($role);

		return $role;

	}//end find()

	//--------------------------------------------------------------------

	/**
	 * Locates a role based on the role name. Case doesn't matter.
	 *
	 * @access public
	 *
	 * @param string $name A string with the name of the role.
	 *
	 * @return object An object with the role and its permissions, or FALSE
	 */
	public function find_by_name($name=NULL)
	{
		if (empty($name))
		{
			return FALSE;
		}

		$role = $this->find_by('role_name', $name);

		$this->get_role_permissions($role);

		return $role;

	}//end find_by_name()

	//--------------------------------------------------------------------


	/**
	 * A simple update of the role. This does, however, clean things up
	 * when setting this role as the default role for new users.
	 *
	 * @access public
	 *
	 * @param int   $id   An int, being the role_id
	 * @param array $data An array of key/value pairs to update the db with.
	 *
	 * @return bool TRUE on successful update, else FALSE
	 */
	public function update($id=NULL, $data=NULL,$permissions=array())
	{
		if($id==0) {
            $result = parent::insert($data);
            if($result) {
                //add permission
                $permission = array(
                    'name'  =>  'Site.'.$data['role_name'].'.Manage',
                    'description'   =>  'To manage the access control permissions for the  role'
                );
                return $this->db->insert('permissions',$permission);
            }
        }
        else {
            $oldRole = parent::find($id);
            $result = parent::update($id,$data);
            if($result) {
                //update permission
                $permission = array(
                    'name'  =>  'Site.'.$data['role_name'].'.Manage',
                );
                $this->role_permission_model->set_for_role($id, $permissions);
                return $this->db->where('name','Site.'.$oldRole->role_name.'.Manage')->update('permissions',$permission);
            }
        }

	}//end update()

	//--------------------------------------------------------------------

	/**
	 * Verifies that a role can be deleted.
	 *
	 * @param int $role_id The role to verify.
	 *
	 * @return bool TRUE if the role can be deleted, else FALSE
	 */
	public function can_delete_role($role_id=0)
	{
		$this->db->select('can_delete');
		$delete_role = parent::find($role_id);

		if ($delete_role->can_delete == 1)
		{
			return TRUE;
		}

		return FALSE;

	}//end can_delete_role()

	//--------------------------------------------------------------------

	/**
	 * Deletes a role. By default, it will perform a soft_delete and
	 * leave the permissions untouched. However, if $purge == TRUE, then
	 * all permissions related to this role are also deleted.
	 *
	 * @access public
	 *
	 * @param int  $id    An integer with the role_id to delete.
	 * @param bool $purge If FALSE, will perform a soft_delete. If TRUE, will remove the role and related permissions from db.
	 *
	 * @return bool TRUE/FALSE
	 */
	function delete($id=0, $purge=FALSE)
	{
		// We might not be allowed to delete this role.
		if ($this->can_delete_role($id) == FALSE)
		{
			$this->error = 'This role can not be deleted.';
			return FALSE;
		}

		if ($this->default_role_id() == $id)
		{
			$this->error = 'The default role can not be deleted.';
			return FALSE;
		}

		if ($purge === TRUE)
		{
			// temporarily set the soft_deletes to TRUE.
			$this->soft_deletes = FALSE;
		}

		// get the name for management deletion later
		$role = $this->role_model->find($id);

		// delete the record
		$deleted = parent::delete($id);

		if ($deleted === TRUE)
		{
			// Now update the users to the default role
			if ( ! class_exists('User_model'))
			{
				$this->load->model('users/User_model','user_model');
			}

			$this->user_model->set_to_default_role($id);

			// now delete the role_permissions for this role
			$this->role_permission_model->delete_for_role($id);

			// now delete the manage permission for this role
			$permission_name = 'Permissions.' . ucwords($role->role_name) . '.Manage';

			if ( ! class_exists('Permission_model'))
			{
				$this->load->model('permissions/permission_model');
			}

			$perm = $this->permission_model->find_by('name', $permission_name);
			if ($perm)
			{
				// remove the role_permissions for this permission
				$this->db->delete('role_permissions', array('permission_id' => $perm->permission_id));
				$this->db->delete('permissions', array('name' => $permission_name));
			}
		}//end if

		return $deleted;

	}//end delete()

	//--------------------------------------------------------------------

	/**
	 * Returns the id of the default role.
	 *
	 * @access public
	 *
	 * @return mixed ID of the default role or FALSE
	 */
	public function default_role_id()
	{
		$this->db->where('default', 1);
		$query = $this->db->get($this->table_name);

		if ($query->num_rows() == 1)
		{
			return (int)$query->row()->role_id;
		}

		return FALSE;

	}//end default_role_id()

	//--------------------------------------------------------------------

	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	/**
	 * Finds the permissions and role_permissions array for a single role.
	 *
	 * @access public
	 *
	 * @param int $role A reference to an existing role object. This object is modified directly.
	 *
	 * @return void
	 */
	public function get_role_permissions(&$role)
	{
		if ( ! is_object($role))
		{
			return;
		}

		$permission_array = array();

		// Grab our permissions for the role.
		$permissions = $this->permission_model->find_all();

		// Permissions
		foreach ($permissions as $key => $permission)
		{
			$permission_array[$permission->name] = $permission;
		}

		$role->permissions = $permission_array;

		if ( ! class_exists('Role_permission_model'))
		{
			$this->load->model('roles/role_permission_model');
		}

		// Role Permissions
		$permission_array = array();
		$role_permissions = $this->role_permission_model->find_for_role($role->role_id);

		if (is_array($role_permissions) && count($role_permissions))
		{
			foreach ($role_permissions as $key => $permission)
			{
				$permission_array[$permission->permission_id] = 1;
			}
		}

		$role->role_permissions = $permission_array;
		unset($permission_array);

	}//end get_role_permissions()

	//--------------------------------------------------------------------

}//end Role_model