function encodeForAjax(data: {[key: string]: any}): string {
  return Object.keys(data).map(function(k: string){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}

async function getData(url: string): Promise<Response> {
  return fetch(url);
}

async function postData(url: string, data: Object): Promise<Response> {
  return fetch(url, {
    method: 'post',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: encodeForAjax(data),
  });
}

function convertToObject(formData: FormData): {[key: string]: any} {
  let object: {[key: string]: any} = {};
  formData.forEach((value, key) => {
    object[key] = value;
  });
  return object;
}

const sendToastMessage = (function () {
  let timer: number;
  
  return async function (message: string, type: string): Promise<void> {
    const oldToastMessage = document.querySelector<HTMLElement>('#toast-message');
    if (oldToastMessage)
      oldToastMessage.remove();
    window.clearTimeout(timer);

    let icon = document.createElement('span');
    icon.classList.add('material-symbols-outlined');

    switch (type) {
      case 'success':
        icon.innerHTML = 'check';
        break;
      
      case 'error':
        icon.innerHTML = 'error';
        break;

      default:
        throw new Error(`Invalid toast message type "${type}"`);
    }

    const toastMessage = document.createElement('div');
    toastMessage.id = 'toast-message';
    document.body.appendChild(toastMessage);

    toastMessage.classList.add(type);
    toastMessage.appendChild(icon);
    toastMessage.innerHTML += message;

    return new Promise((resolve) => window.setTimeout(resolve, 5000))
      .then(() => toastMessage.remove());
  }
})();

function drawLikeButton(): HTMLElement {
  const likeButton = document.createElement('div');
  likeButton.classList.add('like-button');

  const label = document.createElement('label');
  label.classList.add('material-symbols-outlined');

  const input = document.createElement('input');
  input.type = 'checkbox';

  label.appendChild(input);
  label.innerHTML += 'favorite_border';

  likeButton.appendChild(label);

  return likeButton;
}

function goToProduct(id: string): void {
	document.location.assign(`/product/${id}`);
}

function getProductImages(productId: number): Promise<string[]> {
  return getData(`/api/product/${productId}/images`)
    .then(response => response.json())
    .then(json => {
      if (json.success) {
        return json.images;
      } else {
        sendToastMessage('An unexpected error occurred', 'error');
        console.error(json.error);
        return [];
      }
    })
    .catch(error => {
      sendToastMessage('An unexpected error occurred', 'error');
      console.error(error);
      return [];
    });
}



function onLikeButtonClick(event: Event): void {
  event.stopPropagation();
  return;
}

async function drawProductCard(product: {[key: string]: any}): Promise<HTMLElement> {
  const productCard = document.createElement('div');
  productCard.classList.add('product-card');

  productCard.addEventListener('click', () => goToProduct(product.id));

  const productImage = document.createElement('img');
  productImage.src = (await getProductImages(product.id))[0];
  productImage.alt = product.title;

  const productTitle = document.createElement('h1');
  productTitle.innerHTML = product.title;

  const productPrice = document.createElement('p');
  productPrice.classList.add('price');
  productPrice.innerHTML = product.price;

  const likeButton = drawLikeButton();
  likeButton.addEventListener('click', onLikeButtonClick);

  productCard.appendChild(productImage);
  productCard.appendChild(productTitle);
  productCard.appendChild(productPrice);
  productCard.appendChild(likeButton);

  return productCard;
}

