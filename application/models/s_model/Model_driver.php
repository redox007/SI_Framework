<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_driver
 *
 * @author Suchandan
 */
class Model_driver extends MY_Model {

    public $table;

    public function __construct() {
        parent::__construct();
        $this->setTable(TBL_DRIVER);
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
        return $this->insertRecord(TBL_DRIVER, $user);
    }

    public function get_list($fields = array()) {
        $this->setTable(TBL_DRIVER);


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

        $s = trim( $this->requet('s') );
        $stype = $this->requet('search_type');
        if ($s && $stype == 'driver') {
            $this->setWhereStringArray(array(
                "full_name LIKE '%$s%'",
                "first_name LIKE '%$s%'",
                "last_name LIKE '%$s%'",
                "phone_no LIKE '%$s%'",
                "license_no LIKE '%$s%'",
                "adhar_card_no LIKE '%$s%'",
                "email_id LIKE '%$s%'"
                    ), 'OR', true);
        }
        return $this->setFields($fields)
                        ->setWhereGroup($where)
                        ->orderBy('id')
                        ->execute()->results();
    }

    public function login($user_id, $password) {
        return $this->setWhereGroupString(array(
                    'phone_no' => $user_id,
                    'email_id' => $user_id
                        ), 'OR')->setWhere('password', $password)->execute()->result();
    }

    public function update($user, $id) {
        $data = unset_if_empty($user, array('email_id', 'phone_no', 'full_name'));
        return $this->updateRecord(TBL_DRIVER, array('id' => $id), $data);
    }

    public function get_driver($id, $fields = array()) {
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

    public function get_driver_vehical($id) {
        return $this->setTable(array(TBL_DRIVER_VEHICALS => 'dv'))
                        ->setFields(array(
                            "vh.id as vehical_id",
                            "vh.*",
                            "dv.driver_id as driver_id",
                            "dv.driver_id as driver_id",
                            "dv.date_from",
                            "dv.date_to"
                        ))
                        ->setJoin(array(TBL_VEHICALS => 'vh'), array('dv.vehical_id' => 'vh.id', 'dv.is_current' => '1'))
                        ->setJoin(array(TBL_DRIVER => 'drv'), array('drv.id' => 'dv.driver_id'))
                        ->setWhere('dv.driver_id', $id)
                        ->execute()->result();
    }

    public function rate_driver($driver_id, $passenger_id, $rating, $order_no, $booking_id) {

        $this->updateRecord(TBL_ORDERS, array('id' => $order_no), array('driver_rating' => $rating));
        $driver_rating_data = $this->getData(TBL_DRIVER_RATING, array('driver_id' => $driver_id));

        $total_rating_no = 1;
        $total_rating = $rating;
        $avg_rating = $rating;

        if ($driver_rating_data) {
            $total_rating_no = $driver_rating_data['total_rating_no'] + 1;
            $total_rating = $driver_rating_data['total_rating'] + $rating;
            $avg_rating = two_decimal($total_rating / $total_rating_no);
        }
        $order_id = $order_no;
        $rating_data = compact('total_rating_no', 'total_rating', 'avg_rating', 'order_id', 'booking_id', 'driver_id');

        return $this->insertRecord(TBL_DRIVER_RATING, $rating_data);
//        return $this->manage(TBL_DRIVER_RATING, $rating_data, array('driver_id' => $driver_id));
    }

    public function delete($id) {
        return $this->deleteRecord(TBL_DRIVER, array('id' => $id));
    }

    public function get_driver_payment_details($driver_id) {

        $this->setTable(TBL_DRIVER_PAYMENT);

        $this->setField('SUM(amount_due) as amount_due', true, 0);
        $this->setField('SUM(amount_paid) as amount_paid', true, 0);
        $this->setField('SUM(amount_total) as amount_total', true, 0);

        $order_id = $this->requet('order_id');
        $booking_id = $this->requet('booking_id');

        if ($driver_id) {
            $this->setWhere('driver_id', $driver_id);
        }
        if ($order_id) {
            $this->setWhere('order_id', $order_id);
        }
        if ($booking_id) {
            $this->setWhere('booking_id', $booking_id);
        }

        return $this->get_result();
    }
    
    public function get_driver_booked_dates($driver_id) {
        $dates = $this->setTable(TBL_ORDERS)
                ->setField('pickup_date')
                ->setWhereGroup('driver_no', $driver_id)
                ->setWhereString('pickup_date > CURDATE()')
                ->get_results();
        $d = array();
        if($dates){
            foreach($dates as $date){
                $d[] = $date['pickup_date'];
            }
        }
        return $d;
    }

}
