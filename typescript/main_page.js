var startNowButton = document.getElementById('start-now-button');
if (startNowButton) {
    startNowButton.addEventListener('click', function () {
        location.href = 'actions/go_to_profile.php';
    });
}
