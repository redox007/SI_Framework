<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomerController
 *
 * @author Suchandan
 */
class CustomerController extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->auth(admin_base_url('login'));
        $this->loadS_model('passenger');
        $this->setViewData('title', "Customer manage");
        $this->setViewData('user', array());
        $this->setViewData('object', 'customer');
    }

    public function register() {

        $action = $this->post('action');

        if ($action == 'insert') {
            $insert_data = $this->post('user');
            $this->setViewData('user', $insert_data);
            $condition = array(
                'phone_no' => "Please provide phone no.",
                'email_id' => "Please provide email id.",
                'password' => "Please provide password."
            );
            if (!$this->validation($condition, $insert_data)) {
                $this->errors_response();
            } elseif ($this->Model_common->check_with_fields(TBL_PASSENGER, array('phone_no' => $insert_data['phone_no']))) {
                $this->errors_response("This phone no already exists.");
            }else {
                $insert_data['password'] = md5($insert_data['password']);
                $insert_data['created_on'] = date('y-m-d H:i:s');
                $id = $this->Model_passenger->register($insert_data);
                $this->redirectTO(admin_base_url('customer/lists'), "The passenger successfully registered.");
            }
        }

        $this->setViewData('panel_heading', "Customer info");
        $this->setViewData('action', "insert");
        $this->render_view('register', 'passenger');
    }

    public function lists() {
        $this->setViewData('box_header', "Customer list");
        $this->setViewData('list', $this->Model_passenger->get_list());
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
        $action = $this->post('action');
        $user = $this->Model_passenger->get_passenger($id);
        if (!$id) {
            show_error('The passenger id not defined.');
        }
        if ($action == 'update') {
            $condition = array(
                'phone_no' => "Please provide phone no.",
                'email_id' => "Please provide email id."
            );
            if (!$this->validation($condition, $this->post('user'))) {
                $this->errors_response();
                $this->setViewData('user', $this->post('user'));
            } else {
                $this->Model_passenger->update($this->post('user'),$id);
                $this->redirectTO(admin_base_url('customer/update/'.$id), "The passenger successfully updated.");
            }
        }
        $this->setViewData('user', $user);
        $this->setViewData('panel_heading', "Customer info");
        $this->render_view('register', 'passenger');
    }

    public function view($id) {
        $this->setViewData('panel_heading', "Customer info");
        $user = $this->Model_passenger->get_passenger($id);
        if (!$id || !$user) {
            show_error('Invalid passenger ID.');
        }
        $user['status'] = ($user['status']) ? '<span class="label label-success">Active</span>' : '<span class="label label-important">Inactive</span>';
        $user['created_on'] = date('Y-m-d', strtotime($user['created_on']));

        $this->setViewData('user', $user);
        $this->render_view('view', 'passenger');
    }

    public function delete($id) {
        $user = $this->Model_passenger->get_passenger($id);
        if (!$id || !$user) {
            show_error('Invalid passenger ID.');
        }

        $this->Model_passenger->delete($id);
        $this->redirectTO(admin_base_url('customer/lists'), "The passenger successfully deleted.");
    }

}
