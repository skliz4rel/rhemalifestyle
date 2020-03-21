<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include("../config/connector.php");
include("../utility/Library.php");


class Message{
    
    private $connection = null;
    private $library = null;    

    
    function __construct(){
        $this->connection = new Connector();
        $this->library = new Library();
        $this->connection->doConnection();        
    }
    
    public function saveMessage(){
        
        $date = (trim($_POST['date']));
        $scripture = $this->library->stopInjection($this->library->filter(trim($_POST['scripture'])));
        $title = $this->library->stopInjection($this->library->filter(trim($_POST['title'])));
        $preacher = $this->library->stopInjection($this->library->filter(trim($_POST['preacher'])));
        $message = $this->library->stopInjection($this->library->filter(trim($_POST['message'])));
        $branchid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        
        $content = array('Date'=>$date,'Title'=>$title,'Preacher'=>$preacher,'Scripture'=>$scripture,'Message'=>$message);
        
        $error="Correct the following error : <br/>";
        $test = true;
        
        foreach($content as $key => $value){
            if(empty($value)){
                $error .="Enter ".$key;
                $test = false;
            }
        }
        
        //Ensure that you add a regular expression here to test the date format to be sre there is no malicious data been passed

        if($test == false){
            //redirect the page to show the error
            $location = "../Entermessage.php?error=".urlencode($error);
            $this->library->Redirect($location);
        }
        else{
            
            $preacherid = $preacher;
            
             if($preacher == "Visitor"){
                 $preacherid =  $this->savePreacher();
             }
            
         
            
           $id =  $this->addMessage($date,$scripture,$title,$preacherid,$message,$branchid);
           
           $location = "";
           if($id >0)
           {
               $location = "../Entermessage.php?success=success";
           }
           else{
               $location = "../Entermessage.php?error=".urlencode("Error while saving");
           }
           
           
           mysql_close();
           $this->library->Redirect($location);
        }
    }
    
    
    //This method is going enter the message details in to the database
    private function addMessage($date,$scripture,$title,$preacherid,$message,$branchid){
        
        //echo $content['Title'];
        
        $query = "insert into message (mdate,title,preacherid,scriptures,message,rhemabranchid) 
            values ('$date','$title',$preacherid,'$scripture','$message', $branchid ) ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_insert_id();
        
        return $id;
    } 
    
    
    //This method is going to be used to save the name of the preacher into the database
    private function savePreacher(){
        
        $id = 0;
       
           $name = $this->library->stopInjection($this->library->filter(trim($_POST['outsidepreacher'])));
            
            $residentState = false;
            $id = $this->saveVisitingPreacher($name, $residentState);  
                   
        
        return $id;
    }
    
    
    //This method is going to be used to save visiting pastor into the database
    private function saveVisitingPreacher($title_name,$residentState){
        
        $query = "insert into Preacher (name,residentPastor) values ('$title_name',0) ";
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_insert_id();
        
        return $id;
    }
    
    
    //This method is going to be used to display the messages of a particular man of God
    public function displayMessagesofPreacher(){
        
        $date = $_POST['date'];
        $preacherid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['preacher'])));
        
        $startdate = $date."-01"; $enddate = $date."-31";
        $query = "select * from message where mdate >= '$startdate' and mdate <= '$enddate' and preacherid=$preacherid";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $output = "";
        
        while($record = mysql_fetch_array($result)){
            
            $output .= "
            <div class='list'><span class='clear'></span>
            <span>$record[2]  <a href='#' class='showmsg'  data-wrap-msg = '$record[4]'  data-wrap-title='$record[2]' >View message</a></span> <span>$record[1] <a href='Editmessage.php?id=$record[0]' target='_blank'><img src='images/edit.png' title='Click on icon to view details'/></a>     <a href='#' data_link='controls/Message.php?id=$record[0]&deleteMsg=1' class='delete' data_id='$record[0]'><img src='images/delete.png' title='Click on icon to delete'/></a> &nbsp; <a href='Questions.php?id=$record[0]' target='_blank' title='View questions on sermon'><img src='images/ques.png' /></a></span>
                
            </div>
            <hr/>
            ";
        }
        
        mysql_close();
        
        echo  $output;
     //   echo $startdate."_".$enddate;
    }
    
    
     //This method is going to be used to collect all the message of a particular rhema branch 
    public function displayMessageofBranch(){
        
        $date = $_POST['date'];
        $branchid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        
        $query = "select id, title from message where mDate = '$date' and rhemabranchid = $branchid ";
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        
        $value = "<option value=''>Choose Message</option>";
        if($num > 0){
            
            while($record = mysql_fetch_array($result)){
                
                $value .= "<option value=$record[0]>$record[1]</option>";
            }
        }
        
        echo $value;
    }
    
    
    public function deleteMessageofPreacher(){
        
        $id = (int)$this->library->stopInjection($this->library->filter(trim($_POST['id'])));
        
        $query = "delete from message where id = $id";
                
        $result = mysql_query($query);
        
        $rows = mysql_affected_rows();
        
        $location = "";
        if($rows >0){
            $location ="../Viewmessage.php?message=".urlencode("successfully deleted");
        }
        else
            $location = "../Viewmessage.php?message=".urlencode("Failed to deleted");
        
        
        mysql_close();
        $this->library->Redirect($location);
    }
    
    
    public function collectMessage(){
        
        $query = "select * from message ";
        $result = mysql_query($query) or die(mysql_error());
        
        return $result;
    }
  
    
    public function updateMessage(){
        
        $date = (trim($_POST['date']));
        $scripture = $this->library->stopInjection($this->library->filter(trim($_POST['scripture'])));
        $title = $this->library->stopInjection($this->library->filter(trim($_POST['title'])));
        $preachername = $this->library->stopInjection($this->library->filter(trim($_POST['preacher'])));
        $message = $this->library->stopInjection($this->library->filter(trim($_POST['message'])));
        
        $branchid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        $messageid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['messageid'])));
                
        $preacherid = $this->library->returnPreacherIDbyname($preachername);
        
        $query = "update Message set mdate = '$date', title = '$title', scriptures = '$scripture', message = '$message', preacherid = $preacherid where rhemabranchid = $branchid and id = $messageid ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $rows = mysql_affected_rows();
        
        $location  = "";
                
        if($rows >0)
            $location = "../Editmessage.php?id=9&success=updated";
        else 
            $location  = "../Editmessage.php?id=9&error=updatefailed";
        
        $this->library->Redirect($location);
    }
    
    function deleteMessage()
    {
        $messageid = $_GET['id'];
       $query = "delete from Message where id = $messageid"; 
       
       $result = mysql_query($query) or die(mysql_error());
       
       $rows = mysql_affected_rows();
       
       $location  = "";
       
       if($rows >0)
           $location  = "../Viewmessage.php?success=deleted";
       else
           $location  = "../Viewmessage.php?error=deleteError";
       
       $this->library->Redirect($location);
    }
}

//This is going to be save the information of the prechaer to the database which the id would be used to 

$object = new Message();

if(isset($_POST['savemessage'])){
     
    $object->saveMessage();
}

else if(isset($_POST['displayMessages'])){
    
    $object->displayMessagesofPreacher();
}

else if(isset($_POST['collectMessage'])){
    
    $object->displayMessageofBranch();
}

else if(isset($_POST['updateMessage']))
    $object->updateMessage();

if(isset($_GET['deleteMsg']))
    $object->deleteMessage();
?>