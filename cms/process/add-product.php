<?php 

 require $_SERVER['DOCUMENT_ROOT'].'config/init.php';
 require '../inc/checklogin.php';
 require CLASS_PATH.'product.php';
 require CLASS_PATH.'product_image.php';

$product = new Product();
$product_img_obj = new ProductImage();

if (isset($_POST) && !empty($_POST)) {
      // debugger($_POST, true);

            /*fields validation starts*/
            
            if((!isset($_POST['product_title'],
             $_POST['product_summary'],
             $_POST['product_price'], 
             $_POST['parent_cat_id'],
             $_POST['status'])) 
              || empty($_POST['product_title']) 
              || empty($_POST['product_price']) 
              || empty($_POST['parent_cat_id']) 
              || empty($_POST['status']) 
              || empty($_POST['product_summary'])
           ) {
             redirect('../product-add', 'error', 'Title, Summary, Category and Price are compulsary to be filled.');
  
           // $session->setSessionKeyValue('product_title_error','Title field is required.');  
          }

          /*fields validation ends*/
  
            $data= array(
                  'title' => sanitize($_POST['product_title']),
                  'cat_id' => sanitize($_POST['parent_cat_id']),
                  'child_cat_id' => (isset($_POST['child_category_id']) && !empty($_POST['child_category_id'])) ? (int)$_POST['child_category_id'] : NULL,
                  'summary' => sanitize($_POST['product_summary']),
                  'description' => htmlentities($_POST['product_description']),
                  'price' => (float)$_POST['product_price'],
                  'discount' => (float)$_POST['product_discount'],
                  'brand' => (isset($_POST['brand_id'])) ? (int)$_POST['brand_id'] : NULL,
                  'stock' => (isset($_POST['stock'])) ? (int)$_POST['stock'] : 0,
                  'other_info' => (isset($_POST['other_info'])) ? htmlentities($_POST['other_info']) : '',
                  'is_featured' => (isset($_POST['is_featured']) && $_POST['is_featured']== 1) ? 1 : 0,
                  'is_branded' => (isset($_POST['is_branded']) && $_POST['is_branded']== 1) ? 1 : 0,
                  'status' => sanitize($_POST['status']),
                  'vendor_id' => (isset($_POST['vendor_id'])) ? (int)$_POST['vendor_id'] : NULL,
                  'added_by' => $session->getSessionKeyValueByKey('user_id')
             );
     
         // debugger($data,true);
             // <-----for editing products----->
          if (isset($_POST['product_id']) && !empty($_POST['product_id'])) {

              $id= $_POST['product_id'];
                  
                 if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error']== 0){
                      $thumbnail= uploadSingleFile($_FILES['thumbnail'], 'product');

                     if($thumbnail){
                        $data['thumbnail'] = $thumbnail;
                          if (isset($_POST['del_thumb']) && !empty($_POST['del_thumb']) && file_exists(UPLOAD_DIR.'product/'.$_POST['del_thumb'])) {
                                unlink(UPLOAD_DIR.'product/'.$_POST['del_thumb']);
                                }
                          } 

                                             
                    }      
                      $product_add = $product->updateProduct($data, $id);
                           
                        if ($product_add) {
                           
                                 if(isset($_FILES['product_image']) && !empty($_FILES['product_image'])){

                                        $file= $_FILES['product_image'];
                                            $count = count($file['name']);
                                              for ($i=0; $i < $count; $i++) { 
                                                  $temp = array();
                                                  if($file['error'][$i]== 0){
                                                  $temp['name']= $file['name'][$i];
                                                  $temp['type']= $file['type'][$i];
                                                  $temp['tmp_name']= $file['tmp_name'][$i];
                                                  $temp['size']= $file['size'][$i];
                                                  $temp['error']= $file['error'][$i];

                                                  $product_img= uploadSingleFile($temp, 'product');

                                                  if ($product_img) {
                                                       $product_image = array(
                                                    'product_id' => $product_add,
                                                    'image_name' => $product_img
                                                         );
                                                       $img_add= $product_img_obj->addProductImg($product_image);
                                                         }
                                                     }
                                                 }            
                                           }

                                    
                                        if (isset($_POST['del_image']) && !empty($_POST['del_image'])) {
                                              foreach ($_POST['del_image'] as $image_del) {

                                               $del= $product_img_obj->deleteImageByName($image_del);

                                              if($del && file_exists(UPLOAD_DIR.'product/'.$image_del)){
                                                unlink(UPLOAD_DIR.'product/'.$image_del);
                                                     }
                                                 }
                                                 // debugger($data);
                                                 // debugger($product_add, true);
                                             }

                               redirect('../product-list', 'success', 'Product Updated Successfully.');
                            }else{
                              redirect('../product-list', 'error', 'There was problem while updating product.');
                                }

        }else{       // <-----for adding products----->
                   if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error']== 0){
                       $thumbnail= uploadSingleFile($_FILES['thumbnail'], 'product');
                        if($thumbnail){
                          $data['thumbnail'] = $thumbnail; 
                         }
                    }
                     // debugger($data, true);
                      $product_add = $product->addProduct($data, true);
                     if($product_add){
                         // debugger($product_add,true); 
                          if(isset($_FILES['product_image']) && !empty($_FILES['product_image'])){
                             $file= $_FILES['product_image'];

                             $count = count($file['name']);
                         for ($i=0; $i < $count; $i++) { 
                          $temp = array();
                          if($file['error'][$i]== 0){
                          $temp['name']= $file['name'][$i];
                          $temp['type']= $file['type'][$i];
                          $temp['tmp_name']= $file['tmp_name'][$i];
                          $temp['size']= $file['size'][$i];
                          $temp['error']= $file['error'][$i];

                          $product_img= uploadSingleFile($temp, 'product');

                          if ($product_img) {
                            $product_image = array(
                                                    'product_id' => $product_add,
                                                    'image_name' => $product_img
                                        
                                         );
                            $img_add= $product_img_obj->addProductImg($product_image);
                              }
                          }
                      }
                   }
                           redirect('../product-add', 'success', 'Product Added Successfully.');

                           } else{
                               redirect('../product-add', 'error', 'There was some problem while adding product.');
                          }
                      // debugger($product_add);
                  // echo "this is adding part";
                  // exit;
            }

                 // <-----for deleting products----->
  }elseif (isset($_GET['id'], $_GET['act']) && !empty($_GET['id']) && !empty($_GET['act'])) {
      $id= (int)$_GET['id'];
     if ($_GET['act'] == substr(md5("del-product".$id.$session->getSessionKeyValueByKey('session_token')),3,15)) {
       $product_info= $product->getProductById($id);
      
       if ($product_info) {
        $product_image= $product_img_obj->getProductImageByProductId($id);
 
          $product_delete= $product->deleteProduct($id);
                // debugger($product_info);
                // debugger($product_image,true);
         if ($product_delete) {
              if (!empty($product_info[0]->thumbnail)&& file_exists(UPLOAD_DIR.'product/'.$product_info[0]->thumbnail)) {
                unlink(UPLOAD_DIR.'product/'.$product_info[0]->thumbnail);
            
              }
                 if ($product_image){
                      foreach ($product_image as $image_info) {
                          if (!empty($image_info->image_name) && file_exists(UPLOAD_DIR.'product/'.$image_info->image_name)) {
                           unlink(UPLOAD_DIR.'product/'.$image_info->image_name);
                          }  
                     }
               }
           redirect('../product-list', 'success', 'The product has been deleted successfully.');
         }else{
          redirect('../product-list', 'error', 'Sorry! There was problem while deleting products.');
               }
       }else{
        redirect('../product-list', 'error', 'The product has already been deleted.');
            }
       }else{
            redirect('../product-list', 'error', 'Token Mismatch.');
             } 

  }else{ 
     redirect('../product-add', 'error', 'Unauthorised Access.');
     }