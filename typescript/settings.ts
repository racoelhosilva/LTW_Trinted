function resetFields(username: string, email: string) {
    usernameField!.value = username;
    emailField!.value = email;
    newPasswordField!.value = "";
    oldPasswordField!.value = "";
    fileInput!.value = "";
}

async function changeSettings(username: string, email: string, newPassword: string, oldPassword: string, profilePicture: File): Promise<any> {
    let message = {path: ""};
    if (profilePicture != null) {
        message = await uploadProfilePicture(profilePicture);
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
}

async function uploadProfilePicture(file: File): Promise<any> {
    // Unfortunately, here we can't use the postData function because it doesn't support the necessary headers for file uploads.
    const formData = new FormData();
    formData.append("subfolder", "profiles");
    formData.append("image", file);
    const response = await fetch("api/upload_image.php", {
        method: "POST",
        body: formData,
    });
    if (!response.ok) {
        throw new Error(`Failed to upload profile picture: ${response.statusText}`);
    } else {
        const data = await response.json();
        return data;
    }
}

const settingsSection: HTMLElement | null = document.querySelector("#account-settings");
const changeSettingsButton: HTMLElement | null | undefined = settingsSection?.querySelector("#settings-button");
const clearProfilePictureButton: HTMLElement | null | undefined = settingsSection?.querySelector("#clear-profile-picture");
const usernameField: HTMLInputElement | null | undefined = settingsSection?.querySelector("#new-username");
const emailField: HTMLInputElement | null | undefined = settingsSection?.querySelector("#new-email");
const newPasswordField: HTMLInputElement | null | undefined = settingsSection?.querySelector("#new-password");
const oldPasswordField: HTMLInputElement | null | undefined = settingsSection?.querySelector("#old-password");
const fileInput: HTMLInputElement | null | undefined = settingsSection?.querySelector('#image-input');

if (settingsSection && changeSettingsButton && clearProfilePictureButton && usernameField && emailField && newPasswordField && oldPasswordField) {

    let username: string = usernameField.value;
    let email: string = emailField.value;

    changeSettingsButton.addEventListener('click', () => {
        changeSettings(usernameField.value, emailField.value, newPasswordField.value, oldPasswordField.value, fileInput!.files![0])
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

    clearProfilePictureButton.addEventListener('click', () => {
        fileInput!.value = '';
    })

}
