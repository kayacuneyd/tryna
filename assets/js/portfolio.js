class CaseStudyManager {
    constructor() {
        this.grid = document.getElementById('case-studies-grid');
        this.cards = this.grid ? Array.from(this.grid.querySelectorAll('[data-case-card]')) : [];
        this.emptyState = document.getElementById('case-studies-empty');
    }

    filter(category) {
        if (!this.grid || !this.cards.length) {
            return;
        }

        let visibleCount = 0;
        this.cards.forEach((card) => {
            const matches = category === 'all' || card.dataset.category === category;
            card.classList.toggle('hidden', !matches);
            if (matches) visibleCount += 1;
        });

        if (this.emptyState) {
            this.emptyState.classList.toggle('hidden', visibleCount > 0);
        }
    }
}

class PortfolioManager {
    constructor() {
        this.currentPage = 1;
        this.currentCategory = 'all';
        this.isLoading = false;
        this.grid = document.getElementById('portfolio-grid');
        this.loadMoreBtn = document.getElementById('loadMoreBtn');
        this.collectionId = this.grid?.dataset.collection || '';
        this.loadingText = this.grid?.dataset.loading || 'Loading portfolio...';
        this.errorText = this.grid?.dataset.error || 'Unable to load portfolio at the moment.';
        this.photoFallback = this.grid?.dataset.photoFallback || 'Photo by Enes Türkoğlu';
        this.untitledText = this.grid?.dataset.untitled || 'Untitled';
        this.caseStudyManager = new CaseStudyManager();

        if (this.grid) {
            this.showMessage(this.loadingText);
        }

        this.bindEvents();
        this.loadPhotos();
        this.caseStudyManager.filter(this.currentCategory);
    }

    bindEvents() {
        document.querySelectorAll('.filter-btn').forEach((btn) => {
            btn.addEventListener('click', () => {
                this.handleFilterClick(btn);
            });
        });

        if (this.loadMoreBtn) {
            this.loadMoreBtn.addEventListener('click', () => {
                this.currentPage += 1;
                this.loadPhotos();
            });
        }
    }

    handleFilterClick(button) {
        document.querySelectorAll('.filter-btn').forEach((btn) => {
            btn.classList.remove('active', 'bg-[#5E9387]', 'text-white');
        });

        button.classList.add('active', 'bg-[#5E9387]', 'text-white');
        this.currentCategory = button.dataset.category;
        this.currentPage = 1;
        if (this.grid) {
            this.showMessage(this.loadingText);
        }
        this.caseStudyManager.filter(this.currentCategory);
        this.loadPhotos(true);
    }

    async loadPhotos(reset = false) {
        if (this.isLoading) return;
        this.isLoading = true;

        if (reset && this.loadMoreBtn) {
            this.loadMoreBtn.disabled = true;
        }

        try {
            const params = new URLSearchParams({
                page: this.currentPage,
                per_page: 15,
                category: this.currentCategory,
            });

            if (this.collectionId) {
                params.append('collection_id', this.collectionId);
            }

            const response = await fetch(`/api/pexels.php?${params.toString()}`);
            if (!response.ok) throw new Error('Network error');
            const data = await response.json();
            if (data.error) {
                throw new Error(data.error);
            }
            this.renderPhotos(data.photos || []);
        } catch (error) {
            console.error('Error loading photos:', error);
            if (this.grid) {
                this.showMessage(this.errorText, 'text-red-500');
            }
        } finally {
            if (this.loadMoreBtn) {
                this.loadMoreBtn.disabled = false;
            }
            this.isLoading = false;
        }
    }

    renderPhotos(photos) {
        if (!this.grid) return;
        if (this.currentPage === 1) {
            this.grid.innerHTML = '';
        }

        photos.forEach((photo) => {
            const card = this.createPhotoCard(photo);
            this.grid.appendChild(card);
        });
    }

    createPhotoCard(photo) {
        const div = document.createElement('div');
        div.className = 'portfolio-item relative group cursor-pointer overflow-hidden rounded-lg';
        div.innerHTML = `
            <img 
                src="${photo.src.large}" 
                alt="${photo.alt || this.photoFallback}"
                class="w-full h-80 object-cover transition-transform duration-300 group-hover:scale-110"
                loading="lazy"
            >
            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition-all duration-300 flex items-end p-4">
                <p class="text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    ${photo.alt || this.untitledText}
                </p>
            </div>
        `;

        div.addEventListener('click', () => {
            if (window.lightbox) {
                window.lightbox.open(photo.src.large2x || photo.src.large, photo.alt);
            }
        });

        return div;
    }

    showMessage(message, textClass = 'text-gray-500') {
        if (!this.grid) return;
        this.grid.innerHTML = '';

        const wrapper = document.createElement('div');
        wrapper.className = 'text-center col-span-full py-12';

        const textEl = document.createElement('p');
        textEl.className = textClass;
        textEl.textContent = message;

        wrapper.appendChild(textEl);
        this.grid.appendChild(wrapper);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('portfolio-grid')) {
        window.portfolioManager = new PortfolioManager();
    }
});
