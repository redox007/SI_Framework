<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_defination
 *
 * @author Suchandan
 */
class Model_defination extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function register_place($data, $type = '') {
        $table = $this->get_table_name($type);
        if ($this->setTable($table)->setWhereGroup($data)->get_results()) {
            _die("This data already exists.");
        }
        return $this->insertRecord($table, $data);
    }

    public function update_place($id, $data, $type = '') {
        $table = $this->get_table_name($type);
        return $this->updateRecord($table, array('id' => $id), $data);
    }

    public function delete_place($type, $id) {
        return $this->deleteRecord($this->get_table_name($type), array('id' => $id));
    }

    public function get_table_name($type = '') {
        $table = '';
        switch ($type) {
            case 'city':$table = TBL_MASTER_CITY;
                break;
            case 'country':$table = TBL_MASTER_COUNTRY;
                break;
            case 'state':$table = TBL_MASTER_STATE;
                break;

            default:
                break;
        }
        return $table;
    }

    public function get_place_fn_name($type = '') {
        $table = '';
        switch ($type) {
            case 'city':$table = 'get_cities';
                break;
            case 'country':$table = 'get_countries';
                break;
            case 'state':$table = 'get_states';
                break;

            default:
                break;
        }
        return $table;
    }

    public function get_place_data($type = 'country', $id = '') {
        $name = $this->get_place_fn_name($type);
        return $this->{$name}($id);
    }

    public function get_countries($id = '') {
        if ($id) {
            $id = array('id' => $id);
        } else {
            $id = array();
        }
        return ($id) ? $this->getData(TBL_MASTER_COUNTRY, $id) : $this->getDatas(TBL_MASTER_COUNTRY);
    }

    public function get_states($id = '') {
        $fn_name = 'get_results';
        $this->setTable(TBL_MASTER_STATE, 'ms');
        if ($id) {
            $this->setWhere('ms.id', $id);
            $fn_name = 'get_result';
        }
        if (( $cid = $this->requet('country_id'))) {
            $this->setWhere('mc.id', $cid);
        }
        return $this->setJoin(array(TBL_MASTER_COUNTRY => 'mc'), array('mc.id' => 'ms.country'))->setFields(array(
                    'ms.*',
                    'mc.name as country_name',
                    'mc.code as country_code',
                ))->{$fn_name}();
    }

    public function get_cities($id = '') {
        $fn_name = 'get_results';
        $this->setTable(TBL_MASTER_CITY, 'mcity');
        if ($id) {
            $this->setWhere('mcity.id', $id);
            $fn_name = 'get_result';
        }
        if (( $cid = $this->requet('country_id'))) {
            $this->setWhere('mc.id', $cid);
        }
        if (( $sid = $this->requet('state_id'))) {
            $this->setWhere('ms.id', $sid);
        }
        return $this->setJoin(array(TBL_MASTER_COUNTRY => 'mc'), array('mc.id' => 'mcity.country'))
                        ->setJoin(array(TBL_MASTER_STATE => 'ms'), array('ms.id' => 'mcity.state'))
                        ->setFields(array(
                            'mcity.*',
                            'mc.name as country_name',
                            'mc.code as country_code',
                            'ms.name as state_name',
                            'ms.code as stste_code',
                        ))->{$fn_name}();
    }

    public function get_rate_card_list() {
        return $this->setTable(TBL_RATE_CARD,'rc')
                ->setFields(array(
                    'rc.*',
                    'mc.name as city_name',
                    'spm.name as spl_type_name',
                    'tm.name as size_name'
                ))
                ->setJoin(array(TBL_MASTER_CITY => 'mc'), array('mc.id' => 'rc.city'))
                ->setJoin(array(TBL_SPECIAL_TYPE_MASTER => 'spm'), array('spm.id' => 'rc.special_type'))
                ->setJoin(array(TBL_TONNAGE_MASTER => 'tm'), array('tm.id' => 'rc.size'))
                ->get_results();
    }

}
