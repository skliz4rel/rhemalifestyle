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
         <ul class="sidebar-nav">
          <li class="sidebar-brand"><a href="#">Super Admin</a></li>
          <li><a href="home.php">Home</a></li>
          <li><a href="setting.php">Settings</a></li>
          <li><a href="createaccount.php">Create Account</a></li>
          <li><a href="editaccount.php">Edit User Account</a></li>          
          <li><a href="fellowshipcenter.php">Enter Fellowship Centers</a></li>
           <li><a href="Wedding.php">Enter Wedding Annoucement</a></li>
           <li><a href="ViewWedding.php">Edit Wedding Annoucement</a></li>
           <li><a href="Letchat.php">Let\'s chat</a></li>
           
            <li><a href="EnterFellowships.php">Church Fellowships</a></li>
            <li><a href="Uploadvideo.php">Upload Video Messages</a></li>
          <li><a href="Uploadaudio.php">Upload Audio Messages</a></li>
        
          
          <li><a href="controls/Logout.php">Logout</a></li>
        </ul>
    ';
    }
    
    
    public function PastorAdminNav(){
        
        echo '            
             <ul class="sidebar-nav">
          <li class="sidebar-brand"><a href="#">Pastor Admin</a></li>
            <li><a href="home.php">Home</a></li>
          <li><a href="Entermessage.php">Enter Message Sermon</a></li>
          <li><a href="Viewmessage.php">View Message Sermons</a></li>
          <li><a href="Questions.php">View Members Questions</a></li>
          
                   
          <li><a href="controls/Logout.php">Logout</a></li>
        </ul>
        ';
    }
    
    public function HodAdminNav(){
        
        echo '
             <ul class="sidebar-nav">
          <li class="sidebar-brand"><a href="#">Departmental Hod Admin</a></li>
            <li><a href="home.php">Home</a></li>
          <li><a href="#">Enter Urgent Annoucement</a></li>
          <li><a href="#">Enter Info</a></li>
          <li><a href="#">Make Broadcast</a></li>
          <li><a href="#">Virtual Meeting Room</a></li>
          <li><a href="controls/Logout.php">Logout</a></li>
         
        </ul>
        ';
    }
    
    public function MultimediaNav(){
        
         echo '
             <ul class="sidebar-nav">
               <li><a href="home.php">Home</a></li>
          <li class="sidebar-brand"><a href="#">Upload Video Messages</a></li>
           <li><a href="Uploadvideo.php">Upload Video Messages</a></li>
          <li><a href="Uploadaudio.php">Upload Audio Messages</a></li>
          <li><a href="controls/Logout.php">Logout</a></li>
         
        </ul>
        ';        
    }
    
    
   public function ControlAdminNav(){
       echo '
             <ul class="sidebar-nav">
               <li><a href="home.php">Home</a></li>
               <li class="sidebar-brand"><a href="Setting.php">Enter Rhema Branches</a></li>
               <li><a href="controladmin/Logout.php">Logout</a></li>
         
        </ul>
        ';       
   }
   
}
?>