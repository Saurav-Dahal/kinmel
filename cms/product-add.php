<?php require $_SERVER['DOCUMENT_ROOT'].'config/init.php';
 require 'inc/checklogin.php';
$page_title= 'Add-Product';
require CLASS_PATH.'category.php';
require CLASS_PATH.'brand.php';
require CLASS_PATH.'product.php';
require CLASS_PATH.'product_image.php';

   $category= new Category();
   $brand= new Brand();
    $product = new Product();
     $product_img_obj = new ProductImage();
     $act= "Add";
if (isset($_GET['id'], $_GET['act']) && !empty($_GET['id']) && !empty($_GET['act'])) {
      $act= "Update";
      $id= (int)$_GET['id'];

          if ($_GET['act']== substr(md5("edit-product".$id.$session->getSessionKeyValueByKey('session_token')),3,15)){
              $product_info= $product->getProductById($id);
               if(!$product_info){
                  redirect('product-list', 'error', 'Product not found.');
                 }
                $image= $product_img_obj->getProductImageByProductId($id);         
                  // debugger($product_info);
                  // debugger($image);
     }else{
         redirect('product-list', 'error', 'Invalid Token');
     }
   }
 ?>

<?php require 'inc/header.php'; ?>
         
      <div class="container body">
      <div class="main_container">
       
       <?php require 'inc/menu.php'; ?>

        <!-- top navigation -->
      
        <div class="top_nav"> 
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>


            <ul class="nav navbar-nav navbar-right">
              <li class="">
                <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php echo $session->getSessionKeyValueByKey('full_name'); ?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    
                    <li><a href="logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>

              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <?php

                flash();

               ?> 
            <div class="page-title">
              <div class="title_left">
                <h3><?php echo $act;?> Product</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $act;?> Product</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                   <!-- form start here -->

                  <form action="process/add-product" method="POST" enctype="multipart/form-data" class="form form-horizontal">
                    <div class="form-group">
                      <div class="col-sm-2">
                        <label for="">Product Title:</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="text" value="<?php echo @$product_info[0]->title;?>" name="product_title" id="product_title" class="form-control" placeholder="Enter Product Title">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-2">
                        <label for="">Product Summary:</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea name="product_summary" class="form-control" placeholder="Enter Product Summary" rows="6" style="resize: none;"><?php echo @$product_info[0]->summary;?></textarea>
                       </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-2">
                        <label for="">Product Description:</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea name="product_description" id="product_description" class="form-control" placeholder="Enter Product Description" rows="6" style="resize: none;"><?php echo @html_entity_decode($product_info[0]->description);?></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-2">
                        <label for="">Price(NPR):</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="number" value="<?php echo @$product_info[0]->price;?>" name="product_price" id="product_price" required class="form-control" placeholder="0.00" min="1">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-2">
                        <label for="">Discount(%):</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="number" value="<?php echo @$product_info[0]->discount;?>" name="product_discount" id="product_discount" class="form-control" placeholder="0%">
                      </div>
                    </div>

                     <div class="form-group">
                      <div class="col-sm-2">
                        <label for="">Category:</label>
                      </div>
                      <div class="col-sm-9">
                        <select name="parent_cat_id" id="parent_cat_id" required class="form-control">
                          <option value="" selected disabled>--Select Any One--</option>
                           <?php
                               $all_parent_category= $category->getAllParents();

                               if ( $all_parent_category) {
                                     foreach ($all_parent_category as $parent_category)
                                      {
                                       ?>
                               <option value="<?php echo $parent_category->id;?>" <?php echo (isset($product_info[0]->cat_id) && $product_info[0]->cat_id == $parent_category->id)? 'selected': '';?>><?php echo @$parent_category->title;?></option>
                                 <?php
                                     }
                               }
                              ?>
                        </select>
                      </div>
                    </div>
                       
                       <?php
                        $hidden_class= 'hidden';
                        if ($act == 'Update' && isset($product_info, $product_info[0]->child_cat_id) && !empty($product_info[0]->child_cat_id)) {
                              $hidden_class= '';
                              $child_cat = $category->getChildByParentId($product_info[0]->cat_id);
                        }
                       ?>

                    <div class="form-group <?php echo $hidden_class;?>" id="child_cat_id">
                      <div class="col-sm-2">
                        <label for="">Sub-Category:</label>
                      </div>
                      <div class="col-sm-9">
                        <select name="child_category_id" id="child_category_id" class="form-control">
                          <option value="" selected disabled>--Select Any One--</option>
                          <?php 
                             if ($child_cat) {
                                    foreach ($child_cat as $children) {
                          ?>
                             <option value="<?php echo $children->id;?>" <?php echo ($product_info[0]->child_cat_id == $children->id) ? 'selected' : '' ;?>><?php echo @$children->title; ?></option>
                          <?php
                                    }
                             }
                          ?>     
                       </select>
                      </div>
                    </div>

                     <div class="form-group">
                      <div class="col-sm-2">
                        <label for="">Is Featured:</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="checkbox" name="is_featured" id="is_featured" value="1" <?php echo (isset($product_info[0]->is_featured) && $product_info[0]->is_featured == 1)? 'checked': '';?>>Yes
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-2">
                        <label for="">Is Branded:</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="checkbox" name="is_branded" id="is_branded" value="1" <?php echo (isset($product_info[0]->is_branded) && $product_info[0]->is_branded == 1)? 'checked': '';?>>Yes
                      </div>
                    </div>

                    <?php
                       
                       $class= 'hidden';
                       if ($act= 'Update' && isset($product_info[0]->brand) && !empty($product_info[0]->brand)) {
                         $class= '';
                       }
                    ?>

                    <div class="form-group <?php echo $class;?>" id="brand_div">
                      <div class="col-sm-2">
                        <label for="">Brand:</label>
                      </div>
                      <div class="col-sm-9">
                        <select name="brand_id" id="brand_id" class="form-control">
                          <option value="" selected disabled>--Select Any One--</option>
                             <?php
                               $all_brand= $brand->getAllBrand();

                               if ( $all_brand) {
                                     foreach ($all_brand as $brand_info)
                                      {
                                       ?>
                               <option value="<?php echo $brand_info->id;?>" <?php echo (isset($product_info[0]->brand) && $product_info[0]->brand== $brand_info->id) ? 'selected' : '';?>><?php echo @$brand_info->title;?>
                               </option>
                                 <?php
                                     }
                               }
                              ?>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-2">
                        <label for="">Stock:</label>
                      </div>
                      <div class="col-sm-9">
                        <input type="number" value="<?php echo @$product_info[0]->stock;?>" name="stock" id="stock" class="form-control" min="0" placeholder="0">
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-2">
                        <label for="">Vendor:</label>
                      </div>
                      <div class="col-sm-9">
                        <select name="vendor_id" id="vendor_id" class="form-control">
                          <option value="" selected disabled>--Select Any One--</option>
                            <?php
                               $all_vendor= $user->getAllVendor();

                               if ( $all_vendor) {
                                     foreach ($all_vendor as $vendor_info)
                                      {
                                       ?>
                               <option value="<?php echo $vendor_info->id;?>" <?php echo (isset($product_info[0]->vendor_id) && $product_info[0]->vendor_id== $vendor_info->id) ? 'selected' : '';?>><?php echo @$vendor_info->full_name;?></option>
                                 <?php
                                     }
                               }
                              ?> 
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-2">
                        <label for="">Status:</label>
                      </div>
                      <div class="col-sm-9">
                        <select name="status" id="status" class="form-control" required>
                          <option value="Active" <?php echo (isset($product_info[0]->status) && $product_info[0]->status== 'Active') ? 'selected' : '';?>>Active</option>
                          <option value="Inactive" <?php echo (isset($product_info[0]->status) && $product_info[0]->status== 'Inactive') ? 'selected' : '';?>>Inactive</option>    
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-2">
                        <label for="">Other Info:</label>
                      </div>
                      <div class="col-sm-9">
                        <textarea name="other_info" id="other_info" class="form-control" placeholder="Enter Other Info" rows="6" style="resize: none;"><?php echo @$product_info[0]->other_info;?></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-2">
                        <label for="">Thumbnail:</label>
                      </div>
                      <div class="col-sm-4">
                        <input type="file" name="thumbnail" accept="image/*"  id="thumbnail">
                      </div>
                      <div class="col-sm-4">
                        <?php 
                            if(isset($product_info) && !empty($product_info[0]->thumbnail) && file_exists(UPLOAD_DIR.'product/'.$product_info[0]->thumbnail)){
                          ?>
                          <img src="<?php echo(UPLOAD_URL.'product/'.$product_info[0]->thumbnail);?>" class="img img-thumbnail img-responsive" style="max-width: 150px;">
                          <input type="hidden" name="del_thumb[]" value="<?php echo $product_info[0]->thumbnail;?>">
                        <?php
                          }
                        ?>

                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-sm-2">
                        <label for="">Other:</label>
                      </div>
                      <div class="col-sm-9">
                       <input type="file" name="product_image[]" id="product_image" accept="image/*" multiple> 
                      </div>
                    </div>

                        <?php
                           if (isset($image) && !empty($image)) {
                            ?>
                            <div class="form-group">
                              <?php
                                foreach ($image as $img_info) {
                                ?>
                                <div class="col-sm-2">
                                  <?php
                                     if (file_exists(UPLOAD_DIR.'product/'.$img_info->image_name)) {
                                      ?>
                                      <img src="<?php echo UPLOAD_URL.'product/'.$img_info->image_name;?>" class="img img-responsive img-thumbnail" style="min-width: 150px; min-height: 120px;">
                                      <input type="checkbox" name="del_image[]" value="<?php echo @$img_info->image_name;?>">Delete
                                      <?php
                                     } 
                                  ?>
                                </div>
                                <?php
                                }
                              ?>
                              </div>
                            <?php
                           }
                        ?>

                    <div class="form-group">
                      <div class="col-sm-2">
                        <label for=""></label>
                      </div>
                      <div class="col-sm-9">
                        <input type="hidden" name="product_id" value="<?php echo @$product_info[0]->id;?>">
                        <button class="btn btn-success" type="submit">
                          <i class="fa fa-send"></i>Submit
                        </button>
                         <button class="btn btn-danger" type="reset">
                          <i class="fa fa-trash"></i>Cancel
                        </button>
                      </div>
                    </div> 
                      
                     </form>

                <!-- form ends here -->

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <<?php require 'inc/copyright.php' ?>
        <!-- /footer content -->
      </div>
    </div>
 
   <?php require 'inc/footer.php' ?>
  
     <script type="text/javascript" src="<?php echo ASSETS_URL.'tinymce/tinymce.min.js'?>"></script>
    <script>
     $('#parent_cat_id').on('change', function(){
        var parent_cat_id= $('#parent_cat_id').val();
              // alert(parent_cat_id);
                 /*api  start */
           $.ajax({
                    url: 'inc/api',
                    type: 'POST',
                    data: {
                            id: parent_cat_id,
                            act: "<?php echo substr(md5('get-child-category'.$session->getSessionKeyValueByKey('session_token')),3,15)?>"

                    },
                    success: function(response){
                      // console.log(response);
                      if (typeof(response)!= 'object')
                      {  
                          response= $.parseJSON(response);
                       }
                       
                       var html_option= "<option value='' selected disabled>--Select Any One--</option>";
                       if (response.status.status == true)
                        { 
                            $.each(response.body, function(key, value){
                              html_option += "<option value='"+value.id+"'>"+value.title+"</option>";
                            });

                            $('#child_category_id').html(html_option);
                            $('#child_cat_id').removeClass('hidden');
                        }else{
                            $('#child_category_id').html(html_option);
                            $('#child_cat_id').addClass('hidden');
                        }
                     }
           });
        /*api ends*/

     });

      $('#is_branded').change(function(){
         var is_branded= $('#is_branded').prop('checked');
         if (is_branded) {
            $('#brand_div').removeClass('hidden');
         }else{
          $('#brand_div').addClass('hidden');
         }

      });


      tinymce.init({
        selector: '#product_description'
      });

      
   </script>