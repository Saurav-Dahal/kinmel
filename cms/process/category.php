<?php 

require $_SERVER['DOCUMENT_ROOT'].'config/init.php';
require '../inc/checklogin.php';
require CLASS_PATH.'category.php';

$category= new Category();
    // debugger($_FILES,true);
    // debugger($_POST,true); 
        
if (isset($_POST) && !empty($_POST)) {
     // debugger($_POST, true);
	   // debugger($_FILES,true);
     
	 $data= array(
	              'title'   => sanitize($_POST['category_title']),
                'summary'   => sanitize($_POST['category_summary']),
                'is_parent' => (isset($_POST['is_parent']) && $_POST['is_parent'] ==1) ? 1 : 0,
                'parent_id' => (isset($_POST['child_parentid']) && !empty($_POST['child_parentid'])) ? (int)$_POST['child_parentid'] : 0,
                'show_in_menu' => (isset($_POST['show_inmenu']) && $_POST['show_inmenu'] ==1) ? 1 : 0,
	              'status'    => sanitize($_POST['category_status']),
	              'added_by'=> $session->getSessionKeyValueByKey('user_id')
	 );  

  if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
           $category_id= $_POST['category_id'];
      }
      if ($category_id) {

         if (isset($_FILES['category_image']) && !empty($_FILES['category_image']['error'] == 0)) {
               $file_name= uploadSingleFile($_FILES['category_image'], 'category');
           if ($file_name){
              $data['image']= $file_name;
            
           if (isset($_POST['oldcategory_image']) && !empty($_POST['oldcategory_image']) && file_exists(UPLOAD_DIR.'category/'.$_POST['oldcategory_image'])) {
                unlink(UPLOAD_DIR.'category/'.$_POST['oldcategory_image']);
              }
          }
        }
              $category_add= $category->update_category($data, $category_id);
    
               if ($category_add) {
                redirect('../category', 'success', 'Category Updated Successfully.');
                 }else{
                 redirect('../category', 'error', 'Sorry! There was problem while updating category.');
                  }
        }

     else{

         if (isset($_FILES['category_image']) && !empty($_FILES['category_image']['error'] == 0)) {
                $file_name= uploadSingleFile($_FILES['category_image'], 'category');
            if ($file_name){
                $data['image']= $file_name;

             $category_add= $category->add_category($data, $is_die);
               // debugger($category_add, true);
         if ($category_add) {
   	             redirect('../category', 'success', 'Category Added Successfully.');
             }else{
                redirect('../category', 'error', 'Sorry! There was problem while adding Category.');
                 }
         }
     }

   }
 }  

 elseif(isset($_GET['id'], $_GET['act']) && !empty($_GET['id']) && !empty($_GET['act']))	 
     {    
        $category_id= (int)$_GET['id'];
        $act = substr(md5("del-category".$category_id.$session->getSessionKeyValueByKey('session_token')), 3, 15);
        //debugger($_GET);
        if($_GET['act'] == $act){      
        //echo substr(md5("del-category".$category_id.$session->getSessionKeyValueByKey('session_token')), 3, 15);
        //exit;
       	         $category_info= $category->getCategoryById($category_id);
                    // debugger($category_info,true);
       	         if($category_info){

                       $category_del= $category->deleteCategory($category_id);
                        if ($category_del) {
                         
                        if (!empty($category_info[0]->image)&& file_exists(UPLOAD_DIR.'category/'.$category_info[0]->image)) {
                        		unlink(UPLOAD_DIR.'category/'.$category_info[0]->image);  
                        	}
                          $category->shiftChild($category_info[0]->id);
                          
                        	redirect('../category', 'success', 'Category deleted successfully.');
                        }else{
                        	redirect('../category', 'error', 'Sorry! There was problem while deleting category.');
                        }

       	            }else{
       	            	redirect('../category', 'error', 'Category has already deleted.');
       	            }     
            }else{
       	      //debugger($_SESSION, true);
                 redirect('../category', 'error', 'Token Mismatch.');
       	         }
  }else{
	redirect('../category', 'error','Unauthorised Access');
      }