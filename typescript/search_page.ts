

function performSearch(searchedProducts: HTMLElement, searchQuery: string) {
    getData(`../actions/action_search.php?search=${searchQuery}`)
        .then(response => response.json())
        .then(json => {
            if (json.success) {
                searchedProducts.innerHTML = '';

                const productSectionTitle = document.createElement('h1');
                productSectionTitle.innerHTML = json.posts.length === 0 ? 'No results found' : `Found ${json.posts.length} results`;
                searchedProducts.appendChild(productSectionTitle);

                json.posts.forEach((post: {[key: string]: string}) => {
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

    if (searchButton) {
        searchButton.addEventListener('click', event => {
            event.preventDefault();
            performSearch(searchedProducts, searchInput?.value ?? '');
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
                json.posts.forEach((post: {[key: string]: string}) => {
                    const productCard = drawProductCard(post);
                    searchedProducts.appendChild(productCard);
                    }
                );
            } else {
                sendToastMessage('An unexpected error occurred', 'error');
                console.error(json.error);
            }
        });
    }
}