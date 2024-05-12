"use strict";
var _a;
function performSearch(searchedProducts, searchQuery) {
    getData(`../actions/action_search.php?search=${searchQuery}`)
        .then(response => response.json())
        .then(json => {
        if (json.success) {
            searchedProducts.innerHTML = '';
            const productSectionTitle = document.createElement('h1');
            productSectionTitle.innerHTML = json.posts.length === 0 ? 'No results found' : `Found ${json.posts.length} results`;
            searchedProducts.appendChild(productSectionTitle);
            json.posts.forEach((post) => {
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
    if (searchButton) {
        searchButton.addEventListener('click', event => {
            var _a;
            event.preventDefault();
            performSearch(searchedProducts, (_a = searchInput === null || searchInput === void 0 ? void 0 : searchInput.value) !== null && _a !== void 0 ? _a : '');
        });
    }
    if (searchInput) {
        searchInput.addEventListener('input', event => performSearch(searchedProducts, searchInput.value));
    }
    if (document.location.search.split('=')[0] === '?query') {
        getData('../actions/action_search.php?search=' + document.location.search.split('=')[1])
            .then(response => response.json())
            .then(json => {
            if (json.success) {
                json.posts.forEach((post) => {
                    const productCard = drawProductCard(post);
                    searchedProducts.appendChild(productCard);
                });
            }
            else {
                sendToastMessage('An unexpected error occurred', 'error');
                console.error(json.error);
            }
        });
    }
}
