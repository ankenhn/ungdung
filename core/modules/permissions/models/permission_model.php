<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Permission_model extends BF_Model
{

	protected $table_name		= 'permissions';


	protected $key			= 'permission_id';

	protected $soft_deletes = FALSE;

	protected $date_format = 'datetime';

	protected $set_created = FALSE;

	protected $set_modified = FALSE;

	function __construct()
	{
		parent::__construct();

	}//end __construct()

	// --------------------------------------------------------------------
    public function loadTable($kTable) {
        //set column you want select.
        $kTable['columns'][] = 'permission_id';
        //get data fill to table
        $this->db->select($kTable['columns']);
        if(!empty($kTable['where'])) {
            foreach($kTable['where'] as $where) {
                $this->db->or_like($where);
            }
        }
        $data= $this->db->order_by($kTable['order_by'],$kTable['sort_by'])->limit($kTable['limit'],$kTable['offset'])->get($this->table_name)->result();
        // total rows in database (with search).
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
                    'name'=> anchor(MODULE_URL.'/edit/'.$var->permission_id,$var->name),
                    'description'=> $var->description,
                    "DT_RowId"  =>  $var->permission_id,
                );
                $result['aaData'][$k] = $var;
            }
        }
        return $result;
    }
	/**
	 * Delete a particular permission from the database
	 *
	 * @access public
	 *
	 * @param int  $id    Permission ID to delete
	 *
	 * @return bool TRUE if the permission was deleted successfully, else FALSE
	 */
	function delete($id=0)
	{
		// delete the ercord
		$deleted = parent::delete($id);

		// if the delete was successful then delete the role_permissions for this permission_id
		if (TRUE === $deleted)
		{
			$this->role_permission_model->delete_for_permission($id);
		}

		return $deleted;

	}//end delete()

	// --------------------------------------------------------------------

	/**
	 * Deletes a particular permission from the database by name.
	 *
	 * @access public
	 *
	 * @param str	$name	The name of the permission to delete
	 * @param bool	$purge	Whether to use soft delete or not.
	 *
	 * @return bool TRUE if the permission was deleted successfully, else FALSE
	 */
	public function delete_by_name($name=null, $purge=false)
	{
		$perm = $this->find_by('name', $name);

		return $this->delete($perm->permission_id, $purge);
	}

	//--------------------------------------------------------------------

	function update($id=0, $data=array())
	{
		if($id==0) {
            return parent::insert($data);
        }
        else {
            return parent::update($id,$data);
        }
	}//end update()

	// --------------------------------------------------------------------

	public function permission_exists($permission=null)
	{
		if (empty($permission))
		{
			return null;
		}

		if ($this->find_by('name', $permission))
		{
			return TRUE;
		}

		return FALSE;

	}//end permission_exists()

	//--------------------------------------------------------------------

}//end Permission_model