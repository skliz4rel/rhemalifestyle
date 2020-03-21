<?php
session_start();
    
    include("AdminNavigation.php");
    include("utility/Library.php");
    include("config/connector.php");
    include("webObject/QuestionModel.php");

    $connection = new Connector();
    $connection->doConnection();
    
    $library = new Library();
    $library->protectPages();
    
    $nav = new AdminNavigation();
    
    $quesid = 0;
    
    if(isset($_GET['quesid']))
    {
        $quesid = $_GET['quesid'];
    }
    
    $branchid = $_SESSION['branchid'];
    
   $questionModel = new QuestionModel();

    $questionModel = $library->returnQuestionModel($quesid, $branchid,$questionModel);
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Respond to Members Questions</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="css/simple-sidebar.css" rel="stylesheet">
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet">

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
              <p class="lead">Respond to Member's Questions</p>
            </div>
          </div>
        </div>
        
        
        <div id="content">

           <form method="post" action="controls/Question.php">
		
            <table width=1000">
                
              <input type="hidden" value="<?php echo $_SESSION['branchid']; ?>" name="branchid">
             <tr>
                 <td><input type="hidden" name="quesid" value="<?php  if(isset($_GET['quesid'])) echo $_GET['quesid']; ?>"></td>
              </tr>
              
             <tr>
               <td> Member's Question </td>
               <td> <textarea name="question" id="question" cols="50" rows="9" readonly><?php echo $questionModel->Question;?></textarea></td>
                
             </tr>
             
             <tr>
                 
               <td>Response</td>
               <td> <textarea name="response" cols="50" rows="9" id="response" required>
                <?php echo $questionModel->Response; ?>
                   </textarea></td>
                
              </tr>
              
              <tr>
              <td></td>
              
              <td>
                <input type="submit" name="respondtoQuestion" value="Respond to Question" class="button"/>
                <input type="reset" value="reset" value="Reset" class="button"/>
               </td>
               </tr>
                </table>
            </form>
        </div>
        
      </div>
      
    </div>
	
  </body>
</html>