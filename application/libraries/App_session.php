<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of app_session
 * @property CI_Controller $ci CI_Controller
 * @property CI_DB_query_builder $db CI_DB_query_builder
 * @author Suchandan
 */

class App_session {

    private $ci;

    public function __construct() {
        $this->ci = get_instance();
    }

    public function check_session($session_id, $user_id, $user_type, $timestamp = '', $requester = '') {

        $session = $this->get_session($user_id);

        $timeout = $this->get_timeout_time() * 60;
        $timestamp = ($timestamp) ? strtotime($timestamp) : time();
        $session_time = strtotime($session['timestamp']);

        if (($timestamp - $session_time) > $timeout) {
            return false;
        } else {
            $this->update_session($user_id, $user_type, $session_id);
        }
    }

    public function get_session($user_id) {
        return $this->ci->db->get_where(TBL_SESSION, array('user_id' => $user_id))->row_array();
    }

    public function update_session($user_id, $user_type, $session_id = '', $timestamp = '') {

        $session = $this->get_session($user_id);
        if (!$session) {
            return false;
        }
        $timestamp = ($timestamp) ? $timestamp : date('y-m-d H:i:s');

        $data['timestamp'] = $timestamp;
        $data['user_type'] = $user_type;
        $data['session_id'] = ($session_id) ? $this->get_session_token() : $session_id;

        $this->ci->db->update($table, $data, array('user_id' => $user_id));
    }

    public function set_session($user_id, $user_type, $session_id = '', $timestamp = '') {

        $timestamp = ($timestamp) ? $timestamp : date('y-m-d H:i:s');

        $data['timestamp'] = $timestamp;
        $data['user_type'] = $user_type;
        $data['session_id'] = ($session_id) ? $this->get_session_token() : $session_id;
        $data['user_id'] = $user_id;
        $this->ci->db->insert(TBL_SESSION, $data);
    }

    protected function get_session_token($bit = 8) {
        return md5(time());
    }

    public function clear_session($user_id) {
        $this->ci->db->delete(TBL_SESSION, array('user_id' => $user_id));
    }

    protected function get_timeout_time() {
        $data = $this->ci->db->get_where(TBL_METAS, array('meta_key' => 'session_timeout'));
        return isset($data['meta_value']) ? $data['meta_value'] : 10;
    }

    public function generate_access_token($developer_id, $app_id, $security_token) {
        $data = $this->check_developer($developer_id, $app_id, $security_token);
        if ($data) {
            $developer_id = $data['developer_id'];
            $app_id = $data['app_id'];

            $access_token = md5($app_id . $developer_id . time());
            return $access_token;
        }
        return false;
    }

    public function check_developer($developer_id, $app_id, $security_token) {
        $data = $this->db->get_where(TBL_ACCESS_TOKEN, array('developer_id' => $developer_id, 'app_id' => $app_id, 'security_token' => $security_token));
        return ($data) ? $data : false;
    }

    public function check_access_token($developer_id, $app_id, $access_token) {
        
        $data = $this->db->get_where(TBL_ACCESS_TOKEN, array('developer_id' => $developer_id, 'app_id' => $app_id, 'access_token' => $access_token));

        if ($data) {
            $life_time = $data['life_time'];
            $last_access_time = strtotime($data['datetime']);
            $current_time = time();
            $life_time = $life_time * 60;

            if (($current_time - $last_access_time) > $life_time) {
                return false;
            }
            return true;
        }

        return ($data) ? $data : false;
    }

}
