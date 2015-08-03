-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 05, 2014 at 04:35 AM
-- Server version: 5.5.24-log
-- PHP Version: 5.3.13

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mdsfqtxu_hhimsv2`
--

--
-- Dumping data for table `disorder`
--

INSERT INTO `disorder` (`DISORDERID`, `CONCEPTID`, `DESCRIPTIONID`, `DESCRIPTIONSTATUS`, `TERM`, `INITIALCAPITALSTATUS`, `DESCRIPTIONTYPE`, `LANGUAGECODE`, `CreateDate`, `CreateUser`, `LastUpDate`, `LastUpDateUser`, `Active`, `Link_ICD_Code`, `Link_ICD_Text`) VALUES
(1, 105000, 1311016, 0, 'Poisoning by pharmaceutical excipient', '0', 'SYN', 'en', '2011-10-06 15:00:00', 'TS Ruban', NULL, NULL, 1, 'T50.9', 'Other and unspecified drugs, medicaments and biological substances'),
(2, 109006, 1317017, 0, 'Anxiety disorder of childhood OR adolescence', '0', 'SYN', 'en', '2011-10-06 15:00:00', 'TS Ruban', NULL, NULL, 1, 'F41.8', 'Other specified anxiety disorders'),
(3, 122003, 1256014, 0, 'Choroidal hemorrhage', '0', 'SYN', 'en', '2011-10-06 15:00:00', 'TS Ruban', NULL, NULL, 1, 'H31.3', 'Choroidal haemorrhage and rupture'),
(4, 122003, 469795010, 0, 'Choroidal haemorrhage', '0', 'SYN', 'en', '2011-10-06 15:00:00', 'TS Ruban', NULL, NULL, 1, 'H31.3', 'Choroidal haemorrhage and rupture');

INSERT INTO `event` (`EVENTID`, `CONCEPTID`, `DESCRIPTIONID`, `DESCRIPTIONSTATUS`, `TERM`, `INITIALCAPITALSTATUS`, `DESCRIPTIONTYPE`, `LANGUAGECODE`, `CreateDate`, `CreateUser`, `LastUpDate`, `LastUpDateUser`, `Active`, `Link_ICD_Code`, `Link_ICD_Text`) VALUES
(1, 891003, 2568015, 0, 'Suicide by self-administered drug', '0', 'SYN', 'en', '2011-10-06 15:00:00', 'TS Ruban', NULL, NULL, 1, NULL, NULL),
(2, 1210002, 3149016, 0, 'Struck by falling lumber', '0', 'SYN', 'en', '2011-10-06 15:00:00', 'TS Ruban', NULL, NULL, 1, NULL, NULL),
(3, 1428003, 3485011, 0, 'Asphyxia due to foreign body in larynx', '0', 'SYN', 'en', '2011-10-06 15:00:00', 'TS Ruban', NULL, NULL, 1, NULL, NULL),
(4, 1762004, 4048015, 0, 'Fetal death from asphyxia AND/OR anoxia during labor', '0', 'SYN', 'en', '2011-10-06 15:00:00', 'TS Ruban', NULL, NULL, 1, NULL, NULL);

INSERT INTO `finding` (`FINDID`, `CONCEPTID`, `DESCRIPTIONID`, `DESCRIPTIONSTATUS`, `TERM`, `INITIALCAPITALSTATUS`, `DESCRIPTIONTYPE`, `LANGUAGECODE`, `CreateDate`, `CreateUser`, `LastUpDate`, `LastUpDateUser`, `Active`, `Link_ICD_Code`, `Link_ICD_Text`) VALUES
(1, 129007, 1266018, 0, 'Homoiothermia', '0', 'SYN', 'en', '2011-10-06 15:00:00', 'TS Ruban', NULL, NULL, 1, NULL, NULL),
(2, 129007, 1267010, 0, 'Homoiothermy', '0', 'SYN', 'en', '2011-10-06 15:00:00', 'TS Ruban', NULL, NULL, 1, NULL, NULL),
(3, 134006, 1275016, 0, 'Decreased hair growth', '0', 'SYN', 'en', '2011-10-06 15:00:00', 'TS Ruban', NULL, NULL, 1, NULL, NULL),
(4, 144008, 1289014, 0, 'Normal peripheral vision', '0', 'SYN', 'en', '2011-10-06 15:00:00', 'TS Ruban', NULL, NULL, 1, NULL, NULL);

SET FOREIGN_KEY_CHECKS=1;

