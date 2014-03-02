<?php
/**
 * Author: Keith.
 * Email: coder.notepad@gmail.com
 * Date: 12/20/13
 * Time: 2:57 PM
 */

class Customer_model extends BF_Model {

    protected $table_name = 'customer';
    protected $date_format = 'datetime';


    public function __construct()
    {
        parent::__construct();
    }//end __construct()

    public function isUser() {
        if($customer = $this->getCustomer()) {
            if(!defined('CUSTOMER_ID')) {
                define('CUSTOMER_ID',$customer->customer_id);
            }
            return true;
        }
        return false;
    }

    public function getCustomer() {
        parent::join('domain','domain.customer_id=customer.customer_id','left');
        if(defined('CUSTOMER')) {
            parent::where('username',CUSTOMER);
        }
        else {
            parent::where(array('domain'=>site_url(),'domain.active'=>1));
        }

        return parent::find_by(array('expiry_date >'=>date("Y-m-d"),'customer.active'=>1));
    }


} 