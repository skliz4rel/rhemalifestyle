<?php
error_reporting(0);
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Uploadvideo
 *
 * @author skliz
 */
include("../config/connector.php");
include("../utility/Library.php");
include("Uploader.php");


class Uploadvideo {
    //put your code here
    public $connection = null;
    public $library = null;
    
    
     function __construct(){
     
        $this->connection = new Connector();
        $this->library = new Library();
        $this->connection->doConnection();
    }

    

    //This method would help you to upload a video
    public function upload(){
     
        
       $preacherid = (int)$this->library->stopInjection($this->library->filter(trim($_POST['preacherid'])));
       $title = $this->library->stopInjection($this->library->filter(trim($_POST['title'])));
       $filecontent =  $_FILES['file'];
      
       
       $location = "../Upload/video/";
       $filesize = 90000000;
        $regexp = '/\.(wmv|avi|mp4)$/i';
       
       $uploader = new Uploader();
       $storefilename =  $uploader->uploadfile($filecontent, $filesize, $location, $regexp);

       $location = "../Uploadvideo.php?success=success";
       
       $this->library->logMedia("video", $title,$preacherid, $storefilename);
       
       if(isset($storefilename) && $storefilename != "no file")
          $this->library->Redirect($location);
       /*
        $allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma");
        $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

        if ((($_FILES["file"]["type"] == "video/mp4")
        || ($_FILES["file"]["type"] == "audio/mp3")
        || ($_FILES["file"]["type"] == "audio/wma")
        || ($_FILES["file"]["type"] == "image/pjpeg")
        || ($_FILES["file"]["type"] == "image/gif")
        || ($_FILES["file"]["type"] == "image/jpeg"))

        && ($_FILES["file"]["size"] < 900000000)
        && in_array($extension, $allowedExts))

        {
        if ($_FILES["file"]["error"] > 0)
        {
            echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
        }
        else
         {
            echo "Upload: " . $_FILES["file"]["name"] . "<br />";
            echo "Type: " . $_FILES["file"]["type"] . "<br />";
            echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
            echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

            if (file_exists("Upload/" . $_FILES["file"]["name"]))
            {
            echo $_FILES["file"]["name"] . " already exists. ";
            }
            else
            {
            move_uploaded_file($_FILES["file"]["tmp_name"],
            "Upload/" . $_FILES["file"]["name"]);
            echo "Stored in: " . "Upload/" . $_FILES["file"]["name"];
            }
            }
        }
        else
        {
            echo "Invalid file";
        }              
         */
    }
    
    
    
    
}


$object = new Uploadvideo();

if(isset($_POST['uploadvideo'])){
    
   // echo "Form was submitted";    
    $object->upload();    
}

?>