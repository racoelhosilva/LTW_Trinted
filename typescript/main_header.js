var profileButton = document.getElementById('person');
if (profileButton) {
    profileButton.addEventListener('click', function () {
        location.href = 'actions/go_to_profile.php';
    });
}
var checkoutButton = document.getElementById('shopping_cart');
if (checkoutButton) {
    checkoutButton.addEventListener('click', function () {
        location.href = 'checkout';
    });
}
var settingsButton = document.getElementById('settings');
if (settingsButton) {
    settingsButton.addEventListener('click', function () {
        location.href = 'settings';
    });
}
