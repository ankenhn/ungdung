<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Keith.
 * Email: coder.notepad@gmail.com
 * Date: 3/1/14
 * Time: 7:43 PM
 */

class Activity_model extends BF_Model {

    protected $table_name = 'activity';
    protected $key = 'activity_id';
    protected $customer_id = true;

    public function __construct() {
        parent::__construct();
    }


    public function getNotification($offset) {
        parent::select('activity.*, users.avatar, users.first_name, users.last_name')->join('users','users.id=activity.user_id')->limit(15,$offset)->order_by('activity_id','desc');
        return parent::find_all();
    }
} 