<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DashboardController
 *
 * @author Suchandan
 */
class DashboardController extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->auth(admin_base_url('login'));
        $this->loadS_model('order');
        $this->loadS_model('booking');
    }

    public function index() {
        $this->setViewData('title', "Dashboard");
        $this->data['user_count'] = $this->Model_common->countData(TBL_PASSENGER);
        $this->data['order_count'] = $this->Model_common->countData(TBL_ORDERS);
        $this->data['driver_count'] = $this->Model_common->countData(TBL_DRIVER);
        $this->data['booking_count'] = $this->Model_common->countData(TBL_BOOKING);

        $this->get_bookings();
        $this->render_view('dashboard');
    }

    public function get_bookings() {

        $this->setPaginationValues(4);
        $this->setPaginationModel($this->Model_booking);
        $bookings = $this->Model_booking->get_current_bookings();
        $this->setPagination(admin_base_url('dashboard/index'), $this->Model_booking->getTotalCount(), count($bookings));
        $this->setViewData('list', $bookings);
        $this->setViewData('object', 'booking');

        $this->setViewData('list_headers', array(
            'invoice_id' => 'Invoice',
            'booking_status_text' => 'Status',
            'pickup_date' => 'Date',
            'booking_type' => 'Type',
            'requested_pickup_time' => 'Pickup Time',
//            'asign_status' => 'Assign',
            'action' => 'Action'
        ));

        $this->get_formated_list();
    }

    private function get_formated_list() {
//        $list = $this->get_formated_booking_list($this->getViewData('list'));
        $list = $this->getViewData('list');
        if ($list) {
            foreach ($list as $key => $user) {
//                debug($user);
                $list[$key]['action'] = '';
                $list[$key]['action'] .= $this->load->view('common/action-bar', array_merge($user, array(
                    'delete_url' => 'dashboard/unassign_booking?booking_id=' . $user['id'],
                    'delete_text' => 'Want to unassign this booking?',
                    'delete_title' => 'Unassign',
                    'no_view' => true,
                    'edit_url' => 'order/update/' . $user['id'],
                    'extra' => '<a class="btn btn-success action-btn assign " data-id="14" href="' . base_url("assign_booking/assign/" . $user['id']) . '" title="Assign"><i class="fa fa-cog"></i></a>'
                                )
                        ), true);
                $list[$key]['booking_status_text'] = $this->status->get_booking_status_text($user['booking_status']);
                $list[$key]['booking_status_class'] = $this->status->get_booking_status_class($user['booking_status']);
                $list[$key]['booking_type'] = __echeck($user['booking_type'] == 2, "Recurring", "FIxed", true);
                $assign = array(0 => "Unassigned", 1 => "Agency", 2 => 'Cargo Driver');
                $list[$key]['requested_pickup_time'] = __echeck($user['pickup_type'] == 2, $user['flex_time'], $user['booking_time'], true);
                $list[$key]['booking_date'] = __echeck(isset($user['booked_dates']) AND count($user['booked_dates']) > 1, "Recurinng", $user['booking_date'], true);
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

    public function unassign_booking() {
        if ($booking_id = $this->request('booking_id')) {
            $this->Model_booking->deleteRecord(TBL_ASSIGNED_DRIVERS, array('booking_id' => $booking_id));
            $this->Model_booking->deleteRecord(TBL_ASSIGNED_AGENCY, array('booking_id' => $booking_id));
            $this->Model_booking->update_booking_status($booking_id, BOOKING_UNASSIGNED);
        }else{
            $this->redirectOnError(admin_base_url('dashboard'), "No booikin id specified.");
        }
        $this->redirectTO(admin_base_url('dashboard'), "The booking is successfully unassigned.");
    }

}
