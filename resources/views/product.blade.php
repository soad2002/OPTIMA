<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>OPTIMA - Product Details</title>
 		<link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">
 		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
 		<!-- Slick -->
 		<link type="text/css" rel="stylesheet" href="css/slick.css"/>
 		<link type="text/css" rel="stylesheet" href="css/slick-theme.css"/>
 		<!-- nouislider -->
 		<link type="text/css" rel="stylesheet" href="css/nouislider.min.css"/>
 		<link rel="stylesheet" href="css/font-awesome.min.css">
 		<link type="text/css" rel="stylesheet" href="css/style.css"/>
    </head>
	<body>
		<!-- HEADER -->
		<header>
			<div id="header">
				<div class="container">
					<div class="row">
						<!-- LOGO -->
						<div class="col-md-3">
							<div class="header-logo">
								<a href="index.html" class="logo">
									<img src="./img/logo.png" alt="OPTIMA">
								</a>
							</div>
						</div>
						<!-- SEARCH BAR -->
						<div class="col-md-5">
							<div class="header-search">
								<form id="searchForm">
									<select class="input-select" id="categorySelect">
										<option value="0">All Categories</option>
										<option value="laptops">Laptops</option>
										<option value="smartphones">Smartphones</option>
										<option value="cameras">Cameras</option>
										<option value="accessories">Accessories</option>
									</select>
									<input class="input" id="searchInput" placeholder="Search products...">
									<button type="submit" class="search-btn">Search</button>
								</form>
							</div>
						</div>
						<div class="col-md-4 clearfix">
							<div class="header-ctn">
								<!-- Wishlist -->
								<div>
									<a href="wishlist.html" id="wishlist-link">
										<i class="fa fa-heart-o"></i>
										<span>My Wishlist</span>
										<div class="qty" id="wishlist-count">0</div>
									</a>
								</div>
								<!-- Account -->
								<div>
									<a href="account.html">
										<i class="fa fa-user-o"></i>
										<span>My Account</span>
									</a>
								</div>
								<!-- Cart -->
								<div class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" href="cart.html">
										<i class="fa fa-shopping-cart"></i>
										<span>My Cart</span>
										<div class="qty" id="cart-count">0</div>
									</a>
									<div class="cart-dropdown">
										<div class="cart-list" id="cart-dropdown-items">
											<div class="empty-cart-message" style="padding: 20px; text-align: center;">
												Your cart is empty
											</div>
										</div>
										<div class="cart-summary">
											<small id="cart-summary-count">0 Item(s)</small>
											<h5 id="cart-summary-total">SUBTOTAL: $0.00</h5>
										</div>
										<div class="cart-btns">
											<a href="cart.html">View Cart</a>
											<a href="checkout.html">Checkout  <i class="fa fa-arrow-circle-right"></i></a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</header>
		
		<!-- NAVIGATION -->
		<nav id="navigation">
			<div class="container">
				<div id="responsive-nav">
					<ul class="main-nav nav navbar-nav">
						<li><a href="index.html">Home</a></li>
						<li><a href="hot-deals.html">Hot Deals</a></li>
						<li><a href="laptops.html">Laptops</a></li>
						<li><a href="smartphones.html">Smartphones</a></li>
						<li><a href="cameras.html">Cameras</a></li>
						<li><a href="accessories.html">Accessories</a></li>
					</ul>
				</div>
			</div>
		</nav>
		
		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<ul class="breadcrumb-tree" id="breadcrumb-nav">
							<li><a href="index.html">Home</a></li>
							<li><a href="#">All Categories</a></li>
							<li class="active">Loading...</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<!-- Alert Messages -->
		<div class="container">
			<div id="success-alert" class="alert alert-success"></div>
			<div id="error-alert" class="alert alert-error"></div>
		</div>

		<!-- Loading State -->
		<div id="loading-product">
			<i class="fa fa-spinner fa-spin fa-3x"></i>
			<p>Loading product details...</p>
		</div>

		<!-- Product Not Found -->
		<div id="product-not-found">
			<h2>Product Not Found</h2>
			<p>The product you are looking for does not exist or has been removed.</p>
			<a href="products.html" class="primary-btn">Browse Products</a>
		</div>

		<!-- SECTION - Product Details -->
		<div class="section" id="product-details-section" style="display: none;">
			<div class="container">
				<div class="row">
					<!-- Product Images -->
					<div class="col-md-5 col-md-push-2">
						<div id="product-main-img">
							<div class="product-preview">
								<img id="main-product-image" src="" alt="">
							</div>
						</div>
					</div>

					<!-- Product Thumbnails -->
					<div class="col-md-2 col-md-pull-5">
						<div id="product-images">
							<!-- Product thumbnails will be loaded here -->
						</div>
					</div>

					<!-- Product Details -->
					<div class="col-md-5">
						<div class="product-details">
							<h2 class="product-name" id="product-name">Product Name</h2>
							<div>
								<div class="product-rating" id="product-rating">
									<!-- Stars will be loaded here -->
								</div>
								<a class="review-link" data-toggle="tab" href="#tab3">
									<span id="review-count">0</span> Review(s) | Add your review
								</a>
							</div>
							<div>
								<h3 class="product-price" id="product-price">$0.00</h3>
								<span class="product-available" id="stock-status">In Stock</span>
							</div>
							<p id="product-short-description">Product description...</p>

							<!-- Product Options -->
							<div class="product-options" id="product-options">
								<!-- Options will be loaded here if available -->
							</div>

							<!-- Add to Cart -->
							<div class="add-to-cart">
								<div class="qty-label">
									Quantity
									<div class="quantity-control">
										<button class="quantity-btn" id="decrease-qty">-</button>
										<input type="number" id="quantity-input" value="1" min="1" max="99">
										<button class="quantity-btn" id="increase-qty">+</button>
									</div>
								</div>
								<button class="add-to-cart-btn" id="add-to-cart-btn">
									<i class="fa fa-shopping-cart"></i> Add to Cart
								</button>
								<button class="add-to-cart-btn" id="buy-now-btn" style="margin-top: 10px; background: #4CAF50;">
									<i class="fa fa-bolt"></i> Buy Now
								</button>
							</div>

							<!-- Wishlist & Compare -->
							<ul class="product-btns">
								<li><a href="#" id="add-to-wishlist-btn"><i class="fa fa-heart-o"></i> Add to Wishlist</a></li>
								<li><a href="#" id="add-to-compare-btn"><i class="fa fa-exchange"></i> Add to Compare</a></li>
							</ul>

							<!-- Product Links -->
							<ul class="product-links">
								<li>Category:</li>
								<li><a href="#" id="product-category">Category</a></li>
								<li><a href="#" id="product-subcategory">Subcategory</a></li>
							</ul>

							<!-- Share Product -->
							<ul class="product-links">
								<li>Share:</li>
								<li>
									<a href="#"><i class="fa fa-facebook"></i></a>
									<a href="#"><i class="fa fa-twitter"></i></a>
									<a href="#"><i class="fa fa-pinterest"></i></a>
									<a href="#"><i class="fa fa-whatsapp"></i></a>
								</li>
							</ul>
						</div>
					</div>

					<!-- Product Tabs -->
					<div class="col-md-12">
						<div id="product-tab">
							<!-- Product Tab Navigation -->
							<ul class="tab-nav">
								<li class="active"><a data-toggle="tab" href="#tab1">Description</a></li>
								<li><a data-toggle="tab" href="#tab2">Specifications</a></li>
								<li><a data-toggle="tab" href="#tab3">Reviews (<span id="tab-review-count">0</span>)</a></li>
							</ul>

							<!-- Product Tab Content -->
							<div class="tab-content">
								<!-- Description Tab -->
								<div id="tab1" class="tab-pane fade in active">
									<div class="row">
										<div class="col-md-12" id="product-description">
											<!-- Description will be loaded here -->
										</div>
									</div>
								</div>

								<!-- Specifications Tab -->
								<div id="tab2" class="tab-pane fade in">
									<div class="row">
										<div class="col-md-12">
											<table class="table" id="product-specifications">
												<!-- Specifications will be loaded here -->
											</table>
										</div>
									</div>
								</div>

								<!-- Reviews Tab -->
								<div id="tab3" class="tab-pane fade in">
									<div class="row">
										<!-- Rating Summary -->
										<div class="col-md-3">
											<div id="rating">
												<div class="rating-avg">
													<span id="average-rating">0.0</span>
													<div class="rating-stars" id="average-stars">
														<!-- Stars will be loaded here -->
													</div>
												</div>
												<ul class="rating" id="rating-distribution">
													<!-- Rating distribution will be loaded here -->
												</ul>
											</div>
										</div>

										<!-- Reviews List -->
										<div class="col-md-6">
											<div id="reviews">
												<ul class="reviews" id="reviews-list">
													<!-- Reviews will be loaded here -->
													<li id="no-reviews-message">
														<div class="review-body">
															<p>No reviews yet. Be the first to review this product!</p>
														</div>
													</li>
												</ul>
												<ul class="reviews-pagination" id="reviews-pagination">
													<!-- Pagination will be loaded here -->
												</ul>
											</div>
										</div>

										<!-- Review Form -->
										<div class="col-md-3">
											<div id="review-form">
												<h4>Add Your Review</h4>
												<form class="review-form" id="submit-review-form">
													<input class="input" type="text" id="reviewer-name" placeholder="Your Name" required>
													<input class="input" type="email" id="reviewer-email" placeholder="Your Email" required>
													<textarea class="input" id="review-text" placeholder="Your Review" rows="4" required></textarea>
													<div class="input-rating">
														<span>Your Rating: </span>
														<div class="stars">
															<input id="star5" name="rating" value="5" type="radio"><label for="star5"></label>
															<input id="star4" name="rating" value="4" type="radio"><label for="star4"></label>
															<input id="star3" name="rating" value="3" type="radio"><label for="star3"></label>
															<input id="star2" name="rating" value="2" type="radio"><label for="star2"></label>
															<input id="star1" name="rating" value="1" type="radio"><label for="star1"></label>
														</div>
													</div>
													<button type="submit" class="primary-btn">Submit Review</button>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- SECTION - Related Products -->
		<div class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="section-title text-center">
							<h3 class="title">Related Products</h3>
						</div>
					</div>

					<!-- Related Products Container -->
					<div id="related-products-container">
						<!-- Related products will be loaded here -->
					</div>
				</div>
			</div>
		</div>
		
		<!-- FOOTER -->
		<footer id="footer">
			<div class="section">
				<div class="container">
					<div class="row">
						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">About Us</h3>
								<p>The leading technical destination connecting customers with lastest global electronic innovations, at affordable prices and exceptional service.</p>
								<ul class="footer-links">
									<li><a href="#"><i class="fa fa-map-marker"></i>Damascus - Syria</a></li>
									<li><a href="#"><i class="fa fa-phone"></i>+963912323455</a></li>
									<li><a href="#"><i class="fa fa-envelope-o"></i>OPTIMA@Email.com</a></li>
								</ul>
							</div>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Categories</h3>
								<ul class="footer-links">
									<li><a href="laptops.html">Laptops</a></li>
									<li><a href="smartphones.html">Smartphones</a></li>
									<li><a href="cameras.html">Cameras</a></li>
									<li><a href="accessories.html">Accessories</a></li>
								</ul>
							</div>
						</div>

						<div class="clearfix visible-xs"></div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Information</h3>
								<ul class="footer-links">
									<li><a href="about.html">About Us</a></li>
									<li><a href="contact.html">Contact Us</a></li>
									<li><a href="privacy.html">Privacy Policy</a></li>
									<li><a href="returns.html">Orders and Returns</a></li>
									<li><a href="terms.html">Terms & Conditions</a></li>
								</ul>
							</div>
						</div>

						<div class="col-md-3 col-xs-6">
							<div class="footer">
								<h3 class="footer-title">Customer Services</h3>
								<ul class="footer-links">
									<li><a href="account.html">My Account</a></li>
									<li><a href="cart.html">View Cart</a></li>
									<li><a href="wishlist.html">Wishlist</a></li>
									<li><a href="track-order.html">Track My Order</a></li>
									<li><a href="help.html">Help</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div id="bottom-footer" class="section">
				<div class="container">
					<div class="row">
						<div class="col-md-12 text-center">
							<span class="copyright">
								Copyright &copy;<script>document.write(new Date().getFullYear());</script> OPTIMA Team . All rights reserved.
							</span>
						</div>
					</div>
				</div>
			</div>
		</footer>
		
		<!-- jQuery Plugins -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/slick.min.js"></script>
		<script src="js/nouislider.min.js"></script>
		<script src="js/jquery.zoom.min.js"></script>
		<script src="js/main.js"></script>
		<script src="js/product.js"></script>
	</body>
</html>