<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Collectwedding
 *
 * @author skliz
 */
//This class is going to collect wedding information
header('Content-type: application/json');
include("../config/connector.php");
include("../webserviceObjects/AudioModel.php");
include("../webserviceObjects/VideoModel.php");
include("../webserviceObjects/MediaModel.php");

class Collectwedding {
    //put your code here
    private $connection = null;
    
    //Declaring the web service objects below
    private $webserviceContainer = null;
    private $weddedobject = null;
    private $abouttowed = null;
    
    function __construct(){
        $this->connection = new Connector();
        $this->connection->doConnection();
        
        $this->webserviceContainer = new WeddingModel();
        
        
        
        
        
        if(isset($_GET['weddingdate'])  && isset($_GET['branchid'])){
            $weddingdate = $_GET['weddingdate'];
            $branchid = $_GET['branchid'];
            
            $this->getWeddingInfo($weddingdate,$branchid);
        }
    }
    
    private function getWeddingInfo($weddingdate,$branchid){
        
        $startdate = $weddingdate."-01";  $enddate = $weddingdate."-31";
        
        $this->webserviceContainer->Aboutwed = $this->returnAbouttowed($startdate, $enddate, $branchid);
        
        $this->webserviceContainer->Weded = $this->returnWeddedinfo($startdate, $enddate, $branchid);
        
        $this->webserviceContainer->Response = "Retrieved";
        
        echo  json_encode($this->webserviceContainer);
    }
    
    
    //This method is going to be used to return the wedded couple information
    private function returnWeddedinfo($startdate,$enddate,$branchid){
        $query = "select bride, groom, weddingdate  from wedding where weddingdate >= '$startdate' and weddingdate <= '$enddate' and rhemabranchid= $branchid and  marriedstatus = true ";
        $result = mysql_query($query) or die(mysql_error());
        
        $num =  mysql_num_rows($result);
        
        
        $wededContainer = array();
        $index = 0;
        if($num >0 ){
            
            
            while($record = mysql_fetch_array($result)){
                $this->weddedobject = new WededModel();              
                
                $this->weddedobject->Bride = $record[0];
                $this->weddedobject->Groom = $record[1];
                $this->weddedobject->Date = $record[2];
                $this->weddedobject->Response = "Retrieved";
                
                
                 $wededContainer[$index] = $this->weddedobject;
                $index++;
            }
        }
        else{
                $this->weddedobject->Bride = "No value";
                $this->weddedobject->Groom = "No value";
                $this->weddedobject->Date = "No value";
                $this->weddedobject->Response = "No value";
                
                $wededContainer[$index] = $this->weddedobject;
        }
        
        return ($wededContainer);
    }
    
    //This is going to return about to wed wedding info
    private function returnAbouttowed($startdate,$enddate,$branchid){
        
         $query = "select * from wedding where weddingdate >= '$startdate' and weddingdate <= '$enddate' and rhemabranchid= $branchid and marriedstatus = false ";
        $result = mysql_query($query) or die(mysql_error());
        
        $num =  mysql_num_rows($result);
        
        $aboutwedContainer = array();
        
        $index = 0;
        if($num >0){
            
            while($record = mysql_fetch_array($result)){
                $this->abouttowed = new AboutWedModel();
                
                $this->abouttowed->Bridetobe = $record[1];
                $this->abouttowed->Groomtobe = $record[2];
                 $this->abouttowed->WeddingTime = $record[3];
                 $this->abouttowed->WeddingDate = $record[4];
                 $this->abouttowed->WeddingAddress = $record[5];
                 $this->abouttowed->EngagementDate = $record[6];
                 $this->abouttowed->EngagementTime = $record[7];         
                 $this->abouttowed->EngagementAddress = $record[8];
                 $this->abouttowed->Response = "Retrieved";
                 
                 $aboutwedContainer[$index] = $this->abouttowed;
                 $index++;
            }
        }
        else
        {
                $this->abouttowed->Bridetobe = "No value";
                $this->abouttowed->Groomtobe = "No value";
                 $this->abouttowed->WeddingTime = "No value";
                 $this->abouttowed->WeddingDate = "No value";
                  $this->abouttowed->WeddingAddress = "No value";
                   $this->abouttowed->EngagementDate = "No value";
                   $this->abouttowed->EngagementTime = "No value";
                   $this->abouttowed->EngagementAddress = "No value";
                   $this->abouttowed->Response = "No value";
            
                   $aboutwedContainer[$index] = $this->abouttowed;
        }
        
        return $aboutwedContainer;
    }
}


$object = new Collectwedding();
?>