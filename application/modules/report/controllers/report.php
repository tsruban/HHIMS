<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

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
class Report extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->checkLogin();
        $this->load->library('session');
        if (isset($_GET["mid"])) {
            $this->session->set_userdata('mid', $_GET["mid"]);
        }
    }

    public function index()
    {
        $this->report_home();
    }

    public function report_home($year=null,$month=null)
    {
        $data = array();
        if(!$year){
            $year=date('Y');
        }
        if(!$month){
            $month=date('m');
        }
        $data['year']=$year;
        $data['month']=$month;
        $data['calendar']=$this->render($year,$month);
        $this->load->vars($data);
        $this->load->view('report_home', 1);
    }



    public function show($year, $month, $days = array(), $day_name_length = 3, $month_href = NULL, $first_day = 0, $pn = array()){

        //// THIS METHOD NOT USED

        $first_of_month = gmmktime(0,0,0,$month,1,$year);
        $day_names = array(); #generate all the day names according to the current locale
        for($n=0,$t=(3+$first_day)*86400; $n<7; $n++,$t+=86400) #January 4, 1970 was a Sunday
            $day_names[$n] = ucfirst(gmstrftime('%A',$t)); #%A means full textual day name

        list($month, $year, $month_name, $weekday) = explode(',',gmstrftime('%m,%Y,%B,%w',$first_of_month));
        $weekday = ($weekday + 7 - $first_day) % 7; #adjust for $first_day
        $title   = htmlentities(ucfirst($month_name)).'&nbsp;'.$year;  #note that some locales don't capitalize month and day names

        @list($p, $pl) = each($pn); @list($n, $nl) = each($pn); #previous and next links, if applicable
        if($p) $p = '<span class="calendar-prev">'.($pl ? '<a href="'.htmlspecialchars($pl).'">'.$p.'</a>' : $p).'</span>&nbsp;';
        if($n) $n = '&nbsp;<span class="calendar-next">'.($nl ? '<a href="'.htmlspecialchars($nl).'">'.$n.'</a>' : $n).'</span>';
        $calendar = '<table class="calendar" border=1 >'."\n".
            '<caption class="calendar-month">'.$p.($month_href ? '<a href="'.htmlspecialchars($month_href).'">'.$title.'</a>' : $title).$n."</caption>\n<tr>";

        if($day_name_length){ #if the day names should be shown ($day_name_length > 0)
            foreach($day_names as $d)
                $calendar .= '<th abbr="'.htmlentities($d).'">'.htmlentities($day_name_length < 4 ? substr($d,0,$day_name_length) : $d).'</th>';
            $calendar .= "</tr>\n<tr>";
        }

        if($weekday > 0) $calendar .= '<td colspan="'.$weekday.'">&nbsp;</td>'; #initial 'empty' days
        for($day=1,$days_in_month=gmdate('t',$first_of_month); $day<=$days_in_month; $day++,$weekday++){
            if($weekday == 7){
                $weekday   = 0; #start a new week
                $calendar .= "</tr>\n<tr>";
            }
            if(isset($days[$day]) and is_array($days[$day])){
                @list($link, $classes, $content) = $days[$day];
                if(is_null($content))  $content  = $day;
                $calendar .= '<td'.($classes ? ' class="'.htmlspecialchars($classes).'">' : '>').
                    ($link ? '<a href="'.htmlspecialchars($link).'">'.$content.'</a>' : $content).'</td>';
            }
            else $calendar .= "<td>$day</td>";
        }
        if($weekday != 7) $calendar .= '<td colspan="'.(7-$weekday).'">&nbsp;</td>'; #remaining "empty" days

        return $calendar."</tr>\n</table>\n";
    }
    public function render($y,$m){
        if (($y <= 0)||($y <= 2000)||($m <= 0)||($m > 12)){
            $mnt=date('n');
            $yr=date('Y');
        }
        else {
            $mnt=$m;
            $yr=$y;
        }
        //  echo $mnt;
        //     echo $yr;
        // echo date('d',mktime(0,0,0,$mnt,2,$yr))."<br>";
        // echo mktime(0,0,0,$mnt=date('n'),date('d'),date('Y'))."<br>";

        $this->year =$yr;
        $this->month =$mnt;
        $week=date('w', mktime(0,0,0,$mnt,1,$yr));
        $insgesamt=date('t', mktime(0,0,0,$mnt,1,$yr));
        $d=date('d');
        $months=array('January','February','March','April','May','June','July','August','September','October','November','December');
        if(isset($erster)&&$erster==0){$erster=7;}
        $html= '<div style=""><table border=1 cellspacing=5 style="font-size:8pt; font-family:Verdana;border:1px solid #f1f1f1;margin: 15px auto;" align=center width=97% height=500px>';
        $html.= '<th colspan=7 align=center style="font-size:18pt; font-family:Arial; color:#ff9900;text-align: center;">';
        $html.= '<input class="btn btn-default" type=button value="&laquo;"   onclick=self.document.location="'.site_url('report/report_home/'.$this->getYear(-1).'/'.$this->getMonth(-1)).'">&nbsp;';
        $html.= $months[$mnt-1].' '.$yr;
        $html.= '&nbsp;<input class="btn btn-default" type=button value="&raquo;"  onclick=self.document.location="'.site_url('report/report_home/'.$this->getYear(1).'/'.$this->getMonth(1)).'">';
        $html.= '</th>';
        $html.= '<tr><td style="color:#666666"><b>Monday</b></td><td style="color:#666666"><b>Tuesday</b></td>';
        $html.= '<td style="color:#666666"><b>Wednesday</b></td><td style="color:#666666"><b>Thursday</b></td>';
        $html.= '<td style="color:#666666"><b>Friday</b></td><td style="color:#0000cc"><b>Saturday</b></td>';
        $html.= '<td style="color:#cc0000"><b>Sunday</b></td></tr>';
        $html.= "<tr>\n";
        $i=1;
        if ($week == 0) $week =7;
        while($i<$week){$html.= '<td>&nbsp;</td>'; $i++;}
        $i=1;
        while($i<=$insgesamt)
        {
            $rest=($i+$week-1)%7;
            if($i==$d){
                $html.= '<td style="font-size:8pt; font-family:Verdana; background:#fff1f1;" valign=top align=left>';
            }
            else{
                $html.= '<td style="font-size:8pt; font-family:Verdana" valign=top align=left>';
            }

            if($i==$d){
                $html.= $this->getOption(date('Y-m-d',mktime(0,0,0,$mnt,$i,$yr)),$i);
            }
            else if ($i > $d){
                $html.= '<span style="color:#cccccc;font-size:18pt; ">'.$this->getOption(date('Y-m-d',mktime(0,0,0,$mnt,$i,$yr)),$i).'</span>';
            }
            else if($rest==6){
                $html.= $this->getOption(date('Y-m-d',mktime(0,0,0,$mnt,$i,$yr)),$i);
            }
            else if($rest==0){
                $html.= $this->getOption(date('Y-m-d',mktime(0,0,0,$mnt,$i,$yr)),$i);
            }
            else{
                $html.= $this->getOption(date('Y-m-d',mktime(0,0,0,$mnt,$i,$yr)),$i);
            }
            $html.= "</td>\n";
            if($rest==0){$html.= '</tr><tr>';}
            $i++;
        }
        $html.= '</tr>';
        $html.= '</table></div>';
        return $html;
    }
    private function getOption($dte,$day){
        $ops = "";
        $ops .= "<table border=0 cellspacing=0 cellpading=2 width=100%>";
        $ops .= "<tr>";
        if ($dte == date('Y-m-d')) {
            $ops .= "<td width=15 style='color:#00a84b;font-size:18pt;font-weight:bold;' valign=top align=left>".$day ;
        }
        else {
            $ops .= "<td width=15 style='color:#000000;font-size:18pt;' valign=top align=left>".$day;
        }
        $ops .= "</td>";
        if ($this->config->item('purpose') !="PP"){
        	$ops .= "<td valign=top align=right style='color:#000000;font-size:8pt;'>" ;
        }else{
        	$ops .= "<td valign=top align=right style='color:#000000;font-size:10pt;'>" ;
        }

        $ops .= "<a onclick=\"openWindow('" . site_url(
                "report/pdf/dailyVisits/print/".$dte
            ) . "')\" href='#'>Visits</a>";
            
        if ($this->config->item('purpose') !="PP"){
	        $ops .= "<br/><a onclick=\"openWindow('" . site_url(
	                "report/pdf/dailyAdmissions/print/".$dte
	            ) . "')\" href='#'>Admissions</a><br>";
	        $ops .= "<a onclick=\"openWindow('" . site_url(
	                "report/pdf/dailyDischarges/print/".$dte
	            ) . "')\" href='#'>Discharges</a>";
        }
        
        $ops .= "<br><a onclick=\"openWindow('" . site_url(
                "report/pdf/pharmacyBalance/print/".$dte
            ) . "')\" href='#'>Drugs dispensed</a><br>";
        $ops .= "<a onclick=\"openWindow('" . site_url(
                "report/pdf/dailyClinics/print/".$dte
            ) . "')\" href='#'>Clinics</a>";
            
        if ($this->config->item('purpose') !="PP"){
	        $ops .= "<br><a onclick=\"openWindow('" . site_url(
	                "report/pdf/midnightCensus/print/".$dte
	            ) . "')\" href='#'>Midnight Census</a><br>";
        }
        
//        $ops .= "<a href='#' onclick=printReport('".$dte."','visits');>Visits</a><br>";
//        $ops .= "<a href='#' onclick=printReport('".$dte."','clinics');>Clinics</a><br>";
//        $ops .= "<a href='#' onclick=printReport('".$dte."','admissions');>Admissions</a><br>";
//        $ops .= "<a href='#' onclick=printReport('".$dte."','discharges');>Discharges</a><br>";
//        $ops .= "<a href='#' onclick=printReport('".$dte."','drugsdispensed');>Drugs dispensed</a><br>";
        $ops .= "</td>";
        $ops .= "<tr>";
        $ops .= "</table>";
        return $ops;
    }
    private function getYear($inc){

        $m = $this->month + $inc;
        if ( $m <1 ){
            $y = $this->year-1;
            return $y;
        }
        else if ( $m >12 ){
            $y = $this->year+1;
            return $y;
        }
        else {
            $y = $this->year;
            return $y;
        }
    }
    private function getMonth($inc){
        $m = $this->month + $inc;
        if ($m <= 0 )
            return 12;
        else if ($m > 12 )
            return 1;
        else
            return $m;
    }
}


//////////////////////////////////////////

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */