var profileButton = document.getElementById('person');
if (profileButton) {
    profileButton.addEventListener('click', function () {
        location.href = 'profile';
    });
}
var settingsButton = document.getElementById('settings');
if (settingsButton) {
    settingsButton.addEventListener('click', function () {
        location.href = 'settings';
    });
}
