<?php
/**
 * Author: Keith.
 * Email: coder.notepad@gmail.com
 * Date: 12/20/13
 * Time: 2:57 PM
 */

class Emailer_model extends BF_Model {

    protected $table_name = 'email_queue';
    protected $date_format = 'int';
    protected $fields = array(
        "id", "subject", "message", "to", "send_success", "send_failed"
    );


    public function __construct()
    {
        parent::__construct();

    }//end __construct()

    public function loadTable($kTable) {
        //set column you want select.
        $kTable['columns'][] = 'id';
        //get data fill to table
        $this->db->select($kTable['columns']);
        if(!empty($kTable['where'])) {
            foreach($kTable['where'] as $where) {
                $this->db->or_like($where);
            }
        }
        $data= $this->db->order_by($kTable['order_by'],$kTable['sort_by'])->limit($kTable['limit'],$kTable['offset'])->get($this->table_name)->result();
        // total rows found.
        $this->db->select($kTable['columns']);
        if(!empty($kTable['where'])) {
            foreach($kTable['where'] as $where) {
                $this->db->or_like($where);
            }
        }
        $totalDisplayRecords = $this->db->get($this->table_name)->num_rows();

        //total rows in database
        $totalRecords = $this->db->get($this->table_name)->num_rows();

        $result = array(
            "sEcho" => $kTable['sEcho'],
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalDisplayRecords,
            "aaData" => array()
        );
        if(!empty($data)) {
            foreach($data as $k=> $var) {
                $var = array (
                    'subject'=> anchor(MODULE_URL.'/edit/'.$var->id,$var->subject),
                    "DT_RowId"  =>  $var->id,
                );
                $result['aaData'][$k] = $var;
            }
        }
        return $result;
    }


    public function save($id=false,$data=array()) {
        $data['to'] = $data['to']!='' ? @json_encode(explode(",",$data['to'])) : "[]";
        $data['send_failed'] = "[]";
        $data['send_success'] = "[]";
        if(!$id) {
            return parent::insert($data);
        }
        $result = parent::update($id,$data);
        if($result) {
            return $id;
        }
        return false;
    }



} 