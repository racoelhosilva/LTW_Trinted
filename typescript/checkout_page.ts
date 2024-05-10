const orderItemCards = document.querySelectorAll<HTMLElement>('.order-item-card');

for (let i = 0; i < orderItemCards.length; i++) {
  const itemCard: HTMLElement = orderItemCards[i];
  const itemImage: HTMLElement = itemCard.getElementsByTagName('img')[0];
  itemImage.addEventListener('click', () => {
    window.location.href = `/product?id=${itemCard.dataset.postId}`;
  });
}

const payNowButton = document.querySelector<HTMLButtonElement>('#pay-now-button');
const checkoutInfoForm = document.querySelector<HTMLFormElement>('#checkout-info-form');
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