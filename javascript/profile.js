"use strict";
const unbanButton = document.getElementById("unban-button");
const banButton = document.getElementById("ban-button");
const url = new URL(window.location.href);
var idParam = url.searchParams.get("id");
var userId;
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
    xhr.open("POST", "actions/ban_user.php", true);
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
    xhr.open("POST", "actions/unban_user.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("user_id=" + userId);
    setUnbannedButtons();
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
<form method="post" action="/actions/make_admin.php">
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
