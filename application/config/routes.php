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
  |	http://codeigniter.com/user_guide/general/routing.html
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
$route['default_controller'] = 'welcome';

$route['ajax'] = 'AjaxController';
$route['ajax/(:any)'] = 'AjaxController/$1';

$route['admin/driver'] = 'DriverController';
$route['admin/driver/(:any)'] = 'DriverController/$1';
$route['admin/driver/update/(:any)'] = 'DriverController/update/$1';
$route['admin/driver/view/(:any)'] = 'DriverController/view/$1';
$route['admin/driver/delete/(:any)'] = 'DriverController/delete/$1';

$route['admin/customer'] = 'CustomerController';
$route['admin/customer/(:any)'] = 'CustomerController/$1';
$route['admin/customer/update/(:any)'] = 'CustomerController/update/$1';
$route['admin/customer/view/(:any)'] = 'CustomerController/view/$1';
$route['admin/customer/delete/(:any)'] = 'CustomerController/delete/$1';

$route['admin/vehicle'] = 'VehicleController';
$route['admin/vehicle/(:any)'] = 'VehicleController/$1';
$route['admin/vehicle/lists/(:any)'] = 'VehicleController/lists/$1';
$route['admin/vehicle/update/(:any)'] = 'VehicleController/update/$1';
$route['admin/vehicle/view/(:any)'] = 'VehicleController/view/$1';
$route['admin/vehicle/delete/(:any)'] = 'VehicleController/delete/$1';

$route['admin/agency'] = 'AgencyController';
$route['admin/agency/(:any)'] = 'AgencyController/$1';
$route['admin/agency/update/(:any)'] = 'AgencyController/update/$1';
$route['admin/agency/view/(:any)'] = 'AgencyController/view/$1';
$route['admin/agency/delete/(:any)'] = 'AgencyController/delete/$1';

$route['admin/discount'] = 'DiscountController';
$route['admin/discount/(:any)'] = 'DiscountController/$1';
$route['admin/discount/update/(:any)'] = 'DiscountController/update/$1';
$route['admin/discount/view/(:any)'] = 'DiscountController/view/$1';
$route['admin/discount/delete/(:any)'] = 'DiscountController/delete/$1';

$route['admin/labour'] = 'LabourController';
$route['admin/labour/(:any)'] = 'LabourController/$1';
$route['admin/labour/update/(:any)'] = 'LabourController/update/$1';
$route['admin/labour/view/(:any)'] = 'LabourController/view/$1';
$route['admin/labour/delete/(:any)'] = 'LabourController/delete/$1';

$route['admin/define'] = 'DefinationController';
$route['admin/define/(:any)'] = 'DefinationController/$1';
$route['admin/define/(:any)/(:any)'] = 'DefinationController/$1/$2';

$route['admin/order'] = 'OrderController';
$route['admin/order/(:any)'] = 'OrderController/$1';
$route['admin/order/(:any)/(:any)'] = 'OrderController/$1/$2';

//$route['admin'] = 'LoginController';
$route['admin/login'] = 'LoginController';
$route['admin/login/logout'] = 'LoginController/logout';
$route['admin/login/(:any)'] = 'LoginController/$1';

$route['admin'] = 'DashboardController';
$route['admin/dashboard'] = 'DashboardController';
$route['admin/dashboard/(:any)'] = 'DashboardController/$1';
$route['admin/dashboard/(:any)/(:any)'] = 'DashboardController/$1/$2';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
