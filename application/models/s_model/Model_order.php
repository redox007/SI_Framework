<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_order
 *
 * @author Suchandan
 */
class Model_order extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function get_payments($order_id, $payment_mode = '') {
        $cond = array('order_no' => $order_id);
        if ($payment_mode) {
            $cond['payment_mode'] = $payment_mode;
        }
        $this->getDatas(TBL_PAYMENT_RECORD, $cond);
    }

    public function get_total_payments($order_id, $payment_mode = '') {

        $this->setTable(TBL_PAYMENT_RECORD)
                ->setField('SUM(paid_amount) as paid_amount',true)
                ->setField('payment_mode',true);
        if ($payment_mode) {
            $this->setWhere('payment_mode', $payment_mode);
        }
        $this->setWhere('order_id', $order_id);
        if($payment_mode){
            return $this->get_result();
        }
        return $this->get_results();
    }

}
