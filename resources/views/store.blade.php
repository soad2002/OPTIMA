<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>OPTIMA - Store</title>
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
										<option value="all">All Categories</option>
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

		<!-- Alert Messages -->
		<div class="container">
			<div id="success-alert" class="alert alert-success"></div>
			<div id="error-alert" class="alert alert-error"></div>
		</div>

		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<ul class="breadcrumb-tree" id="breadcrumb-nav">
							<li><a href="index.html">Home</a></li>
							<li><a href="products.html">All Categories</a></li>
							<li class="active">Products</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<!-- SECTION -->
		<div class="section">
			<div class="container">
				<div class="row">
					<!-- SIDEBAR FILTERS -->
					<div id="aside" class="col-md-3">
						<!-- Categories Filter -->
						<div class="aside filter-section">
							<h3 class="aside-title filter-title">Categories</h3>
							<div class="checkbox-filter" id="categories-filter">
								<!-- Categories will be loaded dynamically -->
							</div>
						</div>

						<!-- Price Filter -->
						<div class="aside filter-section">
							<h3 class="aside-title filter-title">Price Range</h3>
							<div class="price-filter">
								<div id="price-slider"></div>
								<div class="price-inputs">
									<input type="number" id="price-min" placeholder="Min" min="0" max="10000">
									<span>-</span>
									<input type="number" id="price-max" placeholder="Max" min="0" max="10000">
									<button class="primary-btn" id="apply-price-filter">Apply</button>
								</div>
							</div>
						</div>

						<!-- Brands Filter -->
						<div class="aside filter-section">
							<h3 class="aside-title filter-title">Brands</h3>
							<div class="checkbox-filter" id="brands-filter">
								<!-- Brands will be loaded dynamically -->
							</div>
						</div>

						<!-- Top Selling Products -->
						<div class="aside filter-section">
							<h3 class="aside-title filter-title">Top Selling</h3>
							<div id="top-selling-products">
								<!-- Top selling products will be loaded dynamically -->
							</div>
						</div>

						<!-- Clear Filters Button -->
						<div class="aside filter-section">
							<button class="primary-btn" id="clear-filters" style="width: 100%;">
								Clear All Filters
							</button>
						</div>
					</div>

					<!-- STORE -->
					<div id="store" class="col-md-9">
						<!-- Store top filter -->
						<div class="store-filter clearfix">
							<div class="store-sort">
								<div class="sort-options">
									<label>
										Sort By:
										<select class="input-select" id="sort-by">
											<option value="popular">Most Popular</option>
											<option value="price-low">Price: Low to High</option>
											<option value="price-high">Price: High to Low</option>
											<option value="name-asc">Name: A to Z</option>
											<option value="name-desc">Name: Z to A</option>
											<option value="rating">Highest Rated</option>
											<option value="newest">Newest First</option>
										</select>
									</label>

									<label>
										Show:
										<select class="input-select" id="items-per-page">
											<option value="12">12</option>
											<option value="24">24</option>
											<option value="36">36</option>
											<option value="48">48</option>
										</select>
									</label>
								</div>
							</div>
							<ul class="store-grid">
								<li class="active" data-view="grid"><i class="fa fa-th"></i></li>
								<li data-view="list"><i class="fa fa-th-list"></i></li>
							</ul>
						</div>

						<!-- Products Loading State -->
						<div id="loading-products">
							<i class="fa fa-spinner fa-spin fa-3x"></i>
							<p>Loading products...</p>
						</div>

						<!-- No Products Found -->
						<div id="no-products-found">
							<h3>No Products Found</h3>
							<p>Try adjusting your search or filter criteria</p>
							<button class="primary-btn" id="reset-search">Reset Search</button>
						</div>

						<!-- Store products -->
						<div class="row" id="products-container">
							<!-- Products will be loaded dynamically -->
						</div>

						<!-- Store bottom filter -->
						<div class="store-filter clearfix">
							<span class="store-qty" id="products-count">Showing 0 products</span>
							<ul class="store-pagination" id="products-pagination">
								<!-- Pagination will be loaded dynamically -->
							</ul>
						</div>
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
		<script src="js/store.js"></script>
	</body>
</html>