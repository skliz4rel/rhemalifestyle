<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PostSermonQuestion
 *
 * @author skliz
 */
header('Content-type: application/json');
include("../config/connector.php");
include("../utility/Library.php");
include("../webserviceObjects/QuestionModel.php");

class PostSermonQuestion {
    //put your code here
    
    public $connection = null;
    public $library = null;
    private $questionmodel = null;
    
    function PostSermonQuestion(){
        
        $this->connection = new Connector();
        $this->connection->doConnection();
        
        $this->library = new Library();
                
         $json = file_get_contents('php://input');
        $obj = json_decode($json);
        
        if(isset($obj))
            $this->register($obj);
    }
  
    
    private function register($obj){
       $BranchID =  $obj->{"BranchID"};
        $MemberUsername = $obj->{"MemberUsername"};
        $MessageID = $obj->{"MessageID"};
        $Question = $obj->{"Question"};                
        $date = date('Y-m-d');
        $time = date('H:m:s');
        
        $MemberID = $this->library->returnMemberID($MemberUsername);
        
        $query = "insert into question (ques, response, messageid, memberid, qTime, qDate ) 
values ('$Question', '', $MessageID,$MemberID, '$time','$date' ) ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_insert_id();
        
        if($id >0){
            
            $this->questionmodel = new QuestionModel();
            $this->questionmodel->BranchID =  $BranchID;
            $this->questionmodel->MemberUsername = $MemberUsername;
            $this->questionmodel->MessageID = $MessageID;
            $this->questionmodel->Question = $Question;
            $this->questionmodel->Response = "success";
            
            echo json_encode($this->questionmodel);
        }
        else{
            
            $this->questionmodel = new QuestionModel();
            $this->questionmodel->BranchID =  $BranchID;
            $this->questionmodel->MemberUsername = $MemberUsername;
            $this->questionmodel->MessageID = $MessageID;
            $this->questionmodel->Question = $Question;
            $this->questionmodel->Response = "failed";
            
            echo json_encode($this->questionmodel);
        }
    }
    
    
}

$object = new PostSermonQuestion();
?>