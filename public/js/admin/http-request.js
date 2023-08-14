class HttpRequest{
    static getRequest(url, successResponse, failResponse, params, async, headers){
        HttpRequest.request("GET", url, successResponse, failResponse, params, async, headers);
    }

    static postRequest(url, successResponse, failResponse, params, async, headers){
        HttpRequest.request("POST", url, successResponse, failResponse, params, async, headers);
    }

    static request(method, url, successResponse, failResponse, params, async, headers){
        let httpRequest = new XMLHttpRequest();
        let sendParams = typeof params === "string" || params === null ? params :
            params === undefined ? null : new URLSearchParams(params).toString();
        let getParams = sendParams && method === "GET" ? "?" + (sendParams ? sendParams : "") : "";


        if (typeof async !== "boolean") {
            async = true;
        }

        httpRequest.open(method, url + getParams, async);

        if(method === "POST"){
            httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            httpRequest.send(sendParams);
        }
        else{
            httpRequest.send(null);
        }


        if(headers){
            for (let prop in headers) {
                httpRequest.setRequestHeader(prop, headers[prop]);
            }
        }

        httpRequest.onreadystatechange = function(){
            if (httpRequest.readyState === 4) {
                if (httpRequest.status === 200) {
                    successResponse ? successResponse(httpRequest.responseText) : "";
                } else {
                    failResponse ? failResponse(httpRequest.responseText) : "";
                }
            }
        };
    }
}