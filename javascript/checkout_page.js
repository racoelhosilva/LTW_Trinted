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
            loadingSpinner.replaceWith(payNowButton);
            sendToastMessage('Payment successful!', 'success')
                .then(() => checkoutInfoForm.submit());
        }, 2000);
    });
}
