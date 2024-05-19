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

function drawMessage(message: { [key: string]: any }) {

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

    return divElement;
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

function loadNewMessages() {
    fetchNewMessages(destinationId)
        .then(messages => messages.map((message: any) => drawMessage(message)))
        .then(messages => {
            allMessages!.innerHTML = "";
            for (const message of messages){
                allMessages!.append(message);
            }
            resetObserver();
        })
        .catch(error =>{
            console.error(error);
            sendToastMessage('An unexpected error occurred', 'error');
        });
}

async function fetchNewMessages(dest: any) {
    const loggedInUserId = await getLoggedInUserId();
    return getData(`/api/message/${loggedInUserId}/${dest}/`)
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

function loadOldMessages() {
    fetchOldMessages(destinationId)
        .then(messages => messages.map((message: any) => drawMessage(message)))
        .then(messages => {
            for (const message of messages){
                allMessages!.append(message);
            }
            resetObserver();
        })
        .catch(error =>{
            console.error(error);
            sendToastMessage('An unexpected error occurred', 'error');
        });
}

async function fetchOldMessages(dest: any) {
    const loggedInUserId = await getLoggedInUserId();
    return getData(`/api/message/${loggedInUserId}/${dest}?last_id=${allMessages?.lastElementChild?.getAttribute('data-message-id')}`)
        .then(response => response.json())
        .then(json => {
            if (json.success) {
                console.log(json.messages);
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
    const loggedInUserId = await getLoggedInUserId();
    return postData(`/api/message/${loggedInUserId}/`,  {content: message, receiver: dest, csrf: getCsrfToken()})
      .then(response => response.json());
}

function resetObserver() {
    oldObserver.observe(allMessages?.lastElementChild!);
    newObserver.observe(allMessages?.firstElementChild!);
}

const newObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            setTimeout(loadNewMessages, 1000);
        }
    });
}, { threshold: 1 });

const oldObserver = new IntersectionObserver(entries => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            setTimeout(loadOldMessages, 1000);
        }
    });
}, { threshold: 0.5 });

const destinationId = new URLSearchParams(window.location.search).get('id'); 
const allMessages: HTMLElement | null = document.querySelector("#messages");
const newmessage: HTMLElement | null = document.querySelector("#writemessage");
const messageBox: HTMLInputElement | null | undefined = newmessage?.querySelector("#newmessage");
const sendButton: HTMLElement | null | undefined = newmessage?.querySelector("#sendbutton");

if (destinationId && newmessage && messageBox && sendButton) {

    messageBox.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            sendButton.click();
        }
    })

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

    oldObserver.observe(allMessages?.lastElementChild!);
    newObserver.observe(allMessages?.firstElementChild!);
}
