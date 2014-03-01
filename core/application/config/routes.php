<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$route['default_controller'] = "home";
$route['404_override'] = '';

/**** MODULE USERS ******/
Route::any(CUSTOMER_PATH.LOGIN_URL,'users/login');
Route::any(CUSTOMER_PATH.REGISTER_URL,'users/register');
Route::any(CUSTOMER_PATH.'logout','users/logout');
Route::any(CUSTOMER_PATH.'forgot_password', 'users/forgot_password');
Route::any(CUSTOMER_PATH.'reset_password/(:any)/(:any)', 'users/reset_password/$1/$2');


//uploader
Route::any(CUSTOMER_PATH.'uploader', 'system/uploader');

// Authentication
Route::block('users/login');
Route::block('users/register');
Route::block('users/logout');
Route::block('users/forgot_password');
Route::block('users/reset_password');

// Activation
Route::any('activate', 'users/activate');
Route::any('activate/(:any)', 'users/activate/$1');
Route::any('resend_activation', 'users/resend_activation');


// Contexts
Route::prefix(CUSTOMER_PATH.SITE_AREA, function(){
    Route::context('content', array('home' => SITE_AREA .'/content/index'));
    Route::context('reports', array('home' => SITE_AREA .'/reports/index'));
    Route::context('developer');
    Route::context('settings');
});

// API
Route::prefix(API_AREA, function(){
    Route::context('v1');
});

$route[CUSTOMER_PATH.SITE_AREA]	= 'admin/home';

$route = Route::map($route);

/* End of file routes.php */
/* Location: ./application/config/routes.php */