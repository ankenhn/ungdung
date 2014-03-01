<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: DuyAnk
 * Date: 2/12/14
 * Time: 2:16 PM
 */

class Home extends Front_Controller {

    function __construct() {
        parent::__construct();
    }

    function index() {
        Template::render();
    }
}