<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of UpdateMember
 *
 * @author skliz
 */
header('Content-type: application/json');
include("../config/connector.php");
include("../webserviceObjects/MemberModel.php");
include("../utility/Library.php");

class UpdateMember {
    //put your code here
   public $connection = null;
   public $library = null;
   public $membermodel = null;
   
   
   function __construct(){
       $this->connection = new Connector();
       $this->connection->doConnection();
       
       $this->library = new Library();
          
        $json = file_get_contents('php://input');
        $obj = json_decode($json);
        
        if(isset($obj))
            $this->update($obj);
   } 
   
   
   private function update($obj){
       
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
        
       
        $mobileapptypeID = $this->library->returnMobileApptypeID($mobileapptype);
        
         //We are going to go and collect the continent id and the country id for inserting members
        $continentid = $this->library->returnContinentID($continent);
        $countryid = $this->library->returnCountryID($country);
        
        $query = "update member set username = '$username', name='$name', phone='$phone',email='$email',devicetype='$devicetype', mobileapptypeID=$mobileapptypeID, pushregid='$gcmregid',
rhemabranchid=$branchid,continentid=$continentid,countryid=$countryid,ismember='$ismember'

where phone='$phone' or email ='$email' ";
                
        $result = mysql_query($query) or die(mysql_error());
        
        $num = mysql_affected_rows();
        
        if($num > 0){
            
            //NOw we are going to make the gcm message post
            
            
            
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

              $this->membermodel->Submit="Updated";
                       
              echo json_encode($this->membermodel);
            
        }
        else
        {
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

            $this->membermodel->Submit="Updatefailed";
                       
            echo json_encode($this->membermodel);
        }
   }
    
}
?>