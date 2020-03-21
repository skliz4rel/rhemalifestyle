<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AdminNavigation
 *
 * @author skliz
 */
class AdminNavigation {
    //put your code here
    
    function AdminNavigation(){
                
    }
    
    public function SuperAdminNav(){
        
        echo '            
         <ul data-role="listview">
          <li data-role="divider" data-theme="e">Super Admin</li>
          <li><a href="Settingm.php"  data-ajax="false">Settings</a></li>
          <li><a href="Createaccountm.php" data-ajax="false">Create Account</a></li>
          <li><a href="Editaccountm.php" data-ajax="false">Edit User Account</a></li>          
          <li><a href="Fellowshipcenterm.php" data-ajax="false">Enter Fellowship Centers</a></li>
           <li><a href="Wedding.php" data-ajax="false">Enter Wedding Annoucement</a></li>
           <li><a href="ViewWedding.php" data-ajax="false">Edit Wedding Annoucement</a></li>
           <li><a href="Letchat.php" data-ajax="false">Let\'s chat</a></li>
           
            <li><a href="EnterFellowships.php"  data-ajax="false">Church Fellowships</a></li>
            <li><a href="Uploadvideo.php"  data-ajax="false">Upload Video Messages</a></li>
          <li><a href="Uploadaudio.php" data-ajax="false">Upload Audio Messages</a></li>
        
          
          <li><a href="#"  data-ajax="false">View Ads</a></li>
        </ul>
    ';
    }
    
    
    public function PastorAdminNav(){
        
        echo '            
             <ul data-role="listview">
          <li data-role="divider" data-theme="e">Pastor Admin</li>
          
          <li><a href="Entermessage.php"  data-ajax="false">Enter Message Sermon</a></li>
          <li><a href="Viewmessage.php" data-ajax="false">View Message Sermons</a></li>
          <li><a href="Questions.php"  data-ajax="false">View Members Questions</a></li>
          
                   
         <li><a href="#"  data-ajax="false">View Ads</a></li>
        </ul>
        ';
    }
    
    public function HodAdminNav(){
        
        echo '
             <ul data-role="listview">
          <li data-role="divider" data-theme="e">Departmental Hod Admin</li>
            <li><a href="home.php"  data-ajax="false">Home</a></li>
          <li><a href="#"  data-ajax="false">Enter Urgent Annoucement</a></li>
          <li><a href="#" data-ajax="false">Enter Info</a></li>
          <li><a href="#" data-ajax="false">Make Broadcast</a></li>
          <li><a href="#" data-ajax="false">Virtual Meeting Room</a></li>
          <li><a href="#"  data-ajax="false">View Ads</a></li>
         
        </ul>
        ';
    }
    
    public function MultimediaNav(){
        
         echo '
             <ul data-role="listview">
             <li data-role="divider" data-theme="e">Multimedia Admin</li>
               <li><a href="home.php"  data-ajax="false">Home</a></li>
          <li><a href="#"  data-ajax="false">Upload Video Messages</a></li>
           <li><a href="Uploadvideo.php" data-ajax="false">Upload Video Messages</a></li>
          <li><a href="Uploadaudio.php"  data-ajax="false">Upload Audio Messages</a></li>
         <li><a href="#"  data-ajax="false">View Ads</a></li>
         
        </ul>
        ';
    }
    
    
   public function ControlAdminNav(){
       echo '
             <ul data-role="listview">
             <li data-role="divider"  data-theme="e">Control Admin</li>
               <li><a href="home.php"  data-ajax="false">Home</a></li>
               <li><a href="Setting.php" data-ajax="false">Enter Rhema Branches</a></li>
               <li><a href="#"  data-ajax="false">View Ads</a></li>
         
        </ul>
        ';       
   }
   
}
?>