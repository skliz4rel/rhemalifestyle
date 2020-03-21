<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Letchat
 *
 * @author skliz
 */
include("../config/connector.php");
include("../utility/Library.php");
include("../webObject/LetchatModel.php");
include("../utility/Calendar.php");

class Letchat {
    //put your code here
    
     public $connection = null;
    public $library = null;
    public $calendarObject = null;
    
    
    function __construct(){
        $this->connection = new Connector();
        $this->library = new Library();
        $this->connection->doConnection();
        $this->calendarObject = new Calendar();
        
    }
    
    
    //This is going to register the values of the let chat information
    public function register(){
        
        $branchid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        $month= $this->library->stopInjection($this->library->filter(trim($_POST["month"])));
        $year = $this->library->stopInjection($this->library->filter(trim($_POST["year"])));
        
        $date = $year."-".$month."-01";
        
        //echo $date;
        
        //die();
        
        $summary = $this->library->stopInjection($this->library->filter($_POST["summary"]));
        
        $info = $this->library->stopInjection($this->library->filter($_POST["info"]));
        
        
        //This is going to perform the validation
        $content = array('Month'=>$month,'Year'=>$year, 'Summary'=>$summary, 'Information'=>$info);
        
        $error = "Correct the following errors : <br/>";  $test = true;
        
        foreach($content as $key => $value){
            
            if(empty($value)){
              $error .="Enter ".$key."<br/>";   
              $test = false;
            }            
        }
        
        if($test == false){
             $location = "../Letchat.php?error=".urlencode($error);
             $this->library->Redirect($location);
        }
        else{
            $query = "insert into  Letschat (ldate,summary,information,rhemabranchid )
                values ( '$date','$summary','$info',$branchid ) ";

            $result = mysql_query($query) or die(mysql_error());

            $id = mysql_insert_id();

            $location = "";
            if($id >0){
                $location = "../Letchat.php?success=saved";
            }
            else{
                $location = "../Letchat.php?error=".urlencode("Not inserted try again !!");
            }

            $this->library->Redirect($location);
        }
    }
    
    //This is going to return the let chat information for the month and year that was selected 
    function retrieveLetchatInformation(){
        
        $month = $this->library->stopInjection($this->library->filter(trim($_POST['month'])));
        $year = $this->library->stopInjection($this->library->filter(trim($_POST['year'])));
        $branchid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
       
        $monthIndex = $this->calendarObject->returnMonthIndex($month);
        
        $date = $year."-".$month."-01";
        
        $query = "select summary, information from letschat where  rhemabranchid = '$branchid' and ldate = '$date' ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $webserviceObject = new LetchatModel();
        
        $num = mysql_num_rows($result);
        
        if($num >0)
            while($record = mysql_fetch_array($result)){

                $webserviceObject->Summary = ($record[0]);
                $webserviceObject->Information = ($record[1]);
                $webserviceObject->ReturnState = "Has value";
            }
        else{
            $webserviceObject->ReturnState = "No value";
        }
        
        mysql_close();
        
        echo json_encode($webserviceObject);
       
    }
    
    
    //This function is going to be used to update the information of the letchat info
    function updateLetchat(){
        
        //echo "here";
        
        $month = $this->library->stopInjection($this->library->filter(trim($_POST['month'])));
        $year = $this->library->stopInjection($this->library->filter(trim($_POST['year'])));
        $summary = $this->library->stopInjection($this->library->filter($_POST['summary']));
        $information = $this->library->stopInjection($this->library->filter($_POST['info']));
        
        $branchid = (int)$this->library->stopInjection($this->library->filter($_POST['branchid']));
        
        //echo $branchid;
        
        //die();
        
        $date = $year."-".$month."-01";
        
        $query = "update letschat set summary = '$summary', information = '$information' where rhemabranchid = $branchid and ldate = '$date' ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $rows = mysql_affected_rows();
        
        $location  = "";
        
        if($rows >0)
            $location = "../Letchat.php?success=updated";
        else
            $location = "../Letchat.php?error=updateerror";
            
        $this->library->Redirect($location);
    }
     
    
    function deleteLetchat(){
         $month = $this->library->stopInjection($this->library->filter(trim($_POST['month'])));
        $year = $this->library->stopInjection($this->library->filter(trim($_POST['year'])));
        $branchid = (int)$this->library->stopInjection($this->library->filter($_POST['branchid']));
          $date = $year."-".$month."-01";
          
        $query = "delete from letschat where rhemabranchid = $branchid and ldate = '$date' ";
        
        $result =  mysql_query($query) or die(mysql_error());
        
        $rows = mysql_affected_rows();
        
        $location = "";
        
        /*
        if($rows >0)
            $location = "../Letchat.php?success=deleted";
        else
            $location = "../Letchat.php?error=deletefailed";
        
         $this->library->Redirect($location);
         * 
         */
        
        echo $rows;
    }
    
    function redirect(){
        
        $location = "../letchat.php";
        $this->library->Redirect($location);
    }
    
}


$object  = new Letchat();

if(isset($_POST['submit'])){
    
    $object->register();
}

if(isset($_POST['getLetchatInfo'])){
    
    $object->retrieveLetchatInformation();
}

if(isset($_POST['updateLetchat'])){
    
    $object->updateLetchat();
}

if(isset($_POST['deleteLetchat'])){
    $object->deleteLetchat();
}

if(isset($_GET['redirect'])){
    
    $object->redirect();
}
?>