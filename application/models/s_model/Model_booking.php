<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_booking
 *
 * @author Suchandan
 */
class Model_booking extends MY_Model {

    public $only_bookings = false;
    public $extra_condition = '';

    public function __construct() {
        parent::__construct();
        $this->setTable(array(TBL_BOOKING => 'book'));
    }

    public function register($order) {
        return $this->insertRecord(TBL_BOOKING, $order);
    }

    public function update($id, $order = array()) {
        return $this->updateRecord(TBL_BOOKING, array('id' => $id), $order);
    }

    public function update_order($order_id, $order = array(), $booking_id = '') {
        $cond = array('id' => $order_id);
        if ($booking_id) {
            $cond['booking_no'] = $booking_id;
        }
        $this->updateRecord(TBL_ORDERS, $cond, $order);
    }
    
    public function update_booking_status($booking_id,$status = 1) {
        $booking = array('booking_status' => $status);
        return $this->update_booking($booking_id, $booking);
    }

    public function update_order_tracking($order_id, $order = array(), $booking_id = '') {
        $cond = array('id' => $order_id);
        if ($booking_id) {
            $cond['booking_no'] = $booking_id;
        }
        $this->updateRecord(TBL_ORDERS_TRACKING, $cond, $order);
    }

    public function update_booking_orders($booking_id, $order = array()) {
        $cond = array('booking_no' => $booking_id);
        return $this->updateRecord(TBL_ORDERS, $cond, $order);
    }

    public function cancel_booking($booking_no, $passenger_id) {

        $booking = $this->get_booking(array('id' => $booking_no, 'passenger_id' => $passenger_id));

        if (!$booking) {
            _die("The booking does not belongs to you.");
        }

        if ($booking['booking_status'] == BOOKING_COMPLETED) {
            _die("Sorry! the order is already completed. You can't cancel.");
        }
        $orders = $this->get_booking_orders($booking_no, array('order_status'));

        if ($orders) {
            foreach ($orders as $order) {
                if ($order['order_status'] == ORDER_ARRIVED OR $order['order_status'] == ORDER_STARTED) {
                    _die("Sorry! the truck already arrived or started. You can't cancel.");
                }
            }
        }

        $this->updateRecord(TBL_BOOKING, array('id' => $booking_no), array('booking_status' => BOOKING_CANCELLED));
        $this->updateRecord(TBL_ORDERS, array('booking_no' => $booking_no), array('order_status' => ORDER_CANCELLED));
        $this->updateRecord(TBL_ORDERS_TRACKING, array('booking_no' => $booking_no), array('tracking_status' => 2));
    }

    public function confirm_booking($driver_id, $vehical_no, $booking_no) {
        $this->update_booking_orders($booking_no, array('driver_no' => $driver_id, 'vehical_no' => $vehical_no, 'order_status' => ORDER_CONFIRMED));
        $this->update($booking_no, array('booking_status' => BOOKING_CONFIRMED));
    }

    public function get_booking($id) {
        $cond = array('book.id' => $id);
        if (is_array($id)) {
            $cond = $id;
        }
        $booking = $this->setWhereGroup($cond)
                        ->setField('book.*')
                        ->setField('CONCAT(DATE_FORMAT(tfm.start,"%h:00 %p"),"-",DATE_FORMAT(tfm.end,"%h:00 %p")) as flex_time', true)
                        ->setJoin(array(TBL_TIMEFRAME_MASTER => 'tfm'), array('tfm.id' => 'book.flexible_timeslot'))
                        ->execute()->result();
        $location = $this->get_booking_locations($id);
        $orders = $this->get_booking_orders($id);
        $dates = array();
        if ($booking && $orders) {
            $order_count = count($orders);
            foreach ($orders as $key => $value) {
                $dates[] = $value['pickup_date'];
            }
        }
        $booking['dates'] = $dates;
        return ($booking) ? array_merge($booking, $location) : $booking;
    }

    public function get_booking_locations($booking_id) {
        return $this->getData(TBL_ORDERS, array('booking_no' => $booking_id), array('pickup_address', 'pickup_lat', 'pickup_long', 'drop_address', 'drop_lat', 'drop_long'));
    }

    public function get_booking_orders($booking_id, $fields = array()) {
        $cond = array();
        if (is_array($booking_id)) {
            $cond = $booking_id;
        } elseif ($booking_id) {
            $cond = array('booking_no' => $booking_id);
        }
        if (!$fields) {
            $fields = array("ord.*", 'book.passenger_id', 'book.id');
        } else {
            $fields[] = 'book.passenger_id';
            $fields[] = 'book.id';
        }
        return $this->setTable(array(TBL_ORDERS => 'ord'))->setFields($fields)->setJoin(array(TBL_BOOKING => 'book'), array('book.id' => "ord.booking_no"))->setWhereGroup($cond)->execute()->results();
    }

    public function get_unique_invice_id($length = 8) {
        $randomString = random_token($length);
        if ($this->getData(TBL_BOOKING, array('invoice_id' => $randomString))) {
            return $this->get_unique_invice_id($length);
        }
        return strtoupper($randomString);
    }

    public function register_orders($booking_id, $datas = array()) {
        $order_ids = array();
        if ($datas) {
            foreach ($datas as $data) {
                $data['booking_no'] = $booking_id;
                $data['order_status'] = ORDER_RAISED;
                $order_ids[] = $order_id = $this->insertRecord(TBL_ORDERS, $data);
                $this->register_orders_tracking($order_id, $booking_id, $data);
            }
        }
        return $order_ids;
    }

    public function register_orders_tracking($order_id, $booking_id, $data = array()) {
        $tracking_data = array(
            'order_no' => $order_id,
            'booking_no' => $booking_id,
            'tracking_status' => 1,
            'order_status' => BOOKING_RAISED
        );
        $this->insertRecord(TBL_ORDERS_TRACKING, $tracking_data);
    }

    public function get_rate_card($order) {
        $order_details = array();
        if ($order && is_array($order)) {
            $order_details = $order;
        } elseif ($order && is_numeric($order)) {
            $order_details = $this->get_order(array('ord.id' => $order));
        }
        $rate_card = array();
        return $rate_card;
    }

    public function get_order($cred = array()) {
        $result = (is_array($cred)) ? $this->get_orders($cred) : $this->get_orders(array('book.id' => $cred));
        return ($result) ? $result[0] : $result;
    }

    public function get_orders($creds = array(), $status = BOOKING_RAISED, $last_timestamp = '') {

//        $this->show_query();

        $past_booking = $this->requet('past_booking');

//        $current_booking = $this->requet('current_booking');
//        $future_booking = $this->requet('future_booking');

        $booking_status = $this->requet('booking_status');
        $order_status = $this->requet('order_status');
        $driver_id = $this->requet('driver_id');

        $history = $this->requet('history');

        if ($creds) {
            $this->setWhereGroup($creds);
        }

        if ($last_timestamp) {
            $this->setWhereString("book.created_on > '$last_timestamp'");
        }

        $this->setField('book.*');
        $this->setField('ord.id as order_id');
        $this->setField('ord.order_status');
        $this->setField('ord.pickup_date');
        $this->setField('ord.requested_pickup_time');
        $this->setField('ord.pickup_address');
        $this->setField('ord.pickup_lat');
        $this->setField('ord.pickup_long');
        $this->setField('ord.drop_address');
        $this->setField('ord.drop_lat');
        $this->setField('ord.drop_long');
        $this->setField('ord.is_flexible');
        $this->setField('ord.flexible_time_id');
        $this->setField('ord.actual_arival_time');
        $this->setField('ord.actual_start_time');
        $this->setField('ord.actual_drop_time');
        $this->setField('ord.actual_time_taken');
        $this->setField('ord.wating_time');
        $this->setField('ord.actual_distance');
        $this->setField('book.id as booking_id');
        $this->setField('pas.full_name as passenger_name', true);
        $this->setField('pas.phone_no as passenger_phone_no', true);
        $this->setField('dv.full_name as driver_name', true);
        $this->setField('dv.phone_no as driver_phone_no', true);
        $this->setField('dv.address as driver_address', true);
        $this->setField('CONCAT("' . base_url() . '/",dv.driver_image) as driver_image', true, base_url('uploads/driver/driver-image.jpg'));
        $this->setField('veh.vehicle_manufacture as vehicle_manufacture', true);
        $this->setField('CONCAT("' . base_url() . '/",veh.vehicle_image) as vehicle_image', true, base_url('uploads/truck/truck-image.jpeg'));
        $this->setField('spmt.name as special_type_text', true);
        $this->setField('tm.name as capacity_type_text', true);
        $this->setField('CONCAT(DATE_FORMAT(tfm.start,"%h:00 %p"),"-",DATE_FORMAT(tfm.end,"%h:00 %p")) as flex_time', true);
        $this->setField('check_current_or_future_date(ord.pickup_date) as date_in');


        //static data
        $this->setField('pay.total_cost as total_amount', true, 500);
        $this->setField('pay.total_payment as total_payment', true, 400);
        $this->setField('pay.pending_payment as pending_payment', true, 0);
        $this->setField('pay.total_discount as total_discount', true, 100);
        $this->setField('pay.payment_cash as payment_mode', true, 1);


        if ($booking_status) {
            $this->setWhereString('book.booking_status IN (' . $booking_status . ')');
        } elseif ($order_status) {
            $this->setWhereString('ord.order_status IN (' . $order_status . ')');
        } elseif ($past_booking) {
            $this->setWhereString('ord.order_status IN (' . ORDER_FINISHED . ')');
        } else {
            $this->setWhereString('ord.order_status NOT IN (' . ORDER_FINISHED . ',' . ORDER_CANCELLED . ')');
        }

        if ($history) {
            $this->setWhereString('ord.pickup_date < CURDATE()');
        }


        if ($driver_id) {
            $this->setWhere('ord.driver_no', $driver_id);
        }

        if ($this->only_bookings) {
            $this->setGroupBy('book.id');
            if($this->extra_condition){
                $this->setWhereString($this->extra_condition);
            }
        }

        return $this->setJoin(array(TBL_ORDERS => 'ord'), array('ord.booking_no' => 'book.id'))
                        ->setJoin(array(TBL_PASSENGER => 'pas'), array('pas.id' => 'book.passenger_id'))
                        ->setJoin(array(TBL_DRIVER => 'dv'), array('dv.id' => 'book.driver_id'))
                        ->setJoin(array(TBL_VEHICALS => 'veh'), array('veh.id' => 'book.vehicle_id'))
                        ->setJoin(array(TBL_SPECIAL_TYPE_MASTER => 'spmt'), array('spmt.id' => 'book.special_type'))
                        ->setJoin(array(TBL_TONNAGE_MASTER => 'tm'), array('tm.id' => 'book.capacity_type'))
                        ->setJoin(array(TBL_TIMEFRAME_MASTER => 'tfm'), array('tfm.id' => 'book.flexible_timeslot'))
                        ->setJoin(array(TBL_PAYMENTS => 'pay'), array('pay.order_no' => 'ord.id'))
//                        ->setWhere('booking_status', $status)
                        ->execute()->results();
    }

    public function update_booking($id, $booking = array()) {
        if (!$booking) {
            return false;
        }
        return $this->updateRecord(TBL_BOOKING, array('id' => $id), $booking);
    }

    public function get_bookings($cond = array()) {
        $this->only_bookings = true;
        $this->extra_condition = $cond;
        return $this->get_orders();
    }
    
    public function get_current_bookings() {
        $this->only_bookings = true;
        $this->extra_condition = "book.booking_date >= CURDATE()";
        return $this->get_orders();
    }

    public function get_asigned_drivers($booking_id) {
        $data = $this->getDatas(TBL_ASSIGNED_DRIVERS, array('booking_id' => $booking_id));
        $drivers = array();
        if ($data) {
            foreach ($data as $d) {
                $drivers[] = $d['driver_id'];
            }
        }
        return $drivers;
    }

    public function get_asigned_agecies($booking_id) {
        $data = $this->getDatas(TBL_ASSIGNED_AGENCY, array('booking_id' => $booking_id));
        $drivers = array();
        if ($data) {
            foreach ($data as $d) {
                $drivers[] = $d['agency_id'];
            }
        }
        return $drivers;
    }

}
