<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Keith.
 * Email: coder.notepad@gmail.com
 * Date: 3/1/14
 * Time: 10:44 AM
 */

class Customer {

    private $ci;
    private $db;
    public function __construct() {
        $this->ci =&get_instance();
        $this->db = $this->ci->load->database('customer',TRUE);
    }
} 