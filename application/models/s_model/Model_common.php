<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_common
 *
 * @author Suchandan
 */
class Model_common extends MY_Model {

    public function __construct() {
        parent::__construct();
    }

    public function check_with_fields($table, $field_where_or, $extra = '') {
        $this->setTable($table);
        if ($extra) {
            $this->setWhereString($extra);
        }
        return $this->setWhereGroupString($field_where_or, "OR")->execute()->result();
    }

    public function check_with_specific($table, $key, $value, $extra = '') {
        $this->setTable($table);
        if ($extra) {
            $this->setWhereString($extra);
        }
        return $this->setWhere($key, $value)->execute()->results();
    }

    public function check_with_specific_fields($table, $field_where_or, $extra = '') {
        $errors = array();
        if ($field_where_or) {
            foreach ($field_where_or as $key => $value) {
                if ($this->check_with_specific($table, $key, $value, $extra)) {
                    $errors[] = $key;
                }
            }
        }
        return $errors;
    }

    public function check_with_specific_fields_with_errors($table, $cond_fields, $data, $extra = '') {
        $errors = array();
        if (!$data)
            return false;
        $field_where_or = array_make(array_keys($cond_fields), $data);
        if ($field_where_or) {
            foreach ($field_where_or as $key => $value) {
                if ($this->check_with_specific($table, $key, $value, $extra)) {
                    $errors[] = $cond_fields[$key];
                }
            }
        }
        return $errors;
    }

}
