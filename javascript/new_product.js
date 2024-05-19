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
function createProduct(form, files) {
    return __awaiter(this, void 0, void 0, function* () {
        var _a;
        const images = [];
        for (let i = 0; i < files.length; i++) {
            const result = yield uploadImage(files[i], 'posts')
                .then(json => {
                if (json.success) {
                    images.push(`/${json.path}`);
                    return true;
                }
                else {
                    sendToastMessage("An unexpected error occurred", "error");
                    console.error(json.error);
                    return false;
                }
            })
                .catch(error => {
                sendToastMessage("An unexpected error occurred", "error");
                console.error(error);
                return false;
            });
            if (!result)
                return false;
        }
        const formData = convertToObject(new FormData(form));
        let productId;
        try {
            let response = yield postData("/api/product/", {
                title: formData['title'],
                description: formData['description'],
                price: formData['price'],
                category: formData['category'],
                condition: formData['condition'],
                size: formData['size'],
                image: images[0],
                csrf: getCsrfToken(),
            });
            let json = yield response.json();
            if (json.success) {
                productId = json.product.id;
            }
            else {
                sendToastMessage("An unexpected error occurred", "error");
                console.error(json.error);
                return false;
            }
            images.shift();
            response = yield postData(`/api/product/${productId}/images/`, {
                'images[]': images,
                csrf: getCsrfToken(),
            });
            json = yield response.json();
            if (!json.success) {
                sendToastMessage("An unexpected error occurred", "error");
                console.error(json.error);
                return false;
            }
            if (formData['brands'] !== undefined) {
                response = yield putData(`/api/product/${productId}/brands/`, {
                    'brands[]': (_a = formData['brands']) !== null && _a !== void 0 ? _a : [],
                    csrf: getCsrfToken(),
                });
                json = yield response.json();
                if (!json.success) {
                    sendToastMessage("An unexpected error occurred", "error");
                    console.error(json.error);
                    return false;
                }
            }
        }
        catch (error) {
            sendToastMessage("An unexpected error occurred", "error");
            console.error(error);
            return false;
        }
        yield sendToastMessage("Product created successfully", "success");
        document.location.assign(`/product/${productId}`);
        return true;
    });
}
const newProductForm = document.querySelector("#add-product-form");
const newProductButton = document.querySelector("#add-product-button");
const productFileInput = document.querySelector('#product-image-input');
const clearImagesButton = document.querySelector("#clear-product-picture");
console;
if (newProductForm && newProductButton && productFileInput && clearImagesButton) {
    newProductButton.addEventListener('click', () => __awaiter(void 0, void 0, void 0, function* () {
        if (!newProductForm.checkValidity()) {
            newProductForm.reportValidity();
            return;
        }
        yield createProduct(newProductForm, productFileInput.files);
    }));
    clearImagesButton.addEventListener('click', () => {
        productFileInput.value = '';
    });
}
