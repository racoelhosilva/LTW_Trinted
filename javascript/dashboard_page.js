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
function addNewBrand(name) {
    return __awaiter(this, void 0, void 0, function* () {
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
    });
}
function addNewCategory(name) {
    return __awaiter(this, void 0, void 0, function* () {
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
    });
}
function addNewCondition(name) {
    return __awaiter(this, void 0, void 0, function* () {
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
    });
}
function addNewSize(name) {
    return __awaiter(this, void 0, void 0, function* () {
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
    });
}
function sortList(list) {
    const newList = list.cloneNode(false);
    const listElems = [];
    for (let i = 0; i < list.children.length; i++) {
        listElems.push(list.children[i]);
    }
    listElems.sort((a, b) => {
        return a.textContent.localeCompare(b.textContent);
    });
    listElems.forEach(item => newList.appendChild(item));
    list.replaceWith(newList);
}
const newBrandForm = document.querySelector("#new-brand");
const newCategoryForm = document.querySelector("#new-category");
const newConditionForm = document.querySelector("#new-condition");
const newSizeForm = document.querySelector("#new-size");
if (newBrandForm) {
    const newBrandInput = newBrandForm.querySelector('input[type="text"]');
    const newBrandButton = newBrandForm.querySelector('input[type="button"]');
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
    const newCategoryInput = newCategoryForm.querySelector('input[type="text"]');
    const newCategoryButton = newCategoryForm.querySelector('input[type="button"]');
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
    const newConditionInput = newConditionForm.querySelector('input[type="text"]');
    const newConditionButton = newConditionForm.querySelector('input[type="button"]');
    const conditionCount = newConditionForm.querySelector(".details-count");
    const ;
    if (newConditionInput && newConditionButton) {
        newConditionForm.addEventListener("submit", (event) => {
            event.preventDefault();
        });
        newConditionButton.addEventListener("click", (event) => {
            addNewCondition(newConditionInput.value).then((success) => {
                if (success) {
                    newConditionInput.value = "";
                    conditionCount;
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
    const newSizeInput = newSizeForm.querySelector('input[type="text"]');
    const newSizeButton = newSizeForm.querySelector('input[type="button"]');
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
