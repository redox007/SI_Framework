<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_payment
 *
 * @author Suchandan
 */
class Model_payment extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function create_payment($data) {
        return $this->insertRecord(TBL_PAYMENTS, $data);
    }

    public function get_rate_card($cred = array()) {
        if(!$cred) return $cred;
        return $this->setTable(TBL_RATE_CARD)
                        ->setWhereGroup($cred)
                        ->get_result();
    }

}
