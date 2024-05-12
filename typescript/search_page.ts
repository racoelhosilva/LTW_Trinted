const filterTypes = ['condition', 'category', 'size'];

function matchesFilters(post: {[key: string]: string}, searchFilters: {[key: string]: Array<string>}): boolean {
    return filterTypes.every(filterType => {
        if (searchFilters[filterType].length === 0 || searchFilters[filterType].includes(post[filterType])) {
            return true;
        }
    });
}

function updateProducts(
    posts: Array<{[key: string]: string}>,
    searchedProducts: HTMLElement,
    filters: {[key: string]: Array<string>},
): void {
    searchedProducts.innerHTML = '';
    const filteredPosts = posts.filter(post => { console.log(matchesFilters(post, filters)); return matchesFilters(post, filters); });
    console.log(posts);

    const productSectionTitle = document.createElement('h1');
    productSectionTitle.innerHTML = filteredPosts.length === 0 ? 'No results found' : `Found ${posts.length} results`;
    searchedProducts.appendChild(productSectionTitle);

    filteredPosts.forEach((post: {[key: string]: string}) => {
        const productCard = drawProductCard(post);
        searchedProducts.appendChild(productCard);
    });
}

async function performSearch(searchedProducts: HTMLElement, searchQuery: string): Promise<Array<{[key: string]: string}>> {
    return getData(`../actions/action_search.php?search=${searchQuery}`)
        .then(response => response.json())
        .then(json => {
            if (json.success) {
                console.log(json.posts);
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
    const searchFilterElems: NodeListOf<HTMLInputElement> = document.querySelectorAll('.search-filter');
    const searchFilters: {[key: string]: Array<string>} =
        filterTypes.reduce((acc, filterType) => ({...acc, [filterType]: []}), {});
    searchFilters['size'].push('M');
    let posts: Array<{[key: string]: string}> = [];

    const urlParams = new URLSearchParams(window.location.search);
    performSearch(searchedProducts, urlParams.get('search') ?? '')
        .then(result => {
            posts = result;
            updateProducts(result, searchedProducts, searchFilters);
        });
    
    if (searchButton && searchInput) {
        searchButton.addEventListener('click', event => {
            event.preventDefault();
            window.history.pushState({}, '', `search?search=${searchInput.value}`);
            performSearch(searchedProducts, searchInput.value)
            .then(result => {
                window.history.pushState({}, '', `search?search=${urlParams.get('search')}`);
                posts = result;
                updateProducts(result, searchedProducts, searchFilters);
            });
        });

        searchInput.addEventListener('input', () => {
            window.history.pushState({}, '', `search?search=${searchInput.value}`);
            performSearch(searchedProducts, searchInput.value)
            performSearch(searchedProducts, searchInput.value)
            .then(result => {
                posts = result;
                updateProducts(result, searchedProducts, searchFilters);
            });
        });
    }
    
    searchFilterElems.forEach(filterElem => {
        filterElem.addEventListener('click', () => {
            console.log(filterElem);
            const filterType = filterElem.dataset.type;
            const filterValue = filterElem.dataset.value;

            if (filterType && filterValue) {
                if (filterElem.checked)
                    searchFilters[filterType].push(filterElem.value);
                else
                    searchFilters[filterType] = searchFilters[filterType].filter(value => value !== filterValue);
                updateProducts(posts, searchedProducts, searchFilters);
            }
        });
    });
}


