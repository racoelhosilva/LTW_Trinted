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
            method: 'post',
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
function onLikeButtonClick(event) {
    event.stopPropagation();
    return;
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
        const likeButton = drawLikeButton();
        likeButton.addEventListener('click', onLikeButtonClick);
        productCard.appendChild(productImage);
        productCard.appendChild(productTitle);
        productCard.appendChild(productPrice);
        productCard.appendChild(likeButton);
        return productCard;
    });
}
