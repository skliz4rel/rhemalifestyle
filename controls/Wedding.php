<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Wedding
 *
 * @author skliz
 */
include("../config/connector.php");
include("../utility/Library.php");
include("../webObject/WeddingModel.php");

class Wedding {
    //put your code here
    private $connection = null;
    private $library = null;
    
    function __construct(){
        $this->connection = new Connector();
        $this->connection->doConnection();
        $this->library = new Library();
    }
    
    
    //This is going to save wedding information into the database
    public function saveWeddinginfo(){
        $branchid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        $groom = $this->library->stopInjection($this->library->filter(trim($_POST['groom'])));
        $bride = $this->library->stopInjection($this->library->filter(trim($_POST['bride'])));
        $weddingtime = $this->library->stopInjection($this->library->filter(trim($_POST['weddingtime'])));
        $weddingdate = $this->library->stopInjection($this->library->filter(trim($_POST['weddingdate'])));
        $weddingaddress = $this->library->stopInjection($this->library->filter(trim($_POST['weddingaddress'])));
        $receptiondate = $this->library->stopInjection($this->library->filter(trim($_POST['receptiondate'])));
        $receptiontime = $this->library->stopInjection($this->library->filter(trim($_POST['receptiontime'])));
        $receptionaddress = $this->library->stopInjection($this->library->filter(trim($_POST['receptionaddress'])));
        
        
        
        $content = array('Groom'=>$groom, 'Bride'=>$bride,'Wedding Time'=>$weddingtime, 'Wedding Date'=>$weddingdate, 'Wedding Address'=>$weddingaddress, 'Reception Date'=>$receptiondate, 'Reception Time'=>$receptiontime, 'Reception Address'=>$receptionaddress);
        
        $error = "Correct the following errors :<br/>";
        
        $state = true;
        
        foreach($content as $key => $value){
            
            if(empty($value)){
                $error .= "Enter ".$key."<br/>";
                
                $state = false;
            }
        }
        
        if($state == false){
            $location = "../Wedding.php?error=$error";
            $this->library->Redirect($location);
        }
        else{
            
            $this->register($groom,$bride,$weddingtime,$weddingdate,$weddingaddress,$receptiondate,$receptiontime,$receptionaddress,$branchid);
        }
    }
    
    private function register($groom,$bride,$weddingtime,$weddingdate,$weddingaddress,$receptiondate,$receptiontime,$receptionaddress,$branchid){
               
        $query = " insert into wedding (bride,groom,weddingtime,weddingdate, weddingaddress, receptiondate, receptiontime, receptionaddress, marriedstatus, rhemabranchid)

        values ('$bride','$groom','$weddingtime','$weddingdate','$weddingaddress','$receptiondate','$receptiontime','$receptionaddress', false, $branchid)

        ";

        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_insert_id();
        
        if($id >0){
            
            $location = "../Wedding.php?success=success";
        }
        else
            $location = "../Wedding.php?error=".urlencode("Failed to insert values");
        
        $this->library->Redirect($location);
    }
    
    
    function collectWeddingInMonth(){
        
        $month = $this->library->stopInjection($this->library->filter(trim($_POST['month'])));
        $year = $this->library->stopInjection($this->library->filter(trim($_POST['year'])));
        $startdate = $year."-".$month."-01";
        $enddate = $year."-".$month."-31";
        
        $branchid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        $status = $this->library->stopInjection($this->library->filter(trim($_POST['status'])));
        
        $query = "";
        
        if($status == "Married")
           $query = "select * from wedding where rhemabranchid = $branchid  and marriedstatus =true ";
        else
            $query = "select * from wedding where rhemabranchid = $branchid and marriedstatus = false"; 
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        $webserviceContainer = array();
        
        $index = 0;
        if($num >0){
            
            while($record = mysql_fetch_array($result)){
                
                $webserviceObject = new WeddingModel();
                $webserviceObject->Id = $record[0];
                $webserviceObject->Bride = $record[1];
                $webserviceObject->Groom = $record[2];
                $webserviceObject->WeddingTime = $record[3];
                $webserviceObject->WeddingDate = $record[4];
                $webserviceObject->WeddingAddress = $record[5];
                $webserviceObject->ReceptionDate = $record[6];
                $webserviceObject->ReceptionTime = $record[7];
                $webserviceObject->ReceptionAddress = $record[8];
                
                $webserviceContainer[$index] = $webserviceObject;
                
                $index++;
            }
        }
        
        echo json_encode($webserviceContainer);
    }
    
    
    function updateWeddingInfo(){
        
        $weddingid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['weddingid'])));
        $branchid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        $groom = $this->library->stopInjection($this->library->filter(trim($_POST['groom'])));
        $bride = $this->library->stopInjection($this->library->filter(trim($_POST['bride'])));
        $weddingtime = $this->library->stopInjection($this->library->filter(trim($_POST['weddingtime'])));
        $weddingdate = $this->library->stopInjection($this->library->filter(trim($_POST['weddingdate'])));
        $weddingaddress = $this->library->stopInjection($this->library->filter(trim($_POST['weddingaddress'])));
        $receptiondate = $this->library->stopInjection($this->library->filter(trim($_POST['receptiondate'])));
        $receptiontime = $this->library->stopInjection($this->library->filter(trim($_POST['receptiontime'])));
        $receptionaddress = $this->library->stopInjection($this->library->filter(trim($_POST['receptionaddress'])));
        
        $query = "update wedding set bride = '$bride', groom = '$groom', weddingtime = ' $weddingtime', weddingdate = '$weddingdate',
weddingaddress='$weddingaddress', receptiondate = '$receptiondate', receptiontime = '$receptiontime', receptionaddress='$receptionaddress'

where rhemabranchid =$branchid and id = $weddingid";
        
  $result = mysql_query($query)  or die(mysql_error());
        
  $num = mysql_affected_rows();
  
  $location = "";
  
  if($num > 0)
      $location = "../EditWedding.php?success=updated&id=".$weddingid;
  else
      $location = "../EditWedding.php?error=updatefailed&id=".$weddingid;
  
     $this->library->Redirect($location);
  
    }
    
}


$object = new Wedding();

if(isset($_POST['submit'])){
    
    $object->saveWeddinginfo();
}

if(isset($_POST['update'])){
    
    $object->updateWeddingInfo();
}

if(isset($_POST['displayWeddingInMonth'])){
    $object->collectWeddingInMonth();
}
?>