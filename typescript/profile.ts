const messageButton = document.getElementById('message-button');

if (messageButton) {
    messageButton.addEventListener('click', () => {
        document.location.assign(`/messages?id=${messageButton.dataset.userId}`);
    })
}
const url = new URL(window.location.href);
const idParam = url.searchParams.get("id");
let userId: number;

if (idParam == null) {
    userId = 0;
} else {
    userId = parseInt(idParam);
}

document.addEventListener("click", function (event) {
    var target = event.target as HTMLElement;
    if (target.matches("#unban-button")) {
        unbanUser(userId);
    } else if (target.matches("#ban-button")) {
        banUser(userId);
    } else if (target.matches("#make-admin-button")) {
        makeUserAdmin(userId);
    }
});

function banUser(userId: number) {
    postData("api/ban_user.php", {user_id: userId}).then(response => response.json()).then(json => {
        console.log(json.message);
        if (json.status === "success") {
            setBannedButtons();
            sendToastMessage(json.message, "success");
        } else {
            sendToastMessage(json.message, "error");
        }
    });
}

function unbanUser(userId: number) {
    postData("api/unban_user.php", {user_id: userId}).then(response => response.json()).then(json => {
        console.log(json.message);
        if (json.status === "success") {
            setUnbannedButtons();
            sendToastMessage(json.message, "success");
        } else {
            sendToastMessage(json.message, "error");
        }
    });
}

function makeUserAdmin(userId: number) {
    postData("api/make_admin.php", {user_id: userId}).then(response => response.json()).then(json => {
        console.log(json.message);
        if (json.status == "success") {
            setAdminButton();
            sendToastMessage(json.message, "success");
        } else {
            sendToastMessage(json.message, "error");
        }
    });
}

function setBannedButtons(): void {
    const buttonsContainer = document.getElementById("user-buttons");
    if (buttonsContainer) {
        const unbanButton = document.createElement('button');
        unbanButton.className = "blue-button";
        unbanButton.type = "submit";
        unbanButton.id = "unban-button";
        unbanButton.innerText = "Unban";
        const banButton = document.getElementById("ban-button");
        if (banButton) {
            buttonsContainer.replaceChild(unbanButton, banButton)
        }
        const makeAdminButton = document.getElementById("make-admin-button");
        if (makeAdminButton) {
            buttonsContainer.removeChild(makeAdminButton);
        }
    }
}

function setUnbannedButtons(): void {
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

function setAdminButton(): void {
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
