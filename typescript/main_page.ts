const startNowButton = document.getElementById('start-now-button');

if (startNowButton) {
    startNowButton.addEventListener('click', () => {
        document.location.assign('/actions/go_to_profile.php');
    })
}
