<?php require $_SERVER['DOCUMENT_ROOT'].'config/init.php';
 require 'inc/checklogin.php';
$page_title= 'Banner';
 ?>

<?php require 'inc/header.php'; 
      require CLASS_PATH.'banner.php';

    $banner = new Banner();
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
                <h3>Banner List</h3>
                  </div>
       
                  <div class="col-md-6 title_right">
                  <a href="javascript:;" class="btn btn-success pull-right" onclick="addBanner()">
                  <i class="fa fa-plus"></i>Add Banner</a>
                  </div>
            </div>
                
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>All Banner</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <table class="table table-bordered jambo_table">
                      <thead>
                       <th>S.No.</th>
                       <th>Title</th>
                       <th>Link</th>
                       <th>Image</th>
                       <th>Status</th>
                       <th>Action</th>
                        </thead>
                          <tbody>
                            <?php
                            $all_banners= $banner->getAllBanner();
                                  // debugger($all_banners);
                              if ($all_banners) {
                                foreach ($all_banners as $key => $banner_data) {
                            ?>
                            <tr>
                              <td><?php echo $key+1;?></td>
                              <td><?php echo $banner_data->title;?></td>
                              <td><a href="<?php echo $banner_data->link; ?>" class="btn btn-link" target="_banner"><?php echo $banner_data->link; ?></a></td>
                                 <td><?php
                                        if (isset($banner_data->image) && !empty($banner_data->image) && file_exists(UPLOAD_DIR.'banner/'.$banner_data->image)) {
                                          ?>
                                            <img src="<?php echo UPLOAD_URL.'banner/'.$banner_data->image; ?>" class="img img-responsive img-thumbnail" style="max-width:100px">
                                      <?php 
                                        }
                                        ?></td>
                                  <td><?php echo $banner_data->status;?></td>
                                  <td><a href="javascript:;" class="btn btn-link" data-details='<?php echo json_encode($banner_data)?>' onclick="editBanner(this)">Edit</a>/
                                       <?php
                                    $token = substr(md5("del-banner".$banner_data->id.$session->getSessionKeyValueByKey('session_token')),3,15);?>
                                    <a href="process/banner?id=<?php echo $banner_data->id;?>&amp;act=<?php echo $token?>" class="btn btn-link" onclick= " return confirm('Are you sure you want to delete this item?');">Delete</a>
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
            <?php require 'inc/copyright.php' ?>
            <!-- /footer content -->
      </div>
    </div>
 
 <div class="modal" tabindex="-1" role="dialog" id="add_banner">
  <div class="modal-dialog modal-lg" role="document"> 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Banner</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


    <form action="process/banner" method="POST" enctype="multipart/form-data" class="form form-horizontal">
      <div class="modal-body">

          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Banner Title:</label>
            </div>
            <div class="col-sm-8">
              <input type="text" name="banner_title"  class="form-control" required placeholder="Enter Banner Title" id="banner_title">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Link:</label>
            </div>
            <div class="col-sm-8">
              <input type="url" name="banner_link"  class="form-control" placeholder="Enter Banner Link" required id="banner_link">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Status:</label>
            </div>
            <div class="col-sm-8">
              <select name="status" class="form-control" id="banner_status" required>
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
              <input type="file" name="banner_image" accept="image/*" required id="banner_image">
            </div>
            <div class="col-sm-4">
              <img src="" class="img img-responsive img-thumbnail" id="banner_hiddenimage" style="max-width: 100px">
            </div>
          </div>
        </div>


       <div class="modal-footer">
         <input type="hidden" name="oldbanner_image" id="oldbanner_image" value="">
         <input type="hidden" name="banner_id" id="banner_id" value="">
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
    $('#add_banner').modal('show');
  }
   
   function editBanner(e){
       var banner_info= $(e).data('details');
     // console.log(banner_info);
        if (banner_info) {
          $('.modal-title').html('Edit Banner');
          $('#banner_title').val(banner_info.title);
          $('#banner_link').val(banner_info.link);
          $('#banner_status').val(banner_info.status);
          $('#banner_hiddenimage').attr('src', "<?php echo UPLOAD_URL; ?>banner/"+banner_info.image);
          $('#banner_image').removeAttr('required');
          $('#oldbanner_image').val(banner_info.image);
          $('#banner_id').val(banner_info.id);
          showPopUp();
        }

   }

   function addBanner(){
          $('.modal-title').html('Add Banner');
          $('#banner_title').val('');
          $('#banner_link').val('');
          $('#banner_status').val('Active');
          $('#banner_hiddenimage').attr('src', '');
          $('#banner_image').attr('required');
          $('#oldbanner_image').val('');
          $('#banner_id').val('');
          showPopUp();
   }
</script>

