var productCards = document.getElementsByClassName('product-card');
var _loop_1 = function (i) {
    productCards[i].addEventListener('click', function () {
        location.href = '/product?id=' + i;
    });
    var likeButton = productCards[i].querySelector('.like-button');
    likeButton.addEventListener('click', function (event) {
        event.stopPropagation();
        return;
    });
};
for (var i = 0; i < productCards.length; i++) {
    _loop_1(i);
}
