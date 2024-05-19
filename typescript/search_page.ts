async function updateProducts(
    products: Array<{[key: string]: string}>,
    numResults: number,
    searchedProducts: HTMLElement,
): Promise<void> {
    searchedProducts.innerHTML = '';

    const productSectionTitle = document.createElement('h1');
    productSectionTitle.innerHTML = numResults === 0 ? 'No results found' : `Found ${numResults} results`;
    searchedProducts.appendChild(productSectionTitle);

    for (const product of products) {
        const productCard = await drawProductCard(product);
        searchedProducts.appendChild(productCard);
    }
}

async function performSearch(searchQuery: string, filters: Array<string>, start: number, limit: number): Promise<Array<{[key: string]: string}>> {
    let actionUrl = `/actions/action_search.php?query=${searchQuery}&start=${start}&limit=${limit}`;
    filters.forEach(filter => actionUrl += `&${filter}`);

    return getData(actionUrl)
        .then(response => response.json())
        .then(json => {
            if (json.success) {
                return json.products;
            } else {
                sendToastMessage('An unexpected error occurred', 'error');
                console.error(json.error);
            }
        })
        .catch(error => {
            sendToastMessage('An unexpected error occurred', 'error');
            console.error(error);
        });
}

async function getNumberResults(searchQuery: string, filters: Array<string>): Promise<number> {
    let actionUrl = `../actions/action_search.php?query=${searchQuery}&count=true`;
    filters.forEach(filter => actionUrl += `&${filter}`);

    return getData(actionUrl)
        .then(response => response.json())
        .then(json => {
            if (json.success) {
                return json.count;
            } else {
                sendToastMessage('An unexpected error occurred', 'error');
                console.error(json.error);
            }
        })
        .catch(error => {
            sendToastMessage('An unexpected error occurred', 'error');
            console.error(error);
        });
}

function drawPageButton(page: number, text: string, setPage: (page: number) => void): HTMLElement {
    const button = document.createElement('span');
    button.innerHTML = text;
    button.addEventListener('click', () => setPage(page));
    return button;
}

function drawBlockedPageButton(text: string): HTMLElement {
    const button = document.createElement('span');
    button.innerHTML = text;
    button.classList.add('blocked');
    return button;
}

function drawActivePageButton(text: string): HTMLElement {
    const button = document.createElement('span');
    button.innerHTML = text;
    button.classList.add('active');
    return button;
}

function drawEllipsisPageButton(): HTMLElement {
    const button = document.createElement('span');
    button.innerHTML = '...';
    button.classList.add('ellipsis');
    return button;
}

function drawPagination(pages: number, currentPage: number, setPage: (page: number) => void): HTMLElement {
    const pagination = document.createElement('div');
    pagination.id = 'pagination';
    if (pages == 0)
        return pagination;

    if (currentPage > 1) {
        pagination.appendChild(drawPageButton(currentPage - 1, '&lt;', setPage));
    } else {
        pagination.appendChild(drawBlockedPageButton('&lt;'));
    }

    if (currentPage === 1) {
        pagination.appendChild(drawActivePageButton('1'));
    } else {
        pagination.appendChild(drawPageButton(1, '1', setPage));
    }

    if (currentPage > 3) {
        pagination.appendChild(drawEllipsisPageButton());
    }

    for (let i = Math.max(2, currentPage - 1); i <= Math.min(pages - 1, currentPage + 1); i++) {
        if (i === currentPage) {
            pagination.appendChild(drawActivePageButton(i.toString()));
        } else {
            pagination.appendChild(drawPageButton(i, i.toString(), setPage));
        }
    }

    if (currentPage < pages - 2) {
        pagination.appendChild(drawEllipsisPageButton());
    }

    if (pages > 1 && currentPage === pages) {
        pagination.appendChild(drawActivePageButton(pages.toString()));
    } else if (pages > 1) {
        pagination.appendChild(drawPageButton(pages, pages.toString(), setPage));
    }

    if (currentPage < pages) {
        pagination.appendChild(drawPageButton(currentPage + 1, '&gt;', setPage));
    } else {
        pagination.appendChild(drawBlockedPageButton('&gt;'));
    }

    return pagination;
}

const searchDrawer: HTMLElement | null = document.querySelector('#search-drawer');
const searchResults: HTMLElement | null = document.querySelector('#search-results');
const searchedProducts: HTMLElement | null = searchResults?.querySelector('#product-section') ?? null;

if (searchDrawer && searchResults && searchedProducts) {
    const searchInput: HTMLInputElement | null = document.querySelector('#search-input');
    const searchButton: HTMLElement | null = document.querySelector('#search-button');
    const searchFilterElems: NodeListOf<HTMLElement> = document.querySelectorAll('.search-filter');
    let searchFilters: Array<string> = [];

    const productsPerPage = 15;
    let numResults: number;
    let totalPages: number;
    let currentPage: number;
    let pagination: HTMLElement = document.createElement('div');
    searchResults.appendChild(pagination);

    async function updatePage(query: string, page: number): Promise<void> {
        currentPage = page;
        const results = await performSearch(query, searchFilters, (currentPage - 1) * productsPerPage, productsPerPage);
        updateProducts(results, numResults, searchedProducts!);
        
        pagination.remove();
        pagination = drawPagination(totalPages, currentPage, (page) => updatePage(query, page));
        searchResults!.appendChild(pagination);
    }

    async function updateSearchResults(query: string): Promise<void> {
        numResults = await getNumberResults(query, searchFilters);
        totalPages = Math.ceil(numResults / productsPerPage);
        updatePage(query, 1);
    }

    const urlParams = new URLSearchParams(window.location.search);
    updateSearchResults(urlParams.get('query') ?? '');
    
    if (searchButton && searchInput) {
        searchButton.addEventListener('click', event => {
            event.preventDefault();
            window.history.pushState({}, '', `search?query=${searchInput.value}`);
            updateSearchResults(searchInput.value);
        });

        searchInput.value = urlParams.get('query') ?? '';
    }
    
    searchFilterElems.forEach(filterElem => {
        const filterInput: HTMLInputElement | null = filterElem.querySelector('input');
        if (!filterInput)
            return;
        filterInput.addEventListener('click', () => {
            const filterType = filterElem.dataset.type;
            const filterValue = filterElem.dataset.value;

            if (filterType && filterValue && searchInput) {
                const filterString = `${filterType}[]=${filterValue}`;
                if (filterInput!.checked)
                    searchFilters.push(filterString);
                else
                    searchFilters = searchFilters.filter(value => value !== filterString);
                
                updateSearchResults(searchInput.value);
            }
        });
    });
}


