<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Collectbranches
 *
 * @author skliz
 */
include("../config/connector.php");
include("../webserviceObjects/BranchModel.php");

class Collectbranches {
    //put your code here
    
    private $connection = null;
    private $webserviceContainer = null;
    
       function __construct(){
        $this->connection = new Connector();
        $this->connection->doConnection();
        
        $this->webserviceContainer = array();
        
        $countryid = 0;
        
        if(isset($_GET['country']))
        {
            $countryid = $this->returnCountryID($_GET['country']);
            
            //echo $countryid;
            $this->GetBranches($countryid);
        }
                        
         
       }
       
       //This method would return the country id 
       private function returnCountryID($country){
           
           $query = "select id from country where name = '$country' ";
           
           $result = mysql_query($query) or die(mysql_error());
           
           $id = 0;
           
           while($record = mysql_fetch_array($result)){
               $id = $record[0];
           }
           
           return $id;
       }
       
       
      //Ths method would collect the branches
       private function GetBranches($id){
           
           $query = "select id, branchname from rhemabranch where countryid = $id ";
           
           $result = mysql_query($query) or die(mysql_error());
           
           $value = "";
           
           $index = 0;
           
           if(isset($result)){
                while($record = mysql_fetch_array($result)){

                    $branchObj = new BranchModel();
                    $branchObj->ID = $record[0];
                    $branchObj->Branch = $record[1];
                    $branchObj->Response = "Retrieved";

                    $this->webserviceContainer[$index] = $branchObj;
                    $index++;
                }
           }
           else{
                    $branchObj = new BranchModel();
                    $branchObj->ID = "No data";
                    $branchObj->Branch = "No data";
                    $branchObj->Response = "No data";
               
                    $this->webserviceContainer[0] = $branchObj;
           }
           
           echo  json_encode($this->webserviceContainer);
       }
}

$object = new Collectbranches();
?>