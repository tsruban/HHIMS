-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 05, 2014 at 04:28 AM
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

-- --------------------------------------------------------

--
-- Table structure for table `admission`
--

CREATE TABLE IF NOT EXISTS `admission` (
  `ADMID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) DEFAULT NULL,
  `BHT` varchar(100) NOT NULL,
  `AdmissionDate` datetime NOT NULL,
  `Doctor` int(11) DEFAULT NULL,
  `Ward` int(5) NOT NULL,
  `Complaint` varchar(200) NOT NULL,
  `ICD_Code` varchar(10) DEFAULT NULL,
  `ICD_Text` varchar(200) DEFAULT NULL,
  `SNOMED_Code` varchar(20) DEFAULT NULL,
  `SNOMED_Text` varchar(200) DEFAULT NULL,
  `IMMR_Code` varchar(10) DEFAULT NULL,
  `IMMR_Text` varchar(200) DEFAULT NULL,
  `Discharge_ICD_Code` varchar(10) DEFAULT NULL,
  `Discharge_ICD_Text` varchar(200) DEFAULT NULL,
  `Discharge_IMMR_Code` varchar(10) DEFAULT NULL,
  `Discharge_IMMR_Text` varchar(200) DEFAULT NULL,
  `Discharge_SNOMED_Code` varchar(20) DEFAULT NULL,
  `Discharge_SNOMED_Text` varchar(200) DEFAULT NULL,
  `Discharge_Doctor` int(11) DEFAULT NULL,
  `DischargeDate` varchar(30) DEFAULT NULL,
  `OutCome` varchar(50) DEFAULT NULL,
  `Discharge_Remarks` varchar(200) NOT NULL,
  `ReferTo` varchar(30) DEFAULT NULL,
  `Remarks` varchar(200) NOT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `OnSetDate` date DEFAULT NULL,
  `AdmitTo` int(4) DEFAULT NULL,
  `O_PID` varchar(100) DEFAULT NULL,
  `DeathDate` varchar(30) DEFAULT NULL,
  `is_referred` tinyint(1) NOT NULL,
  `referred_id` int(11) DEFAULT NULL,
  `referred_from` varchar(50) DEFAULT NULL,
  `ICD` int(11) NOT NULL,
  `IMMR` int(11) NOT NULL,
  `SNOMED` int(11) NOT NULL,
  `Discharge_ICD` int(11) NOT NULL,
  `Discharge_IMMR` int(11) NOT NULL,
  `Discharge_SNOMED` int(11) NOT NULL,
  PRIMARY KEY (`ADMID`),
  KEY `IX_ADMDATE` (`AdmissionDate`),
  KEY `IX_DISDATE` (`DischargeDate`),
  KEY `IX_PID` (`PID`),
  KEY `IX_WARD` (`Ward`),
  KEY `fk_doctor` (`Doctor`),
  KEY `fk_ward_admit` (`AdmitTo`),
  KEY `fk_ICD` (`ICD`),
  KEY `fk_DCHR_ICD` (`Discharge_ICD`),
  KEY `fk_IMMR` (`IMMR`),
  KEY `fk_DCHR_IMMR` (`Discharge_IMMR`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=177 ;

-- --------------------------------------------------------

--
-- Table structure for table `admission_diagnosis`
--

CREATE TABLE IF NOT EXISTS `admission_diagnosis` (
  `ADMDIAGNOSISID` int(11) NOT NULL AUTO_INCREMENT,
  `ADMID` int(11) NOT NULL,
  `PID` varchar(100) NOT NULL,
  `ICD_Code` varchar(10) DEFAULT NULL,
  `ICD_Text` varchar(200) DEFAULT NULL,
  `SNOMED_Code` varchar(20) DEFAULT NULL,
  `SNOMED_Text` varchar(200) DEFAULT NULL,
  `IMMR_Code` varchar(10) DEFAULT NULL,
  `IMMR_Text` varchar(200) DEFAULT NULL,
  `Remarks` varchar(200) NOT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `DiagnosisDate` datetime DEFAULT NULL,
  `Main` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`ADMDIAGNOSISID`),
  KEY `fk_diagnosis_admission` (`ADMID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=107 ;

-- --------------------------------------------------------

--
-- Table structure for table `admission_notes`
--

CREATE TABLE IF NOT EXISTS `admission_notes` (
  `ADMNOTEID` int(11) NOT NULL AUTO_INCREMENT,
  `ADMID` int(11) NOT NULL,
  `Note` varchar(1000) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`ADMNOTEID`),
  KEY `fk_admission_notes` (`ADMID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=37 ;

-- --------------------------------------------------------

--
-- Table structure for table `admission_prescribe_items`
--

CREATE TABLE IF NOT EXISTS `admission_prescribe_items` (
  `prescribe_items_id` int(11) NOT NULL AUTO_INCREMENT,
  `admission_prescription_id` int(11) NOT NULL,
  `DRGID` int(11) DEFAULT NULL,
  `Dosage` varchar(100) DEFAULT NULL,
  `HowLong` varchar(100) DEFAULT NULL,
  `Remarks` varchar(200) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Frequency` varchar(50) DEFAULT NULL,
  `drug_list` text,
  `StopDate` datetime DEFAULT NULL,
  `route` varchar(50) DEFAULT NULL,
  `type` varchar(50) DEFAULT NULL,
  `given_by` int(11) DEFAULT NULL,
  `is_given` tinyint(1) DEFAULT '0',
  `given_date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`prescribe_items_id`),
  KEY `DRGID` (`DRGID`),
  KEY `admission_prescription_id` (`admission_prescription_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `admission_prescribe_items_dispense`
--

CREATE TABLE IF NOT EXISTS `admission_prescribe_items_dispense` (
  `items_dispense_id` int(11) NOT NULL AUTO_INCREMENT,
  `prescribe_items_id` int(11) NOT NULL,
  `given_date_time` datetime DEFAULT NULL,
  `given_by` varchar(100) DEFAULT NULL,
  `Remarks` varchar(200) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`items_dispense_id`),
  KEY `prescribe_items_id` (`prescribe_items_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `admission_prescription`
--

CREATE TABLE IF NOT EXISTS `admission_prescription` (
  `admission_prescription_id` int(11) NOT NULL AUTO_INCREMENT,
  `Dept` varchar(200) DEFAULT NULL,
  `ADMID` int(11) NOT NULL,
  `PID` int(11) DEFAULT NULL,
  `PrescribeDate` datetime DEFAULT NULL,
  `PrescribeBy` varchar(200) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `GetFrom` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`admission_prescription_id`),
  KEY `fk_visit_opd_presciption` (`ADMID`),
  KEY `fk_patient_opd_presciption` (`PID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `admission_procedures`
--

CREATE TABLE IF NOT EXISTS `admission_procedures` (
  `ADMDPROCEDUREID` int(11) NOT NULL AUTO_INCREMENT,
  `ADMID` int(11) NOT NULL,
  `SNOMED_Code` varchar(20) DEFAULT NULL,
  `SNOMED_Text` varchar(200) DEFAULT NULL,
  `Remarks` varchar(200) NOT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `ProcedureDate` datetime DEFAULT NULL,
  PRIMARY KEY (`ADMDPROCEDUREID`),
  KEY `fk_admission_procedures` (`ADMID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

-- --------------------------------------------------------

--
-- Table structure for table `admission_transfer`
--

CREATE TABLE IF NOT EXISTS `admission_transfer` (
  `ADTR` int(11) NOT NULL AUTO_INCREMENT,
  `ADMID` int(11) DEFAULT NULL,
  `TransferDate` datetime NOT NULL,
  `TransferFrom` int(4) DEFAULT NULL,
  `TransferTo` int(4) DEFAULT NULL,
  `TransferBy` int(4) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`ADTR`),
  KEY `fk_admission_transfer` (`ADMID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `appointment`
--

CREATE TABLE IF NOT EXISTS `appointment` (
  `APPID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) DEFAULT NULL,
  `VDate` varchar(25) NOT NULL,
  `VTime` varchar(25) NOT NULL,
  `Token` int(5) DEFAULT NULL,
  `Type` varchar(30) DEFAULT NULL,
  `Mode` varchar(30) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Consultant` int(11) DEFAULT NULL,
  PRIMARY KEY (`APPID`),
  KEY `fk_appointment_patient` (`PID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=102 ;

-- --------------------------------------------------------

--
-- Table structure for table `attachment`
--

CREATE TABLE IF NOT EXISTS `attachment` (
  `ATTCHID` int(11) NOT NULL AUTO_INCREMENT,
  `Attach_Type` varchar(50) DEFAULT NULL,
  `Attach_To` varchar(50) DEFAULT NULL,
  `EPISODE` int(11) NOT NULL,
  `PID` int(11) NOT NULL,
  `Attached_By` int(11) NOT NULL,
  `Attach_Description` varchar(500) DEFAULT NULL,
  `Attach_Comment` varchar(5000) DEFAULT NULL,
  `Attach_Name` varchar(500) NOT NULL,
  `Attach_Link` varchar(500) NOT NULL,
  `Attach_Hash` varchar(100) NOT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`ATTCHID`),
  KEY `fk_attachment_patient` (`PID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `attachment_comment`
--

CREATE TABLE IF NOT EXISTS `attachment_comment` (
  `ATTCH_COM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `ATTCHID` int(11) NOT NULL,
  `Comment_Date` datetime DEFAULT NULL,
  `Comment` varchar(5000) DEFAULT NULL,
  `Comment_By` int(11) NOT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`ATTCH_COM_ID`),
  KEY `fk_attachment_comment` (`ATTCHID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=32 ;

-- --------------------------------------------------------

--
-- Table structure for table `canned_text`
--

CREATE TABLE IF NOT EXISTS `canned_text` (
  `CTEXTID` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(200) NOT NULL,
  `Text` varchar(200) DEFAULT NULL,
  `Remarks` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`CTEXTID`),
  UNIQUE KEY `Code` (`Code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=492 ;

-- --------------------------------------------------------

--
-- Table structure for table `clinic`
--

CREATE TABLE IF NOT EXISTS `clinic` (
  `clinic_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `drug_stock` int(11) NOT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `applicable_to` varchar(10) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`clinic_id`),
  KEY `fk_clinic_stock` (`drug_stock`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_diagram`
--

CREATE TABLE IF NOT EXISTS `clinic_diagram` (
  `clinic_diagram_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT NULL,
  `diagram_link` varchar(200) DEFAULT NULL,
  `diagram_name` varchar(200) DEFAULT NULL,
  `diagram_hash` varchar(50) DEFAULT NULL,
  `diagram_type` varchar(20) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `width` int(5) DEFAULT NULL,
  `height` int(5) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`clinic_diagram_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_patient`
--

CREATE TABLE IF NOT EXISTS `clinic_patient` (
  `clinic_patient_id` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) NOT NULL,
  `clinic_id` int(11) NOT NULL,
  `status` varchar(30) NOT NULL,
  `next_visit_date` date DEFAULT NULL,
  `next_visit_time` time DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `remarks` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`clinic_patient_id`),
  KEY `fk_clinic` (`clinic_id`),
  KEY `fk_clinic_patient` (`PID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=30 ;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_prescribe_items`
--

CREATE TABLE IF NOT EXISTS `clinic_prescribe_items` (
  `clinic_prescribe_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `clinic_prescription_id` int(11) NOT NULL,
  `DRGID` int(11) DEFAULT NULL,
  `Dosage` varchar(100) DEFAULT NULL,
  `HowLong` varchar(100) DEFAULT NULL,
  `Remarks` varchar(200) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Frequency` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`clinic_prescribe_item_id`),
  KEY `DRGID` (`DRGID`),
  KEY `fk_clinic_prescribe_items` (`clinic_prescription_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=60 ;

-- --------------------------------------------------------

--
-- Table structure for table `clinic_prescription`
--

CREATE TABLE IF NOT EXISTS `clinic_prescription` (
  `clinic_prescription_id` int(11) NOT NULL AUTO_INCREMENT,
  `Dept` varchar(200) DEFAULT NULL,
  `clinic_patient_id` int(11) NOT NULL,
  `PID` int(11) DEFAULT NULL,
  `PrescribeDate` datetime DEFAULT NULL,
  `PrescribeBy` varchar(200) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`clinic_prescription_id`),
  KEY `fk_clinic_presciption` (`clinic_patient_id`),
  KEY `fk_patient_clinic_presciption` (`PID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=24 ;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE IF NOT EXISTS `complaints` (
  `COMPID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) DEFAULT NULL,
  `isNotify` tinyint(1) DEFAULT '0',
  `Type` varchar(200) DEFAULT NULL,
  `ICDLink` varchar(200) DEFAULT NULL,
  `Remarks` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`COMPID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=457 ;

-- --------------------------------------------------------

--
-- Table structure for table `disorder`
--

CREATE TABLE IF NOT EXISTS `disorder` (
  `DISORDERID` int(11) NOT NULL AUTO_INCREMENT,
  `CONCEPTID` int(11) NOT NULL,
  `DESCRIPTIONID` int(11) DEFAULT NULL,
  `DESCRIPTIONSTATUS` int(11) DEFAULT NULL,
  `TERM` varchar(200) DEFAULT NULL,
  `INITIALCAPITALSTATUS` varchar(200) DEFAULT NULL,
  `DESCRIPTIONTYPE` varchar(200) DEFAULT NULL,
  `LANGUAGECODE` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Link_ICD_Code` varchar(20) DEFAULT NULL,
  `Link_ICD_Text` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`DISORDERID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=155257 ;

-- --------------------------------------------------------

--
-- Table structure for table `district`
--

CREATE TABLE IF NOT EXISTS `district` (
  `DISTRICTID` int(11) NOT NULL AUTO_INCREMENT,
  `DistrictName` varchar(50) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Code` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`DISTRICTID`),
  UNIQUE KEY `DistrictName` (`DistrictName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `drugs`
--

CREATE TABLE IF NOT EXISTS `drugs` (
  `DRGID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(130) NOT NULL,
  `Stock` int(11) DEFAULT NULL,
  `Remarks` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Frequency` varchar(50) DEFAULT NULL,
  `dFrequency` varchar(50) DEFAULT NULL,
  `dDosage` varchar(50) DEFAULT NULL,
  `Type` varchar(50) DEFAULT NULL,
  `ClinicStock` int(10) DEFAULT '0',
  PRIMARY KEY (`DRGID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=174 ;

-- --------------------------------------------------------

--
-- Table structure for table `drugs_dosage`
--

CREATE TABLE IF NOT EXISTS `drugs_dosage` (
  `DDSGID` int(11) NOT NULL AUTO_INCREMENT,
  `Dosage` varchar(50) DEFAULT NULL,
  `Factor` varchar(5) DEFAULT NULL,
  `Type` varchar(50) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`DDSGID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `drugs_frequency`
--

CREATE TABLE IF NOT EXISTS `drugs_frequency` (
  `DFQYID` int(11) NOT NULL AUTO_INCREMENT,
  `Frequency` varchar(50) DEFAULT NULL,
  `Factor` varchar(5) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`DFQYID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `drug_count`
--

CREATE TABLE IF NOT EXISTS `drug_count` (
  `drug_count_id` int(11) NOT NULL AUTO_INCREMENT,
  `drug_stock_id` int(11) NOT NULL,
  `who_drug_id` int(11) NOT NULL,
  `who_drug_count` int(11) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`drug_count_id`),
  KEY `fk_drug_count_stock` (`drug_stock_id`),
  KEY `fk_who_drug_count` (`who_drug_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=318 ;

-- --------------------------------------------------------

--
-- Table structure for table `drug_stock`
--

CREATE TABLE IF NOT EXISTS `drug_stock` (
  `drug_stock_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `alert_out_of_stock` tinyint(1) DEFAULT '1',
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`drug_stock_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `dsd_division`
--

CREATE TABLE IF NOT EXISTS `dsd_division` (
  `DSDIVISIONID` int(11) NOT NULL AUTO_INCREMENT,
  `DSDivisionName` varchar(50) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Code` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`DSDIVISIONID`),
  UNIQUE KEY `DSDivisionName` (`DSDivisionName`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE IF NOT EXISTS `event` (
  `EVENTID` int(11) NOT NULL AUTO_INCREMENT,
  `CONCEPTID` int(11) NOT NULL,
  `DESCRIPTIONID` int(11) DEFAULT NULL,
  `DESCRIPTIONSTATUS` int(11) DEFAULT NULL,
  `TERM` varchar(200) DEFAULT NULL,
  `INITIALCAPITALSTATUS` varchar(200) DEFAULT NULL,
  `DESCRIPTIONTYPE` varchar(200) DEFAULT NULL,
  `LANGUAGECODE` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Link_ICD_Code` varchar(20) DEFAULT NULL,
  `Link_ICD_Text` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`EVENTID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10587 ;

-- --------------------------------------------------------

--
-- Table structure for table `finding`
--

CREATE TABLE IF NOT EXISTS `finding` (
  `FINDID` int(11) NOT NULL AUTO_INCREMENT,
  `CONCEPTID` int(11) NOT NULL,
  `DESCRIPTIONID` int(11) DEFAULT NULL,
  `DESCRIPTIONSTATUS` int(11) DEFAULT NULL,
  `TERM` varchar(200) DEFAULT NULL,
  `INITIALCAPITALSTATUS` varchar(200) DEFAULT NULL,
  `DESCRIPTIONTYPE` varchar(200) DEFAULT NULL,
  `LANGUAGECODE` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Link_ICD_Code` varchar(20) DEFAULT NULL,
  `Link_ICD_Text` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`FINDID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=67684 ;

-- --------------------------------------------------------

--
-- Table structure for table `hospital`
--

CREATE TABLE IF NOT EXISTS `hospital` (
  `HID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(130) DEFAULT NULL,
  `Telephone1` varchar(20) DEFAULT NULL,
  `Telephone2` varchar(20) DEFAULT NULL,
  `Address_Street` varchar(20) DEFAULT NULL,
  `Address_Village` varchar(20) DEFAULT NULL,
  `Address_DSDivision` varchar(20) DEFAULT NULL,
  `Address_District` varchar(20) DEFAULT NULL,
  `Address_Country` varchar(20) DEFAULT NULL,
  `Address_ZIP` int(11) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Code` varchar(10) DEFAULT NULL,
  `Type` varchar(30) DEFAULT NULL,
  `Current_BHT` varchar(50) DEFAULT NULL,
  `Display_Drug_Count` tinyint(1) DEFAULT NULL,
  `Display_Zero_Drug_Count` tinyint(1) DEFAULT NULL,
  `Dispense_Drug_Count` tinyint(1) DEFAULT NULL,
  `Display_Previous_Drug` tinyint(1) DEFAULT NULL,
  `Use_One_Field_Name` tinyint(1) DEFAULT NULL,
  `Use_Calendar_DOB` tinyint(1) DEFAULT NULL,
  `Instant_Validation` tinyint(1) DEFAULT NULL,
  `Number_NIC_Validation` tinyint(1) DEFAULT NULL,
  `LIC_Info` varchar(200) DEFAULT NULL,
  `Visit_ICD_Field` tinyint(1) DEFAULT NULL,
  `occupation_field` tinyint(4) NOT NULL DEFAULT '0',
  `Visit_SNOMED_Field` tinyint(1) DEFAULT NULL,
  `Token_Footer_Text` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`HID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `icd10`
--

CREATE TABLE IF NOT EXISTS `icd10` (
  `ICDID` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(10) DEFAULT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `isNotify` tinyint(1) DEFAULT '0',
  `Remarks` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`ICDID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18777 ;

-- --------------------------------------------------------

--
-- Table structure for table `immr`
--

CREATE TABLE IF NOT EXISTS `immr` (
  `IMMRID` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(10) DEFAULT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `Category` varchar(200) DEFAULT NULL,
  `ICDCODE` varchar(400) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`IMMRID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=278 ;

-- --------------------------------------------------------

--
-- Table structure for table `injection`
--

CREATE TABLE IF NOT EXISTS `injection` (
  `injection_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `dosage` varchar(30) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`injection_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `institution`
--

CREATE TABLE IF NOT EXISTS `institution` (
  `INSTID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(130) DEFAULT NULL,
  `Contact_Person` varchar(130) DEFAULT NULL,
  `Code` varchar(10) DEFAULT NULL,
  `Type` varchar(30) DEFAULT NULL,
  `Email1` varchar(30) DEFAULT NULL,
  `Email2` varchar(30) DEFAULT NULL,
  `Telephone1` varchar(20) DEFAULT NULL,
  `Telephone2` varchar(20) DEFAULT NULL,
  `Address_Street` varchar(20) DEFAULT NULL,
  `Address_Village` varchar(20) DEFAULT NULL,
  `Address_DSDivision` varchar(20) DEFAULT NULL,
  `Address_District` varchar(20) DEFAULT NULL,
  `Address_Country` varchar(20) DEFAULT NULL,
  `Address_ZIP` int(11) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`INSTID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `lab_order`
--

CREATE TABLE IF NOT EXISTS `lab_order` (
  `LAB_ORDER_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Dept` varchar(200) DEFAULT NULL,
  `OBJID` int(11) NOT NULL,
  `PID` int(11) DEFAULT NULL,
  `OrderDate` datetime DEFAULT NULL,
  `OrderBy` varchar(200) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `Priority` varchar(20) DEFAULT NULL,
  `TestGroupName` varchar(100) DEFAULT NULL,
  `CollectionDateTime` varchar(15) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `O_PID` varchar(100) DEFAULT NULL,
  `Collection_Status` varchar(10) DEFAULT NULL,
  `CollectBy` varchar(200) DEFAULT NULL,
  `Remarks` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`LAB_ORDER_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `lab_order_items`
--

CREATE TABLE IF NOT EXISTS `lab_order_items` (
  `LAB_ORDER_ITEM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `LAB_ORDER_ID` int(11) NOT NULL,
  `LABID` int(11) DEFAULT NULL,
  `TestValue` varchar(200) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`LAB_ORDER_ITEM_ID`),
  KEY `LABID` (`LABID`),
  KEY `LAB_ORDER_ID` (`LAB_ORDER_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=154 ;

-- --------------------------------------------------------

--
-- Table structure for table `lab_tests`
--

CREATE TABLE IF NOT EXISTS `lab_tests` (
  `LABID` int(11) NOT NULL AUTO_INCREMENT,
  `Department` varchar(200) DEFAULT NULL,
  `GroupName` varchar(200) DEFAULT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `RefValue` varchar(200) DEFAULT NULL,
  `Remarks` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`LABID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Table structure for table `lab_test_department`
--

CREATE TABLE IF NOT EXISTS `lab_test_department` (
  `LABDEPTID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`LABDEPTID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `lab_test_group`
--

CREATE TABLE IF NOT EXISTS `lab_test_group` (
  `LABGRPTID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`LABGRPTID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE IF NOT EXISTS `notification` (
  `NOTIFICATION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `EPISODEID` int(11) NOT NULL,
  `PID` varchar(100) NOT NULL,
  `FROMID` varchar(100) NOT NULL,
  `TOID` varchar(100) NOT NULL,
  `Episode_Type` varchar(100) NOT NULL,
  `Disease` varchar(200) NOT NULL,
  `LabConfirm` tinyint(1) DEFAULT '0',
  `Confirmed` tinyint(1) DEFAULT '0',
  `Remarks` varchar(1000) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `ConfirmedBy` varchar(200) DEFAULT NULL,
  `notificationDate` datetime DEFAULT NULL,
  `Status` varchar(50) DEFAULT NULL,
  `SentTo` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`NOTIFICATION_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=43 ;

-- --------------------------------------------------------

--
-- Table structure for table `opd_notes`
--

CREATE TABLE IF NOT EXISTS `opd_notes` (
  `opd_notes_id` int(11) NOT NULL AUTO_INCREMENT,
  `notes` varchar(500) NOT NULL,
  `OPDID` int(11) NOT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`opd_notes_id`),
  KEY `fk_opd_notes` (`OPDID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `opd_presciption`
--

CREATE TABLE IF NOT EXISTS `opd_presciption` (
  `PRSID` int(11) NOT NULL AUTO_INCREMENT,
  `Dept` varchar(200) DEFAULT NULL,
  `OPDID` int(11) NOT NULL,
  `PID` int(11) DEFAULT NULL,
  `PrescribeDate` datetime DEFAULT NULL,
  `PrescribeBy` varchar(200) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `O_PID` varchar(100) DEFAULT NULL,
  `GetFrom` varchar(30) DEFAULT 'Stock',
  PRIMARY KEY (`PRSID`),
  KEY `fk_visit_opd_presciption` (`OPDID`),
  KEY `fk_patient_opd_presciption` (`PID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=39 ;

-- --------------------------------------------------------

--
-- Table structure for table `opd_treatment`
--

CREATE TABLE IF NOT EXISTS `opd_treatment` (
  `OPDTREATMENTID` int(11) NOT NULL AUTO_INCREMENT,
  `OPDID` int(11) NOT NULL,
  `Treatment` varchar(500) DEFAULT NULL,
  `Status` varchar(1000) DEFAULT NULL,
  `Remarks` varchar(1000) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `TREATMENTID` int(11) NOT NULL,
  PRIMARY KEY (`OPDTREATMENTID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=61 ;

-- --------------------------------------------------------

--
-- Table structure for table `opd_visits`
--

CREATE TABLE IF NOT EXISTS `opd_visits` (
  `OPDID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) DEFAULT NULL,
  `OLD_OPDID` int(11) DEFAULT NULL,
  `DateTimeOfVisit` datetime DEFAULT NULL,
  `OnSetDate` date DEFAULT NULL,
  `Complaint` varchar(200) DEFAULT NULL,
  `ICD_Code` varchar(10) DEFAULT NULL,
  `ICD_Text` varchar(200) DEFAULT NULL,
  `SNOMED_Code` varchar(10) DEFAULT NULL,
  `Doctor` int(11) DEFAULT NULL,
  `Remarks` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `isNotify` tinyint(1) DEFAULT '0',
  `SNOMED_Text` varchar(500) DEFAULT NULL,
  `VisitType` int(20) DEFAULT NULL,
  `O_PID` varchar(100) DEFAULT NULL,
  `referred_admission_id` int(11) DEFAULT NULL,
  `is_refered` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`OPDID`),
  KEY `fk_opd_visits_patient` (`PID`),
  KEY `fk_opd_doctor` (`Doctor`),
  KEY `fk_referred_admission` (`referred_admission_id`),
  KEY `fk_VisitType` (`VisitType`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=667 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `PID` int(11) NOT NULL AUTO_INCREMENT,
  `LPID` int(11) NOT NULL,
  `HID` int(11) NOT NULL,
  `Old_PID` int(11) DEFAULT NULL,
  `CStatus` varchar(10) DEFAULT NULL,
  `Cward` int(5) DEFAULT NULL,
  `Personal_Title` varchar(10) DEFAULT NULL,
  `Full_Name_Registered` varchar(50) NOT NULL,
  `Personal_Used_Name` varchar(50) DEFAULT NULL,
  `NIC` varchar(15) DEFAULT NULL,
  `occupation` varchar(30) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Age` varchar(20) DEFAULT NULL,
  `Telephone` varchar(20) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `Personal_Civil_Status` varchar(10) DEFAULT NULL,
  `Personal_Preferred_Language` varchar(10) DEFAULT NULL,
  `Citizenship` varchar(5) DEFAULT NULL,
  `ContactPerson` varchar(200) DEFAULT NULL,
  `Birth_Address_Street` varchar(20) DEFAULT NULL,
  `Birth_Address_Village` varchar(20) DEFAULT NULL,
  `Birth_Address_DSDivision` varchar(20) DEFAULT NULL,
  `Birth_Address_District` varchar(20) DEFAULT NULL,
  `Birth_Address_Country` varchar(20) DEFAULT NULL,
  `Birth_Address_ZIP` int(11) DEFAULT NULL,
  `Address_Street` varchar(200) DEFAULT NULL,
  `Address_Village` varchar(50) DEFAULT NULL,
  `Address_DSDivision` varchar(20) DEFAULT NULL,
  `Address_District` varchar(20) DEFAULT NULL,
  `Address_Country` varchar(20) DEFAULT NULL,
  `Address_ZIP` int(11) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Remarks` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Address_Street1` varchar(200) DEFAULT NULL,
  `DeathDate` varchar(30) DEFAULT NULL,
  `HIN` varchar(12) NOT NULL,
  PRIMARY KEY (`PID`),
  KEY `IX_LPID` (`LPID`),
  KEY `IX_NAME` (`Full_Name_Registered`(5)),
  KEY `HIN` (`HIN`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=189 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_alergy`
--

CREATE TABLE IF NOT EXISTS `patient_alergy` (
  `ALERGYID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) DEFAULT NULL,
  `Name` varchar(200) DEFAULT NULL,
  `Status` varchar(50) NOT NULL,
  `Remarks` varchar(200) NOT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `O_PID` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`ALERGYID`),
  KEY `fk_patient_alergy` (`PID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_exam`
--

CREATE TABLE IF NOT EXISTS `patient_exam` (
  `PATEXAMID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) DEFAULT NULL,
  `Weight` int(4) DEFAULT NULL,
  `Height` varchar(5) NOT NULL,
  `sys_BP` int(4) DEFAULT NULL,
  `diast_BP` int(4) DEFAULT NULL,
  `Temprature` varchar(5) NOT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `ExamDate` datetime DEFAULT NULL,
  `O_PID` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`PATEXAMID`),
  KEY `fk_patient_exam` (`PID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=89 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_history`
--

CREATE TABLE IF NOT EXISTS `patient_history` (
  `PATHISTORYID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) DEFAULT NULL,
  `History_Type` varchar(50) DEFAULT NULL,
  `SNOMED_Code` varchar(20) DEFAULT NULL,
  `SNOMED_Text` varchar(200) DEFAULT NULL,
  `Remarks` varchar(200) NOT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `HistoryDate` varchar(50) DEFAULT NULL,
  `O_PID` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`PATHISTORYID`),
  KEY `fk_patient_history` (`PID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=83 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_injection`
--

CREATE TABLE IF NOT EXISTS `patient_injection` (
  `patient_injection_id` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) NOT NULL,
  `injection_id` int(11) NOT NULL,
  `order_by_id` int(11) NOT NULL,
  `complete_by_id` int(11) NOT NULL,
  `status` varchar(11) NOT NULL,
  `episode_type` varchar(11) NOT NULL,
  `episode_id` varchar(11) NOT NULL,
  `complete_date` datetime DEFAULT NULL,
  `remarks` varchar(100) NOT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`patient_injection_id`),
  KEY `fk_patient_injection` (`PID`),
  KEY `fk_injection` (`injection_id`),
  KEY `fk_order_by` (`order_by_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `patient_notes`
--

CREATE TABLE IF NOT EXISTS `patient_notes` (
  `patient_notes_id` int(11) NOT NULL AUTO_INCREMENT,
  `notes` varchar(500) NOT NULL,
  `PID` int(11) NOT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`patient_notes_id`),
  KEY `fk_patient_notes` (`PID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `PRMID` int(11) NOT NULL AUTO_INCREMENT,
  `UserGroup` varchar(200) NOT NULL,
  `UserAccess` longtext,
  `Remarks` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`PRMID`),
  UNIQUE KEY `UserGroup` (`UserGroup`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `prescribe_items`
--

CREATE TABLE IF NOT EXISTS `prescribe_items` (
  `PRS_ITEM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PRES_ID` int(11) NOT NULL,
  `DRGID` int(11) DEFAULT NULL,
  `Dosage` varchar(100) DEFAULT NULL,
  `HowLong` varchar(100) DEFAULT NULL,
  `Remarks` varchar(200) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Frequency` varchar(50) DEFAULT NULL,
  `drug_list` text,
  PRIMARY KEY (`PRS_ITEM_ID`),
  KEY `DRGID` (`DRGID`),
  KEY `PRES_ID` (`PRES_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=136 ;

-- --------------------------------------------------------

--
-- Table structure for table `procedures`
--

CREATE TABLE IF NOT EXISTS `procedures` (
  `PROCEDUREID` int(11) NOT NULL AUTO_INCREMENT,
  `CONCEPTID` int(11) NOT NULL,
  `DESCRIPTIONID` int(11) DEFAULT NULL,
  `DESCRIPTIONSTATUS` int(11) DEFAULT NULL,
  `TERM` varchar(200) DEFAULT NULL,
  `INITIALCAPITALSTATUS` varchar(200) DEFAULT NULL,
  `DESCRIPTIONTYPE` varchar(200) DEFAULT NULL,
  `LANGUAGECODE` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Link_ICD_Code` varchar(20) DEFAULT NULL,
  `Link_ICD_Text` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`PROCEDUREID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `qb_bill`
--

CREATE TABLE IF NOT EXISTS `qb_bill` (
  `QB_BILL_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) NOT NULL,
  `Status` varchar(10) DEFAULT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `Type` varchar(100) DEFAULT NULL,
  `EPISODE` int(11) NOT NULL,
  `Total` float(8,2) DEFAULT NULL,
  `TotalPaid` float(8,2) DEFAULT NULL,
  `Balance` float(8,2) DEFAULT NULL,
  `PayMode` varchar(50) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `CRTE_UID` int(11) NOT NULL,
  `RESV_UID` int(11) DEFAULT NULL,
  `DatePaid` datetime DEFAULT NULL,
  `Hash` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`QB_BILL_ID`),
  KEY `fk_patient_bill` (`PID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=118 ;

-- --------------------------------------------------------

--
-- Table structure for table `qb_bill_item`
--

CREATE TABLE IF NOT EXISTS `qb_bill_item` (
  `QB_BILL_ITEM_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(500) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `UnitPrize` float(8,2) DEFAULT NULL,
  `TotalPrize` float(8,2) NOT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `CRTE_UID` int(11) NOT NULL,
  `Hash` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `QB_BILL_ID` int(11) NOT NULL,
  `Type` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`QB_BILL_ITEM_ID`),
  KEY `fk_qb_bill_item` (`QB_BILL_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=494 ;

-- --------------------------------------------------------

--
-- Table structure for table `qb_conf`
--

CREATE TABLE IF NOT EXISTS `qb_conf` (
  `QB_CONF_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Currency` varchar(5) DEFAULT NULL,
  `Vat` float(8,2) DEFAULT NULL,
  `HospitalCommision` float(8,2) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`QB_CONF_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `qb_consult_fee`
--

CREATE TABLE IF NOT EXISTS `qb_consult_fee` (
  `QB_CONST_FEE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Consultant` int(11) DEFAULT NULL,
  `WeekDayFee` int(11) DEFAULT NULL,
  `WeekEndDayFee` int(11) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `HospitalCommision` float(8,2) DEFAULT '0.00',
  PRIMARY KEY (`QB_CONST_FEE_ID`),
  UNIQUE KEY `Consultant` (`Consultant`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `qb_drug_cost`
--

CREATE TABLE IF NOT EXISTS `qb_drug_cost` (
  `QB_DRUG_COST_ID` int(11) NOT NULL AUTO_INCREMENT,
  `DRUG_ID` int(11) DEFAULT NULL,
  `Cost` float(8,2) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Name` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`QB_DRUG_COST_ID`),
  UNIQUE KEY `DRUG_ID` (`DRUG_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=129 ;

-- --------------------------------------------------------

--
-- Table structure for table `qb_lab_cost`
--

CREATE TABLE IF NOT EXISTS `qb_lab_cost` (
  `QB_LAB_COST_ID` int(11) NOT NULL AUTO_INCREMENT,
  `LAB_ID` int(11) DEFAULT NULL,
  `Cost` float(8,2) DEFAULT NULL,
  `Name` varchar(300) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`QB_LAB_COST_ID`),
  UNIQUE KEY `LAB_ID` (`LAB_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=56 ;

-- --------------------------------------------------------

--
-- Table structure for table `qb_opd_procedure_cost`
--

CREATE TABLE IF NOT EXISTS `qb_opd_procedure_cost` (
  `QB_PROC_COST_ID` int(11) NOT NULL AUTO_INCREMENT,
  `PROC_ID` int(11) DEFAULT NULL,
  `Cost` float(8,2) DEFAULT NULL,
  `Name` varchar(300) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`QB_PROC_COST_ID`),
  UNIQUE KEY `PROC_ID` (`PROC_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `qb_staff_payment`
--

CREATE TABLE IF NOT EXISTS `qb_staff_payment` (
  `QB_STAFF_PAY_ID` int(11) NOT NULL AUTO_INCREMENT,
  `QB_BILL_ID` int(11) NOT NULL,
  `Type` varchar(500) DEFAULT NULL,
  `DateCreate` datetime DEFAULT NULL,
  `DatePaid` datetime DEFAULT NULL,
  `STAFF_ID` int(11) NOT NULL,
  `DoctorAmount` float(8,2) NOT NULL,
  `HospitalAmount` float(8,2) NOT NULL,
  `HospitalCommision` float(8,2) DEFAULT '0.00',
  `Status` varchar(10) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`QB_STAFF_PAY_ID`),
  KEY `fk_qb_staff_payment_bill` (`QB_BILL_ID`),
  KEY `fk_qb_staff_payment` (`STAFF_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=49 ;

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire`
--

CREATE TABLE IF NOT EXISTS `questionnaire` (
  `QUES_ID` int(11) NOT NULL AUTO_INCREMENT,
  `QUES_ST_ID` int(11) DEFAULT NULL,
  `Date` datetime DEFAULT NULL,
  `Type` varchar(100) DEFAULT NULL,
  `OBID` int(11) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`QUES_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `questionnaire_data`
--

CREATE TABLE IF NOT EXISTS `questionnaire_data` (
  `QUES_ANS_ID` int(11) NOT NULL AUTO_INCREMENT,
  `QUES_ID` int(11) DEFAULT NULL,
  `Question` varchar(200) DEFAULT NULL,
  `Answer` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`QUES_ANS_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=161 ;

-- --------------------------------------------------------

--
-- Table structure for table `quest_flds_struct`
--

CREATE TABLE IF NOT EXISTS `quest_flds_struct` (
  `QUES_FLD_ST_ID` int(11) NOT NULL AUTO_INCREMENT,
  `QUES_ST_ID` int(11) DEFAULT NULL,
  `Field` varchar(200) DEFAULT NULL,
  `Type` varchar(100) DEFAULT NULL,
  `PValue` varchar(1000) DEFAULT NULL,
  `DValue` varchar(100) DEFAULT NULL,
  `Help` varchar(2000) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`QUES_FLD_ST_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `quest_struct`
--

CREATE TABLE IF NOT EXISTS `quest_struct` (
  `QUES_ST_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) DEFAULT NULL,
  `Type` varchar(100) DEFAULT NULL,
  `Remarks` varchar(2000) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `VisitType` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`QUES_ST_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `qu_answer`
--

CREATE TABLE IF NOT EXISTS `qu_answer` (
  `qu_answer_id` int(11) NOT NULL,
  `qu_question_id` int(11) NOT NULL,
  `qu_quest_answer_id` int(11) NOT NULL,
  `answer` varchar(50) NOT NULL,
  `answer_type` varchar(50) NOT NULL,
  `answer_order` int(11) NOT NULL,
  `CreateDate` datetime NOT NULL,
  `CreateUser` varchar(50) DEFAULT NULL,
  `LastUpDate` datetime NOT NULL,
  `LastUpDateUser` varchar(50) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`qu_answer_id`),
  KEY `fk_qu_answer` (`qu_quest_answer_id`),
  KEY `fk_qu_question_respo` (`qu_question_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `qu_module`
--

CREATE TABLE IF NOT EXISTS `qu_module` (
  `qu_module_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(11) NOT NULL,
  `code` varchar(10) NOT NULL,
  `description` varchar(100) NOT NULL,
  `CreateDate` datetime NOT NULL,
  `CreateUser` varchar(50) DEFAULT NULL,
  `LastUpDate` datetime NOT NULL,
  `LastUpDateUser` varchar(50) DEFAULT NULL,
  `applicable_to` varchar(10) DEFAULT NULL,
  `show_in_patient` tinyint(1) DEFAULT NULL,
  `show_in_admission` tinyint(1) DEFAULT NULL,
  `show_in_visit` int(11) DEFAULT NULL,
  `show_in_Clinic` int(11) DEFAULT NULL,
  `link_to` varchar(10) DEFAULT NULL,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY (`qu_module_id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `qu_question`
--

CREATE TABLE IF NOT EXISTS `qu_question` (
  `qu_question_id` int(11) NOT NULL AUTO_INCREMENT,
  `qu_questionnaire_id` int(11) NOT NULL,
  `CreateDate` datetime NOT NULL,
  `CreateUser` varchar(50) DEFAULT NULL,
  `LastUpDate` datetime NOT NULL,
  `LastUpDateUser` varchar(50) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `qu_question_repos_id` int(11) NOT NULL,
  `show_order` int(11) NOT NULL,
  PRIMARY KEY (`qu_question_id`),
  KEY `fk_qu_questionnaire_question` (`qu_questionnaire_id`),
  KEY `fk_qu_questionnaire_question_repos` (`qu_question_repos_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=96926729 ;

-- --------------------------------------------------------

--
-- Table structure for table `qu_questionnaire`
--

CREATE TABLE IF NOT EXISTS `qu_questionnaire` (
  `qu_questionnaire_id` int(11) NOT NULL AUTO_INCREMENT,
  `qu_module_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `code` varchar(10) NOT NULL,
  `description` varchar(100) NOT NULL,
  `CreateDate` datetime NOT NULL,
  `CreateUser` varchar(50) DEFAULT NULL,
  `LastUpDate` datetime NOT NULL,
  `LastUpDateUser` varchar(50) DEFAULT NULL,
  `applicable_to` varchar(10) DEFAULT NULL,
  `show_in_patient` tinyint(1) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `show_in_admission` tinyint(1) NOT NULL,
  `show_in_visit` int(11) DEFAULT NULL,
  `show_in_clinic` int(11) NOT NULL,
  PRIMARY KEY (`qu_questionnaire_id`),
  UNIQUE KEY `code` (`code`),
  KEY `fk_qu_clinic` (`show_in_clinic`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=66042617 ;

-- --------------------------------------------------------

--
-- Table structure for table `qu_question_repos`
--

CREATE TABLE IF NOT EXISTS `qu_question_repos` (
  `qu_question_repos_id` int(11) NOT NULL AUTO_INCREMENT,
  `question` varchar(50) NOT NULL,
  `code` varchar(10) NOT NULL,
  `question_type` varchar(20) NOT NULL,
  `default_ans` varchar(100) NOT NULL,
  `help` varchar(100) NOT NULL,
  `CreateDate` datetime NOT NULL,
  `CreateUser` varchar(50) DEFAULT NULL,
  `LastUpDate` datetime NOT NULL,
  `LastUpDateUser` varchar(50) DEFAULT NULL,
  `applicable_to` varchar(10) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  `qu_group` varchar(20) NOT NULL,
  PRIMARY KEY (`qu_question_repos_id`),
  UNIQUE KEY `code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=93502511 ;

-- --------------------------------------------------------

--
-- Table structure for table `qu_quest_answer`
--

CREATE TABLE IF NOT EXISTS `qu_quest_answer` (
  `qu_quest_answer_id` int(11) NOT NULL,
  `qu_questionnaire_id` int(11) NOT NULL,
  `link_type` varchar(30) NOT NULL,
  `link_id` int(11) NOT NULL,
  `CreateDate` datetime NOT NULL,
  `CreateUser` varchar(50) DEFAULT NULL,
  `LastUpDate` datetime NOT NULL,
  `LastUpDateUser` varchar(50) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`qu_quest_answer_id`),
  KEY `fk_qqu_quest_answer` (`qu_questionnaire_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `qu_select`
--

CREATE TABLE IF NOT EXISTS `qu_select` (
  `qu_select_id` int(11) NOT NULL AUTO_INCREMENT,
  `qu_question_id` int(11) NOT NULL,
  `select_text` varchar(50) NOT NULL,
  `select_value` varchar(50) NOT NULL,
  `select_default` varchar(50) NOT NULL,
  `help` varchar(100) NOT NULL,
  `CreateDate` datetime NOT NULL,
  `CreateUser` varchar(50) DEFAULT NULL,
  `LastUpDate` datetime NOT NULL,
  `LastUpDateUser` varchar(50) DEFAULT NULL,
  `active` tinyint(1) NOT NULL,
  PRIMARY KEY (`qu_select_id`),
  KEY `fk_qu_select_question_repos` (`qu_question_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=98400485 ;

-- --------------------------------------------------------

--
-- Table structure for table `recent_patient`
--

CREATE TABLE IF NOT EXISTS `recent_patient` (
  `RPID` int(11) NOT NULL AUTO_INCREMENT,
  `PID` int(11) DEFAULT NULL,
  `UID` int(11) DEFAULT NULL,
  `Page` varchar(100) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `O_PID` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`RPID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=557 ;

-- --------------------------------------------------------

--
-- Table structure for table `snomed`
--

CREATE TABLE IF NOT EXISTS `snomed` (
  `SNOMEDID` int(11) NOT NULL AUTO_INCREMENT,
  `CONCEPTID` int(11) NOT NULL,
  `DESCRIPTIONID` int(11) DEFAULT NULL,
  `DESCRIPTIONSTATUS` int(11) DEFAULT NULL,
  `TERM` varchar(200) DEFAULT NULL,
  `INITIALCAPITALSTATUS` varchar(200) DEFAULT NULL,
  `DESCRIPTIONTYPE` varchar(200) DEFAULT NULL,
  `LANGUAGECODE` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`SNOMEDID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `snomed_map`
--

CREATE TABLE IF NOT EXISTS `snomed_map` (
  `MAPID` int(11) NOT NULL AUTO_INCREMENT,
  `CONCEPTID` int(11) NOT NULL,
  `ICDMAP` varchar(50) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`MAPID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=131940 ;

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE IF NOT EXISTS `treatment` (
  `TREATMENTID` int(11) NOT NULL AUTO_INCREMENT,
  `Treatment` varchar(500) DEFAULT NULL,
  `Remarks` varchar(1000) DEFAULT NULL,
  `Type` varchar(20) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`TREATMENTID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `HID` int(11) NOT NULL,
  `Title` varchar(10) DEFAULT NULL,
  `FirstName` varchar(50) NOT NULL,
  `OtherName` varchar(50) NOT NULL,
  `NIC` varchar(12) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `CivilStatus` varchar(10) DEFAULT NULL,
  `Gender` varchar(10) DEFAULT NULL,
  `Post` varchar(20) DEFAULT NULL,
  `UserName` varchar(50) NOT NULL,
  `UserGroup` varchar(50) NOT NULL DEFAULT 'User',
  `Password` varchar(50) NOT NULL,
  `DefaultLanguage` varchar(10) DEFAULT NULL,
  `Telephone` varchar(20) DEFAULT NULL,
  `Address_Street` varchar(20) DEFAULT NULL,
  `Address_Village` varchar(20) DEFAULT NULL,
  `Address_DSDivision` varchar(20) DEFAULT NULL,
  `Address_District` varchar(20) DEFAULT NULL,
  `Address_Country` varchar(20) DEFAULT NULL,
  `Address_ZIP` int(11) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Speciality` varchar(50) DEFAULT NULL,
  `LastTimeSeen` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Status` varchar(50) DEFAULT NULL,
  `last_prescription_cmd` varchar(20) NOT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `UserName` (`UserName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=91 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_chat_message`
--

CREATE TABLE IF NOT EXISTS `user_chat_message` (
  `CHAT_MESSAGE_ID` int(11) NOT NULL AUTO_INCREMENT,
  `FROM_ID` int(11) NOT NULL,
  `TO_ID` int(11) NOT NULL,
  `Session_Id` varchar(100) NOT NULL,
  `SentAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Message` varchar(500) DEFAULT NULL,
  `Seen` tinyint(4) NOT NULL,
  PRIMARY KEY (`CHAT_MESSAGE_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=121 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_chat_session`
--

CREATE TABLE IF NOT EXISTS `user_chat_session` (
  `CHAT_CHAT_SESSION_ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER1_ID` int(11) NOT NULL,
  `USER2_ID` int(11) NOT NULL,
  `Session_Id` varchar(100) NOT NULL,
  `CreatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ClosedAt` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `Status` varchar(500) DEFAULT NULL,
  PRIMARY KEY (`CHAT_CHAT_SESSION_ID`),
  KEY `Session_Id` (`Session_Id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_favour_drug`
--

CREATE TABLE IF NOT EXISTS `user_favour_drug` (
  `user_favour_drug_id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`user_favour_drug_id`),
  KEY `fk_user_favour_drug` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_favour_drug_items`
--

CREATE TABLE IF NOT EXISTS `user_favour_drug_items` (
  `user_favour_drug_items_id` int(11) NOT NULL AUTO_INCREMENT,
  `who_drug_id` int(11) NOT NULL,
  `user_favour_drug_id` int(11) NOT NULL,
  `frequency` varchar(50) NOT NULL,
  `how_long` varchar(50) NOT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`user_favour_drug_items_id`),
  KEY `fk_favour_drug` (`who_drug_id`),
  KEY `fk_user_favour_drug_items` (`user_favour_drug_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=73 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_group`
--

CREATE TABLE IF NOT EXISTS `user_group` (
  `UGID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(20) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Remarks` varchar(200) DEFAULT NULL,
  `MainMenu` varchar(500) DEFAULT NULL,
  `Scan_Redirect` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`UGID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_menu`
--

CREATE TABLE IF NOT EXISTS `user_menu` (
  `UMID` int(11) NOT NULL AUTO_INCREMENT,
  `UserGroup` varchar(500) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Link` varchar(100) DEFAULT NULL,
  `MenuOrder` int(11) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`UMID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_post`
--

CREATE TABLE IF NOT EXISTS `user_post` (
  `POST_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Remarks` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`POST_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_speciality`
--

CREATE TABLE IF NOT EXISTS `user_speciality` (
  `SPEC_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Remarks` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`SPEC_ID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `village`
--

CREATE TABLE IF NOT EXISTS `village` (
  `VGEID` int(11) NOT NULL AUTO_INCREMENT,
  `Province` varchar(50) DEFAULT NULL,
  `District` varchar(50) DEFAULT NULL,
  `DSDivision` varchar(50) DEFAULT NULL,
  `GNDivision` varchar(50) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Code` varchar(15) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`VGEID`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13832 ;

-- --------------------------------------------------------

--
-- Table structure for table `visit_type`
--

CREATE TABLE IF NOT EXISTS `visit_type` (
  `VTYPID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(200) NOT NULL,
  `Remarks` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  `Stock` int(30) DEFAULT NULL,
  PRIMARY KEY (`VTYPID`),
  UNIQUE KEY `Name` (`Name`),
  KEY `fk_stock` (`Stock`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `ward`
--

CREATE TABLE IF NOT EXISTS `ward` (
  `WID` int(5) NOT NULL AUTO_INCREMENT,
  `HID` int(5) NOT NULL,
  `Name` varchar(200) NOT NULL,
  `Telephone` varchar(15) DEFAULT NULL,
  `BedCount` int(5) DEFAULT NULL,
  `Remarks` varchar(200) DEFAULT NULL,
  `Type` varchar(200) DEFAULT NULL,
  `CreateDate` datetime DEFAULT NULL,
  `CreateUser` varchar(200) DEFAULT NULL,
  `LastUpDate` datetime DEFAULT NULL,
  `LastUpDateUser` varchar(200) DEFAULT NULL,
  `Active` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`WID`),
  UNIQUE KEY `Name` (`Name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

-- --------------------------------------------------------

--
-- Table structure for table `who_drug`
--

CREATE TABLE IF NOT EXISTS `who_drug` (
  `wd_id` int(11) NOT NULL AUTO_INCREMENT,
  `group` varchar(97) DEFAULT NULL,
  `sub_group` varchar(83) DEFAULT NULL,
  `name` varchar(61) DEFAULT NULL,
  `formulation` varchar(126) DEFAULT NULL,
  `dose` varchar(10) NOT NULL,
  `default_num` varchar(10) NOT NULL,
  `default_timing` varchar(10) NOT NULL,
  `remarks` varchar(156) DEFAULT NULL,
  `CreateDate` varchar(10) DEFAULT NULL,
  `CreateUser` varchar(10) DEFAULT NULL,
  `LastUpDateUser` varchar(10) DEFAULT NULL,
  `LastUpDate` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`wd_id`),
  UNIQUE KEY `wd_id` (`wd_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=107 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admission`
--
ALTER TABLE `admission`
  ADD CONSTRAINT `fk_admission_patient` FOREIGN KEY (`PID`) REFERENCES `patient` (`PID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_doctor` FOREIGN KEY (`Doctor`) REFERENCES `user` (`UID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ward` FOREIGN KEY (`Ward`) REFERENCES `ward` (`WID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_ward_admit` FOREIGN KEY (`AdmitTo`) REFERENCES `ward` (`WID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `admission_diagnosis`
--
ALTER TABLE `admission_diagnosis`
  ADD CONSTRAINT `fk_diagnosis_admission` FOREIGN KEY (`ADMID`) REFERENCES `admission` (`ADMID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `admission_notes`
--
ALTER TABLE `admission_notes`
  ADD CONSTRAINT `fk_admission_notes` FOREIGN KEY (`ADMID`) REFERENCES `admission` (`ADMID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `admission_procedures`
--
ALTER TABLE `admission_procedures`
  ADD CONSTRAINT `fk_admission_procedures` FOREIGN KEY (`ADMID`) REFERENCES `admission` (`ADMID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `admission_transfer`
--
ALTER TABLE `admission_transfer`
  ADD CONSTRAINT `fk_admission_transfer` FOREIGN KEY (`ADMID`) REFERENCES `admission` (`ADMID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `appointment`
--
ALTER TABLE `appointment`
  ADD CONSTRAINT `fk_appointment_patient` FOREIGN KEY (`PID`) REFERENCES `patient` (`PID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `attachment`
--
ALTER TABLE `attachment`
  ADD CONSTRAINT `fk_attachment_patient` FOREIGN KEY (`PID`) REFERENCES `patient` (`PID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `attachment_comment`
--
ALTER TABLE `attachment_comment`
  ADD CONSTRAINT `fk_attachment_comment` FOREIGN KEY (`ATTCHID`) REFERENCES `attachment` (`ATTCHID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `clinic`
--
ALTER TABLE `clinic`
  ADD CONSTRAINT `fk_clinic_stock` FOREIGN KEY (`drug_stock`) REFERENCES `drug_stock` (`drug_stock_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `clinic_patient`
--
ALTER TABLE `clinic_patient`
  ADD CONSTRAINT `fk_clinic` FOREIGN KEY (`clinic_id`) REFERENCES `clinic` (`clinic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_clinic_patient` FOREIGN KEY (`PID`) REFERENCES `patient` (`PID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `clinic_prescribe_items`
--
ALTER TABLE `clinic_prescribe_items`
  ADD CONSTRAINT `fk_clinic_prescribe_items` FOREIGN KEY (`clinic_prescription_id`) REFERENCES `clinic_prescription` (`clinic_prescription_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `clinic_prescription`
--
ALTER TABLE `clinic_prescription`
  ADD CONSTRAINT `fk_clinic_presciption` FOREIGN KEY (`clinic_patient_id`) REFERENCES `clinic_patient` (`clinic_patient_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_patient_clinic_presciption` FOREIGN KEY (`PID`) REFERENCES `patient` (`PID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `drug_count`
--
ALTER TABLE `drug_count`
  ADD CONSTRAINT `fk_drug_count_stock` FOREIGN KEY (`drug_stock_id`) REFERENCES `drug_stock` (`drug_stock_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_who_drug_count` FOREIGN KEY (`who_drug_id`) REFERENCES `who_drug` (`wd_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `lab_order_items`
--
ALTER TABLE `lab_order_items`
  ADD CONSTRAINT `fk_lab_order_items` FOREIGN KEY (`LAB_ORDER_ID`) REFERENCES `lab_order` (`LAB_ORDER_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `opd_notes`
--
ALTER TABLE `opd_notes`
  ADD CONSTRAINT `fk_opd_notes` FOREIGN KEY (`OPDID`) REFERENCES `opd_visits` (`OPDID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `opd_presciption`
--
ALTER TABLE `opd_presciption`
  ADD CONSTRAINT `fk_patient_opd_presciption` FOREIGN KEY (`PID`) REFERENCES `patient` (`PID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_visit_opd_presciption` FOREIGN KEY (`OPDID`) REFERENCES `opd_visits` (`OPDID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `opd_visits`
--
ALTER TABLE `opd_visits`
  ADD CONSTRAINT `fk_opd_doctor` FOREIGN KEY (`Doctor`) REFERENCES `user` (`UID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_opd_visits_patient` FOREIGN KEY (`PID`) REFERENCES `patient` (`PID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_referred_admission` FOREIGN KEY (`referred_admission_id`) REFERENCES `admission` (`ADMID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_VisitType` FOREIGN KEY (`VisitType`) REFERENCES `visit_type` (`VTYPID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `patient_alergy`
--
ALTER TABLE `patient_alergy`
  ADD CONSTRAINT `fk_patient_alergy` FOREIGN KEY (`PID`) REFERENCES `patient` (`PID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `patient_exam`
--
ALTER TABLE `patient_exam`
  ADD CONSTRAINT `fk_patient_exam` FOREIGN KEY (`PID`) REFERENCES `patient` (`PID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `patient_history`
--
ALTER TABLE `patient_history`
  ADD CONSTRAINT `fk_patient_history` FOREIGN KEY (`PID`) REFERENCES `patient` (`PID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `patient_injection`
--
ALTER TABLE `patient_injection`
  ADD CONSTRAINT `fk_injection` FOREIGN KEY (`injection_id`) REFERENCES `injection` (`injection_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_order_by` FOREIGN KEY (`order_by_id`) REFERENCES `user` (`UID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_patient_injection` FOREIGN KEY (`PID`) REFERENCES `patient` (`PID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `patient_notes`
--
ALTER TABLE `patient_notes`
  ADD CONSTRAINT `fk_patient_notes` FOREIGN KEY (`PID`) REFERENCES `patient` (`PID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `prescribe_items`
--
ALTER TABLE `prescribe_items`
  ADD CONSTRAINT `fk_prescribe_items` FOREIGN KEY (`PRES_ID`) REFERENCES `opd_presciption` (`PRSID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `qb_bill`
--
ALTER TABLE `qb_bill`
  ADD CONSTRAINT `fk_patient_bill` FOREIGN KEY (`PID`) REFERENCES `patient` (`PID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `qb_bill_item`
--
ALTER TABLE `qb_bill_item`
  ADD CONSTRAINT `fk_qb_bill_item` FOREIGN KEY (`QB_BILL_ID`) REFERENCES `qb_bill` (`QB_BILL_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `qb_consult_fee`
--
ALTER TABLE `qb_consult_fee`
  ADD CONSTRAINT `fk_qb_consult_fee` FOREIGN KEY (`Consultant`) REFERENCES `user` (`UID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `qb_drug_cost`
--
ALTER TABLE `qb_drug_cost`
  ADD CONSTRAINT `fk_qb_drug_cost` FOREIGN KEY (`DRUG_ID`) REFERENCES `drugs` (`DRGID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `qb_lab_cost`
--
ALTER TABLE `qb_lab_cost`
  ADD CONSTRAINT `fk_qb_lab_cost` FOREIGN KEY (`LAB_ID`) REFERENCES `lab_tests` (`LABID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `qb_opd_procedure_cost`
--
ALTER TABLE `qb_opd_procedure_cost`
  ADD CONSTRAINT `fk_qb_opd_procedure_cost` FOREIGN KEY (`PROC_ID`) REFERENCES `opd_treatment` (`OPDTREATMENTID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `qb_staff_payment`
--
ALTER TABLE `qb_staff_payment`
  ADD CONSTRAINT `fk_qb_staff_payment` FOREIGN KEY (`STAFF_ID`) REFERENCES `user` (`UID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_qb_staff_payment_bill` FOREIGN KEY (`QB_BILL_ID`) REFERENCES `qb_bill` (`QB_BILL_ID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `qu_answer`
--
ALTER TABLE `qu_answer`
  ADD CONSTRAINT `fk_qu_answer` FOREIGN KEY (`qu_quest_answer_id`) REFERENCES `qu_quest_answer` (`qu_quest_answer_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_qu_question_respo` FOREIGN KEY (`qu_question_id`) REFERENCES `qu_question_repos` (`qu_question_repos_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `qu_question`
--
ALTER TABLE `qu_question`
  ADD CONSTRAINT `fk_qu_questionnaire_question` FOREIGN KEY (`qu_questionnaire_id`) REFERENCES `qu_questionnaire` (`qu_questionnaire_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_qu_questionnaire_question_repos` FOREIGN KEY (`qu_question_repos_id`) REFERENCES `qu_question_repos` (`qu_question_repos_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `qu_questionnaire`
--
ALTER TABLE `qu_questionnaire`
  ADD CONSTRAINT `fk_qu_clinic` FOREIGN KEY (`show_in_clinic`) REFERENCES `clinic` (`clinic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `qu_quest_answer`
--
ALTER TABLE `qu_quest_answer`
  ADD CONSTRAINT `fk_qqu_quest_answer` FOREIGN KEY (`qu_questionnaire_id`) REFERENCES `qu_questionnaire` (`qu_questionnaire_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `qu_select`
--
ALTER TABLE `qu_select`
  ADD CONSTRAINT `fk_qu_select_question_repos` FOREIGN KEY (`qu_question_id`) REFERENCES `qu_question_repos` (`qu_question_repos_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_favour_drug`
--
ALTER TABLE `user_favour_drug`
  ADD CONSTRAINT `fk_user_favour_drug` FOREIGN KEY (`uid`) REFERENCES `user` (`UID`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `user_favour_drug_items`
--
ALTER TABLE `user_favour_drug_items`
  ADD CONSTRAINT `fk_favour_drug` FOREIGN KEY (`who_drug_id`) REFERENCES `who_drug` (`wd_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_user_favour_drug_items` FOREIGN KEY (`user_favour_drug_id`) REFERENCES `user_favour_drug` (`user_favour_drug_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `visit_type`
--
ALTER TABLE `visit_type`
  ADD CONSTRAINT `fk_stock` FOREIGN KEY (`Stock`) REFERENCES `drug_stock` (`drug_stock_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
SET FOREIGN_KEY_CHECKS=1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
