"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
function encodeForAjax(data) {
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
    }).join('&');
}
function getData(url) {
    return __awaiter(this, void 0, void 0, function* () {
        return fetch(url);
    });
}
function postData(url, data) {
    return __awaiter(this, void 0, void 0, function* () {
        return fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: encodeForAjax(data),
        });
    });
}
function putData(url, data) {
    return __awaiter(this, void 0, void 0, function* () {
        return fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: encodeForAjax(data),
        });
    });
}
function patchData(url, data) {
    return __awaiter(this, void 0, void 0, function* () {
        return fetch(url, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: encodeForAjax(data),
        });
    });
}
function deleteData(url, data) {
    return __awaiter(this, void 0, void 0, function* () {
        return fetch(url, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: encodeForAjax(data),
        });
    });
}
function convertToObject(formData) {
    let object = {};
    formData.forEach((value, key) => {
        object[key] = value;
    });
    return object;
}
const getLoggedInUserId = (function () {
    let userId = null;
    return function () {
        return __awaiter(this, void 0, void 0, function* () {
            if (userId !== null)
                return userId;
            return getData('../actions/action_current_user.php')
                .then(response => response.json())
                .then(json => {
                if (json.success) {
                    userId = json['user-id'];
                    return json['user-id'];
                }
                else {
                    sendToastMessage('User not logged in', 'error');
                    return null;
                }
            })
                .catch(error => {
                sendToastMessage('An unexpected error occurred', 'error');
                console.error(error);
                return null;
            });
        });
    };
})();
function getCsrfToken() {
    const csrfTokenElement = document.querySelector('meta[name="csrf-token"]');
    if (!csrfTokenElement) {
        sendToastMessage('CSRF token not found', 'error');
        return '';
    }
    return csrfTokenElement.content;
}
const sendToastMessage = (function () {
    let timer;
    return function (message, type) {
        return __awaiter(this, void 0, void 0, function* () {
            const oldToastMessage = document.querySelector('#toast-message');
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
        });
    };
})();
function drawLikeButton() {
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
function goToProduct(id) {
    document.location.assign(`/product/${id}`);
}
function getProductImages(productId) {
    return getData(`/api/product/${productId}/images`)
        .then(response => response.json())
        .then(json => {
        if (json.success) {
            return json.images;
        }
        else {
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
function addToWishlist(productId, userId, csrfToken) {
    return __awaiter(this, void 0, void 0, function* () {
        return postData(`../api/wishlist/${userId}/`, { 'product': productId, 'csrf': csrfToken })
            .then(response => response.json())
            .then(json => {
            if (json.success) {
                return true;
            }
            else {
                sendToastMessage(json.error == 'User not logged in' ? 'User not logged in' : "Could not add item to wishlist", "error");
                console.error(json.error);
                return false;
            }
        })
            .catch(error => {
            sendToastMessage("An unexpected error occurred", "error");
            console.error(error);
            return false;
        });
    });
}
function removeFromWishlist(productId, sellerId, csrfToken) {
    return __awaiter(this, void 0, void 0, function* () {
        return deleteData(`../api/wishlist/${sellerId}/${productId}/`, { 'csrf': csrfToken })
            .then(response => response.json())
            .then(json => {
            if (json.success) {
                return true;
            }
            else {
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
    });
}
function likeButtonOnClick(event, likeButtonInput, productId, userId, csrfToken) {
    return __awaiter(this, void 0, void 0, function* () {
        event.preventDefault();
        event.stopPropagation();
        const response = !likeButtonInput.checked ? addToWishlist(productId, userId, csrfToken) : removeFromWishlist(productId, userId, csrfToken);
        response.then((result) => {
            if (result)
                likeButtonInput.checked = !likeButtonInput.checked;
        });
    });
}
function drawProductCard(product) {
    return __awaiter(this, void 0, void 0, function* () {
        const productCard = document.createElement('div');
        productCard.classList.add('product-card');
        productCard.addEventListener('click', () => goToProduct(product.id));
        const productImage = document.createElement('img');
        productImage.src = (yield getProductImages(product.id))[0];
        productImage.alt = product.title;
        const productTitle = document.createElement('h1');
        productTitle.innerHTML = product.title;
        const productPrice = document.createElement('p');
        productPrice.classList.add('price');
        productPrice.innerHTML = product.price;
        productCard.appendChild(productImage);
        productCard.appendChild(productTitle);
        productCard.appendChild(productPrice);
        const loggedInUserId = yield getLoggedInUserId();
        if (loggedInUserId !== null && product.seller !== loggedInUserId) {
            const likeButton = drawLikeButton();
            const likeButtonInput = likeButton.querySelector('input');
            if (likeButtonInput && loggedInUserId) {
                likeButtonInput.checked = product['in-wishlist'];
                likeButton.addEventListener('click', (event) => likeButtonOnClick(event, likeButtonInput, product.id, loggedInUserId, getCsrfToken()));
            }
            productCard.appendChild(likeButton);
        }
        return productCard;
    });
}
