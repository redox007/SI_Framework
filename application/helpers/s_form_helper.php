<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
if (!function_exists('get_form_dropdown')) {
    function get_form_dropdown($data, $options = array(), $selected = '', $extra = '') {
        return form_dropdown($data, $options, $selected, $extra);
    }

}

if ( ! function_exists('form_number'))
{
	/**
	 * Text Input Field
	 *
	 * @param	mixed
	 * @param	string
	 * @param	string
	 * @return	string
	 */
	function form_number($data = '', $value = '', $extra = '')
	{
		$defaults = array(
			'type' => 'number',
			'name' => is_array($data) ? '' : $data,
			'value' => $value
		);

		return '<input '._parse_form_attributes($data, $defaults).$extra." />\n";
	}
}


