"use strict";
const productCards = document.getElementsByClassName("product-card");
for (let i = 0; i < productCards.length; i++) {
    let likeButton = (productCards[i].querySelector(".like-button"));
    likeButton.addEventListener("click", (event) => {
        event.stopPropagation();
        return;
    });
}
function goToProduct(id) {
    window.location.href = "product?id=".concat(id);
}
