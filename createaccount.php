<?php
session_start();
session_regenerate_id();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * 
 */

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

    <title>Create Account</title>

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
     $(document).ready(function (){
         
        var error = "<?php  if( isset($_GET['error'])) echo ''.$_GET['error'].''; ?>";
		
		var success = '<?php if(isset($_GET['success'])) echo $_GET['success']; ?>';
       	
	var dialog = {
		modal:true,
		autoOpen:false,
		title:"Chat Transfer Information",
		width:300,
		height:300,
		position:['center','center'],
 		show: 'slide',
		hide: 'explode'
	};
      
        $("#dialog").dialog(dialog);
        
        if(error != null  && error.length >0){
            
            $('#dialog').html(error);
            $('#dialog').dialog('open');
        }
		
		if(success != null && success.length >0){
			
			
			$('#dialog').html("Admin as been created");
            $('#dialog').dialog('open');
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
          <div class="row"></div>
        </div>
        <div id="content">
<p>CREATE ADMINISTRATOR ACCOUNT</p>
                <form name="form1" method="post" action="controls/Account.php">
                  <table width="641" border="0">
                    <tr>
                      <td width="222">Admin Type</td>
                      <td width="403"><label for="admintype"></label>
                        <select name="admintype" id="admintype">
                        <option value="">Select Admintype</option>
                        <?php
                       
                            $library->returnAdmins();
                            
					?>                            
                      </select></td>
                    </tr>
                    <tr>
                      <td>Username</td>
                      <td><label for="username"></label>
                      <input type="text" name="username" id="username" class="text"></td>
                    </tr>
                    <tr>
                      <td>Password</td>
                      <td><label for="password"></label>
                      <input type="password" name="password" id="textfield" class="text"></td>
                    </tr>
                    <tr>
                      <td>First name</td>
                      <td><label for="firstname"></label>
                      <input type="text" name="firstname" id="firstname"class="text"  ></td>
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
                      <td>&nbsp;</td>
                      <td><input type="submit" name="create" id="create" value="Create" class="button"> <input type="reset" name="reset" id="reset" value="Reset" class="button"></td>
                    </tr>
                  </table>
                </form>
        </div>
        
      </div>
      
    </div>
	
   
    
    <div id="dialog"></div>
  </body>
</html>