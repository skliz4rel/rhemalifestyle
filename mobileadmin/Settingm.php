<?php
session_start();

    include("AdminNavigation.php");
    include("../utility/Library.php");
    include("../config/connector.php");

    $connection = new Connector();
    $connection->doConnection();
    $library = new Library();
    $library->protectPages();
    
    $object = new AdminNavigation();
	
    $success = "";
	
	$error = "";
	
	if(isset($_GET['success'])){
		$success = $_GET['success'];
	}
	
	if(isset($_GET['error'])){
		$error = $_GET['error'];	
	}
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Settingm
 *
 * @author skliz
 */
class Settingm {
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
                    
                    form{
                        
                        background:white;
                        padding:20px 20px 20px 20px;                        
                        -moz-border-radius: 8px;                       
                        -webkit-border-radius: 8px;
                        border-radius: 8px;
                    }
                    
                    
                    
                 </style>                 
                 
                 
       </head>
       
  <body>
      
      <section data-role="page">
          
          <header data-role="header"><a href="#" data-rel="back" data-role="button">Back</a><h1>Setting</h1></header>
          
          <div data-role="content">
              
              
              
<div data-role="collapsible-set">
	
	<div data-role="collapsible" >
		<h2 data-theme="e">Enter Country</h2>
		<form method="post" action="../controls/Continent.php">

                <fieldset data-role="fieldcontain">
              
   
                   <label for="continentid">Continent</label>                    
                <select name="continentid" id="continentid" required>
                  <option value="">Select Continent</option>
                  
               		<?php                    	
		      		$result= $library->returnContinent();						
						
						while($record = mysql_fetch_array($result)){
							
							echo "<option value=$record[0]>$record[1]</option>";
						}                                              
                                          
					?>               
                </select>
                   
                   </fieldset>
               
            <fieldset data-role="fieldcontain">              
     
                <label for="code">Country code</label>
                <input type="text" name="code" id="code" required/>
            </fieldset>
                
                    <fieldset data-role="fieldcontain">          
     
                <label for="country">Country</label>
               <input type="text" name="country" id="country"  class="text" required />
          
               </fieldset>
               
              <fieldset data-role="fieldcontain">
            
               <label for="language">Language</label>
                <input type="text" name="language" id="language" class="text">
              </fieldset>
            
                <input type="submit" name="saveCountry" id="saveCountry" value="Submit"  class="button"  data-inline="false" data-theme="b">
            
            
             </form>

	</div>
	
	<div data-role="collapsible">
		<h2>Enter State</h2>
             <form method="post" action="../controls/Continent.php">
                 
                 <div data-role="fieldcontain">
                     
                     <label for="choosecontinent">Continent</label>
                     <select name="choosecontinent" id="choosecontinent" required>
                     <option value="">Select Continent</option>
                     <?php
                     
                        	$result= $library->returnContinent();
						
						
						while($record = mysql_fetch_array($result)){
							
							echo "<option value=$record[0]>$record[1]</option>";
						}
                     ?>                     
                 </select>
                   
                </div>

                    <label id="loading1"><img src="../images/loading.gif"> &nbsp;&nbsp; Loading countries in continent ...</label>
                    
                 <div data-role="fieldcontain">
                     <label for="choosecountry">Country</label>
                     <select name="choosecountry" id="choosecountry">
                         <option value="">Select Country</option>
                         
                         
                     </select>
                 </div>
                 
               
              
 
                 
                 <div data-role="fieldcontain">
                    <label for="state">State</label>
                <input type="text" name="state" id="state"  class="text" required>
                                
                 </div>   
                    
                          
                 <div data-role="fieldcontain">
                     
                     <label for="enteredstate">Saved States</label>
                      <select id="enteredstate" name="enteredstate">
                          <option value=''>Select state</option>
                       </select>
                 </div> 
                 
              <div data-role="controlgroup"  data-type="horizontal">
                 <input type="submit" name="saveState" id="save" value="Save" data-theme="b" /> 
                 <input type="button" name="updateState" id="updateState" value="Update"/>
                <input type="button" name="deleteState" id="deleteState" value="Delete"  data-theme="b"/>
              </div>
             
                 </form>
	</div>

    
    <div data-role="collapsible">
		<h2>Enter Men of God</h2>
                <form name="form1" method="post" action="controls/Setting.php">
                    
               <div data-role="fieldcontain">
                    <label for="position">Select Position</label>
                    
                 <select name="position" id="position" required>
                  <option value="">Select Position</option>
                  <option value="Rev">Rev</option>
                  <option value="Pastor">Pastor</option>
                  <option value="Minister">Minister</option>
                </select>
               </div>
                    
                    
               <div data-role="fieldcontain">
                    <label for="name">Enter name</label>
                <input type="text" name="name" id="name"  class="text" required>                   
               </div>
                    
                    <input type="submit" name="savePreacher" id="save" value="Submit"  data-theme="b">
                </form>
	</div>

    
    <div data-role="collapsible">
		<h2>Update Men of God</h2>
		
                 <form name="form1" method="post" action="controls/Setting.php">
                <div data-role="fieldcontain">
                <label for="prevpreacher">Select Preacher</label>
                <select name="prevpreacher" id="preacher" required>
                	<option value="">Select Preacher</option>
                     	<?php
						
			$result = $library->returnPreachers();
                    	  while($record = mysql_fetch_array($result)){
							  
				  	echo "<option value='$record[1]'>$record[1]</option>";
				}
					
					?>
                </select>
                </div>
                     
                
          <fieldset data-role="fieldcontain">                
                          <label for="title">Title</label>
                      <input type="text" readonly  name="title" id="title" class="title" Placeholder="Preacher title"/>
            </fieldset>       
               
             
              <fieldset data-role="fieldcontain" class="ui-hide-label">
                      <label for="name" >Name</label>
                      <input type="text" name="name" id="name" class="text name" >
                </fieldset>
                      
              <div data-role="controlgroup" data-type="horizontal">
                 <input type="submit" value="Update"  name="updatePreacher" data-theme="b">
                <input type="submit" value="Delete" class="button" name="deletePreacher"/>
                <input type="reset" name="reset" value="Reset" data-theme="b"/>
               </div>
                 
                     
                <input type="hidden" value="<?php echo $_SESSION['branchid']; ?>" name="branchid">
                
                
                </form>
	</div>

    
    
    <div data-role="collapsible">
		<h2>Monthly Enter Scriptures</h2>
		
<form method="post" action="">

<fieldset data-role="fieldcontain">

<label for="scriptures">Scriptures</label>
<textarea  name="scriptures" id="scriptures" placeholder="Enter your Scripture" required></textarea>

</fieldset>


<input type="submit" value="Save" id="save"  data-theme="b"/>


</fieldset>

</form>

	</div>

    
</div>
              
              
              
              
              
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