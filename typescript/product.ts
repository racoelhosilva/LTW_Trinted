const productCards: NodeListOf<HTMLElement> = document.querySelectorAll(".product-card");

productCards.forEach((productCard) => {
	
	let likeButton: HTMLInputElement | null = productCard.querySelector(".like-button");
	if (!likeButton || !productCard.dataset.postId)
		return;

	productCard.addEventListener("click", () => goToProduct(productCard.dataset.postId!));
	likeButton.addEventListener("click", (event) => {
		event.stopPropagation();
		return;
	});
});

