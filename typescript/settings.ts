function resetFields(username: string, email: string) {
    usernameField!.value = username;
    emailField!.value = email;
    newPasswordField!.value = "";
    oldPasswordField!.value = "";
}

async function changeSettings(username: string, email: string, newPassword: string, oldPassword: string): Promise<any> {
    return postData("../actions/change_settings.php", {
        username: username,
        email: email,
        old: oldPassword,
        new: newPassword
    })
        .then(response => response.json());
}

function uploadProfilePicture(file: File): void {
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

const settingsSection: HTMLElement | null = document.querySelector("#account-settings");
const changeSettingsButton: HTMLElement | null | undefined = settingsSection?.querySelector("#settings-button");
const changeProfilePictureButton: HTMLElement | null | undefined = settingsSection?.querySelector("#change-profile-picture");
const usernameField: HTMLInputElement | null | undefined = settingsSection?.querySelector("#new-username");
const emailField: HTMLInputElement | null | undefined = settingsSection?.querySelector("#new-email");
const newPasswordField: HTMLInputElement | null | undefined = settingsSection?.querySelector("#new-password");
const oldPasswordField: HTMLInputElement | null | undefined = settingsSection?.querySelector("#old-password");

if (settingsSection && changeSettingsButton && changeProfilePictureButton && usernameField && emailField && newPasswordField && oldPasswordField) {

    var username: string = usernameField.value;
    var email: string = emailField.value;

    changeSettingsButton.addEventListener('click', () => {
        changeSettings(usernameField.value, emailField.value, newPasswordField.value, oldPasswordField.value)
            .then(json => {
                if (json.success) {
                    sendToastMessage('Profile changed successfully', 'success');
                    username = usernameField.value;
                    email = emailField.value;
                } else if (['Invalid request method', 'User not found', 'Incorrect password', 'No fields to change'].includes(json.error)) {
                    sendToastMessage(json.error, 'error');
                } else {
                    sendToastMessage('Could not change settings, try again later', 'error');
                    console.error(json.error);
                }
                resetFields(username, email);
            });
    });

    changeProfilePictureButton.addEventListener('click', () => {
        const fileInput = document.getElementById('image-input') as HTMLInputElement;
        const file = fileInput.files?.[0];
        if (file) {
            uploadProfilePicture(file);
        } else {
            console.error('No file selected.');
        }
    })

}
