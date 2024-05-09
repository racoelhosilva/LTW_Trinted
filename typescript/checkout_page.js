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
var payNowButton = document.querySelector('#pay-now-button');
var checkoutInfoForm = document.querySelector('#checkout-info-form');
var paymentSuccessfulMessage = document.querySelector('#payment-successful-message');
if (payNowButton && checkoutInfoForm && paymentSuccessfulMessage) {
    payNowButton.addEventListener('click', function (event) {
        // if (!checkoutInfoForm.checkValidity()) {
        //   checkoutInfoForm.reportValidity();
        //   return;
        // }
        var payNowButtonClone = payNowButton.cloneNode(true);
        var loadingSpinner = document.createElement('div');
        loadingSpinner.classList.add('spinner');
        loadingSpinner.appendChild(document.createElement('div'));
        payNowButton.replaceWith(loadingSpinner);
        window.setTimeout(function () {
            loadingSpinner.replaceWith(payNowButton);
            paymentSuccessfulMessage.classList.add('show');
            window.setTimeout(function () {
                paymentSuccessfulMessage.classList.remove('show');
                document.location.assign('/');
            }, 5000);
        }, 2000);
    });
}
