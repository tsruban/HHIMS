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

include("header.php"); ///loads the html HEAD section (JS,CSS)
echo Modules::run('menu'); //runs the available menu option to that usergroup
?>
<div style="width:95%;">
    <div class="row" style="margin-top:55px;">
        <div class="col-md-2 ">
            <?php echo Modules::run('leftmenu/registry'); //runs the available left menu for preferance ?>
        </div>
        <div class="col-md-10 ">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Registry</b></div>

                <?php
                echo "<div id='registry_cont'><table border=0 cellpadding=0 cellspacing=0 class='registry_book' width=100% >";
                echo "<tr>";

                echo "<td class='ttll' colspan=7  ><img src='".base_url()."/images/sl_logo_black_white.png'  valign=middle>&nbsp;&nbsp;&nbsp;&nbsp;$caption2</td>";
                echo "<td class='ttlr' colspan=2 >$caption1</td>";
                echo "</tr>";
                echo "<tr>";
                echo "<th style='border-left:1px solid #000000;'>BHT</th><th>NAME</th><th>AGE</th><th>GENDER</th><th>CIVIL STATUS</th><th>DATE OF ADMISSION</th>";
                echo "<th>STATUS</th>";
                echo "<th>ADDRESS</th>";
                echo "<th>Ward</th>";

                echo "</tr>";
                foreach ($rows as $row) {
                    echo "<tr>";
                    echo "<td class='tdl'>" . $row->BHT . "</td>";
                    echo "<td class='tdc'>" . strtoupper($row->Name) . "</td>";
                    echo "<td class='tdc'>" . strtoupper($row->age) . "</td>";
                    echo "<td class='tdc'>" . strtoupper($row->Gender) . "</td>";
                    echo "<td class='tdc'>" . strtoupper($row->Personal_Civil_Status) . "</td>";
                    echo "<td class='tdc'>" . strtoupper($row->AdmissionDate) . "</td>";
                    echo "<td class='tdc'>";
                    if ($row->OutCome == "") {
                        echo "IN";
                    } else {
                        echo strtoupper($row->OutCome);
                    }
                    echo "</td>";
                    echo "<td class='tdc'>" . strtoupper($row->address) . "</td>";
                    echo "<td class='tdc'>" . strtoupper($row->wardname) . "</td>";

                    echo "</tr>";
                }
                echo "</table ><div>";
                ?>

            </div>
        </div>
    </div>
</div>