<?php

    $_user_id= generateRandomString(30);

    if (isset($_COOKIE['_user_id']) && !empty($_COOKIE['_user_id'])) {
            $_user_id = $_COOKIE['_user_id'];
          }else{
    	     setcookie('_user_id', $_user_id, (time() +(365*86400)), "/");
           }
    
    if (isset($_GET['cat']) && !empty($_GET['cat'])) {
    	   $cat_id= (int)$_GET['cat'];
            
           $to_write= array();
           $temp= array();
           $to_write['date']= date('Y-m-d h.i.s A');
           $to_write['cat_id']= $cat_id;

    	   $_user_file= $_user_id.".json";
    	   $path= "track_data";

    	   if(!is_dir($path)) {
    	   	   mkdir($path);
    	   }
           $file= $path."/".$_user_file;
           
           if (file_exists($file)) {
           	      $old_data= file_get_contents($file);
           	      if ($old_data) {
           	      	    $temp= json_decode($old_data, true);
           	      }
           }

           $temp[]= $to_write;

           file_put_contents($file, json_encode($temp));
    }
