<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

 class People{
    
    private $name = "Jide Akindejoye";
    
    private $address= "13, Ibarapa street, ebute metta west.";
        
    private $phone = "08131528807";
    
    public function __construct(){
                
    }    
    
    public function setName($name){
        $this->name = $name;        
    }
    
    public function getName(){
        
        return $this->name;
    }
    
    public function setAddress($address){
        
        $this->address = $address;
    }
    
    public function getAddress(){
        
        return $this->address;
    }
}
?>