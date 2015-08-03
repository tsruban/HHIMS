<?php

/*
--------------------------------------------------------------------------------
HHIMS - Hospital Health Information Management System
Copyright (c) 2011 Information and Communication Technology Agency of Sri Lanka
<http: www.hhims.org/>
----------------------------------------------------------------------------------
This program is free software: you can redistribute it and/or modify it under the
terms of the GNU Affero General Public License as published by the Free Software 
Foundation, either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,but WITHOUT ANY 
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR 
A PARTICULAR PURPOSE. See the GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License along 
with this program. If not, see <http://www.gnu.org/licenses/> or write to:
Free Software  HHIMS
C/- Lunar Technologies (PVT) Ltd,
15B Fullerton Estate II,
Gamagoda, Kalutara, Sri Lanka
---------------------------------------------------------------------------------- 
Author: Mr. Thurairajasingam Senthilruban   TSRuban[AT]mdsfoss.org
Consultant: Dr. Denham Pole                 DrPole[AT]gmail.com
URL: http: www.hhims.org
----------------------------------------------------------------------------------
*/


include_once 'application/libraries/class/fpdf/fpdf.php';
class MDSReporter extends FPDF
{

    private $widths;
    private $aligns;
    private $dy = 5;
    private $dx = 40;
    private $formNum = '';
    private $pagerWidth = 0;
    private $pageWidth = 0;
    private $footer = true;

    function __construct($data)
    {
        parent::__construct($data['orientation'], $data['unit'], $data['format']);
        $footer = $data['footer'];
        $this->AliasNbPages();
        $this->formNum = $this->formNum;
        $this->pageWidth = $this->w - $this->lMargin - $this->rMargin;
        $this->footer = $footer;
        // 		$this->SetMargins(10, 25);
        //        define('FPDF_FONTPATH', 'include/form_templates/fpdf/font/');
        if(!defined('FPDF_FONTPATH')){
            define('FPDF_FONTPATH', 'application/libraries/class/fpdf/font/');
        }
        $this->AddFont('arial', '', 'arial.php');
        $this->AddFont('arial', 'B', 'arialbd.php');
        $this->AddFont('arial', 'BI', 'arialbi.php');
        $this->AddFont('arial', 'I', 'ariali.php');
        $this->AddFont('akandynew', '', 'akandynew.php');
    }

//	function __construct($orientation='P', $unit='mm', $format='A4', $footer=true) {
//		parent::__construct($orientation, $unit, $format);
//		$this->AliasNbPages();
//		$this->formNum = $this->formNum;
//		$this->pageWidth = $this->w - $this->lMargin - $this->rMargin;
//		$this->footer = $footer;
//		// 		$this->SetMargins(10, 25);
//		//        define('FPDF_FONTPATH', 'include/form_templates/fpdf/font/');
//		define('FPDF_FONTPATH', 'fpdf/font/');
//		$this->AddFont('arial', '', 'arial.php');
//		$this->AddFont('arial', 'B', 'arialbd.php');
//		$this->AddFont('arial', 'BI', 'arialbi.php');
//		$this->AddFont('arial', 'I', 'ariali.php');
//		$this->AddFont('akandynew', '', 'akandynew.php');
//        $this->load->library('class/fpdf/fpdf');
//	}

    //barcode starts
    function Code39($x, $y, $code, $ext = true, $cks = false, $w = 0.4, $h = 10, $wide = false, $text = true)
    {

        //Display code
        if ($text) {
            $this->SetFont('Arial', '', 10);
            $this->Text($x, $y + $h + 4, $code);
        }


        if ($ext) {
            //Extended encoding
            $code = $this->encode_code39_ext($code);
        } else {
            //Convert to upper case
            $code = strtoupper($code);
            //Check validity
            if (!preg_match('|^[0-9A-Z. $/+%-]*$|', $code)) {
                $this->Error('Invalid barcode value: ' . $code);
            }
        }

        //Compute checksum
        if ($cks) {
            $code .= $this->checksum_code39($code);
        }

        //Add start and stop characters
        $code = '*' . $code . '*';

        //Conversion tables
        $narrow_encoding = array(
            '0' => '101001101101', '1' => '110100101011', '2' => '101100101011',
            '3' => '110110010101', '4' => '101001101011', '5' => '110100110101',
            '6' => '101100110101', '7' => '101001011011', '8' => '110100101101',
            '9' => '101100101101', 'A' => '110101001011', 'B' => '101101001011',
            'C' => '110110100101', 'D' => '101011001011', 'E' => '110101100101',
            'F' => '101101100101', 'G' => '101010011011', 'H' => '110101001101',
            'I' => '101101001101', 'J' => '101011001101', 'K' => '110101010011',
            'L' => '101101010011', 'M' => '110110101001', 'N' => '101011010011',
            'O' => '110101101001', 'P' => '101101101001', 'Q' => '101010110011',
            'R' => '110101011001', 'S' => '101101011001', 'T' => '101011011001',
            'U' => '110010101011', 'V' => '100110101011', 'W' => '110011010101',
            'X' => '100101101011', 'Y' => '110010110101', 'Z' => '100110110101',
            '-' => '100101011011', '.' => '110010101101', ' ' => '100110101101',
            '*' => '100101101101', '$' => '100100100101', '/' => '100100101001',
            '+' => '100101001001', '%' => '101001001001');

        $wide_encoding = array(
            '0' => '101000111011101', '1' => '111010001010111', '2' => '101110001010111',
            '3' => '111011100010101', '4' => '101000111010111', '5' => '111010001110101',
            '6' => '101110001110101', '7' => '101000101110111', '8' => '111010001011101',
            '9' => '101110001011101', 'A' => '111010100010111', 'B' => '101110100010111',
            'C' => '111011101000101', 'D' => '101011100010111', 'E' => '111010111000101',
            'F' => '101110111000101', 'G' => '101010001110111', 'H' => '111010100011101',
            'I' => '101110100011101', 'J' => '101011100011101', 'K' => '111010101000111',
            'L' => '101110101000111', 'M' => '111011101010001', 'N' => '101011101000111',
            'O' => '111010111010001', 'P' => '101110111010001', 'Q' => '101010111000111',
            'R' => '111010101110001', 'S' => '101110101110001', 'T' => '101011101110001',
            'U' => '111000101010111', 'V' => '100011101010111', 'W' => '111000111010101',
            'X' => '100010111010111', 'Y' => '111000101110101', 'Z' => '100011101110101',
            '-' => '100010101110111', '.' => '111000101011101', ' ' => '100011101011101',
            '*' => '100010111011101', '$' => '100010001000101', '/' => '100010001010001',
            '+' => '100010100010001', '%' => '101000100010001');

        $encoding = $wide ? $wide_encoding : $narrow_encoding;

        //Inter-character spacing
        $gap = ($w > 0.29) ? '00' : '0';

        //Convert to bars
        $encode = '';
        for ($i = 0; $i < strlen($code); $i++) {
            $encode .= $encoding[$code[$i]] . $gap;
        }

        //Draw bars
        $this->draw_code39($encode, $x, $y, $w, $h);
    }

    function checksum_code39($code)
    {

        //Compute the modulo 43 checksum

        $chars = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
                       'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K',
                       'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V',
                       'W', 'X', 'Y', 'Z', '-', '.', ' ', '$', '/', '+', '%');
        $sum = 0;
        for ($i = 0; $i < strlen($code); $i++) {
            $a = array_keys($chars, $code[$i]);
            $sum += $a[0];
        }
        $r = $sum % 43;
        return $chars[$r];
    }

    function encode_code39_ext($code)
    {
        //Encode characters in extended mode
        $encode = array(
            chr(0)   => '%U', chr(1) => '$A', chr(2) => '$B', chr(3) => '$C',
            chr(4)   => '$D', chr(5) => '$E', chr(6) => '$F', chr(7) => '$G',
            chr(8)   => '$H', chr(9) => '$I', chr(10) => '$J', chr(11) => '�K',
            chr(12)  => '$L', chr(13) => '$M', chr(14) => '$N', chr(15) => '$O',
            chr(16)  => '$P', chr(17) => '$Q', chr(18) => '$R', chr(19) => '$S',
            chr(20)  => '$T', chr(21) => '$U', chr(22) => '$V', chr(23) => '$W',
            chr(24)  => '$X', chr(25) => '$Y', chr(26) => '$Z', chr(27) => '%A',
            chr(28)  => '%B', chr(29) => '%C', chr(30) => '%D', chr(31) => '%E',
            chr(32)  => ' ', chr(33) => '/A', chr(34) => '/B', chr(35) => '/C',
            chr(36)  => '/D', chr(37) => '/E', chr(38) => '/F', chr(39) => '/G',
            chr(40)  => '/H', chr(41) => '/I', chr(42) => '/J', chr(43) => '/K',
            chr(44)  => '/L', chr(45) => '-', chr(46) => '.', chr(47) => '/O',
            chr(48)  => '0', chr(49) => '1', chr(50) => '2', chr(51) => '3',
            chr(52)  => '4', chr(53) => '5', chr(54) => '6', chr(55) => '7',
            chr(56)  => '8', chr(57) => '9', chr(58) => '/Z', chr(59) => '%F',
            chr(60)  => '%G', chr(61) => '%H', chr(62) => '%I', chr(63) => '%J',
            chr(64)  => '%V', chr(65) => 'A', chr(66) => 'B', chr(67) => 'C',
            chr(68)  => 'D', chr(69) => 'E', chr(70) => 'F', chr(71) => 'G',
            chr(72)  => 'H', chr(73) => 'I', chr(74) => 'J', chr(75) => 'K',
            chr(76)  => 'L', chr(77) => 'M', chr(78) => 'N', chr(79) => 'O',
            chr(80)  => 'P', chr(81) => 'Q', chr(82) => 'R', chr(83) => 'S',
            chr(84)  => 'T', chr(85) => 'U', chr(86) => 'V', chr(87) => 'W',
            chr(88)  => 'X', chr(89) => 'Y', chr(90) => 'Z', chr(91) => '%K',
            chr(92)  => '%L', chr(93) => '%M', chr(94) => '%N', chr(95) => '%O',
            chr(96)  => '%W', chr(97) => '+A', chr(98) => '+B', chr(99) => '+C',
            chr(100) => '+D', chr(101) => '+E', chr(102) => '+F', chr(103) => '+G',
            chr(104) => '+H', chr(105) => '+I', chr(106) => '+J', chr(107) => '+K',
            chr(108) => '+L', chr(109) => '+M', chr(110) => '+N', chr(111) => '+O',
            chr(112) => '+P', chr(113) => '+Q', chr(114) => '+R', chr(115) => '+S',
            chr(116) => '+T', chr(117) => '+U', chr(118) => '+V', chr(119) => '+W',
            chr(120) => '+X', chr(121) => '+Y', chr(122) => '+Z', chr(123) => '%P',
            chr(124) => '%Q', chr(125) => '%R', chr(126) => '%S', chr(127) => '%T');

        $code_ext = '';
        for ($i = 0; $i < strlen($code); $i++) {
            if (ord($code[$i]) > 127) {
                $this->Error('Invalid character: ' . $code[$i]);
            }
            $code_ext .= $encode[$code[$i]];
        }
        return $code_ext;
    }

    function draw_code39($code, $x, $y, $w, $h)
    {

        //Draw bars

        for ($i = 0; $i < strlen($code); $i++) {
            if ($code[$i] == '1') {
                $this->Rect($x + $i * $w, $y, $w, $h, 'F');
            }
        }
    }

    function getBarcodeWidth($code, $ext = true, $cks = false, $w = 0.4, $h = 10, $wide = false)
    {

        if ($ext) {
            //Extended encoding
            $code = $this->encode_code39_ext($code);
        } else {
            //Convert to upper case
            $code = strtoupper($code);
            //Check validity
            if (!preg_match('|^[0-9A-Z. $/+%-]*$|', $code)) {
                $this->Error('Invalid barcode value: ' . $code);
            }
        }

        //Compute checksum
        if ($cks) {
            $code .= $this->checksum_code39($code);
        }

        //Add start and stop characters
        $code = '*' . $code . '*';

        //Conversion tables
        $narrow_encoding = array(
            '0' => '101001101101', '1' => '110100101011', '2' => '101100101011',
            '3' => '110110010101', '4' => '101001101011', '5' => '110100110101',
            '6' => '101100110101', '7' => '101001011011', '8' => '110100101101',
            '9' => '101100101101', 'A' => '110101001011', 'B' => '101101001011',
            'C' => '110110100101', 'D' => '101011001011', 'E' => '110101100101',
            'F' => '101101100101', 'G' => '101010011011', 'H' => '110101001101',
            'I' => '101101001101', 'J' => '101011001101', 'K' => '110101010011',
            'L' => '101101010011', 'M' => '110110101001', 'N' => '101011010011',
            'O' => '110101101001', 'P' => '101101101001', 'Q' => '101010110011',
            'R' => '110101011001', 'S' => '101101011001', 'T' => '101011011001',
            'U' => '110010101011', 'V' => '100110101011', 'W' => '110011010101',
            'X' => '100101101011', 'Y' => '110010110101', 'Z' => '100110110101',
            '-' => '100101011011', '.' => '110010101101', ' ' => '100110101101',
            '*' => '100101101101', '$' => '100100100101', '/' => '100100101001',
            '+' => '100101001001', '%' => '101001001001');

        $wide_encoding = array(
            '0' => '101000111011101', '1' => '111010001010111', '2' => '101110001010111',
            '3' => '111011100010101', '4' => '101000111010111', '5' => '111010001110101',
            '6' => '101110001110101', '7' => '101000101110111', '8' => '111010001011101',
            '9' => '101110001011101', 'A' => '111010100010111', 'B' => '101110100010111',
            'C' => '111011101000101', 'D' => '101011100010111', 'E' => '111010111000101',
            'F' => '101110111000101', 'G' => '101010001110111', 'H' => '111010100011101',
            'I' => '101110100011101', 'J' => '101011100011101', 'K' => '111010101000111',
            'L' => '101110101000111', 'M' => '111011101010001', 'N' => '101011101000111',
            'O' => '111010111010001', 'P' => '101110111010001', 'Q' => '101010111000111',
            'R' => '111010101110001', 'S' => '101110101110001', 'T' => '101011101110001',
            'U' => '111000101010111', 'V' => '100011101010111', 'W' => '111000111010101',
            'X' => '100010111010111', 'Y' => '111000101110101', 'Z' => '100011101110101',
            '-' => '100010101110111', '.' => '111000101011101', ' ' => '100011101011101',
            '*' => '100010111011101', '$' => '100010001000101', '/' => '100010001010001',
            '+' => '100010100010001', '%' => '101000100010001');

        $encoding = $wide ? $wide_encoding : $narrow_encoding;

        //Inter-character spacing
        $gap = ($w > 0.29) ? '00' : '0';

        //Convert to bars
        $encode = '';
        for ($i = 0; $i < strlen($code); $i++) {
            $encode .= $encoding[$code[$i]] . $gap;
        }

        $width = 0;
        for ($i = 0; $i < strlen($encode); $i++) {
            $width += $w;
        }
        return $width;
    }

    //barcode ends

    public function setBarcode($barcode, $x = 0, $y = 0, $frame = false, $pb = 30, $text = true)
    {
        $this->CheckPageBreak($pb);
        $this->Ln();
        $width = $this->getBarcodeWidth($barcode);
        $x = $x == 0 ? $this->pageWidth - $width : $x;
        $y = $y == 0 ? $this->GetY() : $y;

        if ($frame) {
            $this->Code39($x, $y, $barcode, true, false, 0.4, 10, false, $text);

            $this->Rect($x - 5, $y + 2, $width + 10, 30);
        } else {
            $this->Code39($x, $y, $barcode, true, false, 0.4, 10, false, $text);
        }

        $this->SetY($y + 30);
    }

    public function getAsPercentage($value)
    {
        $p = $this->pageWidth / 100;
        $w = $p * $value;
        return $w;
    }

    public function Write($h, $txt, $link = '')
    {
        //        $this->SetFont('arial','',10);
        parent::Write($h, $txt, $link);
    }

    public function getFormNum()
    {
        return $this->formNum;
    }

    public function setFormNum($formNum)
    {
        $this->formNum = $formNum;
    }

    public function Footer()
    {
        if ($this->footer) {
            $dat_d = date('d/m/Y@h:i A');
            $this->SetY(-20);
            $this->SetTextColor(100);
            $this->SetFont('arial', 'I', 8);
            $this->MultiCell(0, 6, $dat_d . '~Page ' . $this->PageNo() . '/{nb}', 'T', 'C');
        }
    }

    public function Header()
    {
        $this->SetTextColor(100);
        $this->SetY(0);
        $this->SetFont('arial', 'I', 8);
        $this->MultiCell(0, 6, $this->getFormNum(), 0, 'R');
    }

    function mysqlReport($sql, $colTitles, $colWidths)
    {
        require_once '../config.php';
        $this->Ln();
        $currentPageWidth = $this->pageWidth;
        $link = mysql_connect(HOST, USERNAME, PASSWORD) or
            die("Could not connect: " . mysql_error());
        mysql_select_db(DB);
        $result = mysql_query($sql);
        $numOfRows = mysql_num_rows($result);
        if ($numOfRows == 0) {
            $this->Write(6, 'No Result Found.');
            return;
        } else {
            if ($numOfRows > 1000) {
                $this->SetTextColor(255, 0, 0);
                $this->SetFontSize(20);
                $this->Write(6, "the selected table contains more than 1000 rows of data.!");
                return;
            }
        }
        $colProp = array();
        $numOfFields = mysql_num_fields($result);
        $totalLength = 0;
        $colNames = array();
        $widths = array();
        $avarageWidth = $this->pageWidth / $numOfFields;


        $maxWidths = array();
        while ($row = mysql_fetch_array($result)) {
            for ($i = 0; $i < $numOfFields; $i++) {
                $name = $colTitles[$i];
                $d = $row[$i];
                $w1 = $this->GetStringWidth($d);
                $w2 = $maxWidths[$name];
                if ($w1 > $w2) {
                    $maxWidths[$name] = $w1;
                }
            }
        }

        $feciableWidths = array();
        $totalLength = array_sum($maxWidths);

        for ($i = 0; $i < $numOfFields; $i++) {
            $name = $colTitles[$i];
            $nameWidth = $this->GetStringWidth($name);
            $maxWidth = $maxWidths[$name];

            if ($nameWidth > $maxWidth) {
                $nameWidth += 2;
                $feciableWidths[$name] = $nameWidth;
                $currentPageWidth -= $nameWidth;
                $totalLength -= $maxWidth;
            }
        }
        $aWidths = array();
        for ($i = 0; $i < $numOfFields; $i++) {
            //            echo $i . ':' . $totalLength . ' :B: ' . $currentPageWidth . '<br>';

            $name = $colTitles[$i];
            $nameWidth = $this->GetStringWidth($name);
            $maxWidth = $maxWidths[$name];
            if ($nameWidth < $maxWidth) {
                $r = $maxWidth / $totalLength;
                $columnWidth = $r * $currentPageWidth;
                $aWidths[$name] = $columnWidth;
            } else {
                $aWidths[$name] = $feciableWidths[$name];
            }


            //            echo $i . ':' . $totalLength . ' :A: ' . $currentPageWidth . '<br>';
        }

        //        print_r($aWidths);
        //        echo '<br>Page width=' . $this->pageWidth . ':Column widths=' . array_sum($aWidths);


        if ($colWidths && count($colWidths) == $numOfFields) {
            $this->SetWidths($colWidths);
        } else {
            $this->SetWidths(array_values($aWidths));
        }
        if ($colTitles && count($colTitles) == $numOfFields) {
            $this->Row($colTitles, true);
        } else {
            $this->Row($colNames, true);
        }

        $result = mysql_query($sql);
        while ($row = mysql_fetch_array($result)) {
            $this->Row($row);
        }


        mysql_close($link);
    }

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns = $a;
    }

    function setDy($dy)
    {
        $this->dy = $dy;
    }

    function setDx($dx)
    {
        $this->dx = $dx;
    }

    function getDy()
    {
        return $this->dy;
    }

    function getDx()
    {
        return $this->dx;
    }

    function moveY($dy)
    {
        $this->SetY($this->GetY() + $dy);
    }

    function moveX($dx)
    {
        $this->SetX($this->GetX() + $dx);
    }

    function writeFieldName($name, $fsize = 10)
    {
        $this->SetFont('arial', 'B', $fsize);
        $this->moveY($this->getDy());
        $this->Write(5, $name);
    }

    function writeFieldValue($value, $fsize = 10)
    {
        $this->SetFont('arial', '', $fsize);
        $this->SetX($this->getDx());
        $this->MultiCell(0, 5, $value, 0, 'L');
    }

    function writeField($name, $value, $fsize = 10)
    {
        $this->writeFieldName($name, $fsize);
        $this->writeFieldvalue($value, $fsize);
    }

    function writeTitle($title, $y = 5, $align = 'C')
    {
        $this->SetY($y);
        $this->SetFont('arial', 'B', 14);
        $this->MultiCell(0, 8, $title, '', $align);
    }

    function writeSubTitle($stitle, $fsize = 12, $un = true, $align = 'C')
    {
        $this->SetFont('arial', 'B', $fsize);
        if ($un) {
            $this->MultiCell(0, 6, $stitle, 'B', $align);
        } else {
            $this->MultiCell(0, 6, $stitle, 0, $align);
        }
    }

    function writeSSubTitle($stitle, $fsize = 10, $un = true, $gap = 10)
    {

        if ($un) {
            $this->SetFont('arial', 'BUI', $fsize);
        } else {
            $this->SetFont('arial', 'B', $fsize);
        }
        $this->Write(13, $stitle);
        $this->Ln($gap);
        $this->SetFont('arial', '', $fsize);
    }

    function addCirtification($name='', $text = 'Signature & Designation ', $fsize = 8)
    {
        $this->CheckPageBreak(20);
        $this->SetY(-45);
        $dat_d = date('d/m/Y');
        $this->Ln();
        $this->SetFont('arial', 'B', 10);
        //        $this->MultiCell(0, 6, $text . '.....................   ' . $dat_d, 0, 'C');
        $this->SetWidths(array(75, 75));
        $this->colRRow(array($dat_d, ''), false, 10, 4);
        $this->colRRow(array('..................', '...........................................'), false, 10, 4);

        $this->colRRow(array('    Date', ' ' . $text), true);
        $this->SetWidths(array(40, 80));
        $this->SetAligns(array('L', 'R'));
        $this->colRRow(array('', $name), false, 10, 4);
    }

    function horizontalLine($h = 6)
    {
        $this->MultiCell(0, $h, '', 'B');
    }

    function Row($data, $heading = false, $fsize = 10, $dy = 5)
    {
        $this->CheckPageBreak(10);
        if ($heading) {
            $this->SetFont('arial', 'B', $fsize);
        } else {
            $this->SetFont('arial', '', $fsize);
        }
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            if (isset($this->widths[$i]) && isset($data[$i])) {
                $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
            }

        }

        $h = $dy * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            $this->Rect($x, $y, $w, $h);
            //Print the text
            if (isset($data[$i])) {
                $this->MultiCell($w, 5, $data[$i], 0, $a);
            }

            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function bottomRow($data, $heading = false, $fsize = 10, $dy = 10)
    {
        // 		$this->CheckPageBreak(25);
        if ($heading) {
            $this->SetFont('arial', 'B', $fsize);
        } else {
            $this->SetFont('arial', '', $fsize);
        }
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            if (isset($this->widths[$i]) && isset($data[$i])){
                $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
            }
        }
        $h = $dy * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = isset($this->widths[$i])?$this->widths[$i]:null;
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetFont('arial', '', $fsize);
            //                 $x1=$this->GetX();
            //                 $y1=$this->GetY();
            $this->MultiCell($w, 6, $data[$i], '', $a);
            if(isset($this->widths[$i]) && isset($data[$i])){
                $lines = $this->NbLines($this->widths[$i], $data[$i]);
            }

            for ($line = 0; $line < $lines; $line++) {
                $this->Line($x, $y + ($line + 1) * 6, $x + $w, $y + ($line + 1) * 6);
            }

            //Draw the border
            //            $this->Rect($x, $y, $w, $h);
            //Print the text
            //            $this->MultiCell($w, 10, $data[$i], 'B', $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        //         $this->write(6,'-'.($line+1)*6);
        $this->moveY(($line + 1) * 6);
    }

    /**
     *
     * draw line under each text &
     * bold odd columns.
     *
     * @param array  $data
     * @param string $heading
     * @param int    $fsize
     * @param int    $dy
     */
    function bottomRowOdd($data, $heading = false, $fsize = 10, $dy = 5, $dh = 1, $dx = 4)
    {
        // 		$this->CheckPageBreak(25);
        if ($heading) {
            $this->SetFont('arial', 'B', $fsize);
        } else {
            $this->SetFont('arial', '', $fsize);
        }
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = $dy * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            if ($i % 2 == 0) {
                $this->SetFont('arial', 'B', $fsize);
                $this->MultiCell($w, 6, $data[$i], 0, $a);
            } else {
                $this->SetFont('arial', '', $fsize);
                //                 $x1=$this->GetX();
                //                 $y1=$this->GetY();
                $this->MultiCell($w, 6, $data[$i], '', $a);
                $lines = $this->NbLines($this->widths[$i], $data[$i]);
                for ($line = 0; $line < $lines; $line++) {
                    $this->Line($x, $y + ($line + 1) * 6, $x + $w, $y + ($line + 1) * 6);
                }
            }

            //Draw the border
            //            $this->Rect($x, $y, $w, $h);
            //Print the text
            //            $this->MultiCell($w, 10, $data[$i], 'B', $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        //         $this->write(6,'-'.($line+1)*6);
        $this->moveY($h + $dh);
    }

    /**
     *
     * bold odd columns.
     *
     * @param array  $data
     * @param string $heading
     * @param int    $fsize
     * @param int    $dy
     */
    function colRow($data, $heading = false, $fsize = 10, $dy = 5, $dh = 1, $dx = 4)
    {
        //		$this->CheckPageBreak(25);
        if ($heading) {
            $this->SetFont('arial', 'B', $fsize);
        } else {
            $this->SetFont('arial', '', $fsize);
        }
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = $dy * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            if ($i % 2 == 0) {
                $this->SetFont('arial', 'B', $fsize);
                $this->MultiCell($w, $dx, $data[$i], 0, $a);
            } else {
                $this->SetFont('arial', '', $fsize);
                $this->MultiCell($w, $dx, $data[$i], '', $a);
            }
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        //         $this->moveY(($nb + 1) * $dh);
        $this->moveY($h + $dh);
    }

    function colRRow($data, $heading = false, $fsize = 10, $dy = 5)
    {
        if ($heading) {
            $this->SetFont('arial', 'B', $fsize);
        } else {
            $this->SetFont('arial', '', $fsize);
        }
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = $dy * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //            if ($i % 2 == 0)
            //                $this->SetFont('arial', 'B', $fsize);
            //            else
            //                $this->SetFont('arial', '', $fsize);
            //Draw the border
            //            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 4, $data[$i], 0, $a);
            //            $this->Cell($w,5, $data[$i], 0,0 ,$a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    /**
     *
     * draw plane row.no borders.
     *
     * @param array $data
     */
    function planeRow($data)
    {
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = 5 * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            //Draw the border
            //            $this->Rect($x, $y, $w, $h);
            //Print the text
            $this->MultiCell($w, 5, $data[$i], 0, $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    /**
     * Print text in rules.
     *
     */
    function writeTextOnRules($data, $heading = false, $fsize = 10, $dy = 5)
    {
        if ($heading) {
            $this->SetFont('arial', 'B', $fsize);
        } else {
            $this->SetFont('arial', '', $fsize);
        }
        //Calculate the height of the row
        $nb = 0;
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        }
        $h = $dy * $nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            if ($i % 2 == 0) {
                $this->SetFont('arial', 'B', $fsize);
                $this->MultiCell($w, 6, $data[$i], 0, $a);
            } else {
                $this->SetFont('arial', '', $fsize);
                $x = $this->GetX();
                $y = $this->GetY();
                $this->MultiCell($w, 6, $data[$i], '', $a);
                $lines = $this->NbLines($this->widths[$i], $data[$i]);
                for ($line = 0; $line < $lines; $line++) {
                    $this->Line($x, $y + ($line + 1) * 6, $x + $w, $y + ($line + 1) * 6);
                }
            }

            //Draw the border
            //            $this->Rect($x, $y, $w, $h);
            //Print the text
            //            $this->MultiCell($w, 10, $data[$i], 'B', $a);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger) {
            $this->AddPage($this->CurOrientation);
        }
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = & $this->CurrentFont['cw'];
        if ($w == 0) {
            $w = $this->w - $this->rMargin - $this->x;
        }
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n") {
            $nb--;
        }
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ') {
                $sep = $i;
            }
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j) {
                        $i++;
                    }
                } else {
                    $i = $sep + 1;
                }
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else {
                $i++;
            }
        }
        return $nl;
    }

    public function getPageWidth()
    {
        return $this->pageWidth;
    }

}

?>