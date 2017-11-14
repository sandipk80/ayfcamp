-- phpMyAdmin SQL Dump
-- version 4.0.10.14
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Aug 30, 2016 at 09:27 AM
-- Server version: 5.5.49-cll-lve
-- PHP Version: 5.6.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ayfcamp`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `last_login` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `email`, `password`, `first_name`, `last_name`, `status`, `last_login`, `modified`, `created`) VALUES
(1, 'admin@ayfcamp.com', '0192023a7bbd73250516f069df18b500', 'Tarun', 'Khosla', 1, '2016-08-11 19:19:13', '0000-00-00 00:00:00', '2014-10-21 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `campers`
--

CREATE TABLE IF NOT EXISTS `campers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `camp_id` int(11) NOT NULL,
  `camp_session_id` int(11) NOT NULL,
  `camp_registration_id` int(11) NOT NULL,
  `parent_name` varchar(50) NOT NULL,
  `parent_phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL,
  `physician_name` varchar(50) NOT NULL,
  `physician_phone` varchar(20) NOT NULL,
  `insurance_card_front` varchar(50) NOT NULL,
  `insurance_card_back` varchar(50) NOT NULL,
  `insurance_carrier` varchar(100) NOT NULL,
  `group_number` varchar(50) NOT NULL,
  `agreement_number` varchar(50) NOT NULL,
  `emergency_contact` varchar(255) NOT NULL,
  `emergency_phone` varchar(20) NOT NULL,
  `recent_illness` tinyint(1) NOT NULL DEFAULT '0',
  `chronic_illness` tinyint(1) NOT NULL DEFAULT '0',
  `past_mononucleosis` tinyint(1) NOT NULL DEFAULT '0',
  `eye_wear` tinyint(1) NOT NULL DEFAULT '0',
  `hospitalization` tinyint(1) NOT NULL DEFAULT '0',
  `surgery` tinyint(1) NOT NULL DEFAULT '0',
  `frequent_headache` tinyint(1) NOT NULL DEFAULT '0',
  `head_injury` tinyint(1) NOT NULL DEFAULT '0',
  `knocked_unconscious` tinyint(1) NOT NULL DEFAULT '0',
  `ear_infections` tinyint(1) NOT NULL DEFAULT '0',
  `excercise_fainting` tinyint(1) NOT NULL DEFAULT '0',
  `excercise_dizziness` tinyint(1) NOT NULL DEFAULT '0',
  `seizures` tinyint(1) NOT NULL DEFAULT '0',
  `chest_pain` tinyint(1) NOT NULL DEFAULT '0',
  `high_blood_pressure` tinyint(1) NOT NULL DEFAULT '0',
  `heart_murmurs` tinyint(1) NOT NULL DEFAULT '0',
  `back_problem` tinyint(1) NOT NULL DEFAULT '0',
  `asthama` tinyint(1) NOT NULL DEFAULT '0',
  `diabetes` tinyint(1) NOT NULL DEFAULT '0',
  `diarrhea` tinyint(1) NOT NULL DEFAULT '0',
  `sleepwalking` tinyint(1) NOT NULL DEFAULT '0',
  `bed_wetting` tinyint(1) NOT NULL DEFAULT '0',
  `eating_disorder` tinyint(1) NOT NULL DEFAULT '0',
  `joint_problem` tinyint(1) NOT NULL DEFAULT '0',
  `strep_throat` tinyint(1) NOT NULL DEFAULT '0',
  `skin_problem` tinyint(1) NOT NULL DEFAULT '0',
  `brought_orthodontic_appliance` tinyint(1) NOT NULL DEFAULT '0',
  `emotional_difficulties` tinyint(1) NOT NULL DEFAULT '0',
  `additional_information` text NOT NULL,
  `explanations` text NOT NULL,
  `registration_code` varchar(100) NOT NULL,
  `step` int(2) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `campers`
--

INSERT INTO `campers` (`id`, `user_id`, `child_id`, `camp_id`, `camp_session_id`, `camp_registration_id`, `parent_name`, `parent_phone`, `address`, `location`, `physician_name`, `physician_phone`, `insurance_card_front`, `insurance_card_back`, `insurance_carrier`, `group_number`, `agreement_number`, `emergency_contact`, `emergency_phone`, `recent_illness`, `chronic_illness`, `past_mononucleosis`, `eye_wear`, `hospitalization`, `surgery`, `frequent_headache`, `head_injury`, `knocked_unconscious`, `ear_infections`, `excercise_fainting`, `excercise_dizziness`, `seizures`, `chest_pain`, `high_blood_pressure`, `heart_murmurs`, `back_problem`, `asthama`, `diabetes`, `diarrhea`, `sleepwalking`, `bed_wetting`, `eating_disorder`, `joint_problem`, `strep_throat`, `skin_problem`, `brought_orthodontic_appliance`, `emotional_difficulties`, `additional_information`, `explanations`, `registration_code`, `step`, `status`, `created`) VALUES
(1, 1, 1, 1, 1, 1, 'Sandip', '9284934829', 'PlaÃ§a de la Risa dels Vents', 'SDFKSFL,fjsfjs,sdfsfs', 'Shankar', '2324242', '', '', 'sdfsfsfsfs', '2343242', '23424242', '234225252', '23235552', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 'Nullam ante libero, lacinia vel sagittis id, rutrum iaculis tortor? Sed a odio ut ex suscipit metus.\r\n', 'Vestibulum porttitor faucibus accumsan. Phasellus sed ligula pellentesque, pulvinar nunc eu posuere.\r\n', '11j2b7q389g3b9n965s8g9j987s7s342632648g2j8j2s3q7g240', 1, 1, '2016-08-17 00:00:00'),
(2, 1, 1, 1, 3, 1, 'Sandip', '9284934829', 'PlaÃ§a de la Risa dels Vents', 'SDFKSFL,fjsfjs,sdfsfs', 'Shankar', '2324242', '', '', 'sdfsfsfsfs', '2343242', '23424242', '234225252', '23235552', 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 'Nullam ante libero, lacinia vel sagittis id, rutrum iaculis tortor? Sed a odio ut ex suscipit metus.\r\n', 'Vestibulum porttitor faucibus accumsan. Phasellus sed ligula pellentesque, pulvinar nunc eu posuere.\r\n', '11j2b7q389g3b9n965s8g9j987s7s342632648g2j8j2s3q7g240', 1, 1, '2016-08-17 00:00:00'),
(3, 1, 2, 1, 2, 1, 'Sandip', '9284934829', '9878883722', 'SDFKSFL,fjsfjs,sdfsfs', 'Shankar', '2324242', '', '', 'dswrwrw', '535353', '42342', '234225252', '23235552', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 'Aliquam sed turpis hendrerit, lacinia arcu quis, vestibulum odio. Suspendisse facilisis; est nullam.\r\n', 'Integer pharetra arcu a ligula efficitur, at viverra turpis luctus. Sed eu libero non eros volutpat.\r\n', '1365j7j166s12823j9s8q8b5q9b6v4s6v52944v3n3b7g4b2n161', 2, 1, '2016-08-17 00:00:00'),
(4, 1, 2, 1, 4, 1, 'Sandip', '9284934829', '9878883722', 'SDFKSFL,fjsfjs,sdfsfs', 'Shankar', '2324242', '', '', 'dswrwrw', '535353', '42342', '234225252', '23235552', 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 'Aliquam sed turpis hendrerit, lacinia arcu quis, vestibulum odio. Suspendisse facilisis; est nullam.\r\n', 'Integer pharetra arcu a ligula efficitur, at viverra turpis luctus. Sed eu libero non eros volutpat.\r\n', '1365j7j166s12823j9s8q8b5q9b6v4s6v52944v3n3b7g4b2n161', 2, 1, '2016-08-17 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `camps`
--

CREATE TABLE IF NOT EXISTS `camps` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `total_sessions` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `camps`
--

INSERT INTO `camps` (`id`, `title`, `total_sessions`, `year`, `created`) VALUES
(1, 'Sample', 5, 2016, '2016-08-11 20:21:32');

-- --------------------------------------------------------

--
-- Table structure for table `camp_registrations`
--

CREATE TABLE IF NOT EXISTS `camp_registrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `camp_id` int(11) NOT NULL,
  `total_campers` int(11) NOT NULL,
  `parent_name` varchar(50) NOT NULL,
  `parent_email` varchar(100) NOT NULL,
  `parent_phone` varchar(20) NOT NULL,
  `secondary_parent_name` varchar(50) NOT NULL,
  `secondary_parent_phone` varchar(20) NOT NULL,
  `secondary_parent_email` varchar(100) NOT NULL,
  `primary_address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state_id` int(11) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `emergency_contact1` varchar(255) NOT NULL,
  `emergency_contact2` varchar(255) NOT NULL,
  `total_amount` varchar(7) NOT NULL,
  `payment_id` int(11) NOT NULL,
  `payment_status` enum('Pending','Failed','Success') NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `waitlist` tinyint(1) NOT NULL,
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `camp_registrations`
--

INSERT INTO `camp_registrations` (`id`, `user_id`, `camp_id`, `total_campers`, `parent_name`, `parent_email`, `parent_phone`, `secondary_parent_name`, `secondary_parent_phone`, `secondary_parent_email`, `primary_address`, `city`, `state_id`, `zipcode`, `emergency_contact1`, `emergency_contact2`, `total_amount`, `payment_id`, `payment_status`, `status`, `waitlist`, `modified`, `created`) VALUES
(1, 1, 1, 2, 'Sandip Kumar', 'Sandip.kumar78@gmail.com', '9877987868', 'Rekha', '948593859385', 'rerel@kdlfkdl.fld', '23, Jamuna Bldg', 'Arkanasa', 2840, '1312313', 'Aenean accumsan ut posuere.', 'Aenean molestie ex a metus.', '500', 1, 'Success', 1, 0, '2016-08-17 09:02:56', '2016-08-17 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `camp_sessions`
--

CREATE TABLE IF NOT EXISTS `camp_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `camp_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `start_from` date NOT NULL,
  `end_at` date NOT NULL,
  `rate` varchar(5) NOT NULL,
  `camper_limit` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `camp_sessions`
--

INSERT INTO `camp_sessions` (`id`, `camp_id`, `title`, `start_from`, `end_at`, `rate`, `camper_limit`) VALUES
(1, 1, 'Week A', '2016-08-12', '2016-08-19', '320', 40),
(2, 1, 'Week B', '2016-08-25', '2016-08-31', '221', 60),
(3, 1, 'Week C', '2016-09-02', '2016-09-16', '380', 76),
(4, 1, 'Week D', '2016-10-07', '2016-10-19', '420', 58),
(5, 1, 'Week E', '2016-10-25', '2016-10-31', '460', 46);

-- --------------------------------------------------------

--
-- Table structure for table `childs`
--

CREATE TABLE IF NOT EXISTS `childs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `date_of_birth` date NOT NULL,
  `gender` enum('M','F') NOT NULL DEFAULT 'M',
  `email` varchar(100) NOT NULL,
  `photo` varchar(50) NOT NULL,
  `relation` varchar(20) NOT NULL,
  `is_ayfcamper` tinyint(1) NOT NULL DEFAULT '0',
  `tshirt_size` varchar(20) NOT NULL,
  `insurance_card_front` varchar(50) NOT NULL,
  `insurance_card_back` varchar(50) NOT NULL,
  `health_insurance_carrier` varchar(50) NOT NULL,
  `group_number` varchar(50) NOT NULL,
  `agreement_number` varchar(50) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `childs`
--

INSERT INTO `childs` (`id`, `user_id`, `first_name`, `last_name`, `date_of_birth`, `gender`, `email`, `photo`, `relation`, `is_ayfcamper`, `tshirt_size`, `insurance_card_front`, `insurance_card_back`, `health_insurance_carrier`, `group_number`, `agreement_number`, `status`, `modified`, `created`) VALUES
(1, 1, 'Suhani', 'Soni', '2006-08-16', 'F', 'web.codebyte@gmail.com', 'ala2ohumaeirulida2.jpg', 'Father', 0, '', '', '', '', '', '', 1, '2016-08-14 04:54:10', '2016-08-08 09:31:42'),
(2, 1, 'Deetya', 'Soni', '2010-05-06', 'F', 'web.codebyte@gmail.com', 'nuno8i5e9oji3o8e5e.jpg', 'Father', 0, '', '', '', '', '', '', 1, '2016-08-14 04:53:11', '2016-08-08 09:44:17'),
(3, 2, 'Alec', 'Tima', '2010-05-25', 'M', 'erictima@me.com', 'ori8aoo5ojapu5ugal.jpg', 'son', 0, '', '', '', '', '', '', 1, '2016-08-17 17:50:54', '2016-08-17 17:50:54');

-- --------------------------------------------------------

--
-- Table structure for table `registration_payments`
--

CREATE TABLE IF NOT EXISTS `registration_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `registration_id` int(11) NOT NULL,
  `transaction_id` varchar(50) NOT NULL,
  `amount` varchar(10) NOT NULL,
  `data` text NOT NULL,
  `status` varchar(10) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `registration_payments`
--

INSERT INTO `registration_payments` (`id`, `user_id`, `registration_id`, `transaction_id`, `amount`, `data`, `status`, `created`) VALUES
(1, 1, 1, '5371443257420393B', '500', 'a:10:{s:9:"TIMESTAMP";s:19:"2016-08-17 09:02:56";s:13:"CORRELATIONID";s:13:"95caf831c2e86";s:3:"ACK";s:7:"Success";s:7:"VERSION";s:4:"51.0";s:5:"BUILD";s:6:"000000";s:3:"AMT";s:3:"500";s:12:"CURRENCYCODE";s:3:"USD";s:7:"AVSCODE";s:1:"X";s:9:"CVV2MATCH";s:1:"M";s:13:"TRANSACTIONID";s:17:"5371443257420393B";}', 'Success', '2016-08-17 09:02:56');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE IF NOT EXISTS `states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `country_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2888 ;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `country_id`, `status`) VALUES
(2837, 'Alabama', 237, 1),
(2838, 'Alaska', 237, 1),
(2839, 'Arizona', 237, 1),
(2840, 'Arkansas', 237, 1),
(2841, 'California', 237, 1),
(2842, 'Colorado', 237, 1),
(2843, 'Connecticut', 237, 1),
(2844, 'Delaware', 237, 1),
(2845, 'Florida', 237, 1),
(2846, 'Georgia', 237, 1),
(2847, 'Hawaii', 237, 1),
(2848, 'Idaho', 237, 1),
(2849, 'Illinois', 237, 1),
(2850, 'Indiana', 237, 1),
(2851, 'Iowa', 237, 1),
(2852, 'Kansas', 237, 1),
(2853, 'Kentucky', 237, 1),
(2854, 'Louisiana', 237, 1),
(2855, 'Maine', 237, 1),
(2856, 'Maryland', 237, 1),
(2857, 'Massachusetts', 237, 1),
(2858, 'Michigan', 237, 1),
(2859, 'Minnesota', 237, 1),
(2860, 'Mississippi', 237, 1),
(2861, 'Missouri', 237, 1),
(2862, 'Montana', 237, 1),
(2863, 'Nebraska', 237, 1),
(2864, 'Nevada', 237, 1),
(2865, 'New Hampshire', 237, 1),
(2866, 'New Jersey', 237, 1),
(2867, 'New Mexico', 237, 1),
(2868, 'New York', 237, 1),
(2869, 'North Carolina', 237, 1),
(2870, 'North Dakota', 237, 1),
(2871, 'Ohio', 237, 1),
(2872, 'Oklahoma', 237, 1),
(2873, 'Oregon', 237, 1),
(2874, 'Pennsylvania', 237, 1),
(2875, 'Rhode Island', 237, 1),
(2876, 'South Carolina', 237, 1),
(2877, 'South Dakota', 237, 1),
(2878, 'Tennessee', 237, 1),
(2879, 'Texas', 237, 1),
(2880, 'Utah', 237, 1),
(2881, 'Vermont', 237, 1),
(2882, 'Virginia', 237, 1),
(2883, 'Washington', 237, 1),
(2884, 'Washington DC', 237, 1),
(2885, 'West Virginia', 237, 1),
(2886, 'Wisconsin', 237, 1),
(2887, 'Wyoming', 237, 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(50) NOT NULL,
  `first_name` varchar(30) NOT NULL,
  `last_name` varchar(30) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state_id` int(11) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `hear_from` varchar(150) NOT NULL,
  `token` varchar(50) NOT NULL,
  `last_login` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `active` enum('0','1') NOT NULL DEFAULT '0',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `first_name`, `last_name`, `phone`, `address`, `city`, `state_id`, `zipcode`, `hear_from`, `token`, `last_login`, `status`, `active`, `modified`, `created`) VALUES
(1, 'sandipk', 'sandip.kumar78@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', 'Sandip', 'Kumar', '9877987868', '23, Jamuna Bldg', 'Arkanasa', 2840, '1312313', 'gddgg ffhfhfh fhfhtrr', 'z4h5t8t7d3d1', '2016-08-17 18:07:46', 1, '1', '2016-08-13 19:44:54', '2016-08-07 21:42:21'),
(2, 'etima', 'erictima@aol.com', '953cac55fd3b7bcb82f2df9e221cb1b7', 'Eric', 'Tima', '8888888888', '', '', 0, '', '', '7m5g5r7d4s4n', '0000-00-00 00:00:00', 1, '1', '2016-08-17 17:50:06', '2016-08-17 17:50:06');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
