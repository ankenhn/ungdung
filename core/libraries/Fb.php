<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author: Keith.
 * Email: coder.notepad@gmail.com
 * Date: 2/12/14
 * Time: 11:30 PM
 */
require_once "facebook.php";

class Fb {
    private $appID = null;
    private $appSecret = null;
    private $ci;
    private $facebook;
    private $debug = false;

    function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->config('facebook');
        $this->appID = $this->ci->config->item('app_id');
        $this->appSecret = $this->ci->config->item('app_secret');
        $this->facebook = new Facebook(array(
            'appId' => $this->appID,
            'secret' => $this->appSecret,
        ));

        $this->_getSignedRequest();
    }


    function login($redirect_uri=false) {
        $user = $this->facebook->getUser();
        if($user) {
            return true;
        } else {
            if($redirect_uri===false) {
                $redirect_uri = $this->ci->config->item('app_url');
                if($this->ci->config->item('app_type')=='page_tab') {
                    $redirect_uri .= '?sk=app_'.$this->appID;

                    //add app_data to url
                    $signedRequest = $this->getSignedRequest();
                    if(isset($signedRequest['app_data'])) {
                        $redirect_uri .= '&app_data='.$signedRequest['app_data'];
                    }
                }
            }

            $login = $this->getLoginUrl(array(
                'scope' =>  'publish_actions',
                'redirect_uri'  =>  $redirect_uri
            ));
            if(!$this->ci->input->is_ajax_request())
                exit("<script type='text/javascript'>top.window.location.href='{$login}'</script>");
            else {
                exit($login);
            }
        }
    }

    function getLoginUrl($param = array()) {
        return $this->facebook->getLoginUrl($param);
    }


    function api($url,$method='GET',$param=array()) {
        try {
            return $this->facebook->api($url,$method,$param);
        } catch(FacebookApiException $e) {
            if($this->debug===false) {
                error_log($e->getType());
                error_log($e->getMessage());
                $this->login();
            } else {
                $dataError = '<p><strong>Fatal Error:</strong> '.$e->getType().'</p>';
                $dataError .= '<p><strong>Message:</strong> '.$e->getMessage().'</p>';
                $dataError .= '<p><strong>URL:</strong> '.$url.'</p>';
                $dataError .= '<p><strong>Method:</strong> '.$method.'</p>';
                $dataError .= '<p><strong>Param:</strong> <pre>'.print_r($param).'</pre></p>';
                exit($dataError);
            }
        }
    }


    /**
     * @param array $data = array(
     *                      'message' => 'I\'ve been testing my IQ!',
     *                      'name' => 'IC-YOUR-IQ',
     *                      'caption' => 'This is my result:',
     *                      'link' => 'http://apps.facebook.com/icyouriq/',
     *                      'actions' => array('name'=>'Sweet FA','link'=>'http://www.facebookanswers.co.uk'),
     *                      'description' => 'description',
     *                      'picture' => 'url'
     *                  );
     *
     * @param string $user
     * @return mixed
     */

    function postToFeed($data=array(),$user='me') {
        return $this->api($user.'/feed','POST', $data);
    }

    /**
     * @param array $data = array(
     *                   'message' => 'I\'ve been testing my IQ!',
     *                   'url' => 'https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQHtjMtz3ZNpuRdTfOgIkEnVDtJEMKssqKSahvMShiWuKJVoR_6',
     *                   'place' =>'352409648123214'
     *               );
     * @param string $user
     * @return mixed
     */

    function postPhotoToFeed($data=array(),$user='me') {
        return $this->api($user.'/photos','POST', $data);
    }

    function getSignedRequest() {
        return $this->ci->session->userdata('signedRequest');
    }

    function liked() {
        $signedRequest = $this->getSignedRequest();
        if(isset($signedRequest['page']['liked'])) {
            return $signedRequest['page']['liked'];
        }
    }

    function _getSignedRequest() {
        $signedRequest = $this->ci->session->userdata('signedRequest');
        if(!$signedRequest OR $this->ci->input->post()) {
            $signed = $this->facebook->getSignedRequest();
            if(isset($signed['page']['id'])) {
                $this->ci->session->set_userdata('signedRequest',$signed);
            }
        }
    }

}