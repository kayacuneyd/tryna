// Main JavaScript file - global functions
document.addEventListener('DOMContentLoaded', () => {
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');

    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    const langButton = document.getElementById('langButton');
    const langDropdown = document.getElementById('langDropdown');

    if (langButton && langDropdown) {
        langButton.addEventListener('click', (event) => {
            event.stopPropagation();
            langDropdown.classList.toggle('hidden');
        });

        document.addEventListener('click', () => {
            langDropdown.classList.add('hidden');
        });
    }

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
});