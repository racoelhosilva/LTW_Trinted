async function addNewBrand(name: string): Promise<boolean> {
    if (name === "")
        return false;
    return postData("/api/brand/", { name: name, csrf: getCsrfToken() })
        .then(response => response.json())
        .then(json => {
            if (json.success) {
                sendToastMessage("Brand added successfully", "success");
                return true;
            }
            else {
                sendToastMessage("An unexpected error occurred", "error");
                console.error(json.error);
                return false;
            }
        }).catch(error => {
            sendToastMessage("An unexpected error occurred", "error");
            console.error(error);
            return false;
        });
}

async function addNewCategory(name: string): Promise<boolean> {
    if (name === "")
        return false;
    return postData("/api/category/", { name: name, csrf: getCsrfToken() })
        .then(response => response.json())
        .then(json => {
            if (json.success) {
                sendToastMessage("Category added successfully", "success");
                return true;
            }
            else {
                sendToastMessage("An unexpected error occurred", "error");
                console.error(json.error);
                return false;
            }
        }).catch(error => {
            sendToastMessage("An unexpected error occurred", "error");
            console.error(error);
            return false;
        });
}

async function addNewCondition(name: string): Promise<boolean> {
    if (name === "")
        return false;
    return postData("/api/condition/", { name: name, csrf: getCsrfToken() })
        .then(response => response.json())
        .then(json => {
            if (json.success) {
                sendToastMessage("Condition added successfully", "success");
                return true;
            }
            else {
                sendToastMessage("An unexpected error occurred", "error");
                console.error(json.error);
                return false;
            }
        }).catch(error => {
            sendToastMessage("An unexpected error occurred", "error");
            console.error(error);
            return false;
        });
}

async function addNewSize(name: string): Promise<boolean> {
    if (name === "")
        return false;
    return postData("/api/size/", { name: name, csrf: getCsrfToken() })
        .then(response => response.json())
        .then(json => {
            if (json.success) {
                sendToastMessage("Size added successfully", "success");
                return true;
            }
            else {
                sendToastMessage("An unexpected error occurred", "error");
                console.error(json.error);
                return false;
            }
        }).catch(error => {
            sendToastMessage("An unexpected error occurred", "error");
            console.error(error);
            return false;
        });
}

const brandsCard: HTMLElement | null = document.querySelector("#brands-card");
const categoriesCard: HTMLElement | null = document.querySelector("#categories-card");
const conditionsCard: HTMLElement | null = document.querySelector("#conditions-card");
const sizesCard: HTMLElement | null = document.querySelector("#sizes-card");

if (brandsCard) {
    const newBrandForm: HTMLFormElement | null = brandsCard.querySelector('form');
    const newBrandInput: HTMLInputElement | null = newBrandForm?.querySelector('input[type="text"]') ?? null;
    const newBrandButton: HTMLInputElement | null = newBrandForm?.querySelector('input[type="button"]') ?? null;
    const brandsList: HTMLUListElement | null = brandsCard.querySelector('ul');
    const brandCount = brandsCard.querySelector(".detail-count");

    if (newBrandForm && newBrandInput && newBrandButton && brandsList && brandCount) {
        newBrandForm.addEventListener("submit", (event) => {
            event.preventDefault();
        });

        newBrandButton.addEventListener("click", () => {
            addNewBrand(newBrandInput.value).then((success) => {
                if (!success)
                    return;

                const newBrandItem = document.createElement("li");
                newBrandItem.innerHTML = newBrandInput.value;
                brandsList!.appendChild(newBrandItem);

                newBrandInput.value = "";
                brandCount.innerHTML = (parseInt(brandCount.innerHTML!) + 1).toString();
            });
        });

        newBrandInput.addEventListener("keypress", (event) => {
            if (event.key === "Enter")
                newBrandButton.click();
        });
    }
}

if (categoriesCard) {
    const newCategoryForm: HTMLFormElement | null = categoriesCard.querySelector('form');
    const newCategoryInput: HTMLInputElement | null = newCategoryForm?.querySelector('input[type="text"]') ?? null;
    const newCategoryButton: HTMLInputElement | null = newCategoryForm?.querySelector('input[type="button"]') ?? null;
    const categoriesList: HTMLUListElement | null = categoriesCard.querySelector('ul');
    const categoryCount = categoriesCard.querySelector(".detail-count");

    if (newCategoryForm && newCategoryInput && newCategoryButton && categoriesList && categoryCount) {
        newCategoryForm.addEventListener("submit", (event) => {
            event.preventDefault();
        });

        newCategoryButton.addEventListener("click", () => {
            addNewCategory(newCategoryInput.value).then((success) => {
                if (!success)
                    return

                const newCategoryItem = document.createElement("li");
                newCategoryItem.innerHTML = newCategoryInput.value;
                categoriesList!.appendChild(newCategoryItem);

                newCategoryInput.value = "";
                categoryCount.innerHTML = (parseInt(categoryCount.innerHTML!) + 1).toString();
            });
        });

        newCategoryInput.addEventListener("keypress", (event) => {
            if (event.key === "Enter")
                newCategoryButton.click();
        });
    }
}

if (conditionsCard) {
    const newConditionForm: HTMLFormElement | null = conditionsCard.querySelector('form');
    const newConditionInput: HTMLInputElement | null = newConditionForm?.querySelector('input[type="text"]') ?? null;
    const newConditionButton: HTMLInputElement | null = newConditionForm?.querySelector('input[type="button"]') ?? null;
    const conditionsCount: HTMLElement | null = conditionsCard.querySelector(".detail-count");
    const conditionsList: HTMLUListElement | null = conditionsCard.querySelector('ul');

    if (newConditionForm && newConditionInput && newConditionButton && conditionsCount && conditionsList) {
        newConditionForm.addEventListener("submit", (event) => {
            event.preventDefault();
        });

        newConditionButton.addEventListener("click", () => {
            addNewCondition(newConditionInput.value).then((success) => {
                if (!success)
                    return;
                
                const newConditionItem = document.createElement("li");
                newConditionItem.innerHTML = newConditionInput.value;
                conditionsList!.appendChild(newConditionItem);

                newConditionInput.value = "";
                conditionsCount.innerHTML = (parseInt(conditionsCount.innerHTML) + 1).toString();
            });
        });

        newConditionInput.addEventListener("keypress", (event) => {
            if (event.key === "Enter")
                newConditionButton.click();
        });
    }
}

if (sizesCard) {
    const newSizeForm: HTMLFormElement | null = sizesCard.querySelector('form');
    const newSizeInput: HTMLInputElement | null = newSizeForm?.querySelector('input[type="text"]') ?? null;
    const newSizeButton: HTMLInputElement | null = newSizeForm?.querySelector('input[type="button"]') ?? null;
    const sizesCount: HTMLElement | null = sizesCard.querySelector(".detail-count");
    const sizesList: HTMLUListElement | null = sizesCard.querySelector('ul');

    if (newSizeForm && newSizeInput && newSizeButton && sizesCard && sizesList && sizesCount) {
        newSizeForm.addEventListener("submit", (event) => {
            event.preventDefault();
        });

        newSizeButton.addEventListener("click", () => {
            addNewSize(newSizeInput.value).then((success) => {
                if (!success)
                    return;

                const newSizeItem = document.createElement("li");
                newSizeItem.innerHTML = newSizeInput.value;
                sizesList!.appendChild(newSizeItem);

                newSizeInput.value = "";
                sizesCount.innerHTML = (parseInt(sizesCount.innerHTML) + 1).toString();
            });
        });

        newSizeInput.addEventListener("keypress", (event) => {
            if (event.key === "Enter")
                newSizeButton.click();
        });
    }
}

