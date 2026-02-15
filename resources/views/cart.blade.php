@extends('Const_Layouts.master')

@section('title', 'OPTIMA - Shopping Cart')

@section('content')
		
		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<ul class="breadcrumb-tree">
							<li><a href="index.html">Home</a></li>
							<li class="active">Shopping Cart</li>
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
		<div id="loading-cart">
			<i class="fa fa-spinner fa-spin fa-3x"></i>
			<p>Loading your cart...</p>
		</div>

		<!-- Empty Cart -->
		<div id="empty-cart">
			<i class="fa fa-shopping-cart fa-5x" style="color: #ddd; margin-bottom: 30px;"></i>
			<h2>Your Shopping Cart is Empty</h2>
			<p>Looks like you haven't added any products to your cart yet.</p>
			<a href="products.php" class="primary-btn" style="margin-top: 20px;">Continue Shopping</a>
		</div>

		<!-- SECTION -->
		<div class="section" id="cart-section" style="display: none;">
			<div class="container">
				<div class="row">
					<!-- Cart Items -->
					<div class="col-md-8">
						<div class="cart-header">
							<h3>Shopping Cart (<span id="cart-items-count">0</span> items)</h3>
						</div>
						
						<div id="cart-items-container">
							<!-- Cart items will be loaded here -->
						</div>
						
						<!-- Coupon Code -->
						<div class="coupon-section">
							<input type="text" class="coupon-input" id="coupon-code" placeholder="Enter coupon code">
							<button class="primary-btn" id="apply-coupon">Apply Coupon</button>
						</div>
						
						<!-- Cart Actions -->
						<div class="cart-actions" style="margin-top: 30px;">
							<button class="update-cart-btn" id="update-cart">
								<i class="fa fa-refresh"></i> Update Cart
							</button>
							<a href="products.php" class="continue-shopping">
								<i class="fa fa-arrow-left"></i> Continue Shopping
							</a>
						</div>
					</div>
					
					<!-- Order Summary -->
					<div class="col-md-4">
						<div class="cart-summary">
							<h4>Order Summary</h4>
							
							<div class="summary-row">
								<span>Subtotal (<span id="summary-items-count">0</span> items)</span>
								<span id="subtotal">$0.00</span>
							</div>
							
							<div class="summary-row">
								<span>Shipping</span>
								<span id="shipping">FREE</span>
							</div>
							
							<div class="summary-row">
								<span>Tax</span>
								<span id="tax">$0.00</span>
							</div>
							
							<div class="summary-row" id="discount-row" style="display: none;">
								<span>Discount</span>
								<span id="discount">-$0.00</span>
							</div>
							
							<div class="summary-row" style="border-bottom: 2px solid #333;">
								<strong>Total</strong>
								<strong class="summary-total" id="total">$0.00</strong>
							</div>
							
							<div style="margin-top: 30px;">
								<a href="checkout.html" class="primary-btn" style="width: 100%; text-align: center; padding: 15px;">
									Proceed to Checkout
								</a>
							</div>
							
							<div style="margin-top: 20px; text-align: center;">
								<p>We accept:</p>
								<div style="font-size: 24px; color: #666;">
									<i class="fa fa-cc-visa"></i>
									<i class="fa fa-cc-mastercard"></i>
									<i class="fa fa-cc-paypal"></i>
									<i class="fa fa-cc-amex"></i>
								</div>
							</div>
						</div>
						
						<!-- Security Info -->
						<div style="margin-top: 20px; padding: 15px; background: #f9f9f9; border-radius: 5px;">
							<p><i class="fa fa-lock" style="color: #27ae60;"></i> Secure checkout</p>
							<p><i class="fa fa-shield" style="color: #3498db;"></i> SSL encrypted</p>
							<p><i class="fa fa-undo" style="color: #9b59b6;"></i> 30-day return policy</p>
						</div>
					</div>
				</div>
				
				<!-- Recently Viewed -->
				<div class="row" style="margin-top: 50px;">
					<div class="col-md-12">
						<h4>Recently Viewed</h4>
						<div id="recently-viewed" style="display: flex; gap: 20px; overflow-x: auto; padding: 20px 0;">
							<!-- -->
						</div>
					</div>
				</div>
			</div>
		</div>
		
		@endsection
		
		@push('scripts')
		<script src="{{ asset('js/jquery.min.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('js/main.js') }}"></script>
		<script src="{{ asset('js/cart.js') }}"></script>
		@endpush
