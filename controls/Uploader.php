<?php
class Uploader{
    
        protected $error = "";
	protected $filename = "";	
	protected $filetmpname = null;
        
        
        
        public function upload(){
            
            echo $_FILES["file"]["type"];
            
            die();              
        }
        
        
            
        
        
        public function uploadfile($file,$filesize,$location,$regexp)
        {
            $this->filename = $file['name'];
            $this->filetmpname = $file['tmp_name']; 
            
           $test =   preg_match($regexp, $file["name"]);
           
           if($test == false){
               echo "The video must in any of this extensions (mp4, avi, mpeg, wmv)";
               echo $image['name'];
               return;
           }
           else
           {
             //  echo "here 1";
           }
           
           $size =  filesize($file['name']);
           
           //echo  $size;
           
          if($size > $filesize){
              echo "Please this image must not be greater than $imagesize bytes";
              return;
          }
          else{
             // echo "here 2";
          }
            
            $newfilename = $location.rand().basename($this->filename);
            $storagepath=$location.basename($this->filename);
            if(isset($this->filename)){
               // echo "file is set";
                if(is_uploaded_file($this->filetmpname))
                   if(move_uploaded_file($this->filetmpname,$storagepath)){
                       //now rename the file to avoid duplication
                       rename($storagepath,$newfilename);
                       
                      // echo $newfilename;
                                              
                       return $newfilename;
                }
            }
            else
                 return "no file";
        }
}
?>