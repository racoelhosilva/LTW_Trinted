function itemCardOnClick(event: MouseEvent, postId: number): void {
  document.location.assign(`/product?id=${postId}`);
}

function createOrderItemCard(post: { [key: string]: any }): HTMLElement {
  const orderItemCard = document.createElement('div');
  orderItemCard.classList.add('order-item-card');

  const image = document.createElement('img');
  image.src = post.images[0];
  image.alt = 'Product Image';
  orderItemCard.appendChild(image);

  image.addEventListener('click', (event) => itemCardOnClick(event, post.id));

  const itemTitle = document.createElement('h1');
  itemTitle.innerHTML = post.title;

  const itemDetails = document.createElement('p');
  itemDetails.innerHTML = `${post.size} - ${post.condition}`;

  const itemInfo = document.createElement('div');
  itemInfo.appendChild(itemTitle);
  itemInfo.appendChild(itemDetails);
  orderItemCard.appendChild(itemInfo);

  const itemPrice = document.createElement('p');
  itemPrice.classList.add('price');
  itemPrice.innerHTML = `${post.price}`;
  orderItemCard.appendChild(itemPrice);

  return orderItemCard;
}

function updateTotal(checkoutSubtotal: HTMLElement, checkoutTotal: HTMLElement, subtotal: number): void {
  checkoutSubtotal.innerHTML = subtotal.toFixed(2);
  checkoutTotal.innerHTML = (subtotal + 10).toFixed(2);
}

const orderItemsSection: HTMLElement | null = document.querySelector('#order-items');
const payNowButton: HTMLButtonElement | null = document.querySelector('#pay-now-button');
const checkoutInfoForm: HTMLFormElement | null = document.querySelector('#checkout-info-form');
const checkoutSubtotal: HTMLElement | null = document.querySelector('#checkout-subtotal');
const checkoutShipping: HTMLElement | null = document.querySelector('#checkout-shipping');  // TODO: Implement shipping costs
const checkoutTotal: HTMLElement | null = document.querySelector('#checkout-total');

if (orderItemsSection) {
  getCart()
    .then(json => {
      let subtotal: number = 0;

      const cart: Array<{ [key: string]: any }> = json.cart;
      for (const post of cart) {
        const orderItemCard = createOrderItemCard(post);
        orderItemsSection.appendChild(orderItemCard);
        subtotal += post.price;
      }

      if (checkoutSubtotal && checkoutTotal)
        updateTotal(checkoutSubtotal, checkoutTotal, subtotal);
    });
}

if (payNowButton && checkoutInfoForm) {
  payNowButton.addEventListener('click', (event) => {
    if (!checkoutInfoForm.checkValidity()) {
      checkoutInfoForm.reportValidity();
      return;
    }

    const loadingSpinner = document.createElement('div');
    loadingSpinner.classList.add('spinner');
    loadingSpinner.appendChild(document.createElement('div'));
    payNowButton.replaceWith(loadingSpinner);

    window.setTimeout(() => {
      payNowButton.disabled = true;
      loadingSpinner.replaceWith(payNowButton);

      sendToastMessage('Payment successful!', 'success')
        .then(() => checkoutInfoForm.submit());
    }, 2000);
  });
}