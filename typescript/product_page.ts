const prevPhotoButton: HTMLElement | null = document.getElementById('prev-photo');
const nextPhotoButton: HTMLElement | null = document.getElementById('next-photo');

let currentIndex: number = 0;
updatePhotoIndex(currentIndex);

function updatePhotoIndex(index: number) : void {
  const photos: HTMLCollectionOf<HTMLImageElement> | undefined = document.getElementById('product-photos')?.getElementsByTagName('img');
  if (!photos)
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