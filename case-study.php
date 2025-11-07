<?php
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/language.php';

$slug = $_GET['slug'] ?? '';
$case_study = $slug ? get_case_study_by_slug($slug) : null;

if (!$case_study) {
    http_response_code(404);
    $page_title = t('case_page.missing_title') . ' - ' . t('brand.name');
} else {
    $title = $case_study['title'][$current_lang] ?? $case_study['title']['en'];
    $page_title = $title . ' - ' . t('brand.name');
    $page_description = substr($case_study['description'][$current_lang] ?? $case_study['description']['en'], 0, 150);
}

include __DIR__ . '/includes/header.php';
?>
<main class="container mx-auto px-4 py-12">
    <?php if (!$case_study): ?>
        <section class="text-center py-32">
            <h1 class="text-4xl font-bold mb-4"><?php echo t('case_page.missing_title'); ?></h1>
            <p class="text-gray-500 mb-6"><?php echo t('case_page.missing_body'); ?></p>
            <a href="/<?php echo $current_lang; ?>/portfolio" class="px-6 py-3 bg-[#5E9387] text-white rounded-full">
                <?php echo t('case_page.back_cta'); ?>
            </a>
        </section>
    <?php else: ?>
        <?php
        $categoryKey = 'categories.' . $case_study['category'];
        $categoryLabel = t($categoryKey);
        if ($categoryLabel === $categoryKey) {
            $categoryLabel = ucfirst($case_study['category']);
        }
        if (function_exists('mb_strtoupper')) {
            $categoryLabel = mb_strtoupper($categoryLabel, 'UTF-8');
        } else {
            $categoryLabel = strtoupper($categoryLabel);
        }
        ?>
        <p class="text-sm uppercase tracking-[0.3em] text-[#5E738A] mb-2"><?php echo $categoryLabel; ?></p>
        <h1 class="text-4xl font-bold mb-4"><?php echo $case_study['title'][$current_lang] ?? $case_study['title']['en']; ?></h1>
        <div class="text-[#5E738A] mb-8 space-y-1">
            <p><strong><?php echo t('case_page.client'); ?>:</strong> <?php echo $case_study['client']; ?></p>
            <p><strong><?php echo t('case_page.date'); ?>:</strong> <?php echo date('F j, Y', strtotime($case_study['date'])); ?></p>
            <p><strong><?php echo t('case_page.equipment'); ?>:</strong> <?php echo $case_study['equipment']; ?></p>
        </div>
        <div class="prose prose-invert max-w-none text-lg text-[#1C1E21] mb-12">
            <p><?php echo $case_study['description'][$current_lang] ?? $case_study['description']['en']; ?></p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <?php foreach ($case_study['images'] as $image): ?>
                <img src="<?php echo $image; ?>" alt="<?php echo $case_study['title'][$current_lang] ?? $case_study['title']['en']; ?>" class="w-full h-80 object-cover rounded-xl" loading="lazy">
            <?php endforeach; ?>
        </div>
        <?php if (!empty($case_study['testimonial']['text'])): ?>
            <blockquote class="bg-white border border-[#D8C9B1]/50 rounded-2xl p-8 text-xl italic text-[#1C1E21]">
                "<?php echo $case_study['testimonial']['text']; ?>"
                <span class="block mt-4 text-sm uppercase tracking-[0.3em] text-[#5E738A]"><?php echo $case_study['testimonial']['author']; ?></span>
            </blockquote>
        <?php endif; ?>
    <?php endif; ?>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
