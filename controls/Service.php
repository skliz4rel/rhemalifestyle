<?php
session_start();
session_regenerate_id();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Service
 *
 * @author skliz
 */
include("../utility/Library.php");
include("../config/connector.php");

class Service {
    //put your code here
    
    private $library = null;
    private $connection = null;
        
    function __Construct(){
         $this->library = new Library();
        $this->connection = new Connector();
        $this->connection->doConnection();
    }
    
    function LoginAdmin(){
              
        $username =trim($_POST['Username']);
        
        $password = trim($_POST['Password']);
        
        $error = "Correct the following errors<br/>";
        
        $test = true;
        
        $content = array('Username'=>$username, 'Password'=>$password);
        
        foreach($content as $key => $value){
            
            if(empty($value)){
                
                $error .= "Enter ".$key."<br/>";
                $test = false;
            }
        }
        
        $location = "";
        if($test == false){            
            $location = "../service/Login.php?error=error";            
             $this->library->Redirect($location);
            
        }
        else{
           $username = $this->library->stopInjection($this->library->filter(trim($username)));
           $password = $this->library->stopInjection($this->library->filter(trim($password)));
           
           $hashpassword = $this->library->doEncryption($password);
            
           $query = "select id from servicelogin where username = '$username' and password = '$hashpassword' ";
           
           $result = mysql_query($query) or die(mysql_error());
           
           $num = mysql_num_rows($result);
           
           $location = "";
           if($num >0){
               $location = "../service/Home.php";
               
               $_SESSION['R_service_user'] = $username;
              $this->library->Redirect($location);          
           }
           else{
               $location = "../service/Login.php?error=error";
               $this->library->Redirect($location);              
           }
        }
        
        
    }
    
}

$object = new Service();

if(isset($_POST['login']))
    $object->LoginAdmin();
?>