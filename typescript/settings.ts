function resetFields(){
    usernameField!.value = "";
    emailField!.value = "";
    newPasswordField!.value = "";
    oldPasswordField!.value = "";
}

async function changeSettings(username: string, email: string, newPassword: string, oldPassword: string): Promise<any> {
    return postData("../actions/change_settings.php",  {username: username, email: email, old: oldPassword, new: newPassword})
      .then(response => response.json());
}

const settingsSection: HTMLElement | null = document.querySelector("#account-settings");
const changeSettingsButton: HTMLElement | null | undefined = settingsSection?.querySelector("#settings-button");
const usernameField: HTMLInputElement | null | undefined = settingsSection?.querySelector("#new-username");
const emailField: HTMLInputElement | null | undefined = settingsSection?.querySelector("#new-email");
const newPasswordField: HTMLInputElement | null | undefined = settingsSection?.querySelector("#new-password");
const oldPasswordField: HTMLInputElement | null | undefined = settingsSection?.querySelector("#old-password");

if (settingsSection && changeSettingsButton && usernameField && emailField && newPasswordField && oldPasswordField) {

    changeSettingsButton.addEventListener('click', () => {
        changeSettings(usernameField.value, emailField.value, newPasswordField.value, oldPasswordField.value)
            .then(json => {
                if (json.success) {
                    sendToastMessage('Profile changed successfully', 'success');
                }
                else if (json.known){
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
