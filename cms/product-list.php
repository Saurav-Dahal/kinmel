<?php require $_SERVER['DOCUMENT_ROOT'].'config/init.php';
 require 'inc/checklogin.php';

$page_title= 'Product List';
require CLASS_PATH.'product.php';
$product = new Product();
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
                <h3>Product List</h3>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Product List</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <table class="table table-bordered jambo_table">
                       <thead>
                         <th>S.No.</th>
                         <th>Title</th>
                         <th>Category</th>
                         <th>Sub-Category</th>
                         <th>Price</th>
                         <th>Discount</th>
                         <th>Status</th>
                         <th>Thumbnail</th>
                         <th>Action</th>
                       </thead>
                       <tbody>
                        <?php
                           $all_product = $product->getAllProduct();
                             // debugger($all_product);
                             if ($all_product){
                               foreach ($all_product as $key => $product_info){
                              ?>
                              <tr>
                                <td align="center"><?php echo $key+1;?></td>
                                <td><?php echo $product_info->title;?></td>
                                <td align="center"><?php echo ($product_info->cat_title != '') ? $product_info->cat_title : '--';?></td>
                                <td align="center"><?php echo ($product_info->child_cat_title != '') ? $product_info->child_cat_title :'--' ;?></td>
                                <td align="center"><?php echo "NPR ".number_format($product_info->price);?></td>
                                <td align="center"><?php echo $product_info->discount." %";?></td>
                                <td align="center"><?php echo $product_info->status;?></td>
                                <td align="center"><?php
                                        if (isset($product_info->thumbnail) && !empty($product_info->thumbnail) && file_exists(UPLOAD_DIR.'product/'.$product_info->thumbnail)) {
                                          ?>
                                            <img src="<?php echo UPLOAD_URL.'product/'.$product_info->thumbnail; ?>" class="img img-responsive img-thumbnail" style="max-width:100px">
                                      <?php 
                                        }
                                        ?></td>
                                <td>

                                  <?php
                                  $token= substr(md5("edit-product".$product_info->id.$session->getSessionKeyValueByKey('session_token')),3,15);
                                  ?>
                                  <a href="product-add?id=<?php echo $product_info->id;?>&amp;act=<?php echo $token;?>" class="btn btn-link">Edit</a>/
                                   <a href="<?php echo SITE_URL.'product?id='.$product_info->id;?>" class="btn btn-link" target="_blank">View</a>/
                                  <?php
                                  $token= substr(md5("del-product".$product_info->id.$session->getSessionKeyValueByKey('session_token')),3,15);
                                  ?>
                                  <a href="process/add-product?id=<?php echo $product_info->id;?>&amp;act=<?php echo $token;?>" class="btn btn-link" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
                                </td>

                              </tr>
                              <?php
                             }
                             }
                            ?>
                       </tbody>
                     </table>
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