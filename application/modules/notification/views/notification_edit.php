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
<style type="text/css">
    .opdCont {
        background: none repeat scroll 0 0 #FCFCDA;
        border: 1px solid #E0C679;
        font-family: arial;
        font-size: 12px;
        left: 200px;
        margin-top: 5px;
        padding-left: 20px;
        padding-right: 20px;
        position: relative;
        width: 75%;
    }
</style>


<div style="margin-top:60px;" class="opdCont">
    <div id="adh1" class="opdHead"> Notification of communicable disease</div>
    <div id="adb" class="lab_Cont">
        <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-color:#fcfcda;background:#fafade;"
               class="PrescriptionInfo">
            <tbody>
            <tr>
                <td colspan="4">
                    <table width="100%" cellspacing="0" cellpadding="5" border="0"
                           style="border-color:#fcfcda;background:#f6ff00;" class="">
                        <tbody>
                        <tr>
                            <td align="center" colspan="4"><b style="font-size:18px;">NOTIFICATION OF COMMUNICABLE
                                    DISEASE</b></td>
                        </tr>
                        <tr>
                            <td width="100" align="right">Institute:</td>
                            <td align="left"><?php echo $hospital ?></td>
                            <td width="150" align="right">Disease:</td>
                            <td align="left"><b style="color:red"><?php echo $opd_visits_info["Complaint"] ?></b>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Name of patient:</td>
                            <td align="left"><?php echo
                                    $patient_info["Personal_Title"] . ' ' . $patient_info["Full_Name_Registered"] . ' ('
                                    . $patient_info["HIN"] . ')' ?></td>
                            <td align="right">Date of Onset:</td>
                            <td align="left"><?php echo $opd_visits_info["OnSetDate"] ?></td>
                        </tr>
                        <tr>
                            <td align="right">Guardian:</td>
                            <td align="left">-</td>
							
                            <?php if ($epicode_type == "Admission") {
                                echo
                                    "<td  align='right'>Date of Admission:</td><td  align='left' >"
                                    . $epicode->getValue("AdmissionDate") . "</td>";
                            } ?>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <table width="100%" cellspacing="0" cellpadding="5" border="0" class="PrescriptionInfo">
                                    <tbody>
                                    <tr>
                                        <?php

                                        if ($epicode_type == "Admission") {
                                            echo "<td align='right'  nowrap>BHT No"
                                                . ":</td><td align='left' nowrap>" . $epicode->getValue("BHT")
                                                . "</td>";
                                            echo "<td align='right'  nowrap>Ward"
                                                . ":</td><td align='left' nowrap>" . $ward->getValue("Name")
                                                . "</td>";
                                        } else {
                                            if ($epicode_type == "Opd") {
                                                echo "<td align='right'  nowrap>Ward"
                                                    . ":</td><td align='left' nowrap>OPD</td>";
                                            }
                                        }
                                        ?>
                                        <td nowrap="" align="right">Age:</td>
                                        <td nowrap="" align="left"><?php 
											if ($patient_info["Age"]["years"]>0){
												echo  $patient_info["Age"]["years"]."Yrs&nbsp;";
											}
											echo  $patient_info["Age"]["months"]."Mths&nbsp;";
											echo  $patient_info["Age"]["days"]."Dys&nbsp;";
										?> </td>
                                        <td nowrap="" align="right">Sex:</td>
                                        <td nowrap="" align="left"><?php echo $patient_info["Gender"]; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
						<form method="POST" action="<?php echo site_url("notification/save"); ?>">
                        <tr>
                            <td  nowrap align="right">Laboratory Results confirmed?:</td>
                            <td align="left">
							<input type="hidden" id="Disease" name="Disease" value="<?php echo $opd_visits_info["Complaint"]; ?>"/>
							<input type="hidden" id="Episode_Type" name="Episode_Type" value="<?php echo $epicode_type; ?>"/>
							<input type="hidden" id="EPISODEID" name="EPISODEID" value="<?php echo $opd_visits_info["OPDID"]; ?>"/>
							<input type="hidden" id="CONTINUE" name="CONTINUE" value="<?php echo (isset($_GET["CONTINUE"])?$_GET["CONTINUE"]:""); ?>"/>
							<select id="LabConfirm" name="LabConfirm">
								<option value="0">No</option>
								<option value="1">Yes</option>
							</select>
							</td>
                            <td></td>
                            <td align="left"></td>
                        </tr>
						
                        <tr>
                            <td width="100" align="right">Home Address:</td>
                            <td align="left" colspan="3"><?php 
							echo  $patient_info["Address_Street"]."&nbsp;";
							echo  $patient_info["Address_Street1"]."<br>";
							echo  $patient_info["Address_Village"]."<br>";
							//echo  $patient_info["Address_DSDivision"]."<br>";
							echo  $patient_info["Address_District"]."<br>";
							?>
                            </td>
                        </tr>
                        <tr>
                            <td width="100" nowrap="" align="right">Patient's Home Telephone:</td>
                            <td align="left" colspan="3"><?php echo $patient_info["Telephone"]; ?></td>
                        </tr>
                        <tr>
                            <td width="100" nowrap="" align="right">Remarks:</td>
                            <td align="left" colspan="3">
							<textarea id="Remarks" name="Remarks"><?php echo $patient_info["Remarks"]; ?></textarea>
							</td>
                        </tr>
                        <tr>
                            <td width="100" nowrap="" align="right">Date of Notification:</td>
                            <td align="left" colspan="3"><?php echo date(DATE_RFC822) ?></td>
                        </tr>
                        <tr>
                            <td align="left" colspan="4">Notification Confirmed by: 
								<?php
									echo $opd_visits_info["Doctor"];
								?>	
                             </td>
                        </tr>
						
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" colspan="4"><br>
					<input type="submit" class="btn btn-default" value="Save"/>
					<input type="button"  class="btn btn-default" value="Cancel" onclick="window.history.back(1);"/>
                </td>
            </tr>
			</form>
            </tbody>
        </table>
    </div>
</div>