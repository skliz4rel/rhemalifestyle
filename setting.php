<?php
session_start();

    include("AdminNavigation.php");
    include("utility/Library.php");
    include("config/connector.php");	

    $connection = new Connector();
    $connection->doConnection();
    $library = new Library();
    $library->protectPages();
    
    $object = new AdminNavigation();
	
	$success = "";
	
	$error = "";
	
	if(isset($_GET['success'])){
		$success = $_GET['success'];
	}
	
	if(isset($_GET['error'])){
		$error = $_GET['error'];	
	}
	
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Settings</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Add custom CSS here -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">
    
 
 <style type="text/css">
 
 	#save{
		margin-left:2%;
		width:100px;
	}
	
	
	.title{
		margin-right:5px; 
		width:45px;
		height:35px;
	}
	
	.name{
		width:200px;
	}
 </style>
   <link href="css/custom-theme/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" /> 
   <link href="css/themes/custom-theme/jquery.ui.all.css" rel="stylesheet" />
  <script src="js/jquery-1.9.1.js"></script>
 <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
 
 <script type="text/javascript">
 $(document).ready(function (){
	
        $('#loading').hide();
        $('#loading1').hide();
        
	var success = 0; var error = 0;
	
	success  = "<?php echo $success; ?>";
	error = "<?php echo $error; ?>";
	
	 
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
		
		if(success == "updatedpreacher"){
			$('#dialog').html('Updated the Preachers name');
			$('#dialog').dialog('open');
		}
		
		if(success == "deletedpreacher"){
			$('#dialog').html("Deleted the Preachers name");
			$('#dialog').dialog('open');
		}
		
		if(success == "preacherSaved"){
			$('#dialog').html("Preacher name has been saved");
			$('#dialog').dialog('open');			
		}
                
                if(success == "savedState"){
                    
                    $('#dialog').html("State was successfully saved");
                    $('#dialog').dialog('open');
                }
                
                if(success == "statedeleted"){
                    $('#dialog').html("State was successfully deleted ");
                    $('#dialog').dialog('open');
                }
                
                if(success == "stateupdated"){
                    
                    $('#dialog').html("State was successfully updated ");
                    $('#dialog').dialog('open');
                }
		
		if(error == "preachernotupdated"){
			$('#dialog').html("Error occured, Preachers name was not updated.");
			$('#dialog').dialog('open');
		}
		
		if(error == "preachernotdeleted"){
			
			$('#dialog').html("Error occured, Preachers name was not deleted.");
			$('#dialog').dialog('open');
		}
		 
		if(error == "duplicatePreacher"){
			$('#dialog').html("Error occured, You can't save this name cause the preacher name already exists");
			$('#dialog').dialog('open');
		}
		
		if(error == "stateError"){
                    $('#dialog').html("Error occured while trying to save the state");
                    $('#dialog').dialog("open");
                }
                
                if(error == "stateExits"){
                    
                    $('#dialog').html("This state already exits, Please change the name");
                    $('#dialog').dialog('open');
                    
                }
		
		$('#saveCountry').click(function (){
		
			var country = $('#country').val();
			var code = $('#code').val();
			var continentid = $('#continent').val();
			var language = $('#language').val();
			
			if(country.length < 1 || continentid.length < 1){
				alert('Select continent and enter country');
			}
			else{
				$.post(
					'controls/Continent.php',
					{saveCountry:1,code:code,country:country,continentid:continentid,language:language},
					function (data){
						
						if(data == "saved")
						{
							 $('#country').val('');  $('#continent').val(''); $('#language').val('');
							 $('#code').val('');
							 alert("Saved !!");
                                                         window.href.location = "setting.php";
						}
						else if(data == "already exist"){
							alert("Country already exists");
						}
						else{
								alert("Not Saved !!");
						}
					}
				
				);
			}
		});
		 	
		
		$('#preacher').change(function (){
			
			var value = $(this).val();
			
			if(value.length < 1)
			{
				alert("Please a value");
			}
			else{
			//	alert(value);
				var values  =  value.split(" ");
				var length = values.length;
				//alert(length);
				var name="";
				$('.title').val(values[0]);
				
				for(var i=1; i<length; i++){
					name += values[i]+" ";
				}
				$('.name').val(name	);
			}
		});
                
                
                $('#choosecontinent').change(function (){
                    
                    var continentid = $(this).val();
                   
                    if(continentid.length > 0){
                                       
                       $.ajax({
                            url:"controls/Setting.php",
                            data:{
                                collectCountryinContinent:1,
                                continentid:continentid
                            },
                            type:"POST",
                            dataType:"json",
                            async:true,
                            beforeSend: function (xhr){
                                $('#loading').show();
                            },
                            complete:function (xhr,status){
                                $('#loading').hide();
                            },
                            success:function (data){
                                
                                displayCountries_continent(data);
                            },
                            error:function (xhr,status,error){
                                alert(error);
                            }
                        });
                        
                    }                
                });
		 
                 
                 //This function is going to be used display the country into the select box
                 function displayCountries_continent(obj){
                 
                    var count = obj.length;
                    
                    var countries = "<option value=''>Select Country</option>";
                    
                    for(var i=0; i< count; i++){
                        countries += "<option value='"+obj[i].ID+"'>"+obj[i].Name+"</option>";
                    }
                    
                     $('#choosecountry').html(countries);
                 }
                 
                 
                 $('#choosecountry').change(function (){
                     
                     var countryid = $(this).val();
                     
                    if(countryid.length > 0){
                        $.ajax({
                            url:"controls/Setting.php",
                            data:{
                                collectStateinCountry:1,
                                countryid:countryid
                            },
                            type:"POST",
                            dataType:"json",
                            async:true,
                            beforeSend:function (xhr){
                                $('#loading1').show();
                            },
                            complete:function (xhr,status){
                                $('#loading1').hide();
                            },
                            success:function(data){

                                displayStateinCountry(data);
                            },
                            error:function (xhr,status, error){
                                alert(error);
                            }

                        });
                     }
                     
                 });
                 
                 
                 //This function is going to be used to display states in the country
                 function displayStateinCountry(obj){
                    
                    var count = obj.length;
                    
                    var states = "<option value=''>Saved States</option>";
                    for(var i=0; i< count;  i++){
                        
                        states += "<option value='"+obj[i].ID+"'>"+obj[i].Name+"</option>";
                    }
                 
                    $('#enteredstate').html(states);
                 }
                 
                 
                 $('#deleteState').click(function (){
                     
                     //aler('clicked the button');
                     var countryid = $('#choosecountry').val();
                     var stateid = $('#enteredstate').val();
                     
                     if(countryid.length < 1 || stateid.length < 1){
                         
                         alert("Ensure that you have select a country and a state to effect the delete process");
                     }
                     else{                         
                         if(window.confirm("Are you sure that you want to delete ?")){
                             
                             $.ajax({
                                 url:"controls/Setting.php",
                                 data:{
                                     deleteState:1,
                                     countryid:countryid,
                                     stateid:stateid
                                 },
                                 type:"POST",
                                 dataType:"text",
                                 async:true,
                                 beforeSend:function (xhr){
                                     
                                 },
                                 complete:function (xhr,status){
                                     
                                 },
                                 success:function(data){
                                    if(data > 0)  
                                     {
                                         window.location.href="setting.php?success=statedeleted";
                                     }
                                     else
                                         alert("State as not been deleted !!!");
                                 },
                                 error:function (xhr,status,error){
                                     alert(error);
                                 }
                             });
                         }
                     }
                 });
                 
                 
                 $('#updateState').click(function (){
                 
                     var countryid = $('#choosecountry').val();
                     var stateid = $('#enteredstate').val();
                     var newstate = $('#state').val();
                    
                    
                     if(countryid.length < 1 || stateid.length < 1){
                         alert("Ensure that you have select a country and a state to effect the update process");
                     }
                     else if(newstate.length < 1){
                         alert("Please enter the new state you want to update to");
                     }
                     else{          
                         
                         $.ajax({
                             url:"controls/Setting.php",
                             data:{
                                 updateState:1,
                                 countryid:countryid,
                                 stateid:stateid,
                                 newstate:newstate
                             },
                             async:true,
                             type:"POST",
                             dataType:"text",
                             beforeSend:function(xhr){
                                 
                             },
                             complete:function (xhr,status){
                                 
                             },
                             success:function (data){
                                
                                 if(data == "updated")
                                     window.location.href = "setting.php?success=stateupdated";
                                 else
                                     alert("No update was made !!");
                             },
                             error:function (xhr,status, error){
                                 alert(error);
                             }
                             
                         });
                         
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
        
        <header><h2>Enter Country</h2></header>
          <form name="form1" method="post" action="">
            <table width="655" border="0">
                <tr>
                    <td><input type="hidden" value="<?php echo $_SESSION['branchid']; ?>" name="branchid"></td>
                </tr>
                
              <tr>
                <td width="300">Select Continent</td>
                <td width="345"><label for="continent"></label>
                  <select name="continent" id="continent" required>
                  <option value="">Select Continent</option>
                  
               		<?php
                    	
							$result= $library->returnContinent();
						
						
						while($record = mysql_fetch_array($result)){
							
							echo "<option value=$record[0]>$record[1]</option>";
						}
                                                
                                          
					?>               
                </select></td>
              </tr>
              <tr>
                <td>Enter Country Code</td>
                <td><label for="code"></label>
                <input type="text" name="code" id="code" class="text" required></td>
              </tr>
              <tr>
                <td>Enter Country</td>
                <td><label for="country"></label>
                <input type="text" name="country" id="country"  class="text" required></td>
              </tr>
              <tr>
                <td>Enter Language</td>
                <td><label for="language"></label>
                <input type="text" name="language" id="language" class="text"></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="button" name="saveCountry" id="saveCountry" value="Submit"  class="button"> </td>
              </tr>
            </table>
          </form>
        
    
        
        <header><h2>Enter State</h2></header>
          <form name="stateform" method="post" action="controls/Setting.php">
            <table width="655" border="0">
                  <tr>
                    <td><input type="hidden" value="<?php echo $_SESSION['branchid']; ?>" name="branchid"></td>
                </tr>
                
             <tr>
                 <td width="300">Continent</td>
                 <td width="345">
                 <select name="choosecontinent" id="choosecontinent" required>
                     <option value="">Select Continent</option>
                     <?php
                     
                        	$result= $library->returnContinent();
						
						
						while($record = mysql_fetch_array($result)){
							
							echo "<option value=$record[0]>$record[1]</option>";
						}
                     
                     ?>                     
                 </select>
                     
                     <label id="loading"><img src="images/loading.gif"> &nbsp;&nbsp; Loading countries in continent ...</label>
                  </td>
             </tr>
                
              <tr>
                <td width="300">Country</td>
                <td width="345"><label for="choosecountry"></label>
                  <select name="choosecountry" id="choosecountry" required>
                  <option value="">Select Country</option>
                    <?php
                    //This is the state in 
                    
                    
                ?>
                </select></td>
              </tr>
              <tr>
                <td>Enter State</td>
                <td><label for="state"></label>
                <input type="text" name="state" id="state"  class="text" required>
                
                <label id="loading1"><img src="images/loading.gif"> &nbsp;&nbsp; Loading countries in continent ...</label>
                
                <select name="enteredstate" id="enteredstate">
                    
                    <option value="">Select State</option>
                    
                    
                    
                </select>
                
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="saveState" id="save" value="Save"  class="button"> 
                    <input type="button" name="updateState" id="updateState" value="Update" class="button">
                <input type="button" name="deleteState" id="deleteState" value="Delete" class="button">
                
                </td>
              </tr>
            </table>
          </form>
        
        
        
        
        
        
        <header><h2>Enter Men of God</h2></header>
          <form name="form1" method="post" action="controls/Setting.php">
            <table width="655" border="0">
                  <tr>
                    <td><input type="hidden" value="<?php echo $_SESSION['branchid']; ?>" name="branchid"></td>
                </tr>
                
              <tr>
                <td width="300">Select Position</td>
                <td width="345"><label for="position"></label>
                  <select name="position" id="position" required>
                  <option value="">Select Position</option>
                  <option value="Rev">Rev</option>
                  <option value="Pastor">Pastor</option>
                  <option value="Minister">Minister</option>
                </select></td>
              </tr>
              <tr>
                <td>Enter Name</td>
                <td><label for="name"></label>
                <input type="text" name="name" id="name"  class="text" required></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="submit" name="savePreacher" id="save" value="Submit"  class="button"> </td>
              </tr>
            </table>
          </form>
          
          
          <header><h2>Update Men of God</h2></header>
          
                <form name="form1" method="post" action="controls/Setting.php">
            <table width="655" border="0">
                
                  <tr>
                    <td><input type="hidden" value="<?php echo $_SESSION['branchid']; ?>" name="branchid"></td>
                </tr>
                
              <tr>
                <td width="300">Select Preacher</td>
                <td><select name="prevpreacher" id="preacher" required>
                	<option value="">Select Preacher</option>
                     	<?php
						
			$result = $library->returnPreachers();
                    	  while($record = mysql_fetch_array($result)){
							  
				  	echo "<option value='$record[1]'>$record[1]</option>";
				}
					
					?>
                </select>
                </td>
                </tr>
                
                <tr>
                <td>Update Name</td>
                
                <td><input type="text" readonly  name="title" class="title"/><input type="text" name="name" class="text name" ></td>
                </tr>
                
                <tr><td></td><td><input type="submit" value="Update" class="button" name="updatePreacher">
                <input type="submit" value="Delete" class="button" name="deletePreacher"/>
                <input type="reset" name="reset" value="Reset" class="button"></td></tr>
               </table>     
               
              </form>
                
        
          <hr/>
          
          <div><h2>Monthly Enter Scriptures</h2></div>
          <form  method="post" action="controls/Setting.php">
              <table width="200">
                 <tr>
                    <td><input type="hidden" value="<?php echo $_SESSION['branchid']; ?>" name="branchid"></td>
                </tr>
                  
                  <tr><td>Enter Scriptures</td>
                      <td>
                          <textarea name="scriptures" cols="50" rows="10" id="scriptures" required></textarea>
                          
                      </td></tr>
        
                  <tr><td></td><td><input type="submit" name="saveScriptures" value="Save" class="button"/></td></tr>
                  
                 </table>
              
          </form>          
        
        </div>
        
      </div>
      
    </div>


	<div id="dialog"></div>
  </body>
</html>

<?php
      mysql_close();
?>