"use strict";
const unbanButton = document.getElementById("unban-button");
const banButton = document.getElementById("ban-button");
document.addEventListener("click", function (event) {
    const target = event.target;
    if (target.matches("#unban-button")) {
        sendToastMessage("User unbanned", "success");
        const userId = 4;
        unbanUser(userId);
    }
    else if (target.matches("#ban-button")) {
        sendToastMessage("User banned", "error");
        const userId = 4;
        banUser(userId);
    }
});
function banUser(userId) {
    var xhr = new XMLHttpRequest();
    xhr.addEventListener("readystatechange", function () {
        var _a;
        if (this.readyState === 4) {
            const buttons = document.getElementById("user-buttons");
            if (buttons) {
                const newButtons = document.createElement("div");
                newButtons.innerHTML = this.responseText;
                (_a = buttons.parentNode) === null || _a === void 0 ? void 0 : _a.replaceChild(newButtons, buttons);
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
        var _a;
        if (this.readyState === 4) {
            const buttons = document.getElementById("user-buttons");
            if (buttons) {
                const newButtons = document.createElement("div");
                newButtons.innerHTML = this.responseText;
                (_a = buttons.parentNode) === null || _a === void 0 ? void 0 : _a.replaceChild(newButtons, buttons);
            }
        }
    });
    xhr.open("POST", "actions/unban_user.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("user_id=" + userId);
}
