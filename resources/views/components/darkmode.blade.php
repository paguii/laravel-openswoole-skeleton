<div id="theme-toggle" class="d-flex align-items-center gap-2">
    <label for="dark-mode-input"><i class="bi bi-brightness-high"></i></i></label>
    <div class="form-check form-switch m-0">
        <input class="form-check-input" type="checkbox" id="dark-mode-input">
    </div>
    <label for="dark-mode-input"><i class="bi bi-moon-fill"></i></label>
</div>
<script>
    function changeImagesToDarkMode(isDarkMode) {
        let images = document.querySelectorAll('.toggle-image-dark');

        images.forEach(element => {
            const originalSrc = element.getAttribute('data-original') || element.src;
            if (isDarkMode) {
                if (!element.hasAttribute('data-original')) {
                    element.setAttribute('data-original', originalSrc);
                }

                const extension = originalSrc.match(/(\.[\w\d_-]+)$/i);
                const darkSrc = originalSrc.replace(extension[0], '_dark' + extension[0]);
                element.src = darkSrc;
            } else {
                if (element.hasAttribute('data-original')) {
                    element.src = element.getAttribute('data-original');
                }
            }
        });
    }

    document.getElementById('dark-mode-input').addEventListener('change', function () {
        changeImagesToDarkMode(this.checked);
    });

    let isDarkmode = localStorage.getItem('theme') == 'dark' ? true : false;

    document.addEventListener("DOMContentLoaded", function () {
        changeImagesToDarkMode(isDarkmode);
    });

</script>