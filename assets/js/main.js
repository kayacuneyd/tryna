// Main JavaScript file - global functions
const initUI = () => {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    const closeMobileMenu = () => {
        if (!mobileMenu || !mobileMenuBtn) return;
        mobileMenu.classList.add('hidden');
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
    };

    const closeLangDropdown = () => {
        if (!langDropdown || !langButton) return;
        langDropdown.classList.add('hidden');
        langButton.setAttribute('aria-expanded', 'false');
    };

    const buildEventPath = (event) => {
        if (typeof event.composedPath === 'function') {
            return event.composedPath();
        }

        const path = [];
        let node = event.target;
        while (node) {
            path.push(node);
            node = node.parentNode;
        }
        path.push(window);
        return path;
    };

    const isEventInside = (event, elements) => {
        const path = buildEventPath(event);
        return elements.some((element) => element && path.includes(element));
    };

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.setAttribute('aria-expanded', 'false');

        mobileMenuBtn.addEventListener('click', (event) => {
            event.stopPropagation();
            const isHidden = mobileMenu.classList.toggle('hidden');
            mobileMenuBtn.setAttribute('aria-expanded', (!isHidden).toString());
            if (!isHidden) {
                closeLangDropdown();
            }
        });

        if (typeof window.matchMedia === 'function') {
            const desktopQuery = window.matchMedia('(min-width: 768px)');
            const handleDesktopChange = (event) => {
                if (event.matches) {
                    closeMobileMenu();
                }
            };

            // Immediately sync in case the script loads after a resize.
            handleDesktopChange(desktopQuery);
            desktopQuery.addEventListener('change', handleDesktopChange);
        }
    }

    const langButton = document.getElementById('langButton');
    const langDropdown = document.getElementById('langDropdown');

    if (langButton && langDropdown) {
        langButton.setAttribute('aria-expanded', 'false');
        langButton.addEventListener('click', (event) => {
            event.stopPropagation();
            const isHidden = langDropdown.classList.toggle('hidden');
            langButton.setAttribute('aria-expanded', (!isHidden).toString());
            if (!isHidden) {
                closeMobileMenu();
            }
        });
    }

    const handleGlobalEvent = (event) => {
        if (langDropdown && langButton && !isEventInside(event, [langDropdown, langButton])) {
            closeLangDropdown();
        }

        if (mobileMenu && mobileMenuBtn && !isEventInside(event, [mobileMenu, mobileMenuBtn])) {
            closeMobileMenu();
        }
    };

    document.addEventListener('click', handleGlobalEvent);
    document.addEventListener('touchstart', handleGlobalEvent);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeLangDropdown();
            closeMobileMenu();
        }
    });

    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener('click', (event) => {
            const hash = anchor.getAttribute('href');
            const target = document.querySelector(hash);
            if (target) {
                event.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    if ('loading' in HTMLImageElement.prototype) {
        document.querySelectorAll('img[loading="lazy"]').forEach((img) => {
            img.src = img.dataset.src || img.src;
        });
    }
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initUI);
} else {
    initUI();
}
