<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ColllectFellowshipAddress
 *
 * @author skliz
 */
header('Content-type: application/json');
include("../config/connector.php");
include("../webserviceObjects/HouseFellowshipAddressModel.php");

class CollectFellowshipAddress {
    //put your code here
   
    private $connection = null;
    private $webserviceObject = null;
    private $webserviceContainer = null;
    
    function __construct(){
        $this->connection = new Connector();
        $this->connection->doConnection();
        
        $this->webserviceContainer = array();
        
        if(isset($_GET['branchID']) and isset($_GET['locationID'])){
            $branchid = $_GET['branchID'];
            $locationid = $_GET['locationID'];
            
            $this->getAddress($branchid, $locationid);
        }        
    }
    
    private function getAddress($branchid,$location){
        
        $query = "select * from fellowshiplocationaddress where branchid=$branchid and fellowshiplocationid=$location "; 
        
        $result = mysql_query($query) or die(mysql_error());
        
         $rows =  mysql_num_rows($result);
        
        $index = 0;
        
        if(isset($rows) && $rows > 0)
            while($record = mysql_fetch_array($result)){
            
                $this->webserviceObject = new HouseFellowshipAddressModel();
                $this->webserviceObject->Centeraddress = $record[1];
                $this->webserviceObject->Centername = $record[2];
                $this->webserviceObject->ResponseState = "Data exits";

                $this->webserviceContainer[$index] = $this->webserviceObject;

                $index++;
       }
        else{
            //This is when there is no record to be returned
            $this->webserviceObject = new HouseFellowshipAddressModel();
           $this->webserviceObject->Centeraddress = "No Data";
                $this->webserviceObject->Centername = "No Data";
            $this->webserviceObject->ResponseState = "No Data";
            
             $this->webserviceContainer[$index] = $this->webserviceObject;
        }
        
        echo json_encode($this->webserviceContainer);
    }
}


$object = new CollectFellowshipAddress();
?>