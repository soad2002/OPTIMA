@extends('Const_Layouts.master')

@section('title', 'OPTIMA - My Account')

@section('content')
		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<ul class="breadcrumb-tree">
							<li><a href="{{ route('home') }}">Home</a></li>
							<li class="active">My Account</li>
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
		<div id="loading-account">
			<i class="fa fa-spinner fa-spin fa-3x"></i>
			<p>Loading account information...</p>
		</div>

		<!-- SECTION -->
		<div class="section" id="account-section" style="display: none;">
			<div class="container">
				<div class="row">
					<!-- Sidebar -->
					<div class="col-md-3">
						<div class="account-sidebar">
							<div class="profile-header">
								<div class="profile-avatar" id="user-avatar">
									<i class="fa fa-user"></i>
								</div>
								<div>
									<h5 id="user-name">Loading...</h5>
									<p id="user-email">...</p>
								</div>
							</div>
							<ul>
								<li><a href="#" class="active" onclick="showSection('dashboard')"><i class="fa fa-dashboard"></i> Dashboard</a></li>
								<li><a href="#" onclick="showSection('orders')"><i class="fa fa-shopping-bag"></i> My Orders</a></li>
								<li><a href="#" onclick="showSection('addresses')"><i class="fa fa-map-marker"></i> My Addresses</a></li>
								<li><a href="#" onclick="showSection('wishlist')"><i class="fa fa-heart"></i> My Wishlist</a></li>
								<li><a href="#" onclick="showSection('profile')"><i class="fa fa-user"></i> Profile Settings</a></li>
								<li><a href="#" onclick="showSection('password')"><i class="fa fa-lock"></i> Change Password</a></li>
								<li><a href="#" onclick="logout()" style="color: #e74c3c;"><i class="fa fa-sign-out"></i> Logout</a></li>
							</ul>
						</div>
					</div>
					
					<!-- Main Content -->
					<div class="col-md-9">
						<!-- Dashboard Section -->
						<div id="dashboard-section" class="account-section active">
							<h3>Dashboard</h3>
							<p>Welcome back, <span id="dashboard-name">User</span>!</p>
							
							<div class="row" style="margin-top: 30px;">
								<div class="col-md-4">
									<div class="order-card">
										<h5><i class="fa fa-shopping-bag" style="color: #3498db;"></i> Total Orders</h5>
										<h3 id="total-orders">0</h3>
										<a href="#" onclick="showSection('orders')">View All Orders</a>
									</div>
								</div>
								<div class="col-md-4">
									<div class="order-card">
										<h5><i class="fa fa-heart" style="color: #e74c3c;"></i> Wishlist Items</h5>
										<h3 id="wishlist-total">0</h3>
										<a href="#" onclick="showSection('wishlist')">View Wishlist</a>
									</div>
								</div>
								<div class="col-md-4">
									<div class="order-card">
										<h5><i class="fa fa-star" style="color: #f39c12;"></i> Account Since</h5>
										<h3 id="member-since">2024</h3>
										<p>Loyal Customer</p>
									</div>
								</div>
							</div>
							
							<!-- Recent Orders -->
							<div style="margin-top: 30px;">
								<h5>Recent Orders</h5>
								<div id="recent-orders">
									<!-- Recent orders will be loaded here -->
								</div>
							</div>
						</div>
						
						<!-- Orders Section -->
						<div id="orders-section" class="account-section">
							<h3>My Orders</h3>
							<div id="orders-container">
								<!-- Orders will be loaded here -->
							</div>
						</div>
						
						<!-- Addresses Section -->
						<div id="addresses-section" class="account-section">
							<h3>My Addresses</h3>
							<div id="addresses-container">
								<!-- Addresses will be loaded here -->
							</div>
							
							<button class="primary-btn" onclick="showAddAddressForm()" style="margin-top: 20px;">
								<i class="fa fa-plus"></i> Add New Address
							</button>
							
							<!-- Add Address Form -->
							<div id="add-address-form" class="form-section" style="display: none; margin-top: 30px;">
								<h4>Add New Address</h4>
								<form id="new-address-form">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Full Name *</label>
												<input type="text" class="input" id="address-name" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Phone Number *</label>
												<input type="tel" class="input" id="address-phone" required>
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<label>Address Line 1 *</label>
										<input type="text" class="input" id="address-line1" required>
									</div>
									
									<div class="form-group">
										<label>Address Line 2</label>
										<input type="text" class="input" id="address-line2">
									</div>
									
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<label>City *</label>
												<input type="text" class="input" id="address-city" required>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>State/Province *</label>
												<input type="text" class="input" id="address-state" required>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<label>ZIP/Postal Code *</label>
												<input type="text" class="input" id="address-zip" required>
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<label>Country *</label>
										<input type="text" class="input" id="address-country" required>
									</div>
									
									<div class="form-group">
										<label>
											<input type="checkbox" id="address-default"> Set as default address
										</label>
									</div>
									
									<div class="form-group">
										<button type="submit" class="primary-btn">Save Address</button>
										<button type="button" class="primary-btn" onclick="hideAddAddressForm()" style="background: #95a5a6; margin-left: 10px;">Cancel</button>
									</div>
								</form>
							</div>
						</div>
						
						<!-- Wishlist Section -->
						<div id="wishlist-section" class="account-section">
							<h3>My Wishlist</h3>
							<div id="wishlist-container">
								<!-- Wishlist items will be loaded here -->
							</div>
						</div>
						
						<!-- Profile Settings Section -->
						<div id="profile-section" class="account-section">
							<h3>Profile Settings</h3>
							<div class="form-section">
								<form id="profile-form">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>First Name *</label>
												<input type="text" class="input" id="first-name" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Last Name *</label>
												<input type="text" class="input" id="last-name" required>
											</div>
										</div>
									</div>
									
									<div class="form-group">
										<label>Email Address *</label>
										<input type="email" class="input" id="profile-email" required>
									</div>
									
									<div class="form-group">
										<label>Phone Number</label>
										<input type="tel" class="input" id="profile-phone">
									</div>
									
									<div class="form-group">
										<label>Date of Birth</label>
										<input type="date" class="input" id="profile-dob">
									</div>
									
									<div class="form-group">
										<label>Gender</label>
										<select class="input-select" id="profile-gender">
											<option value="">Select Gender</option>
											<option value="male">Male</option>
											<option value="female">Female</option>
											<option value="other">Other</option>
										</select>
									</div>
									
									<button type="submit" class="primary-btn">Update Profile</button>
								</form>
							</div>
						</div>
						
						<!-- Change Password Section -->
						<div id="password-section" class="account-section">
							<h3>Change Password</h3>
							<div class="form-section">
								<form id="password-form">
									<div class="form-group">
										<label>Current Password *</label>
										<input type="password" class="input" id="current-password" required>
									</div>
									
									<div class="form-group">
										<label>New Password *</label>
										<input type="password" class="input" id="new-password" required>
										<small>Password must be at least 8 characters long</small>
									</div>
									
									<div class="form-group">
										<label>Confirm New Password *</label>
										<input type="password" class="input" id="confirm-password" required>
									</div>
									
									<button type="submit" class="primary-btn">Change Password</button>
								</form>
							</div>
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
		<script src="{{ asset('js/account.js') }}"></script>
		@endpush