const filterTypes = ['condition', 'category', 'size'];

function matchesFilters(post: {[key: string]: string}, searchFilters: {[key: string]: Array<string>}) {
    filterTypes.forEach(filterType => {
        if (searchFilters[filterType].length !== 0 && !searchFilters[filterType].includes(post[filterType])) {
            return false;
        }
    });
    return true;
}

function updateProducts(
    posts: Array<{[key: string]: string}>,
    searchedProducts: HTMLElement,
    filters: {[key: string]: Array<string>},
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
    let posts: Array<{[key: string]: string}> = [];

    const urlParams = new URLSearchParams(window.location.search);
    performSearch(searchedProducts, urlParams.get('search') ?? '')
        .then(result => {
            posts = result;
            updateProducts(posts, searchedProducts, searchFilters);
        });
    
    if (searchButton) {
        searchButton.addEventListener('click', event => {
            event.preventDefault();
            performSearch(searchedProducts, urlParams.get('search') ?? '')
            .then(result => {
                posts = result;
                updateProducts(posts, searchedProducts, searchFilters);
            });
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            performSearch(searchedProducts, urlParams.get('search') ?? '')
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


