<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CollectFellowshipInfo
 *
 * @author skliz
 */
header('Content-type: application/json');
include("../config/connector.php");
include("../webserviceObjects/FellowshipInfoModel.php");

class CollectFellowshipInfo {
    //put your code here
    private $connection = null;
    private $informationModel = null;
    
      function __construct(){
        $this->connection = new Connector();
        $this->connection->doConnection();
        $this->informationModel = new FellowshipInfoModel();
        
        if(isset($_GET['fellowshipid']) and isset($_GET['branchid'])){
            
            $fellowshipid = $_GET['fellowshipid'];
            $branchid = $_GET['branchid'];
            $this->returnInformation($fellowshipid,$branchid);
        }
      }
    
      private function returnInformation($fellowshipid,$branchid){
       
          $query = "select Information from fellowshipinfo where fellowshipid = $fellowshipid and rhemabranchid = $branchid";
          
          $result = mysql_query($query) or die(mysql_error());
          
          $num = mysql_num_rows($result);
          
          if($num >0){
              
              while($record = mysql_fetch_array($result)){
                  
                  $this->informationModel->Information = $record[0];
                 
              }
              
          }
          else{
              
              $this->informationModel->Information = "No data";
             
          }
          
          echo json_encode($this->informationModel);
      }
    
}

$object = new CollectFellowshipInfo();
?>