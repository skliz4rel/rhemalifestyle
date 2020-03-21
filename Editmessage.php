<?php
session_start();

    include("AdminNavigation.php");
    include("utility/Library.php");
    include("config/connector.php");
    include("webObject/MessageModel.php");
       

    $connection = new Connector();
    $connection->doConnection();
    
    $library = new Library();
    $library->protectPages();
    
    $nav = new AdminNavigation();
    
    $webserviceMsgObject = new MessageModel();
    
    $branchid = $_SESSION['branchid'];
    
    $id = 0;
    if(isset($_GET['id'])){
        $id = (int)$_GET['id'];
        
         $webserviceMsgObject = $library->returnMessageModel($id, $branchid, $webserviceMsgObject);
    }else{
        
       
    }
     

    $success = 0;
        
    if(isset($_GET['success']))
        $success = $_GET['success'];
    
    $error = 0;
    
    if(isset($_GET['error']))
        $error = $_GET['error'];
    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Edit Saved Sermon</title>

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
     
  var success = "<?php echo $success; ?>";
  var error = "<?php echo $error; ?>";
     
 $(document).ready(function (){
     
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
	   
        
        if(success != null && success == "updated"){
            $('#dialog').html("Message Details was successfully updated !!");
            $('#dialog').dialog('open');
        }
        
        if(error != null && error == "updatefailed"){
            $('#dialog').html("No Update was made to Message, ensure you make changes or check your connection !!");
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
              
              <form name="form1" method="post" action="controls/Message.php" >
          
          <input type="hidden" name="branchid" value="<?php echo $_SESSION['branchid'];?>"/>
          
          <input type="hidden" name="messageid" value="<?php echo $webserviceMsgObject->MessageID;?>" />
            <table width="auto" border="0">
              <tr>
                <td width="289">Date</td>
                <td width="333"><label for="date"></label>
                <input type="date" name="date" id="date" class="text" value="<?php echo $webserviceMsgObject->Date; ?>" required></td>
              </tr>
              <tr>
                <td>Title</td>
                <td><label for="title"></label>
                <input type="text" name="title" id="title" class="text" value="<?php echo $webserviceMsgObject->Title; ?>" required></td>
              </tr>
              <tr>
                <td>Preacher</td>
                <td>
                <select name="preachers" id="preacher">
                	<option value="">Choose Man of God</option>
                     <?php
                        
                       $result =  $library->returnPreachers();
                       
                       while($record = mysql_fetch_array($result)){
                           
                           echo "<option value='$record[0]'>$record[1]</option>";
                       }
				
                       echo "<option value='Visitor'>Visitor</option";
		    ?>			
		
                </select>
                    
                    
                
                <input type="text" name="preacher" id="preacher" class="text" value="<?php echo $webserviceMsgObject->Preacher; ?>"/></td>
              </tr>
              <tr>
                <td>Scriptures</td>
                <td><input type="text" name="scripture" id="scripture" class="text"  value="<?php echo $webserviceMsgObject->Scriptures; ?>" required/></td>
              </tr>
              <tr>
                <td>Message</td>
                <td><label for="message"></label>
                <textarea name="message" id="message" cols="45" rows="5" class="messagebox" required><?php echo $webserviceMsgObject->Message; ?></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="updateMessage" id="update" value="Update"  class="button"/>
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