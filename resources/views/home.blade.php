@extends('Const_Layouts.master')

@section('title', 'OPTIMA - Home Page')

@section('content')

<!-- SECTION: Shop Categories -->
<div class="section">
    <div class="container">
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-4 col-xs-6">
                <div class="shop">
                    <div class="shop-img">
                        <img src="{{ asset('img/'.$category->image) }}" alt="{{ $category->name }}">
                    </div>
                    <div class="shop-body">
                        <h3>{{ $category->name }}<br>Collection</h3>
                        <a href="{{ route('products.category', ['category' => $category->slug]) }}" class="cta-btn">
                            Shop now <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<!-- SECTION: New Products -->
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title">
                    <h3 class="title">New Products</h3>
                    <div class="section-nav">
                        <ul class="section-tab-nav tab-nav">
                            <li class="active"><a href="#tab-new" onclick="loadNewProducts('all')">All</a></li>
                            @foreach($categories as $category)
                                <li><a href="#tab-new" onclick="loadNewProducts('{{ $category->slug }}')">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-12">
                <div class="row">
                    <div class="products-tabs">
                        <div id="tab-new" class="tab-pane active">
                            <div class="products-slick" data-nav="#slick-nav-1" id="new-products-container">
                                @foreach($newProducts as $product)
                                <div class="product">
                                    <div class="product-img">
                                        <img src="{{ asset('img/'.$product->image) }}" alt="{{ $product->name }}">
                                    </div>
                                    <div class="product-body">
                                        <h3 class="product-name">{{ $product->name }}</h3>
                                        <h4 class="product-price">${{ number_format($product->price / 50, 2) }}</h4>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div id="slick-nav-1" class="products-slick-nav"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- HOT DEAL SECTION -->
<div id="hot-deal" class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="hot-deal">
                    <ul class="hot-deal-countdown" id="deal-countdown">
                        <li><div><h3 id="days">02</h3><span>Days</span></div></li>
                        <li><div><h3 id="hours">10</h3><span>Hours</span></div></li>
                        <li><div><h3 id="minutes">34</h3><span>Mins</span></div></li>
                        <li><div><h3 id="seconds">60</h3><span>Secs</span></div></li>
                    </ul>
                    <h2 class="text-uppercase">Hot deal this week</h2>
                    <p>New Collection Up to 50% OFF</p>
                    <a class="primary-btn cta-btn" href="{{ route('hot-deals') }}">Shop now</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
