<?php
/**
 * Author: Keith.
 * Email: coder.notepad@gmail.com
 * Date: 1/29/14
 * Time: 8:22 AM
 */

class Settings extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('emailer_model');
        Template::set_block('sub_nav','settings/_sub_nav');
    }

    public function loadTable() {
        $result = $this->emailer_model->loadTable($this->kTable);
        exit(json_encode($result));
    }

    public function index() {
        $this->auth->restrict('Emailer.Queue.Update');
        $action = $this->input->post('action');
        if (!empty($action) AND has_permission('Emailer.Queue.Update'))
        {
            $checked = $this->input->post('checked');
            if (!empty($checked))
            {
                foreach($checked as $ids)
                {
                    switch(strtolower($action))
                    {
                        case 'delete':
                            $this->emailer_model->_delete($ids);
                            break;
                    }
                }
                die();
            }
        }
        Template::set('toolbar_title','Email Queue Manage');
        Template::render();
    } //end function index

    public function create() {
        $this->auth->restrict('Emailer.Queue.Update');
        if($this->input->post()) {
            if($this->save()) {
                Template::set_message('Create Success','success');
            } // save data.
        }
        Template::set('toolbar_title','Add Queue');
        Template::set_view('settings/form');
        Template::render();
    }

    public function edit($id = false) {
        $result = $this->emailer_model->find($id);
        if(!$result) {
            Template::set_message('Queue Not Found','warning');
            Template::redirect(MODULE_URL);
        }
        if($this->input->post()) {
            if($this->save($id)) {
                Template::set_message('Update Success','success');
            } // save data.
        }


        Template::set('toolbar_title','Add Queue');
        Template::set('result',$result);
        Template::set_view('settings/form');
        Template::render();
    }

    public function run($id=false) {
        $this->auth->restrict('Emailer.Queue.Run');
        $result = $this->emailer_model->find($id);
        if(!$result) {
            Template::set_message('Queue Not Found','warning');
            Template::redirect(MODULE_URL);
        }
        Assets::add_js($this->load->view('settings/form_js',null,true),'inline');
        Template::set('toolbar_title','Run Queue');
        Template::set('result',$result);
        Template::render();
    }
    public function send_email() {
        $queue = $this->input->post('queue_id');
        $target = $this->emailer_model->find($queue);
        $send_failed = json_decode($target->send_failed);
        $send_success = json_decode($target->send_success);
        $email = array_merge($send_failed,$send_success);
        $emailList = array_merge(array_diff(json_decode($target->to),$email));
        if(empty($emailList)) return false;
        $config = array(
            'to'    =>  $emailList[0],
            'subject'=> $target->subject,
            'message'=> $target->message
        );

        $this->load->library('emailer');
        if($this->emailer->send($config)) {
            $send_success[] = $emailList[0];
            $this->emailer_model->update($queue,array('send_success'=>json_encode($send_success)));
            if(isset($emailList[1]))
                exit(json_encode(array('status'=>true,'email'=>$emailList[0],'next'=>$emailList[1])));
            else
                exit(json_encode(array('status'=>true,'email'=>$emailList[0])));

        }
        else {
            $send_failed[] = $emailList[0];
            $this->emailer_model->update($queue,array('send_failed'=>json_encode($send_failed)));
            if(isset($emailList[1])) {
                exit(json_encode(array('status'=>false,'email'=>$emailList[0],'next'=>$emailList[1])));
            }
            else {
                exit(json_encode(array('status'=>false,'email'=>$emailList[0])));
            }
        }
    }
    private function save($id=0) {
        $this->form_validation->set_rules('subject','Subject','required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('to','To','required|trim|strip_tags|xss_clean');
        $this->form_validation->set_rules('message','Message','trim|strip_tags|xss_clean');
        if($this->form_validation->run()) {
            return $this->emailer_model->save($id,$this->input->post());
        }
    }
} 