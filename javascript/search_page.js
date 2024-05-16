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
function updateProducts(posts, numResults, searchedProducts) {
    searchedProducts.innerHTML = '';
    const productSectionTitle = document.createElement('h1');
    productSectionTitle.innerHTML = numResults === 0 ? 'No results found' : `Found ${numResults} results`;
    searchedProducts.appendChild(productSectionTitle);
    posts.forEach((post) => {
        const productCard = drawProductCard(post);
        searchedProducts.appendChild(productCard);
    });
}
function performSearch(searchQuery, filters, start, limit) {
    return __awaiter(this, void 0, void 0, function* () {
        let actionUrl = `../actions/action_search.php?query=${searchQuery}&start=${start}&limit=${limit}`;
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
function getNumberResults(searchQuery, filters) {
    return __awaiter(this, void 0, void 0, function* () {
        let actionUrl = `../actions/action_search.php?query=${searchQuery}&count=true`;
        filters.forEach(filter => actionUrl += `&${filter}`);
        return getData(actionUrl)
            .then(response => response.json())
            .then(json => {
            if (json.success) {
                return json.count;
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
function drawPageButton(page, text, setPage) {
    const button = document.createElement('span');
    button.innerHTML = text;
    button.addEventListener('click', () => setPage(page));
    return button;
}
function drawBlockedPageButton(text) {
    const button = document.createElement('span');
    button.innerHTML = text;
    button.classList.add('blocked');
    return button;
}
function drawActivePageButton(text) {
    const button = document.createElement('span');
    button.innerHTML = text;
    button.classList.add('active');
    return button;
}
function drawEllipsisPageButton() {
    const button = document.createElement('span');
    button.innerHTML = '...';
    button.classList.add('ellipsis');
    return button;
}
function drawPagination(pages, currentPage, setPage) {
    const pagination = document.createElement('div');
    pagination.id = 'pagination';
    if (pages == 0)
        return pagination;
    if (currentPage > 1) {
        pagination.appendChild(drawPageButton(currentPage - 1, '&lt;', setPage));
    }
    else {
        pagination.appendChild(drawBlockedPageButton('&lt;'));
    }
    if (currentPage === 1) {
        pagination.appendChild(drawActivePageButton('1'));
    }
    else {
        pagination.appendChild(drawPageButton(1, '1', setPage));
    }
    if (currentPage > 3) {
        pagination.appendChild(drawEllipsisPageButton());
    }
    for (let i = Math.max(2, currentPage - 1); i <= Math.min(pages - 1, currentPage + 1); i++) {
        if (i === currentPage) {
            pagination.appendChild(drawActivePageButton(i.toString()));
        }
        else {
            pagination.appendChild(drawPageButton(i, i.toString(), setPage));
        }
    }
    if (currentPage < pages - 2) {
        pagination.appendChild(drawEllipsisPageButton());
    }
    if (pages > 1 && currentPage === pages) {
        pagination.appendChild(drawActivePageButton(pages.toString()));
    }
    else if (pages > 1) {
        pagination.appendChild(drawPageButton(pages, pages.toString(), setPage));
    }
    if (currentPage < pages) {
        pagination.appendChild(drawPageButton(currentPage + 1, '&gt;', setPage));
    }
    else {
        pagination.appendChild(drawBlockedPageButton('&gt;'));
    }
    return pagination;
}
const searchDrawer = document.querySelector('#search-drawer');
const searchResults = document.querySelector('#search-results');
const searchedProducts = (_a = searchResults === null || searchResults === void 0 ? void 0 : searchResults.querySelector('#product-section')) !== null && _a !== void 0 ? _a : null;
if (searchDrawer && searchResults && searchedProducts) {
    const searchInput = document.querySelector('#search-input');
    const searchButton = document.querySelector('#search-button');
    const searchFilterElems = document.querySelectorAll('.search-filter');
    let searchFilters = [];
    const postsPerPage = 15;
    let numResults;
    let totalPages;
    let currentPage;
    let pagination = document.createElement('div');
    searchResults.appendChild(pagination);
    function updatePage(query, page) {
        return __awaiter(this, void 0, void 0, function* () {
            currentPage = page;
            const results = yield performSearch(query, searchFilters, (currentPage - 1) * postsPerPage, postsPerPage);
            updateProducts(results, numResults, searchedProducts);
            pagination.remove();
            pagination = drawPagination(totalPages, currentPage, (page) => updatePage(query, page));
            searchResults.appendChild(pagination);
        });
    }
    function updateSearchResults(query) {
        return __awaiter(this, void 0, void 0, function* () {
            numResults = yield getNumberResults(query, searchFilters);
            totalPages = Math.ceil(numResults / postsPerPage);
            updatePage(query, 1);
        });
    }
    const urlParams = new URLSearchParams(window.location.search);
    updateSearchResults((_b = urlParams.get('query')) !== null && _b !== void 0 ? _b : '');
    if (searchButton && searchInput) {
        searchButton.addEventListener('click', event => {
            event.preventDefault();
            window.history.pushState({}, '', `search?query=${searchInput.value}`);
            updateSearchResults(searchInput.value);
        });
        searchInput.value = (_c = urlParams.get('query')) !== null && _c !== void 0 ? _c : '';
        searchInput.addEventListener('input', () => {
            window.history.pushState({}, '', `search?query=${searchInput.value}`);
            updateSearchResults(searchInput.value);
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
                updateSearchResults(searchInput.value);
            }
        });
    });
}
