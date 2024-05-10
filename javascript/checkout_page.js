"use strict";
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
const orderItemsSection = document.querySelector('#order-items');
const payNowButton = document.querySelector('#pay-now-button');
const checkoutInfoForm = document.querySelector('#checkout-info-form');
const checkoutSubtotal = document.querySelector('#checkout-subtotal');
const checkoutShipping = document.querySelector('#checkout-shipping'); // TODO: Implement shipping costs
const checkoutTotal = document.querySelector('#checkout-total');
if (orderItemsSection) {
    getCart()
        .then(json => {
        let subtotal = 0;
        const cart = json.cart;
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