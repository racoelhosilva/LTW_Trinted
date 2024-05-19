function getCart(): Promise<any> {
  return getData('../actions/action_get_cart.php')
    .then(response => response.json());
}

function addItemToCart(productId: number, csrfToken: string): Promise<any> {
  return postData('../actions/action_edit_cart.php', { 'product-id': productId, remove: false, csrf: csrfToken })
    .then(response => response.json());
}

function removeItemFromCart(productId: number, csrfToken: string): Promise<any> {
  return postData('../actions/action_edit_cart.php', { 'product-id': productId, remove: true, csrf: csrfToken })
    .then(response => response.json());
}

const prevPhotoButton: HTMLElement | null = document.querySelector('#prev-photo');
const nextPhotoButton: HTMLElement | null = document.querySelector('#next-photo');
const photoBadges: NodeListOf<HTMLElement> | null = document.querySelectorAll('.photo-badge');
const cartButton: HTMLElement | null = document.querySelector('.add-cart-button');
const addedToCartMessage: HTMLElement | null = document.querySelector('#added-to-cart-message');
const removedFromCartMessage: HTMLElement | null = document.querySelector('#removed-from-cart-message');

let currentIndex: number = 0;
updatePhotoIndex(currentIndex);

function updatePhotoIndex(index: number) : void {
  const photos: HTMLCollectionOf<HTMLImageElement> | undefined = document.getElementById('product-photos')?.getElementsByTagName('img');
  if (!photos || !photoBadges)
    return;

  currentIndex = index;
  if (currentIndex < 0)
    currentIndex += photos.length;
  else if (currentIndex >= photos.length)
    currentIndex -= photos.length;

  for (let i = 0; i < photos.length; i++) {
    if (i === currentIndex)
      photos[i].style.display = 'block';
    else
      photos[i].style.display = 'none';
  }

  for (let i = 0; i < photoBadges.length; i++) {
    if (i === currentIndex)
      photoBadges[i].classList.add('active');
    else
      photoBadges[i].classList.remove('active');
  }
}

if (prevPhotoButton) {
  prevPhotoButton.addEventListener('click', () => {
    updatePhotoIndex(currentIndex - 1);
  });
}

if (nextPhotoButton) {
  nextPhotoButton.addEventListener('click', () => {
    updatePhotoIndex(currentIndex + 1);
  });
}

if (photoBadges) {
  for (let i = 0; i < photoBadges.length; i++) {
    photoBadges[i].addEventListener('click', () => {
      updatePhotoIndex(i);
    });
  }
}

function updateCartButtonText(cartButton: HTMLElement, itemSelected: boolean): void {
  if (itemSelected)
    cartButton.innerHTML = 'Remove from Cart';
  else
    cartButton.innerHTML = 'Add to Cart';
}

if (cartButton) {
  const productId = parseInt(document.location.pathname.split('/').pop() || '-1');
  let itemSelected = false;

  getCart()
    .then(json => {
      const cart: Array<{ [key: string]: any }> = json.cart;

      itemSelected = cart.map(item => item.id).includes(productId);
      updateCartButtonText(cartButton, itemSelected);
    })
    .catch(error => {
      sendToastMessage('An unexpected error occurred, try again', 'error');
      console.error(error);
    });

  const csrfToken = cartButton.dataset.csrfToken || '';
  cartButton.addEventListener('click', () => {
    let response = !itemSelected ? addItemToCart(productId, csrfToken) : removeItemFromCart(productId, csrfToken);
    response
      .then(json => {
        if (json.success) {
          itemSelected = !itemSelected;
          updateCartButtonText(cartButton, itemSelected);
          sendToastMessage(itemSelected ? 'Added to cart' : 'Removed from cart', 'success');
        } else {
          sendToastMessage('Could not ' + (!itemSelected ? 'add item to cart' : 'remove item from cart'), 'error');
        }
      })
      .catch(error => {
        sendToastMessage('An unexpected error occurred, try again', 'error');
        console.error(error);
      });
  });
}
