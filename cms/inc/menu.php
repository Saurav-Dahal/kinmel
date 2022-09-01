 <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index" class="site_title"><i class="fa fa-paw"></i> <span>Admin Kinmel!</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_info">
                <span>Welcome,</span>
                <h2><?php echo $session->getSessionKeyValueByKey('full_name') ; ?></h2>
              </div>
              <div class="clearfix"></div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>General</h3>
                <ul class="nav side-menu">
                  <li><a><i class="fa fa-home"></i>Home <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="banner">Banner</a></li>
                      <li><a href="category">Category</a></li>
                      <li><a href="brand">Brand</a></li>
                      
                    </ul>
                  </li>

                  <li><a><i class="fa fa-shopping-basket"></i>Product <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="product-add">Add Product</a></li>
                      <li><a href="product-list">List Product</a></li>
                      
                    </ul>
                  </li>

                  <li>
                    <a href="order"><i class="fa fa-shopping-cart"></i>Order</a>
                  </li>

                   <li>
                    <a href="order"><i class="fa fa-users"></i>Users</a>
                  </li>

                   <li><a href="order"><i class="fa fa-image"></i>Advertisement</a></li>

                  
                </ul>
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
           
            <!-- /menu footer buttons -->
          </div>
        </div>