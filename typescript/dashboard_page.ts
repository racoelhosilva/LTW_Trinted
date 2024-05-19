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

function sortList(list: HTMLUListElement) {
    const newList = list.cloneNode(false) as HTMLUListElement;
    const listElems: HTMLElement[] = [];
    for (let i = 0; i < list.children.length; i++) {
        listElems.push(list.children[i] as HTMLElement);
    }

    listElems.sort((a: HTMLElement, b: HTMLElement) => {
        return a.textContent!.localeCompare(b.textContent!);
    })

    listElems.forEach(item => newList.appendChild(item));
    list.replaceWith(newList);
}

const newBrandForm: HTMLFormElement | null = document.querySelector("#new-brand");
const newCategoryForm: HTMLFormElement | null = document.querySelector("#new-category");
const newConditionForm: HTMLFormElement | null = document.querySelector("#new-condition");
const newSizeForm: HTMLFormElement | null = document.querySelector("#new-size");

if (newBrandForm) {
    const newBrandInput: HTMLInputElement | null = newBrandForm.querySelector('input[type="text"]');
    const newBrandButton: HTMLInputElement | null = newBrandForm.querySelector('input[type="button"]');

    if (newBrandInput && newBrandButton) {
        newBrandForm.addEventListener("submit", (event) => {
            event.preventDefault();
        });

        newBrandButton.addEventListener("click", () => {
            addNewBrand(newBrandInput.value).then(() => {
                newBrandInput.value = "";
            });
        });

        newBrandInput.addEventListener("keypress", (event) => {
            if (event.key === "Enter")
                newBrandButton.click();
        });
    }
}

if (newCategoryForm) {
    const newCategoryInput: HTMLInputElement | null = newCategoryForm.querySelector('input[type="text"]');
    const newCategoryButton: HTMLInputElement | null = newCategoryForm.querySelector('input[type="button"]');

    if (newCategoryInput && newCategoryButton) {
        newCategoryForm.addEventListener("submit", (event) => {
            event.preventDefault();
        });

        newCategoryButton.addEventListener("click", (event) => {
            addNewCategory(newCategoryInput.value).then(() => {
                newCategoryInput.value = "";
            });
        });

        newCategoryInput.addEventListener("keypress", (event) => {
            if (event.key === "Enter")
                newCategoryButton.click();
        });
    }
}

if (newConditionForm) {
    const newConditionInput: HTMLInputElement | null = newConditionForm.querySelector('input[type="text"]');
    const newConditionButton: HTMLInputElement | null = newConditionForm.querySelector('input[type="button"]');
    const conditionCount: HTMLElement | null = newConditionForm.querySelector(".details-count");
    const

    if (newConditionInput && newConditionButton) {
        newConditionForm.addEventListener("submit", (event) => {
            event.preventDefault();
        });

        newConditionButton.addEventListener("click", (event) => {
            addNewCondition(newConditionInput.value).then((success) => {
                if (success) {
                    newConditionInput.value = "";
                    conditionCount
                } 
            });
        });

        newConditionInput.addEventListener("keypress", (event) => {
            if (event.key === "Enter")
                newConditionButton.click();
        });
    }
}

if (newSizeForm) {
    const newSizeInput: HTMLInputElement | null = newSizeForm.querySelector('input[type="text"]');
    const newSizeButton: HTMLInputElement | null = newSizeForm.querySelector('input[type="button"]');

    if (newSizeInput && newSizeButton) {
        newSizeForm.addEventListener("submit", (event) => {
            event.preventDefault();
        });

        newSizeButton.addEventListener("click", (event) => {
            addNewSize(newSizeInput.value).then(() => {
                newSizeInput.value = "";
            });
        });

        newSizeInput.addEventListener("keypress", (event) => {
            if (event.key === "Enter")
                newSizeButton.click();
        });
    }
}

