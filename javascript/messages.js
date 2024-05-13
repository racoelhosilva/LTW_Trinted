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
    datetimeParagraph.textContent = message.datetime;
    divElement.appendChild(contentParagraph);
    divElement.appendChild(datetimeParagraph);
    allMessages.prepend(divElement);
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
}
else {
    console.log("CCCC");
}
