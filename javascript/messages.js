"use strict";
var __awaiter = (this && this.__awaiter) || function (thisArg, _arguments, P, generator) {
    function adopt(value) { return value instanceof P ? value : new P(function (resolve) { resolve(value); }); }
    return new (P || (P = Promise))(function (resolve, reject) {
        function fulfilled(value) { try { step(generator.next(value)); } catch (e) { reject(e); } }
        function rejected(value) { try { step(generator["throw"](value)); } catch (e) { reject(e); } }
        function step(result) { result.done ? resolve(result.value) : adopt(result.value).then(fulfilled, rejected); }
        step((generator = generator.apply(thisArg, _arguments || [])).next());
    });
};
function addMessage(message) {
    const divElement = document.createElement('div');
    divElement.className = 'message user1';
    divElement.setAttribute('data-message-id', message.id.toString());
    const contentParagraph = document.createElement('p');
    contentParagraph.textContent = message.content;
    const datetimeParagraph = document.createElement('p');
    datetimeParagraph.textContent = dateFormat(message.datetime);
    divElement.appendChild(contentParagraph);
    divElement.appendChild(datetimeParagraph);
    allMessages.prepend(divElement);
}
function reloadMessage(message) {
    const divElement = document.createElement('div');
    if (message.receiver == destinationId) {
        divElement.className = 'message user1';
    }
    else if (message.sender == destinationId) {
        divElement.className = 'message user2';
    }
    divElement.setAttribute('data-message-id', message.id.toString());
    const contentParagraph = document.createElement('p');
    contentParagraph.textContent = message.content;
    const datetimeParagraph = document.createElement('p');
    datetimeParagraph.textContent = dateFormat(message.datetime);
    divElement.appendChild(contentParagraph);
    divElement.appendChild(datetimeParagraph);
    allMessages.append(divElement);
}
function dateFormat(datetime) {
    const timestamp = new Date(datetime * 1000);
    const current = new Date();
    const timediff = Math.floor((current.getTime() - timestamp.getTime()) / 1000);
    const years = Math.floor(timediff / (365 * 24 * 60 * 60));
    const months = Math.floor(timediff / (30 * 24 * 60 * 60));
    const days = Math.floor(timediff / (24 * 60 * 60));
    const hours = Math.floor(timediff / (60 * 60));
    const minutes = Math.floor(timediff / 60);
    if (years > 0) {
        return years === 1 ? `${years} year` : `${years} years`;
    }
    else if (months > 0) {
        return months === 1 ? `${months} month` : `${months} months`;
    }
    else if (days > 0) {
        return days === 1 ? `${days} day` : `${days} days`;
    }
    else if (hours > 0) {
        return hours === 1 ? `${hours} hour` : `${hours} hours`;
    }
    else if (minutes > 0) {
        return minutes === 1 ? `${minutes} minute` : `${minutes} minutes`;
    }
    else {
        return "Just now";
    }
}
function reloadMessages() {
    fetchMessages(destinationId)
        .then(messages => {
        console.log(messages);
        allMessages.innerHTML = "";
        for (const message of messages) {
            reloadMessage(message);
        }
    })
        .catch(error => {
        console.error(error);
        sendToastMessage('An unexpected error occurred', 'error');
    });
}
function fetchMessages(dest) {
    return __awaiter(this, void 0, void 0, function* () {
        return getData(`../actions/action_get_messages.php?id=${dest}`)
            .then(response => response.json())
            .then(json => {
            if (json.success) {
                return json.messages;
            }
            else {
                sendToastMessage('Could not load messages, try again later', 'error');
                console.error(json.error);
            }
        })
            .catch(error => {
            sendToastMessage('An unexpected error occurred', 'error');
            console.error(error);
        });
    });
}
function sendMessage(message, dest) {
    return __awaiter(this, void 0, void 0, function* () {
        return postData("../actions/action_send_message.php", { message: message, destID: dest })
            .then(response => response.json());
    });
}
const destinationId = new URLSearchParams(window.location.search).get('id');
const allMessages = document.querySelector("#messages");
const newmessage = document.querySelector("#writemessage");
const messageBox = newmessage === null || newmessage === void 0 ? void 0 : newmessage.querySelector("#newmessage");
const sendButton = newmessage === null || newmessage === void 0 ? void 0 : newmessage.querySelector("#sendbutton");
if (destinationId && newmessage && messageBox && sendButton) {
    sendButton.addEventListener('click', () => {
        sendMessage(messageBox.value, Number(destinationId))
            .then(json => {
            if (json.success) {
                messageBox.value = "";
                addMessage(json.message);
            }
            else {
                sendToastMessage('Could not send message, try again later', 'error');
                console.error(json.error);
            }
        });
    });
    window.setInterval(reloadMessages, 10000);
}
else {
    console.log("CCCC");
}
