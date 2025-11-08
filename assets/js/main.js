// Main JavaScript file - global functions
(function () {
    function onReady(callback) {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', callback);
        } else {
            callback();
        }
    }

    function toggleHidden(element, force) {
        if (!element) return;
        if (typeof force === 'boolean') {
            if (force) {
                element.classList.add('hidden');
            } else {
                element.classList.remove('hidden');
            }
            return;
        }
        element.classList.toggle('hidden');
    }

    function setExpanded(trigger, state) {
        if (!trigger) return;
        trigger.setAttribute('aria-expanded', state ? 'true' : 'false');
    }

    function isInside(target, elements) {
        for (var i = 0; i < elements.length; i += 1) {
            var element = elements[i];
            if (element && element.contains(target)) {
                return true;
            }
        }
        return false;
    }

    onReady(function () {
        var mobileMenuBtn = document.getElementById('mobileMenuBtn');
        var mobileMenu = document.getElementById('mobileMenu');
        var langButton = document.getElementById('langButton');
        var langDropdown = document.getElementById('langDropdown');

        function closeMobileMenu() {
            toggleHidden(mobileMenu, true);
            setExpanded(mobileMenuBtn, false);
        }

        function closeLangDropdown() {
            toggleHidden(langDropdown, true);
            setExpanded(langButton, false);
        }

        function toggleMobileMenu() {
            if (!mobileMenu || !mobileMenuBtn) return;
            var isOpen = !mobileMenu.classList.contains('hidden');
            if (isOpen) {
                closeMobileMenu();
            } else {
                toggleHidden(mobileMenu, false);
                setExpanded(mobileMenuBtn, true);
                closeLangDropdown();
            }
        }

        function toggleLangDropdown() {
            if (!langDropdown || !langButton) return;
            var isOpen = !langDropdown.classList.contains('hidden');
            if (isOpen) {
                closeLangDropdown();
            } else {
                toggleHidden(langDropdown, false);
                setExpanded(langButton, true);
                closeMobileMenu();
            }
        }

        if (mobileMenuBtn) {
            mobileMenuBtn.setAttribute('aria-expanded', 'false');
            mobileMenuBtn.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                toggleMobileMenu();
            });
            mobileMenuBtn.addEventListener('touchstart', function (event) {
                event.preventDefault();
                event.stopPropagation();
                toggleMobileMenu();
            });
        }

        if (langButton) {
            langButton.setAttribute('aria-expanded', 'false');
            langButton.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                toggleLangDropdown();
            });
            langButton.addEventListener('touchstart', function (event) {
                event.preventDefault();
                event.stopPropagation();
                toggleLangDropdown();
            });
        }

        if (mobileMenu) {
            var mobileLinks = mobileMenu.querySelectorAll('a');
            for (var i = 0; i < mobileLinks.length; i += 1) {
                mobileLinks[i].addEventListener('click', closeMobileMenu);
            }
        }

        function handleDocumentInteraction(event) {
            var target = event.target;

            if (mobileMenu && mobileMenuBtn && !isInside(target, [mobileMenu, mobileMenuBtn])) {
                closeMobileMenu();
            }

            if (langDropdown && langButton && !isInside(target, [langDropdown, langButton])) {
                closeLangDropdown();
            }
        }

        document.addEventListener('click', handleDocumentInteraction);
        document.addEventListener('touchstart', handleDocumentInteraction);

        document.addEventListener('keydown', function (event) {
            var key = event.key || event.keyCode;
            if (key === 'Escape' || key === 'Esc' || key === 27) {
                closeLangDropdown();
                closeMobileMenu();
            }
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 768) {
                closeMobileMenu();
            }
        });

        var anchorLinks = document.querySelectorAll('a[href^="#"]');
        for (var j = 0; j < anchorLinks.length; j += 1) {
            anchorLinks[j].addEventListener('click', function (event) {
                var hash = this.getAttribute('href');
                var target = document.querySelector(hash);
                if (target) {
                    event.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth' });
                }
            });
        }

        if ('loading' in HTMLImageElement.prototype) {
            var lazyImages = document.querySelectorAll('img[loading="lazy"]');
            for (var k = 0; k < lazyImages.length; k += 1) {
                var img = lazyImages[k];
                img.src = img.dataset.src || img.src;
            }
        }
    });
})();
