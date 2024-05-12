"use strict";
var _a;
const searchDrawer = document.querySelector('#search-drawer');
const searchResults = document.querySelector('#search-results');
const searchedProducts = (_a = searchResults === null || searchResults === void 0 ? void 0 : searchResults.querySelector('#product-section')) !== null && _a !== void 0 ? _a : null;
if (searchDrawer && searchResults && searchedProducts) {
    const searchButton = document.querySelector('#search-button');
    if (searchButton) {
        searchButton.addEventListener('click', event => {
            //event.preventDefault();
        });
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
