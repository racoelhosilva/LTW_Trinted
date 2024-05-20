async function createProduct(form: HTMLFormElement, files: FileList): Promise<boolean> {
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
    let productId;
    
    try {
        let response = await postData("/api/product/", {
            title: formData.get('title'),
            description: formData.get('description'),
            price: formData.get('price'),
            category: formData.get('category'),
            condition: formData.get('condition'),
            size: formData.get('size'),
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

        let data: any = { csrf: getCsrfToken() }
        for (let i = 0; i < images.length; i++)
            data[`images[${i}]`] = images[i];

        response = await postData(`/api/product/${productId}/images/`, data);
        json = await response.json();

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

    await sendToastMessage("Product created successfully", "success");
    document.location.assign(`/product/${productId}/`);
    return true;
}

const newProductForm: HTMLFormElement | null = document.querySelector("#add-product-form");
const newProductButton: HTMLFormElement | null = document.querySelector("#add-product-button");
const productFileInput: HTMLInputElement | null = document.querySelector('#product-image-input');
const clearImagesButton: HTMLElement | null = document.querySelector("#clear-product-images");

if (newProductForm && newProductButton && productFileInput && clearImagesButton) {

    newProductButton.addEventListener('click', async () => {
        if (!newProductForm.checkValidity()) {
            newProductForm.reportValidity();
            return;
        }

        newProductButton.disabled = true;
        await createProduct(newProductForm, productFileInput!.files!);     
        newProductButton.disabled = false; 
    })


    clearImagesButton.addEventListener('click', () => {
        productFileInput!.value = '';
    })
}