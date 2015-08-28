<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LabourController
 *
 * @author Suchandan
 * @property Model_labour $Model_labour Model_labour
 */
class LabourController extends MY_Controller {

    private $validate_condition;
    private $existance_condition;
    private $table = TBL_LABOUR; 

    public function __construct() {
        parent::__construct();

        $this->auth(admin_base_url('login'));
        $this->loadS_model('labour');
        $this->setViewData('title', "Labour manage");
        $this->setViewData('labour', array());
        $this->set_default_conditions();
    }

    private function set_default_conditions() {

        $this->validate_condition = array(
            'phone' => "Please provide phone no.",
        );

        $this->existance_condition = array(
            'phone' => "The phone no already exists."
        );
    }

    private function set_entry_data() {
        $this->setViewData('agencies', key_value_pair($this->Model_labour->getDatas(TBL_AGENCIES), 'id', 'name'));
    }

    public function register() {

        $action = $this->post('action');

        if ($action == 'insert') {

            $insert_data = $this->post('labour');
            $this->setViewData('labour', $insert_data);

            if (!$this->validation($this->validate_condition, $insert_data)) {
                $this->errors_response();
            } elseif (($errors = $this->Model_common->check_with_specific_fields_with_errors($this->table, $this->existance_condition, $insert_data))) {
                $this->setErrors($errors);
                $this->errors_response();
            } else {
                $insert_data['created_on'] = date('y-m-d H:i:s');
                $id = $this->Model_labour->register($insert_data);
                $this->redirectON(admin_base_url('labour/lists'), "The labour successfully registered.");
            }
        }
        
        $this->set_entry_data();
        $this->setViewData('panel_heading', "Labour info");
        $this->setViewData('action', "insert");
        $this->render_view('register', 'labour');
    }

    public function update($id = '') {

        $labour = $this->Model_labour->get_labour($id);
        
        $action = $this->post('action');
        
        if (!$id) {
            show_error('The labour id not defined.');
        }
        
        if ($action == 'update') {
            
            $labour = $this->post('labour');

            if (!$this->validation($this->validate_condition, $this->post('labour'))) {
                $this->errors_response();
                $this->setViewData('labour', $this->post('labour'));
            } elseif (($errors = $this->Model_common->check_with_specific_fields_with_errors($this->table, $this->existance_condition, $labour, db_condition_maker(db_field_concat($this->table, 'id'), $id, '!=')))) {
                $this->setErrors($errors);
                $this->errors_response();
            } else {
                $this->Model_labour->update($id, $this->post('labour'));
                $this->redirectTO(admin_base_url('labour/update/' . $id), "The labour successfully updated.");
            }
        }
        
        $this->set_entry_data();
        $this->setViewData('labour', $labour);
        $this->setViewData('action', 'update');
        $this->setViewData('panel_heading', "Labour info");
        $this->render_view('register', 'labour');
    }

    public function lists() {
        $this->setViewData('box_header', "Labour list");
        $this->setViewData('list', $this->Model_labour->get_list(array_keys($this->get_list_view_fields(true))));
        $this->setViewData('list_headers', $this->get_list_view_fields());
        $this->get_formated_list();
        $this->render_view('list', 'common');
    }

    private function get_formated_list() {
        $list = $this->getViewData('list');
        if ($list) {
            foreach ($list as $key => $labour) {
                $list[$key]['action'] = '';
                $list[$key]['action'] .= $this->load->view('common/action-bar', $labour, true);
                $list[$key]['status'] = ($labour['status']) ? '<span class="label label-success">Active</span>' : '<span class="label label-important">Inactive</span>';
            }
            $this->setViewData('list', $list);
        }
    }

    public function view($id) {
        $this->setViewData('panel_heading', "Labour info");
        $labour = $this->Model_labour->get_labour($id);
        if (!$id || !$labour) {
            show_error('Invalid labour ID.');
        }
        $labour['status'] = get_status_text($labour['status']);
        $labour['created_on'] = date('Y-m-d', strtotime($labour['created_on']));

        $this->setViewData('view_keys', $this->get_view_fields());
        $this->setViewData('view_data', $labour);
        $this->render_view('view', 'labour');
    }

    public function delete($id) {
        $labour = $this->Model_labour->get_labour($id);
        if (!$id || !$labour) {
            show_error('Invalid labour ID.');
        }

        $this->Model_labour->delete($id);
        $this->redirectTO(admin_base_url('lists'), "The labour successfully deleted.");
    }

    private function get_view_fields() {
        $list_view_fields = $this->get_list_view_fields();
        unset($list_view_fields['action']);
        $view_array = array_insert_element($list_view_fields, 'pin_code', 'area', "Area");
        return $view_array;
    }

    private function get_list_view_fields($unset_action = false) {
        $fields = array(
            'id' => 'Labour ID',
            'name' => 'Name',
            'phone' => 'Phone',
            'city' => 'City',
            'area' => 'Area',
            'status' => 'Status',
            'created_on' => 'Date',
            'action' => 'Action'
        );
        if($unset_action){
            unset($fields['action']);
        }
        return $fields;
    }

}
