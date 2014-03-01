<?php
/**
 * Author: Keith.
 * Email: coder.notepad@gmail.com
 * Date: 12/20/13
 * Time: 2:36 PM
 */

class Settings extends Admin_Controller {


    public function __construct() {
        parent::__construct();
        $this->load->model('users_model');
        Template::set_block('sub_nav','settings/_sub_nav');
        $this->lang->load('user');
    }

    public function loadTable() {
        $this->auth->restrict('Permission.Users.Manage');
        $result = $this->users_model->loadTable($this->kTable);
        exit(json_encode($result));
    }

    public function index() {
        $this->auth->restrict('Permission.Users.Manage');
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
                            $this->users_model->_activate($ids);
                            break;
                        case 'deactive':
                            $this->users_model->_deactivate($ids);
                            break;
                        case 'delete':
                            $this->users_model->_delete($ids);
                            break;
                    }
                }
                die();
            }
        }
        Template::set('toolbar_title',lang('Users Manage'));
        Template::render();
    } //end function index

    public function create() {
        $this->auth->restrict('Permission.Users.Manage');
        if($this->input->post()) {
            if($this->save()) {
                Template::set_message(lang('Create Success'),'success');
            } // save data.
        }
        Assets::add_js($this->load->view('settings/form_js',null,true),'inline');
        Template::set('roles',$this->db->get('roles')->result());
        Template::set('toolbar_title',lang('Create User'));
        Template::set_view('settings/form');
        Template::render();
    }

    public function edit($id = false) {
        if(!$id) {
            $id = $this->auth->user_id();
        }
        if(!has_permission('Permission.Users.Manage') AND $id != $this->auth->user_id()) {
            Template::set_message(lang('User Not Found'), 'warning');
            Template::redirect(SITE_AREA);
        }

        if(!$user = $this->users_model->find($id)) {
            Template::set_message(lang('User Not Found'),'warning');
            Template::redirect(MODULE_URL);
        } // check exist

        if(!has_permission('Site.'.$this->db->where('role_id',$user->role_id)->get('roles')->row('role_name').'.Manage')) {
            Template::set_message(lang('User Not Found'), 'error');
            redirect(MODULE_URL);
        }
        if($this->input->post()) {
            if($this->save($id)) {
                Template::set_message(lang('Update Success'),'success');
            } // save data.
        }


        Assets::add_js($this->load->view('settings/form_js',null,true),'inline');
        Template::set('toolbar_title',lang('Update User'));
        Template::set('roles',$this->db->get('roles')->result());
        Template::set('user',$user);
        Template::set_view('settings/form');
        Template::render();
    }

    private function save($id = false) {
        $extra_unique_rule = null;
        if ($id) {
            $_POST['id'] = $id;
            $extra_unique_rule = ',users.id';
        }
        if(has_permission('Permission.Users.Manage') AND has_permission('Site.Roles.Manage')) {
            $this->form_validation->set_rules('role_id','lang:Role Name','required|trim|strip_tags|xss_clean');
        }
        $this->form_validation->set_rules('first_name','lang:First Name','required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('last_name','lang:Last Name','required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('email','lang:Email','required|trim|strip_tags|xss_clean|unique[users.email'.$extra_unique_rule.']');
        if($id) {
            $this->form_validation->set_rules('password','lang:Password','trim|strip_tags|xss_clean');
            $this->form_validation->set_rules('pass_confirm','lang:Pass Confirm','trim|strip_tags|xss_clean|matches[password]');
        }
        else {
            $this->form_validation->set_rules('password','lang:Password','required|trim|strip_tags|xss_clean');
            $this->form_validation->set_rules('pass_confirm','lang:Pass Confirm','trim|strip_tags|xss_clean|matches[password]');
        }
        $this->form_validation->set_rules('birthday','lang:Birthday','trim|strip_tags|xss_clean|date');
        if($this->form_validation->run()) {
            return $this->users_model->save($id,$this->input->post());
        }
    }

}