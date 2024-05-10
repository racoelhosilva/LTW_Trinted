function encodeForAjax(data: {[key: string]: any}): string {
    return Object.keys(data).map(function(k: string){
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&')
}

async function getData(url: string): Promise<Response> {
    return fetch(url);
}

async function postData(url: string, data: Object): Promise<Response> {
    return fetch(url, {
        method: 'post',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: encodeForAjax(data),
    });
}

const sendToastMessage = (function () {
    let timer: number;
    
    return async function (message: string, type: string): Promise<void> {
        const oldToastMessage = document.querySelector<HTMLElement>('#toast-message');
        if (oldToastMessage)
            oldToastMessage.remove();
        window.clearTimeout(timer);

        let icon = document.createElement('span');
        icon.classList.add('material-symbols-outlined');

        switch (type) {
            case 'success':
                icon.innerHTML = 'check';
                break;
            
            case 'error':
                icon.innerHTML = 'error';
                break;

            default:
                throw new Error(`Invalid toast message type "${type}"`);
        }

        const toastMessage = document.createElement('div');
        toastMessage.id = 'toast-message';
        document.body.appendChild(toastMessage);

        toastMessage.classList.add(type);
        toastMessage.appendChild(icon);
        toastMessage.innerHTML += message;

        return new Promise((resolve) => window.setTimeout(resolve, 5000))
            .then(() => toastMessage.remove());
    }
})();
