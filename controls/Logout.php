<?php
session_start();
ob_start();

include('../utility/Library.php');
include("../detectbrowsertype/Mobile_Detect.php");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Logout
 * 
 * @author skliz
 */
class Logout {
    //put your code here
    private $objectLibrary = null;
    private $devicetype = null;
    private $location = null;    
    
    function __construct(){
        
        $this->objectLibrary = new Library();
        
        $this->devicetype =  $this->objectLibrary->detectBrowserType();
        
        unset($_SESSION['admintype']); unset($_SESSION['username']);
        
        $this->destroySessions();
        
      if($this->devicetype == "computer")
        $this->location = "../Login.php";
      else
          $this->location = "../mobileadmin/Loginm.php";
          
        $this->objectLibrary->Redirect($this->location);
    }
    
    //This is going to destroy the session that was created
   private function destroySessions(){
       
       session_destroy();       
       
   }
   
}


$object = new Logout();
?>