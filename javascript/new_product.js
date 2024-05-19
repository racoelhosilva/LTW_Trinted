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
        const formData = new FormData(form);
        let productId;
        try {
            let response = yield postData("/api/product/", {
                title: formData.get('title'),
                description: formData.get('description'),
                price: formData.get('price'),
                category: formData.get('category'),
                condition: formData.get('condition'),
                size: formData.get('size'),
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
            let data = { csrf: getCsrfToken() };
            for (let i = 0; i < images.length; i++)
                data[`images[${i}]`] = images[i];
            response = yield postData(`/api/product/${productId}/images/`, data);
            json = yield response.json();
            if (!json.success) {
                sendToastMessage("An unexpected error occurred", "error");
                console.error(json.error);
                return false;
            }
            if (formData.getAll('brands') !== undefined) {
                const brands = formData.getAll('brands');
                data = { csrf: getCsrfToken() };
                for (let i = 0; i < brands.length; i++)
                    data[`brands[${i}]`] = brands[i];
                response = yield putData(`/api/product/${productId}/brands/`, data);
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
        document.location.assign(`/product/${productId}/`);
        return true;
    });
}
const newProductForm = document.querySelector("#add-product-form");
const newProductButton = document.querySelector("#add-product-button");
const productFileInput = document.querySelector('#product-image-input');
const clearImagesButton = document.querySelector("#clear-product-images");
if (newProductForm && newProductButton && productFileInput && clearImagesButton) {
    newProductButton.addEventListener('click', () => __awaiter(void 0, void 0, void 0, function* () {
        if (!newProductForm.checkValidity()) {
            newProductForm.reportValidity();
            return;
        }
        newProductButton.disabled = true;
        yield createProduct(newProductForm, productFileInput.files);
        newProductButton.disabled = false;
    }));
    clearImagesButton.addEventListener('click', () => {
        productFileInput.value = '';
    });
}
