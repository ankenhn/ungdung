<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Keith.
 * Email: coder.notepad@gmail.com
 * Date: 12/20/13
 * Time: 2:36 PM
 */


class Content extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        Template::set('toolbar_title', lang("Menu Manage"));
        $this->auth->restrict('Site.Menu.Manage');
        $this->load->model('menu_model');
        Template::set_block('sub_nav', 'content/_sub_nav');
    }

    public function index($offset = 0)
    {
        $action = $this->input->post('action');
        if (!empty($action)) {
            $checked = $this->input->post('checked');
            if (!empty($checked)) {
                switch (strtolower($action)) {
                    case 'active':
                        $this->menu_model->_activate($checked);
                        break;
                    case 'deactive':
                        $this->menu_model->_deactivate($checked);
                        break;
                    case 'delete':
                        $a = $this->menu_model->_delete($checked);
                        break;
                }
            } else {
                Template::set_message(lang('us_empty_id'), 'error');
            }
        }
        Assets::add_js($this->load->view('content/index_js', null, true), 'inline');
        Template::set('results', $this->menu_model->order_by('order')->find_all_by(array('parent' => 0)));
        Template::render();
    }

    public function create()
    {
        if ($this->input->post('submit')) {
            $result = $this->save();
            if ($result) {
                Template::set_message(lang("Insert Success"), 'success');
                Template::redirect(MODULE_URL);
            }
        }
        Assets::add_js($this->load->view('content/index_js', null, true), 'inline');
        Template::set('roles', $this->db->get('roles')->result());
        Template::set('menu', $this->db->where('parent', 0)->get('menu')->result());
        Template::set_view('content/form');
        Template::render();
    }

    public function edit($id = false)
    {
        $menu = $this->menu_model->find($id);
        if (empty($menu)) {
            Template::redirect(MODULE_URL);
        }
        if ($this->input->post('submit')) {
            $result = $this->save($id);
            if ($result) {
                Template::set_message(lang("Update Success"), 'success');
                Template::redirect(MODULE_URL);
            }
        }
        Assets::add_js($this->load->view('content/form_js', null, true), 'inline');
        Assets::add_js($this->load->view('content/index_js', null, true), 'inline');
        Template::set('roles', $this->db->get('roles')->result());
        Template::set('sub_menu', $this->db->where('parent', $id)->order_by('order')->get('menu')->result());
        Template::set('menu', $this->db->where('id !=', $id)->where('parent', 0)->get('menu')->result());
        Template::set('result', $menu);
        Template::set_view('content/form');
        Template::render();
    }

    public function upload()
    {
        $path = 'files/layout/icons/mainnav/';
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['max_size'] = '2000';
        $this->load->library('upload', $config);
        if ($this->upload->do_upload('image')) {
            $data = $this->upload->data();
            $response = array('status' => 'success', 'file_name' => $data['file_name']);
            echo json_encode($response);
        } else {
            $response = array('status' => 'error', 'error' => trim(strip_tags($this->upload->display_errors())));
            echo json_encode($response);
        }
    }

    public function order()
    {
        parse_str($this->input->post('sorted'),$row);
        $row = $row['row'];
        if (is_array($row) AND !empty($row)) {
            for ($i = 0; $i < count($row); $i++) {
                $this->db->where(array('id' => $row[$i]))->update('menu', array('order' => $i));
            }
            echo 'ok';
        }
    }

    private function save($id = 0)
    {
        $this->form_validation->set_rules('name', lang("Name"), "required|trim|strip_tags|xss_clean");
        $this->form_validation->set_rules('url', lang("URL"), "required|trim|strip_tags|xss_clean");
        $this->form_validation->set_rules('parent', lang("Parent"), "required|trim|strip_tags|xss_clean");
        $this->form_validation->set_rules('image', lang("Image"), "trim|strip_tags|xss_clean");
        $this->form_validation->set_rules('roles[]', lang("Roles"), "required|xss_clean");
        $this->form_validation->set_rules('target', lang("Target"), "required|trim|strip_tags|xss_clean");
        $this->form_validation->set_rules('active', lang("Status"), "required|trim|strip_tags|xss_clean");
        if ($this->form_validation->run()) {
            $data = array(
                'name' => $this->input->post('name'),
                'url' => $this->input->post('url'),
                'parent' => $this->input->post('parent'),
                'image' => $this->input->post('image'),
                'roles' => json_encode($this->input->post('roles')),
                'target' => $this->input->post('target'),
                'active' => $this->input->post('active'));
            $result = $this->menu_model->update($id, $data);
            return $result;
        }
        return false;
    }
}