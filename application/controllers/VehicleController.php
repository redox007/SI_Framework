<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of VehicleController
 *
 * @author Suchandan
 */
class VehicleController extends MY_Controller {

    private $validate_condition;
    private $existance_condition;
    private $table = TBL_VEHICALS;

    public function __construct() {
        parent::__construct();

        $this->auth(admin_base_url('login'));
        $this->loadS_model('vehical');
        $this->setViewData('title', "Vehicle manage");
        $this->setViewData('vehicle', array());
        $this->set_default_conditions();
        $this->setViewData('object', 'vehicle');
    }

    private function set_default_conditions() {

        $this->validate_condition = array(
            'model' => "Please provide model no.",
            'registration_no' => "Please provide registration no.",
            'capacity' => "Please provide capacity.",
            'type' => "Please provide type."
        );

        $this->existance_condition = array(
            'registration_no' => "The registration id already exists.",
            'vehicle_insurance_no' => "The vehicle insrance no exists."
        );
    }

    private function set_entry_data() {
        $this->setViewData('special_types', key_value_pair($this->Model_vehical->getDatas(TBL_SPECIAL_TYPE_MASTER), 'id', 'name'));
        $this->setViewData('tonnage_array', key_value_pair($this->Model_vehical->getDatas(TBL_TONNAGE_MASTER), 'id', 'name'));
    }

    public function register() {

        $action = $this->post('action');

        if ($action == 'insert') {
            $insert_data = $this->post('vehicle');
            $this->setViewData('vehicle', $insert_data);

            if (!$this->validation($this->validate_condition, $insert_data)) {
                $this->errors_response();
            } elseif (($errors = $this->Model_common->check_with_specific_fields_with_errors($this->table, $this->existance_condition, $insert_data))) {
                $this->setErrors($errors);
                $this->errors_response();
            } else {

                $insert_data['created_on'] = date('y-m-d H:i:s');
                $id = $this->Model_vehical->register($insert_data);
                $this->redirectON(admin_base_url('vehicle/lists'), "The vehical successfully registered.");
            }
        }

        $this->set_entry_data();
        $this->setViewData('panel_heading', "Vehicle info");
        $this->setViewData('action', "insert");
        $this->render_view('register', 'vehicle');
    }

    public function lists() {

        $this->setViewData('box_header', "Vehicle list");
        $this->setPaginationValues(4);
        $this->setPaginationModel($this->Model_vehical);
        $this->setViewData('list', $this->Model_vehical->get_list());
        $this->setPagination(admin_base_url('vehicle/lists'), $this->Model_vehical->getTotalCount(), count($this->getViewData('list')));
        $this->setViewData('show_search', true);
        $this->setViewData('search_param', array(
            'search_type' => 'vehicle'
        ));
        $this->setViewData('list_headers', array(
            'name' => 'Name',
            'model' => 'model',
            'registration_no' => 'Reg no',
            'capacity_text' => 'Capacity',
            'special_type' => 'Type',
            'status' => 'Status',
            'action' => 'Action',
        ));
        $this->get_formated_list();
        $this->render_view('list', 'common');
    }

    private function get_formated_list() {
        $list = $this->getViewData('list');
        if ($list) {
            foreach ($list as $key => $vehicle) {
                $list[$key]['action'] = '';
                $list[$key]['action'] .= $this->load->view('common/action-bar', $vehicle, true);
                $list[$key]['status'] = ($vehicle['status']) ? '<span class="label label-success">Active</span>' : '<span class="label label-important">Inactive</span>';
            }
            $this->setViewData('list', $list);
        }
    }

    public function update($id = '') {
        $this->setViewData('action', 'update');
        $vehicle = $this->Model_vehical->get_vehical($id);
        $action = $this->post('action');
        if (!$id) {
            show_error('The vehical id not defined.');
        }
        if ($action == 'update') {
            $vehicle = $this->post('vehicle');

            if (!$this->validation($this->validate_condition, $this->post('vehicle'))) {
                $this->errors_response();
                $this->setViewData('vehicle', $this->post('vehicle'));
            } elseif (($errors = $this->Model_common->check_with_specific_fields_with_errors($this->table, $this->existance_condition, $vehicle, db_condition_maker(db_field_concat($this->table, 'id'), $id, '!=')))) {
                $this->setErrors($errors);
                $this->errors_response();
            } else {
                $this->Model_vehical->update($id, $this->post('vehicle'));
                $this->redirectTO(admin_base_url('vehicle/update/' . $id), "The vehicle successfully updated.");
            }
        }
        $this->set_entry_data();
        $this->setViewData('vehicle', $vehicle);
        $this->setViewData('panel_heading', "Vehicle info");
        $this->render_view('register', 'vehicle');
    }

    public function view($id) {
        $this->setViewData('panel_heading', "Vehicle info");
        $vehicle = $this->Model_vehical->get_vehical($id);
        if (!$id || !$vehicle) {
            show_error('Invalid vehical ID.');
        }
        $vehicle['status'] = ($vehicle['status']) ? '<span class="label label-success">Active</span>' : '<span class="label label-important">Inactive</span>';
        $vehicle['created_on'] = date('Y-m-d', strtotime($vehicle['created_on']));

        $this->setViewData('vehicle', $vehicle);
        $this->render_view('view', 'vehicle');
    }

    public function delete($id) {
        $vehicle = $this->Model_vehical->get_vehical($id);
        if (!$id || !$vehicle) {
            show_error('Invalid vehical ID.');
        }

        $this->Model_vehical->delete($id);
        $this->redirectTO(admin_base_url('lists'), "The vehical successfully deleted.");
    }

}
