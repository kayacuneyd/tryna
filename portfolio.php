<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/language.php';
require_once __DIR__ . '/includes/functions.php';

$caseStudies = get_case_studies();
$page_title = t('nav.portfolio') . ' - ' . t('brand.name');
$page_description = t('hero.subtitle');
$page_scripts = ['/assets/js/portfolio.js', '/assets/js/lightbox.js'];
$portfolioStrings = [
    'all' => t('portfolio.all'),
    'load_more' => t('portfolio.load_more'),
    'loading' => t('portfolio.loading'),
    'error' => t('portfolio.error'),
    'case_heading' => t('portfolio.case_heading'),
    'case_subheading' => t('portfolio.case_subheading'),
    'case_cta' => t('portfolio.case_cta'),
    'case_empty' => t('portfolio.case_empty'),
    'photo_fallback' => t('portfolio.photo_fallback'),
    'untitled' => t('common.untitled'),
];
$collectionId = htmlspecialchars(PEXELS_COLLECTION_ID, ENT_QUOTES, 'UTF-8');

include __DIR__ . '/includes/header.php';
?>
<main class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-center mb-10"><?php echo t('nav.portfolio'); ?></h1>
    <div class="flex flex-wrap justify-center gap-3 mb-12">
        <button class="filter-btn active px-6 py-2 rounded-full bg-[#5E9387] text-white" data-category="all">
            <?php echo $portfolioStrings['all']; ?>
        </button>
        <button class="filter-btn px-6 py-2 rounded-full border border-[#5E9387]" data-category="portraits"><?php echo t('categories.portraits'); ?></button>
        <button class="filter-btn px-6 py-2 rounded-full border border-[#5E9387]" data-category="nature"><?php echo t('categories.nature'); ?></button>
        <button class="filter-btn px-6 py-2 rounded-full border border-[#5E9387]" data-category="corporate"><?php echo t('categories.corporate'); ?></button>
    </div>
    <div 
        id="portfolio-grid" 
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
        data-collection="<?php echo $collectionId; ?>"
        data-loading="<?php echo htmlspecialchars($portfolioStrings['loading'], ENT_QUOTES, 'UTF-8'); ?>"
        data-error="<?php echo htmlspecialchars($portfolioStrings['error'], ENT_QUOTES, 'UTF-8'); ?>"
        data-photo-fallback="<?php echo htmlspecialchars($portfolioStrings['photo_fallback'], ENT_QUOTES, 'UTF-8'); ?>"
        data-untitled="<?php echo htmlspecialchars($portfolioStrings['untitled'], ENT_QUOTES, 'UTF-8'); ?>"
    >
        <div class="text-center col-span-full py-12">
            <p class="text-gray-500"><?php echo htmlspecialchars($portfolioStrings['loading'], ENT_QUOTES, 'UTF-8'); ?></p>
        </div>
    </div>
    <div class="text-center mt-12">
        <button id="loadMoreBtn" class="px-8 py-3 bg-[#5E9387] text-white rounded-lg hover:bg-[#4a7769] transition">
            <?php echo htmlspecialchars($portfolioStrings['load_more'], ENT_QUOTES, 'UTF-8'); ?>
        </button>
    </div>
</main>
<?php if (!empty($caseStudies)): ?>
<section class="container mx-auto px-4 py-16" data-case-section>
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6 mb-10">
        <div>
            <p class="text-sm uppercase tracking-[0.3em] text-[#5E738A]"><?php echo $portfolioStrings['case_heading']; ?></p>
            <h2 class="text-3xl md:text-4xl font-semibold text-[#1C1E21] mt-2"><?php echo t('nav.portfolio'); ?> / <?php echo $portfolioStrings['case_heading']; ?></h2>
            <p class="text-[#5E738A] mt-3 max-w-2xl"><?php echo $portfolioStrings['case_subheading']; ?></p>
        </div>
    </div>
    <div id="case-studies-grid" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
        <?php foreach ($caseStudies as $case): 
            $title = $case['title'][$current_lang] ?? $case['title']['en'];
            $description = $case['description'][$current_lang] ?? $case['description']['en'];
            if (function_exists('mb_strlen')) {
                $excerpt = mb_strlen($description) > 140 ? mb_substr($description, 0, 137) . '…' : $description;
            } else {
                $excerpt = strlen($description) > 140 ? substr($description, 0, 137) . '…' : $description;
            }
            $cover = $case['images'][0] ?? '/assets/images/placeholder.jpg';
            ?>
            <article class="bg-white rounded-2xl shadow-soft border border-[#D8C9B1]/50 overflow-hidden flex flex-col" data-case-card data-category="<?php echo htmlspecialchars($case['category'], ENT_QUOTES, 'UTF-8'); ?>">
                <div class="h-60 bg-cover bg-center" style="background-image:url('<?php echo htmlspecialchars($cover, ENT_QUOTES, 'UTF-8'); ?>');"></div>
                <div class="p-6 flex flex-col flex-1">
                    <p class="text-xs uppercase tracking-[0.3em] text-[#5E738A] mb-2"><?php echo strtoupper($case['category']); ?></p>
                    <h3 class="text-2xl font-semibold text-[#1C1E21] mb-3"><?php echo htmlspecialchars($title, ENT_QUOTES, 'UTF-8'); ?></h3>
                    <p class="text-[#5E738A] mb-4 flex-1"><?php echo htmlspecialchars($excerpt, ENT_QUOTES, 'UTF-8'); ?></p>
                    <div class="flex items-center justify-between mt-auto">
                        <span class="text-sm text-[#5E738A]"><?php echo htmlspecialchars($case['client'], ENT_QUOTES, 'UTF-8'); ?></span>
                        <a href="/<?php echo $current_lang; ?>/portfolio/<?php echo $case['slug']; ?>" class="inline-flex items-center gap-2 text-[#5E9387] font-semibold hover:text-[#1C1E21] transition">
                            <?php echo $portfolioStrings['case_cta']; ?>
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </article>
        <?php endforeach; ?>
    </div>
    <div id="case-studies-empty" class="hidden text-center text-[#5E738A] mt-10">
        <?php echo $portfolioStrings['case_empty']; ?>
    </div>
</section>
<?php endif; ?>
<div id="lightbox" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center">
    <button id="closeLightbox" class="absolute top-4 right-4 text-white text-4xl">&times;</button>
    <img id="lightboxImage" src="" alt="" class="max-w-full max-h-full object-contain">
    <div id="lightboxCaption" class="absolute bottom-4 left-4 right-4 text-white text-center"></div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
