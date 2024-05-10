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

function getCart(postId: number): Promise<any> {
  return getData('../actions/action_get_cart.php')
    .then(response => response.json());
}

function addItemToCart(postId: number): Promise<any> {
  return postData('../actions/action_edit_cart.php', { post_id: postId, remove: false })
    .then(response => response.json());
}

function removeItemFromCart(postId: number): Promise<any> {
  return postData('../actions/action_edit_cart.php', { post_id: postId, remove: true })
    .then(response => response.json());
}

if (cartButton) {
  const postId = parseInt(document.location.search.split('=')[1]);
  let itemSelected = false;

  getCart(postId)
    .then(json => {
      const cart: Array<number> = json.cart;

      itemSelected = cart.includes(postId);
      updateCartButtonText(cartButton, itemSelected);
    })
    .catch(error => console.log(error));

  cartButton.addEventListener('click', () => {
    let response = !itemSelected ? addItemToCart(postId) : removeItemFromCart(postId);
    response
      .then(json => {
        if (json.success) {
          itemSelected = !itemSelected;
          updateCartButtonText(cartButton, itemSelected);
          sendToastMessage(itemSelected ? 'Added to cart' : 'Removed from cart', 'success');
        } else {
          console.log("Error");
        }
      })
      .catch(error => console.log(error));
  });
}
