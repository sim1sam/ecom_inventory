(function () {
    'use strict';

    var STORAGE_KEY = 'pwa_install_dismissed_until';
    var DISMISS_DAYS = 7;
    var deferredPrompt = null;
    var popup = document.getElementById('pwaInstallPopup');
    if (!popup) {
        return;
    }

    var installBtn = document.getElementById('pwaInstallBtn');
    var dismissBtn = document.getElementById('pwaInstallDismiss');

    function isMobile() {
        return window.matchMedia('(max-width: 767.98px)').matches;
    }

    function isStandalone() {
        return (
            window.matchMedia('(display-mode: standalone)').matches ||
            window.navigator.standalone === true
        );
    }

    function isDismissed() {
        try {
            var until = parseInt(localStorage.getItem(STORAGE_KEY) || '0', 10);
            return Date.now() < until;
        } catch (e) {
            return false;
        }
    }

    function dismissPopup() {
        popup.classList.remove('is-visible');
        popup.setAttribute('aria-hidden', 'true');
        try {
            localStorage.setItem(
                STORAGE_KEY,
                String(Date.now() + DISMISS_DAYS * 24 * 60 * 60 * 1000)
            );
        } catch (e) {
            /* ignore */
        }
    }

    function showPopup() {
        if (isStandalone() || isDismissed()) {
            return;
        }

        popup.classList.add('is-visible');
        popup.setAttribute('aria-hidden', 'false');
    }

    window.addEventListener('beforeinstallprompt', function (e) {
        e.preventDefault();
        deferredPrompt = e;
        showPopup();
    });

    window.addEventListener('appinstalled', function () {
        deferredPrompt = null;
        dismissPopup();
    });

    if ('serviceWorker' in navigator) {
        window.addEventListener('load', function () {
            navigator.serviceWorker
                .register('/sw.js', { scope: '/' })
                .catch(function () {
                    /* SW registration failed */
                });
        });
    }

    if (installBtn) {
        installBtn.addEventListener('click', function () {
            if (deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.finally(function () {
                    deferredPrompt = null;
                    dismissPopup();
                });
            }
        });
    }

    if (dismissBtn) {
        dismissBtn.addEventListener('click', dismissPopup);
    }

    popup.addEventListener('click', function (e) {
        if (e.target === popup) {
            dismissPopup();
        }
    });

    window.addEventListener('load', function () {
        if (isStandalone() || isDismissed()) {
            return;
        }

        setTimeout(function () {
            if (deferredPrompt || isMobile()) {
                showPopup();
            }
        }, 2500);
    });
})();
