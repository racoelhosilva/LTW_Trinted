const profileButton = document.getElementById('person');

if (profileButton) {
    profileButton.addEventListener('click', () => {
        location.href = 'actions/go_to_profile.php';
    })
}

const checkoutButton = document.getElementById('shopping_cart');

if (checkoutButton) {
    checkoutButton.addEventListener('click', () => {
        location.href = 'checkout';
    })
}

const settingsButton = document.getElementById('settings');

if (settingsButton) {
    settingsButton.addEventListener('click', () => {
        location.href = 'settings';
    })
}