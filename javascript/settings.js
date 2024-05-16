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
}
function changeSettings(username, email, newPassword, oldPassword) {
    return __awaiter(this, void 0, void 0, function* () {
        return postData("../actions/change_settings.php", {
            username: username,
            email: email,
            old: oldPassword,
            new: newPassword
        })
            .then(response => response.json());
    });
}
function uploadProfilePicture(file) {
    var formData = new FormData();
    formData.append("subfolder", "profiles");
    formData.append("image", file);
    var xhr = new XMLHttpRequest();
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            console.log(this.responseText);
            // var response = JSON.parse(this.responseText);
            // console.log(response.message);
        }
    });
    xhr.open("POST", "api/upload_image.php", true);
    xhr.send(formData);
}
const settingsSection = document.querySelector("#account-settings");
const changeSettingsButton = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#settings-button");
const changeProfilePictureButton = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#change-profile-picture");
const usernameField = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#new-username");
const emailField = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#new-email");
const newPasswordField = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#new-password");
const oldPasswordField = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#old-password");
if (settingsSection && changeSettingsButton && changeProfilePictureButton && usernameField && emailField && newPasswordField && oldPasswordField) {
    var username = usernameField.value;
    var email = emailField.value;
    changeSettingsButton.addEventListener('click', () => {
        changeSettings(usernameField.value, emailField.value, newPasswordField.value, oldPasswordField.value)
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
    changeProfilePictureButton.addEventListener('click', () => {
        var _a;
        const fileInput = document.getElementById('image-input');
        const file = (_a = fileInput.files) === null || _a === void 0 ? void 0 : _a[0];
        if (file) {
            uploadProfilePicture(file);
        }
        else {
            console.error('No file selected.');
        }
    });
}
