<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Keith.
 * Email: coder.notepad@gmail.com
 * Date: 12/20/13
 * Time: 2:36 PM
 */


class Menu_model extends BF_Model
{

    protected $table_name = 'menu';
    protected $key = 'id';

    protected $fields = array(
        "id", "name", "url", "target", "order", "parent", "image", "roles", "active"
    );


    function __construct() {
        parent::__construct();
    }

    function update($id,$data) {
        if($id==0)
            return parent::insert($data);
        else
            return parent::update($id,$data);
    }

    public function _delete($ids= array()) {
    $menus = array();
        if(!empty($ids)) {
            foreach($ids as $var) {
                $menus = array_merge($this->getChildrenItems($var),$menus);
            }
            parent::_delete($menus);
        }
    }

    private function getChildrenItems($item) {
        $menu = parent::find_all_by(array('parent'=>$item));
        $items= array($item);
        if(!empty($menu)) {
            foreach($menu as $var) {
                $items[] = $var->id;
            }
        }
        return $items;
    }
}




