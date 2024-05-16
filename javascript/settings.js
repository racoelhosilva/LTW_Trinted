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
function resetFields(username, email) {
    usernameField.value = username;
    emailField.value = email;
    newPasswordField.value = "";
    oldPasswordField.value = "";
    fileInput.value = "";
}
function changeSettings(username, email, newPassword, oldPassword, profilePicture) {
    return __awaiter(this, void 0, void 0, function* () {
        let message = { path: "" };
        if (profilePicture != null) {
            message = yield uploadProfilePicture(profilePicture);
        }
        return postData("../actions/change_settings.php", {
            username: username,
            email: email,
            old: oldPassword,
            new: newPassword,
            profile_picture: message.path,
        }).then(response => response.json()).then(json => {
            return json;
        });
    });
}
function uploadProfilePicture(file) {
    return __awaiter(this, void 0, void 0, function* () {
        // Unfortunately, here we can't use the postData function because it doesn't support the necessary headers for file uploads.
        const formData = new FormData();
        formData.append("subfolder", "profiles");
        formData.append("image", file);
        const response = yield fetch("api/upload_image.php", {
            method: "POST",
            body: formData,
        });
        if (!response.ok) {
            throw new Error(`Failed to upload profile picture: ${response.statusText}`);
        }
        else {
            const data = yield response.json();
            return data;
        }
    });
}
const settingsSection = document.querySelector("#account-settings");
const changeSettingsButton = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#settings-button");
const clearProfilePictureButton = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#clear-profile-picture");
const usernameField = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#new-username");
const emailField = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#new-email");
const newPasswordField = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#new-password");
const oldPasswordField = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#old-password");
const fileInput = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector('#image-input');
if (settingsSection && changeSettingsButton && clearProfilePictureButton && usernameField && emailField && newPasswordField && oldPasswordField) {
    let username = usernameField.value;
    let email = emailField.value;
    changeSettingsButton.addEventListener('click', () => {
        changeSettings(usernameField.value, emailField.value, newPasswordField.value, oldPasswordField.value, fileInput.files[0])
            .then(json => {
            if (json.success) {
                sendToastMessage('Profile changed successfully', 'success');
                username = usernameField.value;
                email = emailField.value;
            }
            else if (['Invalid request method', 'User not found', 'Incorrect password', 'No fields to change'].includes(json.error)) {
                sendToastMessage(json.error, 'error');
            }
            else {
                sendToastMessage('Could not change settings, try again later', 'error');
                console.error(json.error);
            }
            resetFields(username, email);
        });
    });
    clearProfilePictureButton.addEventListener('click', () => {
        fileInput.value = '';
    });
}
