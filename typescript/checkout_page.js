var orderItemCards = document.querySelectorAll('.order-item-card');
var _loop_1 = function (i) {
    var itemCard = orderItemCards[i];
    var itemImage = itemCard.getElementsByTagName('img')[0];
    itemImage.addEventListener('click', function () {
        window.location.href = "/product?id=".concat(itemCard.dataset.postId);
    });
};
for (var i = 0; i < orderItemCards.length; i++) {
    _loop_1(i);
}
