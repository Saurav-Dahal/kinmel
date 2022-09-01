<?php

function debugger($data , $is_die = false){
	echo "<pre>";
    print_r($data);
    echo "</pre>";
    if ($is_die) {
    	exit;
    }
}

function getCurrentPage(){
	$current_page = $_SERVER['PHP_SELF'];
	return pathinfo($current_page, PATHINFO_FILENAME);  //index or dashboard//
}

function redirect($path, $flag= null, $message= null){

	if (isset($_SESSION) && $flag != null) {
	     $_SESSION[$flag]= $message;
	}

	@header('location: '.$path);
	exit;
}

function flash(){
	if (isset($_SESSION, $_SESSION['success']) && !empty($_SESSION['success'])) {
		echo "<p class= 'alert-success'>".$_SESSION['success']."</p>";
		unset($_SESSION['success']);
	}
	if (isset($_SESSION, $_SESSION['error']) && !empty($_SESSION['error'])) {
		echo "<p class= 'alert-error'>".$_SESSION['error']."</p>";
		unset($_SESSION['error']);
	}
	if (isset($_SESSION, $_SESSION['warning']) && !empty($_SESSION['warning'])) {
		echo "<p class= 'alert-warning'>".$_SESSION['warning']."</p>";
		unset($_SESSION['warning']);
	}
	if (isset($_SESSION, $_SESSION['info']) && !empty($_SESSION['info'])) {
		echo "<p class= 'alert-info'>".$_SESSION['info']."</p>";
		unset($_SESSION['info']);
	}
}


function generateRandomString($length = 100){
	$char= "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$len= strlen($char);
	$random_string= "";
	for ($i=0; $i <$length ; $i++) { 
		$random_string.= $char[rand(0, $len-1)];
	}
	return $random_string;
}

function sanitize($str){
   $str= strip_tags($str);
   $str= stripslashes($str);
   $str= addslashes($str);
   $str= trim($str);
   return $str;
}

function uploadSingleFile($file, $upload_dir){
    if ($file['error']== 0){
    	   $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    	if (in_array(strtolower($ext), ALLOWED_IMAGE_EXTENSION)) {
    		if ($file['size'] <= 500000) {
    			$path= UPLOAD_DIR.$upload_dir;
    			if (!is_dir($path)) {
    				mkdir($path, '0777', true);
    			}
               $file_name= ucfirst(strtolower($upload_dir))."-".date('Ymdhis').rand(0,999).".".$ext;
               $success= move_uploaded_file($file['tmp_name'], $path."/".$file_name);
                 if ($success) {
                 	return $file_name;
                 }else{
                 	return null; 
                 }
    		}else{
    			return null;
    		}
    	}else{
    		return null;
    	}
    }else{
    	return null;
    }
}


function api_response($data= array(), $status= true, $response_code='200', $message= null ){
  $api_model= new StdClass();
  $api_model->body= $data;
  $api_model->status= array();
  $api_model->status['status']= $status;
  $api_model->status['response_code']= $response_code;
  $api_model->status['message']= $message;

  return json_encode($api_model, JSON_HEX_APOS);

}

function getMax($data){
   $max=0;
   $key= null;
   foreach ($data as $k => $v) {
      $max= max(array($max, $v));
      if ($max == $v) {
           $key= $k;
      }
   }
   return $key;
}