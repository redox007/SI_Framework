<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Web_api
 *
 * @author Suchandan
 * @property CI_Lang $lang CI_Lang
 * @property Model_passenger $Model_passenger Model_passenger
 * @property Model_driver $Model_driver Model_driver
 * @property Model_common $Model_common Model_common
 * @property Model_vehical $Model_vehical Model_vehical
 * @property Model_booking $Model_booking Model_booking
 * @property Model_payment $Model_payment Model_payment
 * @property Model_order $Model_order Model_order
 * @property App_session $App_session App_session
 */
class Web_api extends MY_Controller {

    public $request_data;

    public function __construct() {
        parent::__construct();
        $this->loadS_model('common');
        $this->load->language('api');
        $this->load->library('App_session');
    }

    public function get_session_token() {
        $user_type = $this->request('user_type', true);
        $user_id = $this->request('user_id', true);
        $session_token = $this->request('session_token', true);
    }

    /*
     * Passenger Module start
     */

    public function passenger_login() {

        $user_id = $this->request('user_id', true);
        $password = md5($this->request('password', true));

        $device_id = $this->request('device_id');
        $push_id = $this->request('push_id');
        $os_type = $this->request('os_type');

        $this->loadS_model('passenger');

        $user = $this->Model_passenger->login($user_id, $password);

        if (!$user) {
            $this->_die($this->lang->line('invalid_user'));
        }
        unset($user['password']);

        $this->Model_passenger->update(compact('device_id', 'push_id', 'os_type'), $user['id']);
        $this->setSuccess("success");
        $this->setData('passenger', $user);
        $this->response();
    }

    public function register_passenger() {

        $data['full_name'] = $this->request('full_name');
        $data['email_id'] = $this->request('email_id');
        $data['phone_no'] = $this->request('phone_no', true);
        $data['password'] = md5($this->request('password', true));
        $data['reffer_code'] = $this->request('reffer_code');
        $data['created_on'] = date('Y-m-d H:i:s');

        $this->loadS_model('passenger');

        $passenger_id = $this->Model_passenger->register($data);

        if (!$passenger_id) {
            $this->_die("The user is already exists.");
        }

        $this->setSuccess($this->lang->line('user_registered'));
        $this->setData('passenger_id', $passenger_id);
        $this->response();
    }

    public function update_passenger() {

        $passenger_id = $this->request('passenger_id', true);

        $this->loadS_model('passenger');

        $data['full_name'] = $this->request('full_name');
        $data['email_id'] = $this->request('email_id');
        $data['phone_no'] = $this->request('phone_no');
        $data['modified_on'] = date('Y-m-d H:i:s');

        if (!$this->Model_passenger->get_passenger($passenger_id)) {
            $this->_die("The passenger does not exists.");
        }

        $this->Model_passenger->update($data, $passenger_id);

        $this->setSuccess($this->lang->line('user_updated'));
        $this->response();
    }

    public function passenger() {
        $passenger_id = $this->request('passenger_id', true);

        $this->loadS_model('passenger');

        if (( $passenger = $this->Model_passenger->get_passenger($passenger_id) ) === false) {
            $this->_die("The passenger does not exists.");
        }
        unset($passenger['password']);
        $this->setSuccess();
        $this->setData('details', $passenger);
        $this->response();
    }

    public function request_password_reset_passenger() {

        $email_id = $this->request('email_id', true);

        $this->loadS_model('passenger');

        $passenger = $this->Model_passenger->get_passenger($email_id);
        if (!$passenger) {
            $this->_die("The passenger does not exists.");
        }
        $random_token = random_token(5);
        $this->Model_passenger->update(array('token' => $random_token), $passenger['id']);

        $this->setSuccess("Request has been registered.");
        $this->setData('token', $random_token);
        $this->response();
    }

    public function reset_password_passenger() {

//        $id = $this->request('id', true);
        $token = $this->request('token', true);

        $data['password'] = md5($this->request('password', true));

        $this->loadS_model('passenger');

        $p = $this->Model_passenger->get_passenger(array('token' => $token));

        if (!$p) {
            $this->_die("Un authinticated reset request.");
        }
        $id = $p['id'];
        $data['token'] = '';
        $this->Model_passenger->update($data, $id);

        $this->setSuccess("The password successfully updated.");
        $this->response();
    }

    public function set_fevorite() {

        $data['passenger_id'] = $this->request('passenger_id', true);
        $data['latitude'] = $this->request('latitude', true);
        $data['longitude'] = $this->request('longitude', true);
        $data['city'] = $this->request('city');
        $data['country'] = $this->request('country');
        $data['pin_code'] = $this->request('pin_code', true);
        $data['address'] = $this->request('address', true);
        $data['datetime'] = date('y-m-d H:i:s');

        $this->loadS_model('passenger');

        $location_id = $this->Model_passenger->add_fevorite($data);

        $this->setData('location_id', $location_id);
        $this->set_success_responce("The location hasbeen added as fevorite.");
    }

    public function unset_fevorite() {

        $data['passenger_id'] = $this->request('passenger_id', true);
        $data['id'] = $this->request('location_id', true);

        $this->loadS_model('passenger');

        $location_id = $this->Model_passenger->deleteRecord(TBL_FEVORITE_LOCATION, $data);

        $this->set_success_responce("The location has been unseted from fevorite.");
    }

    public function fevorite_locations() {
        $passenger_id = $this->request('passenger_id', true);
        $this->loadS_model('passenger');

        if (!$this->Model_passenger->get_passenger($passenger_id)) {
            $this->_die("The passenger does not exists.");
        }

        $list = $this->Model_passenger->get_fevo_locations($passenger_id);
        $this->setData('list', $list);
        $this->set_success_responce();
    }

    /*
     * Passenger Module end
     */

    /*
     * Driver Module start
     */

    public function driver_login() {

        $user_id = $this->request('user_id', true);
        $password = md5($this->request('password', true));

        $device_id = $this->request('device_id');
        $push_id = $this->request('push_id');
        $os_type = $this->request('os_type');

        $this->loadS_model('driver');

        $user = $this->Model_driver->login($user_id, $password);

        if (!$user) {
            $this->_die("Invalid user ID or password.");
        }
        unset($user['password']);

        $this->Model_driver->update(compact('device_id', 'push_id', 'os_type'), $user['id']);
        $this->setSuccess("success");

        $this->setData('driver', $user);
        $this->response();
    }

    public function register_driver() {

        $img_data = $this->upload_image('driver_image', '.' . UPLOAD_PATH . '/driver', 'DV');

        if ($img_data) {
            $this->resize_image($img_data['full_path'], 400, 250);
            $data['driver_image'] = UPLOAD_PATH . 'driver/' . $img_data['raw_name'] . '_thumb' . $img_data['file_ext'];
        }

        $data['first_name'] = $this->request('first_name', true);
        $data['middle_name'] = $this->request('middle_name');
        $data['last_name'] = $this->request('last_name', true);
        $data['email_id'] = $this->request('email_id');
        $data['phone_no'] = $this->request('phone_no', true);
        $data['password'] = md5($this->request('password', true));
        $data['dob'] = $this->request('dob', true);
        $data['experience'] = $this->request('experience');
        $data['city'] = $this->request('city');
        $data['address'] = $this->request('address');
        $data['religion'] = $this->request('religion');
        $data['license_no'] = $this->request('license_no', true);
        $data['license_type'] = $this->request('license_type', true);
        $data['adhar_card_no'] = $this->request('adhar_card_no');
        $data['bank_name'] = $this->request('bank_name');
        $data['bank_account_no'] = $this->request('bank_account_no');
        $data['bank_ifsc_code'] = $this->request('bank_ifsc_code');
        $data['reffer_code'] = $this->request('reffer_code');
        $data['created_on'] = date('Y-m-d H:i:s');

        $this->loadS_model('driver');

        $driver_id = $this->Model_driver->register($data);

        if (!$driver_id) {
            $this->_die("The user is already exists.");
        }

        $this->setSuccess("Driver is successfully registered.");
        $this->setData('driver_id', $driver_id);
        $this->response();
    }

    private function upload_image($file_key = 'file', $folder = '', $prefix = 'UP', $file_types = 'gif|jpg|png') {

        if (!isset($_FILES[$file_key])) {
            return false;
        }

        $config['upload_path'] = ($folder) ? $folder : '.' . UPLOAD_PATH;
        $config['allowed_types'] = $file_types;
        $config['file_name'] = $prefix . '-' . time();

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload($file_key)) {
            $error = array('error' => $this->upload->display_errors());
            $this->_die($error);
        } else {
            $data = $this->upload->data();
            return $data;
        }
    }

    private function resize_image($path, $width, $height, $ratio = TRUE, $create_thumb = TRUE) {
        $config['image_library'] = 'gd2';
        $config['source_image'] = $path;
//        $config['new_image'] = $new_path;
        $config['create_thumb'] = $create_thumb;
        $config['maintain_ratio'] = $ratio;
        $config['width'] = $width;
        $config['height'] = $height;

        $this->load->library('image_lib', $config);

        $this->image_lib->resize();
    }

    public function update_driver() {

        $driver_id = $this->request('driver_id', true);

        $data['full_name'] = $this->request('full_name');
        $data['email_id'] = $this->request('email_id');
        $data['phone_no'] = $this->request('phone_no');
        $data['is_active'] = $this->request('is_active');

        $this->loadS_model('driver');

        $old_pass = $this->request('old_pass');

        if ($old_pass) {
            $password = md5($new_pass);
            $new_pass = $this->request('new_pass', true);
            $this->loadS_model('driver');
            if (!$this->Model_driver->getData(TBL_DRIVER, array('id' => $driver_id, 'password' => md5($old_pass)))) {
                $this->_die('The passenger does not exists.');
            }
            $data['password'] = $password;
        }


        $data['modified_on'] = date('Y-m-d H:i:s');


        if (!$this->Model_driver->get_driver($driver_id)) {
            $this->_die("The driver does not exists.");
        }

        $this->Model_driver->update($data, $driver_id);

        $this->setSuccess("The driver successfuly updated.");
        $this->response();
    }

    public function driver() {
        $driver_id = $this->request('driver_id', true);

        $this->loadS_model('driver');

        if (( $driver = $this->Model_driver->get_driver($driver_id) ) === false) {
            $this->_die("The driver does not exists.");
        }
        unset($driver['password']);

        $this->setSuccess();

        $driver['due_payment'] = $this->Model_driver->get_driver_payment_details($driver_id);
        $this->setData('details', $driver);

        $this->response();
    }

    public function request_password_reset_driver() {

        $email_id = $this->request('email_id', true);

        $this->loadS_model('driver');

        $driver = $this->Model_driver->get_driver($email_id);
        if (!$driver) {
            $this->_die("The driver does not exists.");
        }
        $random_token = random_token(5);
        $this->Model_driver->update(array('token' => $random_token), $driver['id']);

        $this->setSuccess("Request has been registered.");
        $this->setData('token', $random_token);
        $this->response();
    }

    public function reset_password_driver() {

//        $id = $this->request('id');
        $token = $this->request('token', true);

        $data['password'] = md5($this->request('password', true));

        $this->loadS_model('driver');

        $p = $this->Model_driver->get_driver(array('token' => $token));

        if (!$p) {
            $this->_die("Un authinticated reset request.");
        }
        $id = $p['id'];
        $data['token'] = '';
        $this->Model_driver->update($data, $id);

        $this->setSuccess("The password successfully updated.");
        $this->response();
    }

    public function take_driver_rating() {

        $driver_id = request('driver_id', true);
        $passenger_id = request('passenger_id', true);
        $rating = request('driver_rating', true);
        $order_no = request('order_no', true);
        $booking_no = request('booking_no', true);
        $vehicle_id = request('vehicle_id', true);
        $vehicle_rating = request('vehicle_rating', true);

        $this->loadS_model('driver');
        $this->loadS_model('passenger');
        $this->loadS_model('booking');
        $this->loadS_model('vehical');

        if (!$this->Model_driver->get_driver($driver_id)) {
            $this->_die("The drive does not exists.");
        }
        if (!$this->Model_passenger->get_passenger($passenger_id)) {
            $this->_die("The passenger does not exists.");
        }
        if (!$this->Model_booking->get_booking_orders(array('booking_no' => $booking_no, 'id' => $order_no))) {
            $this->_die("The order does not exists.");
        }

        $this->Model_driver->rate_driver($driver_id, $passenger_id, $rating, $order_no, $booking_no);
        $this->Model_vehical->rate_vehicle($passenger_id, $vehicle_id, $order_no, $booking_no, $vehicle_rating);

        $this->Model_booking->update_order($order_no, array('order_status' => ORDER_FINISHED));

        $this->set_success_responce("Thanks for your feedback.");
    }

    public function update_driver_location() {

        $driver_id = $this->request('driver_id', true);

        $data['lattitude'] = $this->request('lattitude', true);
        $data['longitude'] = $this->request('longitude', true);

        $this->loadS_model('driver');

        if (!( $driver = $this->Model_driver->get_driver($driver_id) )) {
            $this->_die("The driver does not exists.");
        }

        $this->Model_driver->update($data, $driver_id);

        $this->set_success_responce("The location successfully updated.");
    }

    public function get_driver_position() {

        $this->loadS_model('driver');

        $this->setSuccess();
        $this->setData('list', $this->Model_driver->getDatas(TBL_DRIVER, array(), array('lattitude', 'longitude')));
        $this->response();
    }

    /*
     * Driver Module end
     */

    /*
     * Vehical Module start
     */

    public function register_veahical() {

        $data['name'] = $this->request('name');
        $data['model'] = $this->request('model');
        $data['registration_no'] = $this->request('registration_no', true);
        $data['capacity'] = $this->request('capacity', true);
        $data['type'] = $this->request('type', true);
        $data['created_on'] = date('Y-m-d H:i:s');

        $this->loadS_model('vehical');

        if (( $id = $this->Model_vehical->register($data)) === FALSE) {
            $this->_die("Another vehicle exists with this registration id.");
        }

        $this->setSuccess("Vehicle successfully registered.");
        $this->setData('vehical_id', $id);
        $this->response();
    }

    public function update_veahical() {

        $id = $this->request('vehical_id', true);

        $data['name'] = $this->request('name');
        $data['model'] = $this->request('model');
        $data['capacity'] = $this->request_cache('capacity');
        $data['type'] = $this->request_cache('type');
        $data['created_on'] = date('Y-m-d H:i:s');

        $this->loadS_model('vehical');

        if (!$this->Model_vehical->get_vehical($id)) {
            $this->_die("The vehicle does not exists.");
        }
        $this->Model_vehical->update($id, $data);

        $this->setSuccess("Vehicle successfully updated.");
        $this->response();
    }

    public function assign_veahical() {

        $data['vehical_id'] = $vehical_id = $this->request('vehical_id', true);
        $data['driver_id'] = $driver_id = $this->request('driver_id', true);
        $data['date_from'] = $this->request_default('date_from', date('Y-m-d'));
        $data['date_to'] = $this->request('date_to', true);

        if (!$this->Model_common->getData(TBL_DRIVER, array('id' => $driver_id))) {
            $this->_die("The driver does not exists.");
        }
        if (!$this->Model_common->getData(TBL_VEHICALS, array('id' => $vehical_id))) {
            $this->_die("The vehicle does not exists.");
        }

        $this->loadS_model('vehical');
        $id = $this->Model_vehical->assign($driver_id, $vehical_id);

        $this->setSuccess("Vehicle is successfully assigned.");
        $this->response();
    }

    /*
     * Vehical Module end
     */

    /*
     * Order module start
     */

    private function set_booking_data() {
        $this->request_data['booking'] = array();
        //Booking Details
        $this->request_data['booking']['passenger_id'] = $this->request('passenger_id', true);
        $this->request_data['booking']['booking_type'] = $this->request('booking_type', true);
        $this->request_data['booking']['booking_date'] = $this->request('booking_date', true);
        $this->request_data['booking']['booking_time'] = $this->request('booking_time');
        $this->request_data['booking']['pickup_type'] = $this->request('pickup_type', true);
        $this->request_data['booking']['flexible_timeslot'] = $this->request('flexible_timeslot');
        $this->request_data['booking']['no_of_helpers'] = $this->request('no_of_helpers');
        $this->request_data['booking']['estimated_cost'] = $this->request('estimated_cost');
        $this->request_data['booking']['estimated_distance'] = $this->request('estimated_distance', true);
        $this->request_data['booking']['booking_status'] = BOOKING_RAISED;
        $this->request_data['booking']['special_type'] = $this->request_default('special_type', 1);
        $this->request_data['booking']['capacity_type'] = $this->request_default('capacity_type', 1);
//        $this->request_data['booking']['no_of_order'] = $this->request('no_of_order');
        $this->request_data['booking']['comments'] = $this->request('comments');
        $this->request_data['booking']['city'] = $this->request_default('city', 1);
        $this->request_data['booking']['state'] = $this->request_default('state', 1);
        $this->request_data['booking']['pin'] = $this->request('pin', true);
        $this->request_data['booking']['created_on'] = date('Y-m-d H:i:s');
    }

    private function set_order_data() {

        $this->request_data['order'] = array();
        $date_array = array();
        //Order Details
        if ($this->request_data['booking']['booking_type'] == 2) {
            $this->request_data['booking']['booking_date'] = date('Y-m-d H:i:s');
            $date_json = $this->request('booking_date');
            $date_array = json_decode(stripcslashes($date_json));
        } else {
            $date_array[] = $this->request('booking_date');
        }
        if ($date_array) {
            foreach ($date_array as $date) {
                $order = array(
                    'pickup_address' => $this->request('pickup_address', true),
                    'requested_pickup_time' => $this->request('booking_time'),
                    'pickup_lat' => $this->request('pickup_lat', true),
                    'pickup_long' => $this->request('pickup_long', true),
                    'drop_address' => $this->request('drop_address', true),
                    'pin' => $this->request('pin', true),
                    'drop_lat' => $this->request('drop_lat', true),
                    'drop_long' => $this->request('drop_long', true),
                    'pickup_date' => make_date($date),
                    'is_flexible' => ($this->request_data['booking']['pickup_type'] == 2) ? 1 : 0,
                    'flexible_time_id' => $this->request('flexible_timeshot')
                );
                if ($order['is_flexible'] == 2) {
                    $order['flexible_time_id'] = $this->request('flexible_timeshot');
                }
                $this->request_data['order'][] = $order;
            }
            $this->request_data['booking']['no_of_order'] = count($this->request_data['order']);
        }
    }

    private function estimate_cost() {
        $estimate_costdata = array(
            'estimated_price' => 100,
            'labour_rate' => 20,
            'free_wating_time' => '1hr',
            'wating_time_cost' => 3
        );
        $this->setSuccess();
        $this->setData('estimate_data', $estimate_costdata);
        $this->_die();
    }

    public function book() {

        $this->set_booking_data();
        $this->set_order_data();

        if ($this->request('get_estimate')) {
            $this->estimate_cost();
        }

        $passenger_id = $this->request('passenger_id');

        $booking_data = $this->request_data['booking'];
        $order_data = $this->request_data['order'];

        $this->loadS_model('booking');
        $this->loadS_model('passenger');

        if (!$this->Model_passenger->get_passenger(array('id' => $passenger_id, 'status' => 1))) {
            $this->_die("The passenger is either not exists or inactive.");
        }

        $booking_data['invoice_id'] = $this->Model_booking->get_unique_invice_id(10);

        $booking_id = $this->Model_booking->register($booking_data);
        $order_ids = $this->Model_booking->register_orders($booking_id, $order_data);
        $this->setData('booking_id', $booking_id);
        $this->setData('order_ids', $order_ids);
        $this->setSuccess("Order is sucessfully registered.");
        $this->response();
    }

    public function cancel_booking() {

        $passenger_id = $this->request('passenger_id', true);
        $booking_no = $this->request('booking_no', true);

        $this->loadS_model('booking');
        $this->loadS_model('passenger');

        if (!$this->Model_passenger->get_passenger($passenger_id)) {
            $this->_die("The passenger does not exists.");
        }

        //Execute pre payment booking 
        //Write to code

        $this->Model_booking->cancel_booking($booking_no, $passenger_id);
        $this->setSuccess("The booking successfully cancelled.");
        $this->response();
    }

    private function verify_booking() {

        $driver_id = $this->request('driver_id', true);
        $booking_no = $this->request('booking_no', true);
        $vehical_no = $this->request('vehical_no', true);

        $this->loadS_model('driver');
        $this->loadS_model('booking');

        $driver = $this->Model_driver->get_driver($driver_id);
        $driver_hehical = $this->Model_driver->get_driver_vehical($driver_id);
        $booking = $this->Model_booking->get_booking($booking_no);

        if (!$driver) {
            $this->_die("The driver does not exists.");
        }
        if (!$driver_hehical) {
            $this->_die("The driver is not assigned to any vehicle currently.");
        }
        if ($vehical_no != $driver_hehical['vehical_id']) {
            $this->_die("The driver does not belongs to this vehicle.");
        }
        if (!$booking) {
            $this->_die("The booking does not exists.");
        }
        if (is_past_date($booking['booking_date'] . " " . $booking['booking_time'])) {
            $this->_die('Invalid past booking date.');
        }
        if ($booking['booking_status'] == 2) {
            $this->_die('The booking is already confirmed.');
        }
    }

    public function confirm_booking() {

        $driver_id = $this->request('driver_id', true);
        $booking_no = $this->request('booking_no', true);
        $vehical_no = $this->request('vehical_no', true);

        $this->loadS_model('driver');
        $this->loadS_model('booking');
        $this->loadS_model('passenger');

        $driver = $this->Model_driver->get_driver($driver_id);
        $driver_hehical = $this->Model_driver->get_driver_vehical($driver_id);
        $booking = $this->Model_booking->get_booking($booking_no);



//        if (!$driver) {
//            $this->_die("The driver does not exists.");
//        }
//        if (!$driver_hehical) {
//            $this->_die("The driver is not assigned to any vehicle currently.");
//        }
//        if ($vehical_no != $driver_hehical['vehical_id']) {
//            $this->_die("The driver does not belongs to this vehicle.");
//        }
//        if (!$booking) {
//            $this->_die("The booking does not exists.");
//        }
//        if (is_past_date($booking['booking_date'] . " " . $booking['booking_time'])) {
//            $this->_die('Invalid past booking date.');
//        }
//        if ($booking['booking_status'] == BOOKING_CONFIRMED) {
//            $this->_die('The booking is already confirmed.');
//        }

        if ($booking) {
            $passenger_id = $booking['passenger_id'];
            $passenger = $this->Model_passenger->get_passenger($passenger_id);
            if ($passenger) {
                $push_id = array($passenger['push_id']);
                $data = array(
                    'message' => "The booking has been confirmed.",
                    'booking_id' => $booking_no,
                    'driver_id' => $driver_id,
                    'booking_status' => $booking['booking_status']
                );
                $this->send_notification($push_id, $data);
            }
            
        }

        $this->Model_booking->confirm_booking($driver_id, $vehical_no, $booking_no);
        $this->set_success_responce("Booking has been confirmed.");
    }

    //for drivers only
    public function get_bookings() {

        $driver_id = $this->request('driver_id', true);
        $last_timestamp = $this->request('datetimestamp');
        $status = $this->request_default('status', 1);

        $this->loadS_model('driver');
        $this->loadS_model('booking');

        $driver = $this->Model_driver->get_driver($driver_id);
        $driver_hehical = $this->Model_driver->get_driver_vehical($driver_id);

        if (!$driver) {
            $this->_die("The driver does not exists.");
        }
        if (!$driver_hehical) {
            $this->_die("The driver not assigned to any vehicle currently.");
        }
        $creds = array();
//        $creds['city'] = $driver_hehical['city'];
//        $creds['state'] = $driver_hehical['state'];

        $list = $this->Model_booking->get_orders($creds, $status, $last_timestamp);
        $list = $this->get_formated_booking_list($list);
        $this->setSuccess("success");
        $this->setData('list', $list);
        $this->response();
    }

    public function get_orders() {

        $passenger_id = $this->request('passenger_id');
        $driver_id = $this->request('driver_id');
        $booking_id = $this->request('booking_id');
        $order_id = $this->request('order_id');
        $include_payment_info = $this->request('include_payment_info');

        if (!$passenger_id && !$booking_id && !$order_id && !$driver_id) {
            $data = array(
                'success' => true,
                'msg' => "No paremetere.",
                'list' => array()
            );
            $this->_die($data);
        }
        $this->loadS_model('booking');

        if ($passenger_id)
            $cred['passenger_id'] = $passenger_id;
        if ($booking_id)
            $cred['book.id'] = $booking_id;
        if ($order_id)
            $cred['ord.id'] = $order_id;
        if ($driver_id)
            $cred['ord.driver_no'] = $driver_id;

        $list = $this->Model_booking->get_orders($cred);

        $order = ($list) ? $list[0] : array();

        if ($include_payment_info)
            $this->base_payment_info($order);

        $this->setSuccess();
        $this->setData('list', $list);
        $this->response();
    }

    private function get_formated_booking_list($list) {
        $formated_list = array();
        $formated_list_2 = array();
        if ($list) {
            foreach ($list as $key => $val) {
                if (!isset($formated_list[$val['booking_id']])) {
                    $formated_list[$val['booking_id']] = $val;
                }
                if (!isset($formated_list[$val['booking_id']]['booked_dates'])) {
                    $formated_list[$val['booking_id']]['booked_dates'] = array();
                }
                $formated_list[$val['booking_id']]['booked_dates'][] = $val['pickup_date'];
            }
            foreach ($formated_list as $key => $value) {
                $formated_list_2[] = $value;
            }
            $list = $formated_list_2;
        }
        return $list;
    }

    public function update_booking_status() {

        $booking_id = $this->request('booking_id', true);
        $booking_status = $this->request('booking_status', true);

        $this->loadS_model('booking');

        $this->Model_booking->update($booking_id, array('booking_status' => $booking_status));

        $this->setSuccess("The status successfully updated.");
        $this->response();
    }

    private function base_payment_info($order) {

        if ($order) {
            $this->loadS_model('payment');
            $cred = array(
                'city' => 1,
                'size' => 3
            );
            $pay_info = $rate_card_info = array();
            $rate_card = $this->Model_payment->get_rate_card($cred);
            if (!$rate_card) {
                $this->setMessage("No Rate card found on this criteria.");
            } else {
                $pay_info['total_distance_cost'] = ( $order['actual_distance'] / $rate_card['mode_unit'] ) * $rate_card['mode_unit_cost'];
                $pay_info['total_labour_cost'] = ( $order['no_of_helpers'] * $rate_card['labour_rate'] );
                $pay_info['wating_hour_cost'] = ( $order['wating_time'] / $rate_card['waiting_hour_unit'] ) * $rate_card['wating_hour_cost'];
                $pay_info['grand_total'] = $pay_info['total_distance_cost'] + $pay_info['total_labour_cost'] + $pay_info['wating_hour_cost'];
                $pay_info['discount'] = $this->calculate_discount($order);
                $pay_info['final_payment'] = ($pay_info['grand_total'] - $pay_info['discount']) >= 0 ? $pay_info['grand_total'] - $pay_info['discount'] : 0;

                $rate_card_info = array(
                    'distance_unit' => $rate_card['mode_unit'],
                    'distance_unit_cost' => $rate_card['mode_unit_cost'],
                    'waiting_hour_unit' => $rate_card['waiting_hour_unit'],
                    'wating_hour_cost' => $rate_card['wating_hour_cost'],
                    'labout_unit_cost' => $rate_card['labour_rate']
                );
            }

            $this->loadS_model('order');

            $this->setData('payment_by_paytm', $this->Model_order->get_total_payments($order['order_id'], 2));
            $this->setData('payment_by_cash', $this->Model_order->get_total_payments($order['order_id'], 1));
            $this->setData('pay_info', $pay_info);
            $this->setData('rate_card', $rate_card_info);
        }
    }

    private function calculate_discount($order, $discount_code = '') {
        $discount = 50;
        $discount_code = ($discount_code) ? $discount_code : $this->request('discount_code');
        if ($discount_code) {
            $this->loadS_model('discount');
            $discount_object = $this->Model_discount->get_discount($discount_code);
            if ($discount_object) {
                $discount = $discount_object['discount_amount'] ? $discount_object['discount_amount'] : $discount_object['discount_persent'];
            }
        }
        return $discount;
    }

    public function get_rate_card() {

        $city = $this->request('city', true);
        $special_type = $this->request('special_type', true);
        $load_size = $this->request('load_size', true);

        $this->loadS_model('payment');

        $rate_card = $this->Model_payment->get_rate_card(array('city' => $city, 'special_type' => $special_type, 'size' => $load_size));

        $this->setData('rate_card', $rate_card);
        $this->set_success_responce();
    }

    public function share_invoice() {

        $id = $this->request('requester_id', true);
        $email_id = $this->request('email_id', true);
        $booking_id = $this->request('booking_id', true);
        $order_id = $this->request('order_id', true);
        $requester = $this->request('requester', true);

        $this->loadS_model('passenger');
        $this->loadS_model('driver');
        $this->loadS_model('agency');
        $this->loadS_model('common');

        if ($requester == 1) {
            $this->check_data_die($passenger = $this->Model_passenger->get_passenger($id), "The passenger does not exists.");
        } elseif ($requester == 2) {
            $this->check_data_die($passenger = $this->Model_driver->get_driver($id), "The driver does not exists.");
        } elseif ($requester == 3) {
            $this->check_data_die($passenger = $this->Model_agency->get_agency($id), "The agency does not exists.");
        }

        if (mail($email_id, "Invoice sharing demo", "Text for invice.")) {
            $this->set_success_responce("The invoice hasbeen shared shared.");
        } else {
            $this->set_error_responce("The mail not sent.");
        }
    }

    public function update_order_status() {

        $booking_id = $this->request('booking_id', true);
        $order_status = $this->request('order_status', true);
        $order_id = $this->request('order_id', true);

        $wating_time = $this->request('wating_time');
        $actual_time_taken = $this->request('actual_time_taken');
        $actual_distance = $this->request('actual_distance');

        $this->loadS_model('booking');

        $udata = array('order_status' => $order_status);

        if ($wating_time) {
            $udata['wating_time'] = $wating_time;
        }

        if ($order_status == ORDER_ARRIVED) {
            $udata['actual_arival_time'] = date('H:i:s');
        }
        if ($order_status == ORDER_STARTED) {
            $udata['actual_start_time'] = date('H:i:s');
        }
        if ($order_status == ORDER_REACHED) {
            $udata['actual_drop_time'] = date('H:i:s');
            $udata['actual_time_taken'] = $actual_time_taken;
            $udata['actual_distance'] = $actual_distance;
        }

        $this->Model_booking->update_order($order_id, $udata, $booking_id);
        $this->Model_booking->update_order_tracking($order_id, array('order_status' => $order_status), $booking_id);

        $this->setSuccess("The status successfully updated.");
        $this->response();
    }

    public function create_payment() {

        $data['booking_no'] = $this->request('booking_id', true);
        $data['order_no'] = $this->request('order_id', true);
        $data['payment_mode'] = $this->request('payment_mode', true);
        $data['total_payment'] = $this->request('total_payment', true);
        $data['transaction_id'] = $this->request('transaction_id');
        $extrainfo = $this->request('extrainfo');

        $this->loadS_model('payment');
        $pay_id = $this->Model_payment->create_payment($data);
        $this->setData('pay_id', $pay_id);
        $this->set_success_responce("The payment made successfully.");
    }

    public function get_actual_payment_info() {

        $booking_id = $this->request('booking_id', true);
        $order_id = $this->request('order_id', true);

        $this->loadS_model('payment');
        $this->loadS_model('booking');

        $order = $this->Model_booking->get_order(array('book.id' => $booking_id, 'ord.id' => $order_id));
        if ($order) {
            $this->base_payment_info($order);
        } else {
            $this->_die("No order found in this order id");
        }

        $this->set_success_responce();
    }

    public function calculate_fare() {

        $data['total_distance'] = $this->request('total_distance', true);
        $data['wating_time'] = $this->request('wating_time', true);
        $data['no_of_helpers'] = $this->request_default('no_of_helpers', 1);
        $data['passenger_no'] = $this->request('passenger_no', true);
        $data['driver_no'] = $this->request('driver_no', true);
        $data['vehical_no'] = $this->request('vehical_no', true);
    }

    /*
     * Order module end
     */

    /*
     * Info services 
     */

    public function metadatas() {

        $this->setSuccess();

        $this->setData('meta', key_value_pair($this->Model_common->getDatas(TBL_METAS)));
        $this->setData('tonnage', $this->Model_common->getDatas(TBL_TONNAGE_MASTER));
        $this->setData('special_types', $this->Model_common->getDatas(TBL_SPECIAL_TYPE_MASTER));
        $this->setData('cities', $this->Model_common->getDatas(TBL_MASTER_CITY));
        $this->setData('ccountry', $this->Model_common->getDatas(TBL_MASTER_COUNTRY));
        $this->setData('state', $this->Model_common->getDatas(TBL_MASTER_STATE));
        $this->setData('banks', array(
            array(
                'id' => 1,
                'name' => 'State Bank of India'
            ),
            array(
                'id' => 2,
                'name' => 'United Bank Of India'
            ),
            array(
                'id' => 3,
                'name' => 'Bank of India'
            ),
            array(
                'id' => 4,
                'name' => 'Allahabad Bank'
            )
        ));

        $html_text = "<p><span style='font-size: medium;'>Friends earn Rs 200 </span></p><p><span style='font-size: large;'>Friend Rides,<strong>you earn Rs.200</strong></span></p><p><span style='font-size: medium;'>Share your referal code 0XD48KL</span></p>";
        $this->setData('banner_text', $html_text);

        $time_frame = $this->Model_common->getDatas(TBL_TIMEFRAME_MASTER);
        if ($time_frame) {
            foreach ($time_frame as $key => $time) {
                $time_frame[$key]['start'] = date('h a', strtotime($time['start']));
                $time_frame[$key]['end'] = date('h a', strtotime($time['end']));
            }
        }
        $this->setData('timeframes', $time_frame);

        $this->response();
    }

    public function change_password() {

        $requester_id = $this->request('requester_id', true);
        $old_pass = $this->request('old_pass', true);
        $new_pass = $this->request('new_pass', true);

        $changer = $this->request_default('requester', 1); //NOTE : requester -> 1=Passenger, 2=Driver,3 = Agency [ default  value 1 ]

        $password = md5($new_pass);

        $this->loadS_model('passenger');
        $this->loadS_model('driver');
        $this->loadS_model('agency');

//        $this->show_query();

        if ($changer == 1 && !$this->Model_passenger->getData(TBL_PASSENGER, array('id' => $requester_id, 'password' => md5($old_pass)))) {
            $this->_die('The old passw does not exists.');
        } elseif ($changer == 2 && !$this->Model_passenger->getData(TBL_DRIVER, array('id' => $requester_id, 'password' => md5($old_pass)))) {
            $this->_die('The old passw does not exists.');
        } elseif ($changer == 3 && !$this->Model_passenger->getData(TBL_AGENCIES, array('id' => $requester_id, 'password' => md5($old_pass)))) {
            $this->_die('The old passw does not exists.');
        }

        if ($changer == 1)
            $this->Model_passenger->update(array('password' => $password), $requester_id);
        elseif ($changer == 2)
            $this->Model_driver->update(array('password' => $password), $requester_id);
        elseif ($changer == 3)
            $this->Model_agency->update(array('password' => $password), $requester_id);

        $this->set_success_responce("The password hasbeen changed successfully.");
    }

    public function get_faqs() {
        $this->loadS_model('common');
        $this->setData('list', $this->Model_common->getDatas(TBL_FAQ));
        $this->setSuccess();
        $this->response();
    }

    public function invite() {

        $id = $this->request('requester_id', true);
        $msg = $this->request('msg', true);
        $sender_info = $this->request('sender_id', true);
        $type = $this->request('type', true); // 1 = email , 2 = sms
        $requester = $this->request_default('requester', 1); //1=Passenger, 2=Driver,3=Agency


        $this->loadS_model('passenger');
        $this->loadS_model('driver');
        $this->loadS_model('agency');
        $this->loadS_model('common');

        if ($requester == 1) {
            $this->check_data_die($passenger = $this->Model_passenger->get_passenger($id), "The passenger does not exists.");
        } elseif ($requester == 2) {
            $this->check_data_die($passenger = $this->Model_driver->get_driver($id), "The driver does not exists.");
        } elseif ($requester == 3) {
            $this->check_data_die($passenger = $this->Model_agency->get_agency($id), "The agency does not exists.");
        }

        $status = $this->send_invite($sender_info, $type, $msg);

        $invid = $this->Model_common->insertRecord(TBL_INVITE, array(
            'passenger_id' => $id,
            'send_to' => $sender_info,
            'message' => $msg,
            'send_type' => $type,
            'send_status' => $status,
            'created_on' => date('Y-m-d')
        ));
        $this->setData('invite_id', $invid);
        $this->setSuccess("The invitation successfully sent.");
        $this->response();
    }

    private function send_invite($sno, $type, $text, $sub = "Invitaion for join cargo91") {
        if ($type == 1) {
            mail($sno, $sub, $text);
        } elseif ($type == 2) {
            
        }
        return 1;
    }

    public function assign_driver_to_booking() {

        $driver_id = $this->request('driver_id', true);
        $booking_id = $this->request('booking_id', true);
        $force_assign = $this->request('force_assign');

        $this->loadS_model('booking');
        $this->loadS_model('driver');
        $this->loadS_model('order');

        $driver = $this->Model_driver->get_driver($driver_id);
        $this->check_data_die($driver, "The driver does not exists.");

        $booking = $this->Model_booking->get_booking($booking_id);
        $this->check_data_die($booking, "The booking does not exists.");

        $driver_dates = $this->Model_driver->get_driver_booked_dates($driver_id);
        $booking_dates = $booking['dates'];

        if ($driver_dates) {
            foreach ($driver_dates as $dd) {
                if (in_array($dd, $booking_dates)) {
                    $this->_die("The driver already booked.");
                }
            }
        }

        $this->check_data_die(($booking['booking_status'] != BOOKING_UNASSIGNED AND ! $force_assign), "This booking is already assigned.");
//        $this->check_data_die(($booking['booking_status'] == BOOKING_ASSIGNED AND !$force_assign), "This booking is already assigned.");

        $this->Model_booking->update_booking($booking_id, array('booking_status' => BOOKING_ASSIGNED, 'driver_id' => $driver_id));
        $this->Model_order->updateRecord(TBL_ORDERS, array('booking_no' => $booking_id), array('driver_no' => $driver_id, 'order_status' => ORDER_CONFIRMED));

        $this->set_success_responce("The droiver successfully asigned.");
    }

    public function test() {

//        __debug("Test");
        $this->loadS_model('passenger');
//        echo $this->Model_passenger
//                ->get_model_instance()
//                ->setTable(TBL_BOOKING)
//                ->setField('passenger_id')
//                ->set_where_in('id', '1,2')
//                ->set_where_not_in('id', '1,2')
//                ->set_where_like('id', '%1%', "OR")
//                ->get_generated_query(true);
        echo $this->Model_passenger
                ->get_model_instance()
                ->setTable(TBL_PASSENGER)
                ->setWhereGroup(array('id' => 500))
                ->update_rows(array('full_name' => 'asd', 'phone_no' => 21321313));
        echo $this->db->last_query();
    }

    //Push notification
    public function tapamoy() {
        $red_id = $this->request('push_id');
//        $red_id = "APA91bFD7ehjg5fQLVrBtTBDgNLZO-sudESwv6xEzVV2JeQAmSccivI_L41SSgie3YSydQ3Qt_mtIabbQckPuJbL4_YYU7zK7Hs0XBX07IAmcPZudtO166ziLf_9QILQ7wvcYK47bv7qPQ96n8k8kNYy0fRbYgKxxQ";
        $msg = "TEST PUSH FOR ANDROID";
        $reg = array($red_id);
        $message = array('message' => $msg);
        print_r($this->send_notification($reg, $message));
    }

}
