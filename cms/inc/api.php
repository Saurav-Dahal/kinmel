<?php

require $_SERVER['DOCUMENT_ROOT'].'config/init.php';
require 'checklogin.php';
require CLASS_PATH.'category.php';

  // debugger($_POST, true);
$category= new Category();

$act= isset($_REQUEST['act']) ? sanitize($_REQUEST['act']): null;

if ($act) {
	 if ($act== substr(md5('get-child-category'.$session->getSessionKeyValueByKey('session_token')),3,15))
	      {
	       $id= (int)($_POST['id']);
	       $child_category= $category->getChildByParentId($id);
	       if ($child_category) {
	       	      $data= api_response($child_category, true, 200);
	              echo $data;
	              exit;
	       }else{
	       	      $data= api_response(null, false, 200, 'Sub-category doesnot exist.');
	              echo $data;
	              exit;
	       }

	   }else{
	 	  $data= api_response(null, false, 404, 'Invalid Token.');
	       echo $data;
	       exit;
	        }
}else{
	$data= api_response(null, false, 404, 'Unauthorised Access.');
	echo $data;
	exit;
    }