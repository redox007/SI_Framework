<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DriverController
 *
 * @author Suchandan
 * @property Model_driver $Model_driver Model_driver
 */
class DriverController extends MY_Controller {

    private $validate_condition;
    private $existance_condition;
    private $table = TBL_DRIVER;

    public function __construct() {
        parent::__construct();

        $this->auth(admin_base_url('login'));
        $this->loadS_model('driver');
        $this->setViewData('title', "Driver manage");
        $this->setViewData('user', array());
        $this->setViewData('object', 'driver');
        $this->set_default_conditions();
    }

    private function set_default_conditions() {

        $this->validate_condition = array(
            'phone_no' => "Please provide phone no.",
            'email_id' => "Please provide email id.",
            'password' => "Please provide password.",
            'dob' => "Please provide date of birth.",
            'license_no' => "Please provide lisense no.",
            'bank_account_no' => "Please provide bank acount no."
        );

        $this->existance_condition = array(
            'phone_no' => "The phone no already exists.",
            'bank_account_no' => "The bank account no already exists.",
            'license_no' => "The lisense no already exists.",
        );
    }

    private function set_entry_data() {
        $this->setViewData('agencies', key_value_pair($this->Model_labour->getDatas(TBL_AGENCIES), 'id', 'name'));
    }

    public function register() {

        $action = $this->post('action');

        if ($action == 'insert') {
            $insert_data = $this->post('user');
            $this->setViewData('user', $insert_data);

            if (!$this->validation($this->validate_condition, $insert_data)) {
                $this->errors_response();
            } elseif (($errors = $this->Model_common->check_with_specific_fields_with_errors($this->table, $this->existance_condition, $insert_data))) {
                $this->setErrors($errors);
                $this->errors_response();
            } else {
                $insert_data['password'] = md5($insert_data['password']);
                $insert_data['created_on'] = date('y-m-d H:i:s');
                $id = $this->Model_driver->register($insert_data);
                $this->redirectON(admin_base_url('driver/lists'), "The driver successfully registered.");
            }
        }

        $this->setViewData('panel_heading', "Driver info");
        $this->setViewData('action', "insert");
        $this->render_view('register', 'driver');
    }

    public function lists() {
        $this->setViewData('box_header', "Driver list");
        $this->setViewData('list', $this->Model_driver->get_list());
        $this->setViewData('show_search', true);
        $this->setViewData('search_param', array(
            'search_type' => 'driver'
        ));
        $this->setViewData('list_headers', array(
            'full_name' => 'Fullname',
            'email_id' => 'Email ID',
            'phone_no' => 'Phone no',
            'status' => 'Status',
            'action' => 'Action',
        ));
        $this->get_formated_list();
        $this->render_view('list', 'common');
    }

    private function get_formated_list() {
        $list = $this->getViewData('list');
        if ($list) {
            foreach ($list as $key => $user) {
                $list[$key]['action'] = '';
                $list[$key]['action'] .= $this->load->view('common/action-bar', $user, true);
                $list[$key]['status'] = ($user['status']) ? '<span class="label label-success">Active</span>' : '<span class="label label-important">Inactive</span>';
            }
            $this->setViewData('list', $list);
        }
    }

    public function update($id = '') {
        $this->setViewData('action', 'update');
        $user = $this->Model_driver->get_driver($id);
        $action = $this->post('action');
        if (!$id) {
            show_error('The driver id not defined.');
        }
        if ($action == 'update') {
            $insert_data = $user = $this->post('user');
            $condition = $this->dataArrayUnsetter($this->validate_condition, array('password'));

            if (!$this->validation($condition, $insert_data)) {
                $this->errors_response();
            } elseif (($errors = $this->Model_common->check_with_specific_fields_with_errors($this->table, $this->existance_condition, $insert_data,db_condition_maker(db_field_concat($this->table, 'id'), $id, '!=')))) {
                $this->setErrors($errors);
                $this->errors_response();
            } else {
                $this->Model_driver->update($this->post('user'), $id);
                $this->redirectTO(admin_base_url('driver/update/' . $id), "The driver successfully updated.");
            }
        }
        $this->setViewData('user', $user);
        $this->setViewData('panel_heading', "Driver info");
        $this->render_view('register', 'driver');
    }

    public function view($id) {
        $this->setViewData('panel_heading', "Driver info");
        $user = $this->Model_driver->get_driver($id);
        if (!$id || !$user) {
            show_error('Invalid driver ID.');
        }
        $user['status'] = ($user['status']) ? '<span class="label label-success">Active</span>' : '<span class="label label-important">Inactive</span>';
        $user['created_on'] = date('Y-m-d', strtotime($user['created_on']));

        $this->setViewData('user', $user);
        $this->render_view('view', 'driver');
    }

    public function delete($id) {
        $user = $this->Model_driver->get_driver($id);
        if (!$id || !$user) {
            show_error('Invalid driver ID.');
        }

        $this->Model_driver->delete($id);
        $this->redirectTO(admin_base_url('lists'), "The driver successfully deleted.");
    }

//    function do_upload() {
//        
//        $config['upload_path'] = './uploads/';
//        $config['allowed_types'] = 'gif|jpg|png';
//
//
//        $this->load->library('upload', $config);
//        $name = 'profile_pic';
//        if (!$this->upload->do_upload($name)) {
//            $error = array('error' => $this->upload->display_errors());
//            print_r($error);
//        } else {
//           
//            $data = array('upload_data' => $this->upload->data());
//             print_r($data);
//        }
//    }
}
