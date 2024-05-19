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

async function putData(url: string, data: Object): Promise<Response> {
  return fetch(url, {
    method: 'put',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: encodeForAjax(data),
  });
}

async function patchData(url: string, data: Object): Promise<Response> {
  return fetch(url, {
    method: 'patch',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded',
    },
    body: encodeForAjax(data),
  });
}

async function deleteData(url: string, data: Object): Promise<Response> {
  return fetch(url, {
    method: 'delete',
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

const getLoggedInUserId = (function () {
  let userId: string | null = null;
  
  return async function (): Promise<string | null> {
    if (userId !== null)
      return userId;
    
    return getData('../actions/action_current_user.php')
      .then(response => response.json())
      .then(json => {
        if (json.success) {
          userId = json['user-id'];
          return json['user-id'];
        } else {
          sendToastMessage('User not logged in', 'error');
          return null;
        }
      })
      .catch(error => {
        sendToastMessage('An unexpected error occurred', 'error');
        console.error(error);
        return null;
      });
  }
})();

function getCsrfToken(): string {
  const csrfTokenElement = document.querySelector<HTMLMetaElement>('meta[name="csrf-token"]');
  if (!csrfTokenElement) {
    sendToastMessage('CSRF token not found', 'error');
    return '';
  }
  return csrfTokenElement.content;
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

async function addToWishlist(productId: string, userId: string, csrfToken: string): Promise<boolean> {
	return postData(`../api/wishlist/${userId}/`, {'product': productId, 'csrf': csrfToken})
		.then(response => response.json())
		.then(json => {
			if (json.success) {
				return true;
			} else {
				sendToastMessage(json.error == 'User not logged in' ? 'User not logged in' : "Could not add item to wishlist", "error");
				console.error(json.error);
				return false;
			}
		})
		.catch(error => {
			sendToastMessage("An unexpected error occurred", "error");
			console.error(error);
			return false
		});
}

async function removeFromWishlist(productId: string, sellerId: string, csrfToken: string): Promise<boolean> {
	return deleteData(`../api/wishlist/${sellerId}/${productId}/`, {'csrf': csrfToken})
		.then(response => response.json())
		.then(json => {
			if (json.success) {
				return true;
			} else {
				sendToastMessage(json.error == 'User not logged in' ? 'User not logged in' : "Could not remove item from wishlist", "error");
				console.error(json.error);
				return false;
			}
		})
		.catch(error => {
			sendToastMessage("An unexpected error occurred", "error");
			console.error(error);
			return false;
		});
}

async function likeButtonOnClick(event: Event, likeButtonInput: HTMLInputElement, productId: string, userId: string, csrfToken: string): Promise<void> {
	event.preventDefault();
	event.stopPropagation();
  console.log(event.target);
  console.log(likeButtonInput.checked);
	const response = !likeButtonInput.checked ? addToWishlist(productId, userId, csrfToken) : removeFromWishlist(productId, userId, csrfToken);
	response.then((result) => {
		if (result) likeButtonInput.checked = !likeButtonInput.checked;
	});
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

  productCard.appendChild(productImage);
  productCard.appendChild(productTitle);
  productCard.appendChild(productPrice);

  const loggedInUserId = await getLoggedInUserId();
  if (loggedInUserId !== null && product.seller !== loggedInUserId) {
    const likeButton = drawLikeButton();
    const likeButtonInput = likeButton.querySelector('input');

    if (likeButtonInput && loggedInUserId) {
      console.log(product);
      likeButtonInput.checked = product['in-wishlist'];
      likeButton.addEventListener('click', (event) => likeButtonOnClick(event, likeButtonInput, product.id, loggedInUserId, getCsrfToken()));
    }

    productCard.appendChild(likeButton);
  }

  return productCard;
}

