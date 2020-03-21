<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Collectfellowships
 *
 * @author skliz
 */
header('Content-type: application/json');
include("../config/connector.php");
include("../utility/Library.php");
include("../webserviceObjects/FellowshipModel.php");

class Collectfellowships {
    //put your code here
    
    public $connection = null;
    public $library = null;
    
    private $webserviceContainer = null; 
    private $fellowshipmodel = null;
    
        function __construct(){
        
            $this->connection = new Connector();
            $this->connection->doConnection();
            $this->library = new Library();
          
            $this->webserviceContainer = array();
            
            
            if(isset($_GET['branchID'])){
                                
                $this->collect($_GET['branchID']);
            }
        }
    
        private function collect($branchid){
            
            $query = "select * from fellowship where rhemabranchid = $branchid";
            
            $result = mysql_query($query) or die(mysql_error());
            
            $num = mysql_num_rows($result);
            
            $index = 0;
            if($num >0){
                                
                while($record = mysql_fetch_array($result)){
                    $this->fellowshipmodel = new FellowshipModel();
                    
                    $this->fellowshipmodel->ID = $record['id'];
                    $this->fellowshipmodel->Name = $record['name'];
                    $this->fellowshipmodel->Response ="Retrieved";
                    
                    $this->webserviceContainer[$index] = $this->fellowshipmodel;
                }
            }
            else{
                    $this->fellowshipmodel->ID = "No data";
                    $this->fellowshipmodel->Name = "No data";
                    $this->fellowshipmodel->Response ="No data";
              
                    $this->webserviceContainer[$index] = $this->fellowshipmodel;
              }
            
            echo json_encode($this->webserviceContainer);
        }
    
        
}


$object = new Collectfellowships();
?>