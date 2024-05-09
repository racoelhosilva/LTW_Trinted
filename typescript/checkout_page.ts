const orderItemCards = document.querySelectorAll<HTMLElement>('.order-item-card');

for (let i = 0; i < orderItemCards.length; i++) {
  const itemCard: HTMLElement = orderItemCards[i];
  const itemImage: HTMLElement = itemCard.getElementsByTagName('img')[0];
  itemImage.addEventListener('click', () => {
    window.location.href = `/product?id=${itemCard.dataset.postId}`;
  });
}

const payNowButton = document.querySelector<HTMLElement>('#pay-now-button');
const checkoutInfoForm = document.querySelector<HTMLFormElement>('#checkout-info-form');
if (payNowButton && checkoutInfoForm) {
  payNowButton.addEventListener('click', (event) => {
    if (!checkoutInfoForm.checkValidity()) {
      checkoutInfoForm.reportValidity();
      return;
    }

    window.setTimeout(() => {
      console.log('Payment successful!');
    }, 2000);
  });
}