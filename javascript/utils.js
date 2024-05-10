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
function encodeForAjax(data) {
    return Object.keys(data).map(function (k) {
        return encodeURIComponent(k) + '=' + encodeURIComponent(data[k]);
    }).join('&');
}
function getData(url) {
    return __awaiter(this, void 0, void 0, function* () {
        return fetch(url);
    });
}
function postData(url, data) {
    return __awaiter(this, void 0, void 0, function* () {
        return fetch(url, {
            method: 'post',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: encodeForAjax(data),
        });
    });
}
const sendToastMessage = (function () {
    let timer;
    return function (message, type) {
        return __awaiter(this, void 0, void 0, function* () {
            const oldToastMessage = document.querySelector('#toast-message');
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
        });
    };
})();
