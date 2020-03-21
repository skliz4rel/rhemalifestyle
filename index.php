<?php
session_start();
session_regenerate_id();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author skliz
 * 
 */
 include("detectbrowsertype/Mobile_Detect.php");
 include("utility/Library.php");
 
class Index {
    //put your code here
      
   public $library = null;
    
    function __construct(){
        
        $this->library = new Library();
       
        $devicetype =  $this->library->detectBrowserType();
        
      
        
        if($devicetype == "computer"){
            $this->DisplayComputerView();
        }
        else{
            $this->DisplayMobileView();
        }
        
    }
    
    
    
    //This method is going to call the template for the computer system
    function DisplayComputerView(){
        
        $_SESSION['computerview'] = "mycomputerview".session_id();
        $location = "Login.php";
        $this->library->Redirect($location);
    }
    
    //This is going to call the template for the mobile view
    function DisplayMobileView(){
        $_SESSION['mobileview'] = "mobileview".session_id();
        $location = "mobileadmin/Loginm.php";
        $this->library->Redirect($location);
    }
    
}

$object = new Index();
?>
