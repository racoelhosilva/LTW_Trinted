"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
function addToWishlist(productId) {
    return __awaiter(this, void 0, void 0, function* () {
        return postData("../actions/action_edit_wishlist.php", { product_id: productId, remove: false })
            .then(response => response.json())
            .then(json => {
            if (json.success) {
                return true;
            }
            else {
                sendToastMessage(json.error == 'User not logged in' ? 'User not logged in' : "Could not add item to wishlist", "error");
                console.error(json.error);
                return false;
            }
        })
            .catch(error => {
            sendToastMessage("An unexpected error occurred", "error");
            console.error(error);
            return false;
        });
    });
}
function removeFromWishlist(productId) {
    return __awaiter(this, void 0, void 0, function* () {
        return postData("../actions/action_edit_wishlist.php", { product_id: productId, remove: true })
            .then(response => response.json())
            .then(json => {
            if (json.success) {
                return true;
            }
            else {
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
    });
}
const productCards = document.querySelectorAll(".product-card");
productCards.forEach((productCard) => {
    var _a;
    productCard.addEventListener("click", () => goToProduct(productCard.dataset.productId));
    let likeButton = productCard.querySelector(".like-button");
    let likeButtonInput = (_a = likeButton === null || likeButton === void 0 ? void 0 : likeButton.querySelector("input")) !== null && _a !== void 0 ? _a : null;
    if (!likeButton || !likeButtonInput || !productCard.dataset.productId)
        return;
    likeButton.addEventListener("click", (event) => {
        event.stopPropagation();
        event.preventDefault();
        const response = !likeButtonInput.checked ? addToWishlist(productCard.dataset.productId) : removeFromWishlist(productCard.dataset.productId);
        response.then((result) => {
            if (result)
                likeButtonInput.checked = !likeButtonInput.checked;
        });
    });
});
