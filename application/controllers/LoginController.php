<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of LOginController
 *
 * @author Suchandan
 * @property Model_login $Model_login Model_login
 */
class LoginController extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->loadS_model('login');
    }

    public function index() {
        if ($this->input->post('login')) {
            $user = $this->Model_login->login();
            if ($user) {
                $this->setUserdata(array(
                    'username' => $user['username'],
                    'user_id' => $user['id'],
                    'user_type' => $user['user_type'],
                    'logged_in' => true
                ));
                $redirect = admin_base_url('dashboard');
                if ($this->input->post('redirect')) {
                    $redirect = $this->input->post('redirect');
                }
                $this->redirectON($redirect);
            } else {
                $this->redirectOnError(admin_base_url('login'), "The Userid/Password is incorrect or invalid user.");
            }
        }
        $this->setViewData('body_class', 'login');
        $this->setViewData('redirect', $this->request('redirect'));

        $this->render_view('login');
    }

    public function logout() {
        $this->session->sess_destroy();
        $this->redirect(admin_base_url('login'));
    }

}
