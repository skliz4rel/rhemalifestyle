<?php
session_start();

    include("AdminNavigation.php");
    include("../utility/Library.php");

    $library = new Library();
    $library->protectPages();
    
    $object = new AdminNavigation();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of homem
 *
 * @author skliz
 */
class homem {
    //put your code here
}

?>



<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>RhemaLifestyle Mobile</title>
		<link rel="stylesheet" href="../css_m/jquery.mobile-1.1.2.min.css" />
		<style type="text/css">
                    
                    
                 </style>                                                 
       </head>
  <body>     
      
        <section data-role="page">
      
            
            <header data-role="header" data-position="fixed"><a href="../controls/logout.php" data-role="button"  id="logout" data-ajax="false" data-theme="c">Logout</a> <h1>Home</h1></header>
      
            <div data-role="content">
      
              <?php
          
               if(isset($_SESSION['admintype']))
               {
                   if($_SESSION['admintype'] == "Super Admin"){
                       $object->SuperAdminNav();
                   }
                   else if($_SESSION['admintype'] == "Pastor")
                   {
                        $object->PastorAdminNav();
                   }
                   else if($_SESSION['admintype'] == "Hod"){
                       $object->HodAdminNav();
                   }
                   
                   else if($_SESSION['admintype'] == "Multimedia"){
                       
                       $object->MultimediaNav();
                   }
                   
               }            
          
          ?>
                
             </div>
            
            <div data-role="footer" class="ui-btn">Powered by Rhema Social Media Team</div>
       </section>
      
  </body>
  
 <script src="../js_m/jquery-1.7.1.min.js"></script>
 <script src="../js_m/jquery.mobile-1.1.2.min.js"></script>
 <script type="text/javascript">
     
     $(document).ready(function (){
         
         
         
     });
  </script>
     
  </html>