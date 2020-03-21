<?php
session_start();
session_regenerate_id();

include("utility/Library.php");
include("AdminNavigation.php");

$library = new Library();
$library->protectPages();
  
$nav = new AdminNavigation();
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    
     <link href="css/custom-theme/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" /> 
     <link href="css/themes/custom-theme/jquery.ui.all.css" rel="stylesheet" />
         <script src="js/jquery-1.9.1.js"></script>
 <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
 
 <script type="text/javascript">
 var branchid = '<?php if(isset($_SESSION['branchid'])) echo $_SESSION['branchid'];?>';
// alert(branchid);
 
     $(document).ready(function (){
		 
		 $('#loading').hide();     $('#loading1').hide();

		   $('#admintype').change(function (){
			   var admin = $(this).val();
			   
			//	   alert(admin);  alert(branchid);
			   $('#loading').show();
				 $.post(
				 	'controls/Account.php',
				 	{collectuser:1,admintype:admin,branchid:branchid},
					function(data){
						$('#loading').hide();	
						//alert(data);
						
						$('#username').html(data);
						
					}
				 );
			});
			
			
			$('#retrieve').click(function (){
				
				var admintype = $('#admintype').val();
				var userid = $('#username').val();
				
				if(admintype.length < 1 || username.length < 1)
				{
					alert("Admintype and Username is compulsory");
				}
				else{
					
					$.post(
						'controls/Account.php',
						{retrieve:1,admintype:admintype,userid:userid,branchid:branchid},
						function (data){
							var values = data.split("_");
							
							//This is going to display the values
							$('#password').val(values[0]);
							$('#firstname').val(values[1]);
							$('#lastname').val(values[2]);
							$('#position').val(values[3]);
							
							
							if(values[4] == "Not Activated")
								$('#activestate').val("Not Activated");
							else
								$('#activestate').val("Activate");
						}
					);	
				}				
			});
			
			
			$('#Update').click(function (){
				var admintype = $('#admintype').val();
				var userid = $('#username').val();
				var password = $('#password').val();
				var firstname = $('#firstname').val();
				var lastname = $('#lastname').val();
				var position = $('#position').val();
				var activestate = $('#activestate').val();
				
				///alert(activestate);
				
				//Add validation to the button to avoid error
				if((admintype != null && admintype.length < 1) || (userid != null && userid.length < 1)){
					alert("Select Admintype and a username");
					return;					
				}
				
				
				if(password.length < 1 || firstname.length < 1 || lastname.length < 1 ){
					alert('Enter values into the firstname, password and lastname field to ensure update operation ');	
				}
				else{
				$.post( 
						"controls/Account.php",
						{update:1,admintype:admintype, userid:userid, password:password, firstname:firstname, lastname:lastname, position:position, branchid:branchid, activestate:activestate},
						function (data){
							
							if(data >0){
								resetForm();
								alert("Successfully updated");	
								
							}
							else
								alert("No changes was made. Not updated !!!");
							
						}				
					);
				}
			});
			
			  
			$('#Delete').click(function (){
				//collect values that are needed for deleting
				var admintype = $('#admintype').val();
				var userid = $('#username').val();
				
				
				if(admintype.length < 1 || userid == null){
					alert('Please select admin type and username');	
					return;
				}
				
				if(window.confirm('Are sure you want to delete this Account')){
					
					$.post(
							'controls/Account.php',
							{ delete:1, admintype:admintype, userid:userid, branchid:branchid},
							function(data){								
								if(data == 1){
									$('#username').html('Choose Username');
									alert("Account was successfully deleted  !!");	
								}
								else{
									alert("Account was not deleted !!");	
								}							
							}											
					);
					
				}
				else{
					
					
				}
			});
		
		
			///This function is going to reset value
			function resetForm(){
				$('#password').val('');
				$('#firstname').val('');
				$('#lastname').val('');
				$('#position').val('');
			}
			
	 });
 </script>

  </head>



  <body>
  
    <div id="wrapper">
      
      <!-- Sidebar -->
      <div id="sidebar-wrapper">
       
       <?php
          if(isset($_SESSION['admintype']))
               {
                   if($_SESSION['admintype'] == "Super Admin"){
                       $nav->SuperAdminNav();
                   }
                   else if($_SESSION['admintype'] == "Pastor")
                   {
                        $nav->PastorAdminNav();
                   }
                   else if($_SESSION['admintype'] == "Hod"){
                       $nav->HodAdminNav();
                   }
                   else if($_SESSION['admintype'] == "Multimedia"){
                       
                       $nav->MultimediaNav();
                   }
                   
               }
            
       	?>
       
      </div>
          
      <!-- Page content -->
      <div id="page-content-wrapper">
        <div class="content-header">
          <h1>
            <a id="menu-toggle" href="#" class="btn btn-default"><i class="icon-reorder"></i></a>
            Administrator Home
          </h1>
        </div>
        
        
        <!-- Keep all page content within the page-content inset div! -->
        <div class="page-content inset">
          <div class="row">
            <div class="col-md-12">
              <p class="lead">Welcome Admin !!</p>
            </div>
          </div>
        </div>
        
        
        <div id="content">
              
              
          <form name="form1" method="post" action="">
            <table  width="800" border="0">
              <tr>
                <td width="318">Admintype</td>
                <td width="403">
                  <select name="admintype" id="admintype">
                        <option value="">Select Admintype</option>
                        <?php
                        	
                            $library->returnAdmins();
                            
					?>                            
                      </select>               	
                <span id="loading"><img src="images/loading.gif"> Loading usernames .....</span>
                </td>
              </tr>
              <tr>
                <td>Username</td>
                <td><label for="username"></label>
                  <select name="username" id="username">
                  <option value="">Choose Username</option>
                </select></td>
              </tr>
              <tr>
                <td>Password</td>
                <td><label for="password"></label>
                <input type="text" name="password" id="password" class="text"></td>
              </tr>
              <tr>
                <td>First name</td>
                <td><label for="firstname"></label>
                <input type="text" name="firstname" id="firstname" class="text"></td>
              </tr>
              <tr>
                <td>Last name</td>
                <td><label for="lastname"></label>
                <input type="text" name="lastname" id="lastname" class="text"></td>
              </tr>
              <tr>
                <td>Position</td>
                <td><label for="position"></label>
                <input type="text" name="position" id="position" class="text"></td>
              </tr>
              <tr>
                <td>Activation State</td>
                <td><label for="activestate"></label>
                
                <select name="activestate" id="activestate">
              		<option value="">Select Active State</option>
                	<option value="0">Not Activated</option>
                    <option value="1">Activate</option>
                
                </select>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="button" name="retrieve" id="retrieve" value="Retrieve" class="button">
                  <input type="button" name="Update" id="Update" value="Update" class="button">
                  <input type="button" name="Delete" id="Delete" value="Delete" class="button"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td> <span id="loading1"><img src="images/loading.gif"> Operation in progress, Pls wait .....</span></td>
              </tr>
            </table>
          </form>
        </div>
        
      </div>
      
    </div>
	
    <!-- Bootstrap core JavaScript -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    
  </body>
</html>