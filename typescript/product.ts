async function addToWishlist(postId: string): Promise<boolean> {
	return postData("../actions/action_edit_wishlist.php", {post_id: postId, remove: false})
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

async function removeFromWishlist(postId: string): Promise<boolean> {
	return postData("../actions/action_edit_wishlist.php", {post_id: postId, remove: true})
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
	let likeButton: HTMLElement | null = productCard.querySelector(".like-button");
	let likeButtonInput: HTMLInputElement | null = likeButton?.querySelector("input") ?? null;
	if (!likeButton || !likeButtonInput || !productCard.dataset.postId)
		return;

	productCard.addEventListener("click", () => goToProduct(productCard.dataset.postId!));
	likeButton.addEventListener("click", (event) => {
		event.stopPropagation();
		event.preventDefault();
		const response = !likeButtonInput.checked ? addToWishlist(productCard.dataset.postId!) : removeFromWishlist(productCard.dataset.postId!);
		response.then((result) => {
			if (result)
				likeButtonInput.checked = !likeButtonInput.checked;
		});
	});
});

