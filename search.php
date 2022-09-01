<?php require 'config/init.php';
require CLASS_PATH.'product.php';
require CLASS_PATH.'product_image.php';

    $front_page_title= "Kinmel.com || Search Results ";
       
      $product= new Product();
      $product_img= new ProductImage();

     $search_param= array();

     if(isset($_GET['keyword']) && !empty($_GET['keyword'])){

          $search_param['keyword'] = sanitize($_GET['keyword']);
      }

    if(isset($_GET['cat']) && !empty($_GET['cat'])){

          $search_param['cat_id'] = (int)$_GET['cat'];
     }

     if(isset($_GET['min_price']) && !empty($_GET['min_price'])){

          $search_param['min_price'] = (float)$_GET['min_price'];
     }

     if(isset($_GET['max_price']) && !empty($_GET['max_price'])){

          $search_param['max_price'] = (float)$_GET['max_price'];
     }
     if(isset($_GET['brand']) && !empty($_GET['brand'])){

          $search_param['brand'] = sanitize($_GET['brand']);
     }
     
       debugger($search_param);
    $search_result= $product->getSearchValue($search_param);
       debugger($search_result);

?>
<?php require 'inc/header.php';?>
	<!-- BREADCRUMB -->
	<div id="breadcrumb"> 
		<div class="container">
			<ul class="breadcrumb">
				<li><a href="#">Home</a></li>
				<li class="active">Products</li>
			</ul>
		</div>
	</div>
	<!-- /BREADCRUMB -->
  
	<!-- section -->
	<div class="section">
		<!-- container -->
		<div class="container">
			<!-- row -->
			<div class="row">
				<!-- ASIDE -->
				<div id="aside" class="col-md-3">
					

					<!-- aside widget -->
					<div class="aside">
						<h3 class="aside-title">Filter by Price</h3>
						<input type="checkbox" value="0-1000"> NPR. < 1,000 <br>
						<input type="checkbox" value="1000-10000"> NPR. 1,000-10,000 <br>
						<input type="checkbox" value="10000-100000"> NPR. 10,000-100,000 <br>
						<input type="checkbox" value="100000-0"> NPR. > 1,00,000  <br>
					</div>
					<!-- aside widget -->


					<!-- aside widget -->
					<div class="aside">
						<h3 class="aside-title">Filter by Brand</h3>
						<ul class="list-links">
							<li><a href="#">Nike</a></li>
							<li><a href="#">Adidas</a></li>
							<li><a href="#">Polo</a></li>
							<li><a href="#">Lacost</a></li>
						</ul>
					</div>
					<!-- /aside widget -->

					<!-- aside widget -->
					<div class="aside">
						<h3 class="aside-title">Filter by Category</h3>
						<ul class="list-links">
							<li class="active"><a href="#">Electronics</a></li>
							<li><a href="#">Clothing</a></li>
							<li><a href="#"></a></li>
						</ul>
					</div>
					<!-- /aside widget -->

					<!-- aside widget -->
					<div class="aside">
						<h3 class="aside-title">Top Rated Product</h3>
						<!-- widget product -->
						<div class="product product-widget">
							<div class="product-thumb">
								<img src="<?php echo FRONT_IMAGE_URL;?>thumb-product01.jpg" alt="">
							</div>
							<div class="product-body">
								<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
								<h3 class="product-price">$32.50 <del class="product-old-price">$45.00</del></h3>
								<div class="product-rating">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-o empty"></i>
								</div>
							</div>
						</div>
						<!-- /widget product -->

						<!-- widget product -->
						<div class="product product-widget">
							<div class="product-thumb">
								<img src="<?php echo FRONT_IMAGE_URL;?>thumb-product01.jpg" alt="">
							</div>
							<div class="product-body">
								<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
								<h3 class="product-price">$32.50</h3>
								<div class="product-rating">
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star"></i>
									<i class="fa fa-star-o empty"></i>
								</div>
							</div>
						</div>
						<!-- /widget product -->
					</div>
					<!-- /aside widget -->
				</div>
				<!-- /ASIDE -->

				<!-- MAIN -->
				<div id="main" class="col-md-9">
					<!-- STORE -->
					<div id="store">
						<!-- row -->
						<div class="row">
							<!-- Product Single -->
							<div class="col-md-4 col-sm-6 col-xs-6">
								<div class="product product-single">
									<div class="product-thumb">
										<div class="product-label">
											<span>New</span>
											<span class="sale">-20%</span>
										</div>
										
										<img src="<?php echo FRONT_IMAGE_URL;?>product01.jpg" alt="">
									</div>
									<div class="product-body">
										<h3 class="product-price">$32.50 <del class="product-old-price">$45.00</del></h3>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-o empty"></i>
										</div>
										<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
										<div class="product-btns">
											
											<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
										</div>
									</div>
								</div>
							</div>
							<!-- /Product Single -->

							<!-- Product Single -->
							<div class="col-md-4 col-sm-6 col-xs-6">
								<div class="product product-single">
									<div class="product-thumb">
										
										<img src="<?php echo FRONT_IMAGE_URL;?>product02.jpg" alt="">
									</div>
									<div class="product-body">
										<h3 class="product-price">$32.50</h3>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-o empty"></i>
										</div>
										<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
										<div class="product-btns">
											
											<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
										</div>
									</div>
								</div>
							</div>
							<!-- /Product Single -->

							<div class="clearfix visible-sm visible-xs"></div>

							<!-- Product Single -->
							<div class="col-md-4 col-sm-6 col-xs-6">
								<div class="product product-single">
									<div class="product-thumb">
										<div class="product-label">
											<span>New</span>
											<span class="sale">-20%</span>
										</div>
										
										<img src="<?php echo FRONT_IMAGE_URL;?>product03.jpg" alt="">
									</div>
									<div class="product-body">
										<h3 class="product-price">$32.50 <del class="product-old-price">$45.00</del></h3>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-o empty"></i>
										</div>
										<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
										<div class="product-btns">
											
											<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
										</div>
									</div>
								</div>
							</div>
							<!-- /Product Single -->

							<div class="clearfix visible-md visible-lg"></div>

							<!-- Product Single -->
							<div class="col-md-4 col-sm-6 col-xs-6">
								<div class="product product-single">
									<div class="product-thumb">
										<div class="product-label">
											<span>New</span>
										</div>
										
										<img src="<?php echo FRONT_IMAGE_URL;?>product04.jpg" alt="">
									</div>
									<div class="product-body">
										<h3 class="product-price">$32.50</h3>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-o empty"></i>
										</div>
										<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
										<div class="product-btns">
											
											<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
										</div>
									</div>
								</div>
							</div>
							<!-- /Product Single -->

							<div class="clearfix visible-sm visible-xs"></div>

							<!-- Product Single -->
							<div class="col-md-4 col-sm-6 col-xs-6">
								<div class="product product-single">
									<div class="product-thumb">
										<div class="product-label">
											<span>New</span>
										</div>
										
										<img src="<?php echo FRONT_IMAGE_URL;?>product05.jpg" alt="">
									</div>
									<div class="product-body">
										<h3 class="product-price">$32.50</h3>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-o empty"></i>
										</div>
										<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
										<div class="product-btns">
											
											<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
										</div>
									</div>
								</div>
							</div>
							<!-- /Product Single -->

							<!-- Product Single -->
							<div class="col-md-4 col-sm-6 col-xs-6">
								<div class="product product-single">
									<div class="product-thumb">
										<div class="product-label">
											<span>New</span>
											<span class="sale">-20%</span>
										</div>
										
										<img src="<?php echo FRONT_IMAGE_URL;?>product06.jpg" alt="">
									</div>
									<div class="product-body">
										<h3 class="product-price">$32.50 <del class="product-old-price">$45.00</del></h3>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-o empty"></i>
										</div>
										<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
										<div class="product-btns">
											
											<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
										</div>
									</div>
								</div>
							</div>
							<!-- /Product Single -->

							<div class="clearfix visible-md visible-lg visible-sm visible-xs"></div>

							<!-- Product Single -->
							<div class="col-md-4 col-sm-6 col-xs-6">
								<div class="product product-single">
									<div class="product-thumb">
										<div class="product-label">
											<span>New</span>
											<span class="sale">-20%</span>
										</div>
										
										<img src="<?php echo FRONT_IMAGE_URL;?>product07.jpg" alt="">
									</div>
									<div class="product-body">
										<h3 class="product-price">$32.50 <del class="product-old-price">$45.00</del></h3>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-o empty"></i>
										</div>
										<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
										<div class="product-btns">
											
											<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
										</div>
									</div>
								</div>
							</div>
							<!-- /Product Single -->

							<!-- Product Single -->
							<div class="col-md-4 col-sm-6 col-xs-6">
								<div class="product product-single">
									<div class="product-thumb">
										
										<img src="<?php echo FRONT_IMAGE_URL;?>product08.jpg" alt="">
									</div>
									<div class="product-body">
										<h3 class="product-price">$32.50</h3>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-o empty"></i>
										</div>
										<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
										<div class="product-btns">
											
											<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
										</div>
									</div>
								</div>
							</div>
							<!-- /Product Single -->

							<div class="clearfix visible-sm visible-xs"></div>

							<!-- Product Single -->
							<div class="col-md-4 col-sm-6 col-xs-6">
								<div class="product product-single">
									<div class="product-thumb">
										<div class="product-label">
											<span class="sale">-20%</span>
										</div>
										
										<img src="<?php echo FRONT_IMAGE_URL;?>product01.jpg" alt="">
									</div>
									<div class="product-body">
										<h3 class="product-price">$32.50 <del class="product-old-price">$45.00</del></h3>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-o empty"></i>
										</div>
										<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
										<div class="product-btns">
											
											<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
										</div>
									</div>
								</div>
							</div>
							<!-- /Product Single -->
						</div>
						<!-- /row -->
					</div>
					<!-- /STORE -->
				</div>
				<!-- /MAIN -->
			</div>
			<!-- /row -->
		</div>
		<!-- /container -->
	</div>
	<!-- /section -->
    
    <div class="section">
    	<div class="container">
    		<div class="row">
    		   <div class="col-md-12">
    		   	  <h4>Recommended Products</h4>
    		   	  <hr>
    		   </div>
    		   <div class="col-md-12">
    		   	  <?php
    		   	      // $decoded_product= $product->getSearchValue();

                     if(isset($_COOKIE['_user_id']) && !empty($_COOKIE['_user_id'])){
                        $file= "track_data/recommended/recommended-".$_COOKIE['_user_id'].".json";
                            debugger($file);
                          if (file_exists($file)) {
                             $recommended_product= file_get_contents($file);
                               if (empty($recommended_product)) {
                     	                $recommended_product= $product->getSearchValue();
                                }
                        
                                       $decoded_product= json_decode($recommended_product);
                                       // debugger($decoded_product, true);
                            }
                        }else{
                        	$decoded_product= $product->getSearchValue();
                        }

                     if ($decoded_product) {
                     	   foreach ($decoded_product as $recommended_products) {
                   ?>
                     
                     	<!-- Product Single -->
							<div class="col-md-4 col-sm-6 col-xs-6">
								<div class="product product-single">
									<div class="product-thumb">
										<div class="product-label">
											<span class="sale">-20%</span>
										</div>
										
										<img src="<?php echo FRONT_IMAGE_URL;?>product01.jpg" alt="">
									</div>
									<div class="product-body">
										<h3 class="product-price">$32.50 <del class="product-old-price">$45.00</del></h3>
										<div class="product-rating">
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star"></i>
											<i class="fa fa-star-o empty"></i>
										</div>
										<h2 class="product-name"><a href="#">Product Name Goes Here</a></h2>
										<div class="product-btns">
											
											<button class="primary-btn add-to-cart"><i class="fa fa-shopping-cart"></i> Add to Cart</button>
										</div>
									</div>
								</div>
							</div>
							<!-- /Product Single -->                        

                   <?php
                     	   }
                     }

    		   	  ?>
    		   </div>	
    		</div>
    	</div>
    </div>

   <?php require 'inc/footer.php';?>
   <?php require 'inc/track.php';?>

