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
                            <li><a href="{{ route('laptops') }}">Laptops</a></li>
                            <li><a href="{{ route('smartphones') }}">Smartphones</a></li>
                            <li><a href="{{ route('cameras') }}">Cameras</a></li>
                            <li><a href="{{ route('accessories') }}">Accessories</a></li>
                        </ul>
                    </div>
                </div>

                <div class="clearfix visible-xs"></div>

                <div class="col-md-3 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">Information</h3>
                        <ul class="footer-links">
                            <li><a href="{{ route('about') }}">About Us</a></li>
                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                            <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('returns') }}">Orders and Returns</a></li>
                            <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3 col-xs-6">
                    <div class="footer">
                        <h3 class="footer-title">Customer Services</h3>
                        <ul class="footer-links">
                            <li><a href="{{ route('account') }}">My Account</a></li>
                            <li><a href="{{ route('cart') }}">View Cart</a></li>
                            <li><a href="{{ route('wishlist') }}">Wishlist</a></li>
                            <li><a href="{{ route('track-order') }}">Track My Order</a></li>
                            <li><a href="{{ route('help') }}">Help</a></li>
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
                        Copyright &copy; {{ now()->year }} OPTIMA Team . All rights reserved.
                    </span>
                </div>
            </div>
        </div>
    </div>
</footer>
