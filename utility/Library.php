<?php

class Library  {
    
    public function passwordSyntax(){
                
    }
    
    public function Redirect($location){
        header("Location: ".$location);
        exit;
    }
    
    
    public function destroySessions(){
        
                unset($_SESSION['admintype']); unset($_SESSION['username']);
                session_destroy();       
    }
    
     public function returnAdmins(){
        
        echo '
          
                    <option value="Pastor">Pastor</option>
                    <option value="Hod">Hod</option>
                    <option value="Multimedia">Multimedia</option>
        ';
        
    }
    
    //This method is going to return the preachers that have been stored in the database
    public function returnPreachers(){
        
        $query = "select id, name from Preacher";
        
        $result = mysql_query($query) or die(mysql_error());
        
        return $result;
    }
    
   
    
    public function returnContinent(){
        
        $query = "select id, name from continent ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        return $result;
    }
    
    public function returnCountry($continentid){
        
        $query = "select id, name from country where continentid = $continentid";
        
        $result = mysql_query($query) or die(mysql_error());
        
        return $result;
    }
    
   public function checkIfStateAlreadyExits($countryid,$state){
        
       $query = "select id from state where countryid = $countryid and Name = '$state' ";
       
       $result = mysql_query($query) or die(mysql_error());
       
       $num = mysql_num_rows($result);
       
       if($num >0)
           return true;
       else
           return false;        
    }
    
       
    //This is going to return the name of the name of the preacher
    public function returnPreachername($preacherid){
        
        $query = "select name from preacher where id = $preacherid ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        
        $name = "";
        while($record = mysql_fetch_array($result)){
            
            $name = $record[0];
        }
        
        return $name;
    }
    
    public function returnPreacherIDbyname($preachername){
        
        $query = "select id from preacher where name  = '$preachername' ";
        
        $result= mysql_query($query) or die(mysql_error());
        
        $preacherid = 0;
        
        while($record = mysql_fetch_array($result)){
            
            $preacherid = $record[0];
        }
        
        return $preacherid;
    }
    
    //This is giong to help to return the member id of the user
    public function returnMemberID($Username){
        
        $query = "select id from member where username = '$Username' ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        $id = 0;
        if($num > 0){
            while($record = mysql_fetch_array($result)){
                
                $id = $record[0];
            }
        }
        
        return $id;
    }
    
    
    //This method would return the preacher id
    public function returnPreacherID($messageid){
        
        $query = "select preacherid from message where id = $messageid ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        $preacherid = 0;
        
        if($num >0){
            while($record = mysql_fetch_array($result)){
                
                $preacherid = $record[0];
            }            
        }
        
        return $preacherid;
    }
    
    
    //This method is going to select a list of all the rhema branches
    public function selectBranches(){
        
        $query = "select id, branchname from rhemabranch";
        
        $result = mysql_query($query) or die(mysql_error());
       
        return $result;
    }
    
    
    ///This method is going to return the location were the fellowship exits
    public function returnFellowLocation($branchid){
        
        $query = "select id, location from fellowshiplocation where rhemabranchid = $branchid";
        
        $result = mysql_query($query) or die(mysql_error());
        
        return $result;
    }    
    
    
    //This is going to return the center name of a particular city
    public function returnFellowshipCenterinLocation($branchid,$cityid){
        
        $query = "select id,centername from fellowshiplocationaddress where branchid = $branchid and fellowshiplocationid = $cityid ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        return $result;
    }
    
            
    public function logMedia($mediatype, $title,$preacherid,$medianame){
        
        $query = null;
       
        $date = date("Y-m-d");  $time = date("H:m:s");
        
        $query = "insert media (title, datecreated, timecreated, mediatype,preacherid, medianame ) values ( '$title', '$date', '$time', '$mediatype','$preacherid', '$medianame')";  
        
        $result = mysql_query($query) or die(mysql_error());
        
    }
    
     
     //This method is going to return the names of the saved fellowships
     public function displayFellowshipnames($branchid){
         $query  = "select id, name from fellowship where rhemabranchid = $branchid";
         
         $result = mysql_query($query) or die(mysql_error());
         
         return $result;
     }       
    
    //This method is going to protect the page
    public function protectPages(){
        
        if(!isset($_SESSION['admintype']) and !isset($_SESSION['username'])){
          
                $error="Login to access this page";
                $location = "Login.php?error=".urlencode($error);
                $this->Redirect ($location);            
        }
        
    }
    
    public function returnWeddingModel($id,$branchid,$webserviceObject){
        
        $query = "select * from wedding where id = $id and rhemabranchid = $branchid";
        $result = mysql_query($query) or die(mysql_error());
        
               
        while($record = mysql_fetch_array($result)){
            
            $webserviceObject->Id = $record[0];
            $webserviceObject->Bride = $record[1];
            $webserviceObject->Groom = $record[2];
            $webserviceObject->WeddingTime = $record[3];
            $webserviceObject->WeddingDate = $record[4];
            $webserviceObject->WeddingAddress = $record[5];
            $webserviceObject->ReceptionDate = $record[6];
            $webserviceObject->ReceptionTime = $record[7];
            $webserviceObject->ReceptionAddress = $record[8];
            
        }
        
        return $webserviceObject;
    }
    
    
      //This method would be useed to return a Mesage model
      public function returnMessageModel($messageId, $branchid, $webserviceMsgObject){
                    
          $query = "select * from message where id = $messageId and rhemabranchid = $branchid ";
       
          $result = mysql_query($query) or die(mysql_error());
          
          
          while($record = mysql_fetch_array($result)){
              
              $webserviceMsgObject->MessageID = $record[0];
              $webserviceMsgObject->Date = $record[1];
              $webserviceMsgObject->Title = $record[2];
              $webserviceMsgObject->Scriptures = $record[3];
              $webserviceMsgObject->Message = $record[4];
              
              $preacherid = $record[6];
              $webserviceMsgObject->Preacher = $this->returnPreachername($preacherid);
             
          }
          
          return $webserviceMsgObject;
       }
             
       
       //This is going to return the member username
       public function returnMemberUsername($memberid){
           
           $query = "select username from Member where id = $memberid ";
           
           $result = mysql_query($query) or die(mysql_error());
           
           $username = "";
           
           while($record = mysql_fetch_array($result)){
               
               $username = $record[0];
           }
           
           return $username;
       }
       
       //This function is going to be used to return the Question Model
       public function returnQuestionModel($quesid, $branchid,$questionModel){
           
           $query = "select ques, memberid,response from Question where id = $quesid and rhemabranchid = $branchid";
           
           $result = mysql_query($query) or die(mysql_error());
           
           while($record = mysql_fetch_array($result)){
               
               $questionModel->MemberID = $record[1];
               $questionModel->Question = $record[0];
               $questionModel->Response = $record[2];
           }
           
           return $questionModel;
       }
                  
       
    //This method is going to be used to display the questions of member
    public function displayQuestions($messageid, $status, $branchid, $questionjson){
        
        $preachername =  "";
        
        $preacherid = $this->returnPreacherID($messageid);
        
        $preachername = $this->returnPreachername($preacherid);
        
        $memberUsername = "";
        
        $responseState = false;
        
        if($status == "answered")
            $responseState = true;
        else
            $responseState = false;
        
        $query = "select  id, ques, memberid from Question where messageid = $messageid and ResponseState = '$responseState' and rhemabranchid = $branchid ";
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        $output = "";
        
        //preparing the json object that would be sent to the client user page
        $questionjson->preacher = $preachername;
        
        if($num >0){
            
            $counter = 0;
            while($record = mysql_fetch_array($result)){
                
                 $memberUsername = $this->returnMemberUsername($record[2]);         
                 
                 $values = $record[0]."_".$record[1]."_".$memberUsername;
                                                  
                 //adding content to the json object
                 $questionjson->questionobj[$counter] =  $values;
                 
                 $counter++;
            }
        }
        
        return ($questionjson);
       
    }
    
    
    //This method is going to return mobile type id
    public function returnMobileApptypeID($mobileApptype){
        
        $query = "select id from mobileapptype where type = '$mobileApptype' ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_num_rows($result);
        
        $id = 0;
        if($num >0){
            
            while($record = mysql_fetch_array($result)){
                
               $id = $record[0];
            }
        }
        
        return $id;
    }
    
    
    
    private function returnContinentID($continent){
        
        $query = "select id from continent where name = '$continent' ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id=0;
        while($record = mysql_fetch_array($result)){         
            $id = $record['id'];
        }
        
        return $id;
    }
    
    
    //This is going to return the country id
    private function returnCountryID($country){
        
        $query = "select id from country where name = '$country' ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $id = 0;
        
        while($record = mysql_fetch_array($result)){
            
            $id = $record['id'];
        }
        
        return $id;
    }
    
     //This function is the main function that would be used to stop injection
    public function stopInjection($value){
                   
                    $value = strip_tags($value);
                    
                    if(get_magic_quotes_gpc()) // prevents duplicate backslashes
                    {
                      $value = stripslashes($value);
                    }
                    if (phpversion() >= "4.3.0") //if using new version of PHP and mysql_real_escape_string
                    {
                   // $value = mysql_real_escape_string(htmlentities($value, ENT_QUOTES));
                        $value = mysql_real_escape_string($value);
                    }
                    else //for the old version of PHP and mysql_escape_string
                    {
                        //$value = mysql_escape_string(htmlentities($value, ENT_QUOTES));
                        $value = mysql_real_escape_string($value);
                    }
                    return $value; //return the secure string           
		}
                
                
              
                
                //Filter all bad charaters that could be used for injection
              public function filter($value){
		//This function is going to filter content that are passed into variabloes
                   $banlist = ARRAY (
                     "select *",
                     " = ",
                       "* from","1=1","="," ","--","<=",">=","!="
                  );    
                                      
                   
                for($i =0; $i<count($banlist); $i++){                 
                        $value = (str_ireplace($banlist[$i]," ", $value));
                }
                 		
               	 $value = trim($value); 
                 return $value;
              }
              
            //This function is responsible for encrypting the password that is passed here
             public function doEncryption($value){
                    $value = crypt(hash("haval256,5",sha1(md5($value))),"xx");
                    
                    return $value;
            }
              
            //This function is going to be used to chekc for the date format
           public function checkDateformat($date){                
            //      $date="2012-09-12";

                 if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date))
                {
                    return true;
                }else{
                    return false;
                }
            }
            
      
          //This function is going to be used to detect a mobile or desktop or tablet browser
          function detectBrowserType(){
        
            $detect = new Mobile_Detect;
            $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
           // $scriptVersion = $detect->getScriptVersion();            
            return $deviceType;
        }
 }
?>