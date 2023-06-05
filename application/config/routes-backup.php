<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = 'Errors/error404';
$route['translate_uri_dashes'] = FALSE;

$route['login'] = 'AuthController';
$route['register'] = 'AuthController/cek_nib';
$route['action-cek-nib'] = 'AuthController/action_cek_nib';
$route['register/(:any)'] = 'AuthController/register/$1';
$route['forgot-password'] = 'AuthController/forgot_password';
$route['action-forgot-password'] = 'AuthController/action_forgot_password';
$route['forgot-password-sendmail'] = 'AuthController/forgot_password_sendmail';
$route['reset-password/(:any)'] = 'AuthController/reset_password/$1';
$route['action-reset-password/(:any)'] = 'AuthController/action_reset_password/$1';
$route['authentication'] = 'AuthController/doLogin';
$route['action-register/(:any)'] = 'AuthController/doRegister/$1';
$route['logout'] = 'AuthController/doLogout';
$route['load-kab-kota'] = 'AuthController/load_kab_kota';

$route['account'] = 'AccountController/account';
$route['account/save-profile'] = 'AccountController/save_profil';
$route['account/ubah-password'] = 'AccountController/ubah_password';
$route['account/upload-picture'] = 'AccountController/upload_picture';
$route['account/hapus-profile/(:any)'] = 'AccountController/hapus_profile/$1';

$route['backend/user'] = 'backend/UserController/index';
$route['user'] = 'backend/UserController/index';
$route['user/add'] = 'backend/UserController/add';
$route['user/save'] = 'backend/UserController/save';
$route['user/edit/(:any)'] = 'backend/UserController/get/$1';
$route['user/update/(:any)'] = 'backend/UserController/update/$1';
$route['user/ubah-password/(:any)'] = 'backend/UserController/get_data/$1';
$route['user/change-password/(:any)'] = 'backend/UserController/change_password/$1';
$route['user/delete/(:any)'] = 'backend/UserController/delete/$1';

$route['backend/403'] = 'Errors/error403';

$route['backend/irtp/(:any)'] = 'backend/Irtp/index/$1';

$route['loadTestimoni'] = 'General/loadTestimoni';
$route['loadBerita'] = 'General/loadBerita';
$route['loadData/(:any)'] = 'General/loadAccordion/$1';
$route['loadFaq'] = 'General/loadFaq';

$route['regulasi'] = 'Home/regulasi';
$route['panduan'] = 'Home/panduan';
$route['kontak'] = 'Home/kontak';
$route['berita'] = 'Home/berita';
$route['galeri'] = 'Home/galeri';
$route['faq'] = 'Home/faq';