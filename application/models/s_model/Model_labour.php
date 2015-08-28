<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_labour
 *
 * @author Suchandan
 */
class Model_labour extends MY_Model {

    private $table = TBL_LABOUR; 

    public function __construct() {
        parent::__construct();
        $this->setTable($this->table);
    }

    public function register($data) {
        return $this->insertRecord($this->table, $data);
    }

    public function update($id, $data) {
        return $this->updateRecord($this->table, array('id' => $id), $data);
    }

    public function delete($id) {
        return $this->deleteRecord($this->table, array('id' => $id));
    }

    public function get_labour($id) {
        $agency = $this->get_list(false, $id);
        return $agency ? $agency[0] : $agency;
    }
    
   

    public function get_list($fields = array(), $id = '') {
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
        if ($id) {
            $fields = array('*');
            $this->setWhere('id', $id);
        }
        return $this->setFields($fields)
                        ->setWhereGroup($where)
                        ->orderBy('id')
                        ->execute()->results();
    }

}
