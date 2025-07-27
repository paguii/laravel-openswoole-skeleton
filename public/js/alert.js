const ALERT = {
    SUCCESS: 'success',
    DANGER: 'danger',
    WARNING: 'warning',
    INFO: 'info',
    PRIMARY: 'primary',
}

const toggleAlert = (alert, show) => {
    if (!alert) {
        return;
    }

    if (show) {
        alert.classList.remove('d-none');
    } else {
        alert.classList.add('d-none');
    }
};

const setAlertType = (alert, type) => {
    if (!alert) {
        return;
    }

    if (type === 'success') {
        alert.classList.remove('alert-danger');
        alert.classList.add('alert-success');
    } else {
        alert.classList.remove('alert-success');
        alert.classList.add('alert-danger');
    }
};

const setAlertMessage = (alert, message) => {
    if (!alert) {
        return;
    }

    alert.innerHTML = message;
};

const showAlert = (id, type, message, timeout = 0) => {
    const alert = document.getElementById(id);

    setAlertType(alert, type);
    setAlertMessage(alert, message);
    toggleAlert(alert, true);

    if (timeout > 0) {
        setTimeout(() => {
            toggleAlert(false);
        }, timeout * 1000);
    }

    scrollToAlert(alert);
}

const scrollToAlert = (alert) => {
    if (!alert) {
        return;
    }

    alert.scrollIntoView({
        behavior: 'smooth',
        block: 'start',
        inline: 'nearest'
    });
}

const hideAlert = (id) => {
    const alert = document.getElementById(id);

    if (!alert) {
        return;
    }

    setAlertMessage(alert, '');
    setAlertType(alert, ALERT.SUCCESS);

    toggleAlert(alert, false);
}