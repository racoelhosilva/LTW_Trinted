const orderItemCards = document.querySelectorAll<HTMLElement>('.order-item-card');

for (let i = 0; i < orderItemCards.length; i++) {
  const itemCard: HTMLElement = orderItemCards[i];
  const itemImage: HTMLElement = itemCard.getElementsByTagName('img')[0];
  itemImage.addEventListener('click', () => {
    window.location.href = `/product?id=${itemCard.dataset.postId}`;
  });
}