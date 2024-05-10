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

async function submitCheckoutForm(checkoutForm: HTMLFormElement): Promise<any> {
  return postData(checkoutForm.action, convertToObject(new FormData(checkoutForm)))
    .then(response => response.json());
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
      if (json.success) {
        let subtotal: number = 0;

        const cart: Array<{ [key: string]: any }> = json.cart;
        for (const post of cart) {
          const orderItemCard = createOrderItemCard(post);
          orderItemsSection.appendChild(orderItemCard);
          subtotal += post.price;
        }

        if (checkoutSubtotal && checkoutTotal)
          updateTotal(checkoutSubtotal, checkoutTotal, subtotal);
      } else {
        sendToastMessage('Could not get cart, try again later', 'error');
        console.error(json.error);
      }
    })
    .catch((error) => {
      sendToastMessage('An unexpected error occurred', 'error');
      console.error(error);
    });
}

if (payNowButton && checkoutInfoForm) {
  payNowButton.addEventListener('click', () => {
    if (!checkoutInfoForm.checkValidity()) {
      checkoutInfoForm.reportValidity();
      return;
    }

    const loadingSpinner = document.createElement('div');
    loadingSpinner.classList.add('spinner');
    loadingSpinner.appendChild(document.createElement('div'));
    payNowButton.replaceWith(loadingSpinner);

    window.setTimeout(async () => {
      loadingSpinner.replaceWith(payNowButton);

      submitCheckoutForm(checkoutInfoForm)
        .then(async json => {
          if (json.success) {
            payNowButton.disabled = true;
            await sendToastMessage('Payment successful!', 'success');
            document.location.assign('/');
          } else {
            sendToastMessage('Could not checkout, try again later', 'error');
            console.error(json.error);
          }
        })
        .catch((error) => {
          sendToastMessage('An unexpected error occurred', 'error');
          console.error(error);
        });
    }, 2000);
  });
}