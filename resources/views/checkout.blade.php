@extends('Const_Layouts.master')

@section('title', 'OPTIMA - Checkout')

@section('content')
		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h3 class="breadcrumb-header">Checkout</h3>
						<ul class="breadcrumb-tree">
							<li><a href="{{ route('home') }}">Home</a></li>
							<li><a href="{{ route('cart') }}">Cart</a></li>
							<li class="active">Checkout</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<!-- SECTION -->
		<div class="section">
			<div class="container">
				<!-- Alert-->
				<div id="success-alert" class="alert alert-success"></div>
				<div id="error-alert" class="alert alert-error"></div>
				<div id="warning-alert" class="alert alert-warning"></div>
				
				<div class="row">
					<div class="col-md-7">
						<!-- Shipping Details -->
						<div class="Shipping-details">
							<div class="section-title">
								<h3 class="title">Shipping Information</h3>
							</div>
							<div class="form-group">
								<input class="input" type="text" id="firstName" placeholder="First Name" required>
								<div class="error-message" id="firstName-error">Please enter your first name</div>
							</div>
							<div class="form-group">
								<input class="input" type="text" id="lastName" placeholder="Last Name" required>
								<div class="error-message" id="lastName-error">Please enter your last name</div>
							</div>
							<div class="form-group">
								<input class="input" type="email" id="email" placeholder="Email" required>
								<div class="error-message" id="email-error">Please enter a valid email</div>
							</div>
							<div class="form-group">
								<input class="input" type="text" id="address" placeholder="Address" required>
								<div class="error-message" id="address-error">Please enter your address</div>
							</div>
							<div class="form-group">
								<input class="input" type="text" id="city" placeholder="City" required>
								<div class="error-message" id="city-error">Please enter your city</div>
							</div>
							<div class="form-group">
								<input class="input" type="text" id="country" placeholder="Country" required>
								<div class="error-message" id="country-error">Please enter your country</div>
							</div>
							<div class="form-group">
								<input class="input" type="tel" id="phone" placeholder="Phone Number" required>
								<div class="error-message" id="phone-error">Please enter your phone number</div>
							</div>
						</div>
						<!-- Order notes -->
						<div class="order-notes">
							<textarea class="input" id="orderNotes" placeholder="Order Notes (optional)"></textarea>
						</div>
						<!-- Billing Details -->
						<div class="Billing-details">
							<div class="section-title">
								<h3 class="title">Billing Information</h3>
							</div>
							<div class="input-checkbox">
								<input type="checkbox" id="differentBilling">
								<label for="differentBilling">
									<span></span>
									Not same as shipping address?
								</label>
								<div class="caption" id="billing-fields" style="display: none;">
									<div class="form-group">
										<input class="input" type="text" id="billingFirstName" placeholder="First Name">
									</div>
									<div class="form-group">
										<input class="input" type="text" id="billingLastName" placeholder="Last Name">
									</div>
									<div class="form-group">
										<input class="input" type="email" id="billingEmail" placeholder="Email">
									</div>
									<div class="form-group">
										<input class="input" type="text" id="billingAddress" placeholder="Address">
									</div>
									<div class="form-group">
										<input class="input" type="text" id="billingCity" placeholder="City">
									</div>
									<div class="form-group">
										<input class="input" type="text" id="billingCountry" placeholder="Country">
									</div>
									<div class="form-group">
										<input class="input" type="tel" id="billingPhone" placeholder="Phone Number">
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Order Details -->
					<div class="col-md-5 order-details">
						<div class="section-title text-center">
							<h3 class="title">Your Order</h3>
						</div>
						<div class="order-summary">
							<div class="order-col">
								<div><strong>PRODUCT</strong></div>
								<div><strong>TOTAL</strong></div>
							</div>
							<div id="order-items-container">
								<!-- -->
								<div id="empty-cart-message">
									<i class="fa fa-shopping-cart" style="font-size: 48px; margin-bottom: 20px;"></i>
									<h4>Your cart is empty</h4>
									<p>Add products to your cart first</p>
									<a href="products.php" class="primary-btn">Continue Shopping</a>
								</div>
							</div>
							<div class="order-col">
								<div>Subtotal</div>
								<div><strong id="subtotal">$0.00</strong></div>
							</div>
							<div class="order-col">
								<div>Shipping</div>
								<div><strong id="shipping">FREE</strong></div>
							</div>
							<div class="order-col">
								<div>Tax</div>
								<div><strong id="tax">$0.00</strong></div>
							</div>
							<div class="order-col">
								<div><strong>TOTAL</strong></div>
								<div><strong class="order-total" id="total">$0.00</strong></div>
							</div>
						</div>
						<div class="payment-method">
							<h5 class="title">Payment Method</h5>
							<div class="input-radio">
								<input type="radio" name="payment" id="payment-1" value="cod" checked>
								<label for="payment-1">
									<span></span>
									Cash on Delivery
								</label>
							</div>
							<div class="input-radio">
								<input type="radio" name="payment" id="payment-2" value="card">
								<label for="payment-2">
									<span></span>
									Credit/Debit Card
								</label>
							</div>
							<div class="input-radio">
								<input type="radio" name="payment" id="payment-3" value="bank">
								<label for="payment-3">
									<span></span>
									Bank Transfer
								</label>
							</div>
							<!-- (card) -->
							<div id="card-details" style="display: none; margin-top: 20px;">
								<div class="form-group">
									<input class="input" type="text" id="cardNumber" placeholder="Card Number">
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<input class="input" type="text" id="cardExpiry" placeholder="MM/YY">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<input class="input" type="text" id="cardCVC" placeholder="CVC">
										</div>
									</div>
								</div>
								<div class="form-group">
									<input class="input" type="text" id="cardName" placeholder="Name on Card">
								</div>
							</div>
						</div>
						<div class="input-checkbox">
							<input type="checkbox" id="terms">
							<label for="terms">
								<span></span>
								I've read and accept the <a href="terms.html">terms & conditions</a>
							</label>
							<div class="error-message" id="terms-error">You must accept the terms & conditions</div>
						</div>
						<button id="submit-order-btn" class="primary-btn order-submit" style="width: 100%; padding: 15px;">
							<span id="submit-btn-text">Place Order</span>
							<span id="submit-btn-loading" style="display: none;">
								<i class="fa fa-spinner fa-spin"></i> Processing...
							</span>
						</button>
					</div>
				</div>
			</div>
		</div>
		@endsection
		
		@push('scripts')
		<script src="{{ asset('js/jquery.min.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('js/main.js') }}"></script>
		<script src="{{ asset('js/checkout.js') }}"></script>
		@endpush