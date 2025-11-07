class Lightbox {
    constructor() {
        this.modal = document.getElementById('lightbox');
        this.image = document.getElementById('lightboxImage');
        this.caption = document.getElementById('lightboxCaption');
        this.closeBtn = document.getElementById('closeLightbox');
        this.bindEvents();
    }

    bindEvents() {
        if (this.closeBtn) {
            this.closeBtn.addEventListener('click', () => this.close());
        }

        if (this.modal) {
            this.modal.addEventListener('click', (event) => {
                if (event.target === this.modal) {
                    this.close();
                }
            });
        }

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                this.close();
            }
        });
    }

    open(imageSrc, caption = '') {
        if (!this.modal || !this.image) return;
        this.image.src = imageSrc;
        if (this.caption) {
            this.caption.textContent = caption;
        }
        this.modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    close() {
        if (!this.modal) return;
        this.modal.classList.add('hidden');
        document.body.style.overflow = '';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('lightbox')) {
        window.lightbox = new Lightbox();
    }
});