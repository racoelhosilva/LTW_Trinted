function resetFields(username: string, email: string) {
    usernameField!.value = username;
    emailField!.value = email;
    newPasswordField!.value = "";
    oldPasswordField!.value = "";
    fileInput!.value = "";
}

async function verifyPassword(password: string): Promise<boolean | null> {
    return postData(`/actions/action_verify_password.php`, {
        password: password,
        csrf: getCsrfToken(),
    })
        .then(response => response.json())
        .then(json => {
            if (json.success) {
                return json.valid;
            } else {
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
}

async function changeSettings(username: string, email: string, newPassword: string, oldPassword: string, profilePicture: File): Promise<any> {
    let path = "";
    if (profilePicture != null) {
        path = (await uploadImage(profilePicture, "profiles")).path;
    }

    const passwordValid = await verifyPassword(oldPassword);
    if (passwordValid === false) {
        sendToastMessage('Incorrect password, try again', 'error');
        return;
    } else if (passwordValid == null) {
        return;
    }

    const loggedInUserId = await getLoggedInUserId();
    return patchData(`/api/user/${loggedInUserId}`, {
        name: username,
        email: email,
        password: newPassword,
        profile_picture: path,
        csrf: getCsrfToken(),
    }).then(response => response.json());
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
