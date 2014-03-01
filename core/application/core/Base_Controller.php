<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2013, Bonfire Dev Team
 * @license   http://guides.cibonfire.com/license.html
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Base Controller
 *
 * This controller provides a controller that your controllers can extend
 * from. This allows any tasks that need to be performed sitewide to be
 * done in one place.
 *
 * Since it extends from MX_Controller, any controller in the system
 * can be used in the HMVC style, using modules::run(). See the docs
 * at: https://bitbucket.org/wiredesignz/codeigniter-modular-extensions-hmvc/wiki/Home
 * for more detail on the HMVC code used in Bonfire.
 *
 * @package    Bonfire\Core\Controllers
 * @category   Controllers
 * @author     Bonfire Dev Team
 * @link       http://guides.cibonfire.com/helpers/file_helpers.html
 *
 */
class Base_Controller extends CI_Controller
{


	/**
	 * Stores the previously viewed page's complete URL.
	 *
	 * @var string
	 */
	protected $previous_page;

	/**
	 * Stores the page requested. This will sometimes be
	 * different than the previous page if a redirect happened
	 * in the controller.
	 *
	 * @var string
	 */
	protected $requested_page;

	/**
	 * Stores the current user's details, if they've logged in.
	 *
	 * @var object
	 */
	protected $current_user = NULL;
	//--------------------------------------------------------------------

	/**
	 * Class constructor
	 *
	 */
	public function __construct()
	{
		parent::__construct();

        $this->lang->load('general');
        $this->load->model('users/customer_model','customer_model');
		$this->load->library('system/settings_lib');
        $this->load->library('auth');
        if(!$this->customer_model->isUser()) {
            Template::set_message(lang('URL Not Found'),'warning');
            Template::redirect(WEB_SERVICE);
        }

		// Make sure no assets in up as a requested page or a 404 page.
		if ( ! preg_match('/\.(gif|jpg|jpeg|png|css|js|ico|shtml)$/i', $this->uri->uri_string()))
		{
			$this->previous_page = $this->session->userdata('previous_page');
			$this->requested_page = $this->session->userdata('requested_page');
		}

	}//end __construct()

	//--------------------------------------------------------------------

}//end Base_Controller


/* End of file Base_Controller.php */
/* Location: ./application/core/Base_Controller.php */
