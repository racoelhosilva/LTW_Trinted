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
const editProductButton = document.getElementById('edit-product-button');
if (editProductButton) {
    editProductButton.addEventListener('click', () => {
        document.location.assign(`/edit-product/${editProductButton.dataset.productId}/`);
    });
}
const productCards = document.querySelectorAll(".product-card");
const likeButtons = document.querySelectorAll(".like-button");
productCards.forEach((productCard) => __awaiter(void 0, void 0, void 0, function* () {
    productCard.addEventListener("click", () => goToProduct(productCard.dataset.productId));
}));
likeButtons.forEach((likeButton) => __awaiter(void 0, void 0, void 0, function* () {
    var _a;
    let likeButtonInput = (_a = likeButton === null || likeButton === void 0 ? void 0 : likeButton.querySelector("input")) !== null && _a !== void 0 ? _a : null;
    const productId = likeButton.dataset.productId;
    const loggedInUserId = yield getLoggedInUserId();
    if (!likeButtonInput || !productId || !loggedInUserId)
        return;
    likeButton.addEventListener("click", (event) => __awaiter(void 0, void 0, void 0, function* () { return yield likeButtonOnClick(event, likeButtonInput, productId, loggedInUserId, getCsrfToken()); }));
}));
