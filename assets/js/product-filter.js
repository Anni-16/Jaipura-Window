
let currentView = 'grid'; // Default view
let allItems = [];

window.onload = () => {
    const container = document.getElementById('items-container');
    allItems = Array.from(container.children); // Save original items
    updateFilter(); // Initial render
    bindViewButtons(); // Attach view toggle
};

function updateFilter() {
    const sortValue = document.getElementById('input-sort').value;
    const limitValue = parseInt(document.getElementById('input-limit').value);
    const container = document.getElementById('items-container');

    let filteredItems = [...allItems];

    // Sort using visible text (not data attributes)
    filteredItems.sort((a, b) => {
        const nameA = a.querySelector('.food-title2')?.textContent.trim().toLowerCase() || '';
        const nameB = b.querySelector('.food-title2')?.textContent.trim().toLowerCase() || '';
        const priceA = parseFloat(a.querySelector('.food-price')?.textContent.replace(/[^\d.]/g, '')) || 0;
        const priceB = parseFloat(b.querySelector('.food-price')?.textContent.replace(/[^\d.]/g, '')) || 0;

        switch (sortValue) {
            case 'name-asc':
                return nameA.localeCompare(nameB);
            case 'name-desc':
                return nameB.localeCompare(nameA);
            case 'price-asc':
                return priceA - priceB;
            case 'price-desc':
                return priceB - priceA;
            default:
                return 0;
        }
    });

    // Limit number of results
    filteredItems = filteredItems.slice(0, limitValue);

    // Clear and re-append
    container.innerHTML = '';
    filteredItems.forEach(item => container.appendChild(item));

    applyCurrentView(); // Reapply list/grid layout
}

function bindViewButtons() {
    document.getElementById('grid-view').addEventListener('click', () => switchView('grid'));
    document.getElementById('list-view').addEventListener('click', () => switchView('list'));
}

function switchView(view) {
    currentView = view;
    document.getElementById('grid-view').classList.toggle('active', view === 'grid');
    document.getElementById('list-view').classList.toggle('active', view === 'list');
    applyCurrentView(); // Refresh view
}

function applyCurrentView() {
    const items = document.querySelectorAll('#items-container .item');
    const isList = currentView === 'list';

    items.forEach(item => {
        item.classList.remove('product-grid', 'product-list');
        item.classList.add(isList ? 'product-list' : 'product-grid');

        const desc = item.querySelector('.description');
        if (desc) desc.style.display = isList ? 'block' : 'none';

        // Optional: align text/image for list view
        const foodBox = item.querySelector('.food-box');
        if (foodBox) {
            foodBox.style.display = isList ? 'flex' : 'block';
            foodBox.style.flexDirection = isList ? 'row' : 'column';
            foodBox.style.alignItems = isList ? 'flex-start' : 'center';
        }

        const image = item.querySelector('.product-thumb');
        const descBlock = item.querySelector('.product-description');

        if (image && descBlock && isList) {
            image.style.width = '30%';
            descBlock.style.width = '70%';
            descBlock.style.paddingLeft = '15px';
        } else if (image && descBlock) {
            image.style.width = '';
            descBlock.style.width = '';
            descBlock.style.paddingLeft = '';
        }
    });
}
