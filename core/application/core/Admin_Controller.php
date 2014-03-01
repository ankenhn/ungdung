<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Admin Controller
 *
 * This class provides a base class for all admin-facing controllers.
 * It automatically loads the form, form_validation and pagination
 * helpers/libraries, sets defaults for pagination and sets our
 * Admin Theme.
 *
 * @package    Bonfire
 * @subpackage MY_Controller
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Admin_Controller extends Authenticated_Controller
{
    protected $pager;
    protected $limit;
    protected $kTable;
    //--------------------------------------------------------------------

    /**
     * Class constructor - setup paging and keyboard shortcuts as well as
     * load various libraries
     *
     */
    public function __construct()
    {
        parent::__construct();

        $this->auth->restrict('Site.BackEnd.Login');
        if(!defined('MODULE_URL'))
        define('MODULE_URL',SITE_AREA.'/'.$this->router->fetch_class().'/'.$this->router->fetch_module());

        // load the application lang file here so that the users language is known
        $this->lang->load('application');
        $this->load->library('template');
        $this->load->library('assets');
        $this->load->library('contexts');
        $this->load->library(array('ckeditor'));

        $this->ckeditor->basePath = site_url('assets/ckeditor').'/';
        // Pagination config
        $this->pager = array();
        $this->pager['full_tag_open']	= '<div class="tPages"><ul class="pages">';
        $this->pager['full_tag_close']	= '</ul></div>';
        $this->pager['next_link'] 		= '<span class="icon-arrow-17"></span>';
        $this->pager['prev_link'] 		= '<span class="icon-arrow-14"></span>';
        $this->pager['next_tag_open']	= '<li class="next">';
        $this->pager['next_tag_close']	= '</li>';
        $this->pager['prev_tag_open']	= '<li class="prev">';
        $this->pager['prev_tag_close']	= '</li>';
        $this->pager['first_tag_open']	= '<li>';
        $this->pager['first_tag_close']	= '</li>';
        $this->pager['last_tag_open']	= '<li>';
        $this->pager['last_tag_close']	= '</li>';
        $this->pager['cur_tag_open']	= '<li><a href="#" class="active">';
        $this->pager['cur_tag_close']	= '</a></li>';
        $this->pager['num_tag_open']	= '<li>';
        $this->pager['num_tag_close']	= '</li>';
        //setup ajax paging
        if($this->input->is_ajax_request()) {
            // setup config data table
            $this->kTable['where'] = array();
            $this->kTable['sEcho'] = intval($this->input->get('sEcho'));
            $key = $this->input->get('sSearch');
            $order_icol = $this->input->get('iSortingCols');
            for($i=0; $i<intval($this->input->get('iColumns')); $i++) {
                if(strpos($this->input->get('mDataProp_'.$i),"__NO__SELECT__")===false) {
                    $column = str_replace(array("__K__","__X__"),array("."," as "),$this->input->get('mDataProp_'.$i));

                    $this->kTable['columns'][] = $column;
                    if(!strpos($this->input->get('mDataProp_'.$i),"__X__"))
                        $this->kTable['where'][] = array($column=>$key);
                    else {
                        $column = preg_replace("/__X__(.+)+$/", "",$this->input->get('mDataProp_'.$i));
                        $column = str_replace("__K__",".",$column);
                        $this->kTable['where'][] = array($column=>$key);
                    }
                }
            }
            if(isset($_GET['iSortCol_0'])) {
                $i = $_GET['iSortCol_0'];
                if(strpos($this->input->get('mDataProp_'.$i),"__NO__SELECT__")!==false) {
                    $_GET['mDataProp_'.$i] = str_replace("__NO__SELECT__","",$this->input->get('mDataProp_'.$i));
                }
                if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_0']) ] == "true" )
                {
                    $this->kTable['order_by'] = $_GET['mDataProp_'.$i];
                    if(preg_match("#(.*) as (.*)#",$this->kTable['order_by'],$result)) {
                        $this->kTable['order_by'] = $result[1];
                    }
                    $this->kTable['sort_by'] = $_GET['sSortDir_0']==='asc' ? 'asc' : 'desc';
                }
            }


            $this->kTable['offset'] = intval($this->input->get('iDisplayStart'));
            $this->kTable['limit'] = intval($this->input->get('iDisplayLength'));
        } // end config ajax data table
        // Basic setup
        Template::set('userProfile',$this->auth->userProfile());
        Template::set_theme($this->config->item('template.admin_theme'), 'junk');
    }//end construct()

    //--------------------------------------------------------------------

}

/* End of file Admin_Controller.php */
/* Location: ./application/core/Admin_Controller.php */