<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CollectCountries
 *
 * @author skliz
 * 
 */

include("../config/connector.php");
include("../webserviceObjects/CountryModel.php");

class CollectCountries {
    //put your code here

    public $connection = null;
    private $countryObject= null;
    private $webserviceContainer = null;
    
    function __construct(){
        $this->connection = new Connector();
        $this->connection->doConnection();
        
        $this->webserviceContainer = array();
                        
        if(isset($_GET['continent'])){
            
            $continentid = $this->returnContinentID($_GET['continent']);
           
            $this->collectCountry($continentid);
        }
        
        
        $this->connection->closeConnection();
    }
    
    //This is going to return continent id
    private function returnContinentID($continent){
        
        $query = "select id from continent where name = '$continent' ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_num_rows($result);
        
        $continentid = 0;
        if($id >0)
        while($record = mysql_fetch_array($result)){
            
            $continentid = $record[0];
        }
        
        return $continentid;
    }
    
    //This method is going to connect the countries under this continent
    private function collectCountry($continentid){
        
        $query = "select name, language from country where continentid = $continentid ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        $index= 0;
                    
            while($record = mysql_fetch_array($result)){
                $this->countryObject = new CountryModel();
                $this->countryObject->Country = $record[0];
                $this->countryObject->Language = $record[1];
            
                $this->webserviceContainer[$index] = $this->countryObject;
                
                $index++;
            }
            
          //  echo $_GET['jsonp'] . '('.json_encode($this->webserviceContainer).')';
            echo json_encode($this->webserviceContainer);
       
    }
    
}

$object = new CollectCountries();

?>