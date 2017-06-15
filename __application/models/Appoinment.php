<?php
if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

// Include DAO Class
include_once 'Datastructure.php';

// Define Unit Class
class Appoinment extends Datastructure{
	
    // Get All Appoinment
    function getAllAppoinment(){
        
        $select = " DATE_FORMAT(appoitments_time,'%d/%m/%Y %h:%i %p') AS appoitments_time, pt.patient_kh_name, pt.patient_en_name, name";
        $from = $this->getTblAppoinment() ." AS ap";
        $from .= " LEFT JOIN ". $this->getTblVisitor() . " AS vs ON vs.visitors_id = ap.visitors_id";
        $from .= " LEFT JOIN ". $this->getTblPatient() . " AS pt ON vs.patient_id = pt.patient_id ";
        $from .= " LEFT JOIN ". $this->getTblUser() . " AS us ON us.uid = ap.uid ";
        $where = " appionments_deleted = 0 AND appoitments_time >= NOW() ORDER BY appoitments_time ASC";
        
        return $this->executeQuery($select, $from, $where);
    }
    
    // Get Appoinment By Visitor ID
    function getAppoinmentByVisitorId(){
        return $this->executeQuery("", $this->getTblAppoinment(), " appionments_deleted = 0 AND visitors_id = ".$this->getVisitorId());
    }

    // Get Count Appoinment By Visitor ID
    function getCountAppoiomentByVisitorId(){
        return $this->getCountWhere($this->getTblAppoinment(), " appionments_deleted = 0 AND visitors_id = ".$this->getVisitorId());
    }
    
    // Set Appoinment
    function setAppoinment(){
        $this->setArrayData("visitors_id", $this->getVisitorId());
        $this->setArrayData("uid", $this->getUserId());
        $this->setArrayData("appoitments_time", $this->getDate1());
        
        $this->insertData($this->getTblAppoinment(), $this->getArrayData());
    }
    
    // Update Appoinment Status
    function updateAppoinmentTime(){
        $this->setArrayData("appoitments_time", $this->getDate1());
        $this->setArrayData("appoitments_status", $this->getGroup());
        
        $this->updateDataWhere($this->getTblAppoinment(), $this->getArrayData(), " visitors_id = ".$this->getVisitorId());
    }
}
?>
