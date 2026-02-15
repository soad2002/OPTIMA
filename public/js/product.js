document.addEventListener('DOMContentLoaded', function () {
    function showElement(id) {
        const el = document.getElementById(id);
        if (el) el.style.display = '';
    }

    function hideElement(id) {
        const el = document.getElementById(id);
        if (el) el.style.display = 'none';
    }

    function setText(id, text) {
        const el = document.getElementById(id);
        if (el) el.textContent = text;
    }

    function setHtml(id, html) {
        const el = document.getElementById(id);
        if (el) el.innerHTML = html;
    }

    function setAttr(id, attr, val) {
        const el = document.getElementById(id);
        if (el) el.setAttribute(attr, val);
    }

    hideElement('product-not-found');
    showElement('loading-product');
    hideElement('product-details-section');

    // Get product id from URL (assumes /product/{id})
    const pathParts = window.location.pathname.split('/').filter(Boolean);
    const id = pathParts[pathParts.length - 1];
    if (!id || isNaN(Number(id))) {
        hideElement('loading-product');
        showElement('product-not-found');
        return;
    }

    fetch(`/api/products/${id}`)
        .then((res) => {
            if (!res.ok) throw new Error('Product not found');
            return res.json();
        })
        .then((data) => {
            // populate fields - be tolerant of missing props
            setText('product-name', data.name || data.description || 'Unnamed Product');
            setAttr('main-product-image', 'src', data.image_url || '/img/product01.png');
            setText('product-price', data.price ? `$${(Number(data.price) / 50).toFixed(2)}` : '$0.00');
            setText('product-short-description', data.description || '');
            setHtml('product-description', data.description || 'No description available.');
            setText('product-category', data.category || 'Category');
            // specs into table
            const specs = data.specs || data.specifications || {};
            const specsTable = document.getElementById('product-specifications');
            if (specsTable) {
                let rows = '';
                for (const key in specs) {
                    if (!Object.prototype.hasOwnProperty.call(specs, key)) continue;
                    rows += `<tr><th style="width:30%">${key.replace(/_/g, ' ')}</th><td>${specs[key]}</td></tr>`;
                }
                specsTable.innerHTML = rows || '<tr><td colspan="2">No specifications available.</td></tr>';
            }

            // reviews
            setText('review-count', data.reviews_count ?? 0);
            setText('tab-review-count', data.reviews_count ?? 0);
            setText('average-rating', (data.rating ?? 0).toString());

            // Populate product info table
            const infoTable = document.getElementById('product-info-table');
            if (infoTable) {
                const rows = [];
                rows.push(`<tr><th style="width:30%">ID</th><td>${data.id ?? ''}</td></tr>`);
                rows.push(`<tr><th>Brand</th><td>${data.brand ?? ''}</td></tr>`);
                rows.push(`<tr><th>Category</th><td>${data.category ?? ''}</td></tr>`);
                rows.push(`<tr><th>Price</th><td>${data.price ? `$${(Number(data.price) / 50).toFixed(2)}` : ''}</td></tr>`);
                rows.push(`<tr><th>Color</th><td>${data.color ?? ''}</td></tr>`);
                // Processor / Specs
                rows.push(`<tr><th>Processor</th><td>${data.processor_brand || (data.specs && data.specs.processor) || ''} ${data.processor_model || ''}</td></tr>`);
                rows.push(`<tr><th>RAM</th><td>${data.ram_gb ? data.ram_gb + 'GB' : (data.specs && data.specs.ram) || ''}</td></tr>`);
                rows.push(`<tr><th>Storage</th><td>${data.storage_gb ? data.storage_gb + 'GB ' + (data.storage_type || '') : (data.specs && data.specs.storage) || ''}</td></tr>`);
                rows.push(`<tr><th>Display</th><td>${data.screen_size ? data.screen_size + '" ' + (data.display_type || '') : (data.specs && data.specs.display) || ''}</td></tr>`);
                rows.push(`<tr><th>OS</th><td>${data.os ?? ''}</td></tr>`);
                rows.push(`<tr><th>Weight</th><td>${data.weight_kg ? data.weight_kg + 'kg' : (data.specs && data.specs.weight) || ''}</td></tr>`);
                infoTable.innerHTML = rows.join('');
            }

            hideElement('loading-product');
            showElement('product-details-section');
        })
        .catch((err) => {
            hideElement('loading-product');
            showElement('product-not-found');
            console.error('Error loading product:', err);
        });
});
