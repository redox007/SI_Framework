<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$config['menus'] = array(
    array(
        'controller' => 'admin/dashboard',
        'slug' => '',
        'title' => 'Dashboard',
        'icon' => 'fa-dashboard',  
        'attr' => array()
    ),
    array(
        'controller' => 'admin/driver',
        'slug' => '',
        'parent-slug' => 'driver',
        'title' => 'Driver',
        'icon' => 'fa-support',
        'attr' => array(),
        'child' => array(
            array(
                'controller' => 'admin/driver',
                'slug' => 'register',
                'title' => 'Add Driver',
                'child-slug' => 'driver',
                'icon'  => 'fa-caret-right'
            ),
            array(
                'controller' => 'admin/driver',
                'slug' => 'lists',
                'title' => 'List Driver',
                'child-slug' => 'driver',
                'icon'  => 'fa-caret-right'
            ),
//            array(
//                'controller' => 'admin/driver',
//                'slug' => 'track',
//                'title' => 'Track Driver',
//                'child-slug' => 'driver',
//                'icon'  => 'fa-caret-right'
//            )
        )
    ),
    array(
        'controller' => 'admin/vehicle',
        'slug' => '',
        'parent-slug' => 'vehicle',
        'title' => 'Vehicle',
        'icon' => 'fa-truck',
        'attr' => array(),
        'child' => array(
            array(
                'controller' => 'admin/vehicle',
                'slug' => 'register',
                'title' => 'Add Vehicle',
                'child-slug' => 'vehicle',
                'icon'  => 'fa-caret-right'
            ),
            array(
                'controller' => 'admin/vehicle',
                'slug' => 'lists',
                'title' => 'List Vehicles',
                'child-slug' => 'vehicle',
                'icon'  => 'fa-caret-right'
            ),
//            array(
//                'controller' => 'admin/driver',
//                'slug' => 'track',
//                'title' => 'Track Driver',
//                'child-slug' => 'driver',
//                'icon'  => 'fa-caret-right'
//            )
        )
    ),
    array(
        'controller' => 'admin/customer',
        'slug' => '',
        'parent-slug' => 'customer',
        'title' => 'Customer',
        'icon' => 'fa-users',
        'attr' => array(),
        'child' => array(
            array(
                'controller' => 'admin/customer',
                'slug' => 'register',
                'title' => 'Add Customer',
                'child-slug' => 'customer',
                'icon'  => 'fa-caret-right'
            ),
            array(
                'controller' => 'admin/customer',
                'slug' => 'lists',
                'title' => 'List Customer',
                'child-slug' => 'customer',
                'icon'  => 'fa-caret-right'
            )
        )
    ),
    
    array(
        'controller' => 'admin/agency',
        'slug' => '',
        'parent-slug' => 'agency',
        'title' => 'Agency',
        'icon' => 'fa-users',
        'attr' => array(),
        'child' => array(
            array(
                'controller' => 'admin/agency',
                'slug' => 'register',
                'title' => 'Add Agency',
                'child-slug' => 'agency',
                'icon'  => 'fa-caret-right'
            ),
            array(
                'controller' => 'admin/agency',
                'slug' => 'lists',
                'title' => 'List Agencies',
                'child-slug' => 'agency',
                'icon'  => 'fa-caret-right'
            )
        )
    ),
    
    array(
        'controller' => 'admin/order',
        'slug' => '',
        'parent-slug' => 'order',
        'title' => 'Order',
        'icon' => 'fa-users',
        'attr' => array(),
        'child' => array(
            array(
                'controller' => 'admin/order',
                'slug' => 'register',
                'title' => 'Create order',
                'child-slug' => 'order',
                'icon'  => 'fa-caret-right'
            ),
            array(
                'controller' => 'admin/order',
                'slug' => 'lists',
                'title' => 'List Orders',
                'child-slug' => 'order',
                'icon'  => 'fa-caret-right'
            )
        )
    ),
    
    array(
        'controller' => 'admin/discount',
        'slug' => '',
        'parent-slug' => 'discount',
        'title' => 'Coupon',
        'icon' => 'fa-users',
        'attr' => array(),
        'child' => array(
            array(
                'controller' => 'admin/discount',
                'slug' => 'register',
                'title' => 'Add Coupon',
                'child-slug' => 'discount',
                'icon'  => 'fa-caret-right'
            ),
            array(
                'controller' => 'admin/discount',
                'slug' => 'lists',
                'title' => 'List coupons',
                'child-slug' => 'discount',
                'icon'  => 'fa-caret-right'
            )
        )
    ),
    array(
        'controller' => 'admin/labour',
        'slug' => '',
        'parent-slug' => 'labour',
        'title' => 'Labour',
        'icon' => 'fa-users',
        'attr' => array(),
        'child' => array(
            array(
                'controller' => 'admin/labour',
                'slug' => 'register',
                'title' => 'Add Labour',
                'child-slug' => 'labour',
                'icon'  => 'fa-caret-right'
            ),
            array(
                'controller' => 'admin/labour',
                'slug' => 'lists',
                'title' => 'List labours',
                'child-slug' => 'labour',
                'icon'  => 'fa-caret-right'
            )
        )
    ),
    array(
        'controller' => 'admin/define',
        'slug' => '',
        'parent-slug' => 'define',
        'title' => 'Definations',
        'icon' => 'fa-users',
        'attr' => array(),
        'child' => array(
            array(
                'controller' => 'admin/define',
                'slug' => 'places',
                'title' => 'Add Places',
                'child-slug' => 'define',
                'icon'  => 'fa-caret-right'
            ),
            array(
                'controller' => 'admin/define',
                'slug' => 'listplaces',
                'title' => 'List Places',
                'child-slug' => 'define',
                'icon'  => 'fa-caret-right'
            ),
            array(
                'controller' => 'admin/define',
                'slug' => 'ratecard',
                'title' => 'Add RCard',
                'child-slug' => 'define',
                'icon'  => 'fa-caret-right'
            ),
            array(
                'controller' => 'admin/define',
                'slug' => 'ratecard_list',
                'title' => 'List RCard',
                'child-slug' => 'define',
                'icon'  => 'fa-caret-right'
            ),
            array(
                'controller' => 'admin/define',
                'slug' => 'special_type',
                'title' => 'Special Types',
                'child-slug' => 'define',
                'icon'  => 'fa-caret-right'
            ),
            array(
                'controller' => 'admin/define',
                'slug' => 'tonnege',
                'title' => 'Tonnege',
                'child-slug' => 'define',
                'icon'  => 'fa-caret-right'
            ),
            array(
                'controller' => 'admin/define',
                'slug' => 'timeframes',
                'title' => 'Timeframes',
                'child-slug' => 'define',
                'icon'  => 'fa-caret-right'
            )
        )
    ),
);
