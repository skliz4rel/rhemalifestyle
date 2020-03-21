<?php
session_start();
session_regenerate_id();

include("../utility/Library.php");
include("AdminNavigation.php");

$library = new Library();
$library->protectPages();

/**
 * Description of Editaccountm
 *
 * @author skliz
 */
class Editaccountm {
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
      
          <header data-role="header"><a href="#" data-rel="back" data-theme="c">Back</a> <h1>Edit Account</h1></header>
          
          <div data-role="content">
              
            <fieldset data-role="fieldcontain">
              <label for="admintype">Admintype</label>
              <select id="admintype" name="admintype">
                  <option value="">Select Admintype</option>
                    <?php
                        	
                            $library->returnAdmins();
                            
                ?>      
                    
              </select>
            </fieldset>
              
              
              <fieldset data-role="fieldcontain">
                  <label for="username">Username</label>
                  <select name="username" id="username">
                      <option value="">Select Username</option>
                   </select>
               </fieldset>
              
              
              <fieldset data-role="fieldcontain">
                  <label for="password">Password</label>
                  <input type="password" name="password" id="password"/>
              </fieldset>
              
              <fieldset data-role="fieldcontain">
             <label for="firstname"></label>
                <input type="text" name="firstname" id="firstname" class="text">     
             </fieldset>
              
              <fieldset data-role="fieldcontain">
                  <label for="lastname">Last name</label>
                  <input type="text" name="lastname" id="lastname">
              </fieldset>
            
              
              <fieldset data-role="fieldcontain">
                  <label for="position">Position</label>
                  <input type="text" name="position" id="position"/>
              </fieldset>
              
              
             
              <fieldset data-role="controlgroup" data-type="horizontal">
			<legend>Choose State</legend>
			
			<label for="active">Active</label>
			<input type="radio" name="active" value="Not Active" id="active" checked/>
			
			<label for ="notactive">Not Active</label>
			<input type="radio" name="notactive" value="Not Active" id="notactive"/>
		
		</fieldset>
              
              <fiieldset data-role="controlgroup" data-type="horizontal">
                  
                  <input type="button" name="retrieve" id="retrieve" value="Retrieve" data-theme="b">
                  <input type="button" name="Update" id="Update" value="Update" >
                  <input type="button" name="Delete" id="Delete" value="Delete" data-theme="b">
              </fieldset>
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