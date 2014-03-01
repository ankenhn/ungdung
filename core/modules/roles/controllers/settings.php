<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Keith.
 * Email: coder.notepad@gmail.com
 * Date: 12/20/13
 * Time: 2:36 PM
 */


class Settings extends Admin_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->auth->restrict('Site.Roles.Manage');
		$this->load->model('role_model');
        $this->lang->load('role');
		Template::set_block('sub_nav', 'settings/_sub_nav');
	}//end __construct()

    public function loadTable() {
        $result = $this->role_model->loadTable($this->kTable);
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
                        case 'delete':
                            $this->role_model->_delete($ids);
                            break;
                    }
                }
                die();
            }
        }
        Template::set('toolbar_title',lang("Roles Manage"));
        Template::render();
	}//end index()

	//--------------------------------------------------------------------

	/**
	 * Create a new role in the database
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function create()
	{
		if ($this->input->post())
		{
			if ($this->save_role())
			{
				Template::set_message(lang("Create Success"), 'success');
				redirect(SITE_AREA .'/settings/roles');
			}
		}
        Template::set('toolbar_title', 'Create New Role');
		Template::set_view('settings/role_form');
		Template::render();

	}//end create()

	//--------------------------------------------------------------------

	/**
	 * Edit a role record
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function edit()
	{
		$id = (int)$this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message('Invalid Role ID.', 'error');
			redirect(MODULE_URL);
		}

        $role = $this->role_model->find($id);
        if(!has_permission('Site.'.$role->role_name.'.Manage')) {
            Template::set_message('Invalid Role ID.', 'error');
            redirect(MODULE_URL);
        }

		if (isset($_POST['save']))
		{
			if ($this->save_role($id))
			{
				Template::set_message(lang('Update Success'), 'success');
			}
		}

		$role = $this->role_model->find($id);
		Template::set('role', $role);
        Template::set('toolbar_title',lang('Update Role'));
		Template::set_view('settings/role_form');
		Template::render();

	}//end edit()

	//--------------------------------------------------------------------
	// !HMVC METHODS
	//--------------------------------------------------------------------

	/**
	 * Builds the matrix for display in the role permissions form.
	 *
	 * @access private
	 *
	 * @return string The table(s) of settings, ready to be used in a form.
	 */
	public function matrix()
	{
		$id = (int)$this->uri->segment(5);
		$role = $this->role_model->find($id);

		// Verify role has permission to modify this role's access control
		if ($this->auth->has_permission('Site.'.ucwords($role->role_name).'.Manage')) {
			$permissions_full = $role->permissions;

			$role_permissions = $role->role_permissions;

			$template = array();
			foreach ($permissions_full as $key => $perm)
			{
				$template[$perm->name]['perm_id'] = $perm->permission_id;
				$template[$perm->name]['value'] = 0;
				if(isset($role_permissions[$perm->permission_id]) )
				{
					$template[$perm->name]['value'] = 1;
				}
			}

			// Extract our pieces from each permission
			$domains = array();

			foreach ($template as $key => $value)
			{
				list($domain, $name, $action) = explode('.', $key);

				// Add it to our domains if it's not already there.
				if (!empty($domain) && !array_key_exists($domain, $domains))
				{
					$domains[$domain] = array();
				}

				// Add the preference to the domain array
				if (!isset($domains[$domain][$name]))
				{
					$domains[$domain][$name] = array(
						$action => $value
					);
				}
				else
				{
					$domains[$domain][$name][$action] = $value;
				}

				// Store the actions separately for building the table header
				if (!isset($domains[$domain]['actions']))
				{
					$domains[$domain]['actions'] = array();
				}

				if (!in_array($action, $domains[$domain]['actions']))
				{
					$domains[$domain]['actions'][] = $action;
				}
			}//end foreach

			$auth_failed = '';
		}
		else
		{
			$auth_failed = 'Authentication: You do not have the ability to manage the access control for this role.';
			$domains = '';
		}//end if

		// Build the table(s) in the view to make things a little clearer,
		// and return it!
		return $this->load->view('settings/matrix', array('domains' => $domains, 'authentication_failed' => $auth_failed), TRUE);

	}//end matrix()

	//--------------------------------------------------------------------


	//--------------------------------------------------------------------
	// !PRIVATE METHODS
	//--------------------------------------------------------------------

	private function save_role($id=0)
	{
		if ($id == 0)
		{
			$this->form_validation->set_rules('role_name', 'lang:Name', 'required|trim|unique[roles.role_name]|max_length[60]');
		}
		else
		{
			$_POST['role_id'] = $id;
			$this->form_validation->set_rules('role_name', 'lang:Name', 'required|trim|unique[roles.role_name,roles.role_id]|max_length[60]');
		}

		$this->form_validation->set_rules('description', 'lang:Description', 'trim|max_length[255]');
		$this->form_validation->set_rules('login_destination', 'lang:Login Destination', 'trim|max_length[255]');

		if ($this->form_validation->run())
		{
			$data = array(
                'role_name'     =>  $this->input->post('role_name'),
                'description'   =>  $this->input->post('description'),
                'login_destination' =>  $this->input->post('login_destination')
            );
            return $this->role_model->update($id,$data,$this->input->post('role_permissions'));
		}


	}//end save_role()

	public function permission_matrix()
	{
		// for the permission matrix
		$this->load->helper('inflector');

		Template::set('matrix_permissions', $this->permission_model->select('permission_id, name')->order_by('name')->find_all());
		Template::set('matrix_roles', $this->role_model->select('role_id, role_name')->where('deleted', 0)->find_all());

		$role_permissions = $this->role_permission_model->find_all_role_permissions();

		foreach($role_permissions as $rp)
		{
			$current_permissions[] = $rp->role_id.','.$rp->permission_id;
		}

		Template::set('matrix_role_permissions', $current_permissions);
		Template::set("toolbar_title", lang('Permission Matrix'));

		Template::set_view('settings/permission_matrix');
		Template::render();
	}//end permission_matrix()


	// --------------------------------------------------------------------

	/**
	 * Update the role_permissions table.
	 */
	public function matrix_update()
	{
		// The profiler would add a lot of HTML to the end of the response.
		// This response is supposed to be single piece of text used by JS.
		$this->output->enable_profiler(FALSE);

		$pieces = explode(',',$this->input->post('role_perm'));

		if (!$this->auth->has_permission('Permissions.'.$this->role_model->find( (int) $pieces[0])->role_name.'.Manage'))
		{
			$this->output->set_output(lang("Authentication: You do not have the ability to manage the access control for this role"));

			return;
		}

		if ($this->input->post('action') == 'true')
		{
			if(is_numeric($this->role_permission_model->create_role_permissions($pieces[0],$pieces[1])))
			{
				$msg = lang("Permission added for role");
			}
			else
			{
				$msg = lang("There was a problem adding the permission for the role: ") . $this->role_permission_model->error;
			}
		}
		else
		{
			if($this->role_permission_model->delete_role_permissions($pieces[0], $pieces[1]))
			{
				$msg = lang("Permission removed from the role.");
			}
			else
			{
				$msg = lang("There was a problem deleting the permission for the role: "). $this->role_permission_model->error;
			}
		}//end if

		$this->output->set_output($msg);
	}//end matrix_update()

	//--------------------------------------------------------------------

}//end Settings