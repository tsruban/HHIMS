<?php if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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

if (!function_exists('mdate')) {
    function dob_to_age($dob)
    {
        $date = new DateTime($dob);
        $now = new DateTime();
        $interval = $now->diff($date);
        return $interval->y . 'Y' . $interval->m . 'M' . $interval->d . 'D';
    }
}

function mdsGetDate($date)
{
    if (!$date) {
        return;
    }
    $ar = explode(' ', $date);
    return $ar[0];
}

$ha4 = 260;
function getHospitalCode()
{
    $hid = $_SESSION['HID'];
    return $hid;
}

function mdsTrim($longtext, $n)
{

    $newstr = preg_replace('/[\x00-\x1F\x7F]/', ' ', $longtext);
    if (strlen($newstr) > $n) {
        $newstr = str_split($newstr, $n);
        $newstr = $newstr[0] . '...';
    }
    return $newstr;
}

//return time from '2011-06-13 11:43:02' fromat string
function mdsGetTime($date)
{
    if (!$date) {
        return;
    }
    $ar = explode(' ', $date);

    return $ar[1];
}


function _date_range_limit($start, $end, $adj, $a, $b, $result)
{
    if ($result[$a] < $start) {
        $result[$b] -= intval(($start - $result[$a] - 1) / $adj) + 1;
        $result[$a] += $adj * intval(($start - $result[$a] - 1) / $adj + 1);
    }

    if ($result[$a] >= $end) {
        $result[$b] += intval($result[$a] / $adj);
        $result[$a] -= $adj * intval($result[$a] / $adj);
    }

    return $result;
}

function _date_range_limit_days(&$base, &$result)
{
    $days_in_month_leap = array(31, 31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    $days_in_month = array(31, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    _date_range_limit(1, 13, 12, "m", "y", $base);

    $year = $base["y"];
    $month = $base["m"];

    if (!$result["invert"]) {
        while ($result["d"] < 0) {
            $month--;
            if ($month < 1) {
                $month += 12;
                $year--;
            }

            $leapyear = $year % 400 == 0 || ($year % 100 != 0 && $year % 4 == 0);
            $days = $leapyear ? $days_in_month_leap[$month] : $days_in_month[$month];

            $result["d"] += $days;
            $result["m"]--;
        }
    } else {
        while ($result["d"] < 0) {
            $leapyear = $year % 400 == 0 || ($year % 100 != 0 && $year % 4 == 0);
            $days = $leapyear ? $days_in_month_leap[$month] : $days_in_month[$month];

            $result["d"] += $days;
            $result["m"]--;

            $month++;
            if ($month > 12) {
                $month -= 12;
                $year++;
            }
        }
    }

    return $result;
}

function _date_normalize(&$base, &$result)
{
    $result = _date_range_limit(0, 60, 60, "s", "i", $result);
    $result = _date_range_limit(0, 60, 60, "i", "h", $result);
    $result = _date_range_limit(0, 24, 24, "h", "d", $result);
    $result = _date_range_limit(0, 12, 12, "m", "y", $result);

    $result = _date_range_limit_days($base, $result);

    $result = _date_range_limit(0, 12, 12, "m", "y", $result);

    return $result;
}

function currentQuarter()
{
    $n = date('n');
    if ($n < 4) {
        return "1";
    } elseif ($n > 3 && $n < 7) {
        return "2";
    } elseif ($n > 6 && $n < 10) {
        return "3";
    } elseif ($n > 9) {
        return "4";
    }
}