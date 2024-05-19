async function createProduct(form: HTMLFormElement, files: FileList): Promise<boolean> {
    const images: string[] = [];
    for (let i = 0; i < files.length; i++) {
        const result = await uploadImage(files[i], 'posts')
            .then(json => {
                if (json.success) {
                    images.push(`/${json.path}`);
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

    const formData = convertToObject(new FormData(form));
    let productId;
    
    try {
        let response = await postData("/api/product/", {
            title: formData['title'],
            description: formData['description'],
            price: formData['price'],
            category: formData['category'],
            condition: formData['condition'],
            size: formData['size'],
            image: images[0],
            csrf: getCsrfToken(),
        });
        let json = await response.json();

        if (json.success) {
            productId = json.product.id;
        } else {
            sendToastMessage("An unexpected error occurred", "error");
            console.error(json.error);
            return false;
        }

        images.shift();
        response = await postData(`/api/product/${productId}/images/`, {
            'images[]': images,
            csrf: getCsrfToken(),
        });
        json = await response.json();

        if (!json.success) {
            sendToastMessage("An unexpected error occurred", "error");
            console.error(json.error);
            return false;
        }

        if (formData['brands'] !== undefined) {
            response = await putData(`/api/product/${productId}/brands/`, {
                'brands[]': formData['brands'] ?? [],
                csrf: getCsrfToken(),
            });
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

    await sendToastMessage("Product created successfully", "success");
    document.location.assign(`/product/${productId}`);
    return true;
}

const newProductForm: HTMLFormElement | null = document.querySelector("#add-product-form");
const newProductButton: HTMLFormElement | null = document.querySelector("#add-product-button");
const productFileInput: HTMLInputElement | null = document.querySelector('#product-image-input');
const clearImagesButton: HTMLElement | null = document.querySelector("#clear-product-picture");
console

if (newProductForm && newProductButton && productFileInput && clearImagesButton) {

    newProductButton.addEventListener('click', async () => {
        if (!newProductForm.checkValidity()) {
            newProductForm.reportValidity();
            return;
        }

        await createProduct(newProductForm, productFileInput!.files!);      
    })


    clearImagesButton.addEventListener('click', () => {
        productFileInput!.value = '';
    })
}