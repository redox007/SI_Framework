<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Controller
 * 
 * This is common controller for all webservice that using codeigniter
 *
 * @author Suchandan
 * @property CI_Loader $load Loader
 * @property CI_Lang $lang CI_Lang
 * @property Model_passenger $Model_passenger Model_passenger
 * @property Model_driver $Model_driver Model_driver
 * @property Model_common $Model_common Model_common
 * @property Model_vehical $Model_vehical Model_vehical
 * @property Model_booking $Model_booking Model_booking
 * @property Model_agency $Model_agency Model_agency
 * @property Model_discount $Model_discount Model_discount
 * @property Status $status Status
 * @property CI_Session $session CI_Session
 */
class MY_Controller extends CI_Controller {

    public $data = array();
    protected $objects = array();
    protected $_functions = array();
    protected $response = array();
    protected $status_header = 200;
    protected $debug_before_view = false;
    protected $exit_after_debug_view = false;
    
    //Pagination params
    protected $per_page = 10;
    protected $segment_controller = 4;
    protected $segment_slug = 3;
    protected $page = '';
    protected $start = 0;
    protected $result_count = 0;
    protected $limit_seted = false;
    protected $ajax = false;
    protected $commonModel;
    protected $global_errors = array();
    //For Front admin panel
    protected $request_object = array();
    protected $concat_response = false;
    protected $get_from_request_object = false;

    /*
     * Contructor of the class
     */

    public function __construct() {

        parent::__construct();
        date_default_timezone_set('Asia/Kolkata');
        $this->load->helper('s_helper');
        $this->load->helper('form');
        $this->load->helper('s_form');

        $this->setDefaultVariables();
    }

    public function concat_response($param = true) {
        $this->concat_response = $param;
    }

    public function get_from_request_object($param = true) {
        $this->get_from_request_object = $param;
    }

    /*
     *  setJsonHeader to set the response header
     * @access protected
     * @return object
     * @param string $type default 'application/json'
     */

    protected function setJsonHeader($type = 'application/json') {
        $this->output->set_content_type($type);
        return $this;
    }

    /*
     *  setAccessControl to set the response Access Control
     * @access protected
     * @return object
     * @param string $control default 'true'
     */

    protected function setAccessControl($control = 'true') {
        return $this->output->set_header("Access-Control-Allow-Credentials: $control")
                        ->set_header('Access-Control-Allow-Origin: *')
                        ->set_header('Access-Control-Expose-Headers: Access-Control-Allow-Origin');
    }

    /*
     *  post to get the value from $_POST array
     * @access protected
     * @return mixed
     * @param string $key
     */

    protected function post($key = '') {
        return $this->input->post($key);
    }

    /*
     * to get the value from $_GET array
     * @access protected
     * @return mixed
     * @param string $key
     */

    protected function get($key = '') {
        return $this->input->get($key);
    }

    /*
     * to get the value from $_REQUEST array
     * @access protected
     * @return mixed
     * @param string $key
     */

    protected function request($key = '', $required = false, $default = NULL) {
        if ($this->get_from_request_object) {
            $message = ($required) ? "{$key} is arequired field." : '';
            $data = $this->request_param($key, $message, $this->get_request_object());
            if ($this->check_errors()) {
                $this->_die($message);
            } else {
                return $data;
            }
        }
        return request($key, $required, $default);
    }

    protected function request_cache($key = '', $default = NULL, $required = false) {
        return request_default($key, $default, $required);
    }

    protected function request_default($key = '', $default = NULL, $required = false) {
        return request($key, $required, $default);
    }

    //This is for admmin panel request function
    protected function request_array($key = '', $data = array(), $required = false, $message = "") {
        if (!is_array($data) && is_string($data)) {
            $data = $this->request($data);
        }
        if (!isset($data[$key]) AND $required) {
            $keyword = ucfirst(str_replace(array('_'), array(' '), $key));
            $message = ($message) ? $message : "The {$keyword} field can not be empty";
            $this->setError($message);
        } else {
            return $data[$key];
        }
    }

    protected function request_param($key = '', $message = '', $object = array()) {
//        debug($key);
        $object = ($object) ? $object : $this->request_object;
        $r = ($object) ? __rd($key, $object) : request($key);
        if (!$r && $message) {
            $this->setError($message);
        } else {
            return $r;
        }
    }

    protected function set_request_object($object) {
        if (is_string($object)) {
            $object = $this->request($object);
        }
        if ($object) {
            $this->request_object = $object;
        }
    }

    protected function get_request_object() {
        return $this->request_object;
    }

    protected function unset_request_object() {
        $this->request_object = array();
    }

//    protected function request($key = '', $required = false,$default = NULL) {
//
//        if ($required && (!isset($_REQUEST[$key]) || empty($_REQUEST[$key]) )) {
//            $this->_die("{$key} field is required field.");
//        }
//
//        if(!is_null($default)){
//            $_REQUEST[$key] = $default;
//        }
//        return (isset($_REQUEST[$key])) ? $_REQUEST[$key] : false;
//    }
//
//    protected function request_cache($key = '',$default = NULL,$required = false) {
//        global $_required;
//        $_required[] = $key;
//        return $this->request_default($key,$default,$required);
//    }
//    
//    protected function request_default($key = '',$default = NULL,$required = false) {
//        return $this->request($key,$required,$default);
//    }

    /*
     *  jsonEncode to encode response vale to json object
     * @access protected
     * @return object
     * @param array $response
     */

    protected function jsonEncode($response = array()) {
        if ($this->post('show') == 1) {
            print_r($response);
        }
        return json_encode($response);
    }

    /*
     *  langLine to get language value by its key 
     * @access protected
     * @return string
     * @param string $name
     * @param string $replacer
     * @param string $subject
     */

    protected function langLine($name, $replacer = '', $subject = '') {

        if (($line = $this->lang->line($name)) == 'false') {
            return $name;
        } elseif (strpos($name, ' ')) {
            return $name;
        } else {
            $subject = ($subject == '') ? '{object}' : $subject;
            $line = str_replace($subject, $replacer, $line);
        }
        return $line;
    }

    /*
     *  setResponse to set response array for output
     * @access protected
     * @return object
     * @param array $data
     */

    protected function setResponse($data = array()) {
        $this->response = array_merge($this->response, $data);
        return $this;
    }

    /*
     *  response to set response for output
     * @access protected
     * @param string $response
     * @param boolean $lang
     * @param int $code default 200
     */

    protected function response($response = array(), $lang = false) {
        $data = array();
        if (empty($response)) {
            $response = $this->response;
        } else {
            if (!is_array($response)) {
                $data['msg'] = ($lang) ? $this->langLine($data) : $data;
                $this->response = array_merge($this->response, $data);
            } else {
                $response = array_merge($this->response, $response);
            }
        }
        $json_response = $this->jsonEncode($response);
        $this->generate_doc($json_response);
        $this->setJsonHeader()->setAccessControl()->set_status_header("$this->status_header")->set_output($json_response);
    }

    protected function generate_doc($output) {
        generate_doc($output);
    }

    /*
     *  setStatusHeader to set response header status 
     * @access protected
     * @return object $data
     * @param int $code 
     */

    protected function setStatusHeader($code) {
        if ($code) {
            $this->status_header = $code;
        }
        return $this;
    }

    /*
     *  _die to die after set output response 
     * @access protected
     * @param array $data
     * @param boolean $lang
     */

    protected function _die($data = array(), $lang = false) {
        if (!empty($data)) {
            if (!is_array($data)) {
                $msg = ($lang) ? $this->langLine($data) : $data;
                $this->setMessage($msg);
            } else {
                $this->response = array_merge($this->response, $data);
            }
        }
        _die($this->response);

//        header("Access-Control-Allow-Credentials: true");
//        header('Access-Control-Allow-Origin: *');
//        header('Access-Control-Expose-Headers: Access-Control-Allow-Origin');
//        header('Content-Type: application/json');
//        die(json_encode($this->response));
    }

    /*
     *  checkPostEmptyFields to check empty field of post value
     * @access protected
     * @return mixes
     * @param array $fields
     * @param string $type default post
     */

    protected function checkPostEmptyFields($fields = array(), $type = 'post') {

        if (empty($fields)) {
            return false;
        }

        foreach ($fields as $field) {
            $val = $this->$type($field);
            if (empty($val)) {
                $this->setMessage("The $field can not be empty.");
                $this->_die();
            }
        }
    }

    /*
     *  dataUnsetter to unset keys and value of an array
     * @access protected
     * @return mixes
     * @param array $fields
     * @param string $type default post
     */

    protected function dataUnsetter($data = array(), $fields = array()) {
        if (empty($data) || empty($fields)) {
            return $data;
        }
        foreach ($fields as $field) {
            if (isset($data[$field])) {
                unset($data[$field]);
            }
        }
        return $data;
    }

    /*
     *  setSuccess to set success param for output
     * @access protected
     * @return mixes
     * @param string $name
     */

    protected function setSuccess($name = '') {
        $this->response['success'] = true;
        if ($name)
            $this->response['msg'] = $this->langLine($name);
        return $this;
    }

    protected function set_success_responce($name = '', $data = array()) {
        $this->setSuccess($name);
        $this->response($data);
    }

    protected function set_error_responce($data = array(), $lang = true) {
        $this->_die($data, $lang);
    }

    /*
     *  setData to set data param for output
     * @access protected
     * @return mixes
     * @param string $name
     * @param string $data 
     */

    protected function setData($name = '', $data = array()) {
        if ($name == '') {
            return false;
        }
        $this->response[$name] = $data;
        return $this;
    }

    /*
     *  setMessage to set msg param for output
     * @access protected
     * @return object
     * @param string $name
     * @param mixed $lang default false
     */

    protected function setMessage($name = '', $lang = false) {
        if ($lang) {
            $name = $this->langLine($name);
        }
        $this->response['msg'] = $name;
        return $this;
    }

    /*
     *  setLangMessage to set msg param from $lang array for output
     * @access protected
     * @return object
     * @param string $name
     * @param mixed $lang default false
     */

    protected function setLangMessage($name = '') {
        $this->setMessage($name, true);
        return $this;
    }

    /*
     *  unsetResponseData to unset key value pair from response array
     * @access protected
     * @return boolean
     * @param array $names
     */

    protected function unsetResponseData($names = '') {
        if ($names == '') {
            return false;
        }
        if (!is_array($names)) {
            $names = array($names);
        }
        foreach ($names as $name) {
            if (isset($this->response[$name])) {
                unset($this->response[$name]);
            }
        }
        return true;
    }

    /*
     *  setDefaultVariables to set default response variable
     * @access protected
     * @return boolean
     * @param array $names
     */

    public function setDefaultVariables() {

        date_default_timezone_set('Asia/Kolkata');

        $this->response['success'] = false;
        $this->response['session'] = false;
        $this->response['msg'] = 'false';
        return $this;
    }

    //This section mostly for web

    /*
     *  setDefaultTextDatas to set default test variable Frr Web
     * @access pubic
     * @return boolean
     */

    public function setDefaultTextDatas() {

        $this->data['dashboard_url'] = ($this->config->item('dashboard_url')) ? $this->config->item('dashboard_url') : '';
        $this->data['dashboard_name'] = ($this->config->item('dashboard_name')) ? $this->config->item('dashboard_name') : 'Admin Panel';

        return $this;
    }

    /*
     *  addAction to set default response variable
     * @access protected
     * @return void
     * @param string $hook
     * @param mixed $funcion
     * @param int $priority
     */

    public function addAction($hook, $funcion, $priority = 1) {
        if ($hook && $funcion) {
            $this->_functions[$hook][$priority][] = array(
                'function' => $funcion
            );
        }
    }

    /*
     *  executeAction to set default response variable
     * @access protected
     * @return void
     * @param array $hook
     */

    protected function executeAction($hook) {
        if ($hook == '') {
            return false;
        }
        $args = func_get_args();
        if ($args) {
            $args = array_shift($args);
        }
        if (!empty($this->_functions[$hook])) {
            foreach ($this->_functions[$hook] as $val) {
                if (!empty($val)) {
                    foreach ($val as $fn) {
                        if (!is_array($args)) {
                            $args = array($args);
                        }
                        call_user_func_array($fn['function'], $args);
                    }
                }
            }
        }
    }

    /*
     *  setDataObject to set objects data
     * @access protected
     * @return object
     * @param string $name
     * @param Mixed $object
     */

    public function setDataObject($name = 'name', $object = null) {
        if (!$name || !$object) {
            return false;
        }
        $this->objects[$name] = $object;
        return $this;
    }

    /*
     *  getDataObject to get objects data
     * @access protected
     * @return Mixed
     * @param string $name
     * @param Boolean $O
     */

    public function getDataObject($name = 'name', $O = false) {
        if (!isset($this->objects[$name])) {
            return false;
        }
        return ($O) ? (object) $this->objects[$name] : $this->objects[$name];
    }

    /*
     *  loadLib to Load Library
     * @access puublic
     * @return none
     * @param string $name
     * @param Mixed $data
     */

    public function loadLib($name, $data = null) {
        return $this->load->library($name);
    }

    public function loadS_lib($name, $data = null) {
        return $this->loadLib('s_lib/' . $name, $data);
    }

    /*
     *  loadConfig to Load cofig file
     * @access puublic
     * @return none
     * @param string $name
     */

    public function loadConfig($name) {
        $this->config->load($name);
    }

    public function loadS_config($name) {
        $this->loadConfig('s_config/' . $name);
    }

    /*
     *  loadModel to get Load model
     * @access puublic
     * @return none
     * @param string $name
     * @param Mixed $data
     */

    public function loadModel($name, $data = null) {

        if (strpos($name, '/') > 0) {
            $model = explode('/', $name);
            $dir = $model[0];
            $name = ($model[1]) ? 'Model_' . $model[1] : '';
            $model_name = $name;
            $name = ($name && $dir) ? $dir . '/' . $name : $name;
        } else {
            $model_name = 'Model_' . $name;
            $name = ($model_name) ? $model_name : '';
        }
        if (!$name) {
            return false;
        }

        $model = $this->load->model($name);

        $this->setCommonModel($model_name);

        return $model;
    }

    public function setCommonModel($model = '') {
        if ($model && empty($this->commonModel)) {
            $this->commonModel = $this->{$model};
        }
    }

    public function loadS_model($name, $data = null) {
        return $this->loadModel('s_model/' . $name, $data);
    }

    /*
     * loadHelper to get Load helper
     * @access puublic
     * @return none
     * @param string $name
     * @param Mixed $data
     */

    public function loadHelper($name, $data = null) {
        return $this->load->helper($name);
    }

    /*
     * loadTemplate to get Load Template file 
     * @access puublic
     * @return none
     * @param string $name
     * @param Mixed $data
     */

    public function loadTemplate($name, $data = null) {
//        $data = ($data) ? $data : $this->data;
        $this->load->view('templates/' . $name, $this->data);
    }

    /*
     * setViewData to get set data of view 
     * @access puublic
     * @return Mixed
     * @param string $name
     * @param Mixed $data
     */

    public function setViewData($name, $data = array()) {
        if (is_string($name)) {
            $this->data[$name] = $data;
        } elseif (is_array($name)) {
            $this->data = array_merge($this->data, $name);
        }
        return $this->data;
    }

    public function add_style($path, $footer = false, $priority = 10) {
        $script = '<link rel="stylesheet" href="' . base_url($path) . '" />';
        $this->add_auto_load_script($script, $footer, $priority, true);
    }

    public function add_script($path, $footer = false, $priority = 10) {
        $script = '<script typt="text/javascript" src="' . base_url($path) . '" ></script>';
        $this->add_auto_load_script($script, $footer, $priority, true);
    }

    public function add_auto_load_script($scripts = array(), $footer = false, $priority = 10, $externals = false) {
        if (!$scripts) {
            return false;
        }
        $name = ($footer) ? '_auto_load_scripts_footer' : '_auto_load_scripts_head';

        $scripts = (!is_array($scripts)) ? array($scripts) : $scripts;

        $d_scripts = $this->getViewData($name);
        $d_scripts = ($d_scripts === false) ? array() : $d_scripts;

        foreach ($scripts as $script) {
            $d_scripts[$priority][] = ($externals) ? $script : $this->load_view($script . '-script', 'template-scripts', array(), true);
        }

        ksort($d_scripts);

        $this->setViewData($name, $d_scripts);
    }

    private function make_script_array() {
        $names = array('_auto_load_scripts_footer', '_auto_load_scripts_head');
        foreach ($names as $name) {
            $scripts = $this->getViewData($name);
            $this->data[$name] = array();
            if ($scripts) {
                foreach ($scripts as $key => $script) {
                    if ($script) {
                        foreach ($script as $s) {
                            $this->data[$name][] = $s;
                        }
                    }
                }
            }
        }
    }

    public function updateViewData($name, $update_key, $update_value) {
        $data = $this->getViewData($name);
        if (is_array($update_key)) {
            $data = array_merge($data, $update_key);
        } elseif (isset($data[$update_key])) {
            $data[$update_key] = $update_value;
        }
        $this->setViewData($name, $data);
        return $this->data;
    }

    public function getViewData($name) {

        return isset($this->data[$name]) ? $this->data[$name] : false;
    }

    //Database functions
    public function getData($table, $cond = array(), $fields = array('*'), $join = array(), $grop_by = '') {
        $query_data = array(
            'fields' => $fields,
            'where' => $cond,
            'join' => $join,
            'gooup_by' => $grop_by
        );
        $result = $this->commonModel->runQuery($table, 'select', $query_data);
        return $result->row_array();
    }

    public function getDatas($table, $cond = array(), $fields = array('*'), $join = array(), $limit = array(), $order_by = '', $order = 'DESC', $grop_by = '') {
        $query_data = array(
            'fields' => $fields,
            'where' => $cond,
            'join' => $join,
            'gooup_by' => $grop_by,
            'order_by' => $order_by,
            'order' => $order,
            'limit' => $limit
        );
        $result = $this->commonModel->runQuery($table, 'select', $query_data);
        return $result->result_array();
    }

    public function countData($table, $cond = array(), $fields = array('COUNT(*) as count'), $join = array(), $limit = array(), $order_by = '', $order = 'DESC', $grop_by = '') {
        $res = $this->commonModel->getData($table, $cond, $fields, $join, $limit, $order_by, $order, $grop_by);
        return $res['count'];
    }

    public function insertRecord($table, $data) {
        return $this->commonModel->runQuery($table, 'insert', array('data' => $data));
    }

    public function manageRecord($table, $data, $cond = array()) {
        return $this->commonModel->manage($table, 'delete', array('where' => $data));
    }

    public function deleteRecord($table, $data) {
        return $this->commonModel->runQuery($table, 'delete', array('where' => $data));
    }

    public function updateRecord($table, $cond, $data) {
        return $this->commonModel->runQuery($table, 'update', array('where' => $cond, 'data' => $data));
    }

    public function show_query($only_query = false) {
        $this->commonModel->show_qeury($only_query);
    }

    public function show_result_data() {
        $this->commonModel->show_result_data();
    }

    //End of Database functions
    //COmmon 
    public function number_format($number, $decimals, $dec_point, $thousands_sep) {
        return number_format($number, $decimals, $dec_point, $thousands_sep);
    }

    //ALL WEB RELATED FUNCTION WILL COME HERE
    //Web related functions
    public function auth($redirect_on = 'login') {
        $logged_in = $this->session->userdata('logged_in');

        if (empty($logged_in) || !$logged_in) {
            if ($this->ajax) {
                die('ses_expire');
            }
            $url = current_url();
//            $uri = uri_string();
            $url = urlencode($url);
            $redirect_on = base_url($redirect_on) . "?redirect=$url";
            $this->redirectON($redirect_on, 'Session has expired.', 400);
        }
    }

    public function load_view($view, $folder = '', $vars = array(), $return = false) {
        $view = ($folder) ? $folder . '/' . $view : $view;
        $vars = array_merge($this->data, $vars);
        return $this->load->view($view, $vars, $return);
    }

    public function load_views($views) {

        $data['title'] = (isset($this->data['title'])) ? $this->data['title'] : 'Admin';
        $data['meta_keyword'] = (isset($this->data['meta_keyword'])) ? $this->data['meta_keyword'] : '';
        $data['meta_description'] = (isset($this->data['meta_description'])) ? $this->data['meta_description'] : '';
        $data['author'] = (isset($this->data['author'])) ? $this->data['author'] : '';
        $data['body_class'] = (isset($this->data['body_class'])) ? $this->data['body_class'] : '';

        $this->set_metadata($data);

        if ($views && is_array($views)) {
            foreach ($views as $view) {
                $this->load->view($view, $this->data);
            }
        } elseif (is_string($views)) {
            $this->load->view($views);
        }
    }

    public function render_view($page = 'home', $folder = '') {
        $views = array();
        $views[] = 'templates/header';

        if (!$page) {
            show_error("No view specified.");
        }

        if ($this->session->userdata('logged_in')) {
            $views[] = 'templates/topbar';
            $views[] = 'templates/nav';
            $views[] = 'templates/header-template';
        }

        if (is_array($page) && is_assoc($page)) {
            foreach ($page as $p => $folder) {
                $views[] = ($folder) ? trim($folder) . '/' . trim($p) : trim($p);
            }
        } else {
            $views[] = ($folder) ? trim($folder) . '/' . trim($page) : trim($page);
        }

        if ($this->session->userdata('logged_in')) {
            $views[] = 'templates/footer-template';
        }

        $views[] = 'templates/footer';



        $this->beforeWebview();

        if ($this->debug_before_view) {
            debug($this->data, $this->exit_after_debug_view);
        }
        if (!isset($this->data['data_object'])) {
            $this->setViewData('data_object', array());
        }
        $this->load_views($views);
    }

    public function debug_view($exit = false) {
        $this->debug_before_view = true;
        $this->exit_after_debug_view = $exit;
    }

    public function set_metadata($data = array()) {
        $this->data = array_merge($this->data, $data);
    }

    public function render($views) {
        if ($views && count($views) > 0 && is_array($views)) {
            foreach ($views as $key => $val) {
                if (is_string($key)) {
                    $this->data = array_merge($this->data, $val);
                    $key = 'view-' . $key;
                    $this->load->view($key, $this->data);
                } else {
                    $this->load->view($val, $this->data);
                }
            }
        } elseif (strpos($views, '/') > 0) {
            $model = explode('/', $views);
            $dir = $model[0];
            $views = ($model[1]) ? 'view-' . $model[1] : $views;
            $views = ($views && $dir) ? $dir . '/' . $views : $views;
        } else {
            $views = 'view-' . $views;
        }
        $this->load->view($views, $this->data);
    }

    public function renderTemplate($views, $folder = '', $data = array()) {

        $folder_slug = '';

        if (is_string($folder) && !is_array($views) && $folder != '') {
            $views = $folder . '/' . $views;
        } elseif (is_array($folder)) {
            $data = $folder;
        }

        $this->beforeWebview($data);

        $this->loadTemplate('header');

        if (!isset($this->data['container_id'])) {
            $this->data['container_id'] = "page-wrapper";
        }
        if (!isset($this->data['container_class'])) {
            $this->data['container_class'] = "page-container";
        }

        if ($this->session->userdata('logged_in')) {
            $this->loadTemplate('menu');
            $this->loadTemplate('panel-header');
        }

        $this->render($views);

        if ($this->session->userdata('logged_in')) {
            $this->loadTemplate('panel-footer');
        }

        $this->loadTemplate('footer');
    }

    public function setContainer($id = 'page-wrapper', $class = 'page-container') {
        $this->data['container_id'] = $id;
        $this->data['container_class'] = $class;
    }

//    public function renderTemplate($views, $folder = '', $data = array()) {
//
//        $folder_slug = '';
//
//        if (is_string($folder) && !is_array($views) && $folder !='') {
//            $views = $folder . '/' . $views;
//        } elseif (is_array($folder)) {
//            $data = $folder;
//        }
//        
//        $this->beforeWebview($data);
//
//        $this->loadTemplate('header');
//
//        if ($this->session->userdata('logged_in')) {
//            $this->loadTemplate('menu', $data);
//            $this->loadTemplate('panel-header', $data);
//        }
//
//        $this->render($views, $data);
//
//        if ($this->session->userdata('logged_in')) {
//            $this->loadTemplate('panel-footer', $data);
//        }
//
//        $this->loadTemplate('footer', $data);
//    }

    public function redirect($param = '') {
        redirect(base_url($param));
    }

    public function getUserdata($param = '') {
        return $this->session->userdata($param);
    }

    public function setUserdata($userdata = array()) {
        if (!$userdata)
            return false;
        $this->session->set_userdata($userdata);
    }

    public function redirectON($url, $msg = '', $status = 200) {
        $class = 'success';
        if ($status == 400) {
            $class = 'danger';
        }
        if ($msg) {
            $this->session->set_flashdata('response', array('msg' => $msg, 'status' => $status, 'class' => $class));
        }
        redirect($url);
    }

    public function redirectTO($slug = 'dashboard', $msg = '', $status = 200, $r_class = '') {
        $class = 'success';
        if ($status == 400) {
            $class = 'danger';
        }
        if ($r_class) {
            $class = $r_class;
        }
        $this->session->set_flashdata('response', array('msg' => $msg, 'status' => $status, 'class' => $class));
        $url = base_url($slug);

        redirect($url);
    }

    public function redirectOnError($slug = 'dashboard', $msg = '', $error_class = 'error') {
        $this->redirectTO($slug, $msg, 400, $error_class);
    }

    public function langLineReplacer($name, $replacer = '', $subject = '') {

        if (($line = $this->lang->line($name)) == 'false') {
            return $name;
        } else {
            $subject = ($subject == '') ? '{object}' : $subject;
            $line = str_replace($subject, $replacer, $line);
        }
        return $line;
    }

    public function checkArrayEmptyField($fields = array(), $data = array()) {
        if (empty($fields) || empty($data)) {
            return false;
        }
        foreach ($data as $key => $val) {
            if (in_array($key, $fields) && empty($val)) {

                return false;
            }
        }

        return true;
    }

    public function dataArrayUnsetter($data = array(), $fields = array()) {
        if (empty($fields) || empty($data)) {
            return false;
        }
        foreach ($data as $key => $val) {
            if (in_array($key, $fields)) {
                unset($data[$key]);
            }
        }
        return $data;
    }

    public function error($msg = '') {
        show_error($msg);
    }

    public function set_flashdata($msg = '') {
        $this->session->set_flashdata('msg', $msg);
    }

    public function beforeWebview($data = array()) {

//        $notification_data = (isset($data['response']) && $data['response']) ? $data['response'] : array();
        if (!empty($data)) {
            $this->data = array_merge($this->data, $data);
        }

        $this->loadConfig('s_config/S_config');
        $this->loadLib('s_lib/S_menu');

        $this->setDefaultTextDatas();

        $this->data['ajax_loader'] = base_url('assets/custom/img/ajax-loader.gif');
        $this->data['menu'] = $this->s_menu->menuProcessor();
        $this->data['logout_link'] = base_url('logout');

        if (isset($this->data['response'])) {
            $notification = $this->data['response'];
        } else {
            $notification = $this->session->flashdata('response');
        }
        $this->data['action_messages'] = $this->load->view('templates/action-message', $notification, true);

        $this->make_script_array();
    }

    //Push notification
    public function testPush() {
        $red_id = "APA91bFD7ehjg5fQLVrBtTBDgNLZO-sudESwv6xEzVV2JeQAmSccivI_L41SSgie3YSydQ3Qt_mtIabbQckPuJbL4_YYU7zK7Hs0XBX07IAmcPZudtO166ziLf_9QILQ7wvcYK47bv7qPQ96n8k8kNYy0fRbYgKxxQ";
        $msg = "TEST PUSH FOR ANDROID";
        $reg = array($red_id);
        $message = array('message' => $msg);
        print_r($this->send_notification($reg, $message));
    }

    function send_notification($registatoin_ids, $data = array()) {

        // Set POST variables
        $url = 'https://android.googleapis.com/gcm/send';

        $fields = array(
            'registration_ids' => $registatoin_ids,
            'data' => $data,
        );

        $headers = array(
            'Authorization: key=' . GOOGLE_API_KEY,
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();

        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
//        print_r($result);
        return $result;
    }

    //Pagination function

    protected function setPaginationModel($model, $per_page = 10) {
        $this->pagination_model = $model;
        if ($per_page)
            $this->setPerpage($per_page);
        $this->setLimit();
    }

    protected function enable_ajax_pagination() {
        $this->setViewData('ajax_pagi', true);
    }

    protected function unsetPaginationModel() {
        unset($this->pagination_model);
    }

    protected function getPagination() {
        return $this->getViewData('pagination');
    }

    protected function setPagination($uri, $total_rows, $result_count) {

        if (!isset($this->pagination_model))
            show_error("Pagination Model has not been set.");

        $show_all = $this->get('show_all');
        if ($show_all) {
            $this->data['pagination'] = "";
            return;
        }

        if (!$this->limit_seted) {
            show_error('Please set the limit in your model to use pagination.');
        }
        $this->result_count = $result_count;

        $base_url = base_url($uri);
//        $s = $this->get('s');
        if (count($_GET)) {
            $g = $_GET;
            if (isset($g['per_page'])) {
                unset($g['per_page']);
            }
            $s = http_build_query($g);
            if ($s) {
                $base_url = $base_url . "?" . $s;
            }
        }

        $this->load->library('pagination');

        $config['base_url'] = $base_url;
        $config['total_rows'] = $total_rows;
        $config['per_page'] = $this->per_page;
        $config["uri_segment"] = $this->segment_controller;
        $config['num_links'] = 3;
        $config['use_page_numbers'] = TRUE;
        $config['full_tag_open'] = '<ul class="" id="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '&raquo;';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo;';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';

        if (count($_GET) > 0) {
            $this->config->set_item('enable_query_strings', TRUE);
        }
        $this->pagination->initialize($config);

        $this->createPagination($total_rows);

        return $this->pagination->create_links();
    }

    public function createPagination($total) {

        $pagination['total'] = $total;
        $pagination['start'] = $this->start + 1;
        $pagination['end'] = $this->start + $this->result_count;
        $pagination['links'] = $this->pagination->create_links();

        $this->data['pagination'] = $this->load->view('templates/paginations', $pagination, true);

        $this->unsetPaginationModel();
    }

    public function setPaginationValues( $contrler_pos = 1, $slug_pos = 2) {
//        $this->per_page = $per_page;
        $this->segment_controller = $contrler_pos;
        $this->segment_slug = $slug_pos;
    }

    public function setPerpage($pageCount = 5) {
        $this->per_page = $pageCount;
    }

    public function setLimit($per_page = 0) {

        $show_all = $this->get('show_all');
        if ($show_all) {
            return;
        }

        if ($per_page) {
            $this->setPerpage(intval($per_page));
        }

        if (!isset($this->pagination_model))
            show_error("Pagination Model has not been set.");

        $this->limit_seted = true;

        if (count($_GET) > 0) {
            $this->page = $this->get('per_page');
        } else {
            $this->page = $this->uri->segment($this->segment_controller);
        }

        $this->page = ($this->page == '' || $this->page == 0 ) ? 1 : $this->page;
        $this->start = ($this->page > 1) ? ($this->page - 1) * $this->per_page : 0;

        $this->pagination_model->limit($this->start, $this->per_page);
    }

    public function base_model($name) {
        return strtolower($name);
    }

    public function compulsory_fields($arr, $debug = true) {
        //print_r($arr);
        //array('$phone_number', $phone_number, 'please enter phone number'),
        for ($row = 0; $row < count($arr); $row++) {

            $val = $arr[$row][1];
            $val = trim($val);

            if (empty($val)) {
                $data['result'] = false;
                $data['msg'] = $arr[$row][2];
                if ($debug)
                    $data['field_name'] = $arr[$row][0];
                return $data;
            }
        }
        $data['result'] = true;
        return $data;
    }

    public function load_model($param = '', $data = null) {
        if ($param) {
            if ($data) {
                return $this->load->model($param, $data);
            }
            return $this->load->model($param);
        }
    }

    //Validation and generate erors
    public function validation($condition, $data = array()) {
        $error = 0;

        if (empty($condition)) {
            return true;
        }
        $keys = array_keys($condition);

        foreach ($keys as $key) {
            if ($data && empty($data[$key])) {
                $msg = $condition[$key];
                $this->setError($msg);
                $error++;
            } elseif (!$data && !($val = $this->request($key))) {
                $msg = $condition[$key];
                $this->setError($msg);
                $error++;
            }
        }
        if ($error > 0) {
            $error = 0;
            return false;
        } else {
            $error = 0;
            return true;
        }
    }

    public function createErrorMessage($errors = array()) {
        $msg = '';
        if ($errors) {
            $msg .= '<ul>';
            foreach ($errors as $error) {
                $msg .= '<li>' . ucfirst($error) . '</li>';
            }
            $msg .= '</ul>';
        } else {
            return false;
        }
        return $msg;
    }

//    public function set_error_message($errors = array()) {
//        $msg = '';
//        if ($errors) {
//            $msg .= '<ul>';
//            foreach ($errors as $error) {
//                $msg .= '<li>' . ucfirst($error) . '</li>';
//            }
//            $msg .= '</ul>';
//        } else {
//            return false;
//        }
//        return array('msg' => $msg, 'class' => 'error');
//    }

    public function setError($param = '') {
        $this->global_errors[] = $param;
        return $this;
    }

    public function setErrors($errors = array()) {
        $this->global_errors = array_merge($this->global_errors, $errors);
    }

    public function getError() {
        return $this->global_errors;
    }

    public function make_errors($errors = array()) {
        if ($errors) {
            $this->global_errors = array_merge($this->global_errors, $errors);
        }
        return $this->createErrorMessage($this->global_errors);
    }

    public function get_error_response($message = '') {
        if (!$message) {
            $message = $this->make_errors();
        }
        return array('code' => 400, 'msg' => $message, 'class' => 'error');
    }

    public function errors_response($message = '') {

        $response = $this->get_error_response();
        if ($message) {
            $response = $this->get_error_response($message);
        }
        $this->setViewData('response', $response);
        return $this;
    }

    public function check_errors() {
        if ($this->getError()) {
            return true;
        }
        return false;
    }

    public function getQueryString($uri = '', $full_url = true) {

        $query_string = '';
        $query = array();

        if (isset($_GET) && count($_GET) > 0) {
            foreach ($_GET as $key => $value) {
                $query[] = "$key=$value";
            }
        }

        $query_string = implode('&', $query);

        $uri = ($query_string) ? $uri . '?' . $query_string : $uri;

        if ($full_url) {
            $uri = base_url($uri);
        }
        return $uri;
    }

    public function check_data_die($cdata, $msg = "", $data = array()) {
        if (!$cdata) {
            $data['msg'] = $msg;
            $this->_die($data);
        }
        return true;
    }

}
