<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Keith.
 * Email: coder.notepad@gmail.com
 * Date: 12/20/13
 * Time: 2:36 PM
 */
class Users extends Front_Controller
{

	//--------------------------------------------------------------------

	public function __construct()
	{
		parent::__construct();
		$this->load->model('users/users_model');
		$this->load->library('users/auth');
        $this->lang->load('user');
        $this->load->helper('form');
        $this->load->library('form_validation');

	}//end __construct()

	//--------------------------------------------------------------------

	public function login()
	{
		// if the user is not logged in continue to show the login page
        if ($this->input->post()) {
            $remember = $this->input->post('remember_me') == '1' ? TRUE : FALSE;
            // Try to login
            if ($this->auth->login($this->input->post('login'), $this->input->post('password'), $remember) === TRUE)
            {
                $this->load->model('roles/role_model');

                $user_role = $this->role_model->find($this->auth->role_id());
                Template::redirect(SITE_AREA.'/content');
            }//end if
        }//end if
        else {
            $this->auth->logout();
        }
        Template::set('page_title', 'Login');
        Template::set_theme('admin');
        Template::render('login');

	}//end login()
    public function forgot_password()
    {

        // if the user is not logged in continue to show the login page
        if ($this->auth->is_logged_in() === FALSE)
        {
            if (isset($_POST))
            {
                $this->form_validation->set_rules('email', 'lang:bf_email', 'required|trim|strip_tags|valid_email|xss_clean');

                if ($this->form_validation->run() === FALSE)
                {
                    echo "Invalid Email";
                }
                else
                {
                    $user = $this->db->where('email',$this->input->post('email'))->get('users')->row();
                    if(empty($user)) {
                       exit('Invalid Email');
                    }
                    $this->load->helpers(array('string', 'security'));
                    $pass_code = random_string('alnum', 30);
                    $hash = do_hash($user->email.$user->last_login);
                    $this->users_model->update_where('email',  $user->email, array('reset_hash' => $hash, 'reset_by' => strtotime("+24 hours") ));
                    $pass_link = site_url('reset_password/'. str_replace('@', ':', $user->email) .'/'. $hash);

                    $this->load->library('emailer/emailer');
                    $config['to'] = $user->email;
                    $config['subject']   =  settings_item('site.title').' login details';
                    $config['message'] = $this->load->view('email/forgot_password',array('user'=>$user,'link'=>$pass_link),true);

                    if ($this->emailer->send($config))
                    {
                        echo lang('us_reset_pass_message');
                    }
                    else
                    {
                        echo lang('us_reset_pass_error');
                    }
                }//end if
            }//end if
        }//end if

    }//end forgot_password()


    public function reset_password($email='', $code='')
    {
        // if the user is not logged in continue to show the login page
        if ($this->auth->is_logged_in() === FALSE)
        {
            // If there is no code, then it's not a valid request.
            if (empty($code) || empty($email))
            {
                Template::set_message(lang('us_reset_invalid_email'), 'error');
                Template::redirect('/login');
            }

            // Handle the form
            if ($this->input->post('submit'))
            {
                $this->form_validation->set_rules('password', 'lang:bf_password', 'required|trim|strip_tags|min_length[8]|max_length[120]|valid_password');
                $this->form_validation->set_rules('pass_confirm', 'lang:bf_password_confirm', 'required|trim|strip_tags|matches[password]');

                if ($this->form_validation->run() !== FALSE)
                {
                    // The user model will create the password hash for us.
                    $data = array('password' => $this->input->post('password'),
                        'pass_confirm'	=> $this->input->post('pass_confirm'),
                        'reset_by'		=> 0,
                        'reset_hash'	=> '');
                    $user = $this->users_model->find_by(array(
                        'email' => str_replace(':', '@', $email),
                        'reset_hash' => $code,
                    ));
                    if ($this->users_model->save($user->id, $data))
                    {
                        // Log the Activity

                        Template::set_message(lang('us_reset_password_success'), 'success');
                        Template::redirect('/login');
                    }
                    else
                    {
                        Template::set_message(lang('us_reset_password_error'). $this->users_model->error, 'error');

                    }
                }
            }//end if

            // Check the code against the database
            $email = str_replace(':', '@', $email);
            $user = $this->users_model->find_by(array(
                'email' => $email,
                'reset_hash' => $code,
                'reset_by >=' => time()
            ));

            // It will be an Object if a single result was returned.
            /*
            if (!is_object($user))
            {
                Template::set_message( lang('us_reset_invalid_email'), 'error');
                Template::redirect('/login');
            }
*/
            Template::set('user', $user);
            Template::set_theme('admin');
            Template::render('reset_password');
        }
        else
        {

            Template::redirect('/');
        }//end if

    }//end reset_password()

	//--------------------------------------------------------------------

	/**
	 * Calls the auth->logout method to destroy the session and cleanup,
	 * then redirects to the home page.
	 *
	 * @access public
	 *
	 * @return void
	 */
	public function logout()
	{
		// Always clear browser data (don't silently ignore user requests :).
		$this->auth->logout();

		Template::redirect();

	}//end  logout()

	//--------------------------------------------------------------------



}//end Users

/* Front-end Users Controller */
/* End of file users.php */
