function addMessage(message: { [key: string]: any }) {

    const divElement = document.createElement('div');
    divElement.className = 'message user1';
    divElement.setAttribute('data-message-id', message.id.toString());

    const contentParagraph = document.createElement('p');
    contentParagraph.textContent = message.content;

    const datetimeParagraph = document.createElement('p');
    datetimeParagraph.textContent = dateFormat(message.datetime);

    divElement.appendChild(contentParagraph);
    divElement.appendChild(datetimeParagraph);

    allMessages!.prepend(divElement);
}

function reloadMessage(message: { [key: string]: any }) {

    const divElement = document.createElement('div');
    if (message.receiver == destinationId){
        divElement.className = 'message user1';
    }
    else if (message.sender == destinationId){
        divElement.className = 'message user2';
    }
    divElement.setAttribute('data-message-id', message.id.toString());

    const contentParagraph = document.createElement('p');
    contentParagraph.textContent = message.content;

    const datetimeParagraph = document.createElement('p');
    datetimeParagraph.textContent = dateFormat(message.datetime);

    divElement.appendChild(contentParagraph);
    divElement.appendChild(datetimeParagraph);

    allMessages!.append(divElement);
}

function dateFormat(datetime: number): string {
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
    } else if (months > 0) {
        return months === 1 ? `${months} month` : `${months} months`;
    } else if (days > 0) {
        return days === 1 ? `${days} day` : `${days} days`;
    } else if (hours > 0) {
        return hours === 1 ? `${hours} hour` : `${hours} hours`;
    } else if (minutes > 0) {
        return minutes === 1 ? `${minutes} minute` : `${minutes} minutes`;
    } else {
        return "Just now";
    }
}

function reloadMessages() {
    fetchMessages(destinationId)
        .then(messages => {
            allMessages!.innerHTML = "";
            for (const message of messages){
                reloadMessage(message);
            }
        })
        .catch(error =>{
            console.error(error);
            sendToastMessage('An unexpected error occurred', 'error');
        });
}

async function fetchMessages(dest: any) {
    return getData(`../actions/action_get_messages.php?id=${dest}`)
        .then(response => response.json())
        .then(json => {
            if (json.success) {
                return json.messages;
            } else {
                sendToastMessage('Could not load messages, try again later', 'error');
                console.error(json.error);
            }
        })
        .catch(error =>{
            sendToastMessage('An unexpected error occurred', 'error');
            console.error(error);

        });
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

    window.setInterval(reloadMessages, 10000);


} else {
    console.log("CCCC");
}
