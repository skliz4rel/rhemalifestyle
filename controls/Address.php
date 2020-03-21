<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Address
 *
 * @author skliz
 */

include("../config/connector.php");
include("../utility/Library.php");
include("../webObject/FellowshipLocationModel.php");
include("../webObject/FellowshipCenterModel.php");
include("../webObject/FellowshipCenterDetailModel.php");

class Address {
    //put your code here
    public $connection = null;
    private $library = null; 
    private $locationObject = null;
    
    function __construct(){
        $this->connection = new Connector();
        $this->connection->doConnection();
        
        $this->locationObject = new FellowshipLocationModel();
        $this->library = new Library();
    }
    
    //This function is going to save the fellow ship center 
    public function SaveFellowLocation(){
        
        $city = $this->library->stopInjection($this->library->filter(trim($_POST['city'])));
        $num = (int)$this->library->stopInjection($this->library->filter(trim($_POST['num'])));
        $branchid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        
        $city = strtoupper($city);
        
        $location = "";
        $id= 0;
    
        //we would check if the city already exits to avoid duplication 
        $num = $this->checkIfCityExits($city);
        
        if($num >0){
            //This means that the city already exits
            $id = -1;
        }
        else{
            $query = "insert into FellowshipLocation (Location, num,rhemabranchid) values ('$city', $num,$branchid) ";

            $result = mysql_query($query) or die(mysql_error());

            $id = mysql_insert_id();
        }
       
       
       if($id > 0)
           $location = "../fellowshipcenter.php?success=success";
       else if($id == 0)
           $location = "../fellowshipcenter.php?error=error";
       else if($id == -1)
           $location  = "../fellowshipcenter.php?error=alreadyexits";
       else{}
       
       $this->library->Redirect($location);
    }
        
    
    public function checkIfCityExits($city){
        
        $query = "select id from fellowshipLocation where Location  = '$city' ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        return $num;
    }
    
    //This method would be used to update the fellowship location 
    public function updateLocation(){
        
        $selectedcity =$this->library->stopInjection($this->library->filter(trim($_POST['enteredcity'])));
        $city = strtoupper($this->library->stopInjection($this->library->filter(trim($_POST['city']))));
        $num = (int)$this->library->stopInjection($this->library->filter(trim($_POST['num'])));
        
        $query = "update fellowshiplocation set Location  = '$city', num = '$num' where Location  = '$selectedcity' ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_affected_rows();
        
        $location  = "";
        if($num >0)
        {
            $location = "../fellowshipcenter.php?success=updated";
        }
        else
            $location = "../fellowshipcenter.php?error=updatefailed";
        
        $this->library->Redirect($location);
    }
    
    
    public function SaveFellowshipLocationAddress(){
        
        $locationid = $this->library->stopInjection($this->library->filter(trim($_POST['locationid'])));
        $branchid = $this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        $centername = strtoupper($this->library->stopInjection($this->library->filter(trim($_POST['centername']))));
        $address = strtoupper($this->library->stopInjection($this->library->filter(trim($_POST['address']))));
        
        $content = array("Location"=>$locationid, "Center name"=>$centername, "Address"=>$address);
        
        $error = "Correct the following errors in the Store Address center form :<br/>";
        
        $test = true;
        foreach($content as $key => $value){
            
            if(empty($value)){
                $test = false;
                $error .= "Enter ".$key."<br/>";
            }            
        }
        
        if($test == false){
        
            echo $error;            
        }
        else{
            
            //we would check if the center name already exist before we go ahead to save it intp the database
            $num = $this->checkFellowshipCentername($locationid,$centername,$branchid);
            
            if($num >0){
                echo 0; //This is going to tell the client app that the center name already exits
            }
            else{
                $query = "insert into  fellowshiplocationaddress (centeraddress, centername, fellowshiplocationid, branchid)
                    values ('$address','$centername',$locationid, $branchid)
                ";

                $result = mysql_query($query) or die(mysql_error());

                $id = mysql_insert_id();

                echo $id; 
            }
        }
    }
    
    
    //Please check if the fellowship location address name exits
    function checkFellowshipCentername($locationid,$centername,$branchid){
        
        $query = "select id from fellowshiplocationaddress where fellowshiplocationid = $locationid and centername = '$centername' and branchid  = $branchid ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        return $num;
    }
    
    
    function deleteFellowshipLocation(){
        
        $location = $this->library->stopInjection($this->library->filter(trim($_POST['location'])));
        $branchid = $this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        $query = "delete from fellowshiplocation where Location = '$location' and rhemabranchid = $banchid "; 
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_affected_rows();
        
        echo $num;
    }
    
    
    function backToFellowshipcenter(){
        
        $location = "../fellowshipcenter.php";
        
        $this->library->Redirect($location);
    }
    
    
    //This function is going to be used to collect city detains
    function collectLocationDetails(){
        
         $city = $this->library->stopInjection($this->library->filter($_POST['selectedcity']));
         $branchid = (int)$this->library->stopInjection($this->library->filter($_POST['branchid']));
        
        $query = "select num,Location from fellowshipLocation where Location  = '$city' and rhemabranchid = $branchid ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        if($num >0 ){
            
            while($record = mysql_fetch_array($result)){
                $this->locationObject->Num = $record[0];
                $this->locationObject->Location = $record[1];
            }
            
            echo json_encode($this->locationObject);
        }
        else{            
            echo null;
        }
    }
    
    
    //This function is going to be used to collect centers in a particular branches location
    function collectCenters(){
        
        $branchid = (int)$this->library->stopInjection($this->library->filter($_POST['branchid']));
        $locationid = $this->library->stopInjection($this->library->filter($_POST['locationid']));
        
        $query = "select id, centername from fellowshiplocationaddress where branchid = $branchid and fellowshiplocationid = $locationid ";
        
        $result = mysql_query($query) or die(mysql_error());
        $num = mysql_num_rows($result);
        
        $webserviceContainer = array();
        $index = 0;
        while($record = mysql_fetch_array($result)){
            
            $jsonObject = new FellowshipCenterModel();
            $jsonObject->ID = $record[0];
            $jsonObject->Name = $record[1];
            
            $webserviceContainer[$index] = $jsonObject;
            
            $index++;
        }
        
        echo json_encode($webserviceContainer);
    }
    
    
    //This function is going to return details of a fellowship center
    function returnFellowshipCenterDetails(){
        
        $branchid = (int)$this->library->stopInjection($this->library->filter($_POST['branchid']));
        $centerid = (int)$this->library->stopInjection($this->library->filter($_POST['centerid']));
        
        $query = "select centername, centeraddress from fellowshiplocationaddress where  id = $centerid and branchid = $branchid";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $webserviceObject = new FellowshipCenterDetailModel();
        while($record = mysql_fetch_array($result)){
            
            $webserviceObject->Name = $record[0];
            $webserviceObject->Address = $record[1];
            
        }
        
        echo json_encode($webserviceObject);
    }
    
    function deleteCenteraddress(){
        
        $branchid = (int)$this->library->stopInjection($this->library->filter($_POST['branchid']));
        $centerid = (int)$this->library->stopInjection($this->library->filter($_POST['centerid']));
        
        $query = "delete from fellowshiplocationaddress where branchid = $branchid and id = $centerid";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $rows = mysql_affected_rows();
        
        echo $rows; //returns the affected rows
    }
    
    
    function updateFellowshipCenterDetails(){
        
        $centername = (int)$this->library->stopInjection($this->library->filter(trim($_POST['centername'])));
        $centerid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['savedcenters'])));
        $address = $this->library->stopInjection($this->library->filter(trim($_POST['address'])));
        $branchid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        
        $query = "update fellowshiplocationaddress set centername = '$centername', centeraddress = '$address'
where branchid = $branchid and id = $centerid";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $rows = mysql_affected_rows();
        
        $location = "";
        if($rows >0){
            $location = "../fellowshipcenter.php?success=updatedaddress";
        }
        else{
            $location = "../fellowshipcenter.php?error=addressnotupdated";
        }
        
        $this->library->Redirect($location);
    }
    
}

$object = new Address();


if(isset($_POST['storelocation'])){
    $object->SaveFellowLocation();
}

if(isset($_POST['deleteLocation'])){
    
   $object->deleteFellowshipLocation();
}

if(isset($_POST['updatelocation'])){
    
   $object->updateLocation();
}

if(isset($_POST['saveaddress']))
    $object->SaveFellowshipLocationAddress();

if(isset($_POST['deleteCenteraddress']))
    $object->deleteCenteraddress();

if(isset($_POST['collectLocationDetails'])){
    
    $object->collectLocationDetails();
}

if(isset($_POST['collectCenters']))
{
    $object->collectCenters();
}

if(isset($_POST['fellowshipcenterdetails'])){
    
    $object->returnFellowshipCenterDetails();
}

if(isset($_POST['updateaddress'])){
    
    $object->updateFellowshipCenterDetails();
}

if(isset($_GET['redirect']))
{
    $object->backToFellowshipcenter();
}
?>