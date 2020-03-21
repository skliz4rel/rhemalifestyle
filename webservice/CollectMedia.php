<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CollectMedia
 *
 * @author skliz
 */
//This is going to be used to collect media from the database
header('Content-type: application/json');
include("../config/connector.php");
include("../webserviceObjects/MediaModel.php");
include("../webserviceObjects/VideoModel.php");
include("../webserviceObjects/AudioModel.php");

class CollectMedia {
    //put your code here
    
     //put your code here
    private $connection = null;
    
    private $webserviceContainer = null;
    
    private $videoContainer = null;
    
    private $audioContainer = null;
    
    function __construct(){
        $this->connection = new Connector();
        $this->connection->doConnection();
        
        $this->audioContainer = array();
        $this->videoContainer = array();
        
        $this->webserviceContainer = new MediaModel();
        
        if(isset($_GET['branchid'])){
            $branchid = $_GET['branchid'];
            
            $this->webserviceContainer->Audios = $this->getAudios($branchid);
            $this->webserviceContainer->Videos = $this->getVideos($branchid);
            
            echo json_encode($this->webserviceContainer);
        }
       
    }
    
    
    //This is going to collect the video objects
    private function getVideos($branchid){
        
        $query = "select id,title from media where mediatype = 'video' and rhemabranchid = $branchid";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        $index = 0;
        if($num > 0){
            
            
            while($record = mysql_fetch_array($result)){
                
                 $videoObject = new VideoModel();
                $videoObject->ID = $record[0];
                $videoObject->Title = $record[1];
                 $videoObject->Response = "Retrieved";
                
                $this->videoContainer[$index] = $videoObject;
                $index++;
            }            
        }
        else
        {
            
             $videoObject = new VideoModel();
                $videoObject->ID = "No data";
                $videoObject->Title = "No data";
                $videoObject->Response = "No data";
                $this->videoContainer[$index] = $videoObject;
        }
        
        
        return $this->videoContainer;
    }
    
    
    private function getAudios($branchid){
        
         $query = "select id,title from media where mediatype = 'audio' and rhemabranchid = $branchid";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        $index = 0;
        if($num > 0){
            
            while($record = mysql_fetch_array($result)){
                
                 $audioObject = new AudioModel();
                $audioObject->ID = $record[0];
                $audioObject->Title = $record[1];
                 $audioObject->Response = "Retrieved";
                
                $this->audioContainer[$index] = $audioObject;
                $index++;
            }            
        }
        else
        {            
                $audioObject = new AudioModel();
                $audioObject->ID = "No data";
                $audioObject->Title = "No data";
                $audioObject->Response = "No data";
                $this->audioContainer[$index] = $audioObject;
        }        
        
        return $this->audioContainer;
    }
    
}


$object = new CollectMedia();
?>