<?php
session_start();
session_regenerate_id();

include("../config/connector.php");
include("../utility/Library.php");

echo  $_SESSION['R_service_user'];

$connection = new Connector();
$connection->doConnection();

$library = new Library();
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>RhemaLifestyle Administrative Portal</title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="../css/simple-sidebar.css" rel="stylesheet">
    <link href="../font-awesome/css/font-awesome.min.css" rel="stylesheet">
     <link href="../css/custom-theme/jquery-ui-1.10.3.custom.min.css" rel="stylesheet" /> 
     <link href="../css/themes/custom-theme/jquery.ui.all.css" rel="stylesheet" />
         <script src="../js/jquery-1.9.1.js"></script>
 <script src="../js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript">
 $(document).ready(function (){
    
    $('#loading').hide();  $('#loading1').hide();
    
    $('#continent').change(function (){
        
        var value = $(this).val();
        
        
        if(value != null){
           
           var data = "returnCountry_continent=1&continentid="+value;
            
            $('#loading').show();
            $.ajax({
                url:"../controls/Continent.php",
                data:data,
                async:true,
                type:"POST",
                dataType:"json",
                success:function(result){
                    
                    $('#loading').hide();
                    
                    displayCountries(result);
                },
                error:function (request, error){
                    alert(error);
                }
            });
        }
        
    });
    
    
    //function would be used to display the result into the combo
    function displayCountries(object){
    
        var count = object.length;
        
        //$('#country').append("<option value=''>Select Country</option>");
        for(var i=0; i<count; i++){
            
             $('#country').append("<option value='"+object[i].ID+"'>"+object[i].Name+"</option>");
        }
    }
    
    
    //This is going to call the ajax script that would load the states in a country
    $('#country').change(function (){
                     
                     var countryid = $(this).val();
                     
                    if(countryid.length > 0){
                        $.ajax({
                            url:"../controls/Setting.php",
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
                 
                    $('#state').html(states);
                 }
    
 });
 
 </script>
 
  </head>

  <body>
  
    <div id="wrapper">
      
      <!-- Sidebar -->
      <div id="sidebar-wrapper">
       
                      
         <ul class="sidebar-nav">
          <li class="sidebar-brand"><a href="#">Service Admin</a></li>         
          
          <li><a href="controls/Logout.php">Logout</a></li>
        </ul>
      </div>
          
      <!-- Page content -->
      <div id="page-content-wrapper">
           <div class="content-header">
          <h1>
            <a id="menu-toggle" href="#" class="btn btn-default"><i class="icon-reorder"></i></a>
           Service Admin Account
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
               
     <form name="createBranch" method="post" action="">
         
         <table>
             
              <tr><td>Continent</td><td>
                      
                      <select name="continent" id="continent">
                          <option value="">Select continent</option>
                          <?php
                            $result = $library->returnContinent();
                            
                            while($record = mysql_fetch_array($result)){
                                
                                echo "<option value='$record[0]'>$record[1]</option>";
                            }                            
                          ?>                          
                      </select>
                  </td></tr>
             
         
             <tr><td>Country</td><td>
                     
                     <select name="country" id="country">
                         <option value="">Select Country</option>
                                           
                     </select>
                     
                     <span id="loading"><img src="../images/loading.gif"> &nbsp;&nbsp; Loading countries in continent .....</span>
                 </td></tr>
             
             
             <tr><td>State</td>
                 <td>
                     <select name="state" id="state">
                     
                         
                         
                     </select>
                     
                                  <span id="loading1"><img src="../images/loading.gif"> &nbsp;&nbsp; Loading states in countries .....</span>
                 </td></tr>
             
             <tr><td>Rhema Branch</td><td>
                     
                     <input type="text" name="branchname" value=""/>
                 </td></tr>
             
              <tr><td>Address</td><td>
                      
                      <textarea rows="20" cols="30" name="address"></textarea>
                      
                  </td></tr>
             
              <tr><td></td><td>
                      <input type="submit" value="Save" name="savebranch" class="button" />
                      <input type="reset" value="Reset" name="reset" class="button"/>
                  </td></tr>
        </table>
     </form>
     
</div>
        
      </div>
      
    </div>
	
  </body>
</html>