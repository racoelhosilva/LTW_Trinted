const unbanButton: HTMLElement | null = document.getElementById("unban-button");
const banButton: HTMLElement | null = document.getElementById("ban-button");

document.addEventListener("click", function (event) {
	const target = event.target as HTMLElement;
	if (target.matches("#unban-button")) {
		sendToastMessage("User unbanned", "success");
		const userId = 4;
		unbanUser(userId);
	} else if (target.matches("#ban-button")) {
		sendToastMessage("User banned", "error");
		const userId = 4;
		banUser(userId);
	}
});

function banUser(userId: number) {
	var xhr = new XMLHttpRequest();
	xhr.addEventListener("readystatechange", function () {
		if (this.readyState === 4) {
			const buttons = document.getElementById("user-buttons");
			if (buttons) {
				const newButtons = document.createElement("div");
				newButtons.innerHTML = this.responseText;
				buttons.parentNode?.replaceChild(newButtons, buttons);
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
			const buttons = document.getElementById("user-buttons");
			if (buttons) {
				const newButtons = document.createElement("div");
				newButtons.innerHTML = this.responseText;
				buttons.parentNode?.replaceChild(newButtons, buttons);
			}
		}
	});
	xhr.open("POST", "actions/unban_user.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("user_id=" + userId);
}
