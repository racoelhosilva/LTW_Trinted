const profileButton = document.getElementById('person');

if (profileButton) {
    profileButton.addEventListener('click', () => {
        location.href = 'profile';
    })
}

const settingsButton = document.getElementById('settings');

if (settingsButton) {
    settingsButton.addEventListener('click', () => {
        location.href = 'settings';
    })
}