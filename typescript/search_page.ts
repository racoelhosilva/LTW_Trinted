function updateProducts(
    posts: Array<{[key: string]: string}>,
    searchedProducts: HTMLElement,
): void {
    searchedProducts.innerHTML = '';

    const productSectionTitle = document.createElement('h1');
    productSectionTitle.innerHTML = posts.length === 0 ? 'No results found' : `Found ${posts.length} results`;
    searchedProducts.appendChild(productSectionTitle);

    posts.forEach((post: {[key: string]: string}) => {
        const productCard = drawProductCard(post);
        searchedProducts.appendChild(productCard);
    });
}

async function performSearch(searchQuery: string, filters: Array<string>): Promise<Array<{[key: string]: string}>> {
    let actionUrl = `../actions/action_search.php?query=${searchQuery}`;
    filters.forEach(filter => actionUrl += `&${filter}`);

    return getData(actionUrl)
        .then(response => response.json())
        .then(json => {
            if (json.success) {
                return json.posts;
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

const searchDrawer: HTMLElement | null = document.querySelector('#search-drawer');
const searchResults: HTMLElement | null = document.querySelector('#search-results');
const searchedProducts: HTMLElement | null = searchResults?.querySelector('#product-section') ?? null;

if (searchDrawer && searchResults && searchedProducts) {
    const searchInput: HTMLInputElement | null = document.querySelector('#search-input');
    const searchButton: HTMLElement | null = document.querySelector('#search-button');
    const searchFilterElems: NodeListOf<HTMLElement> = document.querySelectorAll('.search-filter');
    let searchFilters: Array<string> = [];

    const urlParams = new URLSearchParams(window.location.search);
    performSearch(urlParams.get('query') ?? '', searchFilters)
        .then(result => updateProducts(result, searchedProducts));
    
    if (searchButton && searchInput) {
        searchButton.addEventListener('click', event => {
            event.preventDefault();
            window.history.pushState({}, '', `search?query=${searchInput.value}`);
            performSearch(searchInput.value, searchFilters)
            .then(result => updateProducts(result, searchedProducts));
        });

        searchInput.value = urlParams.get('query') ?? '';
        searchInput.addEventListener('input', () => {
            window.history.pushState({}, '', `search?query=${searchInput.value}`);
            performSearch(searchInput.value, searchFilters)
                .then(result => updateProducts(result, searchedProducts));
        });
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
                
                performSearch(searchInput.value, searchFilters)
                    .then(result => updateProducts(result, searchedProducts));
            }
        });
    });
}


