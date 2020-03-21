<?php
session_start();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
include("../config/connector.php");
include("../utility/Library.php");

class Account{
    
    public $connection = null;
    public $library = null;
    
    function __construct(){
        $this->connection = new Connector();
        $this->library = new Library();
        $this->connection->doConnection();
    }

    
    
    public function createAdminAccount(){
        
        $validator = true;
        
        $admintype = $this->library->stopInjection($this->library->filter(trim($_POST['admintype'])));
        $username =$this->library->stopInjection($this->library->filter(trim($_POST['username'])));
        $password = $this->library->stopInjection($this->library->filter(trim($_POST['password'])));
        $firstname = $this->library->stopInjection($this->library->filter(trim($_POST['firstname'])));
        $lastname = $this->library->stopInjection($this->library->filter(trim($_POST['lastname'])));
     
       
        
        $content = array('Admintype'=>$admintype, "Username"=>$username,"Password"=>$password,"First name"=>$firstname,"Last name"=>$lastname);
        
        $error = "Correct the following errors : <br/>";
        foreach($content as $key => $value){
            if(empty($value)){
                
                $error .= "Enter ".$key."</br>";
                
                $validator = false;
            }
            
        }
        
        if($validator == false){
            $location = "../createaccount.php?error=".urlencode($error);
            $this->library->Redirect($location);
        }
        else{
            
            $admintype = strtoupper($_POST['admintype']);
            $username = strtoupper($_POST['username']);
            $password = strtoupper($_POST['password']);
            $firstname = strtoupper($_POST['firstname']);
            $lastname = strtoupper($_POST['lastname']);

            $id = $this->addAccount( $admintype,$username,$password,$firstname,$lastname, $position);
           
            $location = "";
            if($id >0){
                $location = "../createaccount.php?success=success";                 
            }
            if($id == 0){
                $location = "../createaccount.php?error=error";
            }
            
            //This is going to redirect
            $this->library->Redirect($location);
        }
    }
    
    
    public function collectAdminUser(){
        
        $admintype = $this->library->stopInjection($this->library->filter($_POST['admintype']));
        $branchid = (int)$this->library->stopInjection($this->library->filter($_POST['branchid']));
        
        $value = "";
        
        $query = "select id, username from admin where admintype = '$admintype' and rhemabranchid = $branchid "; 
        
        $result = mysql_query($query) or die(mysql_error());
        
        while($record = mysql_fetch_array($result)){
            
            $value .= "<option value='$record[0]'>$record[1]</option>";            
        }
        
        echo $value;
    }
    
    
    
    //This method is going to be used to add the admin account to the db
    private function addAccount( $admintype,$username,$password,$firstname,$lastname,$position){
        
        $branchid = $_SESSION['branchid'];
        $query = "insert into Admin (username,password,firstname,lastname,position,admintype,rhemabranchid,active) 
        values ( '$username', '$password','$firstname','$lastname','$position','$admintype','$branchid',1 ) ";
    
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_insert_id();
        
        return $id;
    }
    
    
   
    public function getAdminDetails(){
        
        $admintype = $this->library->stopInjection($this->library->filter($_POST['admintype']));
        $userid = (int)$this->library->stopInjection($this->library->filter($_POST['userid']));
        $branchid = (int)$this->library->stopInjection($this->library->filter($_POST['branchid']));
        
        $query = "select password,firstname,lastname,position,active from admin where admintype = '$admintype' and id= '$userid' and rhemabranchid = $branchid ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $value = "";
        
        while($record = mysql_fetch_array($result)){
            
            $state = "";
            if($record[4] == 0)
                $state = "Not Activated";
            else
                $state = "Activated";
            
            if($record[3] == null)
                $value .= $record[0]."_".$record[1]."_".$record[2]."_"."Unknown_".$state;
            else
                $value .= $record[0]."_".$record[1]."_".$record[2]."_".$record[3]."_".$state;
                        
        }
        
        echo $value;    
    }
    
    
    public function deleteAdminAccount(){
        
        $branchid = (int)$this->library->stopInjection($this->library->filter($_POST['branchid']));
        $admintype = $this->library->stopInjection($this->library->filter($_POST['admintype']));
        $userid = (int)$this->library->stopInjection($this->library->filter($_POST['userid']));
        
        $query = "delete from admin where rhemabranchid = $branchid and admintype = '$admintype' and id = $userid ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_affected_rows();
        
        echo $id;
    }
    
    
    public function deactivateAdminAccount(){
        
        
    }
    
    
    public function updateAdminAccount(){
        
        $admintype = $this->library->stopInjection($this->library->filter($_POST['admintype']));
        $userid = (int)$this->library->stopInjection($this->library->filter($_POST['userid']));
        $password = $this->library->stopInjection($this->library->filter($_POST['password']));
        $firstname = $this->library->stopInjection($this->library->filter($_POST['firstname']));
        $lastname = $this->library->stopInjection($this->library->filter($_POST['lastname']));
        $position = $this->library->stopInjection($this->library->filter($_POST['position']));
        $activestate = ($_POST['activestate']);
        $branchid = (int)$this->library->stopInjection($this->library->filter($_POST['branchid']));
        
        
            
        
        $query = "update admin set password = '$password', firstname = '$firstname', lastname = '$lastname', position = '$position', active=$activestate where id = $userid and admintype = '$admintype' and rhemabranchid = $branchid ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_affected_rows();
        
        echo $id;
    }
    
}


$object = new Account();

if(isset($_POST['create']))
    $object->createAdminAccount();

else if(isset($_POST['delete']))
    $object->deleteAdminAccount();

else if(isset($_POST['deactivate']))
    $object->deactivateAdminAccount();

else if(isset($_POST['retrieve']))
    $object->getAdminDetails();

else if(isset($_POST['collectuser']))
    $object->collectAdminUser();

else if(isset($_POST['update']))
    $object->updateAdminAccount();

?>