<?php
session_start();
session_regenerate_id();

    include("AdminNavigation.php");
    include("utility/Library.php");
    include("config/connector.php");

    $library = new Library();
    $library->protectPages();
    
    $connection  = new Connector();
    $connection->doConnection(); //make the connection to the database
    
    $object = new AdminNavigation();
    
    $branchid = $_SESSION['branchid'];
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Church Fellowships</title>

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
 
 var error = "<?php if(isset($_GET['error'])) echo $_GET['error']; ?>";
 
 var success = "<?php if(isset($_GET['success'])) echo $_GET['success'];?>";
 
 var branchid = "<?php echo $branchid; ?>";
 
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
	        
        if(error != null  && error.length >0){            
            
            if(error == "deletefailed")
               $('#dialog').html("Fellowship information was deleted");
           else 
               $('#dialog').html(error);
         
            $('#dialog').dialog('open');
        }
		
		if(success != null && success.length >0){
                    
                        if(success == "success")
                            $('#dialog').html("Information as been saved");
                        else if(success == "updated")
                            $('#dialog').html("Information as been updated");
                        
                        else if(success == "deleted")
                            $('#dialog').html("Fellowship has been deleted");
                    
                        $('#dialog').dialog('open');
		}
	
               
	
            $('#savedfellowship').change(function (){
                
                var fellowshipid = $(this).val();
                
                if(fellowshipid.length < 1){
                    
                     $('#name').val('');
                      $('#head').val('');
                    alert("Please select fellowship you want to edit");
                }
                else{
                    var data = "displayDetails=1&fellowshipid="+fellowshipid+"&branchid="+branchid;
                    $.ajax({
                        url:"controls/Enterfellowship.php",
                        data:data,
                        async:true,
                        type:"POST",
                        dataType:"json",
                        success:function (result){
                            displayfellowshipDetails(result);
                        },
                        error:function (request,error){                       
                            alert(error);
                        }
                    });
                }
            });
            
            //THis function is going to display the result in the form fields
            function displayfellowshipDetails(obj){
                
                $('#name').val(obj.Name);
                $('#head').val(obj.Head);
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
              <p class="lead">Church Fellowships !!</p>
            </div>
          </div>
        </div>
        
        
        <div id="content">
          <form name="form1" method="post" action="controls/Enterfellowship.php" enctype="multipart/form-data">
              
            <input type="hidden" name="branchid" value="<?php echo $_SESSION['branchid']; ?>" required/>
            <table width="774" border="0">
                <tr>
                <td></td>
                 <td>
                     <select name="savedfellowship" id="savedfellowship">
                         <option value="">View Saved Fellowships</option>
                         <?php
                         $branchid = $_SESSION['branchid'];
                            $result = $library->displayFellowshipnames($branchid);
                                                             
                             $num = mysql_num_rows($result);

                            if($num >0){

                                while($record= mysql_fetch_array($result)){

                                    echo "<option value='$record[0]'>$record[1]</option>";
                                }
                            }
                         ?>                            
                     </select>
                  </td>
                 </tr>
              <tr>
                <td colspan="2">Enter Fellowships in Church</td>
              </tr>
              <tr>
                <td width="337">Fellowship Name</td>
                <td width="421"><label for="name"></label>
                <input type="text" name="name" id="name" class="text" required></td>
              </tr>
              <tr>
                <td>Fellowship Head name</td>
                <td><label for="head"></label>
                <input type="text" name="head" id="head" class="text" required></td>
              </tr>
              
              <tr>
                 <td><label for="logo">Fellowship Logo</label></td>
                 <td>
                     <input type="file" name="logo" required/>
                 </td>
              </tr>
              
              
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" id="submit" value="Submit" class=button>
                    <input type="submit" name="updateFellowship" id="update" value="Update" class="button">
                    <input type="submit" name="deleteFellowship" id="delete" value="Delete" class="button">
                <input type="reset" name="reset" id="reset" value="Reset" class=button></td>
              </tr>
            </table>
          </form>
               
        </div>
        
      </div>
      
    </div>
    
    <div id="dialog"></div>
	
  </body>
</html>