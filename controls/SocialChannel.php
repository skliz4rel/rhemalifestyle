<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SocialChannel
 *
 * @author skliz
 */

include("../config/connector.php");
include("../utility/Library.php");

class SocialChannel {
    //put your code here
     private $connection = null;
     private $library = null;
     
     
     function __construct(){
        $this->connection = new Connector();
        $this->connection->doConnection();
        
        $this->library = new Library();       
    }
 
    
    //Tis method would be used to activate social channel of the fellowship
    function activateSocialChannel(){
        
        $fellowshipid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['fellowshipid'])));
        $branchid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['branchid'])));
        
        $query = "update socialchannel set activateState = 'true' where fellowshipid = $fellowshipid and rhemabranchid = $branchid";
        
        $result =  mysql_query($query) or die(mysql_error());
        
        $rows = mysql_affected_rows();
    }
    
}

$object = new SocialChannel();


if(isset($_POST['activateChannel']))
    $object->activateSocialChannel();


?>