<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of OrderController
 * @property Model_order $Model_order Model_order
 * @author Suchandan
 */
class OrderController extends MY_Controller {

    private $request_data;
    private $update = false;

    public function __construct() {
        parent::__construct();
        $this->auth(admin_base_url('login'));
        $this->loadS_model('order');
        $this->loadS_model('booking');
    }

    public function register($id = '') {

        $booking_action = '';
        $this->setViewData('action', 'insert');
        $action = $this->request_param('action');

        if ($action == 'update') {

            $this->set_request_object('booking');
            $this->set_booking_data();
            $this->set_order_data();
            $this->unset_request_object();

            $booking = $this->request_data['booking'];
            $orders = $this->request_data['order'];
            $booking['booking_status'] = $this->request_array('booking_status', 'booking');

            $this->Model_booking->update_booking($id, $booking);

            if ($orders) {
                foreach ($orders as $order) {
                    $order_id = $order['order_id'];
                    unset($order['order_id']);
                    $this->Model_booking->update_order($order_id, $order);
                }
            }
            $this->redirectTO(admin_base_url('order/update/' . $id), "The Booking successfully updated.");
        } elseif ($action == 'insert') {

            $booking = $this->request_param('booking');
            $this->setViewData('data_object', $booking);

            $this->set_request_object('booking');
            $this->set_booking_data();
            $this->set_order_data();
            $this->unset_request_object();

            if ($this->check_errors()) {
                $this->errors_response();
            } else {
                $booking_data = $this->request_data['booking'];
                $order_data = $this->request_data['order'];

                $booking_data['invoice_id'] = $this->Model_booking->get_unique_invice_id(10);

                $booking_id = $this->Model_booking->register($booking_data);
                $order_ids = $this->Model_booking->register_orders($booking_id, $order_data);

                $this->redirectTO(admin_base_url('order/lists'), "The order successfully placed.");
            }
        }

        $this->setViewData('panel_heading', "Order info");
        $this->setViewData('action', "insert");

        $this->add_style('assets/vendors/timepicker/jquery.timepicker.css');
        $this->add_script('assets/vendors/timepicker/jquery.timepicker.min.js', true);

        $this->add_style('assets/vendors/autocomplete/autocomplete.css');
        $this->add_script('assets/vendors/autocomplete/jquery.autocomplete.min.js', true);

        $this->add_auto_load_script('google_map');
        $this->add_auto_load_script('booking', true);

        $this->setViewData('timeframes', $this->Model_order->getDatas(TBL_TIMEFRAME_MASTER));
        $this->setViewData('special_types', key_value_pair($this->Model_order->getDatas(TBL_SPECIAL_TYPE_MASTER), 'id', 'name', array('' => 'Select Special type')));
        $this->setViewData('capacity_types', key_value_pair($this->Model_order->getDatas(TBL_TONNAGE_MASTER), 'id', 'name', array('' => 'Select capicity type')));
        $this->setViewData('cities', key_value_pair($this->Model_order->getDatas(TBL_MASTER_CITY), 'id', 'name', array('' => 'Select City')));
        $this->setViewData('states', key_value_pair($this->Model_order->getDatas(TBL_MASTER_STATE), 'id', 'name', array('' => 'Select State')));
        $this->setViewData('booking_statuses', $this->status->get_booking_status_array());

        $this->setViewData('booking_action', $booking_action);

        if ($id) {
            $this->setViewData('action', 'update');
            $data = $this->Model_booking->get_order($id);
            $dates = $this->Model_booking->getDatas(TBL_ORDERS, array('booking_no' => $id), array('pickup_date', 'id'));
            $d = array();
            if ($dates) {

                foreach ($dates as $date) {
                    $d[$date['id']] = $date['pickup_date'];
                }
            }
            $data['booking_date'] = $d;
            $this->setViewData('data_object', $data);
        }

        $this->render_view('register', 'order');
    }

    public function update($id) {
        if (!$id) {
            show_error("Invalid order id provided.");
        }
        $this->update = true;
        $this->register($id);
    }

    public function lists() {
        $this->setViewData('box_header', "Order list");
        $this->setPaginationModel($this->Model_booking);
        $list = $this->Model_booking->get_bookings();
        $this->setPagination(admin_base_url('order/' . __FUNCTION__), $this->Model_booking->getTotalCount(), count($list));

        $this->setViewData('list', $list);
        $this->setViewData('list_headers', array(
            'booking_id' => 'Booking ID',
            'invoice_id' => 'Invoice ID',
            'booking_status' => 'Booking Status',
            'pickup_date' => 'Pickup Date',
            'requested_pickup_time' => 'Pickup Time',
            'action' => 'Action'
        ));
        $this->get_formated_list();
//        $this->debug_view();
        $this->render_view('list', 'common');
    }

    private function get_formated_list() {
        $list = $this->getViewData('list');
        if ($list) {
            foreach ($list as $key => $user) {
                $list[$key]['action'] = '';
                $list[$key]['action'] .= $this->load->view('common/action-bar', $user, true);
                $list[$key]['booking_status'] = $this->status->get_booking_status_text($user['booking_status']);
//                $list[$key]['status'] = ($user['status']) ? '<span class="label label-success">Active</span>' : '<span class="label label-important">Inactive</span>';
            }
            $this->setViewData('list', $list);
        }
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

    private function set_booking_data() {

        $this->request_data['booking'] = array();

        //Booking Details
        $this->request_data['booking']['passenger_id'] = $this->request_param('passenger_id', "Please select the passenger.");

        $this->request_data['booking']['booking_time'] = $this->request_param('booking_time');
        $this->request_data['booking']['flexible_timeslot'] = $this->request_param('flexible_timeslot');
        $this->request_data['booking']['no_of_helpers'] = $this->request_param('no_of_helpers');
        $this->request_data['booking']['estimated_cost'] = $this->request_param('estimated_cost');
        $this->request_data['booking']['estimated_distance'] = $this->request_param('estimated_distance', "Please give the estimated distance.");
        $this->request_data['booking']['booking_status'] = BOOKING_RAISED;
        $this->request_data['booking']['special_type'] = $this->request_default('special_type', 1);
        $this->request_data['booking']['capacity_type'] = $this->request_default('capacity_type', 1);
        $this->request_data['booking']['comments'] = $this->request_param('comments');
        $this->request_data['booking']['city'] = $this->request_default('city', 1);
        $this->request_data['booking']['state'] = $this->request_default('state', 1);
        $this->request_data['booking']['pin'] = $this->request_param('pin', "Please give the pin.");

        if (!$this->update)
            $this->request_data['booking']['created_on'] = date('Y-m-d H:i:s');
        if (!$this->update)
            $this->request_data['booking']['booking_date'] = make_date();
    }

    private function set_order_data() {

        $this->request_data['order'] = array();
        $date_array = array();

        $date_array = $this->request_param('booking_date');
        //Order Details
        $this->request_data['booking']['pickup_type'] = ($this->request_param('pickup_type')) ? $this->request_param('pickup_type') : 1;
        if ($date_array) {
            foreach ($date_array as $key => $date) {
                $order = array(
                    'pickup_address' => $this->request_param('pickup_address', "Please give the pickup address."),
                    'requested_pickup_time' => $this->request_param('booking_time'),
                    'pickup_lat' => $this->request_param('pickup_lat', "Please give the pickup latitude."),
                    'pickup_long' => $this->request_param('pickup_long', "Please give the pickup longitude."),
                    'drop_address' => $this->request_param('drop_address', "Please give drop adddress."),
                    'pin' => $this->request_param('pin'),
                    'drop_lat' => $this->request_param('drop_lat', "Please give the drop latitude."),
                    'drop_long' => $this->request_param('drop_long', "Please give the drop longitude."),
                    'pickup_date' => make_date($date),
                    'is_flexible' => ($this->request_data['booking']['pickup_type'] == 2) ? 1 : 0,
                    'flexible_time_id' => $this->request_param('flexible_timeslot')
                );
                if ($order['is_flexible'] == 2) {
                    $order['flexible_time_id'] = $this->request_param('flexible_timeslot');
                }
                if ($this->update) {
                    $order['order_id'] = $key;
                    $order['flexible_time_id'] = $this->request_data['booking']['flexible_timeslot'] = ($this->request_data['booking']['pickup_type'] == 1) ? 0 : $this->request_param('flexible_timeslot');
                }
                $this->request_data['order'][] = $order;
            }

            $order_count = count($this->request_data['order']);
            $this->request_data['booking']['no_of_order'] = $order_count;

            $this->request_data['booking']['booking_type'] = ($order_count > 1) ? 2 : 1;
        }
    }

}
