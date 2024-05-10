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
function itemCardOnClick(event, postId) {
    document.location.assign(`/product?id=${postId}`);
}
function createOrderItemCard(post) {
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
function updateTotal(checkoutSubtotal, checkoutTotal, subtotal) {
    checkoutSubtotal.innerHTML = subtotal.toFixed(2);
    checkoutTotal.innerHTML = (subtotal + 10).toFixed(2);
}
function submitCheckoutForm(checkoutForm) {
    return __awaiter(this, void 0, void 0, function* () {
        return postData(checkoutForm.action, convertToObject(new FormData(checkoutForm)))
            .then(response => response.json());
    });
}
const orderItemsSection = document.querySelector('#order-items');
const payNowButton = document.querySelector('#pay-now-button');
const checkoutInfoForm = document.querySelector('#checkout-info-form');
const checkoutSubtotal = document.querySelector('#checkout-subtotal');
const checkoutShipping = document.querySelector('#checkout-shipping'); // TODO: Implement shipping costs
const checkoutTotal = document.querySelector('#checkout-total');
if (orderItemsSection) {
    getCart()
        .then(json => {
        if (json.success) {
            let subtotal = 0;
            const cart = json.cart;
            for (const post of cart) {
                const orderItemCard = createOrderItemCard(post);
                orderItemsSection.appendChild(orderItemCard);
                subtotal += post.price;
            }
            if (checkoutSubtotal && checkoutTotal)
                updateTotal(checkoutSubtotal, checkoutTotal, subtotal);
        }
        else {
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
        window.setTimeout(() => __awaiter(void 0, void 0, void 0, function* () {
            loadingSpinner.replaceWith(payNowButton);
            submitCheckoutForm(checkoutInfoForm)
                .then((json) => __awaiter(void 0, void 0, void 0, function* () {
                if (json.success) {
                    payNowButton.disabled = true;
                    yield sendToastMessage('Payment successful!', 'success');
                    document.location.assign('/');
                }
                else {
                    sendToastMessage('Could not checkout, try again later', 'error');
                    console.error(json.error);
                }
            }))
                .catch((error) => {
                sendToastMessage('An unexpected error occurred', 'error');
                console.error(error);
            });
        }), 2000);
    });
}
