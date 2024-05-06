const productCards: HTMLCollectionOf<Element> = document.getElementsByClassName('product-card');

for (let i = 0; i < productCards.length; i++) {
  productCards[i].addEventListener('click', () => {
    location.href = '/product?id=' + i;
  });

  let likeButton = <HTMLInputElement> productCards[i].querySelector('.like-button');
  likeButton.addEventListener('click', (event) => {
    event.stopPropagation();
    return;
  });
}