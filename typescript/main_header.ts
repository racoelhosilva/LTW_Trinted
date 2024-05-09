const profileButton = document.getElementById('person');

if (profileButton) {
    profileButton.addEventListener('click', () => {
        location.href = 'profile';
    })
}

const checkoutButton = document.getElementById('shopping_cart');

if (checkoutButton) {
    checkoutButton.addEventListener('click', () => {
        location.href = 'checkout';
    })
}