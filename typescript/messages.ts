async function sendMessage(message: string, dest: number): Promise<any> {
    return postData(message, dest)
      .then(response => response.json());
}

const urlParams = new URLSearchParams(window.location.search); 
const newmessage: HTMLElement | null = document.querySelector(".writemessage");
const messageBox: HTMLElement | null | undefined = newmessage?.querySelector(".newmessage");
const sendButton: HTMLElement | null | undefined = newmessage?.querySelector(".sendbutton");


if (newmessage && messageBox && sendButton) {
    
    sendButton.addEventListener('click', () => {
        sendMessage(messageBox.innerText, urlParams['id']);
    });




}
