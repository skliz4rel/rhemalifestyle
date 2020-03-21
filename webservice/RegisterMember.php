<?php
//
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.

//This method is going to be used to register a memeber when the user connects to the application from a mobile phone
 * 
 * 
 */
header('Content-type: application/json');
include("../config/connector.php");
include("../webserviceObjects/MemberModel.php");
include("../utility/Library.php");
include("../GCM/GCM.php");


class RegisterMember{
    
    public $connection = null;
    public $library = null;
    public $membermodel = null;
    public $gcm = null;
    
    function __construct(){
        
        $this->connection = new Connector();
        $this->connection->doConnection();
        
        $this->gcm = new GCM();
                
        $this->library = new Library();
        
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        
        if(isset($obj))
            $this->register($obj);
    }
    
    function register($obj){
        
        $name = $obj->{"Name"};
        $username = $obj->{"Username"};
        $phone = $obj->{"Phone"};
        $email = $obj->{"Email"};
        $branchid = $obj->{"BranchID"};
        $branchid = (int)trim($branchid);
        $continent = $obj->{"Continent"};
        $country = $obj->{"Country"};
        $memberstate = $obj->{"MemberState"};
        $devicetype = $obj->{"DeviceType"};
        $mobileapptype = $obj->{"MobileAppType"};
        $gcmregid = $obj->{"GCMRegistrationID"};
        
        $ismember = false;
        
        if($memberstate == "Yes"){
            $ismember = true;
        }
        else{
            $ismember = false;
        }
        
        //We are going to go and collect the continent id and the country id for inserting members
        $continentid = $this->library->returnContinentID($continent);
        $countryid = $this->library->returnCountryID($country);
        
        //Before we enter the values into the database we have to check if the user as been registered before
        $test = $this->checkDuplicateUsername($username);
        
        if($test){
         //   $array = array("Name"=>$name,"Username"=>$username,"Phone"=>$phone,"Email"=>$email,"Submit"=>"");
            
            $this->membermodel = new MemberModel();
            $this->membermodel->Name = $name;
            $this->membermodel->Username = $username;
            $this->membermodel->Phone=$phone; 
            $this->membermodel->Email=$email;
            $this->membermodel->BranchID = $branchid;
            $this->membermodel->Continent = $continent;
            $this->membermodel->Country = $country;
            $this->membermodel->MemberState = $memberstate;
            $this->membermodel->DeviceType = $devicetype;
            $this->membermodel->MobileAppType = $mobileapptype;
            $this->membermodel->GCMRegistrationID = $gcmregid;
            
            $this->membermodel->Submit="Username exists";
            
            echo json_encode($this->membermodel);
            
        }
        else{
            //Now we can insert the values since the username does not exists
            $mobileapptypeID = $this->library->returnMobileApptypeID($this->membermodel->MobileAppType);
            
            
            $query = "insert into member (name, username, phone, email,devicetype, mobileapptypeID, pushregid, rhemabranchid, continentid, countryid, ismember ) values ('$name','$username','$phone','$email','$devicetype',$mobileapptypeID,'$gcmregid',$branchid,$continentid, $countryid, '$ismember' )";  
            $result = mysql_query($query) or die(mysql_error());

            $id = mysql_insert_id();

            mysql_close();

            if($id >0){
            // We are going to post to the gcm server
            $registation_ids = array($gcmregid);
                $message = array("message" => "registered");

                $result = $gcm->send_notification($registation_ids, $message);

                //$array = array("Name"=>$name,"Username"=>$username,"Phone"=>$phone,"Email"=>$email,"Submit"=>"");
            $this->membermodel = new MemberModel();
            $this->membermodel->Name = $name;
            $this->membermodel->Username = $username;
            $this->membermodel->Phone=$phone; 
            $this->membermodel->Email=$email;
            $this->membermodel->BranchID = $branchid;
            $this->membermodel->Continent = $continent;
            $this->membermodel->Country = $country;
            $this->membermodel->MemberState = $memberstate;
            $this->membermodel->DeviceType = $devicetype;
            $this->membermodel->MobileAppType = $mobileapptype;
            $this->membermodel->GCMRegistrationID = $gcmregid;

              $this->membermodel->Submit="Submit";
                       
              echo json_encode($this->membermodel);
            }
            else
            {
              //  $array = array("Name"=>$name,"Username"=>$username,"Phone"=>$phone,"Email"=>$email,"Submit"=>"");
               $this->membermodel = new MemberModel();
                $this->membermodel->Name = $name;
                $this->membermodel->Username = $username;
                $this->membermodel->Phone=$phone; 
                $this->membermodel->Email=$email;
                $this->membermodel->BranchID = $branchid;
                $this->membermodel->Continent = $continent;
                $this->membermodel->Country = $country;
                 $this->membermodel->MemberState = $memberstate;
                $this->membermodel->Submit="Failed";

                echo json_encode($this->membermodel);
            
            }

          }
    }
    
    
    function checkDuplicateUsername($username){
        
        $query = "select id from member where username = '$username' ";
        
        $result = mysql_query($query) or die(mysql_error());
        
        $content = mysql_fetch_array($result);
        
        if($content['id'] >0){            
            return true;
        }
        else
            return false;
    }
}

$object = new RegisterMember();

?>