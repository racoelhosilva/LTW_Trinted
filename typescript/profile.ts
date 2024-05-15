const unbanButton: HTMLElement | null = document.getElementById("unban-button");
const banButton: HTMLElement | null = document.getElementById("ban-button");

document.addEventListener("click", function (event) {
	const target = event.target as HTMLElement;
	if (target.matches("#unban-button")) {
		const userId = 4;
		unbanUser(userId);
	} else if (target.matches("#ban-button")) {
		const userId = 4;
		banUser(userId);
	}
});

function banUser(userId: number) {
	var xhr = new XMLHttpRequest();
	xhr.addEventListener("readystatechange", function () {
		if (this.readyState === 4) {
			var response = JSON.parse(this.responseText);
			console.log(response.message);
			if (response.status == "success") {
				setBannedButtons();
				sendToastMessage("User banned", "success");
			} else {
				sendToastMessage(response.message, "error");
			}
		}
	});

	xhr.open("POST", "actions/ban_user.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("user_id=" + userId);
}

function unbanUser(userId: number) {
	var xhr = new XMLHttpRequest();
	xhr.addEventListener("readystatechange", function () {
		if (this.readyState === 4) {
			var response = JSON.parse(this.responseText);
			console.log(response.message);
			if (response.status == "success") {
				setUnbannedButtons();
				sendToastMessage("User unbanned", "success");
			} else {
				sendToastMessage(response.message, "error");
			}
		}
	});
	xhr.open("POST", "actions/unban_user.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("user_id=" + userId);
	setUnbannedButtons();
}

function setBannedButtons(): void {
	const buttonsContainer = document.getElementById("user-buttons");
	if (buttonsContainer) {
		let buttonsHtml = "";

		buttonsHtml += `
                <button type="submit" class="admin-button" id="unban-button">Unban</button>
            `;

		buttonsContainer.innerHTML = buttonsHtml;
	}
}

function setUnbannedButtons(): void {
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
