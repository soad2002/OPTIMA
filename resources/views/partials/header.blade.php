<!-- HEADER -->
<header>
    <div id="header">
        <div class="container">
            <div class="row">
                <!-- LOGO -->
                <div class="col-md-3">
                    <div class="header-logo">
                        <a href="{{ route('home') }}" class="logo">
                            <img src="{{ asset('img/shop01.png') }}" alt="OPTIMA" style="max-height: 70px ; max-width :70px">
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
                            <a href="{{ route('wishlist') }}" id="wishlist-link">
                                <i class="fa fa-heart-o"></i>
                                <span>My Wishlist</span>
                                <div class="qty" id="wishlist-count">0</div>
                            </a>
                        </div>
                        <!-- Account / Auth -->
                        <div>
                            @guest
                                <a href="{{ route('login') }}" id="login-link">
                                    <i class="fa fa-sign-in"></i>
                                    <span>Sign In</span>
                                </a>
                            @else
                                <a href="{{ route('account') }}" class="account-link">
                                    <i class="fa fa-user-o"></i>
                                    <span>{{ Auth::user()->name ?? 'My Account' }}</span>
                                    @if(Auth::user() && strtolower(Auth::user()->email) === 'tester@example.com')
                                        <span class="user-badge">Local Tester</span>
                                    @endif
                                </a>
                                @if(auth()->check() && auth()->user()->isAdmin())
                                    <a href="{{ route('admin.dashboard') }}" class="admin-link" title="Admin Dashboard" style="margin-left:8px;">
                                        <i class="fa fa-shield"></i>
                                        <span>Admin</span>
                                        <span class="admin-badge">ADMIN</span>
                                    </a>
                                @endif
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:inline-block; margin-left:8px;">
                                    @csrf
                                    <button type="submit" class="btn-link" style="border:none;background:none;padding:0;color:inherit;cursor:pointer;">Logout</button>
                                </form>
                            @endguest
                        </div>
                        <!-- Cart -->
                        <div class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true" href="{{ route('cart') }}">
                                <i class="fa fa-shopping-cart"></i>
                                <span>My Cart</span>
                                <div class="qty" id="cart-count">0</div>
                            </a>
                            <div class="cart-dropdown">
                                <div class="cart-list" id="cart-dropdown-items">
                                    <!-- محتويات السلة تظهر هنا -->
                                    <div class="empty-cart-message" style="padding: 20px; text-align: center;">
                                        Your cart is empty
                                    </div>
                                </div>
                                <div class="cart-summary">
                                    <small id="cart-summary-count">0 Item(s)</small>
                                    <h5 id="cart-summary-total">SUBTOTAL: $0.00</h5>
                                </div>
                                <div class="cart-btns">
                                    <a href="{{ route('cart') }}">View Cart</a>
                                    <a href="{{ route('checkout') }}">Checkout  <i class="fa fa-arrow-circle-right"></i></a>
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
                <li class="active"><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('hot-deals') }}">Hot Deals</a></li>
                <li><a href="{{ route('laptops') }}">Laptops</a></li>
                <li><a href="{{ route('smartphones') }}">Smartphones</a></li>
                <li><a href="{{ route('cameras') }}">Cameras</a></li>
                <li><a href="{{ route('accessories') }}">Accessories</a></li>
            </ul>
        </div>
    </div>
</nav>
