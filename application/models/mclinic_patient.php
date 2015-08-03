<?php
/**
 * Created by JetBrains PhpStorm.
 * User: kavinga
 * Date: 10/27/13
 * Time: 1:50 PM
 * To change this template use File | Settings | File Templates.
 */

class Mclinic_patient extends My_Model
{

    function __construct()
    {
        parent::__construct();
        $this->_table = 'clinic_patient';
        $this->_key = 'clinic_patient_id';
        $this->load->database();
    }

    public function getSequenceNumber()
    {
        if (isset($this->sequence_number) && $this->sequence_date==$this->next_visit_date) {
            return $this->sequence_number;
        } else {
            $query = "SELECT MAX(sequence_number) as current_number FROM clinic_patient WHERE clinic_id = ".$this->clinic_id." AND sequence_date = '".$this->next_visit_date."'";
            $result = $this->db->query($query);
            $current_number = $result->first_row()->current_number;
            if ($current_number) {
                $next_number = $current_number + 1;
            } else {
                $next_number = 1;
            }
            $this->db->where('clinic_patient_id', $this->clinic_patient_id);
            $this->db->update($this->_table, array('sequence_number'=>$next_number,'sequence_date'=>$this->next_visit_date));
            $this->sequence_number=$next_number;
            return $this->sequence_number;
        }
    }
}