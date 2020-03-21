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
 * Description of Createm
 *
 * @author skliz
 */
class Createm {
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
      
          <header data-role="header">
              <a href="#" data-rel="back" data-theme="c">Back</a><h1>CREATE ADMINISTRATOR ACCOUNT</h1>
          </header>
          
          
          <div data-role="content">
     
             <form method="post" action="">
              
                 <fieldset data-role="fieldcontain">
                     <label for="admintype">Admin Type</label>
                     <select id="admintype" name="admintype" required>
                         
                      <option value="">Select Admintype</option>
                      <?php
                      
                         $library->returnAdmins();
                      
                      ?>                      
                      </select>
                  </fieldset>
                 
                 
                 <fieldset data-role="fieldcontain">
                     <label for="username">Username</label>
                     <input type="text" id="username" name="username" required/>
                 
                 </fieldset>
                 
                 <fieldset data-role="fieldcontain">
                     <label for="password">Password</label>
                     <input type="password" id="password" name="password" required/>
                  </fieldset>
                 
                 
                 <fieldset data-role="fieldcontain">
                     
                     <label for="firstname">First name</label>
                     <input type="text" id="firstname" name="firstname" required/>
                  </fieldset>
                     
                <fieldset data-role="fieldcontain">
                     <label for="lastname">Last name</label>
                     <input type="text" id="lastname" name="lastname" required/>
                  </fieldset>
                 
                 <fieldset data-role="fieldcontain">
                     <label for="position">Position</label>
                     <input type="text" id="position" name="position" required/>
                 </fieldset>
                 
                 <div data-role="controlgroup" data-type="horizontal">
                     <input type="submit" value="Create" id="create" data-theme="b"/>
                     <input type="reset" value="Reset" id="reset"/>
                 </div>
             </form>
           </div>
          
          
          <footer data-role="footer" class="ui-btn">Powered by Rhema Social Media Team</footer>
          
     </section>
  </body>
  
  
 <script src="../js_m/jquery-1.7.1.min.js"></script>
 <script src="../js_m/jquery.mobile-1.1.2.min.js"></script>
 <script type="text/javascript">
     
     $(document).ready(function (){
         
         
         
     });
  </script>
 </html>