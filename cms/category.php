<?php require $_SERVER['DOCUMENT_ROOT'].'config/init.php';
 require 'inc/checklogin.php';
$page_title= 'Category';
 ?>

<?php require 'inc/header.php'; 
      require CLASS_PATH.'category.php';

    $category = new Category();
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
                <h3>Category List</h3>
            </div>
       
            <div class="col-md-6 title_right">
            <a href="javascript:;" class="btn btn-success pull-right" onclick="addCategory()">
            <i class="fa fa-plus"></i>Add Category</a>
            </div>
       </div>
                
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>All Category</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <table class="table table-bordered jambo_table">
                      <thead>
                       <th>S.No.</th>
                       <th>Title</th>
                       <th>Summary</th>
                       <th>Is_Parent</th>
                       <th>Parent</th>
                       <th>Show in Menu</th>
                       <th>Image</th>
                       <th>Status</th>
                       <th>Action</th>
                        </thead>
                          <tbody>
                            <?php
                            $all_category= $category->getAllCategory();
                              // debugger($all_category);
                              if ($all_category) {
                                foreach ($all_category as $key => $category_data) {
                            ?>
                            <tr>
                              <td><?php echo $key+1;?></td>
                              <td><?php echo $category_data->title;?></td>
                              <td><?php echo $category_data->summary;?></td>
                              <td align="center"><?php echo ($category_data->is_parent== 1)? 'Yes': 'No';?></td>
                              <td align="center">
                                <?php
                                  $parent_id= $category_data->parent_id;
                                  if($parent_id !=0){
                                  $parent_info= $category->getCategoryParentById($parent_id);
                                  if($parent_info){
                                    echo $parent_info[0]->title;
                                  }
                                }
                                else{
                                  echo '--';
                                }?></td>
                              <td align="center"><?php echo ($category_data->show_in_menu== 1)? 'Yes' : 'No';?></td>
                              <td><?php
                                        if (isset($category_data->image) && !empty($category_data->image) && file_exists(UPLOAD_DIR.'category/'.$category_data->image)) {
                                          ?>
                                            <img src="<?php echo UPLOAD_URL.'category/'.$category_data->image; ?>" class="img img-responsive img-thumbnail" style="max-width:100px">
                                      <?php 
                                        }
                                        ?></td>
                              <td><?php echo $category_data->status;?></td>
                              <td>
                                <a href="javascript:;" class="btn btn-link" data-details='<?php echo json_encode($category_data, JSON_HEX_APOS);?>' onclick= "editCategory(this)">Edit</a>
                                /
                                 <?php
                                $token= substr(md5("del-category".$category_data->id.$session->getSessionKeyValueByKey('session_token')),3,15);
                                ?>
                              <a href="process/category?id=<?php echo $category_data->id;?>&amp;act=<?php echo $token?>" class="btn btn-link" onclick= "return confirm('Are you sure you want to delete this item?')">Delete</a>
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
 
 <div class="modal" tabindex="-1" role="dialog" id="add_category">
  <div class="modal-dialog modal-lg" role="document"> 
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>


  <form action="process/category" method="POST" enctype="multipart/form-data" class="form form-horizontal">
      <div class="modal-body">

          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Category Title:</label>
            </div>
            <div class="col-sm-8">
              <input type="text" name="category_title"  class="form-control" required placeholder="Enter Category Title" id="category_title">
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Summary:</label>
            </div>
            <div class="col-sm-8">
              <textarea class="form-control" name="category_summary" id="category_summary" rows="6" style="resize: none;"></textarea> 
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Is Parent</label>
            </div>
            <div class="col-sm-8">
              <input type="checkbox" name="is_parent" id="is_parent" value="1" checked>Yes
            </div>
          </div>

          <div class="form-group hidden" id="choose_parent">
            <div class="col-sm-3">
              <label for="">Choose Parent:</label>
            </div>
            <div class="col-sm-8">
              <select name="child_parentid" class="form-control" id="child_parentid">
                <option value="" >--Select Any One--</option>
                <?php $all_parentcategory= $category->getAllParents();
                   if($all_parentcategory){
                     foreach ($all_parentcategory as $parent_cat) {
                       ?>
                       <option value="<?php echo $parent_cat->id;?>"><?php echo $parent_cat->title; ?></option>
                       <?php
                     }
                   }  
                ?>
                
               
              </select>
            </div>
          </div>
           
           <div class="form-group">
            <div class="col-sm-3">
              <label for="">Show in Menu:</label>
            </div>
            <div class="col-sm-8">
              <input type="checkbox" name="show_inmenu" id="show_inmenu" value="1" checked>Yes
            </div>
          </div>
          
          <div class="form-group">
            <div class="col-sm-3">
              <label for="">Status:</label>
            </div>
            <div class="col-sm-8">
             <select name="category_status" class="form-control" id="category_status">
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
              <input type="file" name="category_image" accept="image/*" required id="category_image">
            </div>
            <div class="col-sm-4">
            <img src="" class="img img-responsive img-thumbnail" id="category_hiddenimage" style="max-width: 100px">
            </div>
          </div>


      <div class="modal-footer">
        <input type="hidden" name="oldcategory_image" id="oldcategory_image" value="">
        <input type="hidden" name="category_id" id="category_id" value="">
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
    $('#add_category').modal('show');
  }
   
   function editCategory(e){
       var category_info= $(e).data('details');
     // console.log(category_info);
        if (category_info) {
          $('.modal-title').html('Edit Category');
          $('#category_title').val(category_info.title);
          $('#category_summary').val(category_info.summary);

          if (category_info.is_parent== 1) {
            $('#is_parent').prop('checked', true);
             $('#choose_parent').addClass('hidden');
            $('#child_parentid').val('');
          }else{
            $('#is_parent').prop('checked', false);
            $('#choose_parent').removeClass('hidden');
            $('#child_parentid').val(category_info.parent_id);
          }
           
           if (category_info.show_in_menu == 1) {
            $('#show_inmenu').prop('checked', true);
           }else{
            $('#show_inmenu').prop('checked', false);
           }

          $('#category_status').val(category_info.status);
          $('#category_hiddenimage').attr('src', "<?php echo UPLOAD_URL; ?>category/"+category_info.image);
          $('#category_image').removeAttr('required');
          $('#oldcategory_image').val(category_info.image);
          $('#category_id').val(category_info.id);
          showPopUp();
        }

   }

   function addCategory(){
          $('.modal-title').html('Add Category');
          $('#category_title').val('');
          $('#category_summary').val('');

          $('#is_parent').prop('checked', true);
          $('#choose_parent').addClass('hidden');
          $('#child_parentid').val('');

          $('#show_inmenu').prop('checked', true);

          $('#category_status').val('Active');
          $('#category_hiddenimage').attr('src', '');
          $('#category_image').attr('required');
          $('#oldcategory_image').val('');
          $('#category_id').val('');
          showPopUp();
   }

   $('#is_parent').on('change', function(){
    var checked= $('#is_parent').prop('checked');
    if(checked) {
       $('#choose_parent').addClass('hidden');
    }else{
      $('#choose_parent').removeClass('hidden');
    }

   })
</script>

