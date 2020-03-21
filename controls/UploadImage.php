<?php
class UploadImage {
    
        protected $error = "";
	protected $filename = "";
	
	protected $filetmpname = null;
        
      
        public function upload($image,$imagesize,$location,$regexp)
        {
            $this->filename = $image['name'];
            
           
            $this->filetmpname = $image['tmp_name'];
            
          
           $test =   preg_match($regexp, $this->filename);
           
           if($test == false){
               echo "The image must be a jpeg,gif or png";
               return;
           }
                      
           $size =  filesize($this->filetmpname);
           
          if($size > $imagesize){
              echo "Please this image must not be greater than $imagesize bytes";
              return;
          }
            
            
            $newfilename = $location.rand().basename($this->filename);
            $storagepath=$location.basename($this->filename);
            if(isset($this->filename)){
               // echo "file is set";
                if(is_uploaded_file($this->filetmpname))
                   if(move_uploaded_file($this->filetmpname,$storagepath)){
                       //now rename the file to avoid duplication
                       rename($storagepath,$newfilename);
                       
                       return $newfilename;
                   
                }
            }
            else
                 return "no file";
        }
}
?>