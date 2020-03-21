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

    <title>View Wedding</title>

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
        
      var branchid = "<?php echo $branchid; ?>";
    $(document).ready(function (){
        
        $('#display').click(function (){
            
            var month = $('#month').val();
            var year = $('#year').val();
            var status = $('#status').val();
            
            
            if(month.length < 1 || year.length < 1){
                alert("Choose a month and a year");
            }
            else if(status.length < 1)
            {
                alert("Please choose marital status");
            }
            else{
                var data = "displayWeddingInMonth=1&month="+month+"&year="+year+"&status="+status+"&branchid="+branchid;
                
                $.ajax({
                    url:"controls/Wedding.php",
                    data:data,
                    async:true,
                    type:"POST",
                    dataType:"json",
                    success:function (result){
                        displayWeddingInfo(result);
                    },
                    error:function (request,error){
                        alert(error);
                    }
                });
                
            }
        });
        
        
        //This function would of the display the result wedded and about to wed
        function displayWeddingInfo(obj){
            
            var count = obj.length;
            
           // alert(count);
            var displayResult = "";
            for(var i=0; i<count; i++){
                displayResult += "<tr><td>"+obj[i].Bride+"</td><td>"+obj[i].Groom+"</td><td>"+obj[i].WeddingTime+"</td><td>"+obj[i].WeddingDate+"</td><td>"+"</td><td>"+obj[i].WeddingAddress+"</td><td>"+obj[i].ReceptionDate+"</td><td>"+obj[i].ReceptionTime+"</td><td>"+obj[i].ReceptionAddress+" <a href='EditWedding.php?id="+obj[i].Id+"'>Edit</a>"+"</td>"+"</tr>";
            }
            
            $('.displaywedding table tbody').html(displayResult);
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
              <p class="lead">Edit Wedding Announcement !!</p>
            </div>
          </div>
        </div>
        
        
        <div id="content">
               
            <div>
                <h2>Display Wedding By Month</h2>
                
                <table width="500">
                        <tr><td>Choose Month : </td><td>
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
                             
                </select>
                    </td>
                    
                    <td>
                        
                       <select name="year" id="year"> 
                           <option value=''>Select Year</option>
                           <?php
                                $date = date('Y-m-d');
                                
                                $values = explode("-", $date);
                                
                                $year = $values[0]; $lastyr = $year+4;
                                
                                for($i = ($year-1); $i <$lastyr; $i++){
                                    
                                    echo "<option value='{$i}'>$i</option>";
                                }
                           ?>
                       </select>
                    </td>
                    
                    <td>
                        <select name="status" id="status">
                            <option value="">Select Marital Status</option>
                            <option value="Married">Married</option>
                            <option value="Abouttowed">About to Wed</option>
                        </select>
                    </td>
                    
                    
    <td><input type="button" class="button" value="Display" id="display"></td>
                        </tr>
                </table>
             </div>
            
            
         <div class="displaywedding">
                
          <table>
              <thead>
                <tr><th>Bride</th><th>Groom</th><th>Wedding Time</th><th>Wedding Date</th><th>Wedding Address</th><th>Reception Date</th><th>Reception Time</th><th>Reception address</th></tr>
               </thead>
                
                <tbody>
                    
                </tbody>
          </table>      
            </div>
            
        </div>
        
      </div>
      
    </div>
	
  </body>
</html>