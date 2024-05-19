"use strict";
const startNowButton = document.getElementById('start-now-button');
if (startNowButton) {
    startNowButton.addEventListener('click', () => {
        document.location.assign('/profile');
    });
}
