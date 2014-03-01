<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



class Contexts
{

	protected static $menu	= array();
	protected static $ci;


	//--------------------------------------------------------------------

	public function __construct()
	{
		self::$ci =& get_instance();

	}//end __construct()

	//--------------------------------------------------------------------

    public static function render_menu($class='nav',$exp='wexp') {
        $site_url=site_url(SITE_AREA.'/'.self::$ci->uri->segment(2).'/'.self::$ci->uri->segment(3));
        $role=self::$ci->auth->role_id();
        $role='"'.$role.'"';
        $menus=self::$ci->db->where(array('active'=>1,'parent'=>0))->like('roles',$role)->order_by('order')->get('menu')->result();
        $nav=null;
        if(!empty($menus)) {
            $nav    =   "<ul class='{$class}'>";
            foreach($menus as $k => $menu) {
                $items=self::$ci->db->where(array('active'=>1,'parent'=>$menu->id))->like('roles',$role)->order_by('order')->get('menu')->result();
                $subnav=null;
                $cls_s = false;
                if(!empty($items)) {
                    $subnav    .=  '<ul>';
                    foreach($items as $item) {
                        $target=$item->target;
                        $url=site_url($item->url);
                        if(is_int(strpos($url,$site_url))) $cls_s=true;
                        $name=ucwords($item->name);
                        $subnav    .=  "<li><a href='{$url}' target='{$target}' title='{$name}'>{$name}</a></li>";
                    }
                    $subnav    .=  '</ul>';
                }
                $subclass= ($subnav!=null) ? $exp : '';
                $target=$menu->target;
                $url=site_url($menu->url);
                $name=ucwords($menu->name);
                if(is_int(strpos($url,$site_url))) $cls_s=true;
                if($cls_s) $cls='nav_active';
                else $cls='';
                if(is_int(strpos(site_url($menus[0]->url),$site_url)) AND $k!=0) $cls=''; 
                $image = (is_file($menu->image))  ?  site_url($menu->image)  : '';
                $nav    .=  "<li class='{$cls}'><a href='{$url}' title='{$name}' target='{$target}' class='{$subclass}'><img src='{$image}' style='max-width:23px; max-height:23px;' /><span>{$name}</span></a>";
                $nav    .=  $subnav;
                $nav    .=  "</li>";
            }
            $nav    .=  '</ul>';
        }
        return $nav;
    }

	//--------------------------------------------------------------------

}//end Contexts
