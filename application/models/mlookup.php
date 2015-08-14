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
__________________________________________________________________________________
Private Practice configuration :

Date : July 2015		ICT Agency of Sri Lanka (www.icta.lk), Colombo
Author : Laura Lucas
Programme Manager: Shriyananda Rathnayake
Supervisors : Jayanath Liyanage, Erandi Hettiarachchi
URL: http://www.govforge.icta.lk/gf/project/hhims/
----------------------------------------------------------------------------------
*/

class Mlookup extends CI_Model
{

    function __construct()
    {
        parent::__construct();
		$this->load->database();
    }
	function get_drugs_sub_groups($id){
		$dataset = array();
		$sql=" select  who_drug.sub_group , who_drug.wd_id";
        $sql .= " FROM who_drug  " ;
		
        $sql .= " WHERE (who_drug.sub_group is not null) and ( who_drug.group = (select who_drug1.group from who_drug as who_drug1 where who_drug1.wd_id='".$id."') ) group by who_drug.sub_group order by who_drug.sub_group" ;
		//echo $sql;
		//exit;
	   $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset;  
	}	

	function get_canned_text($txt){
		$dataset = array();
		$sql = " SELECT Code,Text FROM   canned_text  ";
		$sql .=" WHERE (Active = 1) AND (Code =  '".strtoupper($txt)."') ";		
		 $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset = $row;
            }
        }
        $Q->free_result();    
        return $dataset;  
	}	
	function get_drug_name($id=null,$drug_stock_id=null){
		$dataset = array();
		$sql=" select who_drug.name, who_drug.formulation, who_drug.dose, who_drug.wd_id,who_drug.default_num,who_drug.default_timing";
		if ($drug_stock_id!=null){
			$sql .= ",drug_count.who_drug_count ";
		}
        $sql .= " FROM who_drug " ;
		if ($drug_stock_id!=null){
			$sql .="left JOIN `drug_count` ON drug_count.who_drug_id= who_drug .wd_id";
		}
        $sql .= " WHERE (who_drug.name is not null) ";
		if ($id!=null){
			$sql .= " and ( who_drug.sub_group = (select who_drug1.sub_group from who_drug as who_drug1 where who_drug1.wd_id='".$id."') ) ";
		}
		if ($drug_stock_id!=null){
			$sql .="and  (drug_count.drug_stock_id ='$drug_stock_id') ";
		}
		$sql .= " order by who_drug.name" ;
		//echo $sql;
		//exit;
	   $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset;  
	}	
	function get_formulation($id){
		$dataset = array();
		$sql=" select  who_drug.formulation , who_drug.wd_id";
        $sql .= " FROM who_drug  " ;
		
        $sql .= " WHERE (who_drug.formulation is not null) and ( who_drug.name = (select who_drug1.name from who_drug as who_drug1 where who_drug1.wd_id='".$id."') ) group by who_drug.formulation order by who_drug.formulation" ;
		//echo $sql;
		//exit;
	   $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset;  
	}	
	
	function get_frequency(){
		$dataset = array();
		$sql=" select DISTINCT drugs_frequency.Frequency , drugs_frequency.DFQYID";
        $sql .= " FROM drugs_frequency  " ;
        $sql .= " WHERE drugs_frequency.Active=1 ORDER BY drugs_frequency.Frequency" ;
        
		//echo $sql;
		//exit;
	   $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset;  
	}	

	
//SELECT DISTINCT drugs_dosage.Dosage, drugs_dosage.DDSGID FROM `drugs_dosage` WHERE drugs_dosage.active =1 
//ORDER BY drugs_dosage.Dosage

// Modification when programming PP configuration
// Previous versions didn't load the dosage from the database
	function get_dosage(){
		$dataset = array();
		$sql=" SELECT DISTINCT drugs_dosage.Dosage, drugs_dosage.DDSGID ";
        $sql .= " FROM `drugs_dosage`  " ;
        $sql .= " WHERE drugs_dosage.active =1 ORDER BY drugs_dosage.Dosage" ;
        
		//echo $sql;
		//exit;
	   $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset;  
	}		
	
//	SELECT DISTINCT `Period`, `DPRDID`  FROM `drugs_period` ORDER BY `Period`  
// Modification when programming PP configuration
// Previous versions didn't load the period from the database
	function get_period(){
		$dataset = array();
		$sql=" SELECT DISTINCT `Period`, `DPRDID` ";
        $sql .= " FROM `drugs_period` " ;
        $sql .= " WHERE drugs_period.active =1 ORDER BY `Period`" ; 

	   $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset;  
	}	
	
	function get_drugs_groups(){
		$dataset = array();
		$sql=" select  who_drug.group , who_drug.wd_id";
        $sql .= " FROM who_drug  " ;
        $sql .= " WHERE who_drug.group is not null group by who_drug.group order by who_drug.group" ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset;  
	}

function get_complaint_list($key){
		$key = stripslashes($key);
        $key = mysql_real_escape_string($key);
		$dataset = array();
		$sql=" select COMPID as id,Name as value,Name as label ";
        $sql .= " FROM complaints " ;
        $sql .= " WHERE (Active = 1) and (Name like '%".$key."%')" ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset;    
    }
	
	
	function get_village_list($key){
        $key = stripslashes($key);
        $key = mysql_real_escape_string($key);

        $dataset = array();
		$sql=" select VGEID as id,GNDivision as value,District as Address_District,DSDivision as Address_DSDivision, concat(GNDivision, ', ', DSDivision, ', ', District) as label ";
        $sql .= " FROM village " ;
        $sql .= " WHERE (Active = 1) and (GNDivision like '%".$key."%')" ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset;    
    }
	
	
	public function get_snomed_term($terms,$type='disorder',$from=1,$to=100){

        $dataset = array();
		$sql =" SELECT  DISTINCT CONCEPTID, TERM, Link_ICD_Code, Link_ICD_Text FROM ".$type;
		$sql .=" WHERE  (";
		foreach ($terms as $term){
			$sql .=" (TERM  like '%".$term."%') AND ";
		}
		$sql .=" (1=1))";
		//$sql .=" AND Link_ICD_Code IS NOT NULL AND Link_ICD_Code <> '' ";
		$sql .=" order by Link_ICD_Code DESC limit ".$from . ','.$to;
		//echo $sql;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() >0){
				
				foreach ($Q->result_array() as $row){
					if ($row['Link_ICD_Code']!=''){
						$immr = $this->analize_immr($row['Link_ICD_Code']);
						$row['immr'] = $immr;
					}
					else{
						$row['immr'] = null;
					}
					$dataset[] = $row;
				}
                //$dataset = $Q->result_array();
        }
        $Q->free_result();    
        return  $dataset;  
	}
	
	public function analize_immr($icd_code){
		$icd_codes = explode(".", $icd_code);
		$immr = $this->get_immr($icd_code);
		if (empty($immr)){
			if(isset($icd_codes[0])){
				$immr = $this->get_immr($icd_codes[0]);
			}
		}
		return $immr;
	}
	
	public function get_immr($icd_code){
		$icd_codes = explode(".", $icd_code);
		$dataset = array();
		$sql=" select IMMRID,CODE,Name,Category ";
        $sql .= " FROM immr " ;
        $sql .= " WHERE (ICDCODE like '%".$icd_code."%')" ;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() > 0){
            foreach ($Q->result_array() as $row){
                $dataset[] = $row;
            }
        }
        $Q->free_result();    
        return $dataset;    
	}
	
	
	
	public function get_ICD_code($code){
	    $code = stripslashes($code);
        $code = mysql_real_escape_string($code);

        $dataset = array();
		$sql =" SELECT * FROM snomed_map WHERE  CONCEPTID  = '".$code."' ";
		//echo $sql;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() ==1){
            foreach ($Q->result_array() as $row){
                $dataset = substr($row["ICDMAP"],0,3);
            }
        }
        $Q->free_result();    
        return $dataset;  
	}
	
	public function get_ICD_info($code){
	    $code = stripslashes($code);
        $code = mysql_real_escape_string($code);

        $dataset = array();
		$sql =" SELECT * FROM icd10 WHERE  Code  like '%".$code."' ";
		//echo $sql;
        $Q =  $this->db->query($sql);
        if ($Q->num_rows() ==1){
            foreach ($Q->result_array() as $row){
                $dataset = $row;
            }
        }
        $Q->free_result();    
        return $dataset;  
	}
	
	}
