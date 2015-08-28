<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menu
 *
 * @author Suchandan
 */
class S_menu {

    private $CI;
    private $menus;
    private $controller;
    private $action;

    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->config->load('s_config/S_menu');
        $this->menus = $this->CI->config->item('menus');
        $this->setCrrentUri();
    }

    public function getMenu() {
        return $this->menus;
    }

    public function menuProcessor($menu = array(), $wrappers = array()) {

        $main_menu = '';
        $menu = ($menu) ? $menu : $this->getMenu();
        $default_wrapper = array(
            'link_container' => '<li>',
            'link_container_end' => '</li>',
            'text_wrapper' => '',
            'text_wrapper_end' => '',
            'icon' => true
        );
        $wrappers = array_merge($default_wrapper, $wrappers);
        if ($menu) {
            foreach ($menu as $menu_item) {
                $main_menu .= $this->manuMaker($menu_item, $wrappers);
            }
        }

        return $main_menu;
    }

    private function makeAttributeText($attr) {
        $attr_text = array();
        if ($attr) {
            foreach ($attr as $attr_key => $attr_val) {
                $attr_text[] = "$attr_key = '$attr_val'";
            }
        }
        return $attr_text;
    }

    private function checkActive($controller,$action,$is_child = false) {
        return (($this->controller == $controller && $this->action == $action));
    }

    private function manuMaker($menu_item, $wrappers, $child = false) {
        $output = '';
        $child_menu_parent = false;
        $active = false;
//        print_r($menu_item); 
        if ($menu_item) {

            $child_menu = '';
            
            $controler = $menu_item['controller'];
            $slug = $menu_item['slug'];
            $url = base_url($controler . '/' . $slug);
            $attr = (isset($menu_item['attr'])) ? $menu_item['attr'] : array();
            
            $active = $this->checkActive($controler,$slug);
            
            $output .= $wrappers['link_container'];
            
            if (isset($menu_item['child']) && !empty($menu_item['child'])) {

                $child_menu = '<ul class="nav nav-second-level">';
                foreach ($menu_item['child'] as $menu_item_child) {
                    $child_menu .= $this->manuMaker($menu_item_child, $wrappers, true);
                }
                $child_menu .= '</ul>';
                $url = '#';
                $child_menu_parent = true;
            }
            if ($active) {
                $attr['class'] = (isset($attr['class']) && $attr['class']) ? $attr['class'] . ' '.'active' : 'active';
            }
            if ($child_menu_parent) {
                $attr['class'] = 'dropmenu';
            }
//            print_r($attr);
            $attr_text = implode(' ', $this->makeAttributeText($attr));
            
            $output .= '<a  ' . $attr_text . ' href="' . $url . '">';

            if ($wrappers['icon'] && isset($menu_item['icon']) && $menu_item['icon']) {
                $output .= '<i class="fa ' . $menu_item['icon'] . ' fa-fw"></i>';
            } elseif (isset($menu_item['icon']) && $menu_item['icon']) {
                $output .= $menu_item['icon'];
            }
            
            $output .= $wrappers['text_wrapper'];
            $output .= '<span class="hidden-tablet"> '.$menu_item['title'].'</span>';
            if ($child_menu_parent) {
                $output .= '<span class="pull-right dropper-icon"> <i class="fa fa-arrow-circle-o-right"></i> </span>';
            }
            $output .= $wrappers['text_wrapper_end'];
            $output .= '</a>';
            $output .= $child_menu;
            $output .= $wrappers['link_container_end'];
            $child_menu_parent = false;
        }
        return $output;
    }

    public function setCrrentUri() {
        $this->controller = $this->CI->uri->segment(1);
        $this->action = $this->CI->uri->segment(2);
    }

}
