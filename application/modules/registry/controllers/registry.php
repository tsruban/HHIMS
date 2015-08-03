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
class Registry extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checkLogin();
        $this->load->library('session');
		if(isset($_GET["mid"])){
			$this->session->set_userdata('mid', $_GET["mid"]);
		}			
    }

    public function index()
    {
        $this->admission();
    }


    public function opd($dte = null)
    {
        $dte = $dte ? $dte : date('Y-m-d');
        $data = array();
        $qry = "SELECT  opd_visits.DateTimeOfVisit,
		opd_visits.OPDID ,
		concat('(', patient.PID,') ',patient.Personal_Title, ' ',patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  as Name  ,
		concat(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(patient.DateofBirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(patient.DateofBirth, '00-%m-%d')) ,'Yrs') as age,
		patient.Gender,
		patient.Personal_Civil_Status,
		concat(patient.Address_Street,', ',patient.Address_Village,', ',Address_DSDivision,', ',Address_District) as address,
		opd_visits.VisitType
		FROM opd_visits, patient
		where (patient.PID = opd_visits.PID ) AND (opd_visits.DateTimeOfVisit LIKE '$dte%') order by opd_visits.OPDID desc";
        $result = $this->db->query($qry);
        $data['rows'] = $result->result();
        $data['caption1']
            = "HOSPITAL : " . strtoupper($this->session->userdata('Hospital')) . "<br>DATE : " . $this->getRegistryDate(
            $dte, 'opd'
        );
        $data['caption2'] = "OPD PATIENT REGISTRY BOOK";
        $this->load->vars($data);
        $this->load->view('opd');
    }

    public function admission($dte = null)
    {
        $dte = $dte ? $dte : date('Y-m-d');
        $data = array();
        $qry = "SELECT  admission.AdmissionDate,
		admission.ADMID,
		admission.BHT,
		admission.OutCome,
		concat('(', patient.PID,') ',patient.Personal_Title, ' ',patient.Full_Name_Registered,' ', patient.Personal_Used_Name)  as Name  ,
		concat(DATE_FORMAT(NOW(), '%Y') - DATE_FORMAT(patient.DateofBirth, '%Y') - (DATE_FORMAT(NOW(), '00-%m-%d') < DATE_FORMAT(patient.DateofBirth, '00-%m-%d')) ,'Yrs') as age,
		patient.Gender,
		patient.Personal_Civil_Status,
		concat(patient.Address_Street,', ',patient.Address_Village,', ',Address_DSDivision,', ',Address_District) as address,
		ward.Name as wardname
		FROM admission, patient,ward
		where  (patient.PID = admission.PID ) AND(ward.WID = admission.Ward )  AND (admission.AdmissionDate LIKE '$dte%')order by ADMID desc";
        $result = $this->db->query($qry);
        $data['rows'] = $result->result();
        $data['caption1']
            = "HOSPITAL : " . strtoupper($this->session->userdata('Hospital')) . "<br>DATE : " . $this->getRegistryDate(
            $dte
        );
        $data['caption2'] = "ADMISSION AND DISCHARGE BOOK ";
        $this->load->vars($data);
        $this->load->view('admission');
    }

    private function getRegistryDate($date, $action = 'admission')
    {
        $out = "";
        if ($this->isDateValid($date)) {
            $dte = $date;
        } else {
            $dte = date('Y-m-d');
        }
        $url = site_url("registry/$action/");
        $out = "<input type='text' name='dte' id='dte' value='$dte' style='border:0px;cursor:pointer;'>";
        $out .= "<script>\n";
        $out .= "			$('#dte').datepicker({\n";
        $out .= "				changeMonth: true,changeYear: true,yearRange: 'c-100:c+100',dateFormat: 'yy-mm-dd',maxDate: '+0D',\n";
        $out .= "				onSelect: function(dateText, inst) { \n";
        $out .= "					$(this).val(dateText); self.document.location='$url/'+dateText}\n";
        $out .= "			});\n";
        $out .= "		</script>\n";

///////////////////////////////////////////////////////
//        $out
//            .= "<script>
//			$('#dte').datepicker({
//				changeMonth: true,changeYear: true,yearRange: 'c-100:c+100',dateFormat: 'yy-mm-dd',maxDate: '+0D'
//				onSelect: function(dateText, inst) {
//					$(this).val(dateText); ";
//        $out .= "self.document.location='&book=" . $_GET["book"] . "&dte='+dateText";
//        $out
//            .= "}
//			});
//		</script>";
        return $out;
    }

    private function isDateValid($str)
    {
        $stamp = strtotime($str);
        if (!is_numeric($stamp)) {
            return FALSE;
        }
        if (checkdate(date('m', $stamp), date('d', $stamp), date('Y', $stamp))) {
            return TRUE;
        }
        return FALSE;
    }


}


//////////////////////////////////////////

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */