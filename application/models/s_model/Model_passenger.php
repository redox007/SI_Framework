<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_passenger
 *
 * @author Suchandan
 */
class Model_passenger extends MY_Model {

    public $table;

    public function __construct() {
        parent::__construct();
        $this->setTable(TBL_PASSENGER);
        $this->table = $this->table();
    }

    public function register($user) {
        $euser = $this->setWhereGroupString(array(
                    'phone_no' => $user['phone_no'],
                    'email_id' => $user['email_id']
                        ), 'OR')->execute()->result();
        if ($euser) {
            return false;
        }
        return $this->insertRecord(TBL_PASSENGER, $user);
    }

    public function login($user_id, $password) {
        return $this->setWhereGroupString(array(
                    'phone_no' => $user_id,
                    'email_id' => $user_id
                        ), 'OR')->setWhere('password', $password)->execute()->result();
    }

    public function update($user, $id) {
        $data = unset_if_empty($user, array('email_id', 'phone_no', 'full_name'));
        return $this->updateRecord(TBL_PASSENGER, array('id' => $id), $data);
    }

    public function get_passenger($id, $fields = array()) {

        if ($fields) {
            $this->setFields($fields);
        }
        if (is_array($id)) {
            return $this->setWhereGroup($id)->execute()->result();
        }
        return $this->setWhereGroupString(array(
                    'phone_no' => $id,
                    'email_id' => $id,
                    'id' => $id
                        ), 'OR')->execute()->result();
    }

    public function add_fevorite($data) {
        return $this->insertRecord(TBL_FEVORITE_LOCATION, $data);
    }

    public function get_fevo_locations($passenger_id) {
        return $this->getDatas(TBL_FEVORITE_LOCATION, array('passenger_id' => $passenger_id));
    }

    public function get_list($fields = array()) {
//        $this->show_query();
        $this->setTable(TBL_PASSENGER);
        $where = array();
        if (!$fields) {
            $fields = array(
                'id',
                'full_name',
                'phone_no',
                'email_id',
                'reffer_code',
                'created_on',
                'modified_on',
                'status'
            );
        }
        $s = $this->requet('s');
        if ($s) {
            $this->setWhereStringArray(array(
                "full_name LIKE '%$s%'",
                "phone_no LIKE '%$s%'",
                "email_id LIKE '%$s%'"
                    ), 'OR',true);
        }
        return $this->setFields($fields)
                        ->setWhereGroup($where)
                        ->orderBy('id')
                        ->execute()->results();
    }

    public function delete($id) {
        return $this->deleteRecord(TBL_PASSENGER, array('id' => $id));
    }

}
