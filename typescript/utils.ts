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
