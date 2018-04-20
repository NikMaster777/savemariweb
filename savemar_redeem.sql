-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 20, 2018 at 07:12 AM
-- Server version: 5.6.36-cll-lve
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `savemar_redeem`
--

-- --------------------------------------------------------

--
-- Table structure for table `re_admins`
--

CREATE TABLE `re_admins` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_address` text NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_landline` varchar(255) NOT NULL,
  `user_mobile` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_session` text NOT NULL,
  `user_disabled` int(11) NOT NULL,
  `user_created` datetime NOT NULL,
  `user_notepad` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `re_admins`
--

INSERT INTO `re_admins` (`user_id`, `user_username`, `user_firstname`, `user_lastname`, `user_address`, `user_email`, `user_landline`, `user_mobile`, `user_password`, `user_session`, `user_disabled`, `user_created`, `user_notepad`) VALUES
(1, 'admin', 'Shaun', 'Childerley', '14 Belvoir Street', 'admin@savemari.com', '01159550191', '01159550191', 'f1e96e9779ec4f8f44daadc8193c1c607a7a5040', '3ee616e86741eb6b82ac4b0a543148bf73c4ee82', 0, '2015-10-31 00:00:00', '');

-- --------------------------------------------------------

--
-- Table structure for table `re_trans`
--

CREATE TABLE `re_trans` (
  `trans_id` int(10) UNSIGNED NOT NULL,
  `trans_siteid` int(11) NOT NULL,
  `trans_fullname` varchar(255) NOT NULL,
  `trans_mobile` varchar(255) NOT NULL,
  `trans_email` varchar(255) NOT NULL,
  `trans_reference` varchar(255) NOT NULL,
  `trans_amount` decimal(64,2) NOT NULL,
  `trans_postid` int(11) NOT NULL,
  `trans_postslug` text NOT NULL,
  `trans_paytype` int(11) NOT NULL,
  `trans_paystatus` int(11) NOT NULL,
  `trans_paydate` date NOT NULL,
  `trans_date` date NOT NULL,
  `trans_hidden` int(11) NOT NULL,
  `trans_voucher` varchar(255) NOT NULL,
  `trans_voucher_redeem` int(11) NOT NULL,
  `trans_gateway_status` text NOT NULL,
  `trans_paynow_pollurl` text NOT NULL,
  `trans_paypal_txnid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `re_trans`
--

INSERT INTO `re_trans` (`trans_id`, `trans_siteid`, `trans_fullname`, `trans_mobile`, `trans_email`, `trans_reference`, `trans_amount`, `trans_postid`, `trans_postslug`, `trans_paytype`, `trans_paystatus`, `trans_paydate`, `trans_date`, `trans_hidden`, `trans_voucher`, `trans_voucher_redeem`, `trans_gateway_status`, `trans_paynow_pollurl`, `trans_paypal_txnid`) VALUES
(4, 3, 'Shaun Childerley', '07476201688', 'pkonoro@gmail.com', '8EA35C', '12000.00', 196, 'gray-mazda-6-4-door', 1, 1, '2016-11-11', '2016-11-11', 0, 'E8F3-4C4B-4161-C9DC', 1, 'Paid', '', ''),
(6, 3, 'Peter', '07476201688', 'buyer@savemari.com', '3A5D4E', '10000.00', 199, 'mazda-mx-5-miata', 2, 1, '2016-11-11', '2016-11-11', 0, 'DCB2-3A12-7D8E-3A3F', 1, 'Awaiting Delivery', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=a93c16c6-f603-4e2a-a7a1-c92b6aaef851', ''),
(7, 3, 'Peter', '07476201688', 'buyer@savemari.com', '3A008A', '45000.00', 180, 'black-bmw-m5-2-door', 3, 1, '2016-11-11', '2016-11-11', 0, 'B6DC-DB36-D898-2C98', 1, 'Completed', '', ''),
(8, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '282403', '60000.00', 1897, 'marlborough-2-bed-roomed-flat-on-first-floor', 1, 1, '2016-11-22', '2016-11-13', 0, 'FA4E-8C19-C311-EC65', 0, 'Paid', '', ''),
(9, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '133AB1', '5.00', 2010, 'test-listing', 3, 0, '0000-00-00', '2016-11-13', 1, '', 0, '', '', ''),
(10, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '16B7EA', '60000.00', 1897, 'marlborough-2-bed-roomed-flat-on-first-floor', 2, 0, '0000-00-00', '2016-11-13', 1, '', 0, 'Ok', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=b6ab329c-1f40-4730-b1e3-b50e7db0545f', ''),
(11, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'BC96DF', '60000.00', 1897, 'marlborough-2-bed-roomed-flat-on-first-floor', 2, 1, '2016-11-13', '2016-11-13', 0, 'C1E8-9BD9-5C51-01FE', 0, 'Awaiting Delivery', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=55323043-d25a-4f4e-8ecb-4ca87c984b40', ''),
(12, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '02BFC9', '5.00', 2010, 'test-listing', 1, 0, '0000-00-00', '2016-11-14', 0, '', 0, '', '', ''),
(13, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '1383C5', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-11-14', 0, '', 0, '', '', ''),
(14, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '0FCB7C', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-11-14', 0, '', 0, '', '', ''),
(15, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'CAA13A', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-11-14', 0, '', 0, '', '', ''),
(16, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'E743AE', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-11-14', 0, '', 0, '', '', ''),
(17, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '76AB41', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-11-14', 0, '', 0, '', '', ''),
(18, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'A5FFB4', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-11-14', 0, '', 0, '', '', ''),
(19, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '9DA83B', '5.00', 2010, 'test-listing', 2, 1, '2016-11-15', '2016-11-15', 0, '801E-7E0F-ED3C-707B', 1, 'Paid', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=9663c804-c68e-4019-a17a-e3d8da2bee11', ''),
(20, 7, 'Peter Konoro', '07735240382', 'pkonoro@gmail.com', '0BCFCC', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 0, '0000-00-00', '2016-11-16', 0, '', 0, '', '', ''),
(21, 7, 'Peter Konoro', '+447774521349', 'pkonoro@gmail.com', '77F998', '5.00', 2010, 'test-listing', 1, 0, '0000-00-00', '2016-11-16', 0, '', 0, '', '', ''),
(22, 7, 'Peter Konoro', '07421991105', 'pkonoro@gmail.com', '58F6AC', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 0, '0000-00-00', '2016-11-16', 0, '', 0, '', '', ''),
(23, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'A99E15', '5.00', 2010, 'test-listing', 1, 1, '2016-11-18', '2016-11-18', 0, 'FFB8-8A09-BB42-47FD', 1, 'Paid', '', ''),
(24, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'A133BF', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 2, 1, '2016-11-18', '2016-11-18', 0, 'E25F-DE56-253C-0190', 0, 'Awaiting Delivery', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=588fafa9-fead-4591-b014-75c4d18e2cf2', ''),
(25, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '51BF98', '5.00', 2010, 'test-listing', 3, 0, '0000-00-00', '2016-11-18', 1, '', 0, '', '', ''),
(26, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '6D1D23', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 1, 1, '2016-11-22', '2016-11-18', 0, 'A815-CD85-195F-7FB7', 0, 'Paid', '', ''),
(27, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '25939F', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2016-11-18', 0, '', 0, '', '', ''),
(28, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '19EBAC', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2016-11-18', 0, '', 0, '', '', ''),
(29, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'B0D97A', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2016-11-18', 0, '', 0, '', '', ''),
(30, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '621C01', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2016-11-18', 0, '', 0, '', '', ''),
(31, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '0F763B', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2016-11-18', 0, '', 0, '', '', ''),
(32, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '5C8477', '60000.00', 1897, 'marlborough-2-bed-roomed-flat-on-first-floor', 3, 0, '0000-00-00', '2016-11-18', 1, '', 0, '', '', ''),
(33, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'FCD239', '60000.00', 1897, 'marlborough-2-bed-roomed-flat-on-first-floor', 2, 1, '2016-11-18', '2016-11-18', 0, '9B7D-937E-4969-BD41', 0, 'Awaiting Delivery', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=bb023540-f7d6-4431-b5dc-4e2c5e63eb60', ''),
(34, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '37F46B', '5.00', 2010, 'test-listing', 1, 1, '2016-11-22', '2016-11-19', 0, '9C05-D44E-2E79-835C', 0, 'Paid', '', ''),
(35, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '5ADD64', '5.00', 2010, 'test-listing', 2, 1, '2016-11-19', '2016-11-19', 0, '1D21-7C17-DA38-A8AD', 1, 'Paid', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=1ba5c11f-58b1-418c-a6cc-6166ae313b99', ''),
(36, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '5A50CC', '5.00', 2010, 'test-listing', 1, 1, '2016-11-22', '2016-11-19', 0, 'B99F-87AE-5EA1-E6B2', 0, 'Paid', '', ''),
(37, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '16F64A', '5.00', 2010, 'test-listing', 2, 1, '2016-11-19', '2016-11-19', 0, 'AF89-6B88-F12C-0B6F', 1, 'Paid', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=6c5a1f2d-3075-4f69-b0f0-9aa55bf29aee', ''),
(38, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'F6455E', '5.00', 2010, 'test-listing', 2, 1, '2016-11-19', '2016-11-19', 0, 'EF15-9DF2-C84B-0A1C', 0, 'Paid', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=64f249b1-f801-49f8-a8f4-86eaa5347fef', ''),
(39, 7, 'hhh', '12345678987', 'hh@gmail.com', 'A6500E', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 2, 0, '0000-00-00', '2016-11-22', 1, '', 0, 'Ok', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=42ca102a-8996-4786-a8ae-ab295564f815', ''),
(40, 7, 'humphrey', '07774521349', 'humphrey@mobilityholdings.co.za', '783BA4', '5.00', 2010, 'test-listing', 1, 1, '2016-11-22', '2016-11-22', 0, 'ED1A-D084-713E-C540', 0, 'Paid', '', ''),
(41, 7, 'humphrey', '07476201688', 'humphrey@mobilityholdings.co.za', '0E32F2', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 2, 1, '2016-11-22', '2016-11-22', 0, 'FB2B-AF64-7EF9-4F9A', 1, 'Awaiting Delivery', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=7fb941ad-f30e-45de-be5d-1e5b139b9d78', ''),
(42, 7, 'Peter Konoro', '+447774521349', 'pkonoro@gmail.com', '32460A', '5.00', 2010, 'test-listing__trashed', 1, 0, '0000-00-00', '2016-11-29', 0, '', 0, '', '', ''),
(43, 7, 'Tsungi', '07975772254', 'pkonoro@gmail.com', 'B22001', '600000.00', 2025, 'borrowdale-samy-levy-double-storey', 1, 0, '0000-00-00', '2016-12-09', 0, '', 0, '', '', ''),
(44, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', 'E15FAA', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 0, '0000-00-00', '2016-12-11', 0, '', 0, '', '', ''),
(45, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', 'F07029', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-12-11', 0, '', 0, '', '', ''),
(46, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', 'E23CE3', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-12-11', 0, '', 0, '', '', ''),
(47, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', '64D065', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-12-11', 0, '', 0, '', '', ''),
(48, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', '3466B7', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-12-11', 0, '', 0, '', '', ''),
(49, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', '48E4D1', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-12-11', 0, '', 0, '', '', ''),
(50, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', 'B2B500', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-12-11', 0, '', 0, '', '', ''),
(51, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', '575864', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-12-11', 0, '', 0, '', '', ''),
(52, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', '8262D7', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-12-11', 0, '', 0, '', '', ''),
(53, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', 'A2A359', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-12-11', 0, '', 0, '', '', ''),
(54, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', '99068F', '8.00', 1973, 'southlea-park-stand', 2, 0, '0000-00-00', '2016-12-11', 0, '', 0, '', '', ''),
(55, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', 'D04C6B', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 3, 0, '0000-00-00', '2016-12-11', 1, '', 0, '', '', ''),
(56, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', '7491E2', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 3, 0, '0000-00-00', '2016-12-11', 1, '', 0, '', '', ''),
(57, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', 'D295D6', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2016-12-11', 0, '', 0, '', '', ''),
(58, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', 'A86923', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2016-12-11', 0, '', 0, '', '', ''),
(59, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', '56F8FC', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2016-12-11', 0, '', 0, '', '', ''),
(60, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', '031B03', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2016-12-11', 0, '', 0, '', '', ''),
(61, 7, 'peter konoro', '07784143568', 'pkonoro@gmail.com', '988BD6', '8.00', 1973, 'southlea-park-stand', 3, 1, '2016-12-11', '2016-12-11', 0, 'CDF3-14E8-753D-4341', 1, 'Completed', '', ''),
(62, 7, 'JU', '00263772997889', 'fungai.chimwa@gmail.com', '5ED45A', '600000.00', 2025, 'borrowdale-samy-levy-double-storey', 1, 0, '0000-00-00', '2016-12-13', 0, '', 0, '', '', ''),
(63, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'CBBDB8', '600000.00', 2025, 'borrowdale-samy-levy-double-storey', 2, 0, '0000-00-00', '2016-12-20', 1, '', 0, 'Ok', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=4d3b2f54-6711-4508-a7f1-d2c466fd11e6', ''),
(64, 7, 'mr mantse', '07857545657', 'pkonoro@gmail.com', 'BDA411', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 1, '2016-12-20', '2016-12-20', 0, '3F10-5C26-BA75-A78D', 0, 'Paid', '', ''),
(65, 7, 'Tidi Kwidini', '+447852843367', 'lizkay30@yahoo.com', '7CC416', '600000.00', 2025, 'borrowdale-samy-levy-double-storey', 1, 1, '2016-12-21', '2016-12-21', 0, '34FE-4265-0547-DA5A', 0, 'Paid', '', ''),
(66, 7, 'Tidi Kwidini', '+447852843367', 'lizkay30@yahoo.com', '576514', '600000.00', 2025, 'borrowdale-samy-levy-double-storey', 1, 0, '0000-00-00', '2016-12-21', 0, '', 0, '', '', ''),
(67, 7, 'Tidi Kwidini', '+447852843367', 'lizkay30@yahoo.com', '09B972', '600000.00', 2025, 'borrowdale-samy-levy-double-storey', 1, 0, '0000-00-00', '2016-12-21', 0, '', 0, '', '', ''),
(68, 7, 'Tidi Kwidini', '+447852843367', 'lizkay30@yahoo.com', '2D441D', '600000.00', 2025, 'borrowdale-samy-levy-double-storey', 1, 0, '0000-00-00', '2016-12-21', 0, '', 0, '', '', ''),
(69, 7, 'Tidi Kwidini', '+447852843367', 'lizkay30@yahoo.com', 'BF33AA', '600000.00', 2025, 'borrowdale-samy-levy-double-storey', 1, 0, '0000-00-00', '2016-12-21', 0, '', 0, '', '', ''),
(70, 7, 'Tidi Kwidini', '07852843367', 'lizkay30@yahoo.com', '072748', '600000.00', 2025, 'borrowdale-samy-levy-double-storey', 1, 0, '0000-00-00', '2016-12-21', 0, '', 0, '', '', ''),
(71, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'E5B279', '600000.00', 2025, 'borrowdale-samy-levy-double-storey', 1, 0, '0000-00-00', '2016-12-21', 0, '', 0, '', '', ''),
(72, 7, 'Tidi Kwidini', '00447852843367', 'lizkay30@yahoo.com', 'E0CEF0', '600000.00', 2025, 'borrowdale-samy-levy-double-storey', 1, 0, '0000-00-00', '2016-12-21', 0, '', 0, '', '', ''),
(73, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'BB8BC5', '600000.00', 2025, 'borrowdale-samy-levy-double-storey', 1, 0, '0000-00-00', '2016-12-21', 0, '', 0, '', '', ''),
(74, 7, 'Tidi Kwidini', '00447852843367', 'lizkay30@yahoo.com', '1A9B64', '600000.00', 2025, 'borrowdale-samy-levy-double-storey', 1, 1, '2016-12-21', '2016-12-21', 0, 'C056-00A5-0BB9-7FBC', 1, 'Paid', '', ''),
(75, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '968ED7', '600000.00', 2025, 'borrowdale-samy-levy-double-storey', 1, 1, '2017-01-10', '2016-12-21', 0, 'D3EA-25EA-B367-1379', 1, 'Paid', '', ''),
(76, 7, 'Peter Konoro', '+447774521349', 'pkonoro@gmail.com', 'B9C8B6', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 1, 0, '0000-00-00', '2016-12-22', 0, '', 0, '', '', ''),
(77, 7, 'Peter Konoro', '+447774521349', 'pkonoro@gmail.com', '15CDC9', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 1, 1, '2016-12-22', '2016-12-22', 0, 'A5DE-0A02-AF4F-9BA2', 0, 'Paid', '', ''),
(78, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '97E575', '600000.00', 2025, 'borrowdale-samy-levy-double-storey', 1, 1, '2016-12-23', '2016-12-23', 0, 'B45A-7624-B2F8-7C1A', 1, 'Paid', '', ''),
(79, 7, 'nicole mazokera', '07774521349', 'maityronetinashe@gmail.com', 'ED49C7', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 1, '2016-12-28', '2016-12-28', 0, '8A1F-CDC9-77D8-19F7', 0, 'Paid', '', ''),
(80, 7, 'NICOL', '07774521349', 'maityronetinashe@gmail.com', '3C521D', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2016-12-28', 0, '', 0, '', '', ''),
(81, 7, 'NICOL', '07774521349', 'maityronetinashe@gmail.com', '6F58A5', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2016-12-28', 0, '', 0, '', '', ''),
(82, 7, 'NICOL', '07774521349', 'maityronetinashe@gmail.com', '08567B', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2016-12-28', 0, '', 0, '', '', ''),
(83, 7, 'NICOL', '07774521349', 'maityronetinashe@gmail.com', '759644', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2016-12-28', 0, '', 0, '', '', ''),
(84, 7, 'nicole', '07774521349', 'maityronetinashe@gmail.com', 'EF3756', '153000.00', 1904, '5-beds-and-en-suite', 3, 0, '0000-00-00', '2016-12-28', 1, '', 0, '', '', ''),
(85, 7, 'nicol', '07774521349', 'maityronetinashe@gmail.com', '0AFDC4', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 2, 1, '2016-12-28', '2016-12-28', 0, '614B-434A-084C-5F46', 0, 'Awaiting Delivery', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=8de35b11-22ff-474f-9de8-5771ffe0955d', ''),
(86, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'DDADC8', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 1, '2016-12-28', '2016-12-28', 0, '8AC5-89D1-8BB2-12FC', 0, 'Paid', '', ''),
(87, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '7044EB', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 1, '2016-12-28', '2016-12-28', 0, '6E06-72D4-590E-E074', 0, 'Paid', '', ''),
(88, 7, 'clarence', '0785832698', 'clarence@charis.co.zw', '92AEE1', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 2, 0, '0000-00-00', '2017-01-09', 1, '', 0, 'Ok', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=76913450-64ca-4569-95d2-47f6aa129fc1', ''),
(89, 7, 'Peter Konoro', '+447774521349', 'pkonoro@gmail.com', 'E69719', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 0, '0000-00-00', '2017-02-07', 0, '', 0, '', '', ''),
(90, 7, 'Peter Konoro', '+447774521349', 'pkonoro@gmail.com', '6A1B23', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 1, '2017-02-07', '2017-02-07', 0, '8EF4-63DB-B7B1-A612', 0, 'Paid', '', ''),
(91, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'EC9878', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 0, '0000-00-00', '2017-02-28', 0, '', 0, '', '', ''),
(92, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '7F6DD4', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 1, '2017-02-28', '2017-02-28', 0, '0E03-D5E0-88ED-C1E3', 0, 'Paid', '', ''),
(93, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'DD2E7A', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2017-02-28', 0, '', 0, '', '', ''),
(94, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '20C408', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2017-02-28', 0, '', 0, '', '', ''),
(95, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '219D0F', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2017-02-28', 0, '', 0, '', '', ''),
(96, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', 'A9AA7F', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2017-02-28', 0, '', 0, '', '', ''),
(98, 7, 'Kudzai', '07729711320', 'Kfmidzi@gmail.com', 'F5CBE6', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 1, '2017-04-08', '2017-03-18', 0, '325D-9BBE-2CD7-300E', 0, 'Paid', '', ''),
(99, 7, 'Peter Konoro', '+447774521349', 'pkonoro@gmail.com', 'E468FB', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 1, 0, '0000-00-00', '2017-03-18', 0, '', 0, '', '', ''),
(100, 7, 'Peter Kon', '07587876429', 'pkonoro@gmail.com', 'C07A78', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 1, 1, '2017-03-18', '2017-03-18', 0, '83A0-3262-EFF1-28C0', 0, 'Paid', '', ''),
(101, 7, 'Peter Konoro', '07885268228', 'pkonoro@gmail.com', 'DE2AE5', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 1, '2017-03-18', '2017-03-18', 0, 'BF9F-F4E5-3611-6AC3', 0, 'Paid', '', ''),
(102, 7, 'benard', '07832679922', 'pkonoro@gmail.com', '2A23D8', '8.00', 1973, 'southlea-park-stand', 1, 1, '2017-03-23', '2017-03-23', 0, '51AB-EFDE-89B3-EB50', 0, 'Paid', '', ''),
(103, 7, 'hlana', '07590542867', 'pkonoro@gmail.com', '6CE0E5', '8.00', 1973, 'southlea-park-stand', 1, 1, '2017-04-08', '2017-04-08', 0, 'F417-BF82-7316-290A', 0, 'Paid', '', ''),
(104, 7, 'tsungi', '07975772254', 'pkonoro@gmail.com', 'C4E85E', '8.00', 1973, 'southlea-park-stand', 1, 1, '2017-04-11', '2017-04-11', 0, '2985-08A5-657B-56CB', 0, 'Paid', '', ''),
(105, 7, 'Tanaka', '077478998894', 'pkonoro@gmail.com', 'B3A505', '153000.00', 1904, '5-beds-and-en-suite', 1, 0, '0000-00-00', '2017-04-12', 0, '', 0, '', '', ''),
(106, 7, 'Tanaka', '077478998894', 'pkonoro@gmail.com', 'CA7F31', '153000.00', 1904, '5-beds-and-en-suite', 1, 0, '0000-00-00', '2017-04-12', 0, '', 0, '', '', ''),
(107, 7, 'spencer', '07480149075', 'pkonoro@gmail.com', '346CC3', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 1, '2017-04-14', '2017-04-14', 0, '74F0-30E6-DDAD-1318', 0, 'Paid', '', ''),
(108, 7, 'tesa', '07957595010', 'pkonoro@gmail.com', '0361E7', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 1, '2017-04-17', '2017-04-17', 0, 'AB4D-2CCE-5BF0-2922', 0, 'Paid', '', ''),
(109, 7, 'Tasha', '07763456486', 'pkonoro@gmail.com', '3EDB8E', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 1, '2017-04-21', '2017-04-21', 0, '64E2-F8F1-684F-6DC7', 0, 'Paid', '', ''),
(110, 7, 'Zai', '07594282361', 'pkonoro@gmail.com', 'E7074F', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 1, '2017-05-17', '2017-05-17', 0, '89E7-7C0B-FC08-4866', 0, 'Paid', '', ''),
(111, 7, 'Jah', '07979073665', 'pkonoro@gmail.com', '85DE14', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 1, 1, '2017-06-04', '2017-06-04', 0, '93D4-FCDA-9F47-C9D6', 0, 'Paid', '', ''),
(112, 7, 'tafadzwa gocha', '0771340384', 'tafadzwagee@gmail.com', 'BB2064', '153000.00', 1904, '5-beds-and-en-suite', 1, 0, '0000-00-00', '2017-06-06', 0, '', 0, '', '', ''),
(113, 7, 'tafadzwa gocha', '0771340384', 'tafadzwagee@gmail.com', '056C85', '153000.00', 1904, '5-beds-and-en-suite', 1, 0, '0000-00-00', '2017-06-06', 0, '', 0, '', '', ''),
(114, 7, 'tafadzwa gocha', '0771340384', 'tafadzwagee@gmail.com', 'A37085', '153000.00', 1904, '5-beds-and-en-suite', 1, 0, '0000-00-00', '2017-06-06', 0, '', 0, '', '', ''),
(115, 7, 'gary', '07474126180', 'pkonoro@gmail.com', 'E0EA65', '60000.00', 1897, 'marlborough-2-bed-roomed-flat-on-first-floor', 1, 1, '2017-06-10', '2017-06-10', 0, 'F0C1-F3DF-B248-9FEC', 0, 'Paid', '', ''),
(116, 7, 'thabo', '07476201688', 'pkonoro@gmail.com', 'ECFC2E', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 1, '2017-07-11', '2017-07-11', 0, '2B83-A65E-BE46-0A8E', 0, 'Paid', '', ''),
(117, 7, 'Ozzyy', '07774521349', 'pkonoro@gmail.com', '81ED87', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 0, '0000-00-00', '2017-07-17', 0, '', 0, '', '', ''),
(118, 7, 'peter konoro', '07774521349', 'pkonoro@gmail.com', '793A2C', '60000.00', 1897, 'marlborough-2-bed-roomed-flat-on-first-floor', 1, 0, '0000-00-00', '2017-07-31', 0, '', 0, '', '', ''),
(119, 7, 'peter konoro', '07476201688', 'pkonoro@gmail.com', 'EE6C77', '60000.00', 1897, 'marlborough-2-bed-roomed-flat-on-first-floor', 1, 0, '0000-00-00', '2017-07-31', 0, '', 0, '', '', ''),
(120, 7, 'peter konoro', '07476201688', 'pkonoro@gmail.com', '89F41C', '60000.00', 1897, 'marlborough-2-bed-roomed-flat-on-first-floor', 1, 1, '2017-07-31', '2017-07-31', 0, '057E-5BBC-AEB3-90FA', 0, 'Paid', '', ''),
(133, 7, 'Buyer Demo', '+3309876543216', 'buyer@savemari.com', '272D5C', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 1, '2017-08-08', '2017-08-08', 0, '7FDF-C4BB-564A-798C', 1, 'Paid', '', ''),
(134, 7, 'Buyer Demo', '+3309876543216', 'buyer@savemari.com', '66A49D', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 1, 1, '2017-08-08', '2017-08-08', 0, 'CB26-BB8C-D9DF-AA76', 1, 'Paid', '', ''),
(135, 7, 'ennie', '07889459632', 'pkonoro@gmail.com', '23385B', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 2, 1, '2017-08-24', '2017-08-24', 0, '867E-AB62-9283-1889', 0, 'Awaiting Delivery', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=80e04139-5e29-4196-8ab0-9760e774de7f', ''),
(136, 7, 'clarence', '0785832698', 'clarence@savemari.com', '918122', '280000.00', 2000, 'highlands-house-brand-new-town-house-in-the-heart-of-highlands-features', 2, 0, '0000-00-00', '2017-09-01', 1, '', 0, 'Ok', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=d86b1833-f00e-4911-894f-6d8fe727abf8', ''),
(137, 7, 'rise', '0785832698', 'rise@gmail.com', 'A7D250', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2017-09-01', 0, '', 0, '', '', ''),
(138, 7, 'rise', '0785832698', 'rise@gmail.com', '54A567', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2017-09-01', 0, '', 0, '', '', ''),
(139, 7, 'rise', '0785832698', 'rise@gmail.com', '3E8F4E', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2017-09-01', 0, '', 0, '', '', ''),
(140, 7, 'rise', '0785832698', 'rise@gmail.com', '9B0FA4', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2017-09-01', 0, '', 0, '', '', ''),
(141, 7, 'risen', '0785832698', 'rise@gmail.com', 'E0B650', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2017-09-01', 0, '', 0, '', '', ''),
(142, 7, 'risen', '0785832698', 'clarence@gmail.com', '039BD4', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2017-09-01', 0, '', 0, '', '', ''),
(143, 7, 'risen', '0785832698', 'clarence@gmail.com', 'FEED0D', '230.00', 1984, 'borrowdale-quinnington-stand-with-a-neat-3-bed-cottage', 2, 0, '0000-00-00', '2017-09-01', 0, '', 0, '', '', ''),
(144, 7, 'Clarence', '+263785832698', 'clarence@savemari.com', 'F9891D', '153000.00', 1904, '5-beds-and-en-suite', 2, 0, '0000-00-00', '2017-09-01', 1, '', 0, 'Ok', 'https://www.paynow.co.zw/Interface/CheckPayment/?guid=67988103-0b33-49f8-b347-9183449352c7', '');

-- --------------------------------------------------------

--
-- Table structure for table `re_users`
--

CREATE TABLE `re_users` (
  `user_id` int(11) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_session` text NOT NULL,
  `user_created` datetime NOT NULL,
  `user_disabled` int(11) NOT NULL,
  `user_customer` varchar(100) NOT NULL,
  `user_address` text NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_landline` varchar(255) NOT NULL,
  `user_mobile` varchar(255) NOT NULL,
  `user_storefront_url` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `re_users`
--

INSERT INTO `re_users` (`user_id`, `user_username`, `user_password`, `user_session`, `user_created`, `user_disabled`, `user_customer`, `user_address`, `user_email`, `user_firstname`, `user_lastname`, `user_landline`, `user_mobile`, `user_storefront_url`) VALUES
(3, 'CarHeros', '12345', 'bec73d74775d8ee11a578b8409956a6a698d16eb', '2015-11-11 08:56:24', 0, 'Car Heros', '14 Belvoir Street', 'storefront@savemari.com', 'Car', 'Heros', 'Nottingham', '07774521349', 'http://savemari.com/store/carheros/'),
(7, 'propertyvoice', 'letmein', '', '2016-11-10 08:33:47', 0, 'Property Voice', '14 Random Place\r\nNG156NL\r\nUnited Kingdom', 'seller@savemari.com', 'Property', 'Voice', '00000000000', '07774521349', 'http://www.savemari.com/store/propertyvoice/'),
(8, 'Zim Glamor', '408583', '', '2016-11-10 11:52:56', 0, 'Zim Glamor', '14 Zim Street', 'storefront@savemari.com', 'Zim', 'Glamor', '23424334324', '07774521349', 'http://savemari.com/store/zimglamor/');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `re_admins`
--
ALTER TABLE `re_admins`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `re_trans`
--
ALTER TABLE `re_trans`
  ADD PRIMARY KEY (`trans_id`);

--
-- Indexes for table `re_users`
--
ALTER TABLE `re_users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `re_admins`
--
ALTER TABLE `re_admins`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `re_trans`
--
ALTER TABLE `re_trans`
  MODIFY `trans_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `re_users`
--
ALTER TABLE `re_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
