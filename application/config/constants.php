<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  |--------------------------------------------------------------------------
  | File and Directory Modes
  |--------------------------------------------------------------------------
  |
  | These prefs are used when checking and setting modes when working
  | with the file system.  The defaults are fine on servers with proper
  | security, but you may wish (or even need) to change the values in
  | certain environments (Apache running a separate process for each
  | user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
  | always be used to set the mode correctly.
  |
 */
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
  |--------------------------------------------------------------------------
  | File Stream Modes
  |--------------------------------------------------------------------------
  |
  | These modes are used when working with fopen()/popen()
  |
 */

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
  |--------------------------------------------------------------------------
  | Display Debug backtrace
  |--------------------------------------------------------------------------
  |
  | If set to TRUE, a backtrace will be displayed along with php errors. If
  | error_reporting is disabled, the backtrace will not display, regardless
  | of this setting
  |
 */
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
  |--------------------------------------------------------------------------
  | Exit Status Codes
  |--------------------------------------------------------------------------
  |
  | Used to indicate the conditions under which the script is exit()ing.
  | While there is no universal standard for error codes, there are some
  | broad conventions.  Three such conventions are mentioned below, for
  | those who wish to make use of them.  The CodeIgniter defaults were
  | chosen for the least overlap with these conventions, while still
  | leaving room for others to be defined in future versions and user
  | applications.
  |
  | The three main conventions used for determining exit status codes
  | are as follows:
  |
  |    Standard C/C++ Library (stdlibc):
  |       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
  |       (This link also contains other GNU-specific conventions)
  |    BSD sysexits.h:
  |       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
  |    Bash scripting:
  |       http://tldp.org/LDP/abs/html/exitcodes.html
  |
 */
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

//API KEYS
define('GOOGLE_MAP_API_KEY', 'AIzaSyAvaLYGrOcMUWs49h7czjAp96U6qI33hlU'); 
define('GOOGLE_API_KEY', 'AIzaSyACjdpaolaUHA-rjK_YEvP8UdQi9Z3YIwk'); 

//The Booking Status definations 
define("BOOKING_RAISED", 1);
define("BOOKING_ASSIGNED", 2);
define("BOOKING_UNASSIGNED", 3);
define("BOOKING_CONFIRMED", 4);
define("BOOKING_STARTED", 5);
define("BOOKING_COMPLETED", 6);
define("BOOKING_PAID", 7);
define("BOOKING_FINISHED", 8);
define("BOOKING_CANCELLED", 9);

//Payment_modes
define("PAYMENT_MODE_CASH", 1);
define("PAYMENT_MODE_PAYTM", 2);
define("PAYMENT_MODE_OTHERS", 2);



//The Order Status definations 
define("ORDER_RAISED", 1);
define("ORDER_CONFIRMED", 2);
define("ORDER_GOINGTO", 3);
define("ORDER_ARRIVED", 4);
define("ORDER_STARTED", 5);
define("ORDER_REACHED", 6);
define("ORDER_DELIVERED", 7);
define("ORDER_PAID", 8);
define("ORDER_FINISHED", 9);
define("ORDER_CANCELLED", 10);

//Table constants
define('TBL_PASSENGER', 'end_user');
define('TBL_DRIVER', 'drivers');
define('TBL_VEHICALS', 'vehicles');
define('TBL_DRIVER_VEHICALS', 'driver_vehicals');
define('TBL_BOOKING', 'booking');
define('TBL_ORDERS', 'orders');
define('TBL_ORDERS_TRACKING', 'orders_tracking');
define('TBL_DRIVER_RATING', 'driver_rating');
define('TBL_VEHICLE_RATING', 'vehicle_rating');
define('TBL_PAYMENTS', 'payments');
define('TBL_FEVORITE_LOCATION', 'fevorite_location');
define('TBL_USERS', 'users');
define('TBL_METAS', 'metadata');
define('TBL_TONNAGE_MASTER', 'master_tonnage');
define('TBL_SPECIAL_TYPE_MASTER', 'master_special_types');
define('TBL_TIMEFRAME_MASTER', 'master_timeframe');
define('TBL_AGENCIES', 'agencies');
define('TBL_DISCOUNT', 'discount_coupons');
define('TBL_LABOUR', 'labours');
define('TBL_MASTER_COUNTRY', 'master_country');
define('TBL_MASTER_STATE', 'master_state');
define('TBL_MASTER_CITY', 'master_city');
define('TBL_RATE_CARD', 'ratecard');
define('TBL_FAQ', 'faq');
define('TBL_INVITE', 'invite');
define('TBL_SESSION', 'session');
define('TBL_ACCESS_TOKEN', 'access_token');
define('TBL_DRIVER_PAYMENT', 'driver_payment');
define('TBL_PAYMENT_RECORD', 'payment_record');
define('TBL_ASSIGNED_DRIVERS', 'assign_to_driver');
define('TBL_ASSIGNED_AGENCY', 'assign_to_agency');



define('UPLOAD_PATH', '/uploads/');
