<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Assign_booking
 *
 * @author Suchandan
 */
class Assign_booking extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->loadS_model('driver');
        $this->loadS_model('agency');
        $this->loadS_model('booking');
        $this->list_limit = 2;

//        $this->enable_ajax_pagination();
    }

    public function assign($booking_id = '') {
        if (!$booking_id) {
            
        }
        $drivers = array();
        $agencies = array();
        
//        $this->Model_driver->show_query();
        $this->assigned_drivers = $this->Model_booking->get_asigned_drivers($booking_id);
        $this->setViewData('booking', $this->Model_booking->get_booking($booking_id));
//        debug($this->getViewData('booking'));
//        $this->setPaginationModel($this->Model_driver, $this->list_limit);
        $drivers['list'] = $this->get_formated_list($this->Model_driver->get_list());
//        $this->setPagination('assign_booking/drivers', $this->Model_driver->getTotalCount(), count($drivers['list']));
//        $drivers['pagination'] = $this->getPagination();
        $drivers['object'] = 'driver';
        $drivers['list_headers'] = array(
            'check' => "Tick",
            'full_name' => 'Name',
            'phone_no' => 'Phone',
            'status' => 'Status',
//            'action' => 'Action'
        );

        $this->assigned_agencies = $this->Model_booking->get_asigned_agecies($booking_id);
//        $this->setPaginationModel($this->Model_agency, $this->list_limit);
        $agencies['list'] = $this->get_formated_list($this->Model_agency->get_list(), 'agency');
//        $this->setPagination('assign_booking/agencies', $this->Model_agency->getTotalCount(), count($agencies['list']));
//        $agencies['pagination'] = $this->getPagination();
        $drivers['object'] = 'agency';
        $agencies['list_headers'] = array(
            'check' => "Tick",
            'name' => "Name",
            'owner_contact_no' => 'Contact no',
//            'action' => 'Action'
        );

        $this->setViewData('driver', $drivers);
        $this->setViewData('agency', $agencies);
        $this->setViewData('booking_id', $booking_id);
//        $this->debug_view();
        $this->render_view('assign');
    }

    private function get_formated_list($list, $type = 'driver') {
        if ($list) {
            foreach ($list as $key => $user) {
//                $list[$key]['action'] = $this->load->view('common/action-bar', array_merge($user, array(
//                    'no_delete' => true,
//                    'no_view' => true,
//                    'no_edit' => true,
//                    'extra' => '<a class="btn btn-info action-btn assign" data-id="14" href="' . base_url("assign_booking/assign_" . $type . "/" . $user['id']) . '" title="Assign"><i class="fa fa-check-square-o"></i></a>'
//                                )
//                        ), true);
                if ($type == 'agency') {
                    $list[$key]['check'] = form_checkbox('agency_id[]', $user['id'], in_array($user['id'], $this->assigned_agencies));
                } elseif ($type == 'driver') {
                    $list[$key]['check'] = form_checkbox('driver_id[]', $user['id'], in_array($user['id'], $this->assigned_drivers));
                }
            }
        }
        return $list;
    }

    public function drivers() {
//        $this->setPaginationValues(3);
//        $this->setPaginationModel($this->Model_driver, $this->list_limit);
        $this->setViewData('list_headers', array(
            'check' => "Tick",
            'full_name' => 'Name',
            'phone_no' => 'Phone',
            'status' => 'Status'
        ));
        $this->setViewData('list', $this->get_formated_list($this->Model_driver->get_list(), 'driver'));
        $this->setViewData('object', 'drivers');
//        $this->setPagination('assign_booking/drivers', $this->Model_driver->getTotalCount(), count($this->getViewData('list')));
        $this->render_view('list-template', 'common');
    }

    public function agencies() {
//        $this->setPaginationValues(3);
//        $this->setPaginationModel($this->Model_agency, $this->list_limit);
        $this->setViewData('list_headers', array(
            'check' => "Tick",
            'name' => "Name",
            'owner_contact_no' => 'Contact no'
        ));
        $this->setViewData('object', 'agencies');
        $this->setViewData('list', $this->get_formated_list($this->Model_agency->get_list(), 'agency'));
//        $this->setPagination('assign_booking/agencies', $this->Model_agency->getTotalCount(), count($this->getViewData('list')));
        $this->render_view('list-template', 'common');
    }

    public function assign_to_booking() {
        
        $assign_booking = $this->request('assign_booking');
        $driver_ids = $this->request('driver_id');
        $agency_ids = $this->request('agency_id');
        $booking_id = $this->request('booking_id');
        
        if($assign_booking){
            $this->Model_common->deleteRecord(TBL_ASSIGNED_DRIVERS, array('booking_id' => $booking_id));
            $this->Model_common->deleteRecord(TBL_ASSIGNED_AGENCY, array('booking_id' => $booking_id));
            if($driver_ids){
                foreach($driver_ids as $ids){
                    $this->Model_common->insertRecord(TBL_ASSIGNED_DRIVERS, array('booking_id' => $booking_id,'driver_id' => $ids,'assigned_by' => 1));
                }
            }
            if($agency_ids){
                foreach($agency_ids as $ids){
                    $this->Model_common->insertRecord(TBL_ASSIGNED_AGENCY, array('booking_id' => $booking_id,'agency_id' => $ids,'assigned_by' => 1));
                }
            }
        }
        $this->Model_booking->update_booking($booking_id, array('booking_status' => BOOKING_ASSIGNED));
        $this->redirectTO('assign_booking/assign/'.$booking_id, "The booking is assigned successfully.");
    }

}
