// Main JavaScript file - global functions
const initUI = () => {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    const closeMobileMenu = () => {
        if (!mobileMenu || !mobileMenuBtn) return;
        mobileMenu.classList.add('hidden');
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
    };

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.setAttribute('aria-expanded', 'false');

        mobileMenuBtn.addEventListener('click', (event) => {
            event.stopPropagation();
            const isHidden = mobileMenu.classList.toggle('hidden');
            mobileMenuBtn.setAttribute('aria-expanded', (!isHidden).toString());
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
        langButton.addEventListener('click', (event) => {
            event.stopPropagation();
            langDropdown.classList.toggle('hidden');
        });
    }

    document.addEventListener('click', (event) => {
        const target = event.target;

        if (langDropdown && langButton && !langDropdown.contains(target) && !langButton.contains(target)) {
            langDropdown.classList.add('hidden');
        }
        if (
            mobileMenu &&
            mobileMenuBtn &&
            !mobileMenu.contains(target) &&
            !mobileMenuBtn.contains(target) &&
            !mobileMenu.classList.contains('hidden')
        ) {
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
