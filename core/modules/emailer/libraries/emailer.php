<?php
/**
 * Author: Keith.
 * Email: coder.notepad@gmail.com
 * Date: 1/29/14
 * Time: 7:20 AM
 */

class Emailer {

    private $ci;
    private $settings = array();
    private $sender;
    public function __construct() {
        $this->ci =& get_instance();
        $this->default_settings();
    }
    public function send($config = array()) {
        $config['mailtype'] = 'html';
        $config = array_merge($this->settings,$config); //extends config
        $this->ci->load->library('email',$config);

        //set email data
        $to = isset($config['to']) ? $config['to'] : false;
        $subject = isset($config['subject']) ? $config['subject'] : false;
        $message = isset($config['message']) ? $config['message'] : false;
        $this->ci->email->from($this->sender['sender_email'],$this->sender['sender_name']);
        $this->ci->email->to($to);
        $this->ci->email->subject($subject);
        $this->ci->email->message($message);
        if($this->ci->email->send()) {
            return true;
        }
        else {
            return false;
        }
    }
    private function default_settings() {
        $settings = $this->ci->settings_lib->find_all();
        $this->sender = array(
            'sender_email'  =>  $settings['sender_email'],
            'sender_name'  =>  $settings['sender_name']
        );
        if($settings['protocol']=='sendmail') {
            $this->settings = array(
                'protocol'  =>  $settings['protocol'],
                'mailpath'  =>  $settings['mailpath']
            );
        } else if($settings['protocol']=='smtp') {
            $this->settings = array(
                'protocol'  =>  $settings['protocol'],
                'mailpath'  =>  $settings['mailpath'],
                'smtp_host'  =>  $settings['smtp_host'],
                'smtp_user'  =>  $settings['smtp_user'],
                'smtp_pass'  =>  $settings['smtp_pass'],
                'smtp_port'  =>  $settings['smtp_port'],
                'smtp_timeout'  =>  $settings['smtp_timeout'],
                'smtp_crypto'  =>  $settings['smtp_crypto']
            );
        }
        else {
            $this->settings = array(
                'protocol'  =>  $settings['protocol']
            );
        }
    }
} 