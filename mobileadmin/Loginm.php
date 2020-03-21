<?php
session_start();
session_regenerate_id();

include('../config/connector.php');
include('../utility/Library.php');

$connection = new Connector();
$connection->doConnection();

$libObj = new Library();
$libObj->destroySessions();

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Loginm
 *
 * @author skliz
 */
class Loginm {
    //put your code here
}

?>
<!doctype html>
<html>
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
      
      <div data-role="page" data-theme="b">
          
          <div data-role="header" data-position="fixed"><h1>Login Administrator</h1></div>
          
    <div data-role="content">

<p>
    Please enter your user name and password. <a href="/Account/Register">Register</a> if you don't have an account.
</p>

<form action="../controls/PerformLogin.php" method="post" data-ajax="false"><div class="validation-summary-valid" data-valmsg-summary="true"><ul><li style="display:none"></li>
</ul></div>    <ul data-role="listview" data-inset="true">
        <li data-role="list-divider">Details</li>
        
        <li data-role="fieldcontain">
            
            <?php
            
                if(isset($_GET['error']))
                    echo "<font color='red'>". $_GET['error']."</font>";
                
            ?>
            
        </li>

        <li data-role="fieldcontain">
            <label for="Username">User name</label>
            <input data-val="true" data-val-required="The User name field is required." id="Username" name="Username" type="text" value="" />            
        </li>

        <li data-role="fieldcontain">
            <label for="Password">Password</label>
            <input data-val="true" data-val-required="The Password field is required." id="Password" name="Password" type="password" />            
        </li>
        
        
        <li data-role="fieldcontain">
            
            <label for="Branch">Rhema Branch</label>
            <select name="Branch" id="Branch">
                <option value="">Select Branch</option>
                
                  <?php
                    
                        $resultset = $libObj->selectBranches();
                       
                        while($record = mysql_fetch_array($resultset)){
                            echo "<option value='$record[0]'> $record[1]</option>";
                        }
                    ?>
                
             </select>
        </li>
        
        <li data-role="fieldcontain">
            <label for="Admintype">Admintype</label>
            <select name="Admintype" id="Admintype">
                <option value="">Select Admintype</option>
                <option value="Super Admin">Super Admin</option>
                    <option value="Pastor">Pastor</option>
                    <option value="Hod">Hod</option>
                    <option value="Multimedia">Multimedia</option>
            </select>
        </li>
        
        <li data-role="fieldcontain" data-theme="d">
            <label for="RememberMe">Remember me?</label>
            <input data-val="true" data-val-required="The Remember me? field is required." id="RememberMe" name="RememberMe" type="checkbox" value="true" /><input name="RememberMe" type="hidden" value="false" />
        </li>

        
        <li data-controls="horizontal">
            <input type="submit" name="Submit" value="Log in" data-inline="true" />
            &nbsp;&nbsp;&nbsp;
            <input type="reset" name="Reset" value="Reset" data-inline="true">
        </li>
    </ul>
</form>

            </div>

          <div data-role="footer"  data-position="fixed">Developed by Jiz Technologies</div>
      
      </div>
          
 </body>
   
    <script src="../js_m/jquery-1.7.1.min.js"></script>
 <script src="../js_m/jquery.mobile-1.1.2.min.js"></script>
 <script type="text/javascript">
     
     $(document).ready(function (){
         
         
         
     });     
  </script>
     
 
 </html>