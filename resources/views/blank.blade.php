@extends('Const_Layouts.master')

@section('title', 'OPTIMA - Blank Page')

@section('content')
		<!-- BREADCRUMB -->
		<div id="breadcrumb" class="section">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<h3 class="breadcrumb-header">Blank Page</h3>
						<ul class="breadcrumb-tree">
							<li><a href="{{ route('home') }}">Home</a></li>
							<li class="active">Blank</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<!-- SECTION -->
		<div class="section">
			<div class="container">
				<div class="row">
					<!-- Hero / Intro -->
					<div class="col-md-12">
						<div class="section-title text-center">
							<h2 class="title">About OPTIMA</h2>
							<p class="lead">OPTIMA connects customers with the latest global electronics — crafted to deliver great value, dependable service, and a delightful shopping experience.</p>
						</div>
					</div>

					<!-- Mission & Vision -->
					<div class="col-md-6">
						<h3>Our Mission</h3>
						<p>To make cutting-edge technology accessible to everyone by offering carefully selected products, honest pricing, and exceptional customer support.</p>
						<h3>Our Vision</h3>
						<p>To be the most trusted local destination for consumer electronics — where quality, transparency, and community matter.</p>
					</div>

					<!-- Values & Stats -->
					<div class="col-md-6">
						<h3>Core Values</h3>
						<ul>
							<li>Customer first — we listen and act.</li>
							<li>Quality — we curate reliable products.</li>
							<li>Integrity — transparent pricing and policies.</li>
							<li>Community — supporting local needs and growth.</li>
						</ul>

						<div style="margin-top:20px; display:flex; gap:20px; flex-wrap:wrap;">
							<div style="flex:1; min-width:120px; text-align:center;">
								<strong style="font-size:24px; display:block;">10k+</strong>
								<small>Happy Customers</small>
							</div>
							<div style="flex:1; min-width:120px; text-align:center;">
								<strong style="font-size:24px; display:block;">500+</strong>
								<small>Products</small>
							</div>
							<div style="flex:1; min-width:120px; text-align:center;">
								<strong style="font-size:24px; display:block;">24/7</strong>
								<small>Support</small>
							</div>
						</div>
					</div>

					<!-- Team / Contact CTA -->
					<div class="col-md-8">
						<h3>Get in Touch</h3>
						<p>If you have questions about products, orders, or partnerships — we're here to help. Reach out and our team will respond promptly.</p>
						<p><a href="{{ route('contact') }}" class="primary-btn">Contact Us</a></p>
					</div>

					<div class="col-md-4 text-center">
						<img src="{{ asset('img/logo.png') }}" alt="OPTIMA" style="max-width:160px; opacity:0.95;">
						<p style="margin-top:10px;">Damascus • +963912323455 • OPTIMA@Email.com</p>
					</div>
			</div>
		</div>
		@endsection
		
		@push('scripts')
		<script src="{{ asset('js/jquery.min.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		@endpush
