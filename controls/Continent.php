<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Continent
 *
 * @author skliz
 */
include("../config/connector.php");
include("../utility/Library.php");
include("../webObject/CountryModel.php");

class Continent {
    //put your code here
    
    public $connection = null;
    public $library = null;
    
    function __construct(){
        
        $this->library = new Library();
        $this->connection = new Connector();
        $this->connection->doConnection();
    }
    
    public function saveContinent(){
        
        
    }
    
    public function saveCounty(){
        
        $name = strtoupper($this->library->stopInjection($this->library->filter(trim($_POST['country']))));
        
        $code = strtoupper($this->library->stopInjection($this->library->filter(trim($_POST['code']))));
        
        $language = strtoupper($this->library->stopInjection($this->library->filter(trim($_POST['language']))));
        
        $continentid = (int)strtoupper($this->library->stopInjection($this->library->filter(trim($_POST['continentid']))));
        
        $num = $this->checkCountryName($name);
        if($num > 0){
            //This means that the the country is already is in existence
            echo "already exist";
        }
        else{
            $query = "insert into Country (Code,name,language, continentid) values ('$code','$name','$language', $continentid) ";

            $result = mysql_query($query) or die(mysql_error());

            $id = mysql_insert_id();

            if($id >0)
                echo "saved";
            else
                echo "failed";
        }
    }
    
    //This is going to check if the country name exists
    function checkCountryName($name){
        
        $query = "select name from country where name = '$name' ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        return $num;
    }
    
    //This function is going to return the countries in a continent
    function returnCountry_continent(){
        
       $continentid =  (int)$this->library->stopInjection($this->library->filter(trim($_POST['continentid'])));
        
       $query = "select id, name from country where continentid = $continentid ";
       
       $result = mysql_query($query) or die(mysql_error());
       
       $num = mysql_num_rows($result);
       
       $webserviceContainer = array();
       if($num >0){
           
           $index = 0;
           while($record = mysql_fetch_array($result)){
               
               $countryobj = new CountryModel();
               $countryobj->ID= $record[0];
               $countryobj->Name= $record[1];
               
               $webserviceContainer[$index] = $countryobj;
               $index++;
           }
       }
       
       echo json_encode($webserviceContainer);
    }
}


$object = new Continent();

if(isset($_POST['saveCountry']))
       $object->saveCounty();

if(isset($_POST['returnCountry_continent'])){
    $object->returnCountry_continent();    
}

?>