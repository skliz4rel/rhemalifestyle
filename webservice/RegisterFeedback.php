<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Feedback
 *
 * @author skliz
 */
//This class would be used to handle feedbacks that would be posted to the server
header('Content-type: application/json');
include("../config/connector.php");
include("../webserviceObjects/FeedbackModel.php");


class RegisterFeedback {
    //put your code here
    
   public $connection = null;
   public $feedbackmodel = null;
   
    function __construct(){
        $this->connection = new Connector();
        $this->connection->doConnection();
        
                 
         $json = file_get_contents('php://input');
        $obj = json_decode($json);
        
        if(isset($obj))
            $this->register($obj);
        
    }
    
    
    //This method is going to be used to register feedback into the database
    function register($obj){
        
        $Username = $obj->{"Username"};
        $Title = $obj->{"Title"};
        $Message = $obj->{"Message"};
        $BranchID = $obj->{"BranchID"};
        
        //Firstly we are going to collect the member id of the particular user
        $MemberID = 0;
        
        
        $MemberID = $this->returnMemberID($Username);
        
        $query = "insert into feedback (title,message,rhemabranchid,memberid) values ('$Title', '$Message',$BranchID, $MemberID)"; 
    
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_insert_id();
        
        if($id >0){
          
             $this->feedbackmodel = new FeedbackModel();
             
              $this->feedbackmodel->BranchID = $BranchID;
              $this->feedbackmodel->Title = $Title;
              $this->feedbackmodel->Message = $Message;
              $this->feedbackmodel->Username = $Username;
              $this->feedbackmodel->Response  = "Submitted";
              
              echo json_encode($this->feedbackmodel);
        }
        else{
            
             $this->feedbackmodel = new FeedbackModel();
             
            $this->feedbackmodel->BranchID = $BranchID;
              $this->feedbackmodel->Title = $Title;
              $this->feedbackmodel->Message = $Message;
              $this->feedbackmodel->Username = $Username;
              $this->feedbackmodel->Response  = "Failed";
              
              echo json_encode($this->feedbackmodel);            
        }
        
        //$this->connection->closeConnection();
    }
    
    
    private function returnMemberID($username)
    {
        $MemberID = 0;
        
        $query = "select id from member where username = '$username' ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num= mysql_num_rows($result);
        
        if($num >0)
        {
            while($record = mysql_fetch_array($result)){
                
                $MemberID = $record[0];
            }
        }
        
        return $MemberID;
    }
    
}

$object = new RegisterFeedback();
?>