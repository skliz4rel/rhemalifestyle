<?php
session_start();
session_regenerate_id();

    include("AdminNavigation.php");
    include("utility/Library.php");

    $library = new Library();
    $library->protectPages();
    
    $object = new AdminNavigation();
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Fellowship Centers</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

  </head>

  <body>
  
    <div id="wrapper">
      
      <!-- Sidebar -->
      <div id="sidebar-wrapper">
     
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
          
          <input type=hidden  name=branchid value="<?php echo  $_SESSION['branchid']; ?>"/>
            <table width="644" border="0">
              <tr>
                <td width="316">City</td>
                <td width="312"><label for="city"></label>
                <input type="text" name="city" id="city" class="text"  required></td>
              </tr>
              <tr>
                <td>Number of Centers</td>
                <td><label for="num"></label>
                <input type="number" name="num" id="num" class="text" required></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="storefellow" id="store" value="Store" class="adjustedbutton button"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </form>
              
              
              
        
        </div>
        
      </div>
      
    </div>
	
  
  </body>
</html>