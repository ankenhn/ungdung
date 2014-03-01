<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Settings extends Admin_Controller
{

	function __construct()
	{
 		parent::__construct();
		$this->auth->restrict('Site.Permissions.Manage');
		$this->load->model('permission_model');
        $this->lang->load("permission");
		Template::set_block('sub_nav', 'settings/_sub_nav');

	}//end __construct()

	//--------------------------------------------------------------------
    public function loadTable() {
        $result = $this->permission_model->loadTable($this->kTable);
        exit(json_encode($result));
    }
    //--------------------------------------------------------------------
    public function index()
    {
        $action = $this->input->post('action');
        if (!empty($action))
        {
            $checked = $this->input->post('checked');

            if (!empty($checked))
            {
                foreach($checked as $ids)
                {
                    switch(strtolower($action))
                    {
                        case 'active':
                            $this->permission_model->_activate($ids);
                            break;
                        case 'deactive':
                            $this->permission_model->_deactivate($ids);
                            break;
                        case 'delete':
                            $this->permission_model->_delete($ids);
                            break;
                    }
                }
                die();
            }
        }
        Template::set('toolbar_title',lang('Permissions Manage'));
        Template::render();
    }//end index()


	//--------------------------------------------------------------------

	/**
	 * Create a new permission in the database
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function create()
	{
		if ($this->input->post())
		{
			if ($this->save_permissions())
			{
				Template::set_message(lang("Create Success"), 'success');
				Template::redirect(MODULE_URL);
			}
		}
		Template::set('toolbar_title',lang('Create Permission'));
		Template::set_view('settings/permission_form');
		Template::render();

	}//end create()

	//--------------------------------------------------------------------

	public function edit($id=false)
	{
        $permission = $this->permission_model->find($id);
		if (empty($permission)) {
			Template::set_message(lang("Permission Not Found"), 'error');
			redirect(SITE_AREA .'/settings/permissions');
		}

		if ($this->input->post())
		{
			if ($this->save_permissions($id))
			{
				Template::set_message(lang("Update Success"), 'success');
			}
		}

		Template::set('result', $permission);
		Template::set('toolbar_title', 'Update Permission');
		Template::set_view('settings/permission_form');
		Template::render();

	}//end edit()

	//--------------------------------------------------------------------

	/**
	 * Save the permission record to the database
	 *
	 * @access private
	 *
	 * @param string $type The type of save operation (insert or edit)
	 * @param int    $id   The record ID in the case of edit
	 *
	 * @return bool
	 */
	private function save_permissions($id=0)
	{

		$this->form_validation->set_rules('name','lang:Name','required|trim|strip_tags|max_length[30]');
		$this->form_validation->set_rules('description','lang:Description','trim|strip_tags|max_length[100]');
		if ($this->form_validation->run())
		{
            $data = array(
                'name'          =>  $this->input->post('name'),
                'description'   =>  $this->input->post('description'),
                'status'        =>  'active'
            );
			return $this->permission_model->update($id,$data);
		}

	}//end save_permissions()

	//--------------------------------------------------------------------
}//end settings
