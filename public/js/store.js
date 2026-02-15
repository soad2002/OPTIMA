// API Configuration
const API_BASE_URL = '/api'; 
let currentProducts = [];
let currentView = 'grid';
let currentFilters = {
    categories: [],
    brands: [],
    // store DB prices (internal). UI displays values divided by 50.
    minPrice: 100 * 50,
    maxPrice: 7000 * 50,
    sortBy: 'popular',
    searchQuery: '',
    page: 1,
    limit: 12
};
let totalProducts = 0;
let totalPages = 1;

// Display products in grid view
function displayProductsGridView() {
    const container = document.getElementById('products-container');
    const productsHTML = currentProducts.map(product => {
        const displayPrice = (parseFloat(product.price) || 0) / 50;
        return `
        <div class="col-md-4 col-xs-6">
            <div class="product">
                <div class="product-img">
                    <img src="${product.image_url || './img/product01.png'}" alt="${product.name}">
                    <div class="product-label">
                        ${product.is_new ? '<span class="new">NEW</span>' : ''}
                    </div>
                </div>
                <div class="product-body">
                    <p class="product-category">${product.category || 'Laptop'}</p>
                    <h3 class="product-name"><a href="/product/${product.id}">${product.name}</a></h3>
                    <h4 class="product-price">
                        $${displayPrice.toFixed(2)}
                    </h4>
                    <div class="product-rating">
                        ${getStarRating(product.rating || 0)}
                        <span class="reviews-qty">(${product.reviews_count || 0})</span>
                    </div>
                    <div class="product-btns">
                        <button class="add-to-wishlist"><i class="fa fa-heart-o"></i><span class="tooltipp">add to wishlist</span></button>
                        <button class="quick-view" onclick="window.location.href='/product/${product.id}'"><i class="fa fa-eye"></i><span class="tooltipp">quick view</span></button>
                    </div>
                </div>
                <div class="add-to-cart">
                    <button class="add-to-cart-btn" onclick="addToCart('${product.id}', '${product.name}', '${product.price}', '${product.image_url}')">
                        <i class="fa fa-shopping-cart"></i> add to cart
                    </button>
                </div>
            </div>
        </div>
    `}).join('');
    
    container.innerHTML = productsHTML;
}

function displayProductsListView() {
    const container = document.getElementById('products-container');
    const productsHTML = currentProducts.map(product => {
        const displayPrice = (parseFloat(product.price) || 0) / 50;
        return `
        <div class="col-md-12 col-xs-12">
            <div class="product product-list">
                <div class="product-img" style="width:150px;float:left;margin-right:15px;">
                    <img src="${product.image_url || './img/product01.png'}" alt="${product.name}" style="max-width:150px;">
                </div>
                <div class="product-body" style="overflow:hidden;">
                    <p class="product-category">${product.category || 'Laptop'}</p>
                    <h3 class="product-name"><a href="/product/${product.id}">${product.name}</a></h3>
                    <h4 class="product-price">$${displayPrice.toFixed(2)}</h4>
                    <div class="product-rating">
                        ${getStarRating(product.rating || 0)}
                        <span class="reviews-qty">(${product.reviews_count || 0})</span>
                    </div>
                    <p class="product-description">${product.description || ''}</p>
                    <div style="margin-top:10px;">
                        <button class="add-to-wishlist"><i class="fa fa-heart-o"></i> wishlist</button>
                        <button class="quick-view" onclick="window.location.href='/product/${product.id}'"><i class="fa fa-eye"></i> view</button>
                        <button class="add-to-cart-btn" onclick="addToCart('${product.id}', '${product.name}', '${product.price}', '${product.image_url}')"><i class="fa fa-shopping-cart"></i> add to cart</button>
                    </div>
                </div>
            </div>
        </div>
    `}).join('');
    container.innerHTML = productsHTML;
}

function setView(view) {
    currentView = view === 'list' ? 'list' : 'grid';
    // update active buttons
    const buttons = document.querySelectorAll('.store-grid li');
    buttons.forEach(btn => {
        if (btn.getAttribute('data-view') === currentView) btn.classList.add('active');
        else btn.classList.remove('active');
    });
    // re-render products in the selected view
    if (currentProducts && currentProducts.length > 0) {
        if (currentView === 'grid') displayProductsGridView();
        else displayProductsListView();
    }
}

// Fetch products from backend
async function loadProducts() {
    showLoading(true);
    try {
        let params = new URLSearchParams({
            page: currentFilters.page,
            limit: currentFilters.limit,
            sort: currentFilters.sortBy,
            minPrice: currentFilters.minPrice,
            maxPrice: currentFilters.maxPrice
        });

        if (currentFilters.categories.length > 0) params.append('categories', currentFilters.categories.join(','));
        if (currentFilters.brands.length > 0) params.append('brands', currentFilters.brands.join(','));
        if (currentFilters.searchQuery) params.append('search', currentFilters.searchQuery);

        const response = await fetch(`${API_BASE_URL}/products?${params.toString()}`);
        const data = await response.json();

        currentProducts = data.products;
        totalProducts = data.total;
        totalPages = data.pages;

        if (currentProducts.length === 0) {
            showNoProducts(true);
            document.getElementById('products-container').innerHTML = '';
        } else {
            showNoProducts(false);
            if (currentView === 'grid') displayProductsGridView();
            else displayProductsListView();
            updateProductsCount();
            updatePagination();
        }
    } catch (error) {
        console.error('Error loading products:', error);
        showAlert('error', 'Error loading products');
    } finally {
        showLoading(false);
    }
}

// Refresh cart UI from server for authenticated users
async function refreshCart() {
    try {
        const res = await fetch('/cart', { headers: { 'Accept': 'application/json' }, credentials: 'same-origin' });
        if (!res.ok) return;
        const data = await res.json();
        const items = data.items || [];
        const totalItems = items.reduce((s, it) => s + (it.quantity || 0), 0);
        const cartCountEl = document.getElementById('cart-count');
        if (cartCountEl) cartCountEl.textContent = totalItems;

        const miniCart = document.getElementById('cart-dropdown-items');
        if (miniCart) {
            if (items.length === 0) {
                miniCart.innerHTML = `<div class="empty-cart-message" style="padding: 20px; text-align: center;">Your cart is empty</div>`;
            } else {
                const first = items[0];
                miniCart.innerHTML = `
                    <div class="product-widget">
                        <div class="product-img"><img src="${first.image || './img/product01.png'}"></div>
                        <div class="product-body">
                            <h3 class="product-name"><a href="#">${first.name}</a></h3>
                            <h4 class="product-price"><span class="qty">${first.quantity}x</span>$${(first.price/50).toFixed(2)}</h4>
                        </div>
                    </div>
                `;
            }
        }
    } catch (e) {
        // ignore
    }
}

// Load filters dynamically
async function loadFilters() {
    try {
        const response = await fetch(`${API_BASE_URL}/filters`);
        const data = await response.json();
        
        // Display categories
        const catContainer = document.getElementById('categories-filter');
        if (catContainer) {
            catContainer.innerHTML = data.categories.map(cat => `
                <div class="input-checkbox">
                    <input type="checkbox" id="cat-${cat.name}" onchange="updateCategoryFilter('${cat.name}', this.checked)">
                    <label for="cat-${cat.name}"><span></span>${cat.name} <small>(${cat.count})</small></label>
                </div>
            `).join('');
        }

        // Display brands
        const brandContainer = document.getElementById('brands-filter');
        if (brandContainer) {
            brandContainer.innerHTML = data.brands.map(brand => `
                <div class="input-checkbox">
                    <input type="checkbox" id="brand-${brand.name}" onchange="updateBrandFilter('${brand.name}', this.checked)">
                    <label for="brand-${brand.name}"><span></span>${brand.name} <small>(${brand.count})</small></label>
                </div>
            `).join('');
        }

    } catch (error) {
        console.error('Filters Error:', error);
    }
}

// Helper functions
function getStarRating(rating) {
    let stars = '';
    for (let i = 1; i <= 5; i++) {
        stars += `<i class="fa fa-star${i <= rating ? '' : '-o'}"></i>`;
    }
    return stars;
}

function showLoading(show) {
    const loader = document.getElementById('loading-products');
    if (loader) {
        loader.style.display = show ? 'block' : 'none';
    }
}

function showNoProducts(show) {
    const noProducts = document.getElementById('no-products-found');
    if (noProducts) {
        noProducts.style.display = show ? 'block' : 'none';
    }
}

function showAlert(type, message) {
    // Try to show alert in a notification area if it exists
    const alertElement = document.getElementById(`${type}-alert`);
    if (alertElement) {
        alertElement.textContent = message;
        alertElement.style.display = 'block';
        setTimeout(() => {
            alertElement.style.display = 'none';
        }, 3000);
    }
    // Always log to console
    console.log(`[${type.toUpperCase()}] ${message}`);
}

function updateProductsCount() {
    const count = document.getElementById('products-count');
    if (count) {
        const showing = currentProducts.length;
        if (currentFilters.searchQuery) {
            count.textContent = `Showing ${showing} result(s) for "${currentFilters.searchQuery}"`;
        } else {
            count.textContent = `Showing ${showing} products`;
        }
    }
}

function updatePagination() {
    const pagination = document.getElementById('products-pagination');
    if (!pagination) return;

    // Hide pagination when everything fits on one page
    if (totalPages <= 1) {
        pagination.innerHTML = '';
        pagination.style.display = 'none';
        return;
    }

    pagination.style.display = '';
    const current = currentFilters.page || 1;
    const total = totalPages;

    // Build a compact page list: always show first and last, current +/- 2, with ellipses
    const pages = [];
    pages.push(1);
    const start = Math.max(2, current - 2);
    const end = Math.min(total - 1, current + 2);
    if (start > 2) pages.push('...');
    for (let p = start; p <= end; p++) pages.push(p);
    if (end < total - 1) pages.push('...');
    if (total > 1) pages.push(total);

    const items = [];
    // Prev
    const prevPage = Math.max(1, current - 1);
    items.push(`<li class="${current === 1 ? 'disabled' : ''}"><a href="#" data-page="${prevPage}">‹</a></li>`);

    pages.forEach(item => {
        if (item === '...') {
            items.push('<li class="ellipsis"><span>…</span></li>');
        } else {
            items.push(`<li class="${item === current ? 'active' : ''}"><a href="#" data-page="${item}">${item}</a></li>`);
        }
    });

    // Next
    const nextPage = Math.min(total, current + 1);
    items.push(`<li class="${current === total ? 'disabled' : ''}"><a href="#" data-page="${nextPage}">›</a></li>`);

    pagination.innerHTML = items.join('');

    // Attach click handlers
    pagination.querySelectorAll('a[data-page]').forEach(a => {
        a.addEventListener('click', function (e) {
            e.preventDefault();
            const p = parseInt(this.getAttribute('data-page')) || 1;
            if (p === current) return;
            currentFilters.page = p;
            loadProducts();
        });
    });
}

// Category filter update
function updateCategoryFilter(category, checked) {
    if (checked) {
        if (!currentFilters.categories.includes(category)) {
            currentFilters.categories.push(category);
        }
    } else {
        currentFilters.categories = currentFilters.categories.filter(c => c !== category);
    }
    currentFilters.page = 1;
    loadProducts();
}

// Brand filter update
function updateBrandFilter(brand, checked) {
    if (checked) {
        if (!currentFilters.brands.includes(brand)) {
            currentFilters.brands.push(brand);
        }
    } else {
        currentFilters.brands = currentFilters.brands.filter(b => b !== brand);
    }
    currentFilters.page = 1;
    loadProducts();
}

// Add to cart
function addToCart(productId, productName, productPrice, productImage) {
    // If user is authenticated, persist cart server-side
    if (window.App && window.App.user) {
        fetch('/cart/add', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': window.App.csrfToken
            },
            body: JSON.stringify({ productId: parseInt(productId), quantity: 1 })
        }).then(res => {
            if (!res.ok) throw res;
            return res.json();
        }).then(json => {
            showAlert('success', `${productName} added to cart!`);
            // Optionally refresh cart count via API
            updateCartCount();
        }).catch(async (err) => {
            try {
                const data = await err.json();
                showAlert('error', data.error || 'Error adding to cart');
            } catch (e) {
                showAlert('error', 'Error adding to cart');
            }
        });
        return;
    }

    // Fallback: localStorage cart for guests
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const existingItem = cart.find(item => item.id === productId);
    
    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: productId,
            name: productName,
            price: parseFloat(productPrice),
            image: productImage || './img/product01.png',
            quantity: 1
        });
    }
    
    localStorage.setItem('cart', JSON.stringify(cart));
    showAlert('success', `${productName} added to cart!`);
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Read search/category from URL to prefill filters
    const urlParams = new URLSearchParams(window.location.search);
    const urlSearch = urlParams.get('search');
    const urlCategory = urlParams.get('category');
    if (urlSearch) {
        currentFilters.searchQuery = urlSearch;
        const searchInput = document.getElementById('searchInput');
        if (searchInput) searchInput.value = urlSearch;
        // When searching, show all matching results on one page
        currentFilters.limit = 10000;
    }
    if (urlCategory) {
        // store categories as array to match API param handling
        currentFilters.categories = [urlCategory];
        const categorySelect = document.getElementById('categorySelect');
        if (categorySelect) categorySelect.value = urlCategory;
    }

    // Determine initial view based on the active button (grid/list)
    const viewButtonsInit = document.querySelectorAll('.store-grid li');
    viewButtonsInit.forEach(btn => {
        if (btn.classList.contains('active')) {
            currentView = btn.getAttribute('data-view') || 'grid';
        }
    });

    loadFilters();
    loadProducts();
    // refresh cart UI if logged in
    if (window.App && window.App.user) refreshCart();
    // If logged in and have a localStorage cart, merge it into server-side cart
    try {
        if (window.App && window.App.user && localStorage.getItem('cart')) {
            const localCart = JSON.parse(localStorage.getItem('cart') || '[]');
            if (Array.isArray(localCart) && localCart.length > 0) {
                const payload = { items: localCart.map(i => ({ productId: parseInt(i.id), quantity: parseInt(i.quantity || 1) })) };
                fetch('/cart/merge', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': window.App.csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                }).then(res => {
                    if (res.ok) {
                        localStorage.removeItem('cart');
                        refreshCart();
                    }
                }).catch(() => {});
            }
        }
    } catch (e) {}
    
    const priceBtn = document.getElementById('apply-price-filter');
    if (priceBtn) {
        priceBtn.addEventListener('click', () => {
            const minVal = parseFloat(document.getElementById('price-min').value) || 0; // displayed value (DB/50)
            const maxVal = parseFloat(document.getElementById('price-max').value) || 0; // displayed value (DB/50)
            // Convert displayed values back to DB units before filtering (DB = displayed * 50)
            currentFilters.minPrice = Math.round(minVal * 50);
            currentFilters.maxPrice = Math.round(maxVal * 50);
            currentFilters.page = 1;
            loadProducts();
        });
    }

    const sortBtn = document.getElementById('sort-by');
    if (sortBtn) {
        sortBtn.addEventListener('change', (e) => {
            currentFilters.sortBy = e.target.value;
            loadProducts();
        });
    }

    // Header search form may submit and redirect to /store; also allow search on this page
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            currentFilters.searchQuery = document.getElementById('searchInput').value || '';
            currentFilters.page = 1;
            loadProducts();
        });
    }

    // Initialize displayed price inputs and slider from currentFilters
    const priceMinInput = document.getElementById('price-min');
    const priceMaxInput = document.getElementById('price-max');
    // Show UI inputs in display units (DB / 50)
    if (priceMinInput) priceMinInput.value = (currentFilters.minPrice / 50).toFixed(2);
    if (priceMaxInput) priceMaxInput.value = (currentFilters.maxPrice / 50).toFixed(2);

    const priceSliderEl = document.getElementById('price-slider');
    if (priceSliderEl && priceSliderEl.noUiSlider) {
        // Slider and inputs operate in displayed units (DB/50)
        const min = (currentFilters.minPrice / 50) || 100;
        const max = (currentFilters.maxPrice / 50) || 7000;
        try {
            // update slider range to match backend price range (converted to display units), then set values
            if (typeof priceSliderEl.noUiSlider.updateOptions === 'function') {
                priceSliderEl.noUiSlider.updateOptions({
                    range: { min: Math.floor(min), max: Math.ceil(max) }
                });
            }
            priceSliderEl.noUiSlider.set([min, max]);
        } catch (e) {
            // ignore if slider not ready or values invalid
        }
    }

    // Attach handlers to toggle grid/list view
    const viewButtons = document.querySelectorAll('.store-grid li');
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const v = this.getAttribute('data-view');
            setView(v);
        });
    });
});