<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DefinationController
 *
 * @author Suchandan
 * @property Model_defination $Model_defination Model_defination
 */
class DefinationController extends MY_Controller {

    public function __construct() {

        parent::__construct();

        $this->auth(admin_base_url('login'));

        $this->loadS_model('defination');
        $this->setViewData('title', "Definations");
        $this->setViewData('view_data', array());
    }

    public function places() {

        $this->setViewData('panel_heading_country', "Country info");
        $this->setViewData('panel_heading_state', "State info");
        $this->setViewData('panel_heading_city', "City info");

        $this->setViewData('action', "insert");

        $this->setViewData('states', key_value_pair($this->Model_defination->get_states(), 'id', 'name'));
        $this->setViewData('countries', key_value_pair($this->Model_defination->get_countries(), 'id', 'name'));
        $this->add_auto_load_script('place', true);
        $this->render_view('country-city-state', 'defination');
    }

    public function listplaces() {

        $cities = array(
            'object' => 'city',
            'box_header' => "List cities",
            'list_headers' => array(
                'name' => 'Name',
                'country_name' => 'Country',
                'state_name' => 'State',
                'action' => 'Action'
            ),
            'js_sort' => true,
            'list' => $this->get_formated_list($this->Model_defination->get_cities(), 'city')
        );
        $states = array(
            'object' => 'state',
            'box_header' => "List States",
            'list_headers' => array(
                'name' => 'Name',
                'country_name' => 'Country',
                'action' => 'Action'
            ),
            'js_sort' => true,
            'list' => $this->get_formated_list($this->Model_defination->get_states(), 'state')
        );
//        $countries = array(
//            'object' => 'country',
//            'box_header' => "List country",
//            'list_headers' => array(
//                'name' => 'Name',
//                'code' => 'Code',
//                'action' => 'Action'
//            ),
//            'js_sort' => true,
//            'list' => $this->get_formated_list($this->Model_defination->get_countries(), 'country')
//        );

        $this->setViewData('city_list', $cities);
//        $this->setViewData('country_list', $countries);
        $this->setViewData('state_list', $states);
        $this->add_auto_load_script('place', true);
        $this->render_view('list-place', 'defination');
    }

    private function get_formated_list($list, $type = '') {
        if ($list) {
            foreach ($list as $key => $data) {
                $list[$key]['action'] = '';
                $list[$key]['action'] .= '
                        <a class="btn btn-info ajax-edit" data-object-type="' . $type . '" data-object-id="' . $data['id'] . '" href="' . base_url('ajax?action=update_place&type=' . $type . '&id=' . $data['id']) . '">
                            <i class="halflings-icon white edit"></i>  
                        </a>
                        <a class="btn btn-danger ajax-delete" data-object-type="' . $type . '" data-object-id="' . $data['id'] . '"  href="' . base_url('ajax?action=delete_place&type=' . $type . '&id=' . $data['id']) . '">
                            <i class="halflings-icon white trash"></i> 
                        </a>';
            }
        }
        return $list;
    }

    public function ratecard($id = '') {

        $this->loadS_model('common');
        $this->loadS_model('defination');

        $this->setViewData('box_header', "Ratecard");
        $this->setViewData('object', "ratecard");
        $this->setViewData('rate_card', array());
        $this->setViewData('action', 'insert');
        if ($id) {
            $this->setViewData('action', 'update');
        }
        $this->setViewData('list_headers', array(
            "city" => 'City',
            "special_type" => 'Special Type',
            "size" => 'Tonnage',
            "mode" => 'Mode',
            "mode_unit" => 'Unit',
            "mode_unit_cost" => 'cost',
            "waiting_hour_unit" => 'Wating hour',
            "wating_hour_cost" => 'Wating hour cost',
            "free_wating_time" => 'Free wating time',
            "km_limit" => 'KM limit',
            "additional_km_unit" => 'Additional KM unit',
            "additional_km_cost" => 'Additional KM unit cost',
            "special_type_multiplier" => 'Special type multiplier',
            "labour_rate" => 'Labour rate',
            "action" => 'Action'
        ));
        if ($this->request('action') == 'insert') {
            $rate_card = $this->request('rate_card');
            if ($this->Model_common->getData(TBL_RATE_CARD, array_make(array('city', 'special_type', 'size', 'mode'), $rate_card))) {
                $this->updateRecord(TBL_RATE_CARD, array('id' => $id), $rate_card);
                $this->set_success_responce("The rate card has been updated.");
                return;
            }
            $this->insertRecord(TBL_RATE_CARD, $rate_card);
            $this->set_success_responce("The rate card has been saved.");
            return;
        } elseif ($this->request('action') == 'update') {
            $rate_card = $this->request('rate_card');
            $this->updateRecord(TBL_RATE_CARD, array('id' => $id), $rate_card);
            $this->set_success_responce("The rate card has been updated.");
            return;
        }
        $this->process_ratecard($id);
//        $this->debug_view(true);
        $this->render_view('ratecard', 'defination');
    }

    private function process_ratecard($id = '') {

        $action = 'insert';
        if ($id) {
            $rate_cards = $this->Model_common->getData(TBL_RATE_CARD, array('id' => $id));
            $action = 'update';
        }

        $rate_card_array = array();

        $cities = $this->Model_defination->get_cities();
        $rate_card_array['city'] = form_dropdown('rate_card[city]', key_value_pair($cities, 'id', 'name', array('' => "Select city")), (isset($rate_cards['city']) ? $rate_cards['city'] : ''), 'required');

        $cities = $this->Model_defination->getDatas(TBL_SPECIAL_TYPE_MASTER);
        $rate_card_array['special_type'] = form_dropdown('rate_card[special_type]', key_value_pair($cities, 'id', 'name', array('' => "Select special type")), (isset($rate_cards['special_type']) ? $rate_cards['special_type'] : ''), 'required');

        $cities = $this->Model_defination->getDatas(TBL_TONNAGE_MASTER);
        $rate_card_array['size'] = form_dropdown('rate_card[size]', key_value_pair($cities, 'id', 'name', array('' => "Select size")), (isset($rate_cards['size']) ? $rate_cards['size'] : ''), 'required');

        $rate_card_array['mode'] = form_dropdown('rate_card[mode]', array(1 => "KM Based"), (isset($rate_cards['mode']) ? $rate_cards['mode'] : ''), 'required');
        $rate_card_array['mode_unit'] = form_input('rate_card[mode_unit]', (isset($rate_cards['mode_unit']) ? $rate_cards['mode_unit'] : ''), '');
        $rate_card_array['mode_unit_cost'] = form_input('rate_card[mode_unit_cost]', (isset($rate_cards['mode_unit_cost']) ? $rate_cards['mode_unit_cost'] : ''), '');
        $rate_card_array['waiting_hour_unit'] = form_input('rate_card[waiting_hour_unit]', (isset($rate_cards['waiting_hour_unit']) ? $rate_cards['waiting_hour_unit'] : ''), '');
        $rate_card_array['wating_hour_cost'] = form_input('rate_card[wating_hour_cost]', (isset($rate_cards['wating_hour_cost']) ? $rate_cards['wating_hour_cost'] : ''), '');
        $rate_card_array['free_wating_time'] = form_input('rate_card[free_wating_time]', (isset($rate_cards['free_wating_time']) ? $rate_cards['free_wating_time'] : ''), '');
        $rate_card_array['km_limit'] = form_input('rate_card[km_limit]', (isset($rate_cards['km_limit']) ? $rate_cards['km_limit'] : ''), '');
        $rate_card_array['additional_km_unit'] = form_input('rate_card[additional_km_unit]', (isset($rate_cards['additional_km_unit']) ? $rate_cards['additional_km_unit'] : ''), '');
        $rate_card_array['additional_km_cost'] = form_input('rate_card[additional_km_cost]', (isset($rate_cards['additional_km_cost']) ? $rate_cards['additional_km_cost'] : ''), '');
        $rate_card_array['special_type_multiplier'] = form_input('rate_card[special_type_multiplier]', (isset($rate_cards['special_type_multiplier']) ? $rate_cards['special_type_multiplier'] : ''), '');
        $rate_card_array['labour_rate'] = form_input('rate_card[labour_rate]', (isset($rate_cards['labour_rate']) ? $rate_cards['labour_rate'] : ''), '');

        $rate_card_array['action'] = '';
        $rate_card_array['action'] .= form_hidden('action', $action, '');
        $rate_card_array['action'] .= form_submit('submit', 'Save', 'class="btn btn-primary"');

        $this->setViewData('rate_card', $rate_card_array);
    }

    public function ratecard_list() {
        $this->loadS_model('defination');
        $this->setViewData('box_header', "Rate Crad list");
        $this->setViewData('object', "ratecard");
        $this->setViewData('list', $this->Model_defination->get_rate_card_list());
        $this->setViewData('list_headers', array(
            "city_name" => 'City',
            "spl_type_name" => 'Special Type',
            "size_name" => 'Tonnage',
            "mode" => 'Mode',
            "mode_unit" => 'Unit',
            "mode_unit_cost" => 'cost',
            "waiting_hour_unit" => 'Wt. hour unit',
            "wating_hour_cost" => 'Wt. hour cost',
            "free_wating_time" => 'Free wt. time',
            "km_limit" => 'KM limit',
            "additional_km_unit" => 'Addl KM unit',
            "additional_km_cost" => 'Addl KM unit cost',
            "special_type_multiplier" => 'Spl type multiplier',
            "labour_rate" => 'Labour rate',
            "action" => 'Action'
        ));

        $this->get_formated_rate_card_list();
        $this->render_view('list', 'common');
    }

    private function get_formated_rate_card_list() {
        $list = $this->getViewData('list');
        if ($list) {
            foreach ($list as $key => $user) {
                $list[$key]['action'] = '';
                $list[$key]['action'] .= $this->load->view('common/action-bar', array_merge($user, array(
                    'no_view' => true,
                    'edit_url' => "ratecard/{$user['id']}",
                    'delete_url' => "rate_card_delete/{$user['id']}",
                    'no_view' => true,
                        )), true);
//                $list[$key]['status'] = ($user['status']) ? '<span class="label label-success">Active</span>' : '<span class="label label-important">Inactive</span>';
            }
            $this->setViewData('list', $list);
        }
    }

    public function rate_card_delete($id = '') {
        if ($id) {
            $this->loadS_model('defination');
            $this->Model_defination->deleteRecord(TBL_RATE_CARD, array('id' => $id));
        }
        $this->redirectTO(admin_base_url('define/ratecard_list'), "The rate card successfully deleted.");
    }

    public function special_type() {

        $this->setViewData('box_header', "Special Type");
        $this->setViewData('object', "special-type");
        $this->setViewData('box_id', "special-type-box");
        $this->setViewData('list_headers', array(
            'id' => 'ID',
            'name' => 'Name',
            'action' => 'Action'
        ));

        $this->loadS_model('defination');
        $this->setViewData('list', $this->Model_defination->getDatas(TBL_SPECIAL_TYPE_MASTER));
        $this->get_formated_spl_type_list();
        $this->add_auto_load_script('special_type', true);
        $this->render_view('list', 'common');
    }

    private function get_formated_spl_type_list() {

        $list = $this->getViewData('list');
        if ($list) {
            foreach ($list as $key => $user) {
                $list[$key]['action'] = '';
                $list[$key]['name'] = '<span class="spl-name">' . $user['name'] . '</span>';
                $list[$key]['name'] .= form_input('spl_name', $user['name'], 'class="hideme"');
                $list[$key]['action'] .= $this->load->view('common/action-bar', array_merge($user, array(
                    'no_view' => true,
                    'no_delete' => true,
                    'edit_url' => "#",
                    'delete_url' => "#",
                    'save_me' => true,
                    'save_class' => 'hideme',
                    'save_url' => base_url('ajax/save_spltype'),
                    'cancel_me' => true,
                    'cancel_class' => 'hideme',
                    'cancel_url' => '#'
                        )), true);
            }
            $this->setViewData('list', $list);
        }
    }

    public function timeframes() {

        $this->setViewData('box_header', "Timeframe");
        $this->setViewData('object', "timeframe");
        $this->setViewData('box_id', "timeframe-box");
        $this->setViewData('list_headers', array(
            'id' => 'ID',
            'start' => 'Start (Hr)',
            'end' => 'End (Hr)',
            'discount' => 'Discount',
            'action' => 'Action'
        ));

        $this->loadS_model('defination');
        $this->setViewData('list', $this->Model_defination->getDatas(TBL_TIMEFRAME_MASTER));
        $this->get_formated_timeframes_list();
        $this->add_auto_load_script('timeframe', true);
        $this->render_view('list', 'common');
    }

    private function get_formated_timeframes_list() {

        $list = $this->getViewData('list');
        if ($list) {
            foreach ($list as $key => $user) {
                $list[$key]['action'] = '';
//                debug($user);
                $list[$key]['start'] = '<span class="time-start htvalue">' . date('h', strtotime($user['start'])) . '</span>';
                $list[$key]['start'] .= form_input('time[start]', date('h', strtotime($user['start'])), 'class="hideme inputter"');

                $list[$key]['end'] = '<span class="time-end htvalue">' . date('h', strtotime($user['end'])) . '</span>';
                $list[$key]['end'] .= form_input('time[end]', date('h', strtotime($user['end'])), 'class="hideme inputter"');

                $list[$key]['discount'] = '<span class="time-discount htvalue">' . $user['discount'] . '</span>';
                $list[$key]['discount'] .= form_input('time[discount]', $user['discount'], 'class="hideme inputter"');

                $list[$key]['action'] .= $this->load->view('common/action-bar', array_merge($user, array(
                    'no_view' => true,
                    'no_delete' => true,
                    'edit_url' => "#",
                    'delete_url' => "#",
                    'save_me' => true,
                    'save_class' => 'hideme',
                    'save_url' => base_url('ajax/save_timeframe'),
                    'cancel_me' => true,
                    'cancel_class' => 'hideme',
                    'cancel_url' => '#'
                        )), true);
            }
            $this->setViewData('list', $list);
        }
    }

    public function tonnege() {

        $this->setViewData('box_header', "Tonnege");
        $this->setViewData('object', "tonege");
        $this->setViewData('box_id', "tonege-box");
        $this->setViewData('action_url', '');

        $this->loadS_model('defination');

        if ($this->request('submit_tonnege')) {
            $ton = $this->request('tonnege');
            $name = "{$ton['min']}-{$ton['max']}";
            $id = $this->Model_defination->insertRecord(TBL_TONNAGE_MASTER, array('name' => $name));
            $this->setData('object', array('id' => $id, 'name' => $name));
            $this->set_success_responce("The tonnege successfully saved.");
            return;
        }

        $key_header = $object_data = array(
            'min' => 'Min',
            'max' => 'Max',
            'action' => 'Action',
        );
        $object_data['min'] = form_number('tonnege[min]', '');
        $object_data['max'] = form_number('tonnege[max]', '');
        $object_data['action'] = form_submit('sbmit', 'Save', 'class="btn btn-primary"') . form_hidden('submit_tonnege', 1);

        $this->setViewData('key_headers', $key_header);

        $this->setViewData('list_headers', array(
            'id' => 'ID',
            'name' => 'Name',
            'action' => "Action"
        ));
        $this->setViewData('object_data', $object_data);

        $this->loadS_model('defination');

        $this->setViewData('list', $this->Model_defination->getDatas(TBL_TONNAGE_MASTER));
        $this->add_auto_load_script('tonnage', true);
        $this->get_formated_tonnage();
        $this->render_view(array('register-template' => 'common', 'list' => 'common'));
    }

    private function get_formated_tonnage() {

        $list = $this->getViewData('list');
        if ($list) {
            foreach ($list as $key => $user) {
                $list[$key]['action'] = '';
                $list[$key]['action'] .= $this->load->view('common/action-bar', array_merge($user, array(
                    'no_view' => true,
                    'no_edit' => true,
                    'delete_url' => base_url('ajax/delete_ton?id=' . $user['id'])
                        )), true);
            }
            $this->setViewData('list', $list);
        }
    }

}
