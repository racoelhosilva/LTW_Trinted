const searchDrawer: HTMLElement | null = document.querySelector('#search-drawer');
const searchResults: HTMLElement | null = document.querySelector('#search-results');
const searchedProducts: HTMLElement | null = searchResults?.querySelector('#product-section') ?? null;

if (searchDrawer && searchResults && searchedProducts) {
    const searchButton: HTMLElement | null = document.querySelector('#search-button');
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