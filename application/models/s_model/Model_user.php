<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_user
 *
 * @author Suchandan
 */
class Model_user extends MY_Model {

    private $user_id;
    private $user;

    public function __construct() {
        parent::__construct();
    }

    public function load_user($user_id) {
        $this->user_id = $user_id;
    }

    public function get_user($user_id = '') {
        if ($user_id) {
            $this->user_id = $user_id;
        }
        $this->user = $this->db->get(TBL_USERS)
                ->or_where("id = {$this->user_id}")
                ->or_where("email = {$this->user_id}")
                ->or_where("ph = {$this->user_id}")
                ->or_where("username = {$this->user_id}")
                ->row();
        return $this->user;
    }

}
