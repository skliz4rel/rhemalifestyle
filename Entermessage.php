<?php
session_start();

    include("AdminNavigation.php");
    include("utility/Library.php");
    include("config/connector.php");

    $connection = new Connector();
    $connection->doConnection();
    
    $library = new Library();
    $library->protectPages();
    
    $nav = new AdminNavigation();
    
    $error = 0;
    
    if(isset($_GET['error']))
        $error = $_GET['error'];
    
    $success = 0;
    
    if(isset($_GET['success']))
        $success = $_GET['success'];
    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Enter Message</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

	 
         
         <style type="text/css">
             #preacher{                 
                 margin-right:2px;
             }
          
          </style>
  
 <link href="css/custom-theme/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" /> 
 <link href="css/themes/custom-theme/jquery.ui.all.css" rel="stylesheet" />
         <script src="js/jquery-1.9.1.js"></script>
 <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
 <script type="text/javascript">
 
 var error = "<?php echo $error; ?>";
 
 var success = "<?php echo $success; ?>";
 
     $(document).ready(function (){
		 
		 $('#outsidepreacher').hide();
                 
                 $('#preacher').change(function (){
                    
                    var preacher = $(this).val();
                    
                    if(preacher == "Visitor"){
                        $('#outsidepreacher').show();
                    }
                 });
                 
                 
                 $('#scripture').bind('click keypress',function (){
                     var preacher = $('#preacher').val();
                 
                     if(preacher == "Visitor")
                     {
                         var outsidepreacher = $('#outsidepreacher').val();
                         
                         if(outsidepreacher.length < 2){
                             alert("Enter name of the Visiting man of God");
                         }
                     }
                 });
                
                
		var dateoption = {
			dateFormat : 'yy-mm-dd'	
		};
		
	$('#date').datepicker(dateoption);
			
		var dialog = {
		modal:true,
		autoOpen:false,
		title:"Activity Report",
		width:300,
		height:300,
		position:['center','center'],
 		show: 'slide',
		hide: 'explode'
	};
      
        $("#dialog").dialog(dialog);
		
        
       
		
		if(error != null && error == "Error while saving"){
			$('#dialog').html(error);
			$('#dialog').dialog('open');
		}
		
		if(success != null && success == "success"){
			$('#dialog').html("Sermon has been successfully saved !!");
			$('#dialog').dialog('open');
		}
//		
		
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
              <p class="lead">Enter Message Sermon !!</p>
            </div>
          </div>
        </div>
        
        
        <div id="content">
               
               
          <form name="form1" method="post" action="controls/Message.php" >
          
          <input type="hidden" name="branchid" value="<?php echo $_SESSION['branchid'];?>"/>
            <table width="auto" border="0">
              <tr>
                <td width="289">Date</td>
                <td width="333"><label for="date"></label>
                <input type="text" name="date" id="date" class="text" required></td>
              </tr>
              <tr>
                <td>Title</td>
                <td><label for="title"></label>
                <input type="text" name="title" id="title" class="text" required></td>
              </tr>
              <tr>
                <td>Preacher</td>
                <td>
                <select name="preacher" id="preacher" required>
                	<option value="">Choose Man of God</option>
                     <?php
                        
                       $result =  $library->returnPreachers();
                       
                       while($record = mysql_fetch_array($result)){
                           
                           echo "<option value='$record[0]'>$record[1]</option>";
                       }
				
                       echo "<option value='Visitor'>Visitor</option";
		    ?>			
		
                </select>
                    
                    
                
                <input type="text" name="outsidepreacher" id="outsidepreacher" class="text"/></td>
              </tr>
              <tr>
                <td>Scriptures</td>
                <td><input type="text" name="scripture" id="scripture" class="text" required/></td>
              </tr>
              <tr>
                <td>Message</td>
                <td><label for="message"></label>
                <textarea name="message" id="message" cols="45" rows="5" class="messagebox" required></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="savemessage" id="save" value="Submit"  class="button"/>
                <input type="reset" name="reset" id="reset" value="Reset"  class="button"/></td>
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
	
    
    <div id="dialog"></div>
    
    
    
    
  </body>
</html>