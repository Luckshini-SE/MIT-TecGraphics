-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 29, 2024 at 12:27 PM
-- Server version: 5.6.12-log
-- PHP Version: 5.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tecgraphics`
--
CREATE DATABASE IF NOT EXISTS `tecgraphics` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `tecgraphics`;

-- --------------------------------------------------------

--
-- Table structure for table `advance_payment`
--

CREATE TABLE IF NOT EXISTS `advance_payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rec_no` varchar(10) NOT NULL,
  `rec_date` varchar(15) NOT NULL,
  `customer` int(11) NOT NULL,
  `description` varchar(250) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `pay_type` varchar(15) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'pending',
  `balance` varchar(20) NOT NULL,
  `user` int(11) NOT NULL,
  `datetime` varchar(25) NOT NULL,
  `cheq_no` varchar(30) NOT NULL,
  `cheq_date` varchar(25) NOT NULL,
  `deposit_ref` varchar(75) NOT NULL,
  `quot_no` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `advance_payment`
--

INSERT INTO `advance_payment` (`id`, `rec_no`, `rec_date`, `customer`, `description`, `amount`, `pay_type`, `status`, `balance`, `user`, `datetime`, `cheq_no`, `cheq_date`, `deposit_ref`, `quot_no`) VALUES
(1, 'AD10001', '2024-02-29', 1, '', '4340.00', 'Online', 'pending', '3000.00', 0, '2024-02-29 22:49:02', '', '', '', 'QT10004'),
(3, 'AD10002', '2024-03-05', 14, '', '20050.00', 'Online', 'pending', '20050.00', 0, '2024-03-05 19:18:57', '', '', '', 'QT10001'),
(5, 'AD10004', '2024-03-31', 37, '', '3555.00', 'Online', 'yes', '0.00', 0, '2024-03-31 00:29:07', '', '', '', 'QT10040'),
(7, 'AD10005', '2024-03-31', 37, '', '1350.00', 'Online', 'pending', '1350.00', 0, '2024-03-31 10:52:15', '', '', '', 'QT10041');

-- --------------------------------------------------------

--
-- Table structure for table `advance_settlement`
--

CREATE TABLE IF NOT EXISTS `advance_settlement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rec_no` varchar(15) NOT NULL,
  `advance_pay_no` varchar(15) NOT NULL,
  `amount` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `advance_settlement`
--

INSERT INTO `advance_settlement` (`id`, `rec_no`, `advance_pay_no`, `amount`) VALUES
(1, 'RN10003', 'AD10006', '4000.00'),
(2, 'RN10005', 'AD10001', '1340.00'),
(3, 'RN10015', 'AD10004', '3555.00');

-- --------------------------------------------------------

--
-- Table structure for table `contact_person`
--

CREATE TABLE IF NOT EXISTS `contact_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer` int(11) NOT NULL,
  `ctitle` int(11) NOT NULL,
  `cfname` varchar(50) NOT NULL,
  `clname` varchar(50) NOT NULL,
  `cphone` varchar(20) NOT NULL,
  `cemail` varchar(75) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `customer` (`customer`),
  KEY `ctitle` (`ctitle`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `contact_person`
--

INSERT INTO `contact_person` (`id`, `customer`, `ctitle`, `cfname`, `clname`, `cphone`, `cemail`) VALUES
(10, 8, 1, 'John', 'Steward', '0771155667', ''),
(12, 9, 1, 'John', 'Buttler', '0771155667', ''),
(14, 10, 1, 'Vien', 'Smith', '0771155663', ''),
(16, 11, 1, 'Kyle', 'Jamieson', '0771155667', ''),
(17, 11, 2, 'Aliya', 'Hall', '', ''),
(18, 16, 1, 'Brielle', 'Mathews', '0771155669', ''),
(19, 36, 1, 'Givantha', 'Perera', '0771155331', ''),
(20, 36, 1, 'Chamod', 'Premadasa', '', ''),
(21, 9, 2, 'Varuni', 'Collin', '0771155668', '');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ctype` varchar(5) NOT NULL,
  `title` int(11) NOT NULL,
  `name` varchar(75) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `fax` varchar(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `web` varchar(50) NOT NULL,
  `address1` varchar(75) NOT NULL,
  `address2` varchar(75) NOT NULL,
  `address3` varchar(75) NOT NULL,
  `active` varchar(5) NOT NULL DEFAULT 'yes',
  `login` varchar(5) NOT NULL DEFAULT 'no',
  `password` varchar(200) NOT NULL,
  `reg_mode` varchar(10) NOT NULL DEFAULT 'online',
  `reg_date` varchar(25) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `title` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id`, `ctype`, `title`, `name`, `last_name`, `mobile`, `phone`, `fax`, `email`, `web`, `address1`, `address2`, `address3`, `active`, `login`, `password`, `reg_mode`, `reg_date`) VALUES
(1, 'i', 2, 'Lourdes', 'Mary', '0771122334', '0112302010', '', 'lourdesmary@gmail.com', '', 'No. 15,', 'Main Street,', 'Colombo 02.', 'yes', 'no', '52e10d8b23b93b7467296125130aafa7', 'online', '2023-10-02 09:25:46'),
(8, 'c', 6, 'Trinity (Pvt) Ltd.', '', '', '0112304050', '', '', '', 'Colombo', '', '', 'yes', 'no', 'HXmZP6EQ', 'online', '2023-10-09 13:55:00'),
(9, 'c', 6, 'ABC Company Ltd', '', '', '0112584769', '', 'info@abc.com', '', 'Colombo', '', '', 'yes', 'no', '', 'offline', '2023-10-14 07:14:23'),
(10, 'c', 6, 'Dell Industry', '', '', '0112304057', '', '', 'www.dellindustry-official.com', 'Kandy', '', '', 'yes', 'no', '', 'offline', '2023-10-22 12:52:46'),
(11, 'c', 6, 'Intel Chocolates', '', '', '0112302015', '', '', '', 'Kandy', '', '', 'yes', 'no', '', 'offline', '2023-10-28 11:43:39'),
(14, 'i', 1, 'Harold', 'Joseph', '0714535925', '0112304033', '', 'harold@gmail.com', '', 'Colombo', '', '', 'yes', 'no', '52e10d8b23b93b7467296125130aafa7', 'online', '2023-11-02 23:55:46'),
(15, 'i', 3, 'Daphnie', 'Fernando', '0112534982', '', '', '', '', 'Colombo', '', '', 'yes', 'no', '', 'offline', '2023-11-08 10:46:46'),
(16, 'c', 6, 'Mini Co', '', '', '0713216549', '', 'minico@gmail.com', '', 'Kandy', '', '', 'yes', 'no', '', 'offline', '2023-11-13 17:31:11'),
(19, 'i', 1, 'Nimal', 'De Silva', '0775463871', NULL, '', 'nimal@gmail.com', '', '', '', '', 'yes', 'no', '05541787d7c1b98f67eb1ce010ef3381', 'online', '2023-11-15 19:34:42'),
(20, 'i', 1, 'Hemal', 'Vithanage', '', NULL, '', 'hemal@gmail.com', '', '', '', '', 'yes', 'no', '93c0a31726fc8dce8c3f649a84d9b7b4', 'online', '2023-11-21 16:58:25'),
(21, 'c', 6, 'Unilever Sri Lanka (Pvt) Ltd.', '', '', '0112222555', '', 'info@unilever.com', '', '', '', '', 'yes', 'no', '42553530bc8ab9a25be827a7615c3f28', 'online', '2023-11-27 20:08:26'),
(22, 'i', 4, 'Thanuja', 'Surendran', '0771122355', '', '', 'drthanujas@yahoo.com', '', 'Chatham Street', 'Colombo 01.', '', 'yes', 'no', '', 'offline', '2023-12-06 23:55:46'),
(23, 'i', 1, 'Chethiya', 'Jayawardena', '0715532657', '', '', 'chethiya@gmail.com', '', '2nd Cross Road', 'Anuradhapura', '', 'yes', 'no', '', 'offline', '2023-12-08 11:10:50'),
(24, 'c', 6, 'Rhythm International', '', '', '0342459782', '', 'accounts@rhythmint.lk', '', '', '', '', 'yes', 'no', 'd03f6d10749500e9e2e2137a59d826b9', 'online', '2024-02-28 21:59:23'),
(25, 'i', 1, 'Ishan', 'Pathirana', '0752323418', NULL, '', 'ishan.pathirana@yahoo.com', '', '', '', '', 'yes', 'no', '28848ecfb0665bb86bebd1b01771c15e', 'online', '2024-03-02 14:57:28'),
(26, 'i', 2, 'Ayesha', 'Kalpani', '0714368925', NULL, '', 'kalpani4298@gmail.com', '', '', '', '', 'yes', 'no', '9daf9b5191f065731aea6aa5c0547b5c', 'online', '2024-03-02 15:23:34'),
(27, 'i', 1, 'Maneesha', 'Guruge', '0772282467', NULL, '', 'maneestrong@gmal.com', '', '', '', '', 'yes', 'no', 'd1e6b917e2b99d7e4a94d0390b84e304', 'online', '2024-03-02 15:28:51'),
(28, 'i', 3, 'Natasha', 'Mendis', '0776352879', '', '', 'nattie0707@yahoo.com', '', '', '', '', 'yes', 'no', 'a987d3dd1bf942d92a2a72c85d3df0f4', 'online', '2024-03-02 15:36:04'),
(29, 'c', 6, 'Bright Academy', '', '', '0112450205', '', 'sales@brightacademy.lk', '', '', '', '', 'yes', 'no', '173309254d744ee11186193a1b1b0394', 'online', '2024-03-02 15:40:31'),
(30, 'c', 6, 'M T Mills', '', '', '0333578945', '', 'dhanushka@mtmills.com', '', '', '', '', 'yes', 'no', '2142193e6ba0aa831597fceadd02b0e2', 'online', '2024-03-02 19:45:16'),
(31, 'i', 2, 'Tharshika', 'George', '0755921471', NULL, '', 'tharshika78@gmail.com', '', '', '', '', 'yes', 'no', '27f5652ff2a9962ed60c776dcb2e2c72', 'online', '2024-03-02 19:49:01'),
(32, 'c', 6, 'Tiny Flower Nursery', '', '', '0112305989', '', 'tinyflower@gmail.com', '', '', '', '', 'yes', 'no', '222fa91ad51f50bc68d6f0e92caacbe8', 'online', '2024-03-02 19:54:29'),
(33, 'i', 1, 'Vien', 'Franz', '0714253869', NULL, '', 'vienfranz@yahoo.com', '', '', '', '', 'yes', 'no', 'df9a2e23f3778ecd59e9a19f61bec198', 'online', '2024-03-02 20:01:44'),
(34, 'i', 1, 'Nauhaan', 'Muhazib', '0112526784', NULL, '', 'nauhaan9703@gmail.com', '', '', '', '', 'yes', 'no', 'e8ba6122e763345f2d6ad6fbc1e129af', 'online', '2024-03-02 20:05:08'),
(35, 'c', 6, 'A B D Traders', '', '', '0344789115', '', 'abdtraders@gmail.com', '', '', '', '', 'yes', 'no', '9b371bf5405e6a233446b4ef636b57be', 'online', '2024-03-02 20:08:12'),
(36, 'c', 6, 'The Royal Bakery', '', '', '0112526385', '', 'theroyalbakery@gmail.com', '', 'Galle Road', 'Colombo 06', '', 'yes', 'no', '', 'offline', '2024-03-10 12:20:17'),
(37, 'i', 2, 'Luckshini', 'Fernando', '0771183992', NULL, '', 'luckshinif@gmail.com', '', '', '', '', 'yes', 'no', 'fb60cf6d15803bc97f11c7dab1d3c309', 'online', '2024-03-10 20:03:21'),
(38, 'c', 6, 'Amak Global', '', '', '0117882543', '', 'operations@amakglobal.com', '', '', '', '', 'yes', 'no', 'f9ef92b24ea08845f492fb39f4a70fa1', 'online', '2024-03-16 12:38:38'),
(39, 'i', 1, 'Shawn', 'Williams', '0756458614', '', '', 'shawnwill@yahoo.com', '', 'Trincomalee Street', 'Kandy', '', 'yes', 'no', '', 'offline', '2024-03-29 10:45:06'),
(40, 'c', 6, 'ABC Technology', '', '', '0115463258', '', 'abctechnology@sltnet.lk', '', '', '', '', 'yes', 'no', 'e99a18c428cb38d5f260853678922e03', 'online', '2024-03-30 14:32:03'),
(41, 'i', 2, 'Tharika', 'Lesley', '0714567826', NULL, '', 'tharika2003@gmail.com', '', '', '', '', 'yes', 'no', '2f3d6210c13c492b68a709c6a322c223', 'online', '2024-03-30 14:35:14'),
(42, 'i', 1, 'Sithum', 'Perera', '0755824566', NULL, '', 'sithumperera96@yahoo.com', '', '', '', '', 'yes', 'no', '1b2377bafb3222f07757a7322e9455f4', 'online', '2024-03-30 14:39:50'),
(43, 'c', 6, 'Sri Vijaya Trading', '', '', '0117522864', '', 'srivijayatradin@gmail.com', '', '', '', '', 'yes', 'no', 'af1d206af0c5ae3da8784d55e48edb6b', 'online', '2024-03-30 14:44:16'),
(44, 'c', 6, 'St. Anthony''s Hardware', '', '', '0115784579', '', 'st.anthonyshardware@yahoo.com', '', '', '', '', 'yes', 'no', '5f8cf8eaf8def8a956c01533742c89f9', 'online', '2024-03-30 14:47:42'),
(45, 'i', 2, 'Sinthuja', 'Sivarajah', '0768244583', NULL, '', 'sithujasivarajah@gmail.com', '', '', '', '', 'yes', 'no', 'f2a2b83d1f4b82bf05621b7183960b30', 'online', '2024-03-30 14:50:20'),
(46, 'i', 1, 'Arosh', 'Mendis', '0748585863', NULL, '', 'aroshmendis87@gmail.com', '', '', '', '', 'yes', 'no', '270fde5955142616696911940cc5a628', 'online', '2024-03-30 14:54:38'),
(47, 'i', 3, 'Wazeera', 'Farook', '0774586325', NULL, '', 'wazeerafarook2007@gmail.com', '', '', '', '', 'yes', 'no', 'b205dd92b93ca0b8986f696c2ca9e6a5', 'online', '2024-03-30 14:58:11'),
(48, 'i', 1, 'Kennedy', 'Silva', '0751253449', NULL, '', 'kennedy.1995@yahoo.com', '', '', '', '', 'yes', 'no', '01c6df9f6ce4326d0e939a84c0884c8b', 'online', '2024-03-30 15:32:05'),
(49, 'i', 1, 'Sameera', 'Wijesinghe', '0775689421', NULL, '', 'sameerawije@gmail.com', '', '', '', '', 'yes', 'no', '59038e3f328f3c8dfff56c33356d6e98', 'online', '2024-03-30 22:59:18'),
(50, 'c', 6, 'H. D. F. Housing', '', '', '0112547895', '', 'hdfhousing@sltnet.lk', '', '', '', '', 'yes', 'no', '99b74ab0039c9f5edd653ad31910edd2', 'online', '2024-03-30 23:00:55'),
(51, 'i', 1, 'Dilshan', 'Madushanka', '0711588596', NULL, '', 'dilshanmadush@gmail.com', '', '', '', '', 'yes', 'no', '49d05bbd361e3a2ddc277da7fb88f685', 'online', '2024-03-30 23:02:54'),
(52, 'c', 6, 'abcd', '', '', '0775583669', '', 'abcd@gmail.com', '', '', '', '', 'yes', 'no', '202cb962ac59075b964b07152d234b70', 'online', '2024-03-31 14:07:21');

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE IF NOT EXISTS `delivery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `del_no` varchar(25) NOT NULL,
  `del_date` varchar(25) NOT NULL,
  `invoice_id` int(11) NOT NULL COMMENT 'id of invoice table',
  `cus_id` int(11) NOT NULL,
  `log_user` int(11) NOT NULL,
  `log_datetime` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`id`, `del_no`, `del_date`, `invoice_id`, `cus_id`, `log_user`, `log_datetime`) VALUES
(1, 'DN10001', '2024-03-23', 5, 14, 1, '2024-03-23 00:12:40'),
(2, 'DN10002', '2024-03-23', 6, 19, 1, '2024-03-23 00:13:16'),
(3, 'DN10003', '2024-03-23', 7, 21, 1, '2024-03-23 00:13:42'),
(4, 'DN10004', '2024-03-23', 8, 1, 1, '2024-03-23 00:14:07'),
(5, 'DN10005', '2024-03-23', 9, 25, 1, '2024-03-23 00:14:21'),
(6, 'DN10006', '2024-03-23', 10, 1, 1, '2024-03-23 00:14:39'),
(7, 'DN10007', '2024-03-23', 14, 27, 1, '2024-03-23 00:14:49'),
(8, 'DN10008', '2024-03-23', 15, 27, 1, '2024-03-23 00:15:16'),
(9, 'DN10009', '2024-03-23', 16, 21, 1, '2024-03-23 00:15:42'),
(10, 'DN10010', '2024-03-23', 17, 28, 1, '2024-03-23 00:15:56'),
(11, 'DN10011', '2024-03-23', 24, 26, 1, '2024-03-23 00:16:55'),
(12, 'DN10012', '2024-03-23', 20, 30, 1, '2024-03-23 00:17:13'),
(13, 'DN10013', '2024-03-29', 18, 29, 1, '2024-03-29 11:05:58'),
(14, 'DN10014', '2024-03-30', 21, 24, 6, '2024-03-30 13:24:08'),
(15, 'DN10015', '2024-03-30', 22, 32, 6, '2024-03-30 13:24:23'),
(16, 'DN10016', '2024-03-31', 36, 37, 5, '2024-03-31 00:38:28');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_details`
--

CREATE TABLE IF NOT EXISTS `delivery_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `delivery_id` int(11) NOT NULL COMMENT 'id of delivery table',
  `prod_id` int(11) NOT NULL,
  `qty` varchar(20) NOT NULL,
  `packing` varchar(75) NOT NULL,
  `invitm_id` int(11) NOT NULL COMMENT 'id of invoice_details table',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `delivery_details`
--

INSERT INTO `delivery_details` (`id`, `delivery_id`, `prod_id`, `qty`, `packing`, `invitm_id`) VALUES
(1, 1, 4, '100', '100 x 1 pack', 6),
(2, 1, 12, '5', '50 x 1 pack', 7),
(3, 2, 1, '1', '1 pack', 8),
(4, 3, 11, '500', '250 x 2 bundles', 9),
(5, 4, 1, '2', '2 x 1 pack', 10),
(6, 5, 10, '3', '3 x 1 box', 11),
(7, 6, 1, '1', '1 pack', 12),
(8, 7, 10, '1', '1 box', 17),
(9, 8, 5, '20', '1 pack', 18),
(10, 9, 5, '150', '75 x 2 packs', 19),
(11, 10, 3, '20', '1 bundle', 20),
(12, 11, 13, '500', '200 x 2 packs, 100 x 1 pack', 28),
(13, 11, 4, '100', '1 pack', 29),
(14, 12, 9, '2', '1 box', 23),
(15, 13, 1, '2', '2 x 1 pack', 21),
(16, 14, 9, '1', '1 pack', 24),
(17, 14, 14, '2', '2 x 1 pack', 25),
(18, 15, 2, '25', '25 x 1 pack', 26),
(19, 16, 3, '25', '25 x 1 pack', 45);

-- --------------------------------------------------------

--
-- Table structure for table `grn_stock`
--

CREATE TABLE IF NOT EXISTS `grn_stock` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grn_no` varchar(15) NOT NULL,
  `item_id` int(11) NOT NULL,
  `uprice` varchar(15) NOT NULL,
  `grn_qty` varchar(10) NOT NULL,
  `amount` varchar(15) NOT NULL,
  `available_qty` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

--
-- Dumping data for table `grn_stock`
--

INSERT INTO `grn_stock` (`id`, `grn_no`, `item_id`, `uprice`, `grn_qty`, `amount`, `available_qty`) VALUES
(1, 'GRN10001', 5, '40.00', '700', '28000.00', '556'),
(2, 'GRN10001', 6, '41.00', '500', '20500.00', '500'),
(3, 'GRN10002', 8, '38.00', '500', '19000.00', '495'),
(4, 'GRN10002', 1, '32.00', '700', '22400.00', '475'),
(5, 'GRN10002', 7, '35.00', '500', '17500.00', '452'),
(6, 'GRN10003', 11, '3250', '30', '97500.00', '29.3'),
(7, 'GRN10003', 14, '3200', '30', '96000.00', '29.56'),
(8, 'GRN10004', 12, '3250', '30', '97500.00', '28.77'),
(9, 'GRN10004', 13, '3250', '30', '97500.00', '29'),
(10, 'GRN10005', 9, '550', '24', '13200.00', '24'),
(11, 'GRN10005', 10, '700', '12', '8400.00', '12'),
(12, 'GRN10006', 1, '35.00', '200', '7000.00', '0'),
(13, 'GRN10006', 2, '32.00', '200', '6400.00', '0'),
(14, 'GRN10007', 9, '450.00', '12', '5400.00', '0'),
(15, 'GRN10008', 6, '50.00', '150', '7500.00', '0'),
(16, 'GRN10009', 18, '25.00', '15', '375.00', '15'),
(17, 'GRN10010', 2, '45.00', '50', '2250.00', '50'),
(18, 'GRN10010', 7, '50.00', '25', '2500.00', '25'),
(19, 'GRN10011', 33, '500.00', '15', '7500.00', '15'),
(20, 'GRN10011', 35, '150.00', '10', '1500.00', '10');

-- --------------------------------------------------------

--
-- Table structure for table `grn_summary`
--

CREATE TABLE IF NOT EXISTS `grn_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `grn_no` varchar(15) NOT NULL,
  `grn_date` varchar(25) NOT NULL,
  `po_no` varchar(15) NOT NULL,
  `supplier` int(11) NOT NULL,
  `total` varchar(15) NOT NULL,
  `balance` varchar(15) NOT NULL,
  `pay_status` varchar(5) NOT NULL,
  `invoice_no` varchar(50) NOT NULL,
  `user` int(11) NOT NULL,
  `logdatetime` varchar(25) NOT NULL,
  `approval` varchar(10) NOT NULL DEFAULT 'pending',
  `app_user` int(11) NOT NULL,
  `app_datetime` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `grn_summary`
--

INSERT INTO `grn_summary` (`id`, `grn_no`, `grn_date`, `po_no`, `supplier`, `total`, `balance`, `pay_status`, `invoice_no`, `user`, `logdatetime`, `approval`, `app_user`, `app_datetime`) VALUES
(1, 'GRN10001', '2023-10-01', 'PO10001', 2, '48500.00', '0.00', 'yes', 'INV-2023-0058', 1, '2024-02-28 22:53:25', 'yes', 1, '2024-02-28 22:53:38'),
(2, 'GRN10002', '2023-10-16', 'PO10002', 1, '58900.00', '0.00', 'yes', 'PP15248', 1, '2024-02-28 23:39:05', 'yes', 1, '2024-02-28 23:41:31'),
(3, 'GRN10003', '2023-10-24', 'PO10003', 5, '193500.00', '0.00', 'yes', 'CI23-4518', 1, '2024-02-28 23:39:39', 'yes', 1, '2024-02-28 23:41:34'),
(4, 'GRN10004', '2023-10-28', 'PO10004', 5, '195000.00', '70000.00', 'no', '', 1, '2024-02-28 23:40:33', 'yes', 1, '2024-02-28 23:41:37'),
(5, 'GRN10005', '2023-11-09', 'PO10005', 3, '21600.00', '0.00', 'yes', '', 1, '2024-02-28 23:41:07', 'yes', 1, '2024-02-28 23:41:40'),
(6, 'GRN10006', '2024-03-06', 'PO10006', 1, '13400.00', '8400.00', 'no', 'INV-2023-0061', 1, '2024-03-06 02:27:38', 'pending', 0, ''),
(7, 'GRN10007', '2024-03-06', 'PO10007', 3, '5400.00', '5400.00', 'no', 'INV-2023-0065', 1, '2024-03-06 02:27:51', 'pending', 0, ''),
(8, 'GRN10008', '2024-03-06', 'PO10008', 2, '7500.00', '500.00', 'no', 'INV-2023-0067', 1, '2024-03-06 02:28:04', 'pending', 0, ''),
(9, 'GRN10009', '2024-03-12', 'PO10009', 2, '375.00', '375.00', 'no', 'INV-11534', 1, '2024-03-29 10:05:09', 'yes', 1, '2024-03-29 10:06:16'),
(10, 'GRN10010', '2024-03-31', 'PO10013', 2, '4750.00', '0.00', 'yes', 'INV0001', 11, '2024-03-31 00:15:38', 'yes', 10, '2024-03-31 00:16:17'),
(11, 'GRN10011', '2024-03-31', 'PO10014', 7, '9000.00', '4500.00', 'no', 'IN45889', 11, '2024-03-31 10:45:04', 'yes', 10, '2024-03-31 10:45:27');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE IF NOT EXISTS `invoice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_no` varchar(25) NOT NULL,
  `invoice_date` varchar(25) NOT NULL,
  `jobcard_id` int(11) NOT NULL COMMENT 'id of jobcard table',
  `cus_id` int(11) NOT NULL,
  `subtotal` varchar(25) NOT NULL,
  `dis_per` varchar(25) NOT NULL,
  `discount` varchar(25) NOT NULL,
  `total` varchar(25) NOT NULL,
  `paystatus` varchar(10) NOT NULL DEFAULT 'pending',
  `pay_balance` varchar(25) NOT NULL,
  `log_user` int(11) NOT NULL,
  `log_datetime` varchar(25) NOT NULL,
  `inv_type` varchar(15) NOT NULL DEFAULT 'jobcard',
  `delivery` varchar(10) NOT NULL DEFAULT 'no',
  `cancel` varchar(5) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`id`, `invoice_no`, `invoice_date`, `jobcard_id`, `cus_id`, `subtotal`, `dis_per`, `discount`, `total`, `paystatus`, `pay_balance`, `log_user`, `log_datetime`, `inv_type`, `delivery`, `cancel`) VALUES
(1, 'INV10001', '2024-01-01', 0, 22, '560.00', '', '0', '560.00', 'pending', '560.00', 1, '2024-01-29 00:05:36', 'direct', 'no', 'no'),
(2, 'INV10002', '2024-01-01', 0, 15, '1500.00', '', '0', '1500.00', 'yes', '0.00', 1, '2024-01-29 00:08:01', 'direct', 'no', 'no'),
(3, 'INV10003', '2024-01-02', 0, 16, '750.00', '', '0', '750.00', 'yes', '0.00', 1, '2024-01-29 00:08:43', 'direct', 'no', 'no'),
(4, 'INV10004', '2024-01-05', 0, 23, '225.00', '', '0', '225.00', 'yes', '0.00', 1, '2024-01-29 00:09:29', 'direct', 'no', 'no'),
(5, 'INV10005', '2024-01-06', 1, 14, '20050.00', '0', '0', '20050.00', 'pending', '20050.00', 1, '2024-01-29 00:18:13', 'jobcard', 'yes', 'no'),
(6, 'INV10006', '2024-01-29', 2, 19, '2545.00', '10', '254.50', '2290.50', 'pending', '2290.50', 1, '2024-02-29 00:19:36', 'jobcard', 'yes', 'no'),
(7, 'INV10007', '2024-02-01', 3, 21, '37800.00', '0', '0', '37800.00', 'pending', '22800.00', 1, '2024-02-29 00:19:43', 'jobcard', 'yes', 'no'),
(8, 'INV10008', '2024-03-02', 4, 1, '4340.00', '0', '0', '4340.00', 'yes', '0.00', 1, '2024-03-02 19:42:13', 'jobcard', 'yes', 'no'),
(9, 'INV10009', '2024-03-02', 5, 25, '4600.00', '0', '0', '4600.00', 'yes', '0.00', 1, '2024-03-02 22:45:48', 'jobcard', 'yes', 'no'),
(10, 'INV10010', '2024-02-02', 6, 1, '6820.00', '0', '0', '6820.00', 'pending', '6820.00', 1, '2024-03-02 22:45:58', 'jobcard', 'yes', 'no'),
(11, 'INV10011', '2024-01-17', 0, 24, '3000.00', '', '0', '3000.00', 'pending', '3000.00', 1, '2024-03-02 23:08:59', 'direct', 'no', 'no'),
(12, 'INV10012', '2024-01-24', 0, 8, '1200.00', '', '0', '1200.00', 'pending', '1200.00', 1, '2024-03-02 23:09:49', 'direct', 'no', 'yes'),
(13, 'INV10013', '2024-01-21', 0, 16, '5250.00', '', '0', '5250.00', 'pending', '5250.00', 1, '2024-03-02 23:13:30', 'direct', 'no', 'no'),
(14, 'INV10014', '2024-03-03', 7, 27, '1600.00', '0', '0', '1600.00', 'pending', '1600.00', 1, '2024-03-03 00:27:27', 'jobcard', 'yes', 'no'),
(15, 'INV10015', '2024-03-03', 8, 27, '5260.00', '0', '0', '5260.00', 'pending', '5260.00', 1, '2024-03-03 00:27:36', 'jobcard', 'yes', 'no'),
(16, 'INV10016', '2023-12-03', 9, 21, '94050.00', '10', '9405.00', '84645.00', 'pending', '84645.00', 1, '2024-03-03 00:27:42', 'jobcard', 'yes', 'no'),
(17, 'INV10017', '2024-03-03', 10, 28, '3500.00', '0', '0', '3500.00', 'yes', '0.00', 1, '2024-03-03 00:27:50', 'jobcard', 'yes', 'no'),
(18, 'INV10018', '2024-03-03', 11, 29, '3150.00', '0', '0', '3150.00', 'pending', '3150.00', 1, '2024-03-03 00:29:04', 'jobcard', 'yes', 'no'),
(19, 'INV10019', '2024-03-03', 12, 31, '4525.00', '0', '0', '4525.00', 'pending', '4525.00', 1, '2024-03-03 00:29:09', 'jobcard', 'no', 'no'),
(20, 'INV10020', '2024-02-03', 13, 30, '3000.00', '0', '0', '3000.00', 'yes', '0.00', 1, '2024-03-03 00:29:14', 'jobcard', 'yes', 'no'),
(21, 'INV10021', '2024-03-03', 15, 24, '6010.00', '0', '0', '6010.00', 'pending', '6010.00', 1, '2024-03-03 00:29:56', 'jobcard', 'yes', 'no'),
(22, 'INV10022', '2024-03-03', 17, 32, '4675.00', '0', '0', '4675.00', 'yes', '0.00', 1, '2024-03-03 00:30:43', 'jobcard', 'yes', 'no'),
(23, 'INV10023', '2024-03-03', 18, 34, '4300.00', '0', '0', '4300.00', 'yes', '0.00', 1, '2024-03-03 00:30:50', 'jobcard', 'no', 'no'),
(24, 'INV10024', '2023-12-03', 16, 26, '32100.00', '5', '1605.00', '30495.00', 'pending', '30495.00', 1, '2024-03-03 00:30:56', 'jobcard', 'yes', 'no'),
(25, 'INV10025', '2024-01-22', 0, 15, '5400.00', '', '0', '5400.00', 'yes', '0.00', 1, '2024-03-03 01:11:28', 'direct', 'no', 'no'),
(26, 'INV10026', '2024-01-25', 0, 8, '5000.00', '', '0', '5000.00', 'pending', '5000.00', 1, '2024-03-03 01:14:49', 'direct', 'no', 'no'),
(27, 'INV10027', '2024-03-07', 0, 34, '135.00', '', '0', '135.00', 'yes', '0.00', 1, '2024-03-15 23:09:45', 'direct', 'no', 'no'),
(28, 'INV10028', '2024-03-14', 0, 25, '250.00', '', '0', '250.00', 'yes', '0.00', 1, '2024-03-15 23:11:21', 'direct', 'no', 'no'),
(29, 'INV10029', '2024-03-29', 14, 33, '1350.00', '0', '0', '1350.00', 'yes', '0.00', 1, '2024-03-29 11:05:04', 'jobcard', 'no', 'no'),
(30, 'INV10030', '2024-03-18', 19, 37, '7850.00', '0', '0', '7850.00', 'pending', '4850.00', 1, '2024-03-30 12:45:50', 'jobcard', 'no', 'no'),
(32, 'INV10032', '2024-03-30', 21, 21, '2700.00', '0', '0', '2700.00', 'pending', '2700.00', 3, '2024-03-30 13:25:46', 'jobcard', 'no', 'no'),
(33, 'INV10033', '2024-03-31', 19, 37, '5000.00', '0', '0', '5000.00', 'pending', '5000.00', 3, '2024-03-31 13:53:11', 'jobcard', 'no', 'no'),
(34, 'INV10034', '2024-03-31', 23, 38, '2800.00', '0', '0', '2800.00', 'pending', '2800.00', 1, '2024-03-31 14:27:13', 'jobcard', 'no', 'no'),
(35, 'INV10035', '2024-02-15', 0, 24, '14000.00', '', '0', '14000.00', 'pending', '14000.00', 1, '2024-03-30 23:18:44', 'direct', 'no', 'no'),
(36, 'INV10036', '2024-03-31', 30, 37, '3950.00', '10', '395.00', '3555.00', 'yes', '0.00', 3, '2024-03-31 00:37:35', 'jobcard', 'yes', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `invoice_details`
--

CREATE TABLE IF NOT EXISTS `invoice_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `invoice_id` int(11) NOT NULL COMMENT 'id of invoice table',
  `prod_id` int(11) NOT NULL,
  `uprice` varchar(25) NOT NULL,
  `qty` varchar(25) NOT NULL,
  `amount` varchar(25) NOT NULL,
  `artwork` varchar(25) NOT NULL,
  `service` varchar(25) NOT NULL,
  `jitm_id` int(11) NOT NULL COMMENT 'id of jobcard details table',
  `description` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `invoice_details`
--

INSERT INTO `invoice_details` (`id`, `invoice_id`, `prod_id`, `uprice`, `qty`, `amount`, `artwork`, `service`, `jitm_id`, `description`) VALUES
(1, 1, 0, '30.00', '12', '360.00', '', '', 0, 'A4 double side printout - B & W'),
(2, 1, 0, '40.00', '5', '200.00', '', '', 0, 'A4 double side printout - Colour'),
(3, 2, 0, '15.00', '100', '1500.00', '', '', 0, 'A4 Photocopy'),
(4, 3, 0, '30.00', '25', '750.00', '', '', 0, 'A4 double side printout - B & W'),
(5, 4, 0, '45.00', '5', '225.00', '', '', 0, 'Laminating'),
(6, 5, 4, '150.00', '100', '15000.00', '300', '0.00', 1, ''),
(7, 5, 12, '890.00', '5', '4450.00', '300', '0.00', 2, ''),
(8, 6, 1, '2345.00', '1', '2345.00', '0.00', '200', 3, ''),
(9, 7, 11, '75.00', '500', '37500.00', '300', '0.00', 4, ''),
(10, 8, 1, '2170.00', '2', '4340.00', '0.00', '0.00', 5, ''),
(11, 9, 10, '1350.00', '3', '4050.00', '400.00', '150.00', 6, ''),
(12, 10, 1, '6370.00', '1', '6370.00', '450.00', '0.00', 7, ''),
(13, 11, 0, '10.00', '300', '3000.00', '', '', 0, 'A4 Photocopy'),
(14, 12, 0, '10.00', '120', '1200.00', '', '', 0, 'A4 Photocopy'),
(15, 13, 0, '15.00', '150', '2250.00', '', '', 0, 'A4 double side printout'),
(16, 13, 0, '60.00', '50', '3000.00', '', '', 0, 'A4 laminating'),
(17, 14, 10, '1350.00', '1', '1350.00', '0.00', '250.00', 8, ''),
(18, 15, 5, '243.00', '20', '4860.00', '400.00', '0.00', 9, ''),
(19, 16, 5, '624.00', '150', '93600.00', '450.00', '0.00', 10, ''),
(20, 17, 3, '150.00', '20', '3000.00', '300.00', '200.00', 11, ''),
(21, 18, 1, '1375.00', '2', '2750.00', '400.00', '0.00', 12, ''),
(22, 19, 11, '55.00', '75', '4125.00', '400.00', '0.00', 13, ''),
(23, 20, 9, '1500.00', '2', '3000.00', '0.00', '0.00', 14, ''),
(24, 21, 9, '1500.00', '1', '1500.00', '400.00', '150.00', 16, ''),
(25, 21, 14, '1980.00', '2', '3960.00', '0.00', '0.00', 17, ''),
(26, 22, 2, '165.00', '25', '4125.00', '350.00', '200.00', 20, ''),
(27, 23, 3, '150.00', '25', '3750.00', '350.00', '200.00', 21, ''),
(28, 24, 13, '60.00', '500', '30000.00', '300.00', '0.00', 18, ''),
(29, 24, 4, '14.00', '100', '1400.00', '400.00', '0.00', 19, ''),
(30, 25, 0, '17.00', '150', '2550.00', '', '', 0, 'A4 double side printout'),
(31, 25, 0, '57.00', '50', '2850.00', '', '', 0, 'A4 laminating'),
(32, 26, 0, '15.00', '200', '3000.00', '', '', 0, 'A4 double side printout - B & W'),
(33, 26, 0, '10.00', '200', '2000.00', '', '', 0, 'A4 Photocopy'),
(34, 27, 0, '9.00', '15', '135.00', '', '', 0, 'Photocopy - A4'),
(35, 28, 0, '25.00', '10', '250.00', '', '', 0, 'A4 color print out'),
(36, 29, 10, '1350.00', '1', '1350.00', '0.00', '0.00', 15, ''),
(37, 30, 12, '1250.00', '6', '7500.00', '350.00', '0.00', 22, ''),
(39, 32, 11, '55.00', '10', '550.00', '400.00', '0.00', 24, ''),
(40, 32, 10, '1350.00', '1', '1350.00', '400.00', '0.00', 25, ''),
(41, 33, 12, '1250.00', '4', '5000.00', '0.00', '0.00', 22, ''),
(42, 34, 4, '14.00', '200', '2800.00', '0.00', '0.00', 27, ''),
(43, 35, 0, '160.00', '50', '8000.00', '', '', 0, 'Laminating'),
(44, 35, 0, '600.00', '10', '6000.00', '', '', 0, 'Paper stripes'),
(45, 36, 3, '150.00', '25', '3750.00', '0.00', '200.00', 36, '');

-- --------------------------------------------------------

--
-- Table structure for table `issue_details`
--

CREATE TABLE IF NOT EXISTS `issue_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_no` varchar(15) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `stock_id` int(11) NOT NULL COMMENT 'id of grn_stock table',
  `return_qty` varchar(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Dumping data for table `issue_details`
--

INSERT INTO `issue_details` (`id`, `issue_no`, `item_id`, `qty`, `stock_id`, `return_qty`) VALUES
(1, 'MI10001', 1, '75', 4, '0'),
(2, 'MI10002', 7, '10', 5, '0'),
(3, 'MI10003', 5, '150', 1, '10'),
(4, 'MI10004', 11, '0.2', 6, '0'),
(5, 'MI10004', 12, '0.2', 8, '0'),
(6, 'MI10005', 1, '150', 4, '0'),
(7, 'MI10005', 11, '0.5', 6, '0'),
(8, 'MI10005', 12, '0.5', 8, '0'),
(9, 'MI10005', 13, '0.5', 9, '0'),
(10, 'MI10006', 14, '0.04', 7, '0'),
(11, 'MI10007', 12, '0.03', 8, '0'),
(12, 'MI10007', 5, '2', 1, '0'),
(13, 'MI10008', 8, '5', 3, '0'),
(14, 'MI10009', 7, '25', 5, '2'),
(15, 'MI10009', 13, '0.5', 9, '0'),
(16, 'MI10009', 12, '0.5', 8, '0'),
(17, 'MI10010', 14, '0.3', 7, '0'),
(18, 'MI10011', 5, '2', 1, '0'),
(19, 'MI10011', 14, '0.1', 7, '0'),
(20, 'MI10012', 11, '0.02', 6, '0.02'),
(21, 'MI10013', 7, '20', 5, '5');

-- --------------------------------------------------------

--
-- Table structure for table `issue_summary`
--

CREATE TABLE IF NOT EXISTS `issue_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `issue_no` varchar(15) NOT NULL,
  `issue_date` varchar(25) NOT NULL,
  `jobno` varchar(15) NOT NULL,
  `issued_to` varchar(75) NOT NULL,
  `user` int(11) NOT NULL,
  `datetime` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `issue_summary`
--

INSERT INTO `issue_summary` (`id`, `issue_no`, `issue_date`, `jobno`, `issued_to`, `user`, `datetime`) VALUES
(1, 'MI10001', '2024-03-03', 'JO10012', 'Janith', 1, '2024-03-03 15:49:45'),
(2, 'MI10002', '2024-03-03', 'JO10010', 'Janith', 1, '2024-03-03 15:54:24'),
(3, 'MI10003', '2024-03-03', 'JO10009', 'Shankar', 1, '2024-03-03 15:54:56'),
(4, 'MI10004', '2024-03-03', 'JO10009', 'Janith', 1, '2024-03-03 15:57:40'),
(5, 'MI10005', '2024-03-03', 'JO10009', 'Janith', 1, '2024-03-03 16:00:39'),
(6, 'MI10006', '2024-03-03', 'JO10010', 'Shankar', 1, '2024-03-03 16:01:20'),
(7, 'MI10007', '2024-03-03', 'JO10010', 'Shankar', 1, '2024-03-03 16:01:54'),
(8, 'MI10008', '2024-03-03', 'JO10011', 'Shankar', 1, '2024-03-03 16:02:53'),
(9, 'MI10009', '2024-03-03', 'JO10009', 'Keerthi', 1, '2024-03-03 16:03:48'),
(10, 'MI10010', '2024-03-03', 'JO10010', 'Kumara', 1, '2024-03-03 16:22:11'),
(11, 'MI10011', '2024-03-03', 'JO10011', 'Shankar', 1, '2024-03-03 16:22:53'),
(12, 'MI10012', '2024-03-14', 'JO10009', 'Janith', 1, '2024-03-29 10:36:52'),
(13, 'MI10013', '2024-03-31', 'JO10029', 'Thamal', 11, '2024-03-31 00:35:27');

-- --------------------------------------------------------

--
-- Table structure for table `jobcard`
--

CREATE TABLE IF NOT EXISTS `jobcard` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobno` varchar(25) NOT NULL,
  `job_date` varchar(25) NOT NULL,
  `quotation_id` int(11) NOT NULL COMMENT 'id of quotation table',
  `cus_id` int(11) NOT NULL,
  `machine` varchar(5) NOT NULL,
  `instructions` varchar(500) NOT NULL,
  `log_user` int(11) NOT NULL,
  `log_datetime` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Dumping data for table `jobcard`
--

INSERT INTO `jobcard` (`id`, `jobno`, `job_date`, `quotation_id`, `cus_id`, `machine`, `instructions`, `log_user`, `log_datetime`) VALUES
(1, 'JO10001', '2024-01-29', 1, 14, '', '', 1, '2024-02-29 00:17:18'),
(2, 'JO10002', '2024-02-29', 2, 19, '', '', 1, '2024-02-29 00:17:21'),
(3, 'JO10003', '2024-02-29', 3, 21, '', '', 1, '2024-02-29 00:17:24'),
(4, 'JO10004', '2024-03-02', 4, 1, '4', 'Refer attached sample.', 5, '2024-03-02 19:18:27'),
(5, 'JO10005', '2024-03-02', 8, 25, '5', '', 5, '2024-03-02 22:44:12'),
(6, 'JO10006', '2024-03-02', 7, 1, '4', '', 5, '2024-03-02 22:44:45'),
(7, 'JO10007', '2024-03-02', 10, 27, '5', '', 5, '2024-03-02 23:57:07'),
(8, 'JO10008', '2024-03-02', 11, 27, '2', '', 5, '2024-03-02 23:58:29'),
(9, 'JO10009', '2024-03-02', 5, 21, '1', '', 4, '2024-03-03 00:17:28'),
(10, 'JO10010', '2024-03-03', 12, 28, '1', '', 4, '2024-03-03 00:17:51'),
(11, 'JO10011', '2024-03-03', 13, 29, '4', '', 4, '2024-03-03 00:18:03'),
(12, 'JO10012', '2024-03-03', 15, 31, '2', '', 4, '2024-03-03 00:18:20'),
(13, 'JO10013', '2024-03-03', 14, 30, '1', '', 5, '2024-03-03 00:19:48'),
(14, 'JO10014', '2024-03-03', 18, 33, '5', '', 5, '2024-03-03 00:20:12'),
(15, 'JO10015', '2024-03-03', 6, 24, '2', '', 6, '2024-03-03 00:21:48'),
(16, 'JO10016', '2024-03-03', 9, 26, '1', '', 6, '2024-03-03 00:22:17'),
(17, 'JO10017', '2024-03-03', 16, 32, '2', '', 6, '2024-03-03 00:22:33'),
(18, 'JO10018', '2024-03-03', 19, 34, '1', '', 6, '2024-03-03 00:24:39'),
(19, 'JO10019', '2024-03-29', 20, 37, '2', '', 5, '2024-03-29 22:12:30'),
(20, 'JO10020', '2024-03-30', 17, 32, '1', '', 6, '2024-03-30 13:18:28'),
(21, 'JO10021', '2024-03-30', 24, 21, '1', '', 6, '2024-03-30 13:19:11'),
(22, 'JO10022', '2024-03-30', 25, 34, '2', '', 6, '2024-03-30 13:20:04'),
(23, 'JO10023', '2024-03-30', 22, 38, '2', '', 4, '2024-03-30 13:21:52'),
(24, 'JO10024', '2024-03-30', 23, 24, '1', '', 5, '2024-03-30 13:43:40'),
(25, 'JO10025', '2024-03-30', 27, 39, '2', '', 5, '2024-03-30 22:30:34'),
(26, 'JO10026', '2024-03-30', 28, 40, '1', '', 5, '2024-03-30 22:33:01'),
(27, 'JO10027', '2024-03-30', 29, 40, '1', '', 5, '2024-03-30 22:33:51'),
(28, 'JO10028', '2024-03-30', 30, 41, '2', '', 5, '2024-03-30 22:35:01'),
(29, 'JO10029', '2024-03-30', 31, 19, '1', '', 5, '2024-03-30 22:35:23'),
(30, 'JO10030', '2024-03-31', 40, 37, '1', '', 5, '2024-03-31 00:32:39'),
(31, 'JO10031', '2024-03-31', 41, 37, '2', '', 5, '2024-03-31 10:54:24');

-- --------------------------------------------------------

--
-- Table structure for table `jobcard_details`
--

CREATE TABLE IF NOT EXISTS `jobcard_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobcard_id` int(11) NOT NULL COMMENT 'id of jobcard table',
  `prod_id` int(11) NOT NULL,
  `qty` varchar(20) NOT NULL,
  `completed_qty` varchar(20) NOT NULL DEFAULT '0',
  `invoiced_qty` varchar(20) NOT NULL DEFAULT '0',
  `qitm_id` int(11) NOT NULL COMMENT 'id of quotation details table',
  `artwork_inv` varchar(5) NOT NULL DEFAULT 'no',
  `service_inv` varchar(5) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

--
-- Dumping data for table `jobcard_details`
--

INSERT INTO `jobcard_details` (`id`, `jobcard_id`, `prod_id`, `qty`, `completed_qty`, `invoiced_qty`, `qitm_id`, `artwork_inv`, `service_inv`) VALUES
(1, 1, 4, '100', '100', '100', 1, 'yes', 'no'),
(2, 1, 12, '5', '5', '5', 2, 'yes', 'no'),
(3, 2, 1, '1', '1', '1', 3, 'no', 'yes'),
(4, 3, 11, '500', '500', '500', 4, 'yes', 'no'),
(5, 4, 1, '2', '2', '2', 5, 'no', 'no'),
(6, 5, 10, '3', '3', '3', 10, 'yes', 'yes'),
(7, 6, 1, '1', '1', '1', 9, 'yes', 'no'),
(8, 7, 10, '1', '1', '1', 13, 'no', 'yes'),
(9, 8, 5, '20', '20', '20', 14, 'yes', 'no'),
(10, 9, 5, '150', '150', '150', 6, 'yes', 'no'),
(11, 10, 3, '20', '20', '20', 15, 'yes', 'yes'),
(12, 11, 1, '2', '2', '2', 16, 'yes', 'no'),
(13, 12, 11, '75', '75', '75', 18, 'yes', 'no'),
(14, 13, 9, '2', '2', '2', 17, 'no', 'no'),
(15, 14, 10, '1', '1', '1', 21, 'no', 'no'),
(16, 15, 9, '1', '1', '1', 7, 'yes', 'yes'),
(17, 15, 14, '2', '2', '2', 8, 'no', 'no'),
(18, 16, 13, '500', '500', '500', 11, 'yes', 'no'),
(19, 16, 4, '100', '102', '100', 12, 'yes', 'no'),
(20, 17, 2, '25', '25', '25', 19, 'yes', 'yes'),
(21, 18, 3, '25', '25', '25', 22, 'yes', 'yes'),
(22, 19, 12, '10', '10', '10', 23, 'yes', 'no'),
(23, 20, 12, '30', '30', '0', 20, 'yes', 'no'),
(24, 21, 11, '10', '10', '10', 29, 'yes', 'no'),
(25, 21, 10, '1', '1', '1', 30, 'yes', 'no'),
(26, 22, 16, '20', '20', '0', 31, 'no', 'no'),
(27, 23, 4, '200', '200', '200', 25, 'no', 'no'),
(28, 24, 11, '50', '50', '0', 26, 'no', 'no'),
(29, 24, 10, '5', '5', '0', 27, 'no', 'no'),
(30, 24, 3, '20', '20', '0', 28, 'no', 'no'),
(31, 25, 2, '15', '0', '0', 34, 'no', 'no'),
(32, 26, 4, '500', '300', '0', 35, 'no', 'no'),
(33, 27, 2, '100', '0', '0', 36, 'no', 'no'),
(34, 28, 13, '500', '0', '0', 37, 'no', 'no'),
(35, 29, 16, '25', '0', '0', 38, 'no', 'no'),
(36, 30, 3, '25', '25', '25', 47, 'no', 'yes'),
(37, 31, 10, '1', '0', '0', 48, 'no', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `jobcard_material`
--

CREATE TABLE IF NOT EXISTS `jobcard_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jobcard_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1130 ;

--
-- Dumping data for table `jobcard_material`
--

INSERT INTO `jobcard_material` (`id`, `jobcard_id`, `item_id`, `qty`) VALUES
(1, 4, 16, '2'),
(2, 4, 13, '0.02'),
(3, 4, 14, '0.05'),
(1088, 5, 9, '3'),
(1089, 6, 15, '1'),
(1090, 7, 10, '1'),
(1091, 8, 8, '20'),
(1092, 9, 4, '155'),
(1093, 10, 8, '20'),
(1094, 11, 15, '2'),
(1095, 12, 1, '75'),
(1096, 13, 8, '1'),
(1097, 14, 9, '1'),
(1098, 15, 8, '1'),
(1099, 15, 1, '2'),
(1100, 16, 2, '500'),
(1101, 16, 4, '100'),
(1102, 17, 6, '25'),
(1103, 18, 7, '25'),
(1104, 19, 18, '2'),
(1105, 19, 14, '0.12'),
(1106, 20, 6, '5'),
(1107, 21, 26, '10'),
(1108, 21, 9, '1'),
(1109, 22, 7, '15'),
(1110, 22, 13, '0.01'),
(1111, 22, 11, '0.01'),
(1112, 23, 23, '150'),
(1113, 23, 14, '0.015'),
(1114, 24, 1, '50'),
(1115, 24, 9, '5'),
(1116, 24, 4, '20'),
(1117, 25, 3, '15'),
(1118, 25, 14, '0.01'),
(1119, 26, 24, '500'),
(1120, 26, 11, '0.15'),
(1121, 26, 14, '0.15'),
(1122, 27, 6, '100'),
(1123, 27, 14, '0.012'),
(1124, 28, 26, '200'),
(1125, 29, 7, '25'),
(1126, 30, 23, '15'),
(1127, 30, 12, '0.012'),
(1128, 31, 10, '1'),
(1129, 31, 11, '0.015');

-- --------------------------------------------------------

--
-- Table structure for table `machine`
--

CREATE TABLE IF NOT EXISTS `machine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `machine`
--

INSERT INTO `machine` (`id`, `name`) VALUES
(1, 'Digital Printer 1'),
(2, 'Digital Printer 2'),
(3, 'Ink Jet Printer'),
(4, 'Flex Printing Machine 1'),
(5, 'Sublimation Machine'),
(6, 'Flex Printing Machine 2');

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE IF NOT EXISTS `pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `icon` varchar(50) NOT NULL,
  `description` varchar(30) NOT NULL,
  `php_name` varchar(75) NOT NULL,
  `section` varchar(30) NOT NULL,
  `section_order` int(11) NOT NULL,
  `page_order` int(11) NOT NULL DEFAULT '1',
  `active` varchar(5) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=41 ;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `icon`, `description`, `php_name`, `section`, `section_order`, `page_order`, `active`) VALUES
(1, 'users', 'Register Customer', 'customer_register.php', 'Customer', 1, 1, 'yes'),
(2, 'file-text', 'Create Quotation', 'pending_requests.php', 'Quotation', 2, 1, 'yes'),
(3, 'book', 'Open Job Card', 'job_plan.php', 'Job Card', 3, 1, 'yes'),
(4, 'credit-card', 'Generate Invoice', 'pending_jobs.php', 'Invoice', 4, 1, 'yes'),
(5, 'box', 'Purchase Order', 'purchase_order.php', 'Inventory', 5, 1, 'yes'),
(6, 'box', 'Good Received Note', 'goods_received.php', 'Inventory', 5, 3, 'yes'),
(7, 'box', 'Issue Raw Material', 'issue_rawmat.php', 'Inventory', 5, 5, 'yes'),
(8, 'pie-chart', 'Sales', 'sales_report.php', 'Reports', 7, 1, 'yes'),
(9, 'settings', 'Create User', 'user_register.php', 'Maintenance', 8, 7, 'yes'),
(10, 'settings', 'Register Supplier', 'supplier_register.php', 'Maintenance', 8, 2, 'yes'),
(11, 'settings', 'Register Raw Material', 'raw_material_register.php', 'Maintenance', 8, 4, 'yes'),
(12, 'settings', 'Register RM Category', 'rawmat_cat_register.php', 'Maintenance', 8, 3, 'yes'),
(13, 'settings', 'Register Product', 'product_register.php', 'Maintenance', 8, 5, 'yes'),
(14, 'settings', 'Price Management', 'price_management.php', 'Maintenance', 8, 6, 'yes'),
(17, 'file-text', 'Approve Quotation', 'pending_approve_quotations.php', 'Quotation', 2, 2, 'yes'),
(18, 'book', 'Complete Job', 'complete_job.php', 'Job Card', 3, 2, 'yes'),
(19, 'box', 'Approve PO', 'pending_po.php', 'Inventory', 5, 2, 'yes'),
(20, 'box', 'Approve GRN', 'pending_grn.php', 'Inventory', 5, 4, 'yes'),
(21, 'dollar-sign', 'Receipt', 'receipt.php', 'Payment', 6, 2, 'yes'),
(22, 'dollar-sign', 'Make Payment', 'pay_voucher.php', 'Payment', 6, 3, 'yes'),
(23, 'box', 'Return Raw Material', 'return_rawmat.php', 'Inventory', 5, 6, 'yes'),
(24, 'dollar-sign', 'Advance Payment', 'advance_payment.php', 'Payment', 6, 1, 'yes'),
(25, 'pie-chart', 'Stock', 'stock_report.php', 'Reports', 7, 2, 'yes'),
(26, 'pie-chart', 'Customer Ageing', 'customer_ageing.php', 'Reports', 7, 3, 'yes'),
(27, 'pie-chart', 'Receivable', 'receivable.php', 'Reports', 7, 4, 'yes'),
(28, 'pie-chart', 'Payments Received', 'receipt_report.php', 'Reports', 7, 5, 'yes'),
(29, 'pie-chart', 'Payable', 'payable.php', 'Reports', 7, 6, 'yes'),
(30, 'pie-chart', 'Payments Done', 'voucher_report.php', 'Reports', 7, 7, 'yes'),
(31, 'credit-card', 'Direct Invoice', 'direct_invoice.php', 'Invoice', 4, 3, 'yes'),
(32, 'pie-chart', 'Sales - sales person wise', 'sales_person.php', 'Reports', 7, 8, 'yes'),
(33, 'pie-chart', 'Sales - product wise', 'sales_product.php', 'Reports', 7, 9, 'yes'),
(34, 'settings', 'Manage Privileges', 'user_privileges.php', 'Maintenance', 8, 8, 'yes'),
(35, 'pie-chart', 'Gross Profit', 'profitability_report.php', 'Reports', 7, 10, 'yes'),
(36, 'credit-card', 'Delivery', 'pending_invoices.php', 'Invoice', 4, 2, 'yes'),
(37, 'pie-chart', 'Stock Movement', 'stock_movement.php', 'Reports', 7, 11, 'yes'),
(38, 'settings', 'Register Machine', 'machine_register.php', 'Maintenance', 8, 1, 'yes'),
(39, 'settings', 'Create User Type', 'usertype_register.php', 'Maintenance', 8, 9, 'yes'),
(40, 'users', 'Request for quote', 'customer_request.php', 'Customer', 1, 2, 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `payment_voucher`
--

CREATE TABLE IF NOT EXISTS `payment_voucher` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `v_no` varchar(15) NOT NULL,
  `v_date` varchar(15) NOT NULL,
  `supplier` int(11) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `paytype` varchar(15) NOT NULL,
  `cheq_no` varchar(30) NOT NULL,
  `cheq_date` varchar(25) NOT NULL,
  `deposit_ref` varchar(75) NOT NULL,
  `user` int(11) NOT NULL,
  `datetime` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `payment_voucher`
--

INSERT INTO `payment_voucher` (`id`, `v_no`, `v_date`, `supplier`, `amount`, `paytype`, `cheq_no`, `cheq_date`, `deposit_ref`, `user`, `datetime`) VALUES
(1, 'PV10001', '2023-11-02', 1, '58900.00', 'Cash', '', '', '', 1, '2024-02-28 23:46:04'),
(2, 'PV10002', '2023-11-06', 2, '25500.00', 'Bank Deposit', '', '', 'RTH851', 1, '2024-02-28 23:46:33'),
(3, 'PV10003', '2023-11-10', 3, '15000.00', 'Cheque', '125348', '2023-11-24', '', 1, '2024-02-28 23:47:19'),
(4, 'PV10004', '2023-11-23', 5, '100000.00', 'Cheque', '125315', '2023-11-30', '', 1, '2024-02-28 23:52:39'),
(5, 'PV10005', '2023-11-29', 2, '10000.00', 'Bank Deposit', '', '', 'COM00456', 1, '2024-03-29 11:32:18'),
(6, 'PV10006', '2024-03-01', 5, '143500.00', 'Cheque', '233568', '2024-03-07', '', 1, '2024-03-30 11:57:41'),
(7, 'PV10007', '2024-03-01', 3, '6600.00', 'Cash', '', '', '', 1, '2024-03-30 11:57:57'),
(8, 'PV10008', '2024-03-30', 2, '20000.00', 'Cheque', '235654', '2024-03-11', '', 1, '2024-03-30 11:58:37'),
(9, 'PV10009', '2024-03-05', 1, '5000.00', 'Cash', '', '', '', 1, '2024-03-30 11:59:49'),
(10, 'PV10010', '2024-03-07', 5, '45000.00', 'Cheque', '468211', '2024-03-14', '', 1, '2024-03-30 12:00:30'),
(11, 'PV10011', '2024-03-10', 5, '30000.00', 'Bank Deposit', '', '', 'GTF112243', 1, '2024-03-30 12:00:59'),
(12, 'PV10012', '2024-03-31', 2, '4750.00', 'Cash', '', '', '', 3, '2024-03-31 00:18:15'),
(13, 'PV10013', '2024-03-31', 7, '4500.00', 'Cheque', '455788', '2024-04-10', '', 3, '2024-03-31 10:46:39');

-- --------------------------------------------------------

--
-- Table structure for table `payment_voucher_detail`
--

CREATE TABLE IF NOT EXISTS `payment_voucher_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `v_no` varchar(15) NOT NULL,
  `grn_no` varchar(15) NOT NULL,
  `amount` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `payment_voucher_detail`
--

INSERT INTO `payment_voucher_detail` (`id`, `v_no`, `grn_no`, `amount`) VALUES
(1, 'PV10001', 'GRN10002', '58900.00'),
(2, 'PV10002', 'GRN10001', '25500.00'),
(3, 'PV10003', 'GRN10005', '15000.00'),
(4, 'PV10004', 'GRN10003', '50000.00'),
(5, 'PV10004', 'GRN10004', '50000.00'),
(6, 'PV10005', 'GRN10001', '10000.00'),
(7, 'PV10006', 'GRN10003', '143500.00'),
(8, 'PV10007', 'GRN10005', '6600.00'),
(9, 'PV10008', 'GRN10001', '13000.00'),
(10, 'PV10008', 'GRN10008', '7000.00'),
(11, 'PV10009', 'GRN10006', '5000.00'),
(12, 'PV10010', 'GRN10004', '45000.00'),
(13, 'PV10011', 'GRN10004', '30000.00'),
(14, 'PV10012', 'GRN10010', '4750.00'),
(15, 'PV10013', 'GRN10011', '4500.00');

-- --------------------------------------------------------

--
-- Table structure for table `pricing`
--

CREATE TABLE IF NOT EXISTS `pricing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `measure` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `pricing`
--

INSERT INTO `pricing` (`id`, `name`, `measure`) VALUES
(1, 'Per unit', ''),
(2, 'Per sq. inch', 'Inch'),
(3, 'Per sq. feet', 'Feet');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(35) NOT NULL,
  `material` tinyint(1) NOT NULL,
  `size` tinyint(1) NOT NULL,
  `finishing` tinyint(1) NOT NULL,
  `color` tinyint(1) NOT NULL,
  `spec1` tinyint(1) NOT NULL,
  `spec2` tinyint(1) NOT NULL,
  `pricing` varchar(20) NOT NULL DEFAULT '1',
  `uprice` varchar(25) NOT NULL DEFAULT '0.00',
  `image1` varchar(150) NOT NULL,
  `image2` varchar(150) NOT NULL,
  `image3` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `material`, `size`, `finishing`, `color`, `spec1`, `spec2`, `pricing`, `uprice`, `image1`, `image2`, `image3`) VALUES
(1, 'Banner Printing', 1, 0, 1, 0, 1, 1, '3', '75.00', '1upd1.jpg', '1upd2.jpg', '1upd3.jpg'),
(2, 'Certificate Printing', 1, 0, 0, 1, 0, 0, '1', '165.00', '2upd1.png', '', ''),
(3, 'Invitation Printing', 1, 1, 0, 1, 0, 0, '1', '150.00', '3upd1.jpg', '', ''),
(4, 'Visiting Card Printing', 1, 0, 0, 1, 0, 0, '1', '14.00', '4upd1.jpg', '', ''),
(5, 'Sticker Printing', 1, 0, 1, 0, 1, 1, '2', '1.50', '5upd1.jpg', '', ''),
(9, 'Seal Making', 1, 0, 0, 1, 0, 0, '1', '1500.00', '9upd1.jpg', '', ''),
(10, 'Mug Printing', 1, 0, 0, 0, 0, 0, '1', '1350.00', '10upd1.jpeg', '', ''),
(11, 'Leaflet Printing', 1, 1, 0, 0, 0, 0, '1', '55.00', '11upd1.jpg', '', ''),
(12, 'ID Card Printing', 1, 0, 0, 0, 1, 1, '1', '400.00', '12upd1.jpg', '', ''),
(13, 'Notice Printing', 1, 1, 0, 1, 0, 0, '1', '60.00', '13upd1.jpg', '', ''),
(14, 'Voucher/Bill Book Printing', 1, 1, 0, 1, 1, 0, '1', '1750.00', '14upd1.png', '', ''),
(16, 'Brochure Printing', 1, 1, 1, 1, 0, 0, '1', '30.00', '16upd1.png', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `pro_color`
--

CREATE TABLE IF NOT EXISTS `pro_color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Dumping data for table `pro_color`
--

INSERT INTO `pro_color` (`id`, `prod_id`, `name`) VALUES
(1, 2, '01 Colour'),
(2, 2, '02 Colour'),
(3, 2, '04 Colour'),
(4, 3, '01 Colour'),
(5, 3, '02 Colour'),
(6, 3, '04 Colour'),
(7, 4, '01 Colour'),
(8, 4, '02 Colour'),
(9, 4, '04 Colour'),
(10, 9, 'Violet'),
(11, 9, 'Blue'),
(12, 9, 'Black'),
(13, 9, 'Green'),
(14, 9, 'Red'),
(15, 13, '01 Colour'),
(16, 13, '02 Colour'),
(17, 13, '04 Colour'),
(18, 14, '01 Colour'),
(19, 14, '02 Colour'),
(20, 14, '04 Colour'),
(21, 16, '01 Colour'),
(22, 16, '02 Colour'),
(23, 16, '04 Colour');

-- --------------------------------------------------------

--
-- Table structure for table `pro_finishing`
--

CREATE TABLE IF NOT EXISTS `pro_finishing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `uprice` varchar(25) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `pro_finishing`
--

INSERT INTO `pro_finishing` (`id`, `prod_id`, `name`, `uprice`) VALUES
(1, 1, 'Rings', '20.00'),
(2, 1, 'PVC', '30.00'),
(3, 1, 'Pocket', '20.00'),
(4, 1, 'Timber with Flex', '50.00'),
(5, 1, 'Aluminium Frame with Flex', '40.00'),
(6, 1, 'Spacing', '30.00'),
(7, 5, 'With Laminating', '75.00'),
(8, 5, 'Without Laminating', '0.00'),
(12, 16, 'With Binding', '700.00'),
(13, 16, 'With Laminating', '420.00');

-- --------------------------------------------------------

--
-- Table structure for table `pro_material`
--

CREATE TABLE IF NOT EXISTS `pro_material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `pro_material`
--

INSERT INTO `pro_material` (`id`, `prod_id`, `name`) VALUES
(1, 1, 'Flex One Side Black'),
(2, 1, 'White Flex'),
(3, 1, 'Light Box Flex'),
(4, 2, 'Art Board'),
(5, 2, 'Ivory Board'),
(6, 2, 'Ice Silver'),
(7, 2, 'Ice Gold'),
(8, 2, 'Conqueror'),
(9, 3, 'Art Board'),
(10, 3, 'Ivory Board'),
(11, 3, 'Ice Silver'),
(12, 3, 'Ice Gold'),
(13, 3, 'Conqueror'),
(14, 4, 'Art Board'),
(15, 4, 'Ivory Board'),
(16, 4, 'Ice Silver'),
(17, 4, 'Ice Gold'),
(18, 4, 'Conqueror'),
(19, 5, 'White Sticker'),
(20, 5, 'Transparent'),
(21, 5, 'One Way Vision'),
(22, 5, 'Diamond Cut Sticker'),
(23, 5, 'Magnet Sticker'),
(24, 5, 'Sand Blast Sticker'),
(25, 9, '2255 Seal'),
(26, 9, '2267 Seal'),
(27, 9, '3267 Seal'),
(28, 9, 'Round Seal'),
(29, 10, 'White Mug'),
(30, 10, 'Magic Mug'),
(31, 10, 'Animal Mug'),
(32, 11, 'Bank Paper 80 GSM'),
(33, 11, 'Bank Paper 100 GSM'),
(34, 11, 'Art Paper 100 GSM'),
(35, 11, 'Art Paper 120 GSM'),
(36, 11, 'Art Paper 150 GSM'),
(37, 12, 'Plastic Card'),
(38, 12, 'Normal Card'),
(39, 13, 'Art Paper'),
(40, 13, 'Bank Paper'),
(41, 14, 'NCR Paper'),
(42, 14, 'Bank Paper 70 GSM'),
(43, 14, 'Bank Paper 80 GSM'),
(44, 14, 'Dimy Paper'),
(45, 16, 'Art Board'),
(46, 16, 'Ivory Board'),
(47, 16, 'Ice Silver'),
(48, 16, 'Ice Gold'),
(49, 16, 'Conqueror'),
(50, 16, 'Art Paper'),
(51, 16, 'Bank Paper');

-- --------------------------------------------------------

--
-- Table structure for table `pro_size`
--

CREATE TABLE IF NOT EXISTS `pro_size` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `pro_size`
--

INSERT INTO `pro_size` (`id`, `prod_id`, `name`) VALUES
(1, 3, 'A6'),
(2, 3, 'A5'),
(3, 3, 'Other (Specify below)'),
(4, 11, 'B5'),
(5, 11, 'A5'),
(6, 11, 'A4'),
(7, 13, 'A5'),
(8, 13, 'A4'),
(9, 13, 'A3'),
(10, 13, '12&quot; x 18&quot;'),
(11, 14, 'A6'),
(12, 14, 'A5'),
(13, 14, 'A4'),
(14, 14, 'B5'),
(15, 16, 'A4'),
(16, 16, 'Other (Specify below)');

-- --------------------------------------------------------

--
-- Table structure for table `pro_spec1`
--

CREATE TABLE IF NOT EXISTS `pro_spec1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `uprice` varchar(25) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `pro_spec1`
--

INSERT INTO `pro_spec1` (`id`, `prod_id`, `name`, `uprice`) VALUES
(1, 1, 'Gloss', '50.00'),
(2, 1, 'Matt', '45.00'),
(3, 5, 'Gloss', '50.00'),
(4, 5, 'Matt', '45.00'),
(5, 12, 'One Side', '0.00'),
(6, 12, 'Both Side', '350.00'),
(7, 14, 'Auto Carbon', '100.00'),
(8, 14, 'Normal', '0.00'),
(9, 14, '1 Layer', '75.00'),
(10, 14, '2 Layer', '120.00'),
(11, 14, '3 Layer', '230.00');

-- --------------------------------------------------------

--
-- Table structure for table `pro_spec2`
--

CREATE TABLE IF NOT EXISTS `pro_spec2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `prod_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `uprice` varchar(25) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `pro_spec2`
--

INSERT INTO `pro_spec2` (`id`, `prod_id`, `name`, `uprice`) VALUES
(1, 1, 'None', '0.00'),
(2, 1, 'Pull-up', '200.00'),
(3, 1, 'X-stand', '180.00'),
(4, 5, 'Normal Paste', '20.00'),
(5, 5, 'Sunboard Paste', '25.00'),
(6, 5, 'Corrugate Paste', '35.00'),
(7, 5, 'Clear Plastic Paste', '30.00'),
(8, 12, 'With Tag & Holder', '500.00'),
(9, 12, 'Without Tag & Holder', '0.00');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_detail`
--

CREATE TABLE IF NOT EXISTS `purchase_order_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_no` varchar(15) NOT NULL,
  `item_id` int(11) NOT NULL,
  `uprice` varchar(15) NOT NULL,
  `po_qty` varchar(10) NOT NULL,
  `amount` varchar(15) NOT NULL,
  `grn_qty` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `purchase_order_detail`
--

INSERT INTO `purchase_order_detail` (`id`, `po_no`, `item_id`, `uprice`, `po_qty`, `amount`, `grn_qty`) VALUES
(1, 'PO10001', 5, '40.00', '700', '28000.00', '0'),
(2, 'PO10001', 6, '41.00', '500', '20500.00', '0'),
(3, 'PO10002', 8, '38.00', '500', '19000.00', '0'),
(4, 'PO10002', 1, '32.00', '700', '22400.00', '0'),
(5, 'PO10002', 7, '35.00', '500', '17500.00', '0'),
(6, 'PO10003', 11, '3250', '30', '97500.00', '0'),
(7, 'PO10003', 14, '3200', '30', '96000.00', '0'),
(8, 'PO10004', 12, '3250', '30', '97500.00', '0'),
(9, 'PO10004', 13, '3250', '30', '97500.00', '0'),
(10, 'PO10005', 9, '550', '24', '13200.00', '0'),
(11, 'PO10005', 10, '700', '12', '8400.00', '0'),
(12, 'PO10006', 1, '35.00', '200', '7000.00', '0'),
(13, 'PO10006', 2, '32.00', '200', '6400.00', '0'),
(14, 'PO10007', 9, '450.00', '12', '5400.00', '0'),
(15, 'PO10008', 6, '50.00', '150', '7500.00', '0'),
(16, 'PO10009', 18, '25.00', '30', '750.00', '15'),
(17, 'PO10010', 15, '4300', '3', '12900.00', '3'),
(18, 'PO10010', 16, '4500', '2', '9000.00', '2'),
(19, 'PO10011', 37, '1200.00', '5', '6000.00', '5'),
(20, 'PO10012', 23, '850.00', '20', '17000.00', '20'),
(21, 'PO10012', 24, '780.00', '20', '15600.00', '20'),
(22, 'PO10012', 19, '1200.00', '10', '12000.00', '10'),
(23, 'PO10013', 2, '45.00', '50', '2250.00', '0'),
(24, 'PO10013', 7, '50.00', '50', '2500.00', '25'),
(25, 'PO10014', 33, '500.00', '20', '10000.00', '5'),
(26, 'PO10014', 35, '150.00', '10', '1500.00', '0');

-- --------------------------------------------------------

--
-- Table structure for table `purchase_order_summary`
--

CREATE TABLE IF NOT EXISTS `purchase_order_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `po_no` varchar(15) NOT NULL,
  `po_date` varchar(25) NOT NULL,
  `supplier` int(11) NOT NULL,
  `total` varchar(15) NOT NULL,
  `snote` varchar(500) NOT NULL,
  `grn` varchar(5) NOT NULL DEFAULT 'no',
  `user` int(11) NOT NULL,
  `datetime` varchar(25) NOT NULL,
  `approval` varchar(10) NOT NULL DEFAULT 'pending',
  `app_user` int(11) NOT NULL,
  `app_datetime` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=15 ;

--
-- Dumping data for table `purchase_order_summary`
--

INSERT INTO `purchase_order_summary` (`id`, `po_no`, `po_date`, `supplier`, `total`, `snote`, `grn`, `user`, `datetime`, `approval`, `app_user`, `app_datetime`) VALUES
(1, 'PO10001', '2023-10-01', 2, '48500.00', '', 'yes', 1, '2024-02-28 22:52:41', 'yes', 1, '2024-02-28 22:52:56'),
(2, 'PO10002', '2023-10-12', 1, '58900.00', '', 'yes', 1, '2024-02-28 22:55:23', 'yes', 1, '2024-02-28 23:37:17'),
(3, 'PO10003', '2023-10-20', 5, '193500.00', '', 'yes', 1, '2024-02-28 23:31:38', 'yes', 1, '2024-02-28 23:37:20'),
(4, 'PO10004', '2023-10-25', 5, '195000.00', '', 'yes', 1, '2024-02-28 23:32:26', 'yes', 1, '2024-02-28 23:37:23'),
(5, 'PO10005', '2024-11-06', 3, '21600.00', '', 'yes', 1, '2024-02-28 23:35:14', 'yes', 1, '2024-02-28 23:37:56'),
(6, 'PO10006', '2024-03-02', 1, '13400.00', '', 'yes', 1, '2024-03-06 02:08:33', 'yes', 1, '2024-03-06 02:21:44'),
(7, 'PO10007', '2024-03-02', 3, '5400.00', '', 'yes', 1, '2024-03-06 02:09:15', 'yes', 1, '2024-03-06 02:27:08'),
(8, 'PO10008', '2024-03-04', 2, '7500.00', '', 'yes', 1, '2024-03-06 02:10:00', 'yes', 1, '2024-03-06 02:27:12'),
(9, 'PO10009', '2024-03-11', 2, '750.00', '', 'no', 1, '2024-03-29 00:42:15', 'yes', 1, '2024-03-29 00:42:35'),
(10, 'PO10010', '2024-03-12', 6, '21900.00', '', 'no', 1, '2024-03-30 23:10:47', 'pending', 0, ''),
(11, 'PO10011', '2024-03-14', 7, '6000.00', '', 'no', 1, '2024-03-30 23:13:31', 'pending', 0, ''),
(12, 'PO10012', '2024-03-15', 8, '44600.00', '', 'no', 1, '2024-03-30 23:14:54', 'pending', 0, ''),
(13, 'PO10013', '2024-03-31', 2, '4750.00', 'Expected delivery on 05-04-2024', 'no', 11, '2024-03-31 00:13:24', 'yes', 10, '2024-03-31 00:14:17'),
(14, 'PO10014', '2024-03-31', 7, '11500.00', '', 'no', 11, '2024-03-31 10:43:56', 'yes', 10, '2024-03-31 10:44:18');

-- --------------------------------------------------------

--
-- Table structure for table `quotation`
--

CREATE TABLE IF NOT EXISTS `quotation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `q_no` varchar(10) NOT NULL,
  `q_date` varchar(15) NOT NULL,
  `req_id` int(11) NOT NULL,
  `cus_id` varchar(5) NOT NULL,
  `sales_ex` int(11) NOT NULL,
  `subtotal` varchar(25) NOT NULL,
  `dis_per` varchar(25) NOT NULL,
  `discount` varchar(25) NOT NULL,
  `total` varchar(25) NOT NULL,
  `log_user` int(11) NOT NULL,
  `log_datetime` varchar(25) NOT NULL,
  `approval` varchar(5) NOT NULL DEFAULT 'no',
  `appr_user` int(11) NOT NULL,
  `appr_datetime` varchar(25) NOT NULL,
  `confirm` varchar(5) NOT NULL DEFAULT 'no',
  `conf_datetime` varchar(25) NOT NULL,
  `job_alloc` varchar(10) NOT NULL DEFAULT 'no',
  `job_user` int(11) NOT NULL,
  `joball_datetime` varchar(25) NOT NULL,
  `jobcard` varchar(10) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=44 ;

--
-- Dumping data for table `quotation`
--

INSERT INTO `quotation` (`id`, `q_no`, `q_date`, `req_id`, `cus_id`, `sales_ex`, `subtotal`, `dis_per`, `discount`, `total`, `log_user`, `log_datetime`, `approval`, `appr_user`, `appr_datetime`, `confirm`, `conf_datetime`, `job_alloc`, `job_user`, `joball_datetime`, `jobcard`) VALUES
(1, 'QT10001', '2024-02-28', 1, '14', 7, '20050.00', '', '0', '20050.00', 1, '2024-01-28 22:06:47', 'yes', 1, '2024-01-29 00:13:00', 'yes', '2024-03-05 19:18:57', 'yes', 1, '2024-01-29 00:16:31', 'yes'),
(2, 'QT10002', '2024-02-28', 2, '19', 7, '2545.00', '10', '254.50', '2290.50', 1, '2024-02-28 22:49:20', 'yes', 1, '2024-02-29 00:13:07', 'yes', '', 'yes', 1, '2024-02-29 00:16:38', 'yes'),
(3, 'QT10003', '2024-02-29', 4, '21', 2, '37800.00', '', '0', '37800.00', 1, '2024-02-29 00:15:13', 'yes', 1, '2024-02-29 00:15:28', 'yes', '', 'yes', 1, '2024-02-29 00:16:43', 'yes'),
(4, 'QT10004', '2024-02-29', 6, '1', 8, '4340.00', '', '0', '4340.00', 1, '2024-02-29 21:27:35', 'yes', 1, '2024-02-29 21:35:18', 'yes', '2024-02-29 22:49:02', 'yes', 5, '2024-03-01 09:00:24', 'yes'),
(5, 'QT10005', '2024-03-02', 3, '21', 2, '94050.00', '10', '9405.00', '84645.00', 1, '2024-03-02 15:43:49', 'yes', 1, '2024-03-02 15:53:32', 'yes', '2024-03-02 15:55:02', 'yes', 4, '2024-03-02 15:56:41', 'yes'),
(6, 'QT10006', '2024-03-02', 5, '24', 7, '6010.00', '', '0', '6010.00', 1, '2024-03-02 15:44:50', 'yes', 1, '2024-03-02 15:53:37', 'yes', '2024-03-02 15:55:02', 'yes', 6, '2024-03-02 15:56:47', 'yes'),
(7, 'QT10007', '2024-03-02', 7, '1', 8, '6820.00', '', '0', '6820.00', 1, '2024-03-02 15:45:16', 'yes', 1, '2024-03-02 15:53:43', 'yes', '2024-03-02 15:55:02', 'yes', 5, '2024-03-02 21:15:50', 'yes'),
(8, 'QT10008', '2024-03-02', 8, '25', 9, '4600.00', '', '0', '4600.00', 1, '2024-03-02 15:48:52', 'yes', 1, '2024-03-02 20:25:43', 'yes', '2024-03-02 20:55:43', 'yes', 5, '2024-03-02 21:19:07', 'yes'),
(9, 'QT10009', '2024-03-02', 9, '26', 7, '32100.00', '5', '1605.00', '30495.00', 1, '2024-03-02 15:53:16', 'yes', 1, '2024-03-01 20:26:03', 'yes', '2024-03-01 21:26:03', 'yes', 6, '2024-03-02 23:59:52', 'yes'),
(10, 'QT10010', '2024-03-02', 10, '27', 9, '1600.00', '', '0', '1600.00', 1, '2024-03-02 20:22:39', 'yes', 1, '2024-03-02 20:26:15', 'yes', '2024-03-02 22:46:15', 'yes', 5, '2024-03-02 23:50:10', 'yes'),
(11, 'QT10011', '2024-03-02', 11, '27', 8, '5260.00', '', '0', '5260.00', 1, '2024-03-02 20:23:21', 'yes', 1, '2024-03-02 23:46:45', 'yes', '2024-03-02 23:46:45', 'yes', 5, '2024-03-02 23:52:35', 'yes'),
(12, 'QT10012', '2024-03-02', 12, '28', 7, '3500.00', '', '0', '3500.00', 1, '2024-03-02 20:23:52', 'yes', 1, '2024-03-02 23:46:52', 'yes', '2024-03-02 23:47:47', 'yes', 4, '2024-03-02 23:50:17', 'yes'),
(13, 'QT10013', '2024-03-02', 13, '29', 9, '3150.00', '', '0', '3150.00', 1, '2024-03-02 20:24:20', 'yes', 1, '2024-03-02 23:46:56', 'yes', '2024-03-02 23:47:47', 'yes', 4, '2024-03-03 00:00:02', 'yes'),
(14, 'QT10014', '2024-03-02', 14, '30', 7, '3000.00', '', '0', '3000.00', 1, '2024-03-02 23:43:46', 'yes', 1, '2024-03-02 23:47:00', 'yes', '2024-03-02 23:47:47', 'yes', 5, '2024-03-03 00:00:12', 'yes'),
(15, 'QT10015', '2024-03-02', 15, '31', 8, '4525.00', '', '0', '4525.00', 1, '2024-03-02 23:43:59', 'yes', 1, '2024-03-02 23:47:28', 'yes', '2024-03-02 23:47:47', 'yes', 4, '2024-03-03 00:00:39', 'yes'),
(16, 'QT10016', '2024-03-02', 16, '32', 9, '4675.00', '', '0', '4675.00', 1, '2024-03-02 23:44:18', 'yes', 1, '2024-03-02 23:47:33', 'yes', '2024-03-02 23:47:47', 'yes', 6, '2024-03-03 00:00:43', 'yes'),
(17, 'QT10017', '2024-03-02', 17, '32', 7, '27300.00', '', '0', '27300.00', 1, '2024-03-02 23:44:47', 'yes', 1, '2024-03-16 12:40:15', 'yes', '2024-03-16 12:41:14', 'yes', 6, '2024-03-29 11:06:25', 'yes'),
(18, 'QT10018', '2024-03-02', 18, '33', 8, '1350.00', '', '0', '1350.00', 1, '2024-03-02 23:44:58', 'yes', 1, '2024-03-02 23:47:43', 'yes', '2024-03-02 23:47:47', 'yes', 5, '2024-03-03 00:00:49', 'yes'),
(19, 'QT10019', '2024-03-02', 19, '34', 9, '4300.00', '', '0', '4300.00', 1, '2024-03-02 23:45:13', 'yes', 1, '2024-03-02 23:47:47', 'yes', '2024-03-02 23:47:47', 'yes', 6, '2024-03-03 00:00:54', 'yes'),
(20, 'QT10020', '2024-03-10', 21, '37', 8, '12850.00', '', '0', '12850.00', 1, '2024-03-10 20:07:08', 'yes', 1, '2024-03-10 20:08:01', 'yes', '2024-03-11 19:18:20', 'yes', 5, '2024-03-29 22:07:24', 'yes'),
(21, 'QT10021', '2024-03-16', 20, '35', 2, '1220.00', '', '0', '1220.00', 1, '2024-03-16 12:39:43', 'yes', 1, '2024-03-17 22:03:03', 'yes', '2024-03-18 10:05:06', 'yes', 6, '2024-03-31 15:25:00', 'no'),
(22, 'QT10022', '2024-03-29', 22, '38', 2, '2800.00', '', '0', '2800.00', 1, '2024-03-29 10:48:45', 'yes', 1, '2024-03-29 10:49:13', 'yes', '2024-03-29 22:03:57', 'yes', 4, '2024-03-30 13:07:24', 'yes'),
(23, 'QT10023', '2024-03-29', 23, '24', 8, '13800.00', '', '0', '13800.00', 1, '2024-03-29 22:02:38', 'yes', 1, '2024-03-29 22:03:57', 'yes', '2024-03-30 12:53:05', 'yes', 5, '2024-03-30 13:07:29', 'yes'),
(24, 'QT10024', '2024-03-30', 24, '21', 9, '2700.00', '', '0', '2700.00', 1, '2024-03-30 12:48:27', 'yes', 1, '2024-03-30 12:50:01', 'yes', '2024-03-30 12:53:05', 'yes', 6, '2024-03-30 13:07:34', 'yes'),
(25, 'QT10025', '2024-03-30', 25, '34', 8, '9350.00', '10', '935.00', '8415.00', 1, '2024-03-30 12:50:43', 'yes', 1, '2024-03-30 12:52:08', 'yes', '2024-03-30 12:53:05', 'yes', 6, '2024-03-30 13:07:44', 'yes'),
(26, 'QT10026', '2024-03-30', 26, '9', 2, '6550.00', '', '0', '6550.00', 1, '2024-03-30 12:51:18', 'yes', 1, '2024-03-30 12:52:31', 'yes', '2024-03-30 12:53:05', 'yes', 4, '2024-03-30 13:07:52', 'no'),
(27, 'QT10027', '2024-03-30', 27, '39', 7, '2475.00', '', '0', '2475.00', 1, '2024-03-30 12:51:34', 'yes', 1, '2024-03-30 12:53:01', 'yes', '2024-03-30 12:53:05', 'yes', 5, '2024-03-30 22:23:55', 'yes'),
(28, 'QT10028', '2024-03-30', 28, '40', 2, '7750.00', '', '0', '7750.00', 1, '2024-03-30 22:08:11', 'yes', 10, '2024-03-30 22:15:25', 'yes', '2024-03-30 22:20:45', 'yes', 5, '2024-03-30 22:24:06', 'yes'),
(29, 'QT10029', '2024-03-30', 29, '40', 7, '16850.00', '15', '2527.50', '14322.50', 1, '2024-03-30 22:11:35', 'yes', 10, '2024-03-30 22:15:25', 'yes', '2024-03-30 22:20:45', 'yes', 5, '2024-03-30 22:24:11', 'yes'),
(30, 'QT10030', '2024-03-30', 30, '41', 8, '30400.00', '15', '4560.00', '25840.00', 1, '2024-03-30 22:13:55', 'yes', 10, '2024-03-30 22:15:25', 'yes', '2024-03-30 22:20:45', 'yes', 5, '2024-03-30 22:26:17', 'yes'),
(31, 'QT10031', '2024-03-30', 31, '19', 9, '11650.00', '', '0', '11650.00', 1, '2024-03-30 22:14:19', 'yes', 10, '2024-03-30 22:15:25', 'yes', '2024-03-30 22:20:45', 'yes', 5, '2024-03-30 22:26:25', 'yes'),
(32, 'QT10032', '2024-03-30', 32, '14', 8, '1190.00', '', '0', '1190.00', 1, '2024-03-30 22:15:10', 'yes', 10, '2024-03-30 22:15:25', 'yes', '2024-03-30 22:20:45', 'yes', 5, '2024-03-30 22:41:36', 'no'),
(33, 'QT10033', '2024-03-30', 33, '42', 7, '4400.00', '', '0', '4400.00', 1, '2024-03-30 22:15:25', 'yes', 10, '2024-03-30 22:25:17', 'yes', '2024-03-30 22:35:36', 'yes', 6, '2024-03-30 22:41:41', 'no'),
(34, 'QT10034', '2024-03-30', 34, '43', 2, '5960.00', '', '0', '5960.00', 1, '2024-03-30 22:15:43', 'yes', 10, '2024-03-30 22:25:17', 'yes', '2024-03-30 22:35:36', 'yes', 5, '2024-03-31 14:18:37', 'no'),
(35, 'QT10035', '2024-03-30', 35, '44', 2, '6200.00', '', '0', '6200.00', 1, '2024-03-30 22:16:08', 'yes', 10, '2024-03-30 22:25:17', 'no', '', 'no', 0, '', 'no'),
(36, 'QT10036', '2024-03-30', 36, '44', 2, '1900.00', '', '0', '1900.00', 1, '2024-03-30 22:43:33', 'no', 0, '', 'no', '', 'no', 0, '', 'no'),
(37, 'QT10037', '2024-03-30', 37, '45', 7, '9350.00', '', '0', '9350.00', 1, '2024-03-30 22:45:18', 'no', 0, '', 'no', '', 'no', 0, '', 'no'),
(38, 'QT10038', '2024-03-30', 38, '46', 9, '1800.00', '', '0', '1800.00', 1, '2024-03-30 22:45:38', 'no', 0, '', 'no', '', 'no', 0, '', 'no'),
(39, 'QT10039', '2024-03-30', 39, '47', 2, '2700.00', '0', '0', '2700.00', 2, '2024-03-30 22:54:54', 'yes', 10, '2024-03-31 14:58:54', 'no', '', 'no', 0, '', 'no'),
(40, 'QT10040', '2024-03-31', 45, '37', 2, '3950.00', '10', '395.00', '3555.00', 2, '2024-03-31 00:23:05', 'yes', 10, '2024-03-31 00:23:55', 'yes', '2024-03-31 00:29:07', 'yes', 5, '2024-03-31 00:31:07', 'yes'),
(41, 'QT10041', '2024-03-31', 46, '37', 2, '1350.00', '0', '0', '1350.00', 2, '2024-03-31 10:50:04', 'yes', 10, '2024-03-31 10:50:42', 'yes', '2024-03-31 10:52:15', 'yes', 5, '2024-03-31 10:53:37', 'yes'),
(42, 'QT10042', '2024-03-31', 47, '52', 2, '4300.00', '10', '430.00', '3870.00', 2, '2024-03-31 14:12:36', 'yes', 10, '2024-03-31 14:15:33', 'no', '', 'no', 0, '', 'no'),
(43, 'QT10043', '2024-03-31', 48, '37', 2, '5025.00', '10', '502.50', '4522.50', 2, '2024-03-31 14:40:45', 'yes', 10, '2024-03-31 14:59:11', 'no', '', 'no', 0, '', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `quotation_details`
--

CREATE TABLE IF NOT EXISTS `quotation_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `quot_id` int(11) NOT NULL COMMENT 'id of quotaton table',
  `prod_id` int(11) NOT NULL,
  `item_price` varchar(20) NOT NULL,
  `finishing` varchar(20) NOT NULL,
  `spec1` varchar(20) NOT NULL,
  `spec2` varchar(20) NOT NULL,
  `uprice` varchar(20) NOT NULL,
  `qty` varchar(20) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `artwork_status` varchar(5) NOT NULL,
  `artwork` varchar(20) NOT NULL,
  `service_status` varchar(5) NOT NULL,
  `service` varchar(20) NOT NULL,
  `req_item_id` int(11) NOT NULL COMMENT 'id of requests table',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=52 ;

--
-- Dumping data for table `quotation_details`
--

INSERT INTO `quotation_details` (`id`, `quot_id`, `prod_id`, `item_price`, `finishing`, `spec1`, `spec2`, `uprice`, `qty`, `amount`, `artwork_status`, `artwork`, `service_status`, `service`, `req_item_id`) VALUES
(1, 1, 4, '150.00', '', '', '', '150.00', '100', '15000.00', 'yes', '300', 'no', '0.00', 1),
(2, 1, 12, '280.00', '', '300.00', '310.00', '890.00', '5', '4450.00', 'yes', '300', 'no', '0.00', 2),
(3, 2, 1, '2100.00', '20.00', '45.00', '180.00', '2345.00', '1', '2345.00', 'no', '0.00', 'yes', '200', 3),
(4, 3, 11, '75.00', '', '', '', '75.00', '500', '37500.00', 'yes', '300', 'no', '0.00', 5),
(5, 4, 1, '2100.00', '20.00', '50.00', '0.00', '2170.00', '2', '4340.00', 'no', '0.00', 'no', '0.00', 8),
(6, 5, 5, '324.00', '75.00', '50.00', '175.00', '624.00', '150', '93600.00', 'yes', '450.00', 'no', '0.00', 4),
(7, 6, 9, '1500.00', '', '', '', '1500.00', '1', '1500.00', 'yes', '400.00', 'yes', '150.00', 6),
(8, 6, 14, '1750.00', '', '230.00', '', '1980.00', '2', '3960.00', 'no', '0.00', 'no', '0.00', 7),
(9, 7, 1, '6300.00', '20.00', '50.00', '0.00', '6370.00', '1', '6370.00', 'yes', '450.00', 'no', '0.00', 9),
(10, 8, 10, '1350.00', '', '', '', '1350.00', '3', '4050.00', 'yes', '400.00', 'yes', '150.00', 10),
(11, 9, 13, '60.00', '', '', '', '60.00', '500', '30000.00', 'yes', '300.00', 'no', '0.00', 11),
(12, 9, 4, '14.00', '', '', '', '14.00', '100', '1400.00', 'yes', '400.00', 'no', '0.00', 12),
(13, 10, 10, '1350.00', '', '', '', '1350.00', '1', '1350.00', 'no', '0.00', 'yes', '250.00', 13),
(14, 11, 5, '18.00', '0.00', '50.00', '175.00', '243.00', '20', '4860.00', 'yes', '400.00', 'no', '0.00', 14),
(15, 12, 3, '150.00', '', '', '', '150.00', '20', '3000.00', 'yes', '300.00', 'yes', '200.00', 15),
(16, 13, 1, '1125.00', '20.00', '50.00', '180.00', '1375.00', '2', '2750.00', 'yes', '400.00', 'no', '0.00', 16),
(17, 14, 9, '1500.00', '', '', '', '1500.00', '2', '3000.00', 'no', '0.00', 'no', '0.00', 17),
(18, 15, 11, '55.00', '', '', '', '55.00', '75', '4125.00', 'yes', '400.00', 'no', '0.00', 18),
(19, 16, 2, '165.00', '', '', '', '165.00', '25', '4125.00', 'yes', '350.00', 'yes', '200.00', 19),
(20, 17, 12, '400.00', '', '0.00', '500.00', '900.00', '30', '27000.00', 'yes', '300.00', 'no', '0.00', 20),
(21, 18, 10, '1350.00', '', '', '', '1350.00', '1', '1350.00', 'no', '0.00', 'no', '0.00', 21),
(22, 19, 3, '150.00', '', '', '', '150.00', '25', '3750.00', 'yes', '350.00', 'yes', '200.00', 22),
(23, 20, 12, '400.00', '', '350.00', '500.00', '1250.00', '10', '12500.00', 'yes', '350.00', 'no', '0.00', 26),
(24, 21, 1, '1125.00', '50.00', '45.00', '0.00', '1220.00', '1', '1220.00', 'no', '0.00', 'no', '0.00', 23),
(25, 22, 4, '14.00', '', '', '', '14.00', '200', '2800.00', 'no', '0.00', 'no', '0.00', 27),
(26, 23, 11, '55.00', '', '', '', '55.00', '50', '2750.00', 'yes', '450.00', 'no', '0.00', 37),
(27, 23, 10, '1350.00', '', '', '', '1350.00', '5', '6750.00', 'yes', '400.00', 'no', '0.00', 38),
(28, 23, 3, '150.00', '', '', '', '150.00', '20', '3000.00', 'yes', '450.00', 'no', '0.00', 39),
(29, 24, 11, '55.00', '', '', '', '55.00', '10', '550.00', 'yes', '400.00', 'no', '0.00', 57),
(30, 24, 10, '1350.00', '', '', '', '1350.00', '1', '1350.00', 'yes', '400.00', 'no', '0.00', 60),
(31, 25, 16, '30.00', '420.00', '', '', '450.00', '20', '9000.00', 'yes', '350.00', 'no', '0.00', 68),
(32, 26, 1, '2250.00', '20.00', '50.00', '180.00', '2500.00', '1', '2500.00', 'yes', '300.00', 'yes', '500.00', 69),
(33, 26, 13, '60.00', '', '', '', '60.00', '50', '3000.00', 'yes', '250.00', 'no', '0.00', 70),
(34, 27, 2, '165.00', '', '', '', '165.00', '15', '2475.00', 'no', '0.00', 'no', '0.00', 71),
(35, 28, 4, '14.00', '', '', '', '14.00', '500', '7000.00', 'yes', '400.00', 'yes', '350.00', 72),
(36, 29, 2, '165.00', '', '', '', '165.00', '100', '16500.00', 'yes', '350.00', 'no', '0.00', 73),
(37, 30, 13, '60.00', '', '', '', '60.00', '500', '30000.00', 'yes', '400.00', 'no', '0.00', 74),
(38, 31, 16, '30.00', '420.00', '', '', '450.00', '25', '11250.00', 'yes', '400.00', 'no', '0.00', 75),
(39, 32, 5, '1125.00', '0.00', '45.00', '20.00', '1190.00', '1', '1190.00', 'no', '0.00', 'no', '0.00', 76),
(40, 33, 10, '1350.00', '', '', '', '1350.00', '3', '4050.00', 'yes', '350.00', 'no', '0.00', 77),
(41, 34, 14, '1750.00', '', '120.00', '', '1870.00', '3', '5610.00', 'yes', '350.00', 'no', '0.00', 79),
(42, 35, 1, '2625.00', '20.00', '50.00', '180.00', '2875.00', '2', '5750.00', 'yes', '450.00', 'no', '0.00', 80),
(43, 36, 9, '1500.00', '', '', '', '1500.00', '1', '1500.00', 'yes', '400.00', 'no', '0.00', 81),
(44, 37, 13, '60.00', '', '', '', '60.00', '150', '9000.00', 'yes', '350.00', 'no', '0.00', 82),
(45, 38, 4, '14.00', '', '', '', '14.00', '100', '1400.00', 'yes', '400.00', 'no', '0.00', 83),
(46, 39, 10, '1350.00', '', '', '', '1350.00', '2', '2700.00', 'no', '0.00', 'no', '0.00', 84),
(47, 40, 3, '150.00', '', '', '', '150.00', '25', '3750.00', 'no', '0.00', 'yes', '200.00', 90),
(48, 41, 10, '1350.00', '', '', '', '1350.00', '1', '1350.00', 'no', '0.00', 'no', '0.00', 91),
(49, 42, 1, '1500.00', '20.00', '50.00', '0.00', '1570.00', '1', '1570.00', 'yes', '300.00', 'no', '0.00', 92),
(50, 42, 2, '165.00', '', '', '', '165.00', '12', '1980.00', 'yes', '350.00', 'yes', '100', 93),
(51, 43, 2, '165.00', '', '', '', '165.00', '25', '4125.00', 'yes', '400.00', 'yes', '500.00', 94);

-- --------------------------------------------------------

--
-- Table structure for table `quotation_requests`
--

CREATE TABLE IF NOT EXISTS `quotation_requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `req_no` varchar(15) NOT NULL,
  `r_datetime` varchar(25) NOT NULL,
  `cus_id` varchar(5) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'open',
  `mode` varchar(10) NOT NULL DEFAULT 'web',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Dumping data for table `quotation_requests`
--

INSERT INTO `quotation_requests` (`id`, `req_no`, `r_datetime`, `cus_id`, `status`, `mode`) VALUES
(1, 'R/2402/00001', '2023-10-15 21:39:52', '14', 'quotation', 'web'),
(2, 'R/2402/00002', '2023-10-18 21:42:45', '19', 'quotation', 'web'),
(3, 'R/2402/00003', '2023-10-21 21:53:58', '21', 'quotation', 'web'),
(4, 'R/2402/00004', '2023-10-27 21:55:36', '21', 'quotation', 'web'),
(5, 'R/2402/00005', '2023-11-07 22:01:00', '24', 'quotation', 'web'),
(6, 'R/2402/00001', '2024-02-29 21:26:19', '1', 'quotation', 'web'),
(7, 'R/2403/00002', '2024-03-01 08:46:58', '1', 'quotation', 'web'),
(8, 'R/2403/00003', '2024-03-02 14:58:48', '25', 'quotation', 'web'),
(9, 'R/2403/00004', '2024-03-02 15:25:03', '26', 'quotation', 'web'),
(10, 'R/2403/00005', '2024-03-02 15:29:34', '27', 'quotation', 'web'),
(11, 'R/2403/00006', '2024-03-02 15:31:08', '27', 'quotation', 'web'),
(12, 'R/2403/00007', '2024-03-02 15:37:26', '28', 'quotation', 'web'),
(13, 'R/2403/00008', '2024-03-02 15:41:10', '29', 'quotation', 'web'),
(14, 'R/2403/00009', '2024-03-02 19:46:49', '30', 'quotation', 'web'),
(15, 'R/2403/00010', '2024-03-02 19:49:48', '31', 'quotation', 'web'),
(16, 'R/2403/00011', '2024-03-02 19:55:17', '32', 'quotation', 'web'),
(17, 'R/2403/00012', '2024-03-02 19:56:50', '32', 'quotation', 'web'),
(18, 'R/2403/00013', '2024-03-02 20:02:09', '33', 'quotation', 'web'),
(19, 'R/2403/00014', '2024-03-02 20:05:42', '34', 'quotation', 'web'),
(20, 'R/2403/00015', '2024-03-02 20:08:37', '35', 'quotation', 'web'),
(21, 'R/2403/00016', '2024-03-10 20:05:31', '37', 'quotation', 'web'),
(22, 'R/2403/00017', '2024-03-16 12:39:03', '38', 'quotation', 'web'),
(23, 'R/2403/00018', '2024-03-16 23:17:03', '24', 'quotation', 'walkin'),
(24, 'R/2403/00019', '2024-03-17 23:26:22', '21', 'quotation', 'walkin'),
(25, 'R/2403/00020', '2024-03-18 00:24:18', '34', 'quotation', 'walkin'),
(26, 'R/2403/00021', '2024-03-20 21:36:56', '9', 'quotation', 'walkin'),
(27, 'R/2403/00022', '2024-03-29 10:47:26', '39', 'quotation', 'walkin'),
(28, 'R/2403/00023', '2024-03-30 14:32:41', '40', 'quotation', 'web'),
(29, 'R/2403/00024', '2024-03-30 14:33:39', '40', 'quotation', 'web'),
(30, 'R/2403/00025', '2024-03-30 14:35:45', '41', 'quotation', 'web'),
(31, 'R/2403/00026', '2024-03-30 14:36:45', '19', 'quotation', 'web'),
(32, 'R/2403/00027', '2024-03-30 14:38:03', '14', 'quotation', 'web'),
(33, 'R/2403/00028', '2024-03-30 14:40:12', '42', 'quotation', 'web'),
(34, 'R/2403/00029', '2024-03-30 14:44:29', '43', 'quotation', 'web'),
(35, 'R/2403/00030', '2024-03-30 14:48:14', '44', 'quotation', 'web'),
(36, 'R/2403/00031', '2024-03-30 14:48:41', '44', 'quotation', 'web'),
(37, 'R/2403/00032', '2024-03-30 14:51:05', '45', 'quotation', 'web'),
(38, 'R/2403/00033', '2024-03-30 14:55:04', '46', 'quotation', 'web'),
(39, 'R/2403/00034', '2024-03-30 14:58:35', '47', 'quotation', 'web'),
(40, 'R/2403/00035', '2024-03-30 15:00:06', '47', 'open', 'web'),
(41, 'R/2403/00036', '2024-03-30 15:32:38', '48', 'open', 'web'),
(42, 'R/2403/00037', '2024-03-30 22:59:37', '49', 'open', 'web'),
(43, 'R/2403/00038', '2024-03-30 23:01:25', '50', 'open', 'web'),
(44, 'R/2403/00039', '2024-03-30 23:03:25', '51', 'open', 'web'),
(45, 'R/2403/00040', '2024-03-31 00:21:21', '37', 'quotation', 'web'),
(46, 'R/2403/00041', '2024-03-31 10:48:33', '37', 'quotation', 'web'),
(47, 'R/2403/00042', '2024-03-31 14:08:42', '52', 'quotation', 'web'),
(48, 'R/2403/00043', '2024-03-31 14:38:10', '37', 'quotation', 'web');

-- --------------------------------------------------------

--
-- Table structure for table `rawmaterial`
--

CREATE TABLE IF NOT EXISTS `rawmaterial` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) NOT NULL,
  `name` varchar(75) NOT NULL,
  `uom` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `ro_level` varchar(20) NOT NULL,
  `ro_qty` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `rawmaterial`
--

INSERT INTO `rawmaterial` (`id`, `code`, `name`, `uom`, `category`, `ro_level`, `ro_qty`) VALUES
(1, 'P0001', '100 GSM Art Paper', 5, 1, '100', '5000'),
(2, 'P0002', '120 GSM Art Paper', 5, 1, '50', '5000'),
(3, 'B0001', '100 GSM Art Board', 5, 2, '25', '2000'),
(4, 'B0002', '120 GSM Art Board', 5, 2, '25', '1500'),
(5, 'B0003', '260 GSM Art Board', 5, 2, '100', '1000'),
(6, 'B0004', '300 GSM Art Board', 5, 2, '75', '500'),
(7, 'P0003', '260 GSM Art Paper', 5, 1, '100', '750'),
(8, 'P0004', '270 GSM Art Paper', 5, 1, '50', '500'),
(9, 'M0001', 'White Mug', 8, 11, '12', '48'),
(10, 'M0002', 'Magic Mug', 8, 11, '12', '36'),
(11, 'I0001', 'Cyan Ink', 4, 3, '10', '30'),
(12, 'I0002', 'Magenta Ink', 4, 3, '10', '30'),
(13, 'I0003', 'Yellow Ink', 4, 3, '10', '30'),
(14, 'I0004', 'Black Ink', 4, 3, '10', '30'),
(15, 'F0001', 'Flex 3ft - One side black', 6, 6, '2', '12'),
(16, 'F0002', 'Flex 4ft - One side black', 6, 6, '2', '12'),
(17, 'F0003', 'Flex 3ft - One side Matt', 6, 6, '2', '12'),
(18, 'B0005', 'Ivory Board', 5, 2, '50', '30'),
(19, 'B0006', '300 GSM Grey Back Box Board', 5, 2, '25', '100'),
(20, 'B0007', '350 GSM Grey Back Box Board', 5, 2, '25', '100'),
(21, 'B0008', '300 GSM White Back Box Board', 5, 2, '25', '100'),
(22, 'B0009', '350 GSM White Back Box Board', 5, 2, '25', '100'),
(23, 'B0010', '250 GSM Ice Gold Board', 5, 2, '25', '100'),
(24, 'B0011', '250 GSM Ice Silver Board', 5, 2, '25', '100'),
(25, 'P0005', '60 GSM Bank Paper', 5, 1, '75', '350'),
(26, 'P0006', '80 GSM Bank Paper', 5, 1, '75', '350'),
(27, 'P0007', '52 GSM Demy Paper', 5, 1, '50', '500'),
(28, 'P0008', '54 GSM Demy Paper', 5, 1, '50', '500'),
(29, 'P0009', '70  GSM Kraft Paper', 5, 1, '50', '500'),
(30, 'P0010', '80 GSM Kraft Paper', 5, 1, '50', '500'),
(31, 'P0011', 'White Back Sticker Paper', 5, 1, '75', '200'),
(32, 'P0012', 'Yellow Back Sticker Paper', 5, 1, '75', '200'),
(33, 'P0013', 'PVC Sticker Paper', 5, 1, '75', '250'),
(34, 'A0001', 'Double Side Tape - 12mm', 8, 5, '25', '75'),
(35, 'A0002', 'Clear Tape', 8, 5, '20', '50'),
(36, 'A0003', 'Binding Glue', 8, 5, '10', '20'),
(37, 'A0004', 'One Side Lamination Glue', 8, 5, '10', '20'),
(38, 'A0005', 'Double Side Lamination Glue', 8, 5, '5', '5'),
(39, 'C0001', 'OGS Cleaning Fluid', 7, 8, '1', '1');

-- --------------------------------------------------------

--
-- Table structure for table `rawmaterial_category`
--

CREATE TABLE IF NOT EXISTS `rawmaterial_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

--
-- Dumping data for table `rawmaterial_category`
--

INSERT INTO `rawmaterial_category` (`id`, `name`) VALUES
(1, 'Paper'),
(2, 'Board'),
(3, 'Ink'),
(4, 'Toner'),
(5, 'Adhesive'),
(6, 'Flex'),
(7, 'Cutter'),
(8, 'Cleaning'),
(11, 'Mugs');

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE IF NOT EXISTS `receipt` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rec_no` varchar(10) NOT NULL,
  `rec_date` varchar(15) NOT NULL,
  `customer` int(11) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `pay_type` varchar(15) NOT NULL,
  `user` int(11) NOT NULL,
  `datetime` varchar(25) NOT NULL,
  `cheq_no` varchar(30) NOT NULL,
  `cheq_date` varchar(25) NOT NULL,
  `deposit_ref` varchar(75) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `receipt`
--

INSERT INTO `receipt` (`id`, `rec_no`, `rec_date`, `customer`, `amount`, `pay_type`, `user`, `datetime`, `cheq_no`, `cheq_date`, `deposit_ref`) VALUES
(1, 'RN10001', '2024-02-29', 15, '1500.00', 'Cash', 1, '2024-02-29 00:11:05', '', '', ''),
(2, 'RN10002', '2024-02-29', 16, '750.00', 'Cash', 1, '2024-02-29 00:11:21', '', '', ''),
(3, 'RN10003', '2024-03-12', 1, '3000.00', 'Cheque', 1, '2024-03-29 11:31:17', '125486', '2024-03-28', ''),
(4, 'RN10004', '2024-03-12', 21, '15000.00', 'Bank Deposit', 1, '2024-03-30 11:37:00', '', '', 'DD45128'),
(5, 'RN10005', '2024-03-12', 1, '1340.00', 'Settlement', 1, '2024-03-30 11:41:53', '', '', ''),
(6, 'RN10006', '2024-03-13', 28, '3500.00', 'Card', 1, '2024-03-30 11:43:23', '', '', ''),
(7, 'RN10007', '2024-03-14', 34, '4435.00', 'Bank Deposit', 1, '2024-03-30 11:45:52', '', '', 'NDB00056'),
(8, 'RN10008', '2024-03-14', 23, '225.00', 'Cash', 1, '2024-03-30 11:46:32', '', '', ''),
(9, 'RN10009', '2024-03-14', 25, '4850.00', 'Cash', 1, '2024-03-30 11:48:58', '', '', ''),
(10, 'RN10010', '2024-03-15', 30, '3000.00', 'Bank Deposit', 1, '2024-03-30 11:49:25', '', '', 'FGT45682'),
(11, 'RN10011', '2024-03-15', 32, '4675.00', 'Card', 1, '2024-03-30 11:49:43', '', '', ''),
(12, 'RN10012', '2024-03-15', 33, '1350.00', 'Cash', 1, '2024-03-30 11:49:54', '', '', ''),
(13, 'RN10013', '2024-03-31', 15, '5400.00', 'Cash', 1, '2024-03-30 23:30:05', '', '', ''),
(14, 'RN10014', '2024-03-31', 37, '3000.00', 'Bank Deposit', 1, '2024-03-30 23:30:51', '', '', 'TTF4587'),
(15, 'RN10015', '2024-03-31', 37, '3555.00', 'Settlement', 3, '2024-03-31 00:40:00', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `receipt_details`
--

CREATE TABLE IF NOT EXISTS `receipt_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rec_no` varchar(15) NOT NULL,
  `inv_no` varchar(15) NOT NULL,
  `amount` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Dumping data for table `receipt_details`
--

INSERT INTO `receipt_details` (`id`, `rec_no`, `inv_no`, `amount`) VALUES
(1, 'RN10001', 'INV10002', '1500.00'),
(2, 'RN10002', 'INV10003', '750.00'),
(3, 'RN10003', 'INV10008', '3000.00'),
(4, 'RN10004', 'INV10007', '15000.00'),
(5, 'RN10005', 'INV10008', '1340.00'),
(6, 'RN10006', 'INV10017', '3500.00'),
(7, 'RN10007', 'INV10023', '4300.00'),
(8, 'RN10007', 'INV10027', '135.00'),
(9, 'RN10008', 'INV10004', '225.00'),
(10, 'RN10009', 'INV10009', '4600.00'),
(11, 'RN10009', 'INV10028', '250.00'),
(12, 'RN10010', 'INV10020', '3000.00'),
(13, 'RN10011', 'INV10022', '4675.00'),
(14, 'RN10012', 'INV10029', '1350.00'),
(15, 'RN10013', 'INV10025', '5400.00'),
(16, 'RN10014', 'INV10030', '3000.00'),
(17, 'RN10015', 'INV10036', '3555.00');

-- --------------------------------------------------------

--
-- Table structure for table `requests`
--

CREATE TABLE IF NOT EXISTS `requests` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cust_id` int(11) NOT NULL,
  `prod_id` int(11) NOT NULL,
  `material` varchar(5) DEFAULT NULL,
  `size` varchar(5) DEFAULT NULL,
  `width` varchar(10) NOT NULL,
  `height` varchar(10) NOT NULL,
  `finishing` varchar(5) DEFAULT NULL,
  `color` varchar(5) DEFAULT NULL,
  `spec1` varchar(5) DEFAULT NULL,
  `spec2` varchar(5) DEFAULT NULL,
  `image1` varchar(100) NOT NULL,
  `image2` varchar(100) NOT NULL,
  `qty` int(11) NOT NULL,
  `artwork` varchar(5) NOT NULL,
  `service` varchar(10) NOT NULL,
  `datetime` varchar(25) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'open',
  `req_id` varchar(5) DEFAULT NULL,
  `spe_note` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=95 ;

--
-- Dumping data for table `requests`
--

INSERT INTO `requests` (`id`, `cust_id`, `prod_id`, `material`, `size`, `width`, `height`, `finishing`, `color`, `spec1`, `spec2`, `image1`, `image2`, `qty`, `artwork`, `service`, `datetime`, `status`, `req_id`, `spe_note`) VALUES
(1, 14, 4, '16', '', '', '', '', '9', '', '', '', '', 100, 'need', 'standard', '2023-10-15 21:37:50', 'quote', '1', ''),
(2, 14, 12, '37', '', '', '', '', '', '6', '8', '', '', 5, 'need', 'standard', '2023-10-15 21:38:27', 'quote', '1', ''),
(3, 19, 1, '1', '', '4', '7', '1', '', '2', '3', '', '', 1, 'not', 'oneday', '2023-10-18 21:42:37', 'quote', '2', ''),
(4, 21, 5, '22', '', '12', '18', '7', '', '3', '4', '', '', 150, 'need', 'standard', '2023-10-21 21:52:06', 'quote', '3', ''),
(5, 21, 11, '33', '5', '', '', '', '', '', '', '', '', 500, 'need', 'standard', '2023-10-27 21:55:32', 'quote', '4', ''),
(6, 24, 9, '28', '', '', '', '', '14', '', '', '', '', 1, 'need', 'oneday', '2023-11-07 22:00:08', 'quote', '5', ''),
(7, 24, 14, '42', '11', '', '', '', '18', '10', '', '', '', 2, 'not', 'standard', '2023-11-07 22:00:57', 'quote', '5', ''),
(8, 1, 1, '2', '', '4', '7', '3', '', '1', '1', '', '', 2, 'not', 'standard', '2024-02-29 21:26:14', 'quote', '6', ''),
(9, 1, 1, '1', '', '12', '7', '1', '', '1', '1', '', '', 1, 'need', 'standard', '2024-03-01 08:46:44', 'quote', '7', ''),
(10, 25, 10, '29', '', '', '', '', '', '', '', '', '', 3, 'need', 'oneday', '2024-03-02 14:57:28', 'quote', '8', ''),
(11, 26, 13, '40', '7', '', '', '', '17', '', '', '', '', 500, 'need', 'standard', '2024-03-02 15:23:35', 'quote', '9', ''),
(12, 26, 4, '14', '', '', '', '', '9', '', '', '', '', 100, 'need', 'standard', '2024-03-02 15:24:33', 'quote', '9', ''),
(13, 27, 10, '30', '', '', '', '', '', '', '', '', '', 1, 'not', 'oneday', '2024-03-02 15:28:52', 'quote', '10', ''),
(14, 27, 5, '23', '', '4', '3', '8', '', '3', '4', '', '', 20, 'need', 'standard', '2024-03-02 15:31:05', 'quote', '11', ''),
(15, 28, 3, '11', '2', '', '', '', '5', '', '', '', '', 20, 'need', 'oneday', '2024-03-02 15:36:46', 'quote', '12', ''),
(16, 29, 1, '1', '', '3', '5', '1', '', '1', '3', '', '', 2, 'need', 'standard', '2024-03-02 15:40:31', 'quote', '13', ''),
(17, 30, 9, '28', '', '', '', '', '10', '', '', '', '', 2, 'not', 'standard', '2024-03-02 19:45:16', 'quote', '14', ''),
(18, 31, 11, '34', '6', '', '', '', '', '', '', '', '', 75, 'need', 'standard', '2024-03-02 19:49:01', 'quote', '15', ''),
(19, 32, 2, '4', '', '', '', '', '2', '', '', '', '', 25, 'need', 'oneday', '2024-03-02 19:54:29', 'quote', '16', ''),
(20, 32, 12, '38', '', '', '', '', '', '5', '8', '', '', 30, 'need', 'standard', '2024-03-02 19:56:47', 'quote', '17', ''),
(21, 33, 10, '31', '', '', '', '', '', '', '', '', '', 1, 'not', 'standard', '2024-03-02 20:01:44', 'quote', '18', ''),
(22, 34, 3, '11', '1', '', '', '', '6', '', '', '', '', 25, 'need', 'oneday', '2024-03-02 20:05:08', 'quote', '19', ''),
(23, 35, 1, '2', '', '5', '3', '4', '', '2', '1', '', '', 1, 'not', 'standard', '2024-03-02 20:08:12', 'quote', '20', ''),
(26, 37, 12, '38', '', '', '', '', '', '6', '8', '', '', 10, 'need', 'standard', '2024-03-10 20:03:21', 'quote', '21', ''),
(27, 38, 4, '15', '', '', '', '', '9', '', '', '', '', 200, 'not', 'standard', '2024-03-16 12:38:38', 'quote', '22', ''),
(37, 24, 11, '34', '5', '', '', '', '', '', '', '', '', 50, 'need', 'standard', '2024-03-16 22:15:10', 'quote', '23', ''),
(38, 24, 10, '29', '', '', '', '', '', '', '', '', '', 5, 'need', 'standard', '2024-03-16 22:15:23', 'quote', '23', ''),
(39, 24, 3, '9', '2', '', '', '', '6', '', '', '', '', 20, 'need', 'standard', '2024-03-16 22:15:51', 'quote', '23', ''),
(57, 21, 11, '32', '4', '', '', '', '', '', '', '', '', 10, 'need', 'standard', '2024-03-17 20:05:36', 'quote', '24', ''),
(60, 21, 10, '29', '', '', '', '', '', '', '', '', '', 1, 'need', 'standard', '2024-03-17 22:06:24', 'quote', '24', ''),
(68, 34, 16, '50', '15', '', '', '13', '23', '', '', '', '', 20, 'need', 'standard', '2024-03-18 00:23:38', 'quote', '25', ''),
(69, 9, 1, '1', '', '6', '5', '3', '', '1', '3', '', '', 1, 'need', 'oneday', '2024-03-20 21:29:14', 'quote', '26', ''),
(70, 9, 13, '39', '7', '', '', '', '15', '', '', '', '', 50, 'need', 'standard', '2024-03-20 21:36:49', 'quote', '26', ''),
(71, 39, 2, '8', '', '', '', '', '2', '', '', '', '', 15, 'not', 'standard', '2024-03-29 10:47:17', 'quote', '27', ''),
(72, 40, 4, '16', '', '', '', '', '8', '', '', '', '', 500, 'need', 'oneday', '2024-03-30 14:32:03', 'quote', '28', ''),
(73, 40, 2, '4', '', '', '', '', '3', '', '', '', '', 100, 'need', 'standard', '2024-03-30 14:33:36', 'quote', '29', ''),
(74, 41, 13, '40', '7', '', '', '', '16', '', '', '', '', 500, 'need', 'standard', '2024-03-30 14:35:14', 'quote', '30', ''),
(75, 19, 16, '50', '15', '', '', '13', '23', '', '', '', '', 25, 'need', 'standard', '2024-03-30 14:36:41', 'quote', '31', ''),
(76, 14, 5, '21', '', '25', '30', '8', '', '4', '4', '', '', 1, 'not', 'standard', '2024-03-30 14:38:00', 'quote', '32', ''),
(77, 42, 10, '30', '', '', '', '', '', '', '', '', '', 3, 'need', 'standard', '2024-03-30 14:39:50', 'quote', '33', ''),
(78, 21, 9, '28', '', '', '', '', '14', '', '', '', '', 1, 'not', 'standard', '2024-03-30 14:42:15', 'open', NULL, ''),
(79, 43, 14, '41', '12', '', '', '', '19', '10', '', '', '', 3, 'need', 'standard', '2024-03-30 14:44:16', 'quote', '34', ''),
(80, 44, 1, '2', '', '5', '7', '1', '', '1', '3', '', '', 2, 'need', 'standard', '2024-03-30 14:47:42', 'quote', '35', ''),
(81, 44, 9, '26', '', '', '', '', '10', '', '', '', '', 1, 'need', 'standard', '2024-03-30 14:48:38', 'quote', '36', ''),
(82, 45, 13, '40', '7', '', '', '', '17', '', '', '', '', 150, 'need', 'standard', '2024-03-30 14:50:20', 'quote', '37', ''),
(83, 46, 4, '17', '', '', '', '', '8', '', '', '', '', 100, 'need', 'standard', '2024-03-30 14:54:38', 'quote', '38', ''),
(84, 47, 10, '30', '', '', '', '', '', '', '', '', '', 2, 'not', 'standard', '2024-03-30 14:58:11', 'quote', '39', ''),
(85, 47, 14, '42', '11', '', '', '', '19', '7', '', '', '', 1, 'need', 'standard', '2024-03-30 15:00:03', 'quote', '40', ''),
(86, 48, 11, '32', '5', '', '', '', '', '', '', '', '', 75, 'need', 'standard', '2024-03-30 15:32:05', 'quote', '41', ''),
(87, 49, 1, '1', '', '3', '5', '3', '', '1', '2', '', '', 2, 'not', 'standard', '2024-03-30 22:59:18', 'quote', '42', ''),
(88, 50, 9, '27', '', '', '', '', '14', '', '', '', '', 1, 'not', 'standard', '2024-03-30 23:00:55', 'quote', '43', ''),
(89, 51, 10, '29', '', '', '', '', '', '', '', '', '', 1, 'not', 'oneday', '2024-03-30 23:02:54', 'quote', '44', ''),
(90, 37, 3, '12', '2', '', '', '', '6', '', '', '90upd1.jpg', '', 25, 'not', 'oneday', '2024-03-31 00:21:12', 'quote', '45', ''),
(91, 37, 10, '30', '', '', '', '', '', '', '', '', '', 1, 'not', 'standard', '2024-03-31 10:48:13', 'quote', '46', ''),
(92, 52, 1, '1', '', '4', '5', '1', '', '1', '1', '', '', 1, 'need', 'standard', '2024-03-31 14:07:21', 'quote', '47', ''),
(93, 52, 2, '4', '', '', '', '', '3', '', '', '93upd1.jpg', '', 12, 'need', 'oneday', '2024-03-31 14:08:28', 'quote', '47', ''),
(94, 37, 2, '6', '', '', '', '', '3', '', '', '94upd1.jpg', '', 25, 'not', 'oneday', '2024-03-31 14:37:28', 'quote', '48', '');

-- --------------------------------------------------------

--
-- Table structure for table `return_details`
--

CREATE TABLE IF NOT EXISTS `return_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `return_no` varchar(15) NOT NULL,
  `item_id` int(11) NOT NULL,
  `qty` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `return_details`
--

INSERT INTO `return_details` (`id`, `return_no`, `item_id`, `qty`) VALUES
(1, 'MR10001', 11, '0.02'),
(2, 'MR10002', 5, '10'),
(3, 'MR10003', 7, '2'),
(4, 'MR10004', 7, '5');

-- --------------------------------------------------------

--
-- Table structure for table `return_summary`
--

CREATE TABLE IF NOT EXISTS `return_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `return_no` varchar(15) NOT NULL,
  `return_date` varchar(25) NOT NULL,
  `issue_no` varchar(15) NOT NULL,
  `user` int(11) NOT NULL,
  `datetime` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `return_summary`
--

INSERT INTO `return_summary` (`id`, `return_no`, `return_date`, `issue_no`, `user`, `datetime`) VALUES
(1, 'MR10001', '2024-03-14', 'MI10012', 1, '2024-03-29 10:38:01'),
(2, 'MR10002', '2024-03-18', 'MI10003', 1, '2024-03-30 23:07:11'),
(3, 'MR10003', '2024-03-30', 'MI10009', 1, '2024-03-30 23:07:33'),
(4, 'MR10004', '2024-03-31', 'MI10013', 11, '2024-03-31 00:35:47');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sname` varchar(75) NOT NULL,
  `contactp` varchar(75) NOT NULL,
  `contact` varchar(50) NOT NULL,
  `address` varchar(250) NOT NULL,
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `sname`, `contactp`, `contact`, `address`, `email`) VALUES
(1, 'Printmart Papers', 'Mr. Jason', '0718344776', 'Weliamuna Road, Wattala.', 'printmart@gmail.com'),
(2, 'Papercom Pvt Ltd', 'Mr. Sunil', '0777755894', 'St. James Road, Colombo 15.', 'info@papercom.lk'),
(3, 'Johnson Trading', 'Mr. Randika Jayakodi', '0776355894', '155, Chatham Street, Colombo 01', ''),
(4, 'Jeewa Products', '', '0776355892', 'Colombo 13', ''),
(5, 'Colorcroma (Pvt) Ltd', '', '0112546878', 'Piliyandala', 'sales@colorchroma.lk'),
(6, 'D. S. Plastics', 'Mr. Aruna', '0112456568', 'No. 50/1, Main Street, Colombo 11.', ''),
(7, 'New Universe Trading', 'Mr. Vajira', '0761548262', 'No. 45, Sea Street, Colombo 11.', 'info@newuniverse.com'),
(8, 'Amrajh Enterprises', '', '0114747484', '177, New Moon Street, Colombo', 'sales.amrajh@google.com'),
(9, 'New Hara Enterprises', '', '0112752847', 'Colombo', '');

-- --------------------------------------------------------

--
-- Table structure for table `temp_stock_move`
--

CREATE TABLE IF NOT EXISTS `temp_stock_move` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refdate` varchar(12) NOT NULL,
  `refnum` varchar(15) NOT NULL,
  `type` varchar(20) NOT NULL,
  `inqty` varchar(15) NOT NULL,
  `outqty` varchar(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `title`
--

CREATE TABLE IF NOT EXISTS `title` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `title`
--

INSERT INTO `title` (`id`, `title`) VALUES
(1, 'Mr'),
(2, 'Ms'),
(3, 'Mrs'),
(4, 'Dr'),
(5, 'Rev'),
(6, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `unit_of_measure`
--

CREATE TABLE IF NOT EXISTS `unit_of_measure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `unit_of_measure`
--

INSERT INTO `unit_of_measure` (`id`, `name`) VALUES
(1, 'Gram'),
(2, 'Kilogram'),
(3, 'Milliliter'),
(4, 'Liter'),
(5, 'Sheet'),
(6, 'Roll'),
(7, 'Bottle'),
(8, 'Units');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(5) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `designation` varchar(25) NOT NULL,
  `profile_pic` varchar(50) NOT NULL,
  `user_type` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `active` varchar(5) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`id`),
  KEY `user_type` (`user_type`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `title`, `first_name`, `last_name`, `contact`, `designation`, `profile_pic`, `user_type`, `username`, `password`, `active`) VALUES
(1, '2', 'Luckshini', 'Fernando', '0771234567', 'IT Executive', '1_profile.jpg', 1, 'admin@gmail.com', '594cf5f7b9b12f35f982f52e8add1d41', 'yes'),
(2, '2', 'Pavithra', 'Perera', '0772246387', 'Sales Executive', '', 6, 'pavithra@gmail.com', 'dc836b2a87531b0f9eadd6c8c9a21a7a', 'yes'),
(3, '1', 'Mahesh', 'Silva', '0775312849', 'Accounts Executive', '', 2, 'mahesh@gmail.com', '827ccb0eea8a706c4c34a16891f84e7b', 'yes'),
(4, '1', 'Hashan', 'Silva', '0771122337', 'Coordinator', '', 3, 'hashans@tecgraphic.lk', '827ccb0eea8a706c4c34a16891f84e7b', 'yes'),
(5, '2', 'Swetha', 'Nahendran', '0711122344', 'Coordinator', '', 3, 'swethan@tecgraphic.lk', '66d916b6a4a876fffc6f8f7e824d86b3', 'yes'),
(6, '1', 'Mohamed', 'Zulfi', '0751597532', 'Coordinator', '', 3, 'mzulfi@tecgraphic.lk', '827ccb0eea8a706c4c34a16891f84e7b', 'yes'),
(7, '1', 'Dinesh', 'Ranasinghe', '0772246384', 'Sales Executive', '', 6, 'dinesh.ran@gmail.com', 'f07f6c983d715f4155ab0e9ce5cc4805', 'yes'),
(8, '1', 'Chanuka', 'Jayaweera', '0772246385', 'Sales Executive', '', 6, 'chanuka_92@gmail.com', 'f07f6c983d715f4155ab0e9ce5cc4805', 'yes'),
(9, '2', 'Aaliya', 'Sultan', '0772246383', 'Sales Executive', '9_profile.jpg', 6, 'aaliya931@gmail.com', 'f07f6c983d715f4155ab0e9ce5cc4805', 'yes'),
(10, '1', 'Sam', 'Daniel', '0751597577', 'Manager', 'avatar.jpg', 5, 'samd@tecgraphic.lk', '5c4ac32d85eabd4d2dab811b55129d61', 'yes'),
(11, '1', 'Vinoth', 'Shanmugavel', '0715532432', 'Store Executive', '', 4, 'vinoth@gmail.com', '06c805d5b0040b476e178310716bcd22', 'yes'),
(13, '1', 'Dasun', 'Mendis', '0752648412', 'Sales Executive', '', 6, 'dasunm45@gmail.com', 'f5e25a098504e98d45d9a68ac9d2ec1c', 'no');

-- --------------------------------------------------------

--
-- Table structure for table `user_privilege`
--

CREATE TABLE IF NOT EXISTS `user_privilege` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_type` int(11) NOT NULL,
  `page` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=83 ;

--
-- Dumping data for table `user_privilege`
--

INSERT INTO `user_privilege` (`id`, `user_type`, `page`) VALUES
(1, 6, 1),
(2, 6, 2),
(3, 1, 1),
(4, 1, 2),
(5, 1, 3),
(6, 1, 4),
(7, 1, 5),
(8, 1, 6),
(9, 1, 7),
(10, 1, 8),
(11, 1, 9),
(12, 1, 10),
(13, 1, 11),
(14, 1, 12),
(15, 1, 13),
(16, 1, 14),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(21, 1, 21),
(22, 1, 22),
(23, 1, 23),
(24, 1, 24),
(25, 1, 25),
(26, 1, 26),
(27, 1, 27),
(28, 1, 28),
(29, 1, 29),
(30, 1, 30),
(31, 1, 31),
(32, 1, 32),
(33, 1, 33),
(34, 1, 34),
(35, 2, 24),
(36, 2, 21),
(38, 2, 26),
(39, 2, 27),
(40, 2, 28),
(41, 2, 29),
(42, 2, 30),
(43, 2, 22),
(44, 2, 4),
(45, 2, 31),
(46, 3, 3),
(47, 3, 18),
(48, 4, 5),
(49, 4, 6),
(50, 4, 7),
(51, 4, 23),
(52, 4, 25),
(53, 4, 10),
(54, 4, 11),
(55, 5, 17),
(56, 5, 31),
(57, 5, 19),
(58, 5, 20),
(59, 5, 8),
(60, 5, 25),
(61, 5, 26),
(62, 5, 27),
(63, 5, 28),
(64, 5, 29),
(65, 5, 30),
(66, 5, 32),
(67, 5, 33),
(68, 5, 12),
(69, 5, 13),
(70, 5, 14),
(71, 5, 9),
(72, 5, 34),
(73, 1, 36),
(74, 1, 35),
(75, 1, 38),
(76, 5, 38),
(77, 1, 37),
(78, 1, 39),
(79, 1, 40),
(80, 6, 40),
(81, 3, 36),
(82, 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE IF NOT EXISTS `user_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`id`, `name`) VALUES
(1, 'Admin'),
(2, 'Accountant'),
(3, 'Coordinator'),
(4, 'Inventory Officer'),
(5, 'Manager'),
(6, 'Sales Executive');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `contact_person`
--
ALTER TABLE `contact_person`
  ADD CONSTRAINT `cus_contact` FOREIGN KEY (`customer`) REFERENCES `customer` (`id`),
  ADD CONSTRAINT `cus_title` FOREIGN KEY (`ctitle`) REFERENCES `title` (`id`);

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `title` FOREIGN KEY (`title`) REFERENCES `title` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `usertype` FOREIGN KEY (`user_type`) REFERENCES `user_type` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
