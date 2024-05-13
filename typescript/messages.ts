function addMessage(message: { [key: string]: any }) {

    const divElement = document.createElement('div');
    divElement.className = 'message user1';
    divElement.setAttribute('data-message-id', message.id.toString());

    const contentParagraph = document.createElement('p');
    contentParagraph.textContent = message.content;

    const datetimeParagraph = document.createElement('p');
    datetimeParagraph.textContent = message.datetime;

    divElement.appendChild(contentParagraph);
    divElement.appendChild(datetimeParagraph);

    allMessages!.prepend(divElement);
}

async function sendMessage(message: string, dest: number): Promise<any> {
    return postData("../actions/action_send_message.php",  {message: message, destID: dest})
      .then(response => response.json());
}

const destinationId = new URLSearchParams(window.location.search).get('id'); 
const allMessages: HTMLElement | null = document.querySelector("#messages");
const newmessage: HTMLElement | null = document.querySelector("#writemessage");
const messageBox: HTMLInputElement | null | undefined = newmessage?.querySelector("#newmessage");
const sendButton: HTMLElement | null | undefined = newmessage?.querySelector("#sendbutton");

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




} else {
    console.log("CCCC");
}
