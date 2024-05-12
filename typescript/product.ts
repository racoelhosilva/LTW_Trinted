const productCards: HTMLCollectionOf<Element> =
	document.getElementsByClassName("product-card");

for (let i = 0; i < productCards.length; i++) {
	let likeButton = <HTMLInputElement>(
		productCards[i].querySelector(".like-button")
	);
	likeButton.addEventListener("click", (event) => {
		event.stopPropagation();
		return;
	});
}


