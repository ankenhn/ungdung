<?php
/**
 * Author: Keith.
 * Email: coder.notepad@gmail.com
 * Date: 12/20/13
 * Time: 2:36 PM
 */

class Uploader extends Front_Controller {

    private $configUpload = array(
        'upload_path'   =>  '',
        'allowed_types' =>  '',
        'max_size'      =>  '',
        'remove_spaces' => TRUE
);
    public function __construct() {
        parent::__construct();

        $htaccess="<Files ~ '\.(php|php3|php4|php5|phtml|pl|cgi|aspx|asp|xml|py)$'>
                     order deny,allow
                     deny from all
                    </Files>";
        $path = 'assets/uploads/';
        if($this->input->post('folder')) {
            $path .= md5($this->input->post('folder')).'/';
            if(!is_dir($path)) {
                mkdir($path,0777);
                $fp = fopen($path.'/.htaccess', 'w');
                fwrite($fp, $htaccess);
                fclose($fp);
            }
        }
        $path .= md5(date('Y')).'/';
        if(!is_dir($path)) {
            mkdir($path,0777);
            $fp = fopen($path.'/.htaccess', 'w');
            fwrite($fp, $htaccess);
            fclose($fp);
        }

        $path .= md5(date('J')).'/';
        if(!is_dir($path)) {
            mkdir($path,0777);
            $fp = fopen($path.'/.htaccess', 'w');
            fwrite($fp, $htaccess);
            fclose($fp);
        }
        $this->set_config(array('upload_path'=>$path,'allowed_types'=>$this->allowed_upload(),'max_size'=>settings_item('size.upload')));
        if($this->input->post('type')) {
            $this->set_config('allowed_types',$this->allowed_upload($this->input->post('type')));
        }
    }

    public function index() {
        $this->load->library('upload', $this->get_config());
        if ($this->upload->do_upload('file')) {
            $data=$this->upload->data();
            $response = array(
                'status' => 'success',
                'file_path'=> $this->configUpload['upload_path'],
                'file_name'=> $data['file_name'],
                'file_url'=> $this->configUpload['upload_path'].$data['file_name']
            );
            echo (json_encode($response));
        }
        else {
            if(isset($_FILES['file']['name'])) {
                $error = $_FILES['file']['name'].': '.trim(strip_tags($this->upload->display_errors()));
            }
            else {
                $error = trim(strip_tags($this->upload->display_errors()));
            }
            $response = array(
                'status'=>'error',
                'error' => $error
            );
            echo (json_encode($response));
        }
    }// end upload

    private function get_config() {
        return $this->configUpload;
    }// end get config

    private function set_config($name=null,$value=null) {
        if(is_array($name)) {
            $this->configUpload = $name;
        }
        else {
            $this->configUpload[$name] = $value;
        }
    } // end set config

    private function allowed_upload($type='gallery') {
        switch($type) {
            case 'media':
                return str_replace(",","|",settings_item('media.upload'));
            break;
            case 'all':
                return str_replace(",","|",settings_item('media.upload').','.settings_item('gallery.upload'));
            break;
            default:
                return str_replace(",","|",settings_item('gallery.upload'));
            break;
        }
    }


}