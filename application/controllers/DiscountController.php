<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DiscountController
 *
 * @author Suchandan
 */
class DiscountController extends MY_Controller {

    public function __construct() {
        parent::__construct();

        $this->auth(admin_base_url('login'));
        $this->loadS_model('discount');
        $this->setViewData('title', "Discount manage");
        $this->setViewData('discount', array());
    }

    public function register() {

        $action = $this->post('action');

        if ($action == 'insert') {

            $insert_data = $this->post('discount');
            $this->setViewData('discount', $insert_data);

            $condition = array(
                'coupon_code' => "Please provide coupon code.",
                'validity' => "Please provide validity."
            );

            $field_check = array(
                'coupon_code' => "The coupon code already exists."
            );

            if (!$this->validation($condition, $insert_data)) {
                $this->errors_response();
            } elseif (!$this->request_array('discount_persent', $insert_data) && !$this->request_array('discount_amount', $insert_data)) {
                $this->errors_response("Give either persentage or amount of this coupon.");
            } elseif (($errors = $this->Model_common->check_with_specific_fields_with_errors(TBL_DISCOUNT, $field_check, $insert_data))) {
                $this->setErrors($errors);
                $this->errors_response();
            } else {
                $insert_data['created_on'] = date('y-m-d H:i:s');
                $id = $this->Model_discount->register($insert_data);
                $this->redirectON(admin_base_url('discount/lists'), "The discount successfully registered.");
            }
        }

        $this->setViewData('panel_heading', "Discount info");
        $this->setViewData('action', "insert");
        $this->render_view('register', 'discount');
    }

    public function lists() {
        $this->setViewData('box_header', "Discount list");
        $this->setViewData('list', $this->Model_discount->get_list());
        $this->setViewData('list_headers', $this->get_list_view_fields());
        $this->get_formated_list();
        $this->render_view('list', 'common');
    }

    private function get_formated_list() {
        $list = $this->getViewData('list');
        if ($list) {
            foreach ($list as $key => $discount) {
                $list[$key]['action'] = '';
                $list[$key]['action'] .= $this->load->view('common/action-bar', $discount, true);
//                $list[$key]['status'] = ($discount['status']) ? '<span class="label label-success">Active</span>' : '<span class="label label-important">Inactive</span>';
            }
            $this->setViewData('list', $list);
        }
    }

    public function update($id = '') {
        $this->setViewData('action', 'update');
        $discount = $this->Model_discount->get_discount($id);
        $action = $this->post('action');
        if (!$id) {
            show_error('The discount id not defined.');
        }
        if ($action == 'update') {
            $discount = $this->post('discount');

            $condition = array(
                'coupon_code' => "Please provide coupon code.",
                'validity' => "Please provide validity."
            );

            $field_check = array(
                'coupon_code' => "The coupon code already exists."
            );


            if (!$this->validation($condition, $this->post('discount'))) {
                $this->errors_response();
                $this->setViewData('discount', $this->post('discount'));
            } elseif (!$this->request_array('discount_persent', $discount) && !$this->request_array('discount_amount', $discount)) {
                $this->errors_response("Give either discount persentage or discount amount of this coupon.");
            } elseif (($errors = $this->Model_common->check_with_specific_fields_with_errors(
                    TBL_DISCOUNT, $field_check, $discount, db_condition_maker(db_field_concat(TBL_DISCOUNT, 'id'), $id, '!='))
                    )
            ) {
                $this->setErrors($errors);
                $this->errors_response();
            } else {
                $this->Model_discount->update($id, $this->post('discount'));
                $this->redirectTO(admin_base_url('discount/update/' . $id), "The discount successfully updated.");
            }
        }
        $this->setViewData('discount', $discount);
        $this->setViewData('panel_heading', "Discount info");
        $this->render_view('register', 'discount');
    }

    public function view($id) {
        $this->setViewData('panel_heading', "Discount info");
        $discount = $this->Model_discount->get_discount($id);
        if (!$id || !$discount) {
            show_error('Invalid discount ID.');
        }
        $discount['created_on'] = date('Y-m-d', strtotime($discount['created_on']));
//        debug($discount);
        $this->setViewData('view_keys', $this->get_view_fields());
        $this->setViewData('view_data', $discount);
        $this->render_view('view', 'discount');
    }

    public function delete($id) {
        $discount = $this->Model_discount->get_discount($id);
        if (!$id || !$discount) {
            show_error('Invalid discount ID.');
        }

        $this->Model_discount->delete($id);
        $this->redirectTO(admin_base_url('lists'), "The discount successfully deleted.");
    }

    private function get_view_fields() {
        $view_array = $this->get_list_view_fields();
        unset($view_array['action']);
        $view_array['used'] = "How many times used";
        return $view_array;
    }

    private function get_list_view_fields() {
        return array(
            'id' => 'Discount ID',
            'coupon_code' => 'Code',
            'discount_persent' => 'Amount',
            'created_on' => 'Date',
            'action' => "Action"
        );
    }

}
