<?php 

require $_SERVER['DOCUMENT_ROOT'].'config/init.php';
require '../inc/checklogin.php';
require CLASS_PATH.'brand.php';

$brand= new Brand();
    // debugger($_FILES,true);
    // debugger($_POST,true); 
        
if (isset($_POST) && !empty($_POST)) {
     // debugger($_POST);
     // debugger($_FILES,true);
     
   $data= array(
                'title'   => sanitize($_POST['brand_title']),
                'summary' => sanitize($_POST['brand_summary']),
                'status'  => sanitize($_POST['status']),
                'added_by'=> $session->getSessionKeyValueByKey('user_id')
   );  


  if (isset($_POST['brand_id']) && !empty($_POST['brand_id'])) {
           $brand_id= $_POST['brand_id'];
    }
      if ($brand_id){
        
         if (isset($_FILES['brand_image']) && !empty($_FILES['brand_image']['error'] == 0)) {
               $file_name= uploadSingleFile($_FILES['brand_image'], 'brand');
           if ($file_name){
              $data['image']= $file_name;
            
           if (isset($_POST['oldbrand_image']) && !empty($_POST['oldbrand_image']) && file_exists(UPLOAD_DIR.'brand/'.$_POST['oldbrand_image'])) {
            unlink(UPLOAD_DIR.'brand/'.$_POST['oldbrand_image']);
              }
          }
        }
              $brand_add= $brand->update_brand($data, $brand_id);
    
               if ($brand_add) {
                redirect('../brand', 'success', 'Brand Updated Successfully.');
                 }else{
                 redirect('../brand', 'error', 'Sorry! There was problem while updating brand.');
                  }
        }

     else{

         if (isset($_FILES['brand_image']) && !empty($_FILES['brand_image']['error'] == 0)) {
                $file_name= uploadSingleFile($_FILES['brand_image'], 'brand');
            if ($file_name){
                $data['image']= $file_name;

             $brand_add= $brand->add_brand($data);
              // debugger($brand_add, true);
         if ($brand_add) {
                 redirect('../brand', 'success', 'Brand Added Successfully.');
             }else{
                redirect('../brand', 'error', 'Sorry! There was problem while adding brand.');
                 }
         }
     }
   }
 }  

 elseif(isset($_GET['id'], $_GET['act']) && !empty($_GET['id']) && !empty($_GET['act']))   
     {    
        $brand_id= (int)$_GET['id'];
        $act = substr(md5("del-brand".$brand_id.$session->getSessionKeyValueByKey('session_token')), 3, 15);
        //debugger($_GET);
        if($_GET['act'] == $act){      
        //echo substr(md5("del-brand".$brand_id.$session->getSessionKeyValueByKey('session_token')), 3, 15);
        //exit;
                 $brand_info= $brand->getBrandById($brand_id);
                    // debugger($brand_info,true);
                 if($brand_info){
                       $brand_del= $brand->deleteBrand($brand_id);
                        if ($brand_del) {
                        if (!empty($brand_info[0]->image)&& file_exists(UPLOAD_DIR.'brand/'.$brand_info[0]->image)) {
                            unlink(UPLOAD_DIR.'brand/'.$brand_info[0]->image);
                          }
                          redirect('../brand', 'success', 'Brand deleted successfully.');
                        }else{
                          redirect('../brand', 'error', 'Sorry! There was problem while deleting brands.');
                        }

                    }else{
                      redirect('../brand', 'error', 'Brand has already deleted.');
                    }     
            }else{
              //debugger($_SESSION, true);
                 redirect('../brand', 'error', 'Token Mismatch.');
                 }
  }else{
  redirect('../brand', 'error','Unauthorised Access');
      }