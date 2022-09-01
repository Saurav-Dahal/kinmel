<?php 

require $_SERVER['DOCUMENT_ROOT'].'config/init.php';
require '../inc/checklogin.php';
require CLASS_PATH.'banner.php';

$banner= new Banner();
    // debugger($_FILES,true);
    // debugger($_POST,true); 
        
if (isset($_POST) && !empty($_POST)) {
     // debugger($_POST);
	   // debugger($_FILES,true);
     
	 $data= array(
	              'title'   => sanitize($_POST['banner_title']),
	              'link'    => sanitize($_POST['banner_link']),
	              'status'  => sanitize($_POST['status']),
	              'added_by'=> $session->getSessionKeyValueByKey('user_id')
	 );  

  if (isset($_POST['banner_id']) && !empty($_POST['banner_id'])) {
           $banner_id= $_POST['banner_id'];
      }
      if ($banner_id) {

         if (isset($_FILES['banner_image']) && !empty($_FILES['banner_image']['error'] == 0)) {
               $file_name= uploadSingleFile($_FILES['banner_image'], 'banner');
           if ($file_name){
              $data['image']= $file_name;
            
           if (isset($_POST['oldbanner_image']) && !empty($_POST['oldbanner_image']) && file_exists(UPLOAD_DIR.'banner/'.$_POST['oldbanner_image'])) {
            unlink(UPLOAD_DIR.'banner/'.$_POST['oldbanner_image']);
              }
          }
        }
              $banner_add= $banner->update_banner($data, $banner_id);
    
               if ($banner_add) {
                redirect('../banner', 'success', 'Banner Updated Successfully.');
                 }else{
                 redirect('../banner', 'error', 'Sorry! There was problem while updating banner.');
                  }
        }

     else{

         if (isset($_FILES['banner_image']) && !empty($_FILES['banner_image']['error'] == 0)) {
                $file_name= uploadSingleFile($_FILES['banner_image'], 'banner');
            if ($file_name){
                $data['image']= $file_name;

             $banner_add= $banner->add_banner($data);
    
         if ($banner_add) {
   	             redirect('../banner', 'success', 'Banner Added Successfully.');
             }else{
                redirect('../banner', 'error', 'Sorry! There was problem while adding banner.');
                 }
         }
     }

   }
 }  

 elseif(isset($_GET['id'], $_GET['act']) && !empty($_GET['id']) && !empty($_GET['act']))	 
     {    
        $banner_id= (int)$_GET['id'];
        $act = substr(md5("del-banner".$banner_id.$session->getSessionKeyValueByKey('session_token')), 3, 15);
        //debugger($_GET);
        if($_GET['act'] == $act){      
        //echo substr(md5("del-banner".$banner_id.$session->getSessionKeyValueByKey('session_token')), 3, 15);
        //exit;
       	         $banner_info= $banner->getBannerById($banner_id);
                    // debugger($banner_info,true);
       	         if($banner_info){
                       $banner_del= $banner->deleteBanner($banner_id);
                        if ($banner_del) {
                        if (!empty($banner_info[0]->image)&& file_exists(UPLOAD_DIR.'banner/'.$banner_info[0]->image)) {
                        		unlink(UPLOAD_DIR.'banner/'.$banner_info[0]->image);
                        	}
                        	redirect('../banner', 'success', 'Banner deleted successfully.');
                        }else{
                        	redirect('../banner', 'error', 'Sorry! There was problem while deleting banners.');
                        }

       	            }else{
       	            	redirect('../banner', 'error', 'Banner has already deleted.');
       	            }     
            }else{
       	      //debugger($_SESSION, true);
                 redirect('../banner', 'error', 'Token Mismatch.');
       	         }
  }else{
	redirect('../banner', 'error','Unauthorised Access');
      }