<?php
include("../config/connector.php");
include("../utility/Library.php");
include("../webObject/CountryModel.php");
include("../webObject/StateModel.php");

class Setting{
    
    public $connection = null;
    private $library = null;
    
    function __construct(){
        $this->connection = new Connector();
        $this->connection->doConnection();
        
        $this->library = new Library();
    }
    
    public function savePreacher(){
        
        $branchid = $this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        $name = $this->library->stopInjection($this->library->filter(trim($_POST['name'])));
        $position = $this->library->stopInjection($this->library->filter(trim($_POST['position'])));
        
        $title = $position." ".$name;
        
        $title = strtoupper($title);
        
        $num = $this->checkIfPreacherExits($title,$branchid);
        
        $location  = "";
        if($num > 0){
          $location = "../setting.php?error=duplicatePreacher";
        }
        else{
        $query = "insert into Preacher (name,residentPastor,rhemabranchid) values ('$title',true,$branchid) ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_insert_id();
        
        mysql_close();
        
        if($id >0)
        {
            $location = "../setting.php?success=preacherSaved";            
        }
        
        $this->library->Redirect($location);
      }
    }
    
    
    //this method would be used to check if preacher already exits
    function checkIfPreacherExits($title,$branchid){
        
        $query = "select name from Preacher where name  = '$title' and rhemabranchid = $branchid";
        
        $result  = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        return $num;
    }
    
    
    //This is going to update the preachers name in the database
    function updatePreacherName(){
        
        $branchid = $this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        $prevpreacher = $this->library->stopInjection($this->library->filter(trim($_POST['prevpreacher'])));
        $title = $this->library->stopInjection($this->library->filter(trim($_POST['title'])));
        $name = $this->library->stopInjection($this->library->filter(trim($_POST['name'])));
        
        $updatevalue = $title." ".$name;
        
        $prevpreacher = strtoupper($prevpreacher);
        $updatevalue = strtoupper($updatevalue);
        
        $query = "update Preacher set name = '$updatevalue' where name='$prevpreacher'  and rhemabranchid = $branchid";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_affected_rows();
        $location = "";
        if($id >0){
            
            $location = "../setting.php?success=updatedpreacher";
        }else
        {
            $location = "../setting.php?error=preachernotupdated";
        }
        
        $this->library->Redirect($location);
    }
    
    function deletePreacher(){
        $branchid = $this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        $prevpreacher = $this->library->stopInjection($this->library->filter(trim($_POST['prevpreacher'])));
        
        $prevpreacher = strtoupper($prevpreacher);
        
        $query = "delete from Preacher where name = '$prevpreacher' and rhemabranchid = $branchid ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_affected_rows();
        
        $location = "";
        
        if($num >0){
            
            $location = "../setting.php?success=deletedpreacher";
        }else
        {
            $location = "../setting.php?error=preachernotdeleted";
        }
        
        $this->library->Redirect($location);
    }
    
    
    function saveScriptures(){
        
        $branchid = $this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        $scriptures = $this->library->stopInjection($this->library->filter(trim($_POST['scriptures'])));
        
        $error = ""; $check = false;
        
        if(isset($scriptures) && strlen($scriptures) > 1){
        
            $query = "update scriptures set scriptures = '$scripures' where rhemabranchid = $branchid";
            
            $result = mysql_query($query) or die(mysql_error());
            
            $num = mysql_affected_rows();
            
            $location =  "";
            if($num >0){                
                $location  = "../setting.php?success=saveScriptures";
            }
            else{
                $location = "../setting.php?error=scripturenotsaved";
            }
            
            $this->library->Redirect($location);
        }
        
    }
    
    
    function collectCountryinContinent(){
        
        $continentid = $this->library->stopInjection($this->library->filter(trim($_POST['continentid'])));
        
        $result = $this->library->returnCountry($continentid);
                
        $webserviceContainer = array();
        
        $num = mysql_num_rows($result);
        
        $index = 0;
        
        if($num >0)
        while($record = mysql_fetch_array($result)){
                        
            $countrymodel = new CountryModel();
            $countrymodel->ID = $record['id'];
            $countrymodel->Name = $record['name'];
            
            $webserviceContainer[$index] = $countrymodel;
            
            $index++;
        }
        
        echo json_encode($webserviceContainer);        
    }
    
    
    function saveState(){
        
        //$continentid = $_POST['choosecontinent'];
        $countryid = $this->library->stopInjection($this->library->filter(trim($_POST['choosecountry'])));
        $state = $this->library->stopInjection($this->library->filter(trim($_POST['state'])));
      
       
        
        $state = strtoupper($state);
        
        //Now we are going to check if the state exists before attempting to save it into the db
        $check = $this->library->checkIfStateAlreadyExits($countryid, $state);
        
         if(strpos($state, "state") == false)
           $state .= " STATE";
        
        $location = ""; //This is going to store the redirect location
        
        if($check == false){
            $query = "insert into state (Name,countryid) values ('$state',$countryid) ";

            $result = mysql_query($query) or die(mysql_error());

            $id = mysql_insert_id();

            
            if($id >0)
            {
                $location = "../setting.php?success=savedState";
            }
            else 
                $location = "../setting.php?error=stateError";
        }
        else
            $location  = "../setting.php?error=stateExits"; //duplicating state in db
        
        $this->library->Redirect($location);
    }
    
    
    function collectStateinCountry(){
            
        $countryid = $this->library->stopInjection($this->library->filter(trim($_POST['countryid'])));
        
        $query = "select id, Name from state where countryid = $countryid ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        $webserviceContainer = array();
        
        $index = 0;
        
        if($num >0)
            while($record = mysql_fetch_array($result)){
            
                $statemodel = new StateModel();
                $statemodel->ID = $record['id'];
                $statemodel->Name = $record['Name'];
                
                $webserviceContainer[$index] = $statemodel;
                
                $index++;
            }
            
         echo  json_encode($webserviceContainer);
    }
    
    
    //This function is going to be used to delete a state 
    function deleteState(){
        
        $countryid = $this->library->stopInjection($this->library->filter(trim($_POST['countryid'])));
        $stateid = $this->library->stopInjection($this->library->filter(trim($_POST['stateid'])));
        
        $query = "delete from state where id = $stateid and countryid = $countryid";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_affected_rows();
        
        echo $num;
        
        /*
        $location  = "";
        
        if($num >0){
            $location = "../setting.php?success=statedeleted";            
        }
        else
            $location = "../setting.php?error=statenotdeleted";
        
        $this->library->Redirect($location);
         * 
         */
    }
    
    
    function updateState(){
        
        $countryid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['countryid'])));
        $stateid =(int) $this->library->stopInjection($this->library->filter(trim($_POST['stateid'])));
        $newstate = $this->library->stopInjection($this->library->filter(trim($_POST['newstate'])));
        
         if(strpos($newstate, "state") == false)
           $newstate .= " STATE";
        
         $newstate = strtoupper($newstate);
        
        $query = "update state set Name = '$newstate' where countryid= $countryid and id = $stateid ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_affected_rows();
        
        if($num >0 ){
            echo "updated";
        }
        else
        {
            echo "no update";
        }
    }
}

$object = new Setting();

if(isset($_POST['savePreacher'])){
    
    $object->savePreacher();
    
}

else if(isset($_POST['collectCountryinContinent'])){
    $object->collectCountryinContinent();
}

else if(isset($_POST['saveState']))
    $object->saveState();

else if(isset($_POST['collectStateinCountry']))
    $object->collectStateinCountry();

else if(isset($_POST['deleteState']))
    $object->deleteState();


else if(isset($_POST['updateState']))
    $object->updateState();

else if(isset($_POST['updatePreacher'])){
    
    $object->updatePreacherName();
}

else if(isset($_POST['deletePreacher'])){
    
    $object->deletePreacher();
}

else if(isset($_POST['saveScriptures']))
    $object->saveScriptures();

else{
    
}
?>