const prevPhotoButton: HTMLElement | null = document.getElementById('prev-photo');
const nextPhotoButton: HTMLElement | null = document.getElementById('next-photo');

if (prevPhotoButton) {
  prevPhotoButton.addEventListener('click', () => {
    console.log('Previous photo');
  });
}

if (nextPhotoButton) {
  nextPhotoButton.addEventListener('click', () => {
    console.log('Next photo');
  });
}