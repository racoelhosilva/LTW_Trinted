const startNowButton = document.getElementById('start-now-button');


if (startNowButton) {
    startNowButton.addEventListener('click', () => {
        location.href = 'profile';
    })
}
