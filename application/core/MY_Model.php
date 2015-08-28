<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Model
 *
 * @author Suchandan
 * @property CI_DB_query_builder $db CI_DB_query_builder
 */
Class MY_Model extends CI_Model {

    public $query = array();
    public $pastQuery = array();
    public $value = array();
    public $query_string = '';
    public $last_query = '';
    public $count_query = '';
    public $mainTable = '';
    public $mainTableAlish = '';
    private $dbResult;
    private $row = false;
    private $result = false;
    public $show_query = false;
    public $show_result_data = false;
    public $no_execute = false;

    public function __construct() {
        parent::__construct();
        $this->show_query = $this->input->post('show_query');
        $this->resetVarables();
    }

    public function show_query($only_query = false) {
        $this->show_query = ($only_query) ? 1 : 2;
        return $this;
    }

    public function show_result_data() {
        $this->show_result_data = true;
        return $this;
    }

    public function post($key = '') {
        return $this->input->post($key);
    }

    public function get($key = '') {
        return $this->input->get($key);
    }

    public function requet($key = '') {
        return (isset($_REQUEST[$key])) ? $_REQUEST[$key] : false;
    }

    public function countData($table, $cond = array(), $fields = array('COUNT(*) as count'), $join = array(), $limit = array(), $order_by = '', $order = 'DESC', $grop_by = '') {
        $res = $this->getData($table, $cond, $fields, $join, $limit, $order_by, $order, $grop_by);
        return $res['count'];
    }

    public function insertRecord($table, $data) {
        return $this->runQuery($table, 'insert', array('data' => $data));
    }

    public function deleteRecord($table, $data) {
        return $this->runQuery($table, 'delete', array('where' => $data));
    }

    public function updateRecord($table, $cond, $data) {
        return $this->runQuery($table, 'update', array('where' => $cond, 'data' => $data));
    }

    public function getData($table, $cond = array(), $fields = array('*'), $join = array(), $grop_by = '') {
        $query_data = array(
            'fields' => $fields,
            'where' => $cond,
            'join' => $join,
            'gooup_by' => $grop_by
        );
        $result = $this->runQuery($table, 'select', $query_data);
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
        $result = $this->runQuery($table, 'select', $query_data);
        return $result->result_array();
    }

    public function runQuery($table = '', $query_type = 'select', $query_data = array(), $custom = false, $query = '') {

        $result = false;

        $query_data_default['data'] = array();
        $query_data_default['fields'] = array('*');
        $query_data_default['join'] = array();
        $query_data_default['where'] = array();
        $query_data_default['all'] = false;
        $query_data_default['gooup_by'] = '';
        $query_data_default['order_by'] = '';
        $query_data_default['order'] = '';
        $query_data_default['limit'] = array();


        $query_data = array_merge($query_data_default, $query_data);


        extract($query_data);

        $fields = implode(',', $fields);

        if ($table == '')
            return false;
        $table = $this->db->dbprefix($table);

        if ($custom) {
            $result = $this->db->query($query);
        } else {
            switch ($query_type) {
                case 'select':
                    $this->db->select($fields);
                    $this->db->from($table);
                    if (!empty($join)) {
                        foreach ($join as $key => $value) {
                            $cond = (isset($value['cond'])) ? $value['cond'] : '';
                            $type = (isset($value['type'])) ? $value['type'] : 'left';
                            $this->db->join($key, $cond, $type);
                        }
                    }
                    $this->db->where($where);

                    if (!empty($gooup_by)) {
                        $this->db->group_by($gooup_by);
                    }
                    if (!empty($order_by)) {
                        $this->db->order_by($order_by, $order);
                    }
                    if (!empty($limit)) {
                        $this->db->limit(10, 20);
                    }

                    $result = $this->db->get();
                    // print_r($this->db->last_query());
                    break;
                case 'update' :
                    $this->db->where($where);
                    $result = $this->db->update($table, $data);
                    $result = $this->db->affected_rows();
                    break;
                case 'insert' :
                    $result = $this->db->insert($table, $data);
                    if ($this->db->insert_id()) {
                        $result = $this->db->insert_id();
                        ;
                    }
                    break;
                case 'delete' : $this->db->delete($table, $where);
                    $result = $this->db->affected_rows();
                    break;
            }
        }
        if ($this->show_query) {
            ob_start();
            debug($this->db->last_query());
        }
        if ($this->show_result_data) {
            debug($result);
            $this->show_result_data = false;
        }
        return $result;
    }

    //Query maker
    public function resetVarables() {
        $this->query['tables'] = array();
        $this->query['where'] = array();
        $this->query['join'] = array();
        $this->query['fields'] = array();
        $this->query['extra'] = '';
        $this->query['query_type'] = 'SELECT';
        $this->query['group_by'] = '';
        $this->query['order_by'] = '';
        $this->query['order_type'] = 'DESC';
        $this->query['limit'] = '';

        $this->query_string = '';
        $this->mainTable = '';
        $this->mainTableAlish = '';
        $this->value = array();
    }

    public function setGroupBy($name) {
        $this->query['group_by'] = $name;
        return $this;
    }

    public function extra($name) {
        $this->query['extra'] = $name;
        return $this;
    }

    public function queryType($name) {
        $this->query['query_type'] = $name;
        return $this;
    }

    public function orderBy($name, $type = 'DESC') {
        $this->query['order_by'] = $name;
        $this->query['order_type'] = $type;
        return $this;
    }

    public function orderType($name) {
        $this->query['order_type'] = $name;
        return $this;
    }

    public function limit($start, $end) {
        $this->query['limit'] = "$start,$end";
        return $this;
    }

    public function getQuery() {
        return $this->last_query;
    }

    public function getLastQuery() {
        return $this->getQuery();
    }

    public function setValue($name, $value) {
        $this->value[$name] = $value;
        return $this;
    }

    public function getValue($name) {
        if (isset($this->value[$name])) {
            return $this->value[$name];
        }
        return false;
    }

    public function setQuery() {

        if (!is_array($this->query['tables'])) {
            $this->query['tables'] = array($this->query['tables']);
        }
        if (!is_array($this->query['fields'])) {
            $this->query['fields'] = array($this->query['fields']);
        }
//        if (!is_array($this->query['where'])) {
//            $this->query['where'] = array($this->query['where']);
//        }
//        foreach($this->query['tables'] as $key => $tab){
//            $this->query['tables'][$key] = $this->db->dbprefix($tab);
//        }
        $join_string = (empty($this->query['join'])) ? '' : implode($this->query['join'], ' ');
//        $where_string   = (empty($this->query['where'])) ?  ''  : implode($this->query['where'], ' AND ');

        $where_string = $this->makeWhereString();

        $fields_string = (empty($this->query['fields'])) ? '*' : implode($this->query['fields'], ',');
        $table = (empty($this->query['tables'])) ? '' : implode($this->query['tables'], ',');

        $groupby = ($this->query['group_by'] != '' ) ? "GROUP BY " . $this->query['group_by'] : '';
        $order_type = $this->query['order_type'];
        $order_by = ($this->query['order_by'] != '' ) ? "ORDER BY " . $this->query['order_by'] . " $order_type" : '';

        $limit = ($this->query['limit'] != '' ) ? "LIMIT " . $this->query['limit'] : '';

        $extra = $this->query['extra'];
        $query_type = ($this->query['query_type'] == '') ? "SELECT " : $this->query['query_type'];

        $where_string = ($where_string == '' ) ? "" : " WHERE " . $where_string;

        $from = "FROM";

        if ($query_type == "UPDATE" || $query_type == "INSERT" || $query_type == "TRUNCATE") {
            $from = "";
        }

        if ($query_type == "DELETE") {
            $fields_string = '';
        }

        $this->query_string = "$query_type $extra $fields_string $from $table $join_string $where_string $groupby $order_by $limit";
        $this->count_query = "$query_type * $from $table $join_string $where_string $groupby";

        if ($query_type == "UPDATE") {
            $this->query_string = "$query_type $table $extra  $where_string";
        }

        $this->last_query = $this->query_string;
        $this->pastQuery = $this->query;

        $this->resetVarables();

        return $this;
    }

    public function setFields($fields = array(), $if_null = false) {
        if ($if_null && $fields) {
            foreach ($fields as $field) {
                $this->setField($field, $if_null);
            }
        } else {
            $this->query['fields'] = $fields;
        }
        return $this;
    }

    public function setField($field, $if_null = false, $if_null_data = '') {
        $as = '';
        $query_text = '';
        if (( $i = strpos($field, ' as ') ) > 0 && $if_null) {
            $a = explode(' as ', $field);
//            print_r($a);
            $field = trim($a[0]);
            $as = trim($a[1]);
            $query_text = "IFNULL({$field},'{$if_null_data}') as {$as}";
        } elseif ($if_null) {
            $query_text = "IFNULL({$field},'{$if_null_data}') as {$field}";
        }
        $this->query['fields'][] = ($if_null) ? $query_text : $field;
        return $this;
    }

    public function setTable($table, $alish = '') {
        if ($alish) {
            $table = array($table => $alish);
        }
        if (is_array($table)) {
            $p = $table;
            $t = array_keys($table);
            $table = reset($t);
            $b = array_values($p);
            $this->mainTableAlish = end($b);
            $table = "$table $this->mainTableAlish";
        }
        $table = $this->checkTable($table);
        $this->query['tables'] = $table;
        $this->mainTable = $table;

        return $this;
    }

    public function checkTable($table) {
        $_prefix = $this->db->dbprefix;
        if ($_prefix && strpos($table, $_prefix) === false) {
            $table = $this->getTableName($table);
        }
//        echo $table."<br>";
        return $table;
    }

    public function set_nested_where($field, $value, $type = 'AND', $operator = '=', $table = '') {
        return $this->setWhere($field, $value, $type, $table, $operator, true);
    }

    public function set_where_in($field, $value, $type = 'AND', $table = '') {
        $operator = 'IN';
        $value = is_array($value) ? implode(',', $value) : $value;
        $value = "(" . $value . ")";
        return $this->setWhere($field, $value, $type, $table, $operator, true);
    }

    public function set_where_not_in($field, $value, $type = 'AND', $table = '') {
        $operator = 'NOT IN';
        $value = is_array($value) ? implode(',', $value) : $value;
        $value = "(" . $value . ")";
        return $this->setWhere($field, $value, $type, $table, $operator, true);
    }

    public function set_where_like($field, $value, $type = 'AND', $table = '') {
        $operator = 'LIKE';
        return $this->setWhere($field, $value, $type, $table, $operator);
    }

    public function set_where_between($field, $value = array(), $table = '') {
        $operator = 'BETWEEN';
        if (count($value) != 2) {
            show_error("The value must be a array of 2 element");
        }
        return $this->setWhereString("{$field} {$operator} {$value[0]} AND {$value[1]}");
    }

    public function set_where_operator($field, $value, $operator = '=', $type = 'AND', $table = '') {
        return $this->setWhere($field, $value, $type, $table, $operator);
    }

    public function setWhere($field = '', $value = '', $type = 'AND', $table = '', $operator = '=', $fieldVal = false, $wrapper = true) {
        if ($table == '') {
            $table = $this->query['tables'];
        }
        if (!$table) {
            show_error('Wrong query placement.Table not initoialized.');
        }
//        print_r($table);
        $table = $this->checkTable($table);

        if (is_array($field) && !empty($field)) {
            foreach ($field as $v) {
                $keys = array_keys($v);
                extract($v);
                $this->setWhere($field, $value, $type, $table, $operator);
            }
        } else {
            if ($this->mainTableAlish) {
                $table = $this->mainTableAlish;
            }
            if (strpos($field, '.') === false) {
                if ($wrapper) {
                    $field = "$field";
                }
                $field = "$table.$field";
            }
            if (!$field) {
                $value = "'$value'";
            }
            if (!$fieldVal) {
                $value = "'$value'";
            }
            $this->query['where'][][$type] = "$field $operator $value ";
        }

        return $this;
    }

    public function setOrWhere($field = '', $value = '', $table = '', $operator = '=') {
        return $this->setWhere($field, $value, 'OR', $table, $operator);
    }

    public function setWhereGroup($group, $type = 'AND', $table = '', $operator = '=') {
        if ($group) {
            foreach ($group as $key => $val) {
                $this->setWhere($key, $val, $type, $table, $operator);
            }
        }
        return $this;
//        return $this->setWhere($field,$value, 'OR',$table,$operator);
    }

    public function setWhereStringArray($group, $type = 'AND', $grouping = false) {
        if ($group) {
            if ($grouping) {
                $string = implode(" {$type} ", $group);
                if($string){
                    return $this->setWhereString("( {$string} )");
                }
            }
            foreach ($group as $string) {
                $this->setWhereString($string, $type);
            }
        }
        return $this;
    }

    public function setWhereGroupString($group, $type = 'AND', $table = '', $operator = '=') {
        $string = array();
        if ($group) {
            foreach ($group as $key => $val) {
                $string[] = "$key $operator '$val'";
            }
        }
        if ($string) {
            $string = implode(" $type ", $string);
        }
//        if(isset($this->query['where']) && count($this->query['where']) > 0){
//            $string = "( $string )";
//        }
        if ($string) {
            $string = "( $string )";
        }

        $this->setWhereString($string);

        return $this;
//        return $this->setWhere($field,$value, 'OR',$table,$operator);
    }

    public function setFieldWhere($field = '', $value = '', $type = 'AND', $table = '', $operator = '=') {
        $this->setWhere($field, $value, $type, $table, $operator, true);
        return $this;
    }

    public function setWhereString($string = '', $type = 'AND') {
        if ($string && is_string($string)) {
            $this->query['where'][][$type] = $string;
        }
        return $this;
    }

    private function makeWhereString() {
        $where = '';
        if ($this->query['where']) {
            foreach ($this->query['where'] as $key => $val) {
                if ($val) {
                    foreach ($val as $k => $v) {
                        if ($where == '') {
                            $where .= "$v";
                        } else {
                            $where .= " $k " . "$v";
                        }
                    }
                }
            }
        }
        return $where;
    }

    public function setJoinString($string = '') {
        if ($string && is_string($string)) {
            $this->query['join'][] = $string;
        }
        return $this;
    }

    public function setJoin($joiner = '', $cond = array(), $type = 'LEFT', $joinTo = '', $extra = array()) {
        if ($joiner == '' || empty($cond)) {
            return $this;
        }
        $joiner_cond = '';
        $joiner_tablename = '';
        $joinTo_cond = '';
        $joinTo_tablename = '';

        $alish_joiner = '';
        $alish_joinTo = '';

        if (is_array($joiner)) {
            $a = array_keys($joiner);
            $joiner_tablename = reset($a);
            $joiner_tablename = $this->checkTable($joiner_tablename);
            $b = array_values($joiner);
            $alish_joiner = end($b);
        } else {
            $joiner_tablename = $this->checkTable($joiner);
        }

        if (is_array($joinTo)) {
            $a = array_keys($joiner);
            $joinTo_tablename = reset();
            $joinTo_tablename = $this->checkTable($joinTo_tablename);
            $b = array_values($joiner);
            $alish_joinTo = end($b);
        } elseif ($joinTo) {
            $joinTo_tablename = $this->checkTable($joinTo);
        } elseif ($this->mainTableAlish) {
            $joinTo_tablename = $this->mainTableAlish;
        } else {
            $joinTo_tablename = $this->mainTable;
        }

        $joiner_condition = array();

        foreach ($cond as $key => $value) {
//            if($alish_joiner){
//                $joiner_tablename_forcond = "$alish_joiner";
//            }else{
//                $joiner_tablename_forcond = $joiner_tablename;
//            }
//            if($alish_joinTo){
//                $joinTo_tablenamee_forcond = "$alish_joinTo";
//            }else{
//                $joinTo_tablenamee_forcond = $joinTo_tablename;
//            }
//            $joiner_condition[] = "$joiner_tablename_forcond.$key = $joinTo_tablenamee_forcond.$value";
            $joiner_condition[] = "$key = $value";
        }
        $joiner_condition = implode(' AND ', $joiner_condition);
//        if ($cond) {
//            $joiner_cond = "$joiner.".reset(array_keys($cond));
//            $joinTo_cond = "$joinTo.".end(array_values($cond));
//        }
        if ($alish_joiner) {
            $joiner = "$joiner_tablename $alish_joiner";
        } else {
            $joiner = $joiner_tablename;
        }
        if ($alish_joinTo) {
            $joinTo = "$joinTo_tablename $alish_joinTo";
        } else {
            $joinTo = $joinTo_tablename;
        }
        $this->query['join'][] = " $type JOIN $joiner ON $joiner_condition ";
        return $this;
    }

    public function execute($query = '') {

        if ($query == '') {
            $query = $this->setQuery()->getQuery();
        } elseif (is_callable($query)) {
            call_user_func_array($query, array(&$this));
            $query = $this->setQuery()->getQuery();
        }

        if ($this->show_query) {
//            ob_start();
            debug($query);
        }
        if ($this->show_query == 2) {
//            ob_start();
            debug($this->pastQuery);
        }

        if (!$this->no_execute) {
            $this->dbResult = $this->db->query($query);
        }
        if ($this->show_result_data) {
            debug($this->dbResult->result());
            $this->show_result_data = false;
        }
        return $this;
    }

    public function get_model_instance() {
        return new MY_Model();
    }

    public function execute_query($param) {
        if ($this->show_query) {
            print_r('||');
            print_r($param);
        }
        $R = $this->db->query($param);
        return $R;
    }

    public function getTableName($table = '') {
        if ($table == '') {
            return false;
        }
        return $this->db->dbprefix($table);
    }

    public function setOnlyRow($set = true) {
        $this->row = $set;
        return $this;
    }

    public function result($object = false) {
        $method_name = ($object) ? 'row' : 'row_array';
        $this->result = $this->dbResult->{$method_name}();
        return $this->result;
    }

    public function get_result($object = false) {
        return $this->execute()->result($object);
    }

    public function table($table = '') {
        $_table = ($this->query['tables']) ? $this->query['tables'] : false;
        return ($table) ? $table : $_table;
    }

    public function resultOB() {
        return $this->dbResult;
    }

    public function results($object = false) {
        $method_name = ($object) ? 'result' : 'result_array';
        if ($this->row) {
            $this->result = $this->result($object);
            return $this->result;
        }

        $this->result = $this->setOnlyRow(false)->dbResult->{$method_name}();
        return $this->result;
    }

    public function get_results($object = false) {
        return $this->execute()->results($object);
    }

    public function getTotalCount($query = '') {
        $query = ($query) ? $query : $this->count_query;
        return $this->execute($query)->resultOB()->num_rows();
    }

    public function get_num_rows() {
        return $this->resultOB()->num_rows();
    }

    public function count() {
        $this->query['fields'] = 'COUNT(*) as count';
        return $this->execute()->result(true)->count;
    }

    public function manage($table, $data, $cond = array()) {
        $exists = false;
        $d = array();
        if ($cond) {
            $d = $this->getData($table, $cond);
            if (!empty($d)) {
                $exists = true;
            }
        }
        if ($exists) {
            return array('update' => true, 'result' => $this->updateRecord($table, $cond, $data), 'data' => $this->getData($table, $cond));
        } else {
            $data = array_merge($data, $cond);
            return array('update' => false, 'result' => $this->insertRecord($table, $data), 'data' => $this->getData($table, $cond));
        }
    }

    public function get_single_data($name) {
        $this->result = $this->result();
//        $this->result = (array) $this->result;
        return ( isset($this->result) && isset($this->result[$name]) ) ? $this->result[$name] : false;
    }

    public function get_data($field, $cond = array(), $table = '') {
        $_table = $this->table();
        if (!$_table && $table) {
            $this->setTable($table);
        }
        return $this->setWhere($cond)->execute()->get_single_data($field);
    }

    public function list_fields($table) {
        return (is_bool($table) && $table === true) ? $this->resultOB()->list_fields() : $this->db->list_fields($table);
    }

    public function get_generated_query($wrapper = false, $wrapper_start = '(', $wrapper_end = ')') {
        $q = $this->setQuery()->getQuery();
        return ($wrapper) ? $wrapper_start . $q . $wrapper_end : $q;
    }

    public function __debug_query($exit = false) {
        debug($this->get_generated_query(), $exit);
    }

    public function delete_rows() {
        $this->queryType('DELETE');
        return $this->execute()->resultOB();
    }

    public function update_rows($data) {
        if ($data) {
            $a = "SET " . $this->make_array_to_string($data, ' AND ');
            $this->extra($a);
        }
        $this->queryType('UPDATE');
        return $this->execute()->resultOB();
    }

    private function make_array_to_string($data, $glue = ' ', $value_wrapper = "'") {
        return make_array_to_string($data, $glue, $value_wrapper);
    }

}
