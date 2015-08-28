<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $_required, $_required_tracker, $_required_key_tracker;



//debug function
if (!function_exists('debug')) {

    function debug($data = '', $exit = false) {
        print_r('<pre>');
        print_r($data);
        print_r('</pre>');
        if ($exit) {
            exit;
        }
    }

}
//DB HELPER
if (!function_exists('db_field_concat')) {

    function db_field_concat($table = '', $field = '', $as = '', $connecter = '.') {

        $CI = & get_instance();
        $table = $CI->db->dbprefix($table);

        $as = ($as) ? " as {$as}" : '';

        return trim($table) . trim($connecter) . trim($field) . $as;
    }

}
if (!function_exists('db_condition_maker')) {

    function db_condition_maker($cond, $check, $op = '=') {
        return $cond . " {$op} " . $check;
    }

}
//DB HELPER
if (!function_exists('key_value_pair')) {

    function key_value_pair($data, $key = 'meta_key', $value = 'meta_value', $merge_first = array()) {
        $meta_array = array();
        if (!$data) {
            return $data;
        }
        if ($merge_first) {
            $meta_array = array_merge($meta_array, $merge_first);
        }
        foreach ($data as $meta) {
            $meta_array[$meta[$key]] = $meta[$value];
        }

        return $meta_array;
    }

}
if (!function_exists('array_make')) {

    function array_make($keys, $data) {
        $meta_array = array();
        $keys = is_string($keys) ? array($keys) : $keys;
        if (!$keys)
            return $meta_array;
        foreach ($keys as $key) {
            $meta_array[$key] = $data[$key];
        }
        return $meta_array;
    }

}

if (!function_exists('__e')) {

    function __e($data = '', $default = '') {
        echo ($data != '') ? $data : $default;
    }

}
if (!function_exists('__')) {

    function __($data = '', $default = '') {
        echo ( (isset($$data)) ? $$data : $default );
    }

}

if (!function_exists('__r')) {

    function __r($data = '', $default = '') {
        return ( (isset($$data)) ? $$data : $default );
    }

}

if (!function_exists('load_view')) {

    function load_view($name = '', $folder = '', $data = array()) {
        if (!$name) {
            return $name;
        }
        if ($folder) {
            $name = "{$folder}/{$name}";
        }
        $CI = & get_instance();
        if ($data)
            return $CI->load->view($name, $data);
        else
            return $CI->load->view($name);
    }

}
if (!function_exists('get_status_text')) {

    function get_status_text($status, $active = 'Active', $inactive = 'Inactive') {
        return ($status) ? '<span class="label label-success">' . $active . '</span>' : '<span class="label label-important">' . $inactive . '</span>';
    }

}
if (!function_exists('array_insert_element')) {

    function array_insert_element($array, $afterKey, $key, $value) {
        $pos = array_search($afterKey, array_keys($array));
        $count = count($array);

        return array_merge(
                array_slice($array, 0, $pos, $preserve_keys = true), array($key => $value), array_slice($array, $pos, $count, $preserve_keys = true)
        );
    }

}

if (!function_exists('is_assoc')) {

    function is_assoc(array $array) {
        return (bool) count(array_filter(array_keys($array), 'is_string'));
    }

}

if (!function_exists('odd_even')) {

    function odd_even($data) {
        echo ($data % 2 == 0) ? 'even' : "odd";
    }

}

if (!function_exists('__ed')) {

    function __ed($name, $data = array(), $default = '') {
        $default = ($default) ? $default : "<span class='label label-important'><b>{$name}</b> is not found.</span>";
        $d = (isset($data[$name])) ? $data[$name] : $default;
        __e($d);
    }

}
if (!function_exists('__efd')) {

    function __efd($name, $data = array(), $default = '') {
        $default = (!isset($data[$name]) && is_array($default) ) ? '' : $default;
        $d = (isset($data[$name])) ? $data[$name] : $default;
        if (is_array($default) && $default && isset($data[$name])) {
            $a = array_keys($default);
            if (reset($a) == $data[$name]) {
                $b = array_values($default);
                $d = end($b);
            }
        }
        __e($d);
    }

}
if (!function_exists('__rd')) {

    function __rd($name, $data = array()) {
        return (isset($data[$name])) ? $data[$name] : false;
    }

}
if (!function_exists('__echeck')) {

    function __echeck($condition, $true_date = '',$false_data = '',$return = false) {
        if($return){
            return ($condition) ? $true_date : $false_data;
        }else{
            __e((($condition) ? $true_date : $false_data));
        }
        
    }

}


if (!function_exists('admin_base_url')) {

    function admin_base_url($path = '', $no_base_path = true) {
        $path = strpos($path, 'admin/') > 0 ? $path : "admin/{$path}";
        return ($no_base_path) ? $path : base_url($path);
    }

}

if (!function_exists('__el')) {

    function __el($contex = '', $language_file = 'api', $lang_type = 'en') {
        $CI = & get_instance();
        $CI->lang->load($language_file, $lang_type);
        $data = $CI->lang->line($contex);
        __e($data);
    }

}
if (!function_exists('load_css')) {

    function load_css($path = '', $id = '') {
        __e('<link id="' . $id . '" href="' . base_url($path) . '" rel="stylesheet">');
    }

}
if (!function_exists('load_js')) {

    function load_js($path = '') {
        __e("<script src='" . base_url($path) . "' type='text/javascript'></script>");
    }

}
if (!function_exists('generate_doc')) {

    function generate_doc($output) {
        $doc = "";
        if (request('_doc') && ENVIRONMENT == 'development') {
            $desc = request('_doc_desc');
            $doc .= "********" . request('_doc_head', false, $desc) . "*********";
            $doc .= "\nSERVICE : " . current_url();
            $doc .= "\nDESC : " . $desc;
            $doc .= "\n" . _request_params(true);
            $doc .= "\nOUTPUT :" . $output;
        }
        echo $doc;
//        ob_start();
    }

}
if (!function_exists('_request_params')) {

    function _request_params($return = false) {
        global $_required_tracker;
        $param_strng = array();
        if ($_required_tracker) {
            foreach ($_required_tracker as $param) {
                $r = ($param['required']) ? "(R)" : '';
                $param_strng[] = "{$param['key']}" . $r;
            }
        }
        $data = "PARAMS : " . implode(',', $param_strng);
        if ($return) {
            return $data;
        }
        _debug($data);
    }

}
if (!function_exists('_debug')) {

    function _debug($data = '', $exit = false) {
        debug($data, true);
    }

}
if (!function_exists('__debug')) {

    function __debug($data = '', $exit = false) {
        debug($data, true);
    }

}
if (!function_exists('unset_if_empty')) {

    function unset_if_empty($data, $fields = array()) {
        global $_required;
        if (!empty($_required) && is_array($_required)) {
            $fields = $_required;
        }
        if (( empty($fields) || empty($data))) {
            return $data;
        }
        foreach ($data as $key => $val) {
            if (in_array($key, $fields) && empty($data[$key])) {
                unset($data[$key]);
            }
        }
        return $data;
    }

}
if (!function_exists('random_token')) {

    function random_token($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters = str_shuffle($characters);
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
if (!function_exists('_die')) {

    function _die($data = array()) {

        $data_array = array();

        $response['success'] = false;
        $response['session'] = false;

        if (!is_array($data)) {
            $data_array['msg'] = $data;
        } else {
            $data_array = $data;
        }

        $response = array_merge($response, $data_array);
        $response = json_encode($response);
        generate_doc($response);
//        generate_doc($response);

        header("Access-Control-Allow-Credentials: true");
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Expose-Headers: Access-Control-Allow-Origin');
        header('Content-Type: application/json');
        die($response);
    }

}



if (!function_exists('track_request')) {

    function track_request($key = '', $required = false, $default = NULL) {
        global $_required_tracker, $_required_key_tracker;
        if ($key == '_doc' || $key == '_doc_desc' || $key == '_doc_head') {
            return false;
        }
        if ($_required_key_tracker && @in_array($key, $_required_key_tracker)) {
            return false;
        }
        $_required_key_tracker[] = $key;
        $_required_tracker[] = compact('key', 'required', 'default');
//        print_r($_required_key_tracker);
    }

}
if (!function_exists('request')) {

    function request($key = '', $required = false, $default = NULL) {

        if (ENVIRONMENT == 'development' && !is_array($key)) {
            track_request($key, $required, $default);
        }

        if (is_array($key) && $key) {
            foreach ($key as $key_name) {
                $data[$key_name] = (isset($_REQUEST[$key_name])) ? $_REQUEST[$key_name] : false;
                track_request($key_name, $required, $default);
            }
            return $data;
        }

        if ($required && (!isset($_REQUEST[$key]) || empty($_REQUEST[$key]) )) {
            _die("{$key} field is required field.");
        }

        if (!is_null($default) && !isset($_REQUEST[$key])) {
            $_REQUEST[$key] = $default;
        }
        return (isset($_REQUEST[$key])) ? $_REQUEST[$key] : false;
    }

}
if (!function_exists('request_cache')) {

    function request_cache($key = '', $default = NULL, $required = false) {
        global $_required;
        $_required[] = $key;
        return request_default($key, $default, $required);
    }

}
if (!function_exists('request_default')) {

    function request_default($key = '', $default = NULL, $required = false) {
        return request($key, $required, $default);
    }

}
if (!function_exists('two_decimal')) {

    function two_decimal($number) {
        return number_format($number, 2, '.', '');
    }

}
if (!function_exists('is_past_date')) {

    function is_past_date($date) {
        return strtotime($date) < time();
    }

}
if (!function_exists('make_array_to_string')) {

    function make_array_to_string($data, $glue = ' ', $value_wrapper = "'") {
        $string = array();
        if ($data) {
            foreach ($data as $key => $val) {
                $val = ($value_wrapper) ? $value_wrapper . "$val" . $value_wrapper : $val;
                $string[] = "$key = $val";
            }
        }
        return implode($glue, $string);
    }

}
if (!function_exists('make_date')) {

    function make_date($date = '',$format = 'Y-m-d') {
        if(!$date){
            return date($format);
        }else{
            return date($format,  strtotime($date));
        }
    }

}