"use strict";
const messageButton = document.getElementById('message-button');
if (messageButton) {
    messageButton.addEventListener('click', () => {
        document.location.assign(`/messages?id=${messageButton.dataset.userId}`);
    });
}
const url = new URL(window.location.href);
const idParam = url.searchParams.get("id");
let userId;
if (idParam == null) {
    userId = 0;
}
else {
    userId = parseInt(idParam);
}
document.addEventListener("click", function (event) {
    var target = event.target;
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
    var xhr = new XMLHttpRequest();
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            var response = JSON.parse(this.responseText);
            console.log(response.message);
            if (response.status == "success") {
                setBannedButtons();
                sendToastMessage("User banned", "success");
            }
            else {
                sendToastMessage(response.message, "error");
            }
        }
    });
    xhr.open("POST", "api/ban_user.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("user_id=" + userId);
}
function unbanUser(userId) {
    var xhr = new XMLHttpRequest();
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            var response = JSON.parse(this.responseText);
            console.log(response.message);
            if (response.status == "success") {
                setUnbannedButtons();
                sendToastMessage("User unbanned", "success");
            }
            else {
                sendToastMessage(response.message, "error");
            }
        }
    });
    xhr.open("POST", "api/unban_user.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("user_id=" + userId);
}
function makeUserAdmin(userId) {
    var xhr = new XMLHttpRequest();
    xhr.addEventListener("readystatechange", function () {
        if (this.readyState === 4) {
            var response = JSON.parse(this.responseText);
            console.log(response.message);
            if (response.status == "success") {
                setAdminButton();
                sendToastMessage("User is now an admin", "success");
            }
            else {
                sendToastMessage(response.message, "error");
            }
        }
    });
    xhr.open("POST", "api/make_admin.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("user_id=" + userId);
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
        const unbanButton = document.getElementById("unban-button");
        if (unbanButton) {
            buttonsContainer.replaceChild(banButton, unbanButton);
        }
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
