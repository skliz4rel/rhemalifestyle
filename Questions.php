<?php
session_start();

    include("AdminNavigation.php");
    include("utility/Library.php");
    include("config/connector.php");
    include("webObject/Quesjsonobj.php");
  
    
    
    $connection = new Connector();
    $connection->doConnection();
    
    $library = new Library();
    $library->protectPages();
    
    $nav = new AdminNavigation();
    
    $branchid = $_SESSION['branchid'];
    
    $success = 0;
    
    if(isset($_GET['success']))
        $success = $_GET['success'];
    
    $error = 0;
    
    if(isset($_GET['error']))
        $error = $_GET['error'];
    
    
    
    //We are going to try to collect questions in case the message id is set in the url
     $messageid = 0;
                    
                    if(isset($_GET['id']))
                        $messageid = $_GET['id'];
                  
                    $branchid = $_SESSION['branchid'];
                    
      $questionjson = new Quesjsonobj();
     
            
      $status = "unanswered";
      $questionjson = $library->displayQuestions($messageid, $status,$branchid, $questionjson); 
      
    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Questions Asked by Members</title>

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

    var branchid = "<?php echo $_SESSION['branchid']; ?>";
    var success = "<?php echo $success; ?>";
    var error = "<?php echo $error; ?>";

     $(document).ready(function (){
		 
		 $('#loading').hide();
		 $('#loading1').hide();              
              
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
        
        
        if(success != null && success == "deleted"){
            
            $('#dialog').html('Question as been deleted');
            $('#dialog').dialog('open');
        }
        
        
        if(error != null && error == "notdeleted"){
            $('#dialog').html("Question was not deleted");
            $('#dialog').dialog('open');
        }
		 
		 var dateoption = {
			dateFormat : 'yy-mm-dd'	
		};
		
	$('#date').datepicker(dateoption);
	
		$('#getmessage').bind('click',function (){
			
			var date = $('#date').val();
			
			if(date.length < 4){
				alert('Please enter date\n You need the date to load message into select box');	
			}
			else{
				$('#loading1').show();
				
				$.post(
					"controls/Message.php",
					{collectMessage:1,date:date,branchid:branchid},
					function (data){
						$('#loading1').hide();
						$('#message').html(data);
					}
			   );
			}
		});
		
		
		$('#display').click(function (){
			
			var error = "Correct the following error:\n";
			var message = $('#message').val();
			var date = $('#date').val();
			var form = $('form').serialize();
                        var status = $('#status').val();
			
			if(date.length < 2 || message == null || status == null){
				error+= "Enter date and message and status of message";	
				alert(error);
			}
			else{
				
				$.ajax({
					url:'controls/Question.php',
					type:'POST',
					data:form,
					dataType:'json',
					success:function (data){
											
						displayResult(data,status);
					},
					error:function (data){
						alert("failed  "+data);
					}				
				});
				
			}			
		});
		
		
		//This method is going to split the json object and display the result on the web page
		function displayResult(json,status){
			
			$('.preacher').text(json.preacher);
						
			//loop through the other content which is an array
			var content = json.questionobj;
			
			var count = content.length;
			var display = "";
                        
                        if(count < 1){
                             $('#showcontent section').html('');
                            alert("No "+status+" Questions for this message !!!");
                        }
                        else{
                            for(var i=0; i<count; i++){

                                    var questionid = content[i].QuestionID;
                                    var question = content[i].Question;
                                    var memberusername = content[i].MemberUsername;

                                    display = "<div class='list'><span class='clear'></span><span>";

                                    display += question +"</span>";

                                    display += "<span>"+memberusername+"<a href='Respond_Question.php?quesid="+questionid+"' target='_blank'> &nbsp;&nbsp; <img src='images/ans.png' ></a>"+"<a href='controls/Question.php?deleteQuestion=1&quesid="+questionid+"&branchid="+branchid+"' ><img src='images/delete.png' ></a>"+"  </span></div>";

                            }
                            $('#showcontent section').html(display);
                        }
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
              <p class="lead">View Church Members Questions !!</p>
            </div>
            
            <div id="loading1">  <img src="images/loading.gif"/>Loading Messages ...</div>
          </div>
        </div>
        
        
        <div id="content">
                
            <div id="bar">
              <form name="form" method="post" action="">
                
                <input type="hidden" name="displayQuestions" value=1 />
                
                <label for="date">Date of Message</label>
                
                 <input type="text" name="date" id="date"/>
                 
                 <input type="button"   id=getmessage  value="Get Msg"/>
                
                <label for="message">Message</label>
                <select name="messageid" id="message">
                         
                
                </select>
                
                <select name="status" id="status">
                  <option value="">Question Status</option>                  
                  <option value="answered">Answered</option>
                  <option value="unanswered">UnAnswered</option>
                </select>
                
<input type="button" name="display" id="display" value="Display" class="adjustbutton button "/>


       </form>
                             
   
   
            </div>
            
      <span>Preacher :- </span> <span class='preacher'> <?php if(isset($questionjson->preacher)) echo $questionjson->preacher; ?></span> 
<br/>
       
            
            <article id="showcontent">               
          
                  <header>
                    
                    <ul>
                    	<li>Question</li>   <li>Member</li>
                    </ul>
                  </header>
                  
            <div id="loading"><img src="images/loading.gif">Please wait loading content .......</div>
            
              <section>  
               
                  <?php
                  
                  //This is going to check if there are question to display to the user
                  
                   if(isset($values)){
                       
                       foreach($question as $questionjson->questionobj){
                           
                           $values =  explode("_",$question); 
                           
                           $questionid = $values[0];
                           $ques = $values[1];
                           $memberusername =$values[2];
                           
                          echo "<div class='list'><span class='clear'></span><span>";

                            echo  $ques."</span>";

                           echo  "<span>".$memberusername."<a href='Respond_Question.php?quesid=".$questionid."' target='_blank'> &nbsp;&nbsp; <img src='images/ans.png' ></a>"."<a href='controls/Question.php?deleteQuestion=1&quesid=".$questionid."&branchid=".$branchid."' ><img src='images/delete.png' ></a>"."  </span></div>";
                           
                       }                       
                   }        
                                  
                  ?>
               
               
               
               </section>
               
               
            </article>
                
                
        </div>
        
      </div>
      
    </div>
	
   
      <div id="dialog"></div>
  </body>
</html>