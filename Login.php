<?php
session_start();
session_regenerate_id();

include('config/connector.php');
include('utility/Library.php');

$connection = new Connector();
$connection->doConnection();

$libObj = new Library();
$libObj->destroySessions();


//echo $_GET['error'];

//die();
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width" />
    <title>Login Page</title>
    <link href="css/Login.css" rel="stylesheet" />
    <link href="css/Site.css" rel="stylesheet" />
    
 <link href="css/custom-theme/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" /> 
 <link href="css/themes/custom-theme/jquery.ui.all.css" rel="stylesheet" />
         <script src="js/jquery-1.9.1.js"></script>
 <script src="js/jquery-ui-1.10.3.custom.min.js"></script>
 
 <script type="text/javascript">
     $(document).ready(function (){
         
        var error = "<?php if(isset($_GET['error'])) echo "".$_GET['error'].""; ?>";
       	
	var dialog = {
		modal:true,
		autoOpen:false,
		title:"Chat Transfer Information",
		width:300,
		height:200,
		position:['center','center'],
 		show: 'slide',
		hide: 'explode'
	};
      
        $("#dialog").dialog(dialog);
        
        if(error != null  && error.length >0){
            
            $('#dialog').html(error);
            $('#dialog').dialog('open');
        }
        
        
        
        
         
     });
     
     </script>
</head>

<body>
    <div id="container">


<div class="loginhouse">

<img src="images/adminhead.png" width="400" height="150">
  
  <form action="controls/PerformLogin.php" method="post">            
      <fieldset>
                <legend>Login Form</legend>
                             

                <input name="__RequestVerificationToken" type="hidden" value="UVtrnR0M5lsfVIJB2k3HNwo56GEDzEiLGUtCgEuw9yrunbjcQJtAxA5TKxtyDLoSJZ0mai5xujWTNkwOfmZddkC0cR--3Ei2ehIJRuuq8081" /> <!--This is going to create the hidden field for the security token that would be used the submission of the form-->
            <div class="editor-field"><label for="Username">Username</label>  <input data-val="true" data-val-required="Your username is required" id="Username" name="Username" class="text" type="text" value="" />

                <span class="field-validation-valid" data-valmsg-for="Username" data-valmsg-replace="true"></span>
            </div>

            <div class="editor-field"><label for="Password">Password</label>  <input data-val="true" data-val-required="Your Password is required" id="Password" name="Password" class="text" type="password" />

                <span class="field-validation-valid" data-valmsg-for="Password" data-valmsg-replace="true"></span>
            </div>
                
          
             
            <div class="editor-field"><label for="Branch">Rhema Branch</label>
                
                <select name="Branch">
                    <option value=''>Select Branch</option>
                    <?php
                    
                        $resultset = $libObj->selectBranches();
                       
                        while($record = mysql_fetch_array($resultset)){
                            echo "<option value='$record[0]'> $record[1]</option>";
                        }
                    ?>
                </select>
                

                <span class="field-validation-valid" data-valmsg-for="Password" data-valmsg-replace="true"></span>
            </div>
            
            
             <div class="editor-field"><label for="Admintype">Admin Type</label>
                
                <select name="Admintype">
                    <option value=''>Select Admintype</option>
                    <option value="Super Admin">Super Admin</option>
                    <option value="Pastor">Pastor</option>
                    <option value="Hod">Hod</option>
                    <option value="Multimedia">Multimedia</option>
                </select>

                <span class="field-validation-valid" data-valmsg-for="Password" data-valmsg-replace="true"></span>
            </div>
            

             <div class="buttonpanel"><input type="submit" value="Submit" name="Submit" id="login" class="button"/><input type="reset" value="Reset" id="reset" class="button"/></div>

          </fieldset>
</form> 
</div>
        
        <div id="dialog"></div>
</div>
</body>
</html>