async function addToWishlist(productId: string): Promise<boolean> {
	return postData("../actions/action_edit_wishlist.php", {'product-id': productId, remove: false})
		.then(response => response.json())
		.then(json => {
			if (json.success) {
				return true;
			} else {
				sendToastMessage(json.error == 'User not logged in' ? 'User not logged in' : "Could not add item to wishlist", "error");
				console.error(json.error);
				return false;
			}
		})
		.catch(error => {
			sendToastMessage("An unexpected error occurred", "error");
			console.error(error);
			return false
		});
}

async function removeFromWishlist(productId: string): Promise<boolean> {
	return postData("../actions/action_edit_wishlist.php", {'product-id': productId, remove: true})
		.then(response => response.json())
		.then(json => {
			if (json.success) {
				return true;
			} else {
				sendToastMessage(json.error == 'User not logged in' ? 'User not logged in' : "Could not remove item from wishlist", "error");
				console.error(json.error);
				return false;
			}
		})
		.catch(error => {
			sendToastMessage("An unexpected error occurred", "error");
			console.error(error);
			return false;
		});
}

const productCards: NodeListOf<HTMLElement> = document.querySelectorAll(".product-card");

productCards.forEach((productCard) => {
	productCard.addEventListener("click", () => goToProduct(productCard.dataset.productId!));

	let likeButton: HTMLElement | null = productCard.querySelector(".like-button");
	let likeButtonInput: HTMLInputElement | null = likeButton?.querySelector("input") ?? null;
	if (!likeButton || !likeButtonInput || !productCard.dataset.productId)
		return;
	likeButton.addEventListener("click", (event) => {
		event.stopPropagation();
		event.preventDefault();
		const response = !likeButtonInput.checked ? addToWishlist(productCard.dataset.productId!) : removeFromWishlist(productCard.dataset.productId!);
		response.then((result) => {
			if (result)
				likeButtonInput.checked = !likeButtonInput.checked;
		});
	});
});

