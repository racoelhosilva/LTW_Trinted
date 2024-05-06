const profileButton = document.getElementById('person');

if (profileButton) {
    profileButton.addEventListener('click', () => {
        location.href = 'profile';
    })
}