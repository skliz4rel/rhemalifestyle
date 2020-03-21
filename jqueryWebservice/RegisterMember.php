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


class RegisterMember{
    
    public $connection = null;
    public $membermodel = null;
    
    function __construct(){
        
        $this->connection = new Connector();
        $this->connection->doConnection();
                
        
       // $json = file_get_contents('php://input');
       // $obj = json_decode($json);
        
        if(isset($_POST['submit'])){
            
           $this->register();          
            
        }
    }
    
    function register(){
        
        $name = $_POST["Name"];
        $username = $_POST["Username"];
        $phone = $_POST["Phone"];
        $email = $_POST["Email"];
        $branchid = $_POST["BranchID"];
      //  $branchid = $_POST[$branchid];
        $continent = $_POST["Continent"];
        $country = $_POST["Country"];
        $memberstate = $_POST["MemberState"];
        
        $ismember = false;
        
        if($memberstate == 1){
            $ismember = true;
        }
        else{
            $ismember = false;
        }
        
        //We are going to go and collect the continent id and the country id for inserting members
        $continentid = $this->returnContinentID($continent);
        $countryid = $this->returnCountryID($country);
        
        
        
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
            $this->membermodel->Submit="Username exists";
                       
            echo json_encode($this->membermodel);            
        }
        else{
            //Now we can insert the values since the username does not exists
            
            $query = "insert into member (name, username, phone, email,rhemabranchid, continentid, countryid, ismember ) values ('$name','$username','$phone','$email',$branchid,$continentid, $countryid, '$ismember' )";
            $result = mysql_query($query) or die("Here the error is here ".mysql_error());

            $id = mysql_insert_id();

            mysql_close();

            if($id >0){
            //  echo "successful";

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