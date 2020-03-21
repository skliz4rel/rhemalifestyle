<?php

include("../config/connector.php");
include("../webserviceObjects/FellowshipLocationModel.php");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class FellowshipCenter{
    
    public $connection = null;
    public $webserviceObject = null;
    
    //THis is going to store the array that would be converted to json and send to the android client
    public $webserviceObjContainer = null;
    
    function __construct(){
        
        $this->connection = new Connector();
        $this->connection->doConnection();
        
        
        $this->webserviceObjContainer = array();
     
        
     //   $json = file_get_contents('php://input');
       // $obj = json_decode($json);
        
        if(isset($_GET['branchid']))
            $this->ReturnFellowshipLocation($_GET['branchid']);
    
    }   
    
    
    //This method is giong to be used to collect the fellowship center from the database
    public function ReturnFellowshipLocation($id){
        
       // $id = $obj->{"branchid"};
        
        $query = "select * from fellowshiplocation where rhemabranchid = $id";
        $result = mysql_query($query) or die(mysql_error());
     
        
        $index = 0;
        
        
        
        while($record = mysql_fetch_array($result)){
           
            
            $this->webserviceObject = new FellowshipLocationModel(); //create a new instance of the object
            $this->webserviceObject->ID = $record[0];
            $this->webserviceObject->Location = $record[1];
            $this->webserviceObject->Number = "Number of fellowship centers in vicinity: ".$record[2];
            
            
            //add to the array container
            $this->webserviceObjContainer[$index] = $this->webserviceObject;
            
            $index++; //increase the counter
        }
        
        mysql_close();
                
       echo  json_encode($this->webserviceObjContainer);
    }
    
}

$object = new FellowshipCenter();
?>