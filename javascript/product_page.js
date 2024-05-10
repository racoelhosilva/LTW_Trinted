"use strict";
const prevPhotoButton = document.querySelector('#prev-photo');
const nextPhotoButton = document.querySelector('#next-photo');
const photoBadges = document.querySelectorAll('.photo-badge');
const cartButton = document.querySelector('.add-cart-button');
const addedToCartMessage = document.querySelector('#added-to-cart-message');
const removedFromCartMessage = document.querySelector('#removed-from-cart-message');
let currentIndex = 0;
updatePhotoIndex(currentIndex);
function updatePhotoIndex(index) {
    var _a;
    const photos = (_a = document.getElementById('product-photos')) === null || _a === void 0 ? void 0 : _a.getElementsByTagName('img');
    if (!photos || !photoBadges)
        return;
    currentIndex = index;
    if (currentIndex < 0)
        currentIndex += photos.length;
    else if (currentIndex >= photos.length)
        currentIndex -= photos.length;
    for (let i = 0; i < photos.length; i++) {
        if (i === currentIndex)
            photos[i].style.display = 'block';
        else
            photos[i].style.display = 'none';
    }
    for (let i = 0; i < photoBadges.length; i++) {
        if (i === currentIndex)
            photoBadges[i].classList.add('active');
        else
            photoBadges[i].classList.remove('active');
    }
}
if (prevPhotoButton) {
    prevPhotoButton.addEventListener('click', () => {
        updatePhotoIndex(currentIndex - 1);
    });
}
if (nextPhotoButton) {
    nextPhotoButton.addEventListener('click', () => {
        updatePhotoIndex(currentIndex + 1);
    });
}
if (photoBadges) {
    for (let i = 0; i < photoBadges.length; i++) {
        photoBadges[i].addEventListener('click', () => {
            updatePhotoIndex(i);
        });
    }
}
function updateCartButtonText(cartButton, itemSelected) {
    if (itemSelected)
        cartButton.innerHTML = 'Remove from Cart';
    else
        cartButton.innerHTML = 'Add to Cart';
}
function getCart(postId) {
    return getData('../actions/action_get_cart.php')
        .then(response => response.json());
}
function addItemToCart(postId) {
    return postData('../actions/action_edit_cart.php', { post_id: postId, remove: false })
        .then(response => response.json());
}
function removeItemFromCart(postId) {
    return postData('../actions/action_edit_cart.php', { post_id: postId, remove: true })
        .then(response => response.json());
}
const changeToastMessage = (function () {
    let timer;
    return function (itemAdded, addedToCartMessage, removedFromCartMessage) {
        if (!addedToCartMessage || !removedFromCartMessage)
            return;
        window.clearTimeout(timer);
        if (itemAdded) {
            removedFromCartMessage.classList.remove('show');
            addedToCartMessage.classList.add('show');
            timer = window.setTimeout(() => {
                addedToCartMessage.classList.remove('show');
            }, 5000);
        }
        else {
            addedToCartMessage.classList.remove('show');
            removedFromCartMessage.classList.add('show');
            timer = window.setTimeout(() => {
                removedFromCartMessage.classList.remove('show');
            }, 5000);
        }
    };
})();
if (cartButton) {
    const postId = parseInt(document.location.search.split('=')[1]);
    let itemSelected = false;
    getCart(postId)
        .then(json => {
        const cart = json.cart;
        itemSelected = cart.includes(postId);
        updateCartButtonText(cartButton, itemSelected);
    })
        .catch(error => console.log(error));
    cartButton.addEventListener('click', () => {
        let response = !itemSelected ? addItemToCart(postId) : removeItemFromCart(postId);
        response
            .then(json => {
            if (json.success) {
                itemSelected = !itemSelected;
                updateCartButtonText(cartButton, itemSelected);
                changeToastMessage(itemSelected, addedToCartMessage, removedFromCartMessage);
            }
            else {
                console.log("Error");
            }
        })
            .catch(error => console.log(error));
    });
}
