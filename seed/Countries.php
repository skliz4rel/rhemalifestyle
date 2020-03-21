<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Countries
 *
 * @author skliz
 */
//This class is going to contain all the countries according to continent
class Countries {
    //put your code here
    
    public function __construct(){
        
    }
    
    public  function africanCountries(){
        
        $country = array(
            
            "Nigeria","Ghana","Senegal","Lake Chad","South Africa","Cameroon"
        );
        
        return $country;
    }
    
    public function europeCountries(){
        
        $country = array(
            
            "England","Portugal","Spain","Germany","France"
        );
        
        return $country;
    }
    
    public function northamericanCountries(){
        
        $country = array(
        
            "USA","Canada","Haiti"
        );
        
        return $country;
    }
    
    
    public function southamericanCountries(){
        
        $country = array(
            
            "Uruguay","Brazil","Argentina"
        );
        
        return $country;
    }
    
    
    public function australiaCountries(){
        
        $country = array(
            
            "Australia","News zealand"
        );
        
        return $country;        
    }
    
    
    public function asianCountries(){
        
        $country = array(
            
            "China","Indonesia","Japan","Taiwan"
        );
        
        return $country;
    }
}

?>