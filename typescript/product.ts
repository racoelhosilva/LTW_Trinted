const productCards: NodeListOf<HTMLElement> = document.querySelectorAll(".product-card");
const likeButtons: NodeListOf<HTMLElement> = document.querySelectorAll(".like-button");

productCards.forEach(async (productCard) => {
	productCard.addEventListener("click", () => goToProduct(productCard.dataset.productId!));
});

likeButtons.forEach(async (likeButton) => {
	let likeButtonInput: HTMLInputElement | null = likeButton?.querySelector("input") ?? null;
	const productId = likeButton.dataset.productId;
	const loggedInUserId = await getLoggedInUserId();

	if (!likeButtonInput || !productId || !loggedInUserId)
		return;
	likeButton.addEventListener("click", async (event) => await likeButtonOnClick(event, likeButtonInput, productId, loggedInUserId,  getCsrfToken()));
});
