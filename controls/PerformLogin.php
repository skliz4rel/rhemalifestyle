<?php
session_start();
session_regenerate_id();
ob_start();

include("../config/connector.php");
include("../utility/Library.php");
include("../detectbrowsertype/Mobile_Detect.php");
 

class PerformLogin{
   
   public $connectionObject;
   public $library;
   public $devicetype;
   public $location;
   
   function PerformLogin(){
    
       $this->connectionObject = new Connector();
       $this->connectionObject->doConnection();
       $this->library = new Library();
       $this->devicetype = $this->library->detectBrowserType();
       
   }
   
   //This is going to perform the validate operation on the subitted values
   function validateLogin(){
       $username = $this->library->stopInjection($this->library->filter(trim($_POST['Username'])));
       $password = $this->library->stopInjection($this->library->filter(trim($_POST['Password'])));
      $branchid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['Branch'])));
       $admintype = $this->library->stopInjection($this->library->filter(trim($_POST['Admintype'])));
       
       $content = array('Username'=>$username,'Password'=>$password,'Branch'=>$branchid,'Admin type'=>$admintype);
       
       $error = "<font color='red'>Correct the following errors: <br/>";
       $test = true;
       foreach($content as $key => $value){
           
           if(strlen($value) < 1){
               
               $error .= " Enter ".$key."<br/>";
               $test = false;
           }
       }
       
       if($test == false){
           //This means that there is validation error
           $error .= "</font>";
           
           if($this->devicetype == "computer")
            $this->location = "../Login.php?error=".urlencode($error);
           else
               $this->location = "../mobileadmin/Loginm.php?error=".  urlencode($error);
           
            $this->library->Redirect($this->location);
       }
       else{
           //There is no validation error here
           
           if($branchid == 0)
           {
                $error = "Branch does not exits";
                
              if($this->devicetype == "computer")
                $this->location = "../Login.php?error=".urlencode($error);
              else{
                  $this->location = "../mobileadmin/Loginm.php?error=".urlencode($error);
                  
                  //echo "here";
                  //die();
              }
              
                $this->library->Redirect($this->location);
           }
           else{               
                $this->loginUser($username, $password, $branchid, $admintype);                              
           }           
       }
   }
   
   //This method is going to return the branch id 
   function returnBranchID($branch){
       
       $query = "select id from rhemabranch where branchname = '$branch' ";
       $result = mysql_query($query) or die(mysql_error());
       
       $id = 0;
       
       while($record = mysql_fetch_array($result)){
           $id =  $record[0];
       }
       
       return $id;
   }
   
   
   //This method is going to validate the user login process
   function loginUser($username,$password,$branchid,$admintype){
       
       $query = "select id from admin where username = '$username' and password = '$password' and rhemabranchid = '$branchid' and admintype = '$admintype'";
       
       $result = mysql_query($query) or die(mysql_error());
       
       $id = 0;
       
       while($record = mysql_fetch_array($result)){
           $id = $record['id'];
       }
       
            if($id > 0){
                   $this->createSession($admintype, $username,$branchid);
                    
                 if($this->devicetype == "computer")
                    $this->location = "../home.php";
                 else
                     $this->location = "../mobileadmin/homem.php";
                 
                   $this->library->Redirect($this->location);
               }
               else{
                  
                    $error = "You entered a wrong login details";
                    
                     if($this->devicetype == "computer")
                        $this->location = "../Login.php?error=".urlencode($error);
                     else
                         $this->location = "../mobileadmin/Loginm.php?error=".urlencode($error);
                     
                    $this->library->Redirect($this->location);
                  
               }
   }
   
   
   //This method would be used to create the session that would be used to create administrator
   private function createSession($admintype,$username,$branchid){
       $_SESSION['admintype'] = $admintype;
       $_SESSION['username'] = $username;
       $_SESSION['branchid'] = $branchid;
   }
   
}
   $object = new PerformLogin();
        
        if(isset($_POST['Submit']))
             $object->validateLogin();
        else{
            //This is going to redirect the user back to the login page
            $error = "Can't access page directly";
            
          if($object->devicetype == "computer")
             $object->location = "../Login.php?error=".urlencode($error);
          else{
              $object->location = "../mobileadmin/Loginm.php?error=".urlencode($error);
          }
          
            $object->library->Redirect($object->location);
        }
?>


<?php
ob_end_flush();
?>