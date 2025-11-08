// Main JavaScript file - global functions
const initUI = () => {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const langButton = document.getElementById('langButton');
    const langDropdown = document.getElementById('langDropdown');

    const toggleHidden = (element, force) => {
        if (!element) return;
        if (typeof force === 'boolean') {
            element.classList.toggle('hidden', force);
        } else {
            element.classList.toggle('hidden');
        }
    };

    const setExpanded = (trigger, state) => {
        if (!trigger) return;
        trigger.setAttribute('aria-expanded', state ? 'true' : 'false');
    };

    const isInside = (target, ...elements) => {
        return elements.some((element) => element && element.contains(target));
    };

    const closeMobileMenu = () => {
        toggleHidden(mobileMenu, true);
        setExpanded(mobileMenuBtn, false);
    };

    const closeLangDropdown = () => {
        toggleHidden(langDropdown, true);
        setExpanded(langButton, false);
    };

    const openMobileMenu = () => {
        toggleHidden(mobileMenu, false);
        setExpanded(mobileMenuBtn, true);
        closeLangDropdown();
    };

    const openLangDropdown = () => {
        toggleHidden(langDropdown, false);
        setExpanded(langButton, true);
        closeMobileMenu();
    };

    const toggleMobileMenu = () => {
        if (!mobileMenu || !mobileMenuBtn) return;
        const isOpen = !mobileMenu.classList.contains('hidden');
        if (isOpen) {
            closeMobileMenu();
        } else {
            openMobileMenu();
        }
    };

    const toggleLangDropdown = () => {
        if (!langDropdown || !langButton) return;
        const isOpen = !langDropdown.classList.contains('hidden');
        if (isOpen) {
            closeLangDropdown();
        } else {
            openLangDropdown();
        }
    };

    if (mobileMenuBtn) {
        mobileMenuBtn.setAttribute('aria-expanded', 'false');
        mobileMenuBtn.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            toggleMobileMenu();
        });
    }

    if (langButton) {
        langButton.setAttribute('aria-expanded', 'false');
        langButton.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();
            toggleLangDropdown();
        });
    }

    if (mobileMenu) {
        mobileMenu.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', closeMobileMenu);
        });
    }

    const handleDocumentClick = (event) => {
        const target = event.target;

        if (mobileMenu && mobileMenuBtn && !isInside(target, mobileMenu, mobileMenuBtn)) {
            closeMobileMenu();
        }

        if (langDropdown && langButton && !isInside(target, langDropdown, langButton)) {
            closeLangDropdown();
        }
    };

    document.addEventListener('click', handleDocumentClick);

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            closeLangDropdown();
            closeMobileMenu();
        }
    });

    window.addEventListener(
        'resize',
        () => {
            if (window.innerWidth >= 768) {
                closeMobileMenu();
            }
        },
        { passive: true },
    );

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
