<?php require $_SERVER['DOCUMENT_ROOT'].'config/init.php';
 require 'inc/checklogin.php';
$page_title= 'Brand';
 ?>

<?php require 'inc/header.php'; 
      require CLASS_PATH.'brand.php';

    $brand = new Brand();
?>
         
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
            <div class=" col-md-6 title_left">
                <h3>Brand List</h3>
            </div>
       
            <div class="col-md-6 title_right">
            <a href="javascript:;" class="btn btn-success pull-right" onclick="addBrand()">
            <i class="fa fa-plus"></i>Add Brand</a>
            </div>
       </div>
                
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>All Brand</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <table class="table table-bordered jambo_table">
                      <thead>
                       <th>S.No.</th>
                       <th>Title</th>
                       <th>Summary</th>
                       <th>Image</th>
                       <th>Status</th>
                       <th>Action</th>
                        </thead>
                          <tbody>
                            <?php
                            $all_brands= $brand->getAllBrand();
                                  // debugger($all_brands);
                              if ($all_brands) {
                                foreach ($all_brands as $key => $brand_data) {
                            ?>
                            <tr>
                              <td><?php echo $key+1;?></td>
                              <td><?php echo $brand_data->title;?></td>
                              <td><?php echo $brand_data->summary;?></td>
                                 <td><?php
                                        if (isset($brand_data->image) && !empty($brand_data->image) && file_exists(UPLOAD_DIR.'brand/'.$brand_data->image)) {
                                          ?>
                                            <img src="<?php echo UPLOAD_URL.'brand/'.$brand_data->image; ?>" class="img img-responsive img-thumbnail" style="max-width:100px">
                                      <?php 
                                        }
                                        ?></td>
                                  <td><?php echo $brand_data->status;?></td>
                                  <td><a href="javascript:;" class="btn btn-link" data-details='<?php echo json_encode($brand_data)?>' onclick="editBrand(this)">Edit</a>/
                                       <?php
                                    $token = substr(md5("del-brand".$brand_data->id.$session->getSessionKeyValueByKey('session_token')),3,15);?>
                                    <a href="process/brand?id=<?php echo $brand_data->id;?>&amp;act=<?php echo $token?>" class="btn btn-link" onclick= " return confirm('Are you sure you want to delete this item?');">Delete</a>
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
 
 <div class="modal" tabindex="-1" role="dialog" id="add_brand">
  <div class="modal-dialog modal-lg" role="document"> 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Brand</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


    <form action="process/brand" method="POST" enctype="multipart/form-data" class="form form-horizontal">
      <div class="modal-body">

          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Brand Title:</label>
            </div>
            <div class="col-sm-8">
              <input type="text" name="brand_title"  class="form-control" required placeholder="Enter Brand Title" id="brand_title">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Summary:</label>
            </div>
            <div class="col-sm-8">
              <textarea class="form-control" id="brand_summary" name="brand_summary" rows="6" style="resize: none;"></textarea>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Status:</label>
            </div>
            <div class="col-sm-8">
              <select name="status" class="form-control" id="brand_status" required>
                <option value="Active">Active</option>
                <option value="Inactive">Inactive</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Image:</label>
            </div>
            <div class="col-sm-4">
              <input type="file" name="brand_image" accept="image/*" required id="brand_image">
            </div>
            <div class="col-sm-4">
              <img src="" class="img img-responsive img-thumbnail" id="brand_hiddenimage" style="max-width: 100px">
            </div>
          </div>

      </div>


      <div class="modal-footer">
        <input type="hidden" name="oldbrand_image" id="oldbrand_image" value="">
        <input type="hidden" name="brand_id" id="brand_id" value="">
        <button type="submit" class="btn btn-success"><i class="fa fa-send"></i>Save Changes</button>
        <button type="reset" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-trash"></i>Close</button>
      </div>
    </form>
    </div>
  </div>
</div>

<?php require 'inc/footer.php' ?>

<script>
  function showPopUp(){
    $('#add_brand').modal('show');
  }
   
   function editBrand(e){
       var brand_info= $(e).data('details');
     // console.log(brand_info);
        if (brand_info) {
          $('.modal-title').html('Edit Brand');
          $('#brand_title').val(brand_info.title);
          $('#brand_summary').val(brand_info.summary);
          $('#brand_status').val(brand_info.status);
          $('#brand_hiddenimage').attr('src', "<?php echo UPLOAD_URL; ?>brand/"+brand_info.image);
          $('#brand_image').removeAttr('required');
          $('#oldbrand_image').val(brand_info.image);
          $('#brand_id').val(brand_info.id);
          showPopUp();
        }

   }

   function addBrand(){
          $('.modal-title').html('Add Brand');
          $('#brand_title').val('');
          $('#brand_summary').val('');
          $('#brand_status').val('Active');
          $('#brand_hiddenimage').attr('src', '');
          $('#brand_image').attr('required');
          $('#oldbrand_image').val('');
          $('#brand_id').val('');
          showPopUp();
   }
</script>

