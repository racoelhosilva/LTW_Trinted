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
var _a, _b, _c, _d, _e, _f, _g, _h;
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
const brandsCard = document.querySelector("#brands-card");
const categoriesCard = document.querySelector("#categories-card");
const conditionsCard = document.querySelector("#conditions-card");
const sizesCard = document.querySelector("#sizes-card");
if (brandsCard) {
    const newBrandForm = brandsCard.querySelector('form');
    const newBrandInput = (_a = newBrandForm === null || newBrandForm === void 0 ? void 0 : newBrandForm.querySelector('input[type="text"]')) !== null && _a !== void 0 ? _a : null;
    const newBrandButton = (_b = newBrandForm === null || newBrandForm === void 0 ? void 0 : newBrandForm.querySelector('input[type="button"]')) !== null && _b !== void 0 ? _b : null;
    const brandsList = brandsCard.querySelector('ul');
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
                brandsList.appendChild(newBrandItem);
                newBrandInput.value = "";
                brandCount.innerHTML = (parseInt(brandCount.innerHTML) + 1).toString();
            });
        });
        newBrandInput.addEventListener("keypress", (event) => {
            if (event.key === "Enter")
                newBrandButton.click();
        });
    }
}
if (categoriesCard) {
    const newCategoryForm = categoriesCard.querySelector('form');
    const newCategoryInput = (_c = newCategoryForm === null || newCategoryForm === void 0 ? void 0 : newCategoryForm.querySelector('input[type="text"]')) !== null && _c !== void 0 ? _c : null;
    const newCategoryButton = (_d = newCategoryForm === null || newCategoryForm === void 0 ? void 0 : newCategoryForm.querySelector('input[type="button"]')) !== null && _d !== void 0 ? _d : null;
    const categoriesList = categoriesCard.querySelector('ul');
    const categoryCount = categoriesCard.querySelector(".detail-count");
    if (newCategoryForm && newCategoryInput && newCategoryButton && categoriesList && categoryCount) {
        newCategoryForm.addEventListener("submit", (event) => {
            event.preventDefault();
        });
        newCategoryButton.addEventListener("click", () => {
            addNewCategory(newCategoryInput.value).then((success) => {
                if (!success)
                    return;
                const newCategoryItem = document.createElement("li");
                newCategoryItem.innerHTML = newCategoryInput.value;
                categoriesList.appendChild(newCategoryItem);
                newCategoryInput.value = "";
                categoryCount.innerHTML = (parseInt(categoryCount.innerHTML) + 1).toString();
            });
        });
        newCategoryInput.addEventListener("keypress", (event) => {
            if (event.key === "Enter")
                newCategoryButton.click();
        });
    }
}
if (conditionsCard) {
    const newConditionForm = conditionsCard.querySelector('form');
    const newConditionInput = (_e = newConditionForm === null || newConditionForm === void 0 ? void 0 : newConditionForm.querySelector('input[type="text"]')) !== null && _e !== void 0 ? _e : null;
    const newConditionButton = (_f = newConditionForm === null || newConditionForm === void 0 ? void 0 : newConditionForm.querySelector('input[type="button"]')) !== null && _f !== void 0 ? _f : null;
    const conditionsCount = conditionsCard.querySelector(".detail-count");
    const conditionsList = conditionsCard.querySelector('ul');
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
                conditionsList.appendChild(newConditionItem);
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
    const newSizeForm = sizesCard.querySelector('form');
    const newSizeInput = (_g = newSizeForm === null || newSizeForm === void 0 ? void 0 : newSizeForm.querySelector('input[type="text"]')) !== null && _g !== void 0 ? _g : null;
    const newSizeButton = (_h = newSizeForm === null || newSizeForm === void 0 ? void 0 : newSizeForm.querySelector('input[type="button"]')) !== null && _h !== void 0 ? _h : null;
    const sizesCount = sizesCard.querySelector(".detail-count");
    const sizesList = sizesCard.querySelector('ul');
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
                sizesList.appendChild(newSizeItem);
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
