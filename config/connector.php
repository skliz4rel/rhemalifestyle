<?php
include("config.php");

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Connector{
    
    public $connect = null;
    
    function Connector(){
        
    }
    
    public function doConnection(){
                   
        $connect = mysql_connect(SERVER,USERNAME,PASSWORD);

        if($connect){
            
            mysql_select_db(DATABASE, $connect);
        }
    }
     
    //This method is going to close the connection
    public function closeConnection(){
        
        mysql_close(); //This is going to close all connection to the database
    }
}
?>