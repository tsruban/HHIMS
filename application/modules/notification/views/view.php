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
		<?php
			if ($mode == "EDIT"){
				echo ' <form method="POST"  action="'.site_url("notification/save_email").'" >';
			}
		?>
        <table width="100%" cellspacing="2" cellpadding="5" border="0" style="border-color:#fcfcda;background:#fafade;"
               class="PrescriptionInfo">
            <tbody>
            <tr>
                <td width='25%'>To Email Address: :</td>
                <td width='75%' align="left" colspan="3">
				<?php
					if ($mode == "EDIT"){
						echo '<textarea  class="input"
						style="width:400px;" name="TOID" >'.$notification->TOID.'</textarea>';
					}
					else{
						echo '<b>'.$notification->TOID.'</b>';
					}
				?>
				
                </td>
            </tr>
            <tr>
                <td>Subject: :</td>
                <td align="left" colspan="3"><input type="text"
                                                    value="<?php echo $subject; ?>"
                                                    readonly="" style="width:400px; " class="input"></td>
            </tr>
            <tr>
                <td colspan="4">
                    <table width="100%" cellspacing="2" cellpadding="5" border="1"
                           style="border-color:#fcfcda;background:#f6ff00;" class="">
                        <tbody>
                        <tr>
                            <td align="center" colspan="4"><b style="font-size:18px;">NOTIFICATION OF COMMUNICABLE
                                    DISEASE</b></td>
                        </tr>
                        <tr>
                            <td width="100" align="right">Institute:</td>
                            <td align="left"><?php echo (isset($hospital->Name)?$hospital->Name:""); ?></td>
                            <td width="150" align="right">Disease:</td>
                            <td align="left"><?php echo $notification->Disease ?>
                            </td>
                        </tr>
                        <tr>
                            <td align="right">Name of patient:</td>
                            <td align="left"><?php echo
                                    $patient->Personal_Title . ' ' . $patient->Full_Name_Registered . ' ('
                                    . $patient->HIN . ')' ?></td>
                            <td align="right">Date of Onset:</td>
                            <td align="left">-</td>
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
                                        <td nowrap="" align="left"><?php echo $patient->getAge(); ?> </td>
                                        <td nowrap="" align="right">Sex:</td>
                                        <td nowrap="" align="left"><?php echo $patient->Gender ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td width="156" nowrap="" align="right">Laboratory Results:</td>
                            <td align="left">
							<?php 
							if ($mode == "EDIT"){
								echo '<select id="LabConfirm" name="LabConfirm" ">';
								echo '<option value="0" '.(($lab=='No')?'selected':'').' >No</option>';
								echo '<option value="1" '.(($lab=='Yes')?'selected':'').'>Yes</option>';
							echo '</select>';
							}
							else{
								echo $lab;
							}
							?></td>
                            <td align="right">
							Confirmed:
							</td>
                            <td align="left">
							<?php 
							if ($mode == "EDIT"){
								echo '<select id="Confirmed" name="Confirmed" value="'.$notification->Confirmed.'">';
								echo '<option value="0" '.(($Confirmed=='No')?'selected':'').' >No</option>';
								echo '<option value="1" '.(($Confirmed=='Yes')?'selected':'').'>Yes</option>';
								echo '</select>';
							}
							else{
								echo $Confirmed;
							}
							?>
							</td>
                        </tr>
                        <tr>
                            <td width="100" align="right">Home Address:</td>
                            <td align="left" colspan="3"><?php echo $patient->getAddress(); ?>
                            </td>
                        </tr>
                        <tr>
                            <td width="100" nowrap="" align="right">Patient's Home Telephone:</td>
                            <td align="left" colspan="3"><?php echo $patient->Telephone ?></td>
                        </tr>
                        <tr>
                            <td width="100" nowrap="" align="right">Remarks:</td>
                            <td align="left" colspan="3"><?php echo $patient->Remarks ?></td>
                        </tr>
                        <tr>
                            <td width="100" nowrap="" align="right">Date of Notification:</td>
                            <td align="left" colspan="3"><?php echo date(DATE_RFC822) ?></td>
                        </tr>
                        <tr>
                            <td align="left" colspan="4">Notification Confirmed by: <?php echo
                                    $doctor->Title . ' ' . $doctor->FirstName . ' ' . $doctor->OtherName; ?>, Sent By:
                                <?php echo $user->Title . ' ' . $user->FirstName . ' ' . $user->OtherName; ?><br><i>Automatically
                                    generated by HHMIS patient record database
                                    system. </i></td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" colspan="4">
				
					
				   <?php
						if ($mode == "EDIT"){
							echo '<input type="hidden" id="NOTIFICATION_ID" name="NOTIFICATION_ID" value="'.$notification->NOTIFICATION_ID.'">';
							echo '<button type="submit" class="btn btn-default" href="">Save</button>';
							echo '<input type="button" class="btn btn-default" onclick="history.go(-1);" value="Cancel"';
							echo '</form>';
						}
						else{
							?>
							<a class="btn btn-default" href="<?php echo site_url("notification/edit/".$notification->NOTIFICATION_ID); ?>">Edit</a>
							<a class="btn btn-default" href="<?php echo site_url("notification/send/".$notification->NOTIFICATION_ID); ?>">Send Email</a>
							<a class="btn btn-default" target="_blank" href="<?php echo site_url("report/pdf/notification/print/".$notification->NOTIFICATION_ID); ?>">Print</a>
							&nbsp;&nbsp;&nbsp;
							<input type="button" class="btn btn-default" onclick="history.go(-1);" value="Cancel">
							<?php
						}
					?>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>