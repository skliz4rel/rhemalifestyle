<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of CollectLetchatinfo
 *
 * @author skliz
 */
header('Content-type: application/json');
include("../config/connector.php");
include("../webserviceObjects/LetchatSummaryModel.php");
include("../webserviceObjects/LetchatInformationModel.php");
include("../webserviceObjects/LetchatModel.php");


class CollectLetchatinfo {
    //put your code here
    
    private $connection = null;
  
   
    private $objectServiceContainer = null;
    
    function __construct(){
        $this->connection = new Connector();
        $this->connection->doConnection();
        
        $this->objectServiceContainer = new LetchatModel();
        //$this->summaryObject = array();
        //$this->informationObject = array();
        
        
        if(isset($_GET['branchid']) and $_GET['year_month']){
            
            $startdate = $_GET['year_month']."-01";
            $enddate = $_GET['year_month']."-31";
            $branchid = $_GET['branchid'];
            
            $this->displayLetchatInformation($branchid,$startdate,$enddate);
            $this->displayLetchatSumary($branchid,$startdate,$enddate);
                        
            echo json_encode($this->objectServiceContainer);
        }
    }
          
     //This is going to collect summary information from the database
     private function displayLetchatSumary($branchid,$startdate,$enddate){
           
         $query = "select summary from Letschat where rhemabranchid = $branchid and ldate >= '$startdate' and ldate <='$enddate' ";
         
         $result = mysql_query($query) or die(mysql_error());
         
         $num = mysql_num_rows($result);
         
         $obj = null;
         if($num >0){
             
             while($record = mysql_fetch_array($result)){
                 
                 $obj= new LetchatSummaryModel();
                 $obj->Summary = $record[0];
                 $obj->Response = "Retrieved";                              
             }
             
             $this->objectServiceContainer->SummaryModel = $obj;
         }
         else{
            
                 $obj= new LetchatSummaryModel();
                 $obj->Summary = "No data";
                 $obj->Response = "No data";
                 
              $this->objectServiceContainer->SummaryModel = $obj;   
         }
         
         
     }
     
     
     //This is giong to colleect information of the letchat from the database
     private function displayLetchatInformation($branchid,$startdate,$enddate){
         
         $query = "select information from Letschat where rhemabranchid = $branchid and ldate >= '$startdate' and ldate <= '$enddate' ";
         
         $result = mysql_query($query) or die(mysql_error());
         
         $num = mysql_num_rows($result);
         
         $obj = null;
         if($num >0){
                          
             while($record = mysql_fetch_array($result)){
                  
                 $obj = new LetchatInformationModel();
                 $obj->Information= $record[0];                
                 $obj->Response = "Retrieved";
                
             }
             
             $this->objectServiceContainer->InformationModel = $obj;
         }
         else{
                 $obj = new LetchatInformationModel();
                 $obj->Information= "No data";                
                 $obj->Response = "No data";
                                
                 $this->objectServiceContainer->InformationModel = $obj;
         }
        
     }
}

$object = new CollectLetchatinfo();
?>