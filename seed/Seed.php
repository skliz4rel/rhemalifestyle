<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Seed
 *
 * @author skliz
 */
include("../config/connector.php");
include("Countries.php");
include("Branch.php");  //This is the model that would be used to seed the branch in db

//This class would be used to seed the database
class Seed {
    //put your code here
    public $connection = null;
    public $country = null;
    
    function __construct(){
        
        $this->connection = new Connector();
        $this->connection->doConnection();
        
        $this->country = new Countries();
        
        $this->clearTableContent();
        
        $this->seedDatabase();        
        
        $this->seedBranches();
        
        mysql_close();
    }
    
    //This is going to clear the content in the table first
    function clearTableContent(){
        
        $query = "truncate continent ";
        
        mysql_query($query);
        
         $query = "truncate country ";
        
         mysql_query($query);
         
         $query = "truncate rhemabranch";
         
         mysql_query($query);
    }
    
    
    //This fnctioin would be usd to seed the database
    function seedDatabase(){
        
        $query = "insert into continent ( name ) values ('Africa')";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_insert_id();
        
        $this->seedAfricancountry($id);
        
        
        $query = "insert into continent ( name ) values ('Asia')";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_insert_id();
        
        
         $query = "insert into continent ( name ) values ('Australia')";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_insert_id();
        
        
        
        
        $query = "insert into continent ( name ) values ('Europe')";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_insert_id();
        
        
        $query = "insert into continent ( name ) values ('North America')";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_insert_id();
        
        $query = "insert into continent ( name ) values ('South America')";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_insert_id();
        
    }
    
    
    //This is going to seed the content of Africa
    function seedAfricancountry($id){
        
        $country = $this->country->africanCountries();
        
        foreach($country as $key => $value){
            
            $query = "insert into Country (name, language, continentid) values ( '$value','',$id ) ";
            
           $result =  mysql_query($query) or die(mysql_error());
        }
        
    }
    
    
    //This is going to seed the branches
    function  seedBranches(){
        
        $branch1 = new Branch();
        $branch1->Address = "Ebute metta west, off filling station";
        $branch1->Name = "National Head Quarter";
        $branch1->CountryID = 1;
        
        $this->storeBranch($branch1);
        
         $branch2 = new Branch();
        $branch2->Address = "Illorin, Lokoja, Kwara";
        $branch2->Name = "International Head Quarter";
        $branch2->CountryID = 1;
        
        $this->storeBranch($branch2);
    }
    
    
    function storeBranch($branch){
        
        $query = "insert into rhemabranch (branchname,branchaddress, countryid) values ('$branch->Name','$branch->Address',$branch->CountryID ) ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id = mysql_insert_id();
        
       // return $id;
    }
}

$object = new Seed();
?>