<?php
session_start();
session_regenerate_id();

    include("AdminNavigation.php");
    include("utility/Library.php");

    $library = new Library();
    $library->protectPages();
    
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

    <title>Let chat</title>

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
            
            if(error == "updateerror")
                $('#dialog').html("Letchat information was not updated !!!");
            else if(error == "deletefailed")
                $('#dialog').html("Letschat information was not deleted !!!");
            else{
                $('#dialog').html(error);
            }
                     
            $('#dialog').dialog('open');
        }
        
        
		
		if(success != null && success == "saved"){
						
			$('#dialog').html("Information as been saved");
                      $('#dialog').dialog('open');
		}
                
	
        if(success != null && success == "updated"){
            $('#dialog').html("Let's chat information has been updated");
            $('#dialog').dialog('open');
        }
        
        if(success != null && success == "deleted"){
            $('#dialog').html("You successfully deleted the Lets chat information for the month");
            $('#dialog').dialog('open');
        }
                 
            $('#year').change(function (){
                
                var month = $('#month').val();
                var year = $(this).val();
                
                if(month.length < 1 && year.length < 1){
                    alert("Ensure that you select a month and year");
                }
                else{
                    var data = "month="+month+"&year="+year+"&branchid="+branchid+"&getLetchatInfo=1";
                    $.ajax({
                        url:"controls/letchat.php",
                        type:"POST",
                        dataType:"json",
                        data:data,
                        async:true,
                        success:function (result){
                        // alert(result);
                            displayLetchatinfo(result);
                        },
                        error:function (request,error){
                            alert(error);
                        }
                    });
                }
           });

            
                function displayLetchatinfo(obj){
                    if(obj.ReturnState == "Has value"){
                        $('#summary').val(obj.Summary);
                        $('#info').val(obj.Information);
                    }
                    else{
                        alert("No information as been stored for this month");
                         $('#summary').val('');
                        $('#info').val('');
                    }
                }
            
            
            $('#delete').click(function (){
                
               
                if(window.confirm("Are sure you want to delete ?")){
                    var year = $("#year").val();
                    var month = $("#month").val();
                    
                    if(year.length < 1 || month.length < 1){
                        alert("Enter you select month and year for the let's chat information");
                    }
                    else{
                        
                        $.post(
                               "controls/letchat.php",
                               {deleteLetchat:1,year:year,month:month,branchid:branchid},
                               function (data){
                                   if(data > 0){
                                      alert("Letchat information was successfully deleted");
                                      window.location.href = "controls/letchat.php?redirect=1";
                                   }
                                   else
                                   {
                                      alert("Letchat information was not deleted");
                                   }
                               }
                        );
                    }
                }
                
            });
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
              <p class="lead">Let's Chat Information !!</p>
            </div>
          </div>
        </div>
        
        
        <div id="content">
          <form name="form1" method="post" action="controls/Letchat.php">
            <table width="629" border="0">
            
            <input type=hidden value="<?php echo $_SESSION['branchid']; ?>" name="branchid" />
              <tr>
                           
                <td colspan="2">Enter Let's Chat Information</td>
              </tr>
              <tr>
                <td width="199">Month</td>
                <td width="414"><label for="month"></label>
                    
                  <select name="month" id="month" required>
                  <option value=''>Select Month</option>
                  <option value='01'>Jan</option>
                   <option value='02'>Feb</option>
                    <option value='03'>Mar</option>
                     <option value='04'>Apr</option>
                      <option value='05'>May</option>
                       <option value='06'>Jun</option>
                        <option value='07'>Jul</option>
                         <option value='08'>Aug</option>
                          <option value='09'>Sep</option>
                          
                           <option value='10'>Oct</option>
                            <option value='11'>Nov</option>
                             <option value='12'>Dec</option>
                             
                </select> <label for="year"></label>
                <select name="year" id="year" required>
                 <option value=''>Select Year</option>
                 <option value='2013'>2013</option>
                  <option value='2014'>2014</option>
                   <option value='2015'>2015</option>
                </select></td>
              </tr>
              <tr>
                <td>Summary</td>
                <td><label for="summary"></label>
                <textarea name="summary" id="summary" cols="45" rows="5" required></textarea></td>
              </tr>
              <tr>
                <td>Information</td>
                <td><label for="info"></label>
                <textarea name="info" id="info" cols="45" rows="5" required></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="submit" id="submit" value="Save" class="button">
                     <input type="submit" name="updateLetchat" id="update" value="Update" class="button">
                     <input type="button" name="deleteLetchat" id="delete" value="Delete" class="button" >
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