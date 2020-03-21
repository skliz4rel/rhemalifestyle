<?php
session_start();
session_regenerate_id();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Processor
 *
 * @author skliz
 */
include('../../config/connector.php');
include('../../utility/Library.php');


class Processor {
    //put your code here
    private $connection = null;
    public $library = null;
    
    function __construct() {
        
        $this->connection = new Connector();
        $this->connection->doConnection();
        
        $this->library = new Library();
        
        if(isset($_POST['Submit']))
            $this->LoginAdmin();
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
            $location = "../Login.php?error=error";            
             $this->library->Redirect($location);
            
        }
        else{
           $username = $this->library->stopInjection($this->library->filter(trim($username)));
           $password = $this->library->stopInjection($this->library->filter(trim($password)));
           
           $hashpassword = $this->library->doEncryption($password);
            
           $query = "select id from controladmin where username = '$username' and password = '$hashpassword' ";
           
           $result = mysql_query($query) or die(mysql_error());
           
           $num = mysql_num_rows($result);
           
           $location = "";
           if($num >0){
               $location = "../Home.php";
               
               $_SESSION['R_service_user'] = $username;
              $this->library->Redirect($location);          
           }
           else{
               $location = "../Login.php?error=error";
               $this->library->Redirect($location);              
           }
        }
                
    }
    
    
    
}

$object = new Processor();

?>