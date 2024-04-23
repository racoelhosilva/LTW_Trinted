var prevPhotoButton = document.getElementById('prev-photo');
var nextPhotoButton = document.getElementById('next-photo');
if (prevPhotoButton) {
    prevPhotoButton.addEventListener('click', function () {
        console.log('Previous photo');
    });
}
if (nextPhotoButton) {
    nextPhotoButton.addEventListener('click', function () {
        console.log('Next photo');
    });
}
