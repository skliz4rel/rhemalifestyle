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

    <title>Wedding</title>

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
 var error = "<?php if(isset($_GET['error'])) echo $_GET['error']; ?>";
 
 var success = "<?php if(isset($_GET['success'])) echo $_GET['success']; ?>";
 
     $(document).ready(function (){
		 
		//alert(branchid);
		
		
		var dateoption = {
			dateFormat : 'yy-mm-dd'	
		};
		
	$('.date').datepicker(dateoption);
			
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
		
		
		if(error != null && error.length > 0){
			$('#dialog').html(error);
			$('#dialog').dialog('open');
		}
		
		if(success != null && success.length > 0){
			$('#dialog').html(success);
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
          <div class="row">
            <div class="col-md-12">
              <p class="lead">Welcome Admin !!</p>
            </div>
          </div>
        </div>
        
        
        <div id="content">
               
          <form name="form1" method="post" action="controls/Wedding.php">
            <table width="708" border="1">
            
            <input type=hidden value="<?php echo $_SESSION['branchid'];?>" name="branchid"/>
           
            
              <tr>
                <td><table width="708" border="0">
                  <tr>
                    <td colspan="2"><h2>Wedding Information</h2></td>
                  </tr>
                  
                  <tr>
                    <td width="331">Name of Man</td>
                    <td width="361"><label for="groom"></label>
                    <input type="text" name="groom" id="groom" class="text" required></td>
                  </tr>
                  <tr>
                    <td>Name of the Lady</td>
                    <td><label for="bride"></label>
                    <input type="text" name="bride" id="bride" class="text"  required></td>
                  </tr>
                  <tr>
                    <td>Time of Wedding</td>
                    <td><label for="weddingtime"></label>
                    <input type="time" name="weddingtime" id="weddingtime" class="text" required></td>
                  </tr>
                  <tr>
                    <td>Date of Wedding</td>
                    <td><label for="weddingdate"></label>
                    <input type="text" name="weddingdate" id="weddingdate" class="text date"  required></td>
                  </tr>
                  <tr>
                    <td>Address of Wedding</td>
                    <td><label for="weddingaddress"></label>
                    <textarea name="weddingaddress" id="weddingaddress" cols="45" rows="5"  required></textarea></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="2"><h2>Engagement Information</h2></td>
                  </tr>
                  <tr>
                    <td>Engagement Date</td>
                    <td><label for="receptiondate"></label>
                    <input type="text" name="receptiondate" id="receptiondate" class="text date"  required></td>
                  </tr>
                  <tr>
                    <td>Engagement Time</td>
                    <td><label for="receptiontime"></label>
                    <input type="time" name="receptiontime" id="receptiontime" class="text" required></td>
                  </tr>
                  <tr>
                    <td>Engagement Address</td>
                    <td><label for="receptionaddress"></label>
                    <textarea name="receptionaddress" id="receptionaddress" cols="45" rows="5" required></textarea></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td><input type="submit" name="submit" id="submit" value="Save" class="button">
                    <input type="submit" name="reset" id="reset" value="Reset" class="button"></td>
                  </tr>
                </table></td>
              </tr>
            </table>
          </form>
        </div>
        
      </div>
      
    </div>
	
   
   <div id="dialog"></div>
  </body>
</html>