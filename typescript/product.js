var productCards = document.getElementsByClassName("product-card");
for (var i = 0; i < productCards.length; i++) {
    var likeButton = (productCards[i].querySelector(".like-button"));
    likeButton.addEventListener("click", function (event) {
        event.stopPropagation();
        return;
    });
}
function goToProduct(id) {
    window.location.href = "product?id=".concat(id);
}
