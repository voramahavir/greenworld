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
$route['default_controller'] = 'Welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['dashboard'] = 'Welcome';
$route['login'] = 'LoginController';
$route['login/(:any)'] = 'LoginController/$1';
$route['users'] = 'UserController';
$route['users/(:any)'] = 'UserController/$1';
$route['users/(:any)/(:any)'] = 'UserController/$1/$2';
$route['plant'] = 'PlantController';
$route['plant/(:any)'] = 'PlantController/$1';
$route['plant/(:any)/(:any)'] = 'PlantController/$1/$2';
$route['familygroup'] = 'GroupController';
$route['familygroup/(:any)'] = 'GroupController/$1';
$route['familygroup/(:any)/(:any)'] = 'GroupController/$1/$2';
$route['posts'] = 'PostController';
$route['posts/(:any)'] = 'PostController/$1';
$route['posts/(:any)/(:any)'] = 'PostController/$1/$2';
$route['nursery'] = 'NurseryController';
$route['nursery/(:any)'] = 'NurseryController/$1';
$route['nursery/(:any)/(:any)'] = 'NurseryController/$1/$2';
$route['plant_category'] = 'PlantCategoryController';
$route['plant_category/(:any)'] = 'PlantCategoryController/$1';
$route['plant_category/(:any)/(:any)'] = 'PlantCategoryController/$1/$2';
$route['articles'] = 'ArticlesController';
$route['articles/(:any)'] = 'ArticlesController/$1';
$route['articles/(:any)/(:any)'] = 'ArticlesController/$1/$2';
$route['bills'] = 'BillsController';
$route['bills/(:any)'] = 'BillsController/$1';
$route['bills/(:any)/(:any)'] = 'BillsController/$1/$2';
$route['codes'] = 'CodeController';
$route['codes/(:any)'] = 'CodeController/$1';
$route['codes/(:any)/(:any)'] = 'CodeController/$1/$2';
$route['forgotPassword'] = 'ForgotPasswordController';
$route['forgotPassword/(:any)'] = 'ForgotPasswordController/$1';
$route['forgotPassword/(:any)/(:any)'] = 'ForgotPasswordController/$1/$2';
$route['plantbanners'] = 'PlantBannerController';
$route['plantbanners/(:any)'] = 'PlantBannerController/$1';
$route['plantbanners/(:any)/(:any)'] = 'PlantBannerController/$1/$2';
$route['nurserybanners'] = 'NurseryBannerController';
$route['nurserybanners/(:any)'] = 'NurseryBannerController/$1';
$route['nurserybanners/(:any)/(:any)'] = 'NurseryBannerController/$1/$2';