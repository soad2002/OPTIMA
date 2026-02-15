@extends('Const_Layouts.master')

@section('title', 'OPTIMA - Product Comparison')

@section('content')
    
    <!-- BREADCRUMB -->
    <div id="breadcrumb" class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb-tree">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li class="active">Compare Products</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- COMPARISON SECTION -->
    <div class="comparison-section">
        <div class="container">
            <div class="comparison-header">
                <h2>Product Comparison</h2>
                <p>Compare up to 4 products side by side</p>
            </div>
            
            <!-- Product Selector -->
            <div class="product-selector">
                <div class="row">
                    <div class="col-md-6">
                        <div class="search-dropdown">
                            <label>Search for Product 1</label>
                            <input type="text" 
                                   class="input" 
                                   id="search-product-1" 
                                   placeholder="Type product name..."
                                   onfocus="searchProducts(1)"
                                   oninput="searchProducts(1)">
                            <div class="search-results" id="results-1"></div>
                        </div>
                        <div id="selected-product-1" class="selected-product" style="margin-top: 15px;"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="search-dropdown">
                            <label>Search for Product 2</label>
                            <input type="text" 
                                   class="input" 
                                   id="search-product-2" 
                                   placeholder="Type product name..."
                                   onfocus="searchProducts(2)"
                                   oninput="searchProducts(2)">
                            <div class="search-results" id="results-2"></div>
                        </div>
                        <div id="selected-product-2" class="selected-product" style="margin-top: 15px;"></div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-6">
                        <div class="search-dropdown">
                            <label>Search for Product 3 (Optional)</label>
                            <input type="text" 
                                   class="input" 
                                   id="search-product-3" 
                                   placeholder="Type product name..."
                                   onfocus="searchProducts(3)"
                                   oninput="searchProducts(3)">
                            <div class="search-results" id="results-3"></div>
                        </div>
                        <div id="selected-product-3" class="selected-product" style="margin-top: 15px;"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="search-dropdown">
                            <label>Search for Product 4 (Optional)</label>
                            <input type="text" 
                                   class="input" 
                                   id="search-product-4" 
                                   placeholder="Type product name..."
                                   onfocus="searchProducts(4)"
                                   oninput="searchProducts(4)">
                            <div class="search-results" id="results-4"></div>
                        </div>
                        <div id="selected-product-4" class="selected-product" style="margin-top: 15px;"></div>
                    </div>
                </div>
                <div class="text-center" style="margin-top: 30px;">
                    <button class="btn-compare" onclick="compareProducts()">
                        <i class="fa fa-balance-scale"></i> Compare Products
                    </button>
                    <button class="btn-compare" onclick="clearComparison()" style="background: #95a5a6; margin-left: 10px;">
                        <i class="fa fa-refresh"></i> Clear All
                    </button>
                </div>
            </div>
            
            <!-- Loading Spinner -->
            <div class="loading-spinner" id="loading-spinner">
                <i class="fa fa-spinner fa-spin fa-3x"></i>
                <p>Loading comparison data...</p>
            </div>
            
            <!-- Comparison Table -->
            <div id="comparison-results" style="display: none;">
                <div class="comparison-container">
                    <table class="comparison-table">
                        <thead>
                            <tr>
                                <th class="spec-cell">Specification</th>
                                <th class="product-cell" id="product-header-1"></th>
                                <th class="product-cell" id="product-header-2"></th>
                                <th class="product-cell" id="product-header-3" style="display: none;"></th>
                                <th class="product-cell" id="product-header-4" style="display: none;"></th>
                            </tr>
                        </thead>
                        <tbody id="comparison-body">
                            <!-- Comparison data will be loaded here -->
                        </tbody>
                    </table>
                </div>
                
                <!-- Comparison Summary -->
                <div class="comparison-summary">
                    <h4>Comparison Summary</h4>
                    <div class="verdict-box">
                        <div class="recommendation" id="recommendation-text"></div>
                        <p id="summary-details"></p>
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-6">
                                <h6>Key Differences:</h6>
                                <ul id="key-differences"></ul>
                            </div>
                            <div class="col-md-6">
                                <h6>Best For:</h6>
                                <ul id="best-for"></ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Empty State -->
            <div id="empty-state" class="empty-state">
                <i class="fa fa-balance-scale"></i>
                <h3>No Products Selected</h3>
                <p>Select at least 2 products to start comparing</p>
                <p>Try searching for products in the search boxes above</p>
            </div>
        </div>
    </div>
    @endsection
    
    @push('scripts')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <script src="{{ asset('js/compare.js') }}"></script>
    @endpush