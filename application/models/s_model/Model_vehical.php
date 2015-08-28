<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_vehical
 *
 * @author Suchandan
 */
class Model_vehical extends MY_Model {

    public function __construct() {
        parent::__construct();
        $this->setTable(TBL_VEHICALS);
    }

    public function register($data) {
        if ($this->getData(TBL_VEHICALS, array('registration_no' => $data['registration_no']))) {
            return false;
        }
        return $this->insertRecord(TBL_VEHICALS, $data);
    }

    public function update($id, $data) {
        $data = unset_if_empty($data);
        return $this->updateRecord(TBL_VEHICALS, array('id' => $id), $data);
    }

    public function assign($driver_id, $vehical_id, $data = array()) {
        if ($this->setTable(TBL_DRIVER_VEHICALS)->setWhereStringArray(array(
                    "( driver_id = '{$driver_id}' AND is_current = '1' )",
                    "( vehical_id = '{$vehical_id}' AND is_current = '1' )"
                        ), "OR")->execute()->result()) {
            _die("The driver or vehical may be engage.");
        }
        if (!$data) {
            return false;
        }
        return $this->insertRecord(TBL_DRIVER_VEHICALS, $data);
    }

    public function is_engaged($vehical_id, $driver_id = '') {
        $this->setTable(TBL_DRIVER_VEHICALS);
        if ($driver_id) {
            return $this->setWhereGroup(array(
                        'vehical_id' => $vehical_id,
                        'driver_id' => $driver_id,
                        'is_current' => 1))->get_results();
        }
        return $this->setWhereStringArray(array(
                    "( vehical_id = '{$vehical_id}' AND is_current = '1' )"
                        ), "OR")->execute()->result();
    }

    public function get_vehical($id) {

        return $this->setTable(array(TBL_VEHICALS => 'vh'))
                        ->setFields(array(
                            "vh.id as vehical_id",
                            "vh.*",
                            "dv.driver_id as driver_id",
                            "dv.driver_id as driver_id",
                            "dv.date_from",
                            'spm.name as special_type',
                            'tm.name as capacity_text',
                            "dv.date_to"
                        ))
                        ->setJoin(array(TBL_DRIVER_VEHICALS => 'dv'), array('dv.vehical_id' => 'vh.id', 'dv.is_current' => '1'))
                        ->setJoin(array(TBL_DRIVER => 'drv'), array('drv.id' => 'dv.driver_id'))
                        ->setJoin(array(TBL_SPECIAL_TYPE_MASTER => 'spm'), array('spm.id' => "vh.type"))
                        ->setJoin(array(TBL_TONNAGE_MASTER => 'tm'), array('tm.id' => "vh.capacity"))
                        ->setWhere('vh.id', $id)
                        ->execute()->result();
    }

    public function get_list($fields = array()) {

        $this->setTable(array(TBL_VEHICALS => 'veh'));
        $where = array();
        if (!$fields) {
            $fields = array(
                'veh.id',
                'veh.name',
                'model',
                'registration_no',
                'capacity',
                'type',
                'status',
                'created_on'
            );
        }
        $s = trim($this->requet('s'));
        $stype = $this->requet('search_type');
        if ($s && $stype == 'vehicle') {
            $this->setWhereStringArray(array(
                "model LIKE '%$s%'",
                "veh.name LIKE '%$s%'",
                "registration_no LIKE '%$s%'"
                    ), 'OR', true);
        }
        return $this->setJoin(array(TBL_SPECIAL_TYPE_MASTER => 'spm'), array('spm.id' => "veh.type"))
                        ->setJoin(array(TBL_TONNAGE_MASTER => 'tm'), array('tm.id' => "veh.capacity"))
                        ->setFields($fields)
                        ->setField('tm.name as capacity_text', TRUE)
                        ->setField('spm.name as special_type', TRUE)
                        ->setWhereGroup($where)
                        ->orderBy('id')
                        ->execute()->results();
    }

    public function rate_vehicle($passenger_id, $vehicle_id, $order_id, $booking_id, $rate) {
        return $this->insertRecord(TBL_VEHICLE_RATING, compact('passenger_id', 'vehicle_id', 'order_id', 'booking_id', 'rate'));
    }

}
