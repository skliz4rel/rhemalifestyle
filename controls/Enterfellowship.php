<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Enterfellowship
 *
 * @author skliz
 */
include("../config/connector.php");
include("../utility/Library.php");
include("../webObject/FellowshipModel.php");
include("UploadImage.php");


class Enterfellowship {
    //put your code here
    
    public $connection = null;
    public $library = null;
    public $imageUploader = null;
    
    
    function __construct(){
        $this->connection = new Connector();
        $this->library = new Library();
        $this->connection->doConnection();
        
        $this->imageUploader = new Uploadimage();
    }
    
    
    public function register(){
        
       $branchid =  $this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
       $name = $this->library->stopInjection($this->library->filter(trim($_POST['name'])));
       $head = $this->library->stopInjection($this->library->filter(trim($_POST['head'])));
       
       $file = $_FILES['logo'];
       
       $content = array('Name'=>$name, 'Head of Fellowship'=>$head);
       
       $test = true;
       $error = "Correct the following errors :<br/>";
       foreach ($content as $key => $value){
       
           if(empty($value)){
            
               $test = false;
               $error .= "Enter ".$key."<br/>";
           }
       }
       
       if(!isset($file))
        {
            $test = false;
            $error .= "Upload Fellowship Logo";
        }
       
       if($test == false){
       
           $location = "../EnterFellowships.php?error=".urlencode("Fill the form fields");
           $this->library->redirect($location);
       }
       else{
       
        $fellowshipName = $name;
       $num =  $this->checkIfFellowsipNameExist($fellowshipName,$branchid);
           
      if($num < 1){
       
                $query = "insert into fellowship (name,head, rhemabranchid) values ( '$name', '$head',$branchid) ";

                $result= mysql_query($query) or die(mysql_error());

                $fellowshipid = mysql_insert_id();

                $location = "";

                if($fellowshipid > 0){

                    //This is going  to create the social page for the newly created fellowship here
                    $this->registerSocialPage($fellowshipid, $name, $branchid,$file);

                    $location = "../EnterFellowships.php?success=success";
                }
                    else
                        $location = "../EnterFellowships.php?error=".urlencode("Error while inserting fellowship values. try again");

      }
      else {
          $location = "../EnterFellowships.php?error=".urlencode("Fellowship already exits !!!!!!!");
      }
      
      
        $this->library->redirect($location);
    }
   
   }
   
   
   //This function would be used to check if the fellowship name already exits
   function checkIfFellowsipNameExist($fellowshipName,$branchid){
       
       $query = "select id from  fellowship where name = '$fellowshipName' and rhemabranchid = $branchid ";
       
       $result = mysql_query($query) or die(mysql_error());
       
       $num = mysql_num_rows($result);
       
       return $num;
   }
   
   
   //This function is going to be used to register fellowsh ip social page upon it creation
   function registerSocialPage($fellowshipid, $fellowshipname, $branchid, $photo){
       
         $imagename = $photo['name'];
           $imagesize = $photo['size'];
           $location = "../Upload/fellowshiplogo/";
           $regexp = '/\.(jpg|jpeg|JPG|gif|jpe|png)$/i';
         
          
           
        $photoname  = $this->imageUploader->upload($photo, 1000000, $location, $regexp);
           
       // die();
      
       $channelName = str_replace("Fellowship", "Channel", $fellowshipname);
       
       $query = "insert into socialchannel (name, activateState,logo, fellowshipid, rhemabranchid) values ('$channelName','false','$photoname',$fellowshipid, $branchid)";
       
       $result = mysql_query($query) or die(mysql_error());
       
       $id = mysql_insert_id();
       
      
   }
   
   
   //This is going to be used to display the fellowship details through json response
   function displayFellowshipDetails(){
       $fellowshipid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['fellowshipid'])));
       $branchid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
       
       $query = "select name, head from fellowship where rhemabranchid = $branchid and id = $fellowshipid";
       
       $result = mysql_query($query) or die(mysql_error());
       
       $num = mysql_num_rows($result);
       
       $webserviceObject = new FellowshipModel();
       if($num >0){
       
           while($record = mysql_fetch_array($result)){
               
               $webserviceObject->Head = $record['head'];
               $webserviceObject->Name = $record['name'];
           }
           
           echo json_encode($webserviceObject);
       }
       else
       {
           echo json_encode($webserviceObject);
       }
   }
    
   
   function updateFellowship(){
       $branchid = (int)trim($_POST['branchid']);
       $name = $this->library->stopInjection($this->library->filter(trim($_POST['name'])));
       $head = $this->library->stopInjection($this->library->filter(trim($_POST['head'])));
       $savedfellowshipid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['savedfellowship'])));
       
       $query = "update fellowship set name = '$name', head = '$head' where rhemabranchid = $branchid and id = $savedfellowshipid ";
       
       $result = mysql_query($query) or die(mysql_error());
       
       $rows = mysql_affected_rows();
       
       $location = "";
       
       if($rows > 0)
           $location = "../EnterFellowships.php?success=updated";
       else
           $location =  "../EnterFellowships.php?error=updaterror";
       
       $this->library->Redirect($location);
   }
   
   
   function deleteFellowship(){
       
       $branchid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
       $savedfellowshipid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['savedfellowship'])));
       
       $query = "delete from fellowship where id = $savedfellowshipid and rhemabranchid = $branchid";
       
       $result = mysql_query($query) or die(mysql_error());
       
       $nums = mysql_affected_rows();
       
       $location  = "";
       
       if($nums >0)
           $location = "../EnterFellowships.php?success=deleted";
       else 
           $location = "../EnterFellowships.php?error=deletefailed";
       
       $this->library->Redirect($location);
   }
   
}


$object = new Enterfellowship();

if(isset($_POST['submit'])){    
    $object->register();
}

if(isset($_POST['updateFellowship']))
    $object->updateFellowship();

if(isset($_POST['displayDetails'])){
    $object->displayFellowshipDetails();    
}

if(isset($_POST['deleteFellowship']))
    $object->deleteFellowship();
?>