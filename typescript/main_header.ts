const profileButton = document.getElementById('person');

if (profileButton) {
    profileButton.addEventListener('click', () => {
        document.location.assign('/profile/');
    })
}

const checkoutButton = document.getElementById('shopping_cart');

if (checkoutButton) {
    checkoutButton.addEventListener('click', () => {
        document.location.assign('/checkout/');
    })
}

const settingsButton = document.getElementById('settings');

if (settingsButton) {
    settingsButton.addEventListener('click', () => {
        document.location.assign('/settings/');
    })
}

const messagesHeaderButton = document.getElementById('message');

if (messagesHeaderButton) {
    messagesHeaderButton.addEventListener('click', () => {
        document.location.assign(`/messages/`);
    })
}

const dashboardButton = document.getElementById('dashboard');

if (dashboardButton) {
    dashboardButton.addEventListener('click', () => {
        document.location.assign(`/dashboard/`);
    })
}
