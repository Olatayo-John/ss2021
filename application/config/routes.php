<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
$route['default_controller'] = 'user';

$route['/'] = 'user/index';
$route['login'] = 'user/login';
$route['register'] = 'user/register';
$route['name-exist'] = 'user/username_exist';
$route['support'] = 'user/support';
$route['logout'] = 'user/logout';


$route['profile'] = 'user/edit';
$route['rating'] = 'user/rating';
$route['account'] = 'user/account';
$route['quota'] = 'user/account';
$route['get-link'] = 'user/get_link';

$route['sms-import'] = 'user/sms_importcsv';
$route['send-multiple-sms'] = 'user/multiple_sms_send_link';

$route['email-import'] = 'user/importcsv';
$route['send-multiple-email'] = 'user/send_multiple_link';

$route['rate/(:any)'] = 'user/rate/$1';
$route['generate-otp'] = 'user/gen_otp';
$route['save'] = 'user/save';

$route['bar-data'] = 'user/bar_data';


$route['users'] = 'admin/users';
$route['admin/users/(:any)'] = 'admin/users/$1';
$route['get-user'] = 'admin/get_user';
$route['update-user'] = 'admin/update_user';
$route['delete-user'] = 'admin/delete_user';
$route['add-user'] = 'admin/add_user';

$route['votes'] = 'admin/votes';
$route['get-user-votes'] = 'admin/votes_get_user';
$route['admin/votes/(:any)'] = 'admin/votes/$1';
$route['pick-plan'] = 'admin/pick_plan';


$route['download-swachhta-app'] = 'user/downloadApp';


$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
