const prevPhotoButton: HTMLElement | null = document.getElementById('prev-photo');
const nextPhotoButton: HTMLElement | null = document.getElementById('next-photo');
const photoBadges: HTMLCollectionOf<Element> | null = document.getElementsByClassName('photo-badge');

let currentIndex: number = 0;
updatePhotoIndex(currentIndex);

function updatePhotoIndex(index: number) : void {
  const photos: HTMLCollectionOf<HTMLImageElement> | undefined = document.getElementById('product-photos')?.getElementsByTagName('img');
  if (!photos || !photoBadges)
    return;

  currentIndex = index;
  if (currentIndex < 0)
    currentIndex += photos.length;
  else if (currentIndex >= photos.length)
    currentIndex -= photos.length;

  for (let i = 0; i < photos.length; i++) {
    if (i === currentIndex)
      photos[i].style.display = 'block';
    else
      photos[i].style.display = 'none';
  }

  for (let i = 0; i < photoBadges.length; i++) {
    if (i === currentIndex)
      photoBadges[i].innerHTML = 'radio_button_checked'
    else
      photoBadges[i].innerHTML = 'radio_button_unchecked';
  }
}

if (prevPhotoButton) {
  prevPhotoButton.addEventListener('click', () => {
    updatePhotoIndex(currentIndex - 1);
  });
}

if (nextPhotoButton) {
  nextPhotoButton.addEventListener('click', () => {
    updatePhotoIndex(currentIndex + 1);
  });
}

if (photoBadges) {
  for (let i = 0; i < photoBadges.length; i++) {
    photoBadges[i].addEventListener('click', () => {
      updatePhotoIndex(i);
    });
  }
}
