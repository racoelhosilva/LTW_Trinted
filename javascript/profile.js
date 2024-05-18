"use strict";
const messageButton = document.getElementById('message-button');
if (messageButton) {
    messageButton.addEventListener('click', () => {
        document.location.assign(`/messages?id=${messageButton.dataset.userId}`);
    });
}

const addProductButton = document.getElementById('add-button');
if (addProductButton) {
    addProductButton.addEventListener('click', () => {
        document.location.assign(`/new-product`);
    });
}

const idParam = window.location.pathname.split("/").pop();
let userId;
if (idParam == null) {
    userId = 0;
}
else {
    userId = parseInt(idParam);
}
document.addEventListener("click", function (event) {
    const target = event.target;
    if (target.matches("#unban-button")) {
        unbanUser(userId);
    }
    else if (target.matches("#ban-button")) {
        banUser(userId);
    }
    else if (target.matches("#make-admin-button")) {
        makeUserAdmin(userId);
    }
});
function banUser(userId) {
    patchData(`/api/user/${userId}/`, { is_banned: 'true', csrf: getCsrfToken() }).then(response => response.json()).then(json => {
        if (json.success) {
            setBannedButtons();
            sendToastMessage('User banned successfully', "success");
        }
        else {
            sendToastMessage(json.error, "error");
        }
    });
}
function unbanUser(userId) {
    patchData(`/api/user/${userId}/`, { is_banned: 'false', csrf: getCsrfToken() }).then(response => response.json()).then(json => {
        if (json.success) {
            setUnbannedButtons();
            sendToastMessage('User unbanned successfully', "success");
        }
        else {
            sendToastMessage(json.error, "error");
        }
    });
}
function makeUserAdmin(userId) {
    patchData(`/api/user/${userId}/`, { type: 'admin', csrf: getCsrfToken() }).then(response => response.json()).then(json => {
        if (json.success) {
            setAdminButton();
            sendToastMessage('User promoted successfully', "success");
        }
        else {
            sendToastMessage(json.error, "error");
        }
    });
}
function setBannedButtons() {
    const buttonsContainer = document.getElementById("user-buttons");
    if (buttonsContainer) {
        const unbanButton = document.createElement('button');
        unbanButton.className = "blue-button";
        unbanButton.type = "submit";
        unbanButton.id = "unban-button";
        unbanButton.innerText = "Unban";
        const banButton = document.getElementById("ban-button");
        if (banButton) {
            buttonsContainer.replaceChild(unbanButton, banButton);
        }
        const makeAdminButton = document.getElementById("make-admin-button");
        if (makeAdminButton) {
            buttonsContainer.removeChild(makeAdminButton);
        }
    }
}
function setUnbannedButtons() {
    const buttonsContainer = document.getElementById("user-buttons");
    if (buttonsContainer) {
        const banButton = document.createElement('button');
        banButton.className = "blue-button";
        banButton.type = "submit";
        banButton.id = "ban-button";
        banButton.innerText = "Ban";
        const makeAdminButton = document.getElementById("make-admin-button");
        if (!makeAdminButton) {
            const newMakeAdminButton = document.createElement('button');
            newMakeAdminButton.className = "blue-button";
            newMakeAdminButton.type = "submit";
            newMakeAdminButton.id = "make-admin-button";
            newMakeAdminButton.innerText = "Make Admin";
            buttonsContainer.appendChild(newMakeAdminButton);
        }
        const unbanButton = document.getElementById("unban-button");
        if (unbanButton) {
            buttonsContainer.removeChild(unbanButton);
        }
        buttonsContainer.appendChild(banButton);
    }
}
function setAdminButton() {
    const buttonsContainer = document.getElementById("user-buttons");
    if (buttonsContainer) {
        const adminButton = document.createElement('button');
        adminButton.className = "blue-button";
        adminButton.disabled = true;
        adminButton.id = "is-admin-button";
        adminButton.innerText = "User is admin";
        const makeAdminButton = document.getElementById("make-admin-button");
        if (makeAdminButton) {
            buttonsContainer.replaceChild(adminButton, makeAdminButton);
        }
        const banButton = document.getElementById("ban-button");
        if (banButton) {
            buttonsContainer.removeChild(banButton);
        }
        const unbanButton = document.getElementById("unban-button");
        if (unbanButton) {
            buttonsContainer.removeChild(unbanButton);
        }
    }
}
