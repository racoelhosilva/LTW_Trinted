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
function updateProduct(productId, form, files) {
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
        try {
            let response = yield patchData(`/api/product/${productId}/`, {
                title: formData.get('title'),
                description: formData.get('description'),
                price: formData.get('price'),
                category: formData.get('category'),
                condition: formData.get('condition'),
                size: formData.get('size'),
                csrf: getCsrfToken(),
            });
            let json = yield response.json();
            if (!json.success) {
                sendToastMessage("An unexpected error occurred", "error");
                console.error(json.error);
                return false;
            }
            if (images.length > 0) {
                const data = { csrf: getCsrfToken() };
                for (let i = 0; i < images.length; i++)
                    data[`images[${i}]`] = images[i];
                response = yield postData(`/api/product/${productId}/images/`, data);
                json = yield response.json();
                if (!json.success) {
                    sendToastMessage("An unexpected error occurred", "error");
                    console.error(json.error);
                    return false;
                }
            }
            if (formData.getAll('brands') !== undefined) {
                const brands = formData.getAll('brands');
                const data = { csrf: getCsrfToken() };
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
        yield sendToastMessage("Product updated successfully", "success");
        document.location.assign(`/product/${productId}/`);
        return true;
    });
}
function deleteProduct(productId) {
    return __awaiter(this, void 0, void 0, function* () {
        return deleteData(`/api/product/${productId}/`, {
            csrf: getCsrfToken(),
        })
            .then(response => response.json())
            .then((json) => __awaiter(this, void 0, void 0, function* () {
            if (json.success) {
                yield sendToastMessage("Product deleted successfully", "success");
                document.location.assign('/');
                return true;
            }
            else {
                sendToastMessage("An unexpected error occurred", "error");
                console.error(json.error);
                return false;
            }
        }))
            .catch(error => {
            sendToastMessage("An unexpected error occurred", "error");
            console.error(error);
            return false;
        });
    });
}
const editProductForm = document.querySelector("#edit-product-form");
const sendEditButton = document.querySelector("#send-edit-product-button");
const deleteProductButton = document.querySelector("#delete-product-button");
const editProductFileInput = document.querySelector('#edit-product-image-input');
const clearEditImagesButton = document.querySelector("#clear-edit-product-images");
if (editProductForm && sendEditButton && deleteProductButton && editProductFileInput && clearEditImagesButton) {
    const productId = extractPathEnd();
    sendEditButton.addEventListener('click', (event) => __awaiter(void 0, void 0, void 0, function* () {
        event.preventDefault();
        if (!editProductForm.checkValidity()) {
            editProductForm.reportValidity();
            return;
        }
        sendEditButton.disabled = deleteProductButton.disabled = true;
        yield updateProduct(productId, editProductForm, editProductFileInput.files);
        sendEditButton.disabled = deleteProductButton.disabled = false;
    }));
    deleteProductButton.addEventListener('click', () => __awaiter(void 0, void 0, void 0, function* () {
        sendEditButton.disabled = deleteProductButton.disabled = true;
        yield deleteProduct(productId);
        sendEditButton.disabled = deleteProductButton.disabled = false;
    }));
    clearEditImagesButton.addEventListener('click', () => {
        editProductFileInput.value = '';
    });
}
