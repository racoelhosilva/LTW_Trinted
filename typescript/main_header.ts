const profileButton = document.getElementById('person');

if (profileButton) {
    profileButton.addEventListener('click', () => {
        document.location.assign('/actions/go_to_profile.php');
    })
}

const checkoutButton = document.getElementById('shopping_cart');

if (checkoutButton) {
    checkoutButton.addEventListener('click', () => {
        document.location.assign('/checkout');
    })
}

const settingsButton = document.getElementById('settings');

if (settingsButton) {
    settingsButton.addEventListener('click', () => {
        location.href = 'settings';
    })
}

const messagesHeaderButton = document.getElementById('message');

if (messagesHeaderButton) {
    messagesHeaderButton.addEventListener('click', () => {
        document.location.assign(`/messages`);
    })
}
