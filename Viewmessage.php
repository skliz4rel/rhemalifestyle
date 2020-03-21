<?php
session_start();
session_regenerate_id();

    include("AdminNavigation.php");
    include("utility/Library.php");
    include("config/connector.php");

    $connection = new Connector();
    $connection->doConnection();

    $library = new Library();
    $library->protectPages();
    
    $object = new AdminNavigation();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>View Message</title>

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

var success = "<?php if(isset($_GET['success'])) echo $_GET['success']?>";

var error = "<?php if(isset($_GET['error'])) echo  $_GET['error']; ?>";

     $(document).ready(function (){
         
         var dialog = {
		modal:true,
		autoOpen:false,
		title:"Message Information",
		width:300,
		height:300,
		position:['center','center'],
 		show: 'slide',
		hide: 'explode'
	};
      
        $("#dialog").dialog(dialog);
        
         var MsgdialogOption = {
            modal:true,
		autoOpen:false,
		title:"Sermon",
		width:500,
		height:500,
		position:['center','center'],
 		show: 'slide',
		hide: 'explode'
        };
                
        $('#Msgdialog').dialog(MsgdialogOption);
         
         
         if(success != null && success == "deleted"){
             
             $('#dialog').html("Successfully deleted !!!");
             $('#dialog').dialog('open');
         }
		 
                 
         if(error != null && error == "deleteError"){
             $('#dialog').html("Error while trying to delete !!");
             $('#dialog').dialog('open');
         }
         
		 $('#loading').hide();
		 
		 $('#display').click(function (){
			 
			 var month = $('#month').val();
			 var year = $('#year').val();
			 var preacher = $('#preacher').val();
			 
			if(month.length < 1 || year.length < 1 || preacher.length <1){ 
				var error = "Ensure that you select month, year and preacher";
				alert(error);
			}
			else{
				$('#showcontent section').html('');
				var date = year+"-"+month;
				$('#loading').show();
				
				$.post(
					"controls/Message.php",
					{displayMessages:1,date:date,preacher:preacher},
					function (data){
						//alert(data);
						$('#loading').hide();
						
						if(data.length > 1){
							
							$('#showcontent section').html(data);
						}
						else{
							alert('No Messages for this preacher !!');	
						}
						
					}	
				);				
			}
		});
		 
          
		
          $(document).on('click','a.delete',function() {
            if(window.confirm("Are you sure you want to delete this ?")){
                  
                  var location  = $(this).attr("data_link");
                  
                  window.location.href = location;
              }
            });
		
             $(document).on('click','a.showmsg',function (){
                 
                 var message = $(this).attr('data-wrap-msg');
                 var title = $(this).attr('data-wrap-title');
                 
                  $('#Msgdialog .title').html(title);
                 
                   $('#Msgdialog .msgcontent').html(message);
                   
                 $('#Msgdialog').dialog("open");
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
              <p class="lead">Display Sermon </p>
            </div>
          </div>
        </div>
        
        
        <div id="content">
                
            <div id="bar">
              <form name="form1" method="post" action="">
                <label for="month">Month</label>
                <select name="month" id="month">
                
                <option value="">Select Month</option>
                <option value="01">Jan</option>
                <option value="02">Feb</option>
                <option value="03">Mar</option>
                <option value="04">Apr</option>
                <option value="05">May</option>
                <option value="06">Jun</option>
                <option value="07">Jul</option>
                <option value="08">Aug</option>
                <option value="09">Sep</option>
                <option value="10">Oct</option>
                <option value="11">Nov</option>
                <option value="12">Dec</option>
                
                </select>
                
                <label for="year">Year</label>
                <select name="year" id="year">
                <option value=''>Select Year</option>
                	<?php
                    
						for($i = 2013; $i< 2040; $i++){
							echo "<option value='$i'>$i</option>";						
						}
					
					?>
                
                </select> 
                
                <label for="preacher">Preacher</label>
                
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
                
<input type="button" name="display" id="display" value="Display" class="adjustbutton button "/>
              </form>
                             
                
            </div>
                  
            
            <article id="showcontent">               
          
                  <header>
                    
                    <ul>
                    	<li>Message Title</li> <li>Date</li>
                    </ul>
                  </header>
                  
            <div id="loading"><img src="images/loading.gif">Please wait loading content .......</div>            
              <section>
               
               
               
               
               </section>
               
               
            </article>
                
                
        </div>
        
      </div>
      
    </div>
	
      
   <div id="dialog">
       
       
       
   </div>
      
      
      
      <div id="Msgdialog">
        
        <div><span>Message Title : </span> <span class="title"> </span></div>
        
        <br/>
        <h3>SERMON</h3>
        <div class="msgcontent">
            
            
         </div>
        
    </div>
   
  </body>
</html>