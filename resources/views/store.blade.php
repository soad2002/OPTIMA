@extends('Const_Layouts.master')

@section('title', 'OPTIMA - Store')

@section('content')
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
							<li><a href="products.php">All Categories</a></li>
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
		@endsection

@push('scripts')
<script src="{{ asset('js/store.js') }}"></script>
@endpush