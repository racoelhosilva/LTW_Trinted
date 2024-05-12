"use strict";
var _a, _b;
const filterTypes = ['condition', 'category', 'price'];
function matchesFilters(post, searchFilters) {
    filterTypes.forEach(filterType => {
        if (searchFilters[filterType].length !== 0 && !searchFilters[filterType].includes(post[filterType])) {
            return false;
        }
    });
    return true;
}
function performSearch(searchedProducts, searchQuery, searchFilters) {
    getData(`../actions/action_search.php?search=${searchQuery}`)
        .then(response => response.json())
        .then(json => {
        if (json.success) {
            searchedProducts.innerHTML = '';
            const productSectionTitle = document.createElement('h1');
            productSectionTitle.innerHTML = json.posts.length === 0 ? 'No results found' : `Found ${json.posts.length} results`;
            searchedProducts.appendChild(productSectionTitle);
            json.posts
                .filter((post) => matchesFilters(post, searchFilters))
                .forEach((post) => {
                const productCard = drawProductCard(post);
                searchedProducts.appendChild(productCard);
            });
        }
        else {
            sendToastMessage('An unexpected error occurred', 'error');
            console.error(json.error);
        }
    })
        .catch(error => {
        sendToastMessage('An unexpected error occurred', 'error');
        console.error(error);
    });
}
const searchDrawer = document.querySelector('#search-drawer');
const searchResults = document.querySelector('#search-results');
const searchedProducts = (_a = searchResults === null || searchResults === void 0 ? void 0 : searchResults.querySelector('#product-section')) !== null && _a !== void 0 ? _a : null;
if (searchDrawer && searchResults && searchedProducts) {
    const searchInput = document.querySelector('#search-input');
    const searchButton = document.querySelector('#search-button');
    const searchFilterElems = document.querySelectorAll('.search-filter');
    const searchFilters = {
        'condition': [],
        'category': [],
        'price': [],
    };
    if (searchButton) {
        searchButton.addEventListener('click', event => {
            var _a;
            event.preventDefault();
            performSearch(searchedProducts, (_a = searchInput === null || searchInput === void 0 ? void 0 : searchInput.value) !== null && _a !== void 0 ? _a : '', searchFilters);
        });
    }
    if (searchInput) {
        searchInput.addEventListener('input', event => performSearch(searchedProducts, searchInput.value, searchFilters));
    }
    const urlParams = new URLSearchParams(window.location.search);
    performSearch(searchedProducts, (_b = urlParams.get('search')) !== null && _b !== void 0 ? _b : '', searchFilters);
}
