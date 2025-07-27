function openSocialLogin(url) {
    let width = 700;
    let height = 800;
    let left = (screen.width - width) / 2;
    let top = (screen.height - height) / 2;

    let loginWindow = window.open(url, 'SocialLogin', `width=${width},height=${height},top=${top},left=${left}`);

    let timer = setInterval(() => {
        if (loginWindow && loginWindow.closed) {
            clearInterval(timer);
            window.location.reload();
        }
    }, 1000);
}