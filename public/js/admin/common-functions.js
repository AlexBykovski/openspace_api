function getOffset(element) {
    if (!element || !element.getClientRects().length) {
        return {top: 0, left: 0};
    }

    let rect = element.getBoundingClientRect();
    let win = element.ownerDocument.defaultView;

    return ({
        top: rect.top + win.pageYOffset,
        left: rect.left + win.pageXOffset
    });
}

function hide(el) {
    if (!el) return;

    el.style.display = "none";
}

function show(el) {
    if (!el) return;

    el.style.display = "block";
}

function getParams() {
    const hash = window.location.href.split('?')[1];
    let result = {};

    if (hash) {
        result = hash.split('&').reduce((res, item) => {
            const parts = item.split('=');

            res[parts[0]] = parts[1];

            return res;
        }, result);
    }

    return result;
}