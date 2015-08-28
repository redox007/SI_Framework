<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AgencyController
 *
 * @author Suchandan
 */
class AgencyController extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->auth(admin_base_url('login'));
        $this->loadS_model('agency');
        $this->setViewData('title', "Agency manage");
        $this->setViewData('agency', array());
    }

    public function register() {

        $action = $this->post('action');

        if ($action == 'insert') {

            $insert_data = $this->post('agency');
            $this->setViewData('agency', $insert_data);
            $condition = array(
                'registration_no' => "Please provide registration no.",
                'owner_name' => "Please provide owner name.",
                'owner_contact_no' => "Please provide contact no.",
                'city' => "Please provide city.",
                'pin_code' => "Please provide pin code.",
                'agency_bank_name' => "Please provide bank name.",
                'agency_bank_accont_no' => "Please provide bank A/C no.",
            );

            $field_check = array(
                'registration_no' => "The registration no already exists.",
                'owner_contact_no' => "The owner contact no already exists.",
                'agency_bank_accont_no' => "The bank account no already exists."
            );


            if (!$this->validation($condition, $insert_data)) {
                $this->errors_response();
            } elseif (($errors = $this->Model_common->check_with_specific_fields_with_errors(TBL_AGENCIES, $field_check, $insert_data))) {
                $this->setErrors($errors);
                $this->errors_response();
            } else {
                $insert_data['created_on'] = date('y-m-d H:i:s');
                $id = $this->Model_agency->register($insert_data);
                $this->redirectON(admin_base_url('agency/lists'), "The agency successfully registered.");
            }
        }

        $this->setViewData('panel_heading', "Agency info");
        $this->setViewData('action', "insert");
        $this->render_view('register', 'agency');
    }

    public function lists() {
        $this->setViewData('box_header', "Agency list");
        $this->setViewData('list', $this->Model_agency->get_list());
        $this->setViewData('list_headers', $this->get_list_view_fields());
        $this->get_formated_list();
        $this->render_view('list', 'common');
    }

    private function get_formated_list() {
        $list = $this->getViewData('list');
        if ($list) {
            foreach ($list as $key => $agency) {
                $list[$key]['action'] = '';
                $list[$key]['action'] .= $this->load->view('common/action-bar', $agency, true);
                $list[$key]['status'] = ($agency['status']) ? '<span class="label label-success">Active</span>' : '<span class="label label-important">Inactive</span>';
            }
            $this->setViewData('list', $list);
        }
    }

    public function update($id = '') {
        $this->setViewData('action', 'update');
        $agency = $this->Model_agency->get_agency($id);
        $action = $this->post('action');
        if (!$id) {
            show_error('The agency id not defined.');
        }
        if ($action == 'update') {
            $agency = $this->post('agency');
            $condition = array(
                'registration_no' => "Please provide registration no.",
                'owner_name' => "Please provide owner name.",
                'owner_contact_no' => "Please provide contact no.",
                'city' => "Please provide city.",
                'pin_code' => "Please provide pin code.",
                'agency_bank_name' => "Please provide bank name.",
                'agency_bank_accont_no' => "Please provide bank A/C no.",
            );

            $field_check = array(
                'registration_no' => "The registration no already exists.",
                'owner_contact_no' => "The owner contact no already exists.",
                'agency_bank_accont_no' => "The bank account no already exists."
            );

            if (!$this->validation($condition, $this->post('agency'))) {
                $this->errors_response();
                $this->setViewData('agency', $this->post('agency'));
            } elseif (($errors = $this->Model_common->check_with_specific_fields_with_errors(
                    TBL_AGENCIES, $field_check, $agency, db_condition_maker(db_field_concat(TBL_AGENCIES, 'id'), $id, '!='))
                    )
            ) {
                $this->setErrors($errors);
                $this->errors_response();
            } else {
                $this->Model_agency->update($id, $this->post('agency'));
                $this->redirectTO(admin_base_url('agency/update/' . $id), "The agency successfully updated.");
            }
        }
        $this->setViewData('agency', $agency);
        $this->setViewData('panel_heading', "Agency info");
        $this->render_view('register', 'agency');
    }

    public function view($id) {
        $this->setViewData('panel_heading', "Agency info");
        $agency = $this->Model_agency->get_agency($id);
        if (!$id || !$agency) {
            show_error('Invalid agency ID.');
        }
        $agency['status'] = get_status_text($agency['status']);
        $agency['created_on'] = date('Y-m-d', strtotime($agency['created_on']));

        $this->setViewData('view_keys', $this->get_view_fields());
        $this->setViewData('agency', $agency);
        $this->render_view('view', 'agency');
    }

    public function delete($id) {
        $agency = $this->Model_agency->get_agency($id);
        if (!$id || !$agency) {
            show_error('Invalid agency ID.');
        }

        $this->Model_agency->delete($id);
        $this->redirectTO(admin_base_url('lists'), "The agency successfully deleted.");
    }

    private function get_view_fields() {
        $list_view_fields = $this->get_list_view_fields();
        unset($list_view_fields['action']);
        $view_array = array_insert_element($list_view_fields, 'pin_code', 'area', "Area");
        return $view_array;
    }

    private function get_list_view_fields() {
        return array(
            'id' => 'Agency ID',
            'name' => 'Name',
            'registration_no' => 'Reg. no',
            'owner_name' => "Owner name",
            'owner_contact_no' => 'contact no',
            'city' => 'City',
            'pin_code' => 'Pin',
            'status' => 'Status',
            'created_on' => 'Date',
            'action' => 'Action'
        );
    }

}
