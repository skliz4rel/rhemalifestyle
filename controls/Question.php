<?php
include("../config/connector.php");
include("../webObject/Quesjsonobj.php");
include("../utility/Library.php");
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Question
 *
 * @author skliz
 */
class Question {
    //put your code here
    
    private $connection = null;
    private $questionjson = null;
    private $library = null;
    
    function __construct(){
        $this->connection = new Connector();
        $this->connection->doConnection();
        
        $this->library = new Library();
        $this->questionjson = new Quesjsonobj();
    }
    
    
    //This method is going to be used to display the questions of member
    public function displayQuestions(){
        
        $messageid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['messageid'])));
        $status = $this->library->stopInjection($this->library->filter(trim($_POST['status'])));
        $date = $this->library->stopInjection($this->library->filter(trim($_POST['date'])));
                       
        $preachername =  "";

        $preachername = $this->returnPreachername($messageid);
        
        $memberUsername = "";
        
        $responseState = false;
        
        if($status == "answered")
            $responseState = true;
        else
            $responseState = false;
        
        $query = "select  id, ques, memberid from Question where messageid = $messageid and ResponseState = '$responseState' and qDate = '$date'";
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        $output = "";
        
        //preparing the json object that would be sent to the client user page
        $this->questionjson->preacher = $preachername;
        
        if($num >0){
            
            $counter = 0;
            while($record = mysql_fetch_array($result)){
                
                 $memberUsername = $this->library->returnMemberUsername($record[2]);
                             
                 $array = array("QuestionID"=>$record[0], "Question"=>$record[1], "MemberUsername"=> $memberUsername);
                                  
                 //adding content to the json object
                 $this->questionjson->questionobj[$counter] = $array;
                 
                 $counter++;
            }
        }
        
        echo  json_encode($this->questionjson);
       // echo $this->questionjson;
    }
        
    //This method is going to return the name of the preacher
    private function returnPreachername($messageid){
        
        $preacherid= $this->library->returnPreacherID($messageid);
        
        $preachername = "";
        if($preacherid > 0){
            
            $preachername = $this->library->returnPreachername($preacherid);
        }
        
        return $preachername;
    }
    
    
   
    
    //This function is going to be used to responsd to the question
    function respondToQuestion(){
    
        $quesid = $this->library->stopInjection($this->library->filter(trim($_POST['quesid'])));
        $branchid = $this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        $question = $this->library->stopInjection($this->library->filter(trim($_POST['question'])));
        $response = $this->library->stopInjection($this->library->filter(trim($_POST['response'])));
        
        $rDate = date("Y-m-d");
        
        $rTime = date("H-m-s");
        
        $query = "update Question set response = '$response', rDate = '$rDate', rTime = '$rTime' where id = $quesid and rhemabranchid= $branchid ";  
        
        $result = mysql_query($query) or die(mysql_error());
        
        $rows = mysql_affected_rows();
        
        $location  = "";
        
        if($rows > 0)
            $location = "../Respond_Question.php?success=responded";
        else
            $location = "../Respond_Question.php?error=notresponded";
        
        $this->library->Redirect($location);
    }
    
    
    public function deleteQuestion(){
        
        $quesid = (int)$this->library->stopInjection($this->library->filter(trim($_GET['quesid'])));
        $branchid = (int)$this->library->stopInjection($this->library->filter(trim($_GET['branchid'])));
        
        $query = "delete from Question where id =$quesid and rhemabranchid = $branchid";
        $result = mysql_query($query) or die(mysql_error());
        
        $rows =  mysql_affected_rows();
        
        $location= "";
        
        if($rows > 0)
            $location = "../Questions.php?success=deleted";
        else
            $location = "../Questions.php?error=notdeleted";
        
        $this->library->Redirect($location);
    }
    
    
}

$object = new Question();

if(isset($_POST['displayQuestions'])){
    
    $object->displayQuestions();
    //echo $_POST['messageid'];
}

if(isset($_POST['respondtoQuestion'])){
    
     $object->respondToQuestion();
}

if(isset($_GET['deleteQuestion']))
    $object->deleteQuestion();
?>