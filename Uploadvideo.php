<?php
session_start();
session_regenerate_id();

    include("AdminNavigation.php");
    include("utility/Library.php");
    include("config/connector.php");

	$connection = new Connector();
	$connection->doConnection();

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

    <title>Upload Video</title>
    
 <link href="css/custom-theme/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" /> 
 <link href="css/themes/custom-theme/jquery.ui.all.css" rel="stylesheet" />
 <script src="js/jquery-1.9.1.js"></script>
 <script src="js/jquery-ui-1.10.3.custom.min.js"></script>

    <script type="text/javascript">
        var success  = "<?php if(isset($_GET['success'])) { echo  $_GET['success']; }?>";
        
        //alert(success);
        $(document).ready(function (){
            
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
        
        if(success != null && success.length >0){
            
            $('#dialog').html('Video as been uploaded !! ');
             $('#dialog').dialog('open');
        }
         
         
        });
        
     </script>

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
           <?php echo $_SESSION['admintype']; ?> Account Page
          </h1>
        </div>
        
        
        <!-- Keep all page content within the page-content inset div! -->
        <div class="page-content inset">
          <div class="row">
            <div class="col-md-12">
              <p class="lead">Upload Video !!</p>
            </div>
          </div>
        </div>
        
        
        <div id="content">
          <form action="controls/Uploadvideo.php" method="post" enctype="multipart/form-data" >
            <table width="669" border="0">
              <tr>
                <td width="312">Preacher</td>
                <td width="341"><label for="preacher"></label>
                    
                  <select name="preacherid" id="preacherid" required>
                     
                      <option value="">Select Admintype</option>
                        <?php
                            
                          $result = $library->returnPreachers();
                            
				while($record = mysql_fetch_array($result)){
					echo "<option value=$record[0]>$record[1]</option>";		
                                }
		       ?>        
                      
                </select>
                
                </td>
              </tr>
              <tr>
                <td>Message Title</td>
                <td><label for="title"></label>
                <input type="text" name="title" id="title" class="text" required></td>
              </tr>
              <tr>
                <td>Upload Video</td>
                <td><input type="file" name="file" id="file" class="text" required></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="uploadvideo" id="submit" value="Upload" class="button"> 
                    <input type="reset" name="reset" id="reset" value="Reset" class="button"></td>
              </tr>
            </table>
          </form>
                
        </div>
        
      </div>
      
    </div>
	
      <div id="dialog"></div>
  </body>
</html>