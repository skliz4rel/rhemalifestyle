<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CollectSermons
 *
 * @author skliz
 */
//This class is going to be used by the web service to collect sermons of the pastor
header('Content-type: application/json');
include("../config/connector.php");
include("../utility/Library.php");
include("../webserviceObjects/MessageModel.php");

class CollectSermons {
    //put your code here
    public $connection = null;
    public $library = null;
    
    private $webserviceContainer = null;
    private $messagemodel = null;
    
    function __construct(){
        
        $this->connection = new Connector();
        $this->connection->doConnection();
        $this->library = new Library();
        
        $this->webserviceContainer = array();
        
        if(isset($_GET['messagedate']) &&  isset($_GET['branchid'])){
            
            $date = $_GET['messagedate'];
            
            $branchid = $_GET['branchid'];
            
            $this->getPastorSermons($date,$branchid);
        }
    }
    
    
    public function getPastorSermons($date,$branchid){
        
        $query = " select id, title, scriptures, message, preacherid from message  where mdate = '$date' and rhemabranchid = $branchid ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        if($num > 0){
            
            $index = 0;
            
            while($record = mysql_fetch_array($result)){
                 $this->messagemodel = new MessageModel();
                $preachername = $this->library->returnPreachername($record['preacherid']);
                
                $this->messagemodel->MessageID = $record['id'];
                $this->messagemodel->Preacher= $preachername;
                $this->messagemodel->Message = $record['message'];
                $this->messagemodel->Title = $record['title'];
                $this->messagemodel->Scriptures = $record['scriptures'];
                $this->messagemodel->ResponseState = "Submitted";
                
                $this->webserviceContainer[$index] = $this->messagemodel;
                
                $index++;
            }            
            
            echo  json_encode($this->webserviceContainer);
        }
        else{
                $this->messagemodel = new MessageModel();
                $this->messagemodel->MessageID = 0;
                $this->messagemodel->Preacher= "Failed";
                $this->messagemodel->Message = "Failed";
                $this->messagemodel->Title = "Failed";
                $this->messagemodel->Scriptures = "Failed";
                $this->messagemodel->ResponseState = "Failed";
                
                
                $this->webserviceContainer[0] = $this->messagemodel;
                
                echo json_encode($this->webserviceContainer);
        }
        
    }
    
}


$object = new CollectSermons();
?>