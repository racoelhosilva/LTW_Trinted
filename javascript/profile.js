"use strict";
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
        let buttonsHtml = "";
        buttonsHtml += `
                <button type="submit" class="admin-button" id="unban-button">Unban</button>
            `;
        buttonsContainer.innerHTML = buttonsHtml;
    }
}
function setUnbannedButtons() {
    const buttonsContainer = document.getElementById("user-buttons");
    if (buttonsContainer) {
        let buttonsHtml = "";
        buttonsHtml += `
<form method="post" action="/api/make_admin.php">
<input type="hidden" name="user_id" value="<?= $user->id; ?>">
<button type="submit" class="admin-button">Make Admin</button>
</form>
        `;
        buttonsHtml += `
        <button type="submit" class="admin-button" id="ban-button">Ban</button>
            `;
        buttonsContainer.innerHTML = buttonsHtml;
    }
}
function setAdminButton() {
    const buttonsContainer = document.getElementById("user-buttons");
    if (buttonsContainer) {
        let buttonsHtml = "";
        buttonsHtml += `
		<button disabled id="is-admin-button">User is admin</button>
            `;
        buttonsContainer.innerHTML = buttonsHtml;
    }
}
