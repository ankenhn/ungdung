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
        $this->auth->restrict('Site.Settings.Manage');
		Template::set('toolbar_title', 'Site Settings');
        Template::set_block('secNav','settings/_secNav');

	}//end __construct()

	public function index()
	{
        if($this->input->post('webConfig')) {
            if($this->save_settings()) {
                Template::set_message('Update Settings Success','success');
                Template::redirect($this->uri->uri_string());
            }
        }
        if($this->input->post('emailSystem')) {
            if($this->save_emailSystem()) {
                Template::set_message('Update Settings Success','success');
            }
        }
        if($this->input->post('btnMaintenance')) {
            if($this->save_maintenance()) {
                Template::set_message('Update Settings Success','success');
            }
        }
        $settings = $this->settings_lib->find_all();
        Assets::add_js($this->load->view('settings/index_js',array('settings'=>$settings),true),'inline');
		Template::set('settings', $settings);
		Template::render();

	}//end index()

	private function save_settings()
	{
        $this->form_validation->set_rules('title', lang("Site Name"), 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('keyword', lang("Meta Keyword"), 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('description', lang("Meta Description"), 'required|trim|strip_tags|xss_clean');
		if ($this->form_validation->run()) {
            $data = array(
                array('name' => 'site.title', 'value' => $this->input->post('title')),
                array('name' => 'meta.keyword', 'value' => $this->input->post('keyword')),
                array('name' => 'meta.description', 'value' => $this->input->post('description'))
            );
            // save the settings to the DB
            $updated = $this->settings_model->update_batch($data, 'name');
            return $updated;
		}
	}//end save_settings()

    private function save_maintenance() {
        $this->form_validation->set_rules('opMaintenance', lang("Maintenance"), 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('maintenance_content', lang("Maintenance Content"), 'required');
        if ($this->form_validation->run()) {
            $data = array(
                array('name' => 'site.maintenance', 'value' => $this->input->post('opMaintenance')),
                array('name' => 'site.maintenance_content', 'value' => $this->input->post('maintenance_content')),
            );
            // save the settings to the DB
            $updated = $this->settings_model->update_batch($data, 'name');
            return $updated;
        }
    }
    private function save_emailSystem() {
        $this->form_validation->set_rules('sender_email', lang("Sender Email"), 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('sender_name', lang("Sender Name"), 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('protocol', lang("Protocol"), 'required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('mailpath', lang("Mail Path"), 'trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('smtp_host', lang("SMTP Host"), 'trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('smtp_user', lang("SMTP User"), 'trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('smtp_pass', lang("SMTP Pass"), 'trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('smtp_port', lang("SMTP Port"), 'trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('smtp_timeout', lang("SMTPTimeout"), 'trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('smtp_crypto', lang("SMTP Encrypt"), 'trim|strip_tags|xss_clean');
        if ($this->form_validation->run()) {
            $data = array(
                array('name' => 'sender_email', 'value' => $this->input->post('sender_email')),
                array('name' => 'sender_name', 'value' => $this->input->post('sender_name')),
                array('name' => 'protocol', 'value' => $this->input->post('protocol')),
                array('name' => 'mailpath', 'value' => $this->input->post('mailpath')),
                array('name' => 'smtp_host', 'value' => $this->input->post('smtp_host')),
                array('name' => 'smtp_user', 'value' => $this->input->post('smtp_user')),

                array('name' => 'smtp_port', 'value' => $this->input->post('smtp_port')),
                array('name' => 'smtp_timeout', 'value' => $this->input->post('smtp_timeout')),
                array('name' => 'smtp_crypto', 'value' => $this->input->post('smtp_crypto')),
            );
            if(md5(settings_item('smtp_pass'))!=$this->input->post('smtp_pass')) {
                $data[] = array('name' => 'smtp_pass', 'value' => $this->input->post('smtp_pass'));
            }
            // save the settings to the DB
            $updated = $this->settings_model->update_batch($data, 'name');
            return $updated;
        }
    }
}//end Settings()
