async function updateProduct(productId: string, form: HTMLFormElement, files: FileList): Promise<boolean> {
    const images: string[] = [];
    for (let i = 0; i < files.length; i++) {
        const result = await uploadImage(files[i], 'posts')
            .then(json => {
                if (json.success) {
                    images.push(json.path);
                    return true;
                } else {
                    sendToastMessage("An unexpected error occurred", "error");
                    console.error(json.error);
                    return false
                }
            })
            .catch(error => {
                sendToastMessage("An unexpected error occurred", "error");
                console.error(error);
                return false
            });
        if (!result) return false;
    }

    const formData = new FormData(form);

    try {
        let response = await patchData(`/api/product/${productId}/`, {
            title: formData.get('title'),
            description: formData.get('description'),
            price: formData.get('price'),
            category: formData.get('category'),
            condition: formData.get('condition'),
            size: formData.get('size'),
            csrf: getCsrfToken(),
        });
        let json = await response.json();

        if (!json.success) {
            sendToastMessage("An unexpected error occurred", "error");
            console.error(json.error);
            return false;
        }

        if (images.length > 0) {
            const data: any = { csrf: getCsrfToken() }
            for (let i = 0; i < images.length; i++)
                data[`images[${i}]`] = images[i];

            response = await postData(`/api/product/${productId}/images/`, data);
            json = await response.json();

            if (!json.success) {
                sendToastMessage("An unexpected error occurred", "error");
                console.error(json.error);
                return false;
            }
        }

        if (formData.getAll('brands') !== undefined) {
            const brands = formData.getAll('brands');
            const data: any = { csrf: getCsrfToken() };
            for (let i = 0; i < brands.length; i++)
                data[`brands[${i}]`] = brands[i];

            response = await putData(`/api/product/${productId}/brands/`, data);
            json = await response.json();

            if (!json.success) {
                sendToastMessage("An unexpected error occurred", "error");
                console.error(json.error);
                return false;
            }
        }
    } catch (error) {
        sendToastMessage("An unexpected error occurred", "error");
        console.error(error);
        return false;
    }

    await sendToastMessage("Product updated successfully", "success");
    document.location.assign(`/product/${productId}/`);
    return true;
}

async function deleteProduct(productId: string): Promise<boolean> {
    return deleteData(`/api/product/${productId}/`, {
        csrf: getCsrfToken(),
    })
        .then(response => response.json())
        .then(async json => {
            if (json.success) {
                await sendToastMessage("Product deleted successfully", "success");
                document.location.assign('/');
                return true;
            } else {
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
}

const editProductForm: HTMLFormElement | null = document.querySelector("#edit-product-form");
const sendEditButton: HTMLFormElement | null = document.querySelector("#send-edit-product-button");
const deleteProductButton: HTMLFormElement | null = document.querySelector("#delete-product-button");
const editProductFileInput: HTMLInputElement | null = document.querySelector('#edit-product-image-input');
const clearEditImagesButton: HTMLElement | null = document.querySelector("#clear-edit-product-images");

if (editProductForm && sendEditButton && deleteProductButton && editProductFileInput && clearEditImagesButton) {
    const productId = extractPathEnd();

    sendEditButton.addEventListener('click', async (event) => {
        event.preventDefault();
        if (!editProductForm.checkValidity()) {
            editProductForm.reportValidity();
            return;
        }

        sendEditButton.disabled = deleteProductButton.disabled = true;
        await updateProduct(productId!, editProductForm, editProductFileInput!.files!);  
        sendEditButton.disabled = deleteProductButton.disabled = false;    
    })

    deleteProductButton.addEventListener('click', async () => {
        sendEditButton.disabled = deleteProductButton.disabled = true;
        await deleteProduct(productId!);
        sendEditButton.disabled = deleteProductButton.disabled = false;
    })


    clearEditImagesButton.addEventListener('click', () => {
        editProductFileInput!.value = '';
    })
}
