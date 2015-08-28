<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_discount
 *
 * @author Suchandan
 */
class Model_discount extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->setTable(TBL_DISCOUNT);
    }

    public function register($data) {
        return $this->insertRecord(TBL_DISCOUNT, $data);
    }

    public function update($id, $data) {
        return $this->updateRecord(TBL_DISCOUNT, array('id' => $id), $data);
    }

    public function delete($id) {
        return $this->deleteRecord(TBL_DISCOUNT, array('id' => $id));
    }

    public function get_discount($id) {
        $agency = $this->get_list(false, $id);
        return $agency ? $agency[0] : $agency;
    }

    public function get_list($fields = array(), $id = '') {
        $where = array();
        if (!$fields) {
//            $fields = array(
//                'id',
//                'coupon_code',
//                'discount_persent',
//                'created_on'
//            );
            $fields = $this->list_fields(TBL_DISCOUNT);
        }
        if ($id) {
            $fields = array('*');
            $this->setWhereGroup(array('id' => $id,'coupon_code' => $id),'OR');
        }
        return $this->setFields($fields)
                        ->orderBy('id')
                        ->execute()->results();
    }

}
