const filterTypes = ['condition', 'category', 'price'];

function matchesFilters(post: {[key: string]: string}, searchFilters: {[key: string]: Array<string>}) {
    filterTypes.forEach(filterType => {
        if (searchFilters[filterType].length !== 0 && !searchFilters[filterType].includes(post[filterType])) {
            return false;
        }
    });
    return true;
}

function performSearch(searchedProducts: HTMLElement, searchQuery: string, searchFilters: {[key: string]: Array<string>}) {
    getData(`../actions/action_search.php?search=${searchQuery}`)
        .then(response => response.json())
        .then(json => {
            if (json.success) {
                searchedProducts.innerHTML = '';

                const productSectionTitle = document.createElement('h1');
                productSectionTitle.innerHTML = json.posts.length === 0 ? 'No results found' : `Found ${json.posts.length} results`;
                searchedProducts.appendChild(productSectionTitle);

                json.posts
                    .filter((post: {[key: string]: string}) => matchesFilters(post, searchFilters))
                    .forEach((post: {[key: string]: string}) => {
                        const productCard = drawProductCard(post);
                        searchedProducts.appendChild(productCard);
                    });
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
    const searchFilters: {[key: string]: Array<string>} = {
        'condition': [],
        'category': [],
        'price': [],
    };

    if (searchButton) {
        searchButton.addEventListener('click', event => {
            event.preventDefault();
            performSearch(searchedProducts, searchInput?.value ?? '', searchFilters);
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', event => performSearch(searchedProducts, searchInput.value, searchFilters));
    }
    
    const urlParams = new URLSearchParams(window.location.search);
    performSearch(searchedProducts, urlParams.get('search') ?? '', searchFilters);
}


