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
function verifyPassword(password) {
    return __awaiter(this, void 0, void 0, function* () {
        return postData(`/actions/action_verify_password.php`, {
            password: password,
            csrf: getCsrfToken(),
        })
            .then(response => response.json())
            .then(json => {
            if (json.success) {
                return json.valid;
            }
            else {
                sendToastMessage('An unexpected error occurred', 'error');
                console.error(json.error);
                return null;
            }
        })
            .catch(error => {
            sendToastMessage('An unexpected error occurred', 'error');
            console.error(error);
            return null;
        });
    });
}
function changeSettings(username, email, newPassword, oldPassword, profilePicture) {
    return __awaiter(this, void 0, void 0, function* () {
        let path = "";
        if (profilePicture != null) {
            path = (yield uploadImage(profilePicture, "profiles")).path;
        }
        const passwordValid = yield verifyPassword(oldPassword);
        if (passwordValid === false) {
            sendToastMessage('Incorrect password, try again', 'error');
            return;
        }
        else if (passwordValid == null) {
            return;
        }
        const loggedInUserId = yield getLoggedInUserId();
        return patchData(`/api/user/${loggedInUserId}`, {
            name: username,
            email: email,
            password: newPassword,
            profile_picture: path,
            csrf: getCsrfToken(),
        }).then(response => response.json());
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
