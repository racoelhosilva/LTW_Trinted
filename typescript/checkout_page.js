"use strict";
const orderItemCards = document.querySelectorAll('.order-item-card');
for (let i = 0; i < orderItemCards.length; i++) {
    const itemCard = orderItemCards[i];
    const itemImage = itemCard.getElementsByTagName('img')[0];
    itemImage.addEventListener('click', () => {
        window.location.href = `/product?id=${itemCard.dataset.postId}`;
    });
}
