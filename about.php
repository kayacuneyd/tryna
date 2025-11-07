<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/language.php';

$page_title = t('about.title') . ' - ' . t('brand.name');
$page_description = t('about.intro');
include __DIR__ . '/includes/header.php';
?>
<main class="container mx-auto px-4 py-12 grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
    <div>
        <p class="text-sm uppercase tracking-[0.3em] text-[#5E738A] mb-4"><?php echo t('about.title'); ?></p>
        <h1 class="text-4xl font-semibold text-[#1C1E21] mb-6"><?php echo t('hero.title'); ?></h1>
        <p class="text-lg text-[#5E738A] leading-relaxed mb-6">
            <?php echo t('about.intro'); ?>
        </p>
        <p class="text-[#1C1E21] mb-4">
            <?php echo t('about_page.secondary'); ?>
        </p>
        <div class="grid grid-cols-2 gap-6">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-[#5E738A]"><?php echo t('about_page.stats.years_label'); ?></p>
                <p class="text-3xl font-semibold"><?php echo t('about_page.stats.years_value'); ?></p>
            </div>
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-[#5E738A]"><?php echo t('about_page.stats.clients_label'); ?></p>
                <p class="text-3xl font-semibold"><?php echo t('about_page.stats.clients_value'); ?></p>
            </div>
        </div>
    </div>
    <div class="relative">
        <div class="absolute -bottom-6 -right-6 w-24 h-24 border border-[#D8C9B1]"></div>
        <img src="https://images.pexels.com/photos/3643924/pexels-photo-3643924.jpeg?auto=compress&cs=tinysrgb&h=750&w=1260" alt="Studio" class="rounded-2xl shadow-soft object-cover w-full h-[520px]" loading="lazy">
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
