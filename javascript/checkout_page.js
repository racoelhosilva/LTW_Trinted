"use strict";
const orderItemCards = document.querySelectorAll('.order-item-card');
for (let i = 0; i < orderItemCards.length; i++) {
    const itemCard = orderItemCards[i];
    const itemImage = itemCard.getElementsByTagName('img')[0];
    itemImage.addEventListener('click', () => {
        window.location.href = `/product?id=${itemCard.dataset.postId}`;
    });
}
const payNowButton = document.querySelector('#pay-now-button');
const checkoutInfoForm = document.querySelector('#checkout-info-form');
const paymentSuccessfulMessage = document.querySelector('#payment-success-message');
if (payNowButton && checkoutInfoForm && paymentSuccessfulMessage) {
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
            loadingSpinner.replaceWith(payNowButton);
            paymentSuccessfulMessage.classList.add('show');
            window.setTimeout(() => {
                paymentSuccessfulMessage.classList.remove('show');
                checkoutInfoForm.submit();
            }, 5000);
        }, 2000);
    });
}
