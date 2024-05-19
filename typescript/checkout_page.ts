async function createOrderItemCard(product: { [key: string]: any }): Promise<HTMLElement> {
  const orderItemCard = document.createElement('div');
  orderItemCard.classList.add('order-item-card');

  const image = document.createElement('img');
  image.src = (await getProductImages(product.id))[0];
  image.alt = 'Product Image';
  orderItemCard.appendChild(image);

  image.addEventListener('click', (event) => goToProduct(product.id));

  const itemInfo = document.createElement('div');
  orderItemCard.appendChild(itemInfo);

  const itemTitle = document.createElement('h1');
  itemTitle.innerHTML = product.title;
  itemInfo.appendChild(itemTitle);

  const itemDetails = document.createElement('p');
  const itemDetailsText = [product.size, product.condition].filter(detail => detail).join(' - ');
  if (itemDetailsText !== '') {
    itemDetails.innerHTML = itemDetailsText;
    itemInfo.appendChild(itemDetails);
  } 

  const itemPrice = document.createElement('p');
  itemPrice.classList.add('price');
  itemPrice.innerHTML = `${product.price}`;
  orderItemCard.appendChild(itemPrice);

  return orderItemCard;
}

function updateTotal(checkoutSubtotal: HTMLElement, checkoutShipping: HTMLElement, checkoutTotal: HTMLElement,
  shippingInput: HTMLInputElement, subtotal: number, shipping: number): void {
  checkoutSubtotal.innerHTML = subtotal.toFixed(2);
  if (shipping >= 0) {
    checkoutShipping.innerHTML = shipping.toFixed(2);
    checkoutShipping.classList.add('price');
    checkoutTotal.innerHTML = (subtotal + shipping).toFixed(2);
    checkoutTotal.classList.add('price');
    shippingInput.value = shipping.toFixed(2);
  } else {
    checkoutShipping.innerHTML = checkoutTotal.innerHTML = '-';
    checkoutShipping.classList.remove('price');
    checkoutTotal.classList.remove('price');
    shippingInput.value = '0.00';
  }
}

async function getShippingCost(checkoutForm: HTMLFormElement): Promise<number> {
  const formData = convertToObject(new FormData(checkoutForm));
  if (formData.address && formData.zip && formData.town && formData.country) {
    return getData(`/actions/action_shipping.php?address=${formData.address}&zip=${formData.zip}&town=${formData.town}&country=${formData.country}`)
      .then(response => response.json())
      .then(json => {
        if (json.success) {
          return json.shipping;
        } else {
          sendToastMessage('An unexpected error occurred', 'error');
          console.error(json.error);
          return -1;
        }
      })
      .catch(error => {
        sendToastMessage('An unexpected error occurred', 'error');
        console.error(error);
        return -1;
      });
  } else {
    return -1;
  }
};

async function submitCheckoutForm(checkoutForm: HTMLFormElement): Promise<any> {
  return postData(checkoutForm.action, convertToObject(new FormData(checkoutForm)))
    .then(response => response.json());
}

const orderItemsSection: HTMLElement | null = document.querySelector('#order-items');
const payNowButton: HTMLButtonElement | null = document.querySelector('#pay-now-button');
const checkoutInfoForm: HTMLFormElement | null = document.querySelector('#checkout-info-form');
const checkoutSubtotal: HTMLElement | null = document.querySelector('#checkout-subtotal');
const checkoutShipping: HTMLElement | null = document.querySelector('#checkout-shipping');
const checkoutTotal: HTMLElement | null = document.querySelector('#checkout-total');
const shippingInput: HTMLInputElement | null = checkoutInfoForm?.querySelector('input[name="shipping"]') ?? null;
let subtotal: number = 0;

if (orderItemsSection && payNowButton && checkoutInfoForm && checkoutSubtotal && checkoutShipping && checkoutTotal && shippingInput) {
  getCart()
    .then(async json => {
      if (json.success) {
        const cart: Array<{ [key: string]: any }> = json.cart;
        for (const product of cart) {
          const orderItemCard = createOrderItemCard(product);
          orderItemsSection.appendChild(await orderItemCard);
          subtotal += product.price;
        }

        if (checkoutSubtotal && checkoutShipping && checkoutTotal)
          updateTotal(checkoutSubtotal, checkoutShipping, checkoutTotal, shippingInput, subtotal, -1);
      } else {
        sendToastMessage('Could not get cart, try again later', 'error');
        console.error(json.error);
      }
    })
    .catch((error) => {
      sendToastMessage('An unexpected error occurred', 'error');
      console.error(error);
    });
  
  const formInputs: NodeListOf<HTMLElement> = checkoutInfoForm.querySelectorAll('input');
  formInputs.forEach(formInput => {
    formInput.addEventListener('blur', () => {
      getShippingCost(checkoutInfoForm)
        .then(shipping => updateTotal(checkoutSubtotal, checkoutShipping, checkoutTotal, shippingInput, subtotal, shipping));
    });
  });

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