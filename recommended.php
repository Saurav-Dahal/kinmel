<?php
     require 'config/init.php';
     require CLASS_PATH.'product.php';

     $product= new Product();

  foreach (glob('track_data/*.json') as $file_name) {
  	          // echo "$file_name";
  	         $file_data= file_get_contents($file_name);
  	         $data= json_decode($file_data, true);

  	         $cat= array();
  	        
  	         foreach ($data as $cat_data) {
  	         	 $cat[$cat_data['cat_id']][] = $cat_data['cat_id'];
  	            }
  	         // debugger($cat);
              
              $cat_info= array();
  	         foreach ($cat as $cat_id => $array) {
  	         	$cat_info[$cat_id]= count($array);
  	            }

                 $recommended_cat= getMax($cat_info);
  	            if ($recommended_cat) {
  	            	  $data= array('cat_id' => $recommended_cat);
  	            	  $recommended_product= $product->getSearchValue($data);

  	            	  $filename='recommended-'.$_COOKIE['_user_id'].'.json';
  	            	 $path= 'track_data/recommended';

  	            	 if(!is_dir($path)){
  	            	 	mkdir($path);
  	            	 }

  	            	 $file = $path."/".$filename;

  	            	 file_put_contents($file, json_encode($recommended_product));

  	            }

  	         debugger($cat_info);
             debugger($recommended_cat);
             debugger($recommended_product);
  }

