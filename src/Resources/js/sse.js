function SseConnect(url) {
    const eventSource = new EventSource(url);

    eventSource.addEventListener('close', event => {
        let data = JSON.parse(event.data);
        if (data.reload) {
            window.location.reload();
        }
    });

    eventSource.addEventListener('messageSweet', event => {
        let data = JSON.parse(event.data);
        let icon = 'success';
        if (data.type === 'error') {
            icon = 'error';
        }
        if (data.type === 'info') {
            icon = 'info';
        }
        if (data.type === 'warning') {
            icon = 'warning';
        }
        if (data.type === 'question') {
            icon = 'question';
        }
        if (data.confirm) {
            Swal.fire({
                title: data.title,
                text: data.message,
                icon: icon
            });
        } else {
            Swal.fire({
                position: "top-end",
                icon: icon,
                title: data.title,
                text: data.message,
                showConfirmButton: false,
                timer: 1500
            });
        }
    });

    eventSource.addEventListener('messageAlert', event => {
        let data = JSON.parse(event.data);
        alert(data.message);
    });

    eventSource.addEventListener('messageToast', event => {
        let data = JSON.parse(event.data);
        let boxMessage = loadBoxMessage();
        let body = document.getElementsByTagName('body')[0];
        body.append(boxMessage);

        let message = loadToast(data);
        boxMessage.append(message);
        $("#" + data.id).fadeIn();

        if (data.autoClose) {
            setTimeout(function () {
                $("#" + data.id).fadeOut('slow', function () {
                    document.getElementById(data.id).remove();
                });
            }, 10000);
        }
    });

    eventSource.addEventListener('messageNotify', event => {
        let data = JSON.parse(event.data);
        let boxMessage = loadBoxMessage();
        let body = document.getElementsByTagName('body')[0];
        body.append(boxMessage);

        let message = loadNotify(data.id, data.title, data.message, data.date, data.type);
        boxMessage.append(message);
        $("#" + data.id).fadeIn();

        if (data.autoClose) {
            setTimeout(function () {
                $("#" + data.id).fadeOut('slow', function () {
                    document.getElementById(data.id).remove();
                });
            }, 10000);
        }
    });

    eventSource.addEventListener('injectionHtml', event => {
        let data = JSON.parse(event.data);
        let element = document.getElementById(data.target);
        if(data.append) {
            let box = document.createElement('div');
            box.innerHTML = data.html;
            element.insertAdjacentElement('beforeend', box);
        } else {
            element.innerHTML = data.html;
        }
    });

    eventSource.addEventListener('injectionScript', event => {
        let data = JSON.parse(event.data);
        let body = document.getElementsByTagName('body')[0];
        let check = document.getElementById('box-sse-script');
        if (check) {
            check.remove();
        }

        let script = document.createElement('script');
        script.id = 'box-sse-script';
        script.textContent = data.script;
        body.appendChild(script);

    });
}

function loadNotify(id, title, message, date, type) {

    let textColor = '#155724';
    let backgroundColor = '#d4edda';
    let borderColor = '#c3e6cb';
    if (type === 'error') {
        textColor = '#721c24';
        backgroundColor = '#f8d7da';
        borderColor = '#f5c6cb';
    }
    if (type === 'info') {
        textColor = '#0c5460';
        backgroundColor = '#d1ecf1';
        borderColor = '#bee5eb';
    }
    if (type === 'warning') {
        textColor = '#856404';
        backgroundColor = '#fff3cd';
        borderColor = '#ffeeba';
    }
    if (type === 'question') {
        textColor = '#004085';
        backgroundColor = '#cce5ff';
        borderColor = '#b8daff';
    }

    let notify = document.createElement('div');
    notify.setAttribute('role', 'alert');
    notify.setAttribute('aria-live', 'assertive');
    notify.setAttribute('aria-atomic', 'true');
    notify.setAttribute('id', id);
    notify.style.width = '500px';
    notify.style.minHeight = '50px';
    notify.style.backgroundColor = backgroundColor;
    notify.style.border = '1px solid '+borderColor;
    notify.style.borderRadius = '5px';
    notify.style.boxShadow = 'rgba(0, 0, 0, 0.1) 0px 0.25rem 0.75rem';
    notify.style.marginBottom = '10px';
    notify.style.marginTop = '10px';

    let notifyDivTitle = document.createElement('div');
    notifyDivTitle.style.borderBottom = '1px solid '+borderColor;
    notifyDivTitle.style.padding = '10px';

    let notifyTitle = document.createElement('strong');
    notifyTitle.style.color = textColor;
    notifyTitle.style.fontSize = '14px';
    notifyTitle.innerHTML = title;
    notifyDivTitle.append(notifyTitle);

    let notifyButton = document.createElement('button');
    notifyButton.setAttribute('type', 'button');
    notifyButton.setAttribute('data-dismiss', 'notify');
    notifyButton.setAttribute('aria-label', 'Close');
    notifyButton.style.float = 'right';
    notifyButton.style.fontSize = '24px';
    notifyButton.style.lineHeight = '1';
    notifyButton.style.color = textColor;
    notifyButton.style.textShadow = 'rgb(255, 255, 255) 0px 1px 0px';
    notifyButton.style.marginLeft = '20px';
    notifyButton.style.padding = '0px';
    notifyButton.style.backgroundColor = 'transparent';
    notifyButton.style.border = '0px';
    notifyButton.style.appearance = 'none';
    notifyButton.onclick = function() {
        document.getElementById(id).remove();
    };
    notifyButton.innerHTML = '&times;';
    notifyDivTitle.append(notifyButton);

    notify.append(notifyDivTitle);

    let notifyDivBody = document.createElement('div');
    notifyDivBody.style.color = textColor;
    notifyDivBody.style.fontSize = '12px';
    notifyDivBody.style.padding = '10px';
    notifyDivBody.innerHTML = message;

    notify.append(notifyDivBody);

    return notify;
}

function loadBoxMessage() {
    let boxMessage = document.getElementById('box-message');
    if(boxMessage === null){
        boxMessage = document.createElement('div');
        boxMessage.setAttribute('id', 'box-message');
        boxMessage.style.position = 'fixed';
        boxMessage.style.top = '20px';
        boxMessage.style.right = '20px';
        boxMessage.style.zIndex = '9999';
    }

    return boxMessage;
}

function loadToast(data) {

    let textColor = '#155724';
    let backgroundColor = '#d4edda';
    let borderColor = '#c3e6cb';
    if (data.type === 'error') {
        textColor = '#721c24';
        backgroundColor = '#f8d7da';
        borderColor = '#f5c6cb';
    }
    if (data.type === 'info') {
        textColor = '#0c5460';
        backgroundColor = '#d1ecf1';
        borderColor = '#bee5eb';
    }
    if (data.type === 'warning') {
        textColor = '#856404';
        backgroundColor = '#fff3cd';
        borderColor = '#ffeeba';
    }
    if (data.type === 'question') {
        textColor = '#004085';
        backgroundColor = '#cce5ff';
        borderColor = '#b8daff';
    }

    let toast = document.createElement('div');
    toast.setAttribute('role', 'alert');
    toast.setAttribute('aria-live', 'assertive');
    toast.setAttribute('aria-atomic', 'true');
    toast.setAttribute('id', data.id);
    toast.style.maxWidth = '350px';
    toast.style.overflow = 'hidden';
    toast.style.position = 'relative';
    toast.style.fontSize = '0.875rem';
    toast.style.backgroundColor = backgroundColor;
    toast.style.border = '1px solid '+borderColor;
    toast.style.borderRadius = '0.25rem';
    toast.style.boxShadow = 'rgba(0, 0, 0, 0.1) 0px 0.25rem 0.75rem';
    toast.style.backdropFilter = 'blur(10px)';
    toast.style.marginBottom = '20px';
    toast.style.display = 'none';
    toast.style.minWidth = '350px';

    let toastHeader = document.createElement('div');
    toastHeader.style.padding = '0.5rem 0.75rem';
    toastHeader.style.borderBottom = '1px solid rgba(0, 0, 0, 0.1)';
    toastHeader.style.backgroundColor = 'rgba(240, 240, 240, 0.3)';
    toastHeader.style.backgroundClip = 'padding-box';
    toastHeader.style.color = textColor;

    let toastImg = document.createElement('img');
    toastImg.style.borderRadius = '0.25rem !important';
    toastImg.setAttribute('alt', '...');
    toastImg.setAttribute('src', (data.imgURL??'/assets/images/logo.png'));
    toastImg.style.width = '30px';
    toastImg.fontSize = '1.125rem';
    toastImg.style.textAnchor = 'middle';
    toastImg.marginRight = '10px';

    let toastStrong = document.createElement('strong');
    toastStrong.innerHTML = data.title;
    toastStrong.style.boxSizing = 'border-box';
    toastStrong.style.fontWeight = 'bolder';
    toastStrong.style.marginRight = 'auto !important';
    toastStrong.style.marginLeft = '10px';

    let toastSmall = document.createElement('small');
    toastSmall.style.float = 'right';
    toastSmall.style.fontSize = '8px';
    toastSmall.style.marginTop = '7px';
    toastSmall.innerHTML = data.date;

    let toastButton = document.createElement('button');
    toastButton.setAttribute('type', 'button');
    toastButton.setAttribute('data-dismiss', 'toast');
    toastButton.setAttribute('aria-label', 'Close');
    toastButton.style.float = 'right';
    toastButton.style.fontSize = '1.5rem';
    toastButton.style.fontWeight = '700';
    toastButton.style.lineHeight = '1';
    toastButton.style.color = textColor;
    toastButton.style.textShadow = 'rgb(255, 255, 255) 0px 1px 0px';
    toastButton.style.opacity = '0.5';
    toastButton.style.marginLeft = '20px';
    toastButton.style.padding = '0px';
    toastButton.style.backgroundColor = 'transparent';
    toastButton.style.border = '0px';
    toastButton.style.appearance = 'none';
    toastButton.onclick = function() {
        document.getElementById(id).remove();
    };

    let toastSpan = document.createElement('span');
    toastSpan.setAttribute('aria-hidden', 'true');
    toastSpan.innerHTML = '&times;';

    toastButton.append(toastSpan);

    toastHeader.append(toastImg);
    toastHeader.append(toastStrong);
    toastHeader.append(toastButton);
    toastHeader.append(toastSmall);

    let toastBody = document.createElement('div');
    toastBody.className = 'toast-body';
    toastBody.style.padding = '10px';
    toastBody.style.color = textColor;

    if(data.linkURL !== null){
        let toastLink = document.createElement('a');
        toastLink.setAttribute('href', data.linkURL);
        toastLink.innerHTML = " "+(data.linkText??'Link')+" ";
        let messageArr = data.message.split('[link]');
        toastBody.append(messageArr[0]);
        toastBody.append(toastLink);
        if(messageArr[1]) {
            toastBody.append(messageArr[1]);
        }
    } else {
        toastBody.innerHTML = data.message;
    }

    toast.append(toastHeader);
    toast.append(toastBody);

    return toast;
}



