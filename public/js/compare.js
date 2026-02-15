
const API_BASE_URL = '';
const MAX_COMPARE_PRODUCTS = 4;
let selectedProducts = [];
let searchTimeout;

const searchInputs = {
    1: document.getElementById('search-product-1'),
    2: document.getElementById('search-product-2'),
    3: document.getElementById('search-product-3'),
    4: document.getElementById('search-product-4')
};

document.addEventListener('DOMContentLoaded', function() {
    loadCart();
    loadWishlist();
    
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-dropdown')) {
            hideAllSearchResults();
        }
    });
});

async function searchProducts(productNumber) {
    const searchTerm = searchInputs[productNumber].value.trim();
    
    if (searchTerm.length < 2) {
        hideSearchResults(productNumber);
        return;
    }
    
    clearTimeout(searchTimeout);
    
    searchTimeout = setTimeout(async () => {
        try {
            const response = await fetch(`${API_BASE_URL}/products/search?q=${encodeURIComponent(searchTerm)}&limit=5`);
            const data = await response.json();
            
            displaySearchResults(productNumber, data.products || []);
        } catch (error) {
            console.error('Search error:', error);
            displaySearchResults(productNumber, getSampleProducts(searchTerm));
        }
    }, 300);
}

function displaySearchResults(productNumber, products) {
    const resultsContainer = document.getElementById(`results-${productNumber}`);
    
    if (products.length === 0) {
        resultsContainer.innerHTML = '<div class="search-result-item">No products found</div>';
        resultsContainer.style.display = 'block';
        return;
    }
    
    const resultsHTML = products.map(product => `
        <div class="search-result-item" onclick="selectProduct(${productNumber}, '${product.id}')">
            <img src="${product.image || 'img/product01.png'}" alt="${product.name}" class="search-result-img">
            <div>
                <div style="font-weight: 500;">${product.name}</div>
                <div style="font-size: 12px; color: #D10024;">$${(parseFloat(product.price)/50).toFixed(2)}</div>
            </div>
        </div>
    `).join('');
    
    resultsContainer.innerHTML = resultsHTML;
    resultsContainer.style.display = 'block';
}

function hideSearchResults(productNumber) {
    document.getElementById(`results-${productNumber}`).style.display = 'none';
}

function hideAllSearchResults() {
    for (let i = 1; i <= MAX_COMPARE_PRODUCTS; i++) {
        hideSearchResults(i);
    }
}

async function selectProduct(productNumber, productId) {
    if (selectedProducts.some(p => p.id === productId)) {
        alert('This product is already selected');
        return;
    }
    
    searchInputs[productNumber].value = '';
    hideSearchResults(productNumber);
    
    const selectedContainer = document.getElementById(`selected-product-${productNumber}`);
    selectedContainer.innerHTML = '<div>Loading product...</div>';
    
    try {
        const response = await fetch(`${API_BASE_URL}/products/${productId}`);
        const data = await response.json();
        
        const product = data.product || data;
        
        selectedProducts[productNumber - 1] = {
            id: product.id,
            name: product.name,
            price: product.price,
            image: product.image,
            category: product.category,
            specs: product.specifications || getDefaultSpecs(product.category)
        };
        
        displaySelectedProduct(productNumber, product);
        
    } catch (error) {
        console.error('Error loading product:', error);
        const sampleProduct = getSampleProductById(productId);
        selectedProducts[productNumber - 1] = sampleProduct;
        displaySelectedProduct(productNumber, sampleProduct);
    }
}

function displaySelectedProduct(productNumber, product) {
    const container = document.getElementById(`selected-product-${productNumber}`);
    
    container.innerHTML = `
        <div style="display: flex; align-items: center; background: #f5f5f5; padding: 10px; border-radius: 5px;">
            <img src="${product.image || 'img/product01.png'}" 
                    alt="${product.name}" 
                    style="width: 50px; height: 50px; object-fit: contain; margin-right: 15px;">
            <div style="flex: 1;">
                <div style="font-weight: 500; margin-bottom: 5px;">${product.name}</div>
                <div style="color: #D10024; font-weight: 600;">$${(parseFloat(product.price)/50).toFixed(2)}</div>
            </div>
            <button class="btn-remove" onclick="removeProduct(${productNumber})">
                <i class="fa fa-times"></i> Remove
            </button>
        </div>
    `;
}

function removeProduct(productNumber) {
    selectedProducts[productNumber - 1] = null;
    document.getElementById(`selected-product-${productNumber}`).innerHTML = '';
}

async function compareProducts() {
    const productsToCompare = selectedProducts.filter(p => p !== null);
    
    if (productsToCompare.length < 2) {
        alert('Please select at least 2 products to compare');
        return;
    }
    
    document.getElementById('loading-spinner').style.display = 'block';
    document.getElementById('comparison-results').style.display = 'none';
    document.getElementById('empty-state').style.display = 'none';
    
    setTimeout(() => {
        displayComparison(productsToCompare);
        document.getElementById('loading-spinner').style.display = 'none';
        document.getElementById('comparison-results').style.display = 'block';
    }, 500);
}

function displayComparison(products) {
    for (let i = 0; i < MAX_COMPARE_PRODUCTS; i++) {
        const header = document.getElementById(`product-header-${i + 1}`);
        if (products[i]) {
            header.textContent = products[i].name;
            header.style.display = 'table-cell';
        } else {
            header.style.display = 'none';
        }
    }
    
    const comparisonBody = document.getElementById('comparison-body');
    const allSpecs = getAllSpecifications(products);
    
    const rowsHTML = allSpecs.map(spec => {
        const values = products.map(product => {
            const value = product.specs[spec.key];
            return value !== undefined ? value : 'N/A';
        });
        
        const comparisons = compareSpecValues(spec.key, values, spec.betterWhen);
        
        return `
            <tr>
                <td class="spec-cell">
                    <span class="feature-icon">${spec.icon || '✓'}</span>
                    ${spec.label}
                </td>
                ${values.map((value, index) => `
                    <td class="product-cell">
                        <span class="spec-value ${comparisons[index]}">${formatSpecValue(spec.key, value)}</span>
                    </td>
                `).join('')}
            </tr>
        `;
    }).join('');
    
    comparisonBody.innerHTML = rowsHTML;
    
    const actionsRow = `
        <tr>
            <td class="spec-cell">
                <span class="feature-icon">🛒</span>
                Actions
            </td>
            ${products.map(product => `
                <td class="product-cell">
                    <button class="btn-compare" onclick="addToCart('${product.id}')" style="padding: 8px 15px; margin: 5px;">
                        <i class="fa fa-shopping-cart"></i> Add to Cart
                    </button>
                    <button class="btn-compare" onclick="addToWishlist('${product.id}')" 
                            style="padding: 8px 15px; margin: 5px; background: #3498db;">
                        <i class="fa fa-heart"></i> Wishlist
                    </button>
                    <a href="product-details.html?id=${product.id}" 
                        class="btn-compare" 
                        style="padding: 8px 15px; margin: 5px; background: #27ae60; display: inline-block; text-decoration: none;">
                        <i class="fa fa-info-circle"></i> Details
                    </a>
                </td>
            `).join('')}
        </tr>
    `;
    
    comparisonBody.innerHTML += actionsRow;
    
    generateComparisonSummary(products);
}

function compareSpecValues(specKey, values, betterWhen) {
    const comparisons = new Array(values.length).fill('equal');
    
    if (values.includes('N/A')) return comparisons;
    
    if (betterWhen === 'higher') {
        const maxValue = Math.max(...values.map(v => parseFloat(v) || 0));
        values.forEach((value, index) => {
            const numValue = parseFloat(value) || 0;
            if (numValue === maxValue) {
                comparisons[index] = 'better';
            } else {
                comparisons[index] = 'worse';
            }
        });
    } else if (betterWhen === 'lower') {
        const minValue = Math.min(...values.map(v => parseFloat(v) || 0));
        values.forEach((value, index) => {
            const numValue = parseFloat(value) || 0;
            if (numValue === minValue) {
                comparisons[index] = 'better';
            } else {
                comparisons[index] = 'worse';
            }
        });
    }
    
    return comparisons;
}

function formatSpecValue(key, value) {
    if (value === 'N/A') return value;
    
        if (key.includes('price') || key.includes('Price')) {
            return `$${(parseFloat(value)/50).toFixed(2)}`;
    } else if (key.includes('weight') || key.includes('Weight')) {
        return `${value} kg`;
    } else if (key.includes('battery') || key.includes('Battery')) {
        return `${value} mAh`;
    } else if (key.includes('memory') || key.includes('ram') || key.includes('storage')) {
        return `${value} GB`;
    } else if (key.includes('screen') || key.includes('display')) {
        return `${value}"`;
    }
    
    return value;
}

function getAllSpecifications(products) {
    const allSpecs = new Map();
    
    products.forEach(product => {
        if (product.specs) {
            Object.entries(product.specs).forEach(([key, value]) => {
                if (!allSpecs.has(key)) {
                    allSpecs.set(key, {
                        key: key,
                        label: formatSpecLabel(key),
                        icon: getSpecIcon(key),
                        betterWhen: getBetterWhen(key)
                    });
                }
            });
        }
    });
    
    return Array.from(allSpecs.values()).sort((a, b) => {
        const order = ['price', 'category', 'brand', 'model', 'processor', 'ram', 'storage', 
                        'screenSize', 'battery', 'weight', 'os', 'camera'];
        return (order.indexOf(a.key) - order.indexOf(b.key)) || a.label.localeCompare(b.label);
    });
}

function formatSpecLabel(key) {
    return key.replace(/([A-Z])/g, ' $1')
                .replace(/^./, str => str.toUpperCase())
                .replace(/\b(Ram|Cpu|Gpu|Hdd|Ssd|Os)\b/gi, match => match.toUpperCase());
}

function getBetterWhen(key) {
    if (key.includes('price') || key.includes('cost') || key.includes('weight')) {
        return 'lower';
    }
    return 'higher'; 
}

function generateComparisonSummary(products) {
    if (products.length < 2) return;
    
    let bestValueIndex = 0;
    let bestValueScore = calculateValueScore(products[0]);
    
    for (let i = 1; i < products.length; i++) {
        const score = calculateValueScore(products[i]);
        if (score > bestValueScore) {
            bestValueScore = score;
            bestValueIndex = i;
        }
    }
    
    const bestProduct = products[bestValueIndex];
    document.getElementById('recommendation-text').textContent = 
        `Best Value: ${bestProduct.name}`;
    
    const priceRange = getPriceRange(products);
    document.getElementById('summary-details').innerHTML = `
        Comparing ${products.length} products in ${products[0].category} category. 
        Price range: ${priceRange.min} - ${priceRange.max}. 
        ${bestProduct.name} offers the best value for money.
    `;
    
    const keyDiffs = findKeyDifferences(products);
    const diffsHTML = keyDiffs.map(diff => `<li>${diff}</li>`).join('');
    document.getElementById('key-differences').innerHTML = diffsHTML;
    
    const bestFor = determineBestFor(products);
    const bestForHTML = bestFor.map(item => `<li>${item}</li>`).join('');
    document.getElementById('best-for').innerHTML = bestForHTML;
}

function calculateValueScore(product) {
    let score = 0;
    
    if (product.price) {
        const priceVal = (parseFloat(product.price) || 0) / 50;
        if (priceVal > 0) score += 1000 / priceVal;
    }
    
    if (product.specs) {
        if (product.specs.ram) score += parseInt(product.specs.ram) * 10;
        if (product.specs.storage) score += parseInt(product.specs.storage) * 5;
        if (product.specs.battery) score += parseInt(product.specs.battery) / 100;
    }
    
    return score;
}

function getPriceRange(products) {
    const prices = products.map(p => p.price).filter(p => p);
    const conv = prices.map(p => (parseFloat(p)||0)/50);
    return {
        min: `$${Math.min(...conv).toFixed(2)}`,
        max: `$${Math.max(...conv).toFixed(2)}`
    };
}

function findKeyDifferences(products) {
    const differences = [];
    const specs = getAllSpecifications(products);
    
    specs.forEach(spec => {
        const values = products.map(p => p.specs[spec.key] || 'N/A');
        const uniqueValues = [...new Set(values)];
        
        if (uniqueValues.length > 1 && uniqueValues.length === products.length) {
            differences.push(`${spec.label}: ${values.map(v => formatSpecValue(spec.key, v)).join(' vs ')}`);
        }
    });
    
    return differences.slice(0, 5); // ارجاع 5 اختلافات
}

function determineBestFor(products) {
    const recommendations = [];
    
    products.forEach((product, index) => {
        if (product.specs) {
            if (product.specs.price && product.specs.price < 500) {
                recommendations.push(`${product.name}: Budget choice`);
            }
            if (product.specs.ram && parseInt(product.specs.ram) >= 16) {
                recommendations.push(`${product.name}: Heavy multitasking`);
            }
            if (product.specs.battery && parseInt(product.specs.battery) >= 5000) {
                recommendations.push(`${product.name}: Long battery life`);
            }
            if (product.specs.storage && parseInt(product.specs.storage) >= 512) {
                recommendations.push(`${product.name}: Large storage needs`);
            }
        }
    });
    
    return [...new Set(recommendations)].slice(0, 4);
}

function clearComparison() {
    selectedProducts = [];
    
    for (let i = 1; i <= MAX_COMPARE_PRODUCTS; i++) {
        document.getElementById(`selected-product-${i}`).innerHTML = '';
        searchInputs[i].value = '';
    }
    
    document.getElementById('comparison-results').style.display = 'none';
    document.getElementById('empty-state').style.display = 'block';
}

async function addToCart(productId) {
    try {
        const response = await fetch(`${API_BASE_URL}/cart/add/${productId}`, {
            method: 'POST'
        });
        
        if (response.ok) {
            alert('Product added to cart!');
            loadCart();
        }
    } catch (error) {
        console.error('Error adding to cart:', error);
        alert('Failed to add product to cart');
    }
}

async function addToWishlist(productId) {
    try {
        const response = await fetch(`${API_BASE_URL}/wishlist`, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': (window.App && window.App.csrfToken) ? window.App.csrfToken : ''
            },
            body: JSON.stringify({ productId })
        });

        if (response.ok) {
            alert('Product added to wishlist!');
            await loadWishlist();
        }
    } catch (error) {
        console.error('Error adding to wishlist:', error);
        alert('Failed to add product to wishlist');
    }
}

async function loadCart() {
    document.getElementById('cart-count').textContent = '0';
}

async function loadWishlist() {
    try {
        const response = await fetch(`${API_BASE_URL}/wishlist`, { credentials: 'same-origin' });
        if (response.ok) {
            const data = await response.json();
            document.getElementById('wishlist-count').textContent = (data && data.length) ? data.length : '0';
            return;
        }
    } catch (error) {
        console.error('Error loading wishlist:', error);
    }
    document.getElementById('wishlist-count').textContent = '0';
}

function getSampleProducts(searchTerm) {
    return [
        {
            id: '1',
            name: 'MacBook Pro 14"',
            price: 1299.99,
            image: 'img/product01.png',
            category: 'laptops'
        },
        {
            id: '2',
            name: 'iPhone 15 Pro',
            price: 999.99,
            image: 'img/product02.png',
            category: 'smartphones'
        },
        {
            id: '3',
            name: 'Sony Alpha 7 III',
            price: 1999.99,
            image: 'img/product03.png',
            category: 'cameras'
        },
        {
            id: '4',
            name: 'Samsung Galaxy S24',
            price: 899.99,
            image: 'img/product04.png',
            category: 'smartphones'
        },
        {
            id: '5',
            name: 'Dell XPS 13',
            price: 1099.99,
            image: 'img/product05.png',
            category: 'laptops'
        }
    ].filter(p => p.name.toLowerCase().includes(searchTerm.toLowerCase()));
}

function getSampleProductById(productId) {
    const products = {
        '1': {
            id: '1',
            name: 'MacBook Pro 14"',
            price: 1299.99,
            image: 'img/product01.png',
            category: 'laptops',
            specs: {
                brand: 'Apple',
                model: 'MacBook Pro 14"',
                processor: 'M3 Pro',
                ram: '16',
                storage: '512',
                screenSize: '14',
                battery: '70',
                weight: '1.6',
                os: 'macOS',
                resolution: '3024x1964'
            }
        },
        '2': {
            id: '2',
            name: 'iPhone 15 Pro',
            price: 999.99,
            image: 'img/product02.png',
            category: 'smartphones',
            specs: {
                brand: 'Apple',
                model: 'iPhone 15 Pro',
                processor: 'A17 Pro',
                ram: '8',
                storage: '256',
                screenSize: '6.1',
                battery: '3274',
                weight: '0.187',
                os: 'iOS 17',
                camera: '48MP'
            }
        },
        '3': {
            id: '3',
            name: 'Sony Alpha 7 III',
            price: 1999.99,
            image: 'img/product03.png',
            category: 'cameras',
            specs: {
                brand: 'Sony',
                model: 'Alpha 7 III',
                sensor: 'Full Frame',
                resolution: '24.2MP',
                iso: '100-51200',
                video: '4K',
                weight: '1.43',
                stabilization: '5-axis'
            }
        },
        '4': {
            id: '4',
            name: 'Samsung Galaxy S24',
            price: 899.99,
            image: 'img/product04.png',
            category: 'smartphones',
            specs: {
                brand: 'Samsung',
                model: 'Galaxy S24',
                processor: 'Snapdragon 8 Gen 3',
                ram: '12',
                storage: '256',
                screenSize: '6.2',
                battery: '4000',
                weight: '0.168',
                os: 'Android 14',
                camera: '50MP'
            }
        },
        '5': {
            id: '5',
            name: 'Dell XPS 13',
            price: 1099.99,
            image: 'img/product05.png',
            category: 'laptops',
            specs: {
                brand: 'Dell',
                model: 'XPS 13',
                processor: 'Intel Core i7',
                ram: '16',
                storage: '512',
                screenSize: '13.4',
                battery: '52',
                weight: '1.17',
                os: 'Windows 11',
                resolution: '1920x1200'
            }
        }
    };
    
    return products[productId] || products['1'];
}

function getDefaultSpecs(category) {
    const defaultSpecs = {
        laptops: {
            processor: 'Intel Core i5',
            ram: '8',
            storage: '256',
            screenSize: '13.3',
            battery: '50',
            weight: '1.5',
            os: 'Windows 11'
        },
        smartphones: {
            processor: 'Octa-core',
            ram: '6',
            storage: '128',
            screenSize: '6.1',
            battery: '4000',
            weight: '0.18',
            os: 'Android'
        },
        cameras: {
            sensor: 'APS-C',
            resolution: '24MP',
            iso: '100-25600',
            video: '4K',
            weight: '1.0',
            stabilization: 'Yes'
        },
        accessories: {
            compatibility: 'Universal',
            connectivity: 'Bluetooth',
            battery: 'N/A',
            weight: '0.1',
            warranty: '1 year'
        }
    };
    
    return defaultSpecs[category] || {};
}