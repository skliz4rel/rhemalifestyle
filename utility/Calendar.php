<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Calendar
 *
 * @author skliz
 */
class Calendar {
    //put your code here
    
    public function returnMonthIndex($month){
        
        if($month == "Jan")
            return "01";
        else if($month == "Feb")
            return "02";
        else if($month == "Mar")
            return "03";
        else if($month == "Apr")
            return "04";
        else if($month == "May")
            return "05";
        else if($month == "Jun")
            return "06";
        else if($month == "Jul")
            return "07";
        else if($month == "Aug")
            return "08";
        else if($month == "Sep")
            return "09";
        else if($month == "Oct")
            return "10";
        else if($month == "Nov")
            return "11";
        else if($month == "Dec")
            return "12";        
    }
    
}
?>