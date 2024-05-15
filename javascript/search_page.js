"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
var _a, _b, _c;
function updateProducts(posts, searchedProducts) {
    searchedProducts.innerHTML = '';
    const productSectionTitle = document.createElement('h1');
    productSectionTitle.innerHTML = posts.length === 0 ? 'No results found' : `Found ${posts.length} results`;
    searchedProducts.appendChild(productSectionTitle);
    posts.forEach((post) => {
        const productCard = drawProductCard(post);
        searchedProducts.appendChild(productCard);
    });
}
function performSearch(searchQuery, filters) {
    return __awaiter(this, void 0, void 0, function* () {
        let actionUrl = `../actions/action_search.php?query=${searchQuery}`;
        filters.forEach(filter => actionUrl += `&${filter}`);
        return getData(actionUrl)
            .then(response => response.json())
            .then(json => {
            if (json.success) {
                return json.posts;
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
    });
}
const searchDrawer = document.querySelector('#search-drawer');
const searchResults = document.querySelector('#search-results');
const searchedProducts = (_a = searchResults === null || searchResults === void 0 ? void 0 : searchResults.querySelector('#product-section')) !== null && _a !== void 0 ? _a : null;
if (searchDrawer && searchResults && searchedProducts) {
    const searchInput = document.querySelector('#search-input');
    const searchButton = document.querySelector('#search-button');
    const searchFilterElems = document.querySelectorAll('.search-filter');
    let searchFilters = [];
    const urlParams = new URLSearchParams(window.location.search);
    performSearch((_b = urlParams.get('query')) !== null && _b !== void 0 ? _b : '', searchFilters)
        .then(result => updateProducts(result, searchedProducts));
    if (searchButton && searchInput) {
        searchButton.addEventListener('click', event => {
            event.preventDefault();
            window.history.pushState({}, '', `search?query=${searchInput.value}`);
            performSearch(searchInput.value, searchFilters)
                .then(result => updateProducts(result, searchedProducts));
        });
        searchInput.value = (_c = urlParams.get('query')) !== null && _c !== void 0 ? _c : '';
        searchInput.addEventListener('input', () => {
            window.history.pushState({}, '', `search?query=${searchInput.value}`);
            performSearch(searchInput.value, searchFilters)
                .then(result => updateProducts(result, searchedProducts));
        });
    }
    searchFilterElems.forEach(filterElem => {
        const filterInput = filterElem.querySelector('input');
        if (!filterInput)
            return;
        filterInput.addEventListener('click', () => {
            const filterType = filterElem.dataset.type;
            const filterValue = filterElem.dataset.value;
            if (filterType && filterValue && searchInput) {
                const filterString = `${filterType}[]=${filterValue}`;
                if (filterInput.checked)
                    searchFilters.push(filterString);
                else
                    searchFilters = searchFilters.filter(value => value !== filterString);
                performSearch(searchInput.value, searchFilters)
                    .then(result => updateProducts(result, searchedProducts));
            }
        });
    });
}
