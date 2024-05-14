"use strict";
const messageButton = document.getElementById('message-button');
if (messageButton) {
    console.log("Found");
    messageButton.addEventListener('click', () => {
        document.location.assign(`/messages?id=${messageButton.dataset.userId}`);
    });
}
