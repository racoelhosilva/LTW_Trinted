const unbanButton: HTMLElement | null = document.getElementById("unban-button");
const banButton: HTMLElement | null = document.getElementById("ban-button");

function banUser(userId: number) {
	var xhr = new XMLHttpRequest();
	xhr.addEventListener("readystatechange", function () {
		if (this.readyState === 4) {
			console.log(this.responseText);
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
			console.log(this.responseText);
		}
	});
	xhr.open("POST", "actions/unban_user.php", true);
	xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
	xhr.send("user_id=" + userId);
}

if (unbanButton) {
	unbanButton.addEventListener("click", () => {
		sendToastMessage("User unbanned", "success");
		unbanUser(4);
	});
}
if (banButton) {
	banButton.addEventListener("click", () => {
		sendToastMessage("User banned", "error");
		banUser(4);
	});
}
