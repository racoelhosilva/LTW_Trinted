"use strict";
const prevPhotoButton = document.getElementById('prev-photo');
const nextPhotoButton = document.getElementById('next-photo');
const photoBadges = document.getElementsByClassName('photo-badge');
const cartButton = document.querySelector('.add-cart-button');
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
if (cartButton) {
    const postId = document.location.search.split('=')[1];
    getData('../actions/action_get_cart.php')
        .then(response => response.json())
        .then(json => {
        const cart = json.items;
        const postIds = Array.from(cart.map((item) => item.id));
        console.log(postIds);
        if (postIds.includes(parseInt(postId)))
            cartButton.innerHTML = 'Remove from Cart';
        else
            cartButton.innerHTML = 'Add to Cart';
    });
    cartButton.addEventListener('click', () => {
        postData('../actions/action_edit_cart.php', { post_id: postId })
            .then(response => response.json())
            .then(json => console.log(json))
            .catch(error => console.error('Error:', error));
    });
}
