<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_login
 *
 * @author Suchandan
 */
class Model_login extends MY_Model {

    public function __construct() {
        parent::__construct();
    }
    
    public function login() {
//        $this->show_query();
        $username = $this->post('username');
        $password = $this->post('password');
        
        return $this->setTable(TBL_USERS)->setWhereGroup(array(
            'username' => $username,
            'phno' => $username,
            'email' => $username
        ), "OR")->setWhere('password', $password)->execute()->result();
    }

}
