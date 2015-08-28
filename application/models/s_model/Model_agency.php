<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_agency
 *
 * @author Suchandan
 */
class Model_agency extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->setTable(TBL_AGENCIES);
    }

    public function register($data) {
        return $this->insertRecord(TBL_AGENCIES, $data);
    }

    public function update($id, $data) {
        return $this->updateRecord(TBL_AGENCIES, array('id' => $id), $data);
    }

    public function delete($id) {
        return $this->deleteRecord(TBL_AGENCIES, array('id' => $id));
    }

    public function get_agency($id){
        $agency = $this->get_list(false,$id);
        return $agency ? $agency[0] : $agency;
    }
    public function get_list($fields = array(),$id = '') {
        $where = array();
        if (!$fields) {
            $fields = array(
                'id',
                'name',
                'registration_no',
                'owner_name',
                'owner_contact_no',
                'city',
                'pin_code',
                'status',
                'created_on'
            );
        }
        $s = trim( $this->requet('s') );
        $stype = $this->requet('search_type');
        if ($s && $stype == 'agency') {
            $this->setWhereStringArray(array(
                "name LIKE '%$s%'",
                "registration_no LIKE '%$s%'",
                "owner_contact_no LIKE '%$s%'",
                "owner_name LIKE '%$s%'"
                    ), 'OR', true);
        } 
        if($id){
            $fields = array('*');
            $this->setWhere('id',$id);
        }
        return $this->setFields($fields)
                        ->setWhereGroup($where)
                        ->orderBy('id')
                        ->execute()->results();
    }

}
