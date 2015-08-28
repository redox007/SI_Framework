<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AjaxController
 *
 * @author Suchandan
 * @property Model_defination $Model_defination Model_defination
 */
class AjaxController extends MY_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->getUserdata('logged_in')) {
            die(0);
        }
    }

    public function index() {
        $action = $this->request('action');
        if (!$action) {
            die('0');
        } else {
            $this->{$action}();
        }
    }

    private function generate_coupon() {

        $this->loadS_model('discount');
        $token = random_token(6);
        $is_exists = $this->Model_discount->get_discount($token);
        if ($is_exists) {
            $token = $this->generate_coupon();
        }
        die(strtoupper($token));
    }

    private function register_city() {
        $country = $this->request('city');
        $this->loadS_model('defination');
        $id = $this->request('id');
        if ($id) {
            $this->Model_defination->update_place($id, $country, 'city');
            $this->setData('updated_data', $this->Model_defination->get_cities($id));
            $this->setData('type', 'city');
            $this->setData('id', $id);
            $this->set_success_responce("The city successfully updated.");
            return;
        }
        $cid = $this->Model_defination->register_place($country, 'city');
        $this->setData('city_id', $cid);
        $this->set_success_responce("The city successfully registered.");
    }

    private function register_country() {
        $country = $this->request('country');
        $this->loadS_model('defination');
        $id = $this->request('id');
        if ($id) {
            $this->Model_defination->update_place($id, $country, 'country');
            $this->setData('updated_data', $this->Model_defination->get_countries($id));
            $this->setData('type', 'country');
            $this->setData('id', $id);
            $this->set_success_responce("The country successfully updated.");
            return;
        }
        $cid = $this->Model_defination->register_place($country, 'country');
        $this->setData('country_id', $cid);
        $this->set_success_responce("The country successfully registered.");
    }

    private function register_state() {
        $country = $this->request('state');
        $this->loadS_model('defination');
        $id = $this->request('id');
        if ($id) {
            $this->Model_defination->update_place($id, $country, 'state');
            $this->setData('updated_data', $this->Model_defination->get_states($id));
            $this->setData('type', 'state');
            $this->setData('id', $id);
            $this->set_success_responce("The state successfully updated.");
            return;
        }
        $cid = $this->Model_defination->register_place($country, 'state');
        $this->setData('state_id', $cid);
        $this->set_success_responce("The state successfully registered.");
    }

    private function get_state_country() {
        $required = $this->request('required');
        $extra = '';
        if ($required) {
            $extra = 'required=""';
        }
        $this->loadS_model('defination');
        $states = $this->Model_defination->get_states();
        $countries = $this->Model_defination->get_countries();

        $this->setData('countries', $countries);
        $this->setData('states', $states);
        $this->setData('country_html', form_dropdown('state[country]', key_value_pair($countries, 'id', 'name'), '', $extra));
        $this->setData('states_html', form_dropdown('city[state]', key_value_pair($states, 'id', 'name'), '', $extra));
        $this->set_success_responce('done');
    }

    public function update_place() {

        $this->loadS_model('defination');

        $type = $this->request('type');
        $id = $this->request('id');
        $data = $this->Model_defination->get_place_data($type, $id);
        $data['panel_heading_' . $type] = ucfirst($type) . ' info';

        $data['states'] = key_value_pair($this->Model_defination->get_states(), 'id', 'name');
        $data['countries'] = key_value_pair($this->Model_defination->get_countries(), 'id', 'name');

        $this->load_view($type, 'defination', $data);
    }

    public function delete_place() {

        $this->loadS_model('defination');

        $type = $this->request('type');
        $id = $this->request('id');
        if (!$type || !$id) {
            $this->_die("Type or id not specified.");
        }
        $this->Model_defination->delete_place($type, $id);
        $this->set_success_responce("The {$type} is deleted successfully.");
    }

    public function save_spltype() {
        $data['name'] = $this->request('name');
        $id = $this->request('spl_id');
        $this->loadS_model('defination');
        $this->Model_defination->updateRecord(TBL_SPECIAL_TYPE_MASTER, array('id' => $id), $data);
        $this->setData('name', $data['name']);
        $this->set_success_responce("The special type is successfully updated.");
    }

    public function save_timeframe() {
        $data = $send_data = $this->request('time');
        
        $data['start'] = $data['start'].':00:00';
        $data['end'] = $data['end'].':00:00';
        
        $id = $this->request('time_id');
        $this->loadS_model('defination');
        $this->Model_defination->updateRecord(TBL_TIMEFRAME_MASTER, array('id' => $id), $data);
        $this->setData('time', $send_data);
        $this->set_success_responce("The timeframe is successfully updated.");
    }

    public function delete_ton() {
        $id = $this->request('id');

        $this->loadS_model('defination');
        $this->Model_defination->deleteRecord(TBL_TONNAGE_MASTER, array('id' => $id));

        $this->set_success_responce("The tonnage is successfully deleted.");
    }
    public function get_passengers() {
        $this->loadS_model('passenger');
        $list = $this->Model_passenger->get_list(array('id as data','full_name as value'));
        $this->setData('query',$this->request('s'));
        $this->setData('suggestions',$list);
        $this->set_success_responce();
    }

}
