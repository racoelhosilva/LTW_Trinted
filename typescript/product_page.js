var prevPhotoButton = document.getElementById('prev-photo');
var nextPhotoButton = document.getElementById('next-photo');
var photoBadges = document.getElementsByClassName('photo-badge');
var currentIndex = 0;
updatePhotoIndex(currentIndex);
function updatePhotoIndex(index) {
    var _a;
    var photos = (_a = document.getElementById('product-photos')) === null || _a === void 0 ? void 0 : _a.getElementsByTagName('img');
    if (!photos || !photoBadges)
        return;
    currentIndex = index;
    if (currentIndex < 0)
        currentIndex += photos.length;
    else if (currentIndex >= photos.length)
        currentIndex -= photos.length;
    for (var i = 0; i < photos.length; i++) {
        if (i === currentIndex)
            photos[i].style.display = 'block';
        else
            photos[i].style.display = 'none';
    }
    for (var i = 0; i < photoBadges.length; i++) {
        if (i === currentIndex)
            photoBadges[i].innerHTML = 'radio_button_checked';
        else
            photoBadges[i].innerHTML = 'radio_button_unchecked';
    }
}
if (prevPhotoButton) {
    prevPhotoButton.addEventListener('click', function () {
        updatePhotoIndex(currentIndex - 1);
    });
}
if (nextPhotoButton) {
    nextPhotoButton.addEventListener('click', function () {
        updatePhotoIndex(currentIndex + 1);
    });
}
if (photoBadges) {
    var _loop_1 = function (i) {
        photoBadges[i].addEventListener('click', function () {
            updatePhotoIndex(i);
        });
    };
    for (var i = 0; i < photoBadges.length; i++) {
        _loop_1(i);
    }
}
