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
var _a, _b;
const filterTypes = ['condition', 'category', 'size'];
function matchesFilters(post, searchFilters) {
    filterTypes.forEach(filterType => {
        if (searchFilters[filterType].length !== 0 && !searchFilters[filterType].includes(post[filterType])) {
            return false;
        }
    });
    return true;
}
function updateProducts(posts, searchedProducts, filters) {
    searchedProducts.innerHTML = '';
    const productSectionTitle = document.createElement('h1');
    productSectionTitle.innerHTML = posts.length === 0 ? 'No results found' : `Found ${posts.length} results`;
    searchedProducts.appendChild(productSectionTitle);
    posts.forEach((post) => {
        const productCard = drawProductCard(post);
        searchedProducts.appendChild(productCard);
    });
}
function performSearch(searchedProducts, searchQuery) {
    return __awaiter(this, void 0, void 0, function* () {
        return getData(`../actions/action_search.php?search=${searchQuery}`)
            .then(response => response.json())
            .then(json => {
            if (json.success) {
                console.log(json.posts);
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
    const searchFilters = filterTypes.reduce((acc, filterType) => (Object.assign(Object.assign({}, acc), { [filterType]: [] })), {});
    let posts = [];
    const urlParams = new URLSearchParams(window.location.search);
    performSearch(searchedProducts, (_b = urlParams.get('search')) !== null && _b !== void 0 ? _b : '')
        .then(result => {
        posts = result;
        updateProducts(posts, searchedProducts, searchFilters);
    });
    if (searchButton) {
        searchButton.addEventListener('click', event => {
            var _a;
            event.preventDefault();
            performSearch(searchedProducts, (_a = urlParams.get('search')) !== null && _a !== void 0 ? _a : '')
                .then(result => {
                posts = result;
                updateProducts(posts, searchedProducts, searchFilters);
            });
        });
    }
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            var _a;
            performSearch(searchedProducts, (_a = urlParams.get('search')) !== null && _a !== void 0 ? _a : '')
                .then(result => {
                posts = result;
                updateProducts(posts, searchedProducts, searchFilters);
            });
        });
    }
    searchFilterElems.forEach(filterElem => {
        filterElem.addEventListener('click', () => {
            const filterType = filterElem.dataset.type;
            const filterValue = filterElem.dataset.value;
            if (filterType) {
                if (filterElem.checked)
                    searchFilters[filterType].push(filterElem.value);
                else
                    searchFilters[filterType] = searchFilters[filterType].filter(value => value !== filterValue);
                updateProducts(posts, searchedProducts, searchFilters);
            }
        });
    });
}
