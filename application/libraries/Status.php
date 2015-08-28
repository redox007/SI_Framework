<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Status
 *
 * @author Suchandan
 */
class Status{ 

    public $booking_status = array();
    public $order_status = array();

    public function __construct() {
        $this->booking_status[BOOKING_RAISED] = array('name' => "Raised", 'class' => 'raised');
        $this->booking_status[BOOKING_ASSIGNED] = array('name' => "Assigned", 'class' => 'assigned');
        $this->booking_status[BOOKING_UNASSIGNED] = array('name' => "Unassigned", 'class' => 'unassigned');
        $this->booking_status[BOOKING_CONFIRMED] = array('name' => "Confirmed", 'class' => 'confirmed');
        $this->booking_status[BOOKING_STARTED] = array('name' => "Started", 'class' => 'started');
        $this->booking_status[BOOKING_COMPLETED] = array('name' => "Completed", 'class' => 'completed');
        $this->booking_status[BOOKING_PAID] = array('name' => "Paid", 'class' => 'paid');
        $this->booking_status[BOOKING_FINISHED] = array('name' => "Finished", 'class' => 'finished');
        $this->booking_status[BOOKING_CANCELLED] = array('name' => "Cancelled", 'class' => 'cancelled');

        $this->order_status[ORDER_RAISED] = array('name' => "Raised", 'class' => 'raised');
        $this->order_status[ORDER_CONFIRMED] = array('name' => "Confirmed", 'class' => 'confirmed');
        $this->order_status[ORDER_GOINGTO] = array('name' => "Going to", 'class' => 'goingto');
        $this->order_status[ORDER_ARRIVED] = array('name' => "Arrived", 'class' => 'arrived');
        $this->order_status[ORDER_STARTED] = array('name' => "Started", 'class' => 'started');
        $this->order_status[ORDER_REACHED] = array('name' => "Reached", 'class' => 'reached');
        $this->order_status[ORDER_DELIVERED] = array('name' => "Delivered", 'class' => 'delivered');
        $this->order_status[ORDER_PAID] = array('name' => "Paid", 'class' => 'paid');
        $this->order_status[ORDER_FINISHED] = array('name' => "Finished", 'class' => 'finished');
        $this->order_status[ORDER_CANCELLED] = array('name' => "Cancelled", 'class' => 'cancelled');
    }

    public function get_booking_status_array() {
        $data = array();
        foreach($this->booking_status as $key => $val){
            $data[$key] = $val['name'];
        }
        return $data;
    }

    public function get_order_status_array() {
        $data = array();
        foreach($this->order_status as $key => $val){
            $data[$key] = $val['name'];
        }
        return $data;
    }

    public function get_booking_status_text($status) {
        return $this->booking_status[$status]['name'];
    }

    public function get_booking_status_class($status) {
        return $this->booking_status[$status]['class'];
    }

    public function get_order_status_text($status) {
        return $this->order_status[$status]['name'];
    }

    public function get_order_status_class($status) {
        return $this->order_status[$status]['class'];
    }

}
