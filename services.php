<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/language.php';

$page_title = t('services.title') . ' - ' . t('brand.name');
$page_description = t('services_page.card_description');
include __DIR__ . '/includes/header.php';
?>
<main class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-center mb-12"><?php echo t('services.title'); ?></h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php foreach (t('services.list') as $service): ?>
            <div class="bg-white p-8 rounded-2xl shadow-soft border border-[#D8C9B1]/50 flex flex-col justify-between">
                <h2 class="text-2xl font-semibold mb-4"><?php echo $service; ?></h2>
                <p class="text-[#5E738A]"><?php echo t('services_page.card_description'); ?></p>
                <a href="/<?php echo $current_lang; ?>/contact" class="mt-6 inline-flex items-center gap-2 text-[#5E9387] font-semibold">
                    <?php echo t('services_page.cta'); ?> &rarr;
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
