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
function resetFields() {
    usernameField.value = "";
    emailField.value = "";
    newPasswordField.value = "";
    oldPasswordField.value = "";
}
function changeSettings(username, email, newPassword, oldPassword) {
    return __awaiter(this, void 0, void 0, function* () {
        return postData("../actions/change_settings.php", { username: username, email: email, old: oldPassword, new: newPassword })
            .then(response => response.json());
    });
}
const settingsSection = document.querySelector("#account-settings");
const changeSettingsButton = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#settings-button");
const usernameField = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#new-username");
const emailField = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#new-email");
const newPasswordField = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#new-password");
const oldPasswordField = settingsSection === null || settingsSection === void 0 ? void 0 : settingsSection.querySelector("#old-password");
if (settingsSection && changeSettingsButton && usernameField && emailField && newPasswordField && oldPasswordField) {
    changeSettingsButton.addEventListener('click', () => {
        changeSettings(usernameField.value, emailField.value, newPasswordField.value, oldPasswordField.value)
            .then(json => {
            if (json.success) {
                sendToastMessage('Profile changed successfully', 'success');
            }
            else if (json.known) {
                sendToastMessage(json.error, 'error');
            }
            else {
                sendToastMessage('Could not change settings, try again later', 'error');
                console.error(json.error);
            }
            resetFields();
        });
    });
}
