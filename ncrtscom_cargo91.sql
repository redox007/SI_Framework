-- Adminer 3.7.1 MySQL dump

SET NAMES utf8;
SET foreign_key_checks = 0;
SET time_zone = '-06:00';
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DROP TABLE IF EXISTS `cgo_access_token`;
CREATE TABLE `cgo_access_token` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `developer_id` varchar(10) NOT NULL,
  `app_id` varchar(15) NOT NULL,
  `access_token` text NOT NULL,
  `security_token` text NOT NULL,
  `life_time` int(11) NOT NULL COMMENT 'value in min',
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `cgo_access_token` (`id`, `developer_id`, `app_id`, `access_token`, `security_token`, `life_time`, `datetime`) VALUES
(1,	'CG1',	'APPCARGO91',	'',	'0a63cf687e8b87536c7ffde7512ca333',	60,	'2015-08-12 07:08:05');

DROP TABLE IF EXISTS `cgo_admin_menus`;
CREATE TABLE `cgo_admin_menus` (
  `menu_id` int(11) NOT NULL AUTO_INCREMENT,
  `controller` varchar(40) NOT NULL,
  `method` varchar(40) NOT NULL,
  `title` varchar(50) NOT NULL,
  `icon_class` varchar(20) NOT NULL,
  `class` varchar(100) NOT NULL,
  `id` varchar(20) NOT NULL,
  `attrs` varchar(255) NOT NULL,
  `route_url` text NOT NULL,
  `parent` int(11) NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_admin_menus` (`menu_id`, `controller`, `method`, `title`, `icon_class`, `class`, `id`, `attrs`, `route_url`, `parent`, `datetime`) VALUES
(1,	'dashboard',	'',	'Dashboard',	'icon-bar-chart',	'',	'',	'',	'dashboard',	0,	'2015-07-21 04:20:43');

DROP TABLE IF EXISTS `cgo_agencies`;
CREATE TABLE `cgo_agencies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `registration_no` varchar(20) NOT NULL,
  `owner_name` varchar(100) NOT NULL,
  `owner_no` int(11) NOT NULL,
  `owner_contact_name` varchar(100) NOT NULL,
  `owner_contact_no` varchar(15) NOT NULL,
  `city` varchar(15) NOT NULL,
  `area` varchar(15) NOT NULL,
  `pin_code` varchar(15) NOT NULL,
  `agency_bank_name` varchar(100) NOT NULL,
  `agency_bank_accont_no` varchar(50) NOT NULL,
  `agency_bank_ifsc` varchar(20) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1=Active,0=Inactive',
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_agencies` (`id`, `name`, `registration_no`, `owner_name`, `owner_no`, `owner_contact_name`, `owner_contact_no`, `city`, `area`, `pin_code`, `agency_bank_name`, `agency_bank_accont_no`, `agency_bank_ifsc`, `status`, `created_on`, `modified_on`) VALUES
(1,	'Tata Motors',	'585695',	'5',	0,	'tata',	'8013182266',	'pune',	'pune',	'8756952',	'SBI SARISHA',	'8565985652145898',	'1234',	1,	'2015-07-25 08:04:45',	'0000-00-00 00:00:00'),
(2,	'Ashok Layland',	'585693',	'2',	0,	'ASHOK',	'8013182269',	'pune',	'pune',	'8756952',	'SBI SARISHA',	'8565985652145895',	'1234',	1,	'2015-07-25 10:25:40',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `cgo_booking`;
CREATE TABLE `cgo_booking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` varchar(10) NOT NULL,
  `passenger_id` int(11) NOT NULL,
  `booking_type` int(11) NOT NULL DEFAULT '1' COMMENT '1= Fixed, 2= Recurring',
  `booking_date` date NOT NULL,
  `booking_time` time NOT NULL,
  `pickup_type` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1= Fixed time, 2= flexible time',
  `flexible_timeslot` tinyint(4) NOT NULL,
  `estimated_cost` double NOT NULL,
  `estimated_distance` double NOT NULL,
  `booking_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=RAISED,2=ASSIGNED(anency),3=UNASSIGNED,4=CONFIRMED,5=STARTED,6=COMPLETED,7=PAID,8=FINISHED,9=CANCELLED',
  `special_type` tinyint(4) NOT NULL,
  `capacity_type` int(11) NOT NULL DEFAULT '1' COMMENT 'Tonnage',
  `no_of_order` int(11) NOT NULL,
  `no_of_helpers` int(11) NOT NULL,
  `comments` text NOT NULL,
  `coupon` varchar(15) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `created_on` datetime NOT NULL,
  `last_nodified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `pin` varchar(15) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_booking` (`id`, `invoice_id`, `passenger_id`, `booking_type`, `booking_date`, `booking_time`, `pickup_type`, `flexible_timeslot`, `estimated_cost`, `estimated_distance`, `booking_status`, `special_type`, `capacity_type`, `no_of_order`, `no_of_helpers`, `comments`, `coupon`, `city`, `state`, `created_on`, `last_nodified`, `pin`, `driver_id`, `vehicle_id`) VALUES
(1,	'FF84EI2BV6',	9,	2,	'2015-07-29',	'00:00:00',	2,	1,	100,	19040,	2,	1,	1,	0,	3,	'',	'',	'1',	'1',	'2015-07-29 16:12:37',	'2015-07-29 04:42:37',	'700107',	2,	2),
(2,	'D8TYZPQQSY',	9,	2,	'2015-07-29',	'00:00:09',	1,	0,	100,	11.776,	1,	1,	1,	0,	7,	'',	'',	'1',	'1',	'2015-07-29 19:07:48',	'2015-07-29 07:37:48',	'700107',	1,	1),
(3,	'O4YTARXQ7E',	9,	1,	'2015-07-30',	'03:37:00',	1,	0,	100,	0.716,	1,	1,	1,	0,	0,	'',	'',	'1',	'1',	'2015-07-30 15:40:38',	'2015-07-30 04:10:38',	'700107',	0,	0),
(4,	'HMILNBV9RD',	9,	2,	'2015-08-04',	'00:00:00',	2,	2,	100,	13.632,	1,	1,	1,	0,	5,	'',	'',	'1',	'1',	'2015-08-04 12:35:19',	'2015-08-04 01:05:19',	'700107',	0,	0),
(5,	'HGVETMYMZR',	9,	1,	'2015-08-07',	'04:53:00',	1,	0,	100,	4.368,	1,	1,	1,	0,	0,	'',	'',	'1',	'1',	'2015-08-06 16:55:29',	'2015-08-06 05:25:29',	'700054',	0,	0),
(6,	'WGJCPXTCZQ',	14,	1,	'2015-08-08',	'00:00:09',	1,	0,	100,	19.1,	1,	1,	1,	0,	5,	'',	'',	'1',	'1',	'2015-08-08 00:31:09',	'2015-08-07 13:01:09',	'700090',	0,	0),
(7,	'WWPNYAKXU2',	14,	1,	'2015-08-08',	'00:00:12',	1,	0,	100,	17.765,	1,	1,	1,	0,	5,	'',	'',	'1',	'1',	'2015-08-08 09:50:34',	'2015-08-07 22:20:34',	'700107',	0,	0),
(8,	'POOAZMMWPR',	15,	2,	'2015-08-08',	'00:00:00',	2,	1,	100,	17.162,	1,	1,	1,	0,	5,	'',	'',	'1',	'1',	'2015-08-08 11:05:29',	'2015-08-07 23:35:29',	'700107',	0,	0),
(9,	'8VT13X0FBR',	15,	1,	'2015-08-08',	'00:00:01',	1,	0,	100,	17.162,	1,	1,	1,	0,	5,	'',	'',	'1',	'1',	'2015-08-08 11:10:40',	'2015-08-07 23:40:40',	'700107',	0,	0),
(10,	'NNO3BBRYSO',	9,	1,	'2015-08-08',	'00:00:00',	2,	2,	100,	175.769,	1,	1,	1,	0,	3,	'',	'',	'1',	'1',	'2015-08-08 11:38:39',	'2015-08-08 00:08:39',	'700107',	0,	0);

DROP TABLE IF EXISTS `cgo_discount_coupons`;
CREATE TABLE `cgo_discount_coupons` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coupon_code` varchar(20) NOT NULL,
  `discount_persent` float NOT NULL,
  `validity` int(11) NOT NULL,
  `used` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_discount_coupons` (`id`, `coupon_code`, `discount_persent`, `validity`, `used`, `created_on`) VALUES
(1,	'6w4MSH',	23,	7,	0,	'2015-07-25 15:03:55'),
(2,	'rDbNNx',	21,	7,	0,	'2015-07-25 15:05:50');

DROP TABLE IF EXISTS `cgo_drivers`;
CREATE TABLE `cgo_drivers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(51) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `email_id` varchar(255) NOT NULL,
  `license_no` varchar(50) NOT NULL,
  `license_type` varchar(100) NOT NULL,
  `adhar_card_no` varchar(50) NOT NULL,
  `dob` date NOT NULL,
  `experience` float NOT NULL,
  `password` varchar(250) NOT NULL,
  `city` varchar(50) NOT NULL,
  `area` varchar(50) NOT NULL,
  `pin` varchar(50) NOT NULL,
  `address` varchar(50) NOT NULL,
  `bank_name` varchar(50) NOT NULL,
  `bank_account_no` varchar(50) NOT NULL,
  `bank_ifsc_code` varchar(50) NOT NULL,
  `reffer_code` varchar(20) NOT NULL,
  `religion` varchar(20) NOT NULL,
  `token` varchar(15) NOT NULL,
  `status` int(4) NOT NULL DEFAULT '1' COMMENT '1=active,0=inactive',
  `device_id` varchar(255) NOT NULL,
  `push_id` varchar(255) NOT NULL,
  `os_type` int(4) NOT NULL,
  `driver_image` text NOT NULL,
  `lattitude` varchar(10) NOT NULL,
  `longitude` varchar(10) NOT NULL,
  `modified_on` datetime NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_drivers` (`id`, `first_name`, `middle_name`, `last_name`, `full_name`, `phone_no`, `email_id`, `license_no`, `license_type`, `adhar_card_no`, `dob`, `experience`, `password`, `city`, `area`, `pin`, `address`, `bank_name`, `bank_account_no`, `bank_ifsc_code`, `reffer_code`, `religion`, `token`, `status`, `device_id`, `push_id`, `os_type`, `driver_image`, `lattitude`, `longitude`, `modified_on`, `created_on`) VALUES
(1,	'Tapamoy',	'',	'Das',	'',	'8609770752',	'tapamoydasncrts',	'TPDAS',	'',	'TPXXX',	'1990-10-21',	18,	'e10adc3949ba59abbe56e057f20f883e',	'1',	'Kolkata',	'713206',	'Kolkata',	'State Bank of India',	'789563258967',	'SBIN5698',	'AR678',	'Hindu',	'',	1,	'753eba2b6870b532',	'466665446501',	1,	'uploads/truck/driver-image.jpeg',	'22.5106313',	'88.3986994',	'2015-06-29 18:33:28',	'2015-06-29 18:31:25'),
(2,	'',	'',	'',	'Test driver',	'3423423432',	'',	'',	'',	'',	'0000-00-00',	0,	'123456',	'',	'',	'',	'',	'',	'',	'',	'',	'',	'',	0,	'',	'',	0,	'uploads/truck/driver-image.jpeg',	'',	'',	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(3,	'',	'',	'',	'Test driver 2',	'3242342342',	'',	'',	'',	'',	'2015-02-10',	0,	'123456',	'kolkata',	'asdas',	'8524859855',	'asd as da',	'SBI',	'789563258965',	'8569',	'',	'',	'',	1,	'',	'',	0,	'uploads/truck/driver-image.jpeg',	'',	'',	'0000-00-00 00:00:00',	'2015-07-23 18:57:43'),
(4,	'Test',	'0',	'Test',	'',	'8965985632',	'',	'',	'',	'0',	'2015-08-12',	0,	'e10adc3949ba59abbe56e057f20f883e',	'',	'',	'',	'',	'0',	'0',	'0',	'AR678',	'',	'',	1,	'',	'',	0,	'',	'',	'',	'0000-00-00 00:00:00',	'2015-08-08 16:46:00'),
(5,	'fens',	'd',	'd',	'',	'5',	'gsh@nz.nd',	'E',	'NOT KNOWN',	'',	'0000-00-00',	1,	'7694f4a66316e53c8cdd9d9954bd611d',	'Pune',	'',	'',	'e',	'',	'',	'',	'0',	'HINDUISM',	'',	1,	'',	'',	0,	'/uploads/driver/DV-1439214586_thumb.jpg',	'',	'',	'0000-00-00 00:00:00',	'2015-08-10 19:19:46');

DROP TABLE IF EXISTS `cgo_driver_rating`;
CREATE TABLE `cgo_driver_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `total_rating_no` int(11) NOT NULL,
  `total_rating` float NOT NULL,
  `avg_rating` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_driver_rating` (`id`, `driver_id`, `order_id`, `booking_id`, `total_rating_no`, `total_rating`, `avg_rating`) VALUES
(1,	1,	7,	2,	6,	19,	3.17),
(2,	2,	5,	1,	5,	12,	2.4);

DROP TABLE IF EXISTS `cgo_driver_schedule`;
CREATE TABLE `cgo_driver_schedule` (
  `id` int(11) NOT NULL,
  `driver_id` int(11) NOT NULL,
  `pickup_date` date NOT NULL,
  `reserve_from` time NOT NULL,
  `reserve_to` time NOT NULL,
  `status` int(4) NOT NULL DEFAULT '1' COMMENT '1=active,2=started,3=inactive',
  `datetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `cgo_driver_vehicals`;
CREATE TABLE `cgo_driver_vehicals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `driver_id` int(11) NOT NULL,
  `vehical_id` int(11) NOT NULL,
  `date_from` date NOT NULL,
  `date_to` date NOT NULL,
  `created_on` datetime NOT NULL,
  `is_current` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=current,0=past',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_driver_vehicals` (`id`, `driver_id`, `vehical_id`, `date_from`, `date_to`, `created_on`, `is_current`) VALUES
(1,	1,	1,	'2015-07-02',	'2015-07-12',	'2015-07-02 04:16:29',	1);

DROP TABLE IF EXISTS `cgo_end_user`;
CREATE TABLE `cgo_end_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `full_name` varchar(250) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `phone_no` varchar(15) NOT NULL,
  `password` varchar(200) NOT NULL,
  `status` int(4) NOT NULL DEFAULT '1' COMMENT '1=active,0=inactive',
  `reffer_code` varchar(15) NOT NULL,
  `modified_on` datetime NOT NULL,
  `created_on` datetime NOT NULL,
  `token` varchar(100) NOT NULL,
  `device_id` varchar(255) NOT NULL,
  `push_id` varchar(255) NOT NULL,
  `os_type` int(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_end_user` (`id`, `full_name`, `email_id`, `phone_no`, `password`, `status`, `reffer_code`, `modified_on`, `created_on`, `token`, `device_id`, `push_id`, `os_type`) VALUES
(1,	'Suchandan Haldar',	'suchandan.bcet@gmail.com',	'8013182265',	'827ccb0eea8a706c4c34a16891f84e7b',	1,	'',	'0000-00-00 00:00:00',	'2015-07-24 07:36:09',	'',	'',	'',	0),
(2,	'Test',	'test@gmail.com',	'8965985632',	'e10adc3949ba59abbe56e057f20f883e',	1,	'AR678',	'0000-00-00 00:00:00',	'2015-06-29 19:01:17',	'',	'',	'',	0),
(3,	'Tapamoy Das',	'ncrtsmobile@gmail.com',	'1234567890',	'8fa14cdd754f91cc6554c9e71929cce7',	1,	'qwerty',	'0000-00-00 00:00:00',	'2015-07-08 15:22:17',	'kxHeW',	'927c8d7843c9c005',	'466665446501',	1),
(4,	'amitava',	'aa.chatterjee266@gmail.com',	'8337047084',	'81dc9bdb52d04dc20036dbd8313ed055',	1,	'1234',	'0000-00-00 00:00:00',	'2015-07-08 16:09:49',	'',	'',	'',	0),
(5,	'hhHHh',	'bssh@g.vv',	'8553110559',	'202cb962ac59075b964b07152d234b70',	1,	'hahha',	'0000-00-00 00:00:00',	'2015-07-10 17:33:34',	'',	'',	'',	0),
(6,	'fyyyy',	'vhhhu@tg.gg',	'855355',	'202cb962ac59075b964b07152d234b70',	1,	'gjhvbb',	'0000-00-00 00:00:00',	'2015-07-10 19:07:08',	'',	'',	'',	0),
(7,	'Debasish Dash',	'debasishdash@yahoo.com',	'9922531489',	'fee3db4969866b1a5a3d78a15c9cde54',	1,	'',	'0000-00-00 00:00:00',	'2015-07-10 21:49:44',	'',	'',	'',	0),
(8,	'Tapamoy Das',	'tapamoydasncrts@gmail.com',	'8609770752',	'e10adc3949ba59abbe56e057f20f883e',	1,	'12345',	'0000-00-00 00:00:00',	'2015-07-21 14:38:22',	'',	'927c8d7843c9c005',	'466665446501',	1),
(9,	'tapamoy das',	'tapamoydas@gmail.com',	'12345',	'e10adc3949ba59abbe56e057f20f883e',	1,	'',	'0000-00-00 00:00:00',	'2015-07-21 16:04:08',	'',	'11edbc7e78160de6',	'466665446501',	1),
(11,	'asdasd',	'subho253@gmail.com',	'8609770755',	'123456',	1,	'',	'0000-00-00 00:00:00',	'2015-07-23 19:27:55',	'',	'',	'',	0),
(12,	'asd asd as',	'subho126@gmail.com',	'3423423432',	'123456',	1,	'',	'0000-00-00 00:00:00',	'2015-07-23 19:28:33',	'',	'',	'',	0),
(13,	'Poojashree',	'poo@g.com',	'468683867588',	'202cb962ac59075b964b07152d234b70',	1,	'',	'0000-00-00 00:00:00',	'2015-08-05 19:03:05',	'',	'11edbc7e78160de6',	'466665446501',	1),
(14,	'amitava chatterjer',	'amitava.ncrts@gmail.com',	'8337047089',	'827ccb0eea8a706c4c34a16891f84e7b',	1,	'',	'0000-00-00 00:00:00',	'2015-08-07 17:44:14',	'',	'4ae2d4450cf3eb28',	'466665446501',	1),
(15,	'amit das',	'amit@gmail.com',	'8553110554',	'827ccb0eea8a706c4c34a16891f84e7b',	1,	'',	'0000-00-00 00:00:00',	'2015-08-08 10:32:30',	'',	'4ae2d4450cf3eb28',	'466665446501',	1),
(16,	'amitava',	'dip@gmail.com',	'8531456786',	'1649bbcec1ce5f2e51670448911d1fa3',	1,	'',	'0000-00-00 00:00:00',	'2015-08-11 12:10:23',	'',	'4ae2d4450cf3eb28',	'466665446501',	1);

DROP TABLE IF EXISTS `cgo_faq`;
CREATE TABLE `cgo_faq` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_faq` (`id`, `question`, `answer`) VALUES
(1,	'Question 1',	'Answer 1'),
(2,	'Question 2',	'Answer 2');

DROP TABLE IF EXISTS `cgo_fevorite_location`;
CREATE TABLE `cgo_fevorite_location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `passenger_id` int(11) NOT NULL,
  `latitude` varchar(15) NOT NULL,
  `longitude` varchar(15) NOT NULL,
  `city` varchar(10) NOT NULL,
  `state` varchar(10) NOT NULL,
  `country` varchar(10) NOT NULL,
  `pin_code` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_fevorite_location` (`id`, `passenger_id`, `latitude`, `longitude`, `city`, `state`, `country`, `pin_code`, `address`, `datetime`) VALUES
(1,	2,	'34.9087',	'66.2568',	'1',	'1',	'1',	'700030',	'Rajdanga Main Road, East Kolkata Township, Kolkata, West Bengal',	'2015-07-07 17:09:31'),
(2,	2,	'34.9087',	'66.2568',	'2',	'',	'1',	'7000107',	'Bansdroni Metro Station, Bansdroni Post Office Road, Bansdroni, Kolkata, West Bengal',	'2015-07-08 13:26:33'),
(3,	3,	'34.9087',	'66.2568',	'2',	'',	'1',	'7000107',	'Bansdroni Metro Station, Bansdroni Post Office Road, Bansdroni, Kolkata, West Bengal',	'2015-07-24 18:04:53'),
(4,	9,	'22.510583052180',	'88.398698084056',	'Kolkata',	'',	'India',	'700107',	'Sector G,East Kolkata Township,Kolkata',	'2015-08-12 12:45:05'),
(5,	9,	'22.128772642441',	'87.284528575837',	'West Medin',	'',	'India',	'721133',	'Belma',	'2015-08-12 14:27:20'),
(6,	9,	'22.5176176',	'88.3840499',	'Kolkata',	'',	'India',	'123456',	'Kasba, Kolkata, West Bengal, India',	'2015-08-12 14:29:12'),
(7,	9,	'22.5176176',	'88.3840499',	'Kolkata',	'',	'India',	'123456',	'Kasba, Kolkata, West Bengal, India',	'2015-08-12 14:29:14');

DROP TABLE IF EXISTS `cgo_invite`;
CREATE TABLE `cgo_invite` (
  `id` int(11) NOT NULL,
  `passenger_id` int(11) NOT NULL,
  `send_to` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `send_type` int(2) NOT NULL DEFAULT '1' COMMENT '1=email,2=sms',
  `send_status` int(2) NOT NULL DEFAULT '1' COMMENT '1 = sent , 0 = not sent',
  `accept_status` int(2) NOT NULL COMMENT '1 = accepted , 2 = rejected',
  `created_on` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `cgo_invite` (`id`, `passenger_id`, `send_to`, `message`, `send_type`, `send_status`, `accept_status`, `created_on`) VALUES
(0,	9,	'tapamoydasncrts@gmail.com',	'Friends earn Rs 200 \n\nFriend Rides,you earn Rs.200\n\nShare your referal code 0XD48KL\n\n',	1,	1,	0,	'2015-08-06 00:00:00'),
(0,	9,	'tapamoydasncrts@gmail.com',	'\nFriends earn Rs 200 \n\nFriend Rides,you earn Rs.200\n\nShare your referal code 0XD48KL\n\n',	1,	1,	0,	'2015-08-06 00:00:00'),
(0,	9,	'8609770752',	'Friends earn Rs 200 \n\n\n\nFriend Rides,you earn Rs.200\n\nShare your referal code 0XD48KL\n\n',	2,	1,	0,	'2015-08-06 00:00:00'),
(0,	9,	'8609770752',	'Friends earn Rs 200 \n\n\n\nFriend Rides,you earn Rs.200\n\nShare your referal code 0XD48KL\n\n',	2,	1,	0,	'2015-08-06 00:00:00');

DROP TABLE IF EXISTS `cgo_labours`;
CREATE TABLE `cgo_labours` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `city` varchar(20) NOT NULL,
  `area` varchar(50) NOT NULL,
  `address` text NOT NULL,
  `agency_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_labours` (`id`, `name`, `phone`, `city`, `area`, `address`, `agency_id`, `status`, `created_on`, `modified_on`) VALUES
(1,	'Nirmal Jhalor',	'8025658985',	'Kolkata',	'Kolkata',	'a sdas dsa dasdsads',	1,	1,	'2015-07-27 15:40:38',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `cgo_master_city`;
CREATE TABLE `cgo_master_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `state` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `state` (`state`),
  KEY `country` (`country`),
  CONSTRAINT `cgo_master_city_ibfk_1` FOREIGN KEY (`state`) REFERENCES `cgo_master_state` (`id`),
  CONSTRAINT `cgo_master_city_ibfk_2` FOREIGN KEY (`country`) REFERENCES `cgo_master_country` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_master_city` (`id`, `name`, `state`, `country`, `code`) VALUES
(1,	'Kolkata',	1,	1,	'kol'),
(2,	'Pune',	2,	1,	'pune');

DROP TABLE IF EXISTS `cgo_master_country`;
CREATE TABLE `cgo_master_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_master_country` (`id`, `name`, `code`) VALUES
(1,	'India',	'IN');

DROP TABLE IF EXISTS `cgo_master_special_types`;
CREATE TABLE `cgo_master_special_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_master_special_types` (`id`, `name`) VALUES
(1,	'Open truck'),
(2,	'Covered Truck'),
(3,	'Special truck'),
(4,	'Metalic truck');

DROP TABLE IF EXISTS `cgo_master_state`;
CREATE TABLE `cgo_master_state` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `country` int(11) NOT NULL,
  `code` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_master_state` (`id`, `name`, `country`, `code`) VALUES
(1,	'West Bengal',	1,	'WB'),
(2,	'Maharastra',	1,	'MH');

DROP TABLE IF EXISTS `cgo_master_timeframe`;
CREATE TABLE `cgo_master_timeframe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start` time NOT NULL,
  `end` time NOT NULL,
  `discount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_master_timeframe` (`id`, `start`, `end`, `discount`) VALUES
(1,	'02:00:00',	'04:00:00',	18),
(2,	'06:00:00',	'09:00:00',	12),
(3,	'09:00:00',	'11:00:00',	22);

DROP TABLE IF EXISTS `cgo_master_tonnage`;
CREATE TABLE `cgo_master_tonnage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `staus` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_master_tonnage` (`id`, `name`, `staus`) VALUES
(1,	'0.5-1',	1),
(2,	'1-2',	1),
(3,	'2-3',	1),
(4,	'3-4',	1);

DROP TABLE IF EXISTS `cgo_metadata`;
CREATE TABLE `cgo_metadata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `meta_key` varchar(50) NOT NULL,
  `meta_value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_metadata` (`id`, `meta_key`, `meta_value`) VALUES
(1,	'customer_care_no',	'1800-569 4589'),
(2,	'session_timeout',	'10');

DROP TABLE IF EXISTS `cgo_orders`;
CREATE TABLE `cgo_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_no` int(11) NOT NULL,
  `pickup_address` text NOT NULL,
  `pickup_lat` varchar(15) NOT NULL,
  `pickup_long` varchar(15) NOT NULL,
  `drop_address` text NOT NULL,
  `drop_lat` varchar(15) NOT NULL,
  `drop_long` varchar(15) NOT NULL,
  `pickup_date` date NOT NULL,
  `requested_pickup_time` time NOT NULL,
  `confirmed_pickup_time` time NOT NULL,
  `is_flexible` tinyint(4) NOT NULL,
  `flexible_time_id` tinyint(4) NOT NULL,
  `driver_no` int(11) NOT NULL,
  `vehical_no` int(11) NOT NULL,
  `order_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=RAISED,2=CONFIRMED,3=GOINGTO,4=ARRIVED,5=STARTED,6=REACHED,7=DELIVERED,8=PAID,9=FINISHED,10=CANCELLED',
  `driver_rating` int(11) NOT NULL,
  `pin` varchar(15) NOT NULL,
  `actual_arival_time` time NOT NULL,
  `actual_start_time` time NOT NULL,
  `actual_drop_time` time NOT NULL,
  `actual_time_taken` double NOT NULL COMMENT 'in minute',
  `actual_distance` double NOT NULL COMMENT 'in metere',
  `wating_time` double NOT NULL COMMENT 'in second',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_orders` (`id`, `booking_no`, `pickup_address`, `pickup_lat`, `pickup_long`, `drop_address`, `drop_lat`, `drop_long`, `pickup_date`, `requested_pickup_time`, `confirmed_pickup_time`, `is_flexible`, `flexible_time_id`, `driver_no`, `vehical_no`, `order_status`, `driver_rating`, `pin`, `actual_arival_time`, `actual_start_time`, `actual_drop_time`, `actual_time_taken`, `actual_distance`, `wating_time`) VALUES
(1,	1,	'Sector G,East Kolkata Township,Kolkata,',	'22.5105711',	'88.3987666',	'Dashadrone, Kaikhali, Rajarhat, West Bengal, India',	'22.6308327',	'88.4478079',	'2015-08-01',	'00:00:00',	'00:00:00',	1,	0,	1,	0,	9,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(2,	1,	'Sector G,East Kolkata Township,Kolkata,',	'22.5105711',	'88.3987666',	'Dashadrone, Kaikhali, Rajarhat, West Bengal, India',	'22.6308327',	'88.4478079',	'2015-07-29',	'00:00:00',	'00:00:00',	1,	0,	1,	0,	7,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(3,	1,	'Sector G,East Kolkata Township,Kolkata,',	'22.5105711',	'88.3987666',	'Dashadrone, Kaikhali, Rajarhat, West Bengal, India',	'22.6308327',	'88.4478079',	'2015-08-03',	'00:00:00',	'00:00:00',	1,	0,	1,	0,	9,	3,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(4,	1,	'Sector G,East Kolkata Township,Kolkata,',	'22.5105711',	'88.3987666',	'Dashadrone, Kaikhali, Rajarhat, West Bengal, India',	'22.6308327',	'88.4478079',	'2015-07-31',	'00:00:00',	'00:00:00',	1,	0,	1,	0,	9,	2,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(5,	1,	'Sector G,East Kolkata Township,Kolkata,',	'22.5105711',	'88.3987666',	'Dashadrone, Kaikhali, Rajarhat, West Bengal, India',	'22.6308327',	'88.4478079',	'2015-08-02',	'00:00:00',	'00:00:00',	1,	0,	1,	0,	9,	4,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(6,	2,	'Sector G,East Kolkata Township,Kolkata',	'22.5106272',	'88.398732',	'HDFC BANK, CR Avenue Road, Chandni Chawk, Kolkata, West Bengal, India',	'22.5660079',	'88.352522900000',	'2015-08-01',	'00:00:09',	'00:00:00',	0,	0,	0,	0,	9,	4,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(7,	2,	'Sector G,East Kolkata Township,Kolkata',	'22.5106272',	'88.398732',	'HDFC BANK, CR Avenue Road, Chandni Chawk, Kolkata, West Bengal, India',	'22.5660079',	'88.352522900000',	'2015-07-29',	'00:00:09',	'00:00:00',	0,	0,	0,	0,	9,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(8,	2,	'Sector G,East Kolkata Township,Kolkata',	'22.5106272',	'88.398732',	'HDFC BANK, CR Avenue Road, Chandni Chawk, Kolkata, West Bengal, India',	'22.5660079',	'88.352522900000',	'2015-08-02',	'00:00:09',	'00:00:00',	0,	0,	0,	0,	3,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(9,	2,	'Sector G,East Kolkata Township,Kolkata',	'22.5106272',	'88.398732',	'HDFC BANK, CR Avenue Road, Chandni Chawk, Kolkata, West Bengal, India',	'22.5660079',	'88.352522900000',	'2015-07-30',	'00:00:09',	'00:00:00',	0,	0,	0,	0,	1,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(10,	2,	'Sector G,East Kolkata Township,Kolkata',	'22.5106272',	'88.398732',	'HDFC BANK, CR Avenue Road, Chandni Chawk, Kolkata, West Bengal, India',	'22.5660079',	'88.352522900000',	'2015-08-03',	'00:00:09',	'00:00:00',	0,	0,	0,	0,	8,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(11,	2,	'Sector G,East Kolkata Township,Kolkata',	'22.5106272',	'88.398732',	'HDFC BANK, CR Avenue Road, Chandni Chawk, Kolkata, West Bengal, India',	'22.5660079',	'88.352522900000',	'2015-07-31',	'00:00:09',	'00:00:00',	0,	0,	0,	0,	5,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(12,	2,	'Sector G,East Kolkata Township,Kolkata',	'22.5106272',	'88.398732',	'HDFC BANK, CR Avenue Road, Chandni Chawk, Kolkata, West Bengal, India',	'22.5660079',	'88.352522900000',	'2015-08-04',	'00:00:09',	'00:00:00',	0,	0,	0,	0,	2,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(13,	3,	'Sector G,East Kolkata Township,Kolkata',	'22.510636016179',	'88.398704119026',	'Ruby, Kolkata, West Bengal, India',	'22.5127254',	'88.4020311',	'2015-07-30',	'03:37:00',	'00:00:00',	0,	0,	0,	0,	1,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(14,	4,	'Sector G,East Kolkata Township,Kolkata',	'22.510658936266',	'88.398711159825',	'Hastings, Kolkata, West Bengal, India',	'22.5487295',	'88.336076499999',	'2015-08-05',	'00:00:00',	'00:00:00',	1,	0,	0,	0,	1,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(15,	4,	'Sector G,East Kolkata Township,Kolkata',	'22.510658936266',	'88.398711159825',	'Hastings, Kolkata, West Bengal, India',	'22.5487295',	'88.336076499999',	'2015-08-08',	'00:00:00',	'00:00:00',	1,	0,	0,	0,	1,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(16,	4,	'Sector G,East Kolkata Township,Kolkata',	'22.510658936266',	'88.398711159825',	'Hastings, Kolkata, West Bengal, India',	'22.5487295',	'88.336076499999',	'2015-08-04',	'00:00:00',	'00:00:00',	1,	0,	0,	0,	1,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(17,	5,	'Phool Bagan,Kankurgachi,Kolkata',	'22.579626830593',	'88.394229188561',	'Kolkata, West Bengal, India',	'22.572646',	'88.363895000000',	'2015-08-07',	'04:53:00',	'00:00:00',	0,	0,	0,	0,	1,	0,	'700054',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(18,	6,	'Sadhan Pally,Baranagar',	'22.637334894269',	'88.382448926568',	'Kasba Police Station, Kolkata, West Bengal, India',	'22.5194695',	'88.382940699999',	'2015-08-08',	'00:00:09',	'00:00:00',	0,	0,	0,	0,	1,	0,	'700090',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(19,	7,	'Sector G,East Kolkata Township,Kolkata',	'22.510639113488',	'88.398673944175',	'Baranagar Police Station, Kolkata, West Bengal, India',	'22.6360614',	'88.3784457',	'2015-08-08',	'00:00:12',	'00:00:00',	0,	0,	0,	0,	1,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(20,	8,	'Sector G,East Kolkata Township,Kolkata',	'22.510643139990',	'88.398698084056',	'Baranagar Narendranath Vidyamandir, Satchashipara, Kolkata, West Bengal, India',	'22.6321914',	'88.373796399999',	'2015-08-08',	'00:00:00',	'00:00:00',	1,	0,	0,	0,	1,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(21,	8,	'Sector G,East Kolkata Township,Kolkata',	'22.510643139990',	'88.398698084056',	'Baranagar Narendranath Vidyamandir, Satchashipara, Kolkata, West Bengal, India',	'22.6321914',	'88.373796399999',	'2015-08-09',	'00:00:00',	'00:00:00',	1,	0,	0,	0,	1,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(22,	9,	'Sector G,East Kolkata Township,Kolkata',	'22.5106431',	'88.3986977',	'Baranagar Narendranath Vidyamandir, Satchashipara, Kolkata, West Bengal, India',	'22.6321914',	'88.373796399999',	'2015-08-08',	'00:00:01',	'00:00:00',	0,	0,	0,	0,	1,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0),
(23,	10,	'Sector G,East Kolkata Township,Kolkata',	'22.5106315',	'88.3987022',	'Kashba Junior Basic School, Adlabad, Egra, West Bengal, India',	'21.9025766',	'87.54462',	'2015-08-08',	'00:00:00',	'00:00:00',	1,	0,	0,	0,	1,	0,	'700107',	'00:00:00',	'00:00:00',	'00:00:00',	0,	0,	0);

DROP TABLE IF EXISTS `cgo_orders_tracking`;
CREATE TABLE `cgo_orders_tracking` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `booking_no` int(11) NOT NULL,
  `order_no` int(11) NOT NULL,
  `current_lat` varchar(15) NOT NULL,
  `current_long` varchar(15) NOT NULL,
  `tracking_status` int(11) NOT NULL DEFAULT '1' COMMENT '1= requested, 2= inactive,3=completed',
  `order_status` int(11) NOT NULL DEFAULT '1' COMMENT '1= requested, 2= Confirmed,3=arrived,4=started, 5 = completed, 6= Cancelled',
  `updated_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_orders_tracking` (`id`, `booking_no`, `order_no`, `current_lat`, `current_long`, `tracking_status`, `order_status`, `updated_on`) VALUES
(1,	1,	1,	'',	'',	1,	1,	'2015-07-29 04:42:37'),
(2,	1,	2,	'',	'',	1,	1,	'2015-07-29 04:42:37'),
(3,	1,	3,	'',	'',	1,	1,	'2015-07-29 04:42:37'),
(4,	1,	4,	'',	'',	1,	1,	'2015-07-29 04:42:37'),
(5,	1,	5,	'',	'',	1,	1,	'2015-07-29 04:42:37'),
(6,	2,	6,	'',	'',	1,	1,	'2015-07-29 07:37:48'),
(7,	2,	7,	'',	'',	1,	1,	'2015-07-29 07:37:48'),
(8,	2,	8,	'',	'',	1,	1,	'2015-07-29 07:37:48'),
(9,	2,	9,	'',	'',	1,	1,	'2015-07-29 07:37:48'),
(10,	2,	10,	'',	'',	1,	1,	'2015-07-29 07:37:48'),
(11,	2,	11,	'',	'',	1,	1,	'2015-07-29 07:37:48'),
(12,	2,	12,	'',	'',	1,	1,	'2015-07-29 07:37:48'),
(13,	3,	13,	'',	'',	1,	1,	'2015-07-30 04:10:38'),
(14,	4,	14,	'',	'',	1,	1,	'2015-08-04 01:05:19'),
(15,	4,	15,	'',	'',	1,	1,	'2015-08-04 01:05:19'),
(16,	4,	16,	'',	'',	1,	1,	'2015-08-04 01:05:19'),
(17,	5,	17,	'',	'',	1,	1,	'2015-08-06 05:25:29'),
(18,	6,	18,	'',	'',	1,	1,	'2015-08-07 13:01:09'),
(19,	7,	19,	'',	'',	1,	1,	'2015-08-07 22:20:34'),
(20,	8,	20,	'',	'',	1,	1,	'2015-08-07 23:35:29'),
(21,	8,	21,	'',	'',	1,	1,	'2015-08-07 23:35:29'),
(22,	9,	22,	'',	'',	1,	1,	'2015-08-07 23:40:40'),
(23,	10,	23,	'',	'',	1,	1,	'2015-08-08 00:08:39');

DROP TABLE IF EXISTS `cgo_payments`;
CREATE TABLE `cgo_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_no` int(11) NOT NULL,
  `booking_no` int(11) NOT NULL,
  `total_distance` float NOT NULL,
  `total_discount` double NOT NULL,
  `wating_time` int(11) NOT NULL,
  `tolls` double NOT NULL,
  `total_cost` double NOT NULL,
  `payment_cc` double NOT NULL,
  `payment_cash` double NOT NULL,
  `payment_card` double NOT NULL,
  `payment_mode` int(2) NOT NULL DEFAULT '1' COMMENT '1=cash,2=paytm',
  `total_payment` double NOT NULL,
  `pending_payment` double NOT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `cgo_ratecard`;
CREATE TABLE `cgo_ratecard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` int(11) NOT NULL,
  `size` int(11) NOT NULL,
  `special_type` int(11) NOT NULL,
  `mode` int(11) NOT NULL,
  `mode_unit` int(11) NOT NULL,
  `mode_unit_cost` double NOT NULL,
  `waiting_hour_unit` double NOT NULL,
  `wating_hour_cost` double NOT NULL,
  `free_wating_time` double NOT NULL,
  `km_limit` int(11) NOT NULL,
  `additional_km_unit` int(11) NOT NULL,
  `additional_km_cost` double NOT NULL,
  `special_type_multiplier` int(11) NOT NULL,
  `labour_rate` double NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `city` (`city`),
  KEY `special_type` (`special_type`),
  KEY `size` (`size`),
  CONSTRAINT `cgo_ratecard_ibfk_1` FOREIGN KEY (`city`) REFERENCES `cgo_master_city` (`id`),
  CONSTRAINT `cgo_ratecard_ibfk_2` FOREIGN KEY (`size`) REFERENCES `cgo_master_tonnage` (`id`),
  CONSTRAINT `cgo_ratecard_ibfk_3` FOREIGN KEY (`special_type`) REFERENCES `cgo_master_special_types` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_ratecard` (`id`, `city`, `size`, `special_type`, `mode`, `mode_unit`, `mode_unit_cost`, `waiting_hour_unit`, `wating_hour_cost`, `free_wating_time`, `km_limit`, `additional_km_unit`, `additional_km_cost`, `special_type_multiplier`, `labour_rate`, `status`) VALUES
(2,	2,	3,	2,	1,	1,	10,	1,	15,	12,	5,	1,	12,	3,	15,	1),
(3,	1,	4,	3,	1,	25,	12,	36,	25,	10,	15,	30,	50,	5,	10,	1),
(4,	1,	3,	3,	1,	1,	10,	1,	5,	20,	5,	1,	8,	5,	60,	1),
(6,	1,	2,	3,	1,	2,	23,	1,	31,	2,	13,	2,	12,	3,	121,	1);

DROP TABLE IF EXISTS `cgo_session`;
CREATE TABLE `cgo_session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` int(2) NOT NULL DEFAULT '1' COMMENT '1 = passenger , 2 = driver , 3 = Agency,4 = Helpdesk',
  `user_id` int(11) NOT NULL,
  `session_id` text NOT NULL,
  `requester` text NOT NULL,
  `timestamp` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `cgo_users`;
CREATE TABLE `cgo_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `firstname` varchar(20) NOT NULL,
  `lastname` varchar(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `phno` varchar(15) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(250) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1' COMMENT '1=Active,0=inactive',
  `user_type` int(1) NOT NULL DEFAULT '5' COMMENT '1=Super admin,2=helpdesk,3=agency,4=corporate,5=normal user',
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_users` (`id`, `firstname`, `lastname`, `username`, `phno`, `email`, `password`, `status`, `user_type`, `created_on`, `modified_on`) VALUES
(1,	'Admin',	'Admin',	'admin',	'1234567890',	'admin@gmail.com',	'e10adc3949ba59abbe56e057f20f883e',	1,	1,	'2015-07-21 02:12:01',	'0000-00-00 00:00:00');

DROP TABLE IF EXISTS `cgo_vehicles`;
CREATE TABLE `cgo_vehicles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `model` varchar(50) NOT NULL,
  `registration_no` varchar(50) NOT NULL,
  `capacity` int(6) NOT NULL COMMENT 'Tonnage',
  `type` int(4) NOT NULL,
  `vehicle_type` int(4) NOT NULL DEFAULT '1' COMMENT '1=4wheeler/2=3wheeler',
  `vehicle_image` text NOT NULL,
  `vahicle_dimention` varchar(50) NOT NULL,
  `vehicle_manufacture` varchar(250) NOT NULL,
  `vehicle_permit_type` int(4) NOT NULL DEFAULT '1' COMMENT '1=local/2=international',
  `vehicle_permit_validity` date NOT NULL,
  `vehicle_insurance_no` varchar(20) NOT NULL,
  `vehicle_owner_name` varchar(20) NOT NULL,
  `vehicle_primary_phno` varchar(20) NOT NULL,
  `vehicle_secondary_phno` varchar(20) NOT NULL,
  `vehicle_landline` varchar(20) NOT NULL,
  `vehicle_driver` int(11) NOT NULL,
  `vehicle_agency` int(11) NOT NULL,
  `vehicle_availabilty` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=all,2=morning,3=day,4 =evening',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '1=active,0=inactive',
  `address` tinyint(4) NOT NULL,
  `area` varchar(100) NOT NULL,
  `pin` varchar(15) NOT NULL,
  `city` tinyint(4) NOT NULL,
  `state` tinyint(4) NOT NULL,
  `modified_on` datetime NOT NULL,
  `created_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `cgo_vehicles` (`id`, `name`, `model`, `registration_no`, `capacity`, `type`, `vehicle_type`, `vehicle_image`, `vahicle_dimention`, `vehicle_manufacture`, `vehicle_permit_type`, `vehicle_permit_validity`, `vehicle_insurance_no`, `vehicle_owner_name`, `vehicle_primary_phno`, `vehicle_secondary_phno`, `vehicle_landline`, `vehicle_driver`, `vehicle_agency`, `vehicle_availabilty`, `status`, `address`, `area`, `pin`, `city`, `state`, `modified_on`, `created_on`) VALUES
(1,	'Test Vehical',	'B4TIA',	'123456',	5,	2,	1,	'uploads/truck/truck-image.jpeg',	'',	'TATA',	1,	'0000-00-00',	'',	'',	'',	'',	'',	0,	0,	1,	1,	0,	'',	'',	1,	1,	'0000-00-00 00:00:00',	'2015-07-08 16:27:52'),
(2,	'Test Vehical',	'B4TIA',	'1234567',	2,	3,	1,	'uploads/truck/truck-image.jpeg',	'',	'Ashoke Layland',	1,	'0000-00-00',	'',	'',	'',	'',	'',	0,	0,	1,	1,	0,	'',	'',	1,	1,	'0000-00-00 00:00:00',	'2015-06-30 17:05:33'),
(3,	'Ashok Layland',	'ASL56',	'WB856932',	5,	4,	1,	'uploads/truck/truck-image.jpeg',	'',	'Mahindra',	1,	'0000-00-00',	'',	'',	'',	'',	'',	0,	0,	1,	1,	0,	'',	'',	0,	0,	'0000-00-00 00:00:00',	'2015-07-08 16:16:40'),
(4,	'TATA SAFARI',	'TT56T',	'WB856958',	1,	2,	1,	'uploads/truck/truck-image.jpeg',	'',	'Relience',	1,	'0000-00-00',	'',	'',	'',	'',	'',	0,	0,	1,	1,	0,	'',	'',	0,	0,	'0000-00-00 00:00:00',	'2015-07-08 16:20:20'),
(5,	'Test vehicle',	'85464TR',	'23423432423423',	4,	4,	1,	'uploads/truck/truck-image.jpeg',	'',	'TATA 420',	1,	'0000-00-00',	'',	'',	'',	'',	'',	0,	0,	1,	1,	0,	'',	'',	0,	0,	'0000-00-00 00:00:00',	'0000-00-00 00:00:00'),
(6,	'Vehicle 2',	'74545',	'546546546',	3,	3,	1,	'uploads/truck/truck-image.jpeg',	'',	'Marcus',	1,	'0000-00-00',	'',	'',	'',	'',	'',	0,	0,	1,	1,	0,	'',	'',	0,	0,	'0000-00-00 00:00:00',	'2015-07-23 19:00:57');

DROP TABLE IF EXISTS `cgo_vehicle_rating`;
CREATE TABLE `cgo_vehicle_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `passenger_id` int(11) NOT NULL,
  `vehicle_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `rate` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `cgo_vehicle_rating` (`id`, `passenger_id`, `vehicle_id`, `order_id`, `booking_id`, `rate`) VALUES
(1,	9,	2,	3,	1,	5),
(2,	9,	2,	3,	1,	0),
(3,	9,	2,	3,	1,	5),
(4,	9,	2,	4,	1,	5),
(5,	9,	2,	5,	1,	2),
(6,	9,	1,	6,	2,	3),
(7,	9,	1,	7,	2,	0);

-- 2015-08-14 01:12:22
