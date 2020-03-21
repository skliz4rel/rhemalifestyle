<?php
session_start();
session_regenerate_id();

    include("AdminNavigation.php");
    include("utility/Library.php");
    include("config/connector.php");

        $library = new Library();
        $library->protectPages();
	$connection = new Connector();
	$connection->doConnection();
        
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

    <title>Fellowship Centers</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    
    
    <style type="text/css">
    
        .but{
            
            width:10% !important; 
            margin:2% 2% 2% 2%;
        }
    </style>
    
   <link href="css/custom-theme/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" /> 
   <link href="css/themes/custom-theme/jquery.ui.all.css" rel="stylesheet" />
         <script src="js/jquery-1.9.1.js"></script>
 <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
 
 <script type="text/javascript">
     $(document).ready(function (){
         var branchid = "<?php echo $branchid; ?>";
         
		   var error = '<?php if(isset($_GET['error'])) echo $_GET['error']; ?>';
		
		var success = '<?php if(isset($_GET['success'])) echo $_GET['success']; ?>';
                
                var branchid = "<?php echo $_SESSION['branchid'];?>";
       	
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
		
		
	 if(error != null  && error == "error"){
            
            $('#dialog').html("Error while trying to save center information");
            $('#dialog').dialog('open');
         }
		
        if(error != null  && error == "alreadyexits"){
            
                $('#dialog').html("Error occurred, City already exits !!");
                $('#dialog').dialog('open');
         }
         
         if(error != null  && error == "notupdated"){            
                $('#dialog').html("Error occurred, Fellowship center location details was not updated !!");
                $('#dialog').dialog('open');
         }
         
         if(error != null && error == "addressnotupdated"){
             $('#dialog').html("Error occured, Fellowship center address was not updated.\n Try again !!");
             $('#dialog').dialog('open');
         }
		
		if(success != null && success == "success"){
					
	            $('#dialog').html("House Fellowship center location has been saved");
                    $('#dialog').dialog('open');
	     }
             
             if(success != null && success == "updated"){
					
		$('#dialog').html("House Fellowship center location details as been updated");
                $('#dialog').dialog('open');
	     }
             
             if(success != null && success == "updatedaddress"){
                 $('#dialog').html("House fellowship center address as been updated");
                 $('#dialog').dialog('open');
             }
             
             
             
                $('#save').click(function (){
                    
                    var locationid = $('#locations').val();
                    var centername = $('#centername').val();
                    var address = $('#address').val();
                    
                    if(locationid.length < 1 || centername.length < 1 || address.length < 1){
                        alert("Make sure you select and enter values for locations, centername and address");
                    }
                    else{
                        $.post(
                            "controls/Address.php",
                            {saveaddress:1,locationid:locationid,centername:centername,address:address, branchid:branchid },
                            function (data){
                                
                               
                                if(data >0 ){
                                    $('#locations').val('');
                                    $('#centername').val('');
                                    $('#address').val('');
                                    
                                     $('#dialog').html("Successfully saved !!");
                                     $('#dialog').dialog('open');
                                }
                                
                                if(data == 0){
                                    //This would display the center name duplicate error in the form
                                    $('#dialog').html("The center name you enter already exits !!.\n You can't enter the same center name twice in a location. Check Choose Saved Center option to see center names previously entered");
                                     $('#dialog').dialog('open');
                                }
                                
                                var reg = /^[0-9]*$/;
                                
                                if(reg.test(data) == false)
                                {
                                    //This would display the validation error in the form
                                    $('#dialog').html(data);
                                    $('#dialog').dialog('open');
                                }
                            }
                        );
                    }
                });
				
				
				$('#delete').click(function (){
					
					var location = $('#enteredcity').val();
					
					if(location.length < 1 ){
						alert('Select location');
					}
					else{
						if(window.confirm('Are sure you want to delete ?')){												
							$.post(
								"controls/Address.php",
								{deleteLocation:1,location: location,branchid:branchid },
								function (data){
									if(data > 0){
										window.location.href = "controls/Address.php?redirect=1";	
									}
								}
							);
						}		
				}
					
			});
			
			
			$('#enteredcity').change(function (){
				//alert('changed now');	
                                var  value = $(this).val();
                                
                                if(value.length < 1)
                                {
                                    $('#city').val(''); $('#num').val('');
                                       alert("Please select a location");
                                       
                                }
                                else{
                                    var data = "collectLocationDetails=1&selectedcity="+value+"&branchid="+branchid;
                                    $.ajax({
                                    url:"controls/Address.php",
                                    data:data,
                                    type:"POST",
                                    dataType:"json",
                                    async:true,
                                    success:function (result){
                                           displayLocationResult(result); //This the method that would display the json result
                                    },
                                    error:function (request, error){
                                        alert(error);
                                    }
                                  });
                                }
			});
		
                        //This function is going to be used to display json result in the form
                        function displayLocationResult(obj){
                            $('#city').val(obj.Location);
                            $('#num').val(obj.Num);
                        }
                        
                        
                       $('#locations').change(function (){
                           
                           var value = $(this).val();
                           
                           if(value.length < 1){
                               
                               alert("Choose location ");
                               var result = "<option value=''>Choose Saved Center</option>";
                                 $('#savedcenters').html(result);
                           }
                           else{
                               
                              // alert(value);
                               var data = "branchid="+branchid+"&locationid="+value+"&collectCenters=1";
                               $.ajax({
                                  url:"controls/Address.php",
                                   data:data,
                                   async:true,
                                   type:"POST",
                                   dataType:"json",
                                   success:function (result){
                                       displayCenter(result);
                                   },
                                   error:function (request,error){
                                       alert(error);
                                   }
                               });
                           }
                       });
                            
                       function displayCenter(obj){
                            var result = "<option value=''>Choose Saved Center</option>";
                       
                            var count = obj.length;
                          //  alert(count);
                            for(var i=0; i< count; i++){
                                
                                result+= "<option value='"+obj[i].ID+"'>"+obj[i].Name+"</option>";
                            }
                            
                            $('#savedcenters').html(result);
                       }
                       
                       
                       
                    $('#savedcenters').change(function (){
                        
                        var value = $(this).val();
                        if(value.length < 1)
                        {
                           alert("Choose a center name");
                        }
                        else
                        {
                         
                            var data = "branchid="+branchid+"&centerid="+value+"&fellowshipcenterdetails=1";
                            
                            $.ajax({
                                url:"controls/Address.php",
                                data:data,
                                async:true,
                                type:"POST",
                                dataType:"json",
                                success:function (result){
                                    showcenterDetailsResult(result);
                                },
                                error:function(request,error){
                                    alert(error);
                                }                                
                            });
                        }
                        
                    });
                    
                    function showcenterDetailsResult(obj){
                        $('#centername').val(obj.Name);
                        $('#address').val(obj.Address);
                    }
                    
             $('#deleteaddress').click(function (){
                             
                 var centerid = $('#savedcenters').val();
                 
                 if(centerid.length < 1){
                     alert("Choose Saved Center option must be selected");                     
                 }
                 else{
                     $.post(
                           "controls/Address.php",
                           {deleteCenteraddress:1,branchid:branchid,centerid:centerid},
                           function (data){
                               
                              if(data > 0){
                                  $('#dialog').html("The selected center as been deleted");
                                  $('#dialog').dialog('open');
                                  $('#savedcenters').html("<option value=''>Choose Saved Center</option>");
                                  $('#centername').val('');
                                  $('#address').val('');
                                  $('#locations').val("Select Fellowship Location");
                              }
                              else{
                                  
                                  $('#dialog').html('The selected center was not deleted owing to network error');
                                  $('#dialog').dialog('open');
                              }
                           }
                        );
                     
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
          <form name="form1" method="post" action="controls/Address.php">
          
          <input type=hidden  name=branchid value="<?php echo  $_SESSION['branchid']; ?>"/>
            <table width="644" border="0">
            
            <tr>
            <td></td>
            <td>
            
            <select name="enteredcity" id="enteredcity">
            	<option value="" selected>Select Entered City</option>
            	<?php
				$branchid = $_SESSION['branchid'];
              	$result =  $library->returnFellowLocation($branchid);
				
				while($record = mysql_fetch_array($result))
				{
					echo "<option value='$record[1]'>$record[1]</option>";
				}		
				
				?>
            	
            </select>
            
            <input type="button" value="Delete" id="delete" class="button">
            </td>
            </tr>
            
              <tr>
                <td width="316">Town</td>
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
                <td><input type="submit" name="storelocation" id="store" value="Store" class="adjustedbutton button">
                <input type="submit" name="updatelocation" id="update" value="Update" class="adjustedbutton button">
                <input type="reset" name="resetlocation" id="resetlocation" value="Reset" class="adjustedbutton button">
                </td>
                
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </table>
          </form>
              
         
         
         <hr/>     
           
           
          <form name="form2" method="post" action="controls/Address.php">
          <div>Store Addresses of Centers in Each Location</div>
          
          <input type="hidden" value="<?php echo $_SESSION['branchid']; ?>" name="branchid">
            <table width="1100" border="0">
              <tr>
                <td width="322">Fellowship Location</td>
                <td width="315"><label for="locations"></label>
                  <select name="locations" id="locations" required>
                  <option value=''>Select Fellowship Location</option>
                  <?php
				  $branchid = $_SESSION['branchid'];
                                 $result = $library->returnFellowLocation($branchid);
				  
				  while($record = mysql_fetch_array($result)){
					echo "<option value='$record[0]'>$record[1]</option>";	  
				}
				
				mysql_close();
				  
				  ?>                 
                  
                </select></td>
              </tr>
              
              <tr>
                <td>Center name</td>
                <td><label for="centername"></label>
                <input type="text" name="centername" id="centername" class="text" required>
                
                <select name="savedcenters" id="savedcenters" required>
                    <option value="">Choose Saved Center</option>     
                
               </select>
                </td>
              </tr>
              <tr>
                <td>Center Address</td>
                <td><label for="address"></label>
                <textarea name="address" id="address" cols="45" rows="5" required></textarea></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="button " name="saveaddress" id="save" value="Save" class="button but">    
                    <input type="submit" name="updateaddress" id="updateaddress" value="Update" class="button but">
                    <input type="button" name="deleteaddress" id="deleteaddress" value="Delete" class="button but">
                    <input type="reset" name="reset" id="reset" value="Reset" class="button but">  </td>
              
              </tr>
            </table>
          </form>
        </div>
        
      </div>
      
    </div>
	
  
  <div id="dialog"></div>
  </body>
</html>