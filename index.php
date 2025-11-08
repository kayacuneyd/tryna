<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/language.php';

$page_title = t('brand.name');
$page_description = t('hero.subtitle');
include __DIR__ . '/includes/header.php';
?>
<main>
    <section class="hero-gradient min-h-[70vh] flex items-center">
        <div class="container mx-auto px-4 py-16 grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="space-y-6">
                <p class="text-sm uppercase tracking-[0.3em] text-[#5E738A]"><?php echo t('home.location_badge'); ?></p>
                <h1 class="text-5xl lg:text-6xl font-semibold leading-tight text-[#1C1E21]">
                    <?php echo t('hero.title'); ?>
                </h1>
                <p class="text-lg text-[#5E738A] max-w-xl">
                    <?php echo t('hero.subtitle'); ?>
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="/<?php echo $current_lang; ?>/portfolio" class="px-6 py-3 bg-[#5E9387] text-white rounded-full uppercase tracking-wide text-xs">
                        <?php echo t('hero.cta_portfolio'); ?>
                    </a>
                    <a href="/<?php echo $current_lang; ?>/contact" class="px-6 py-3 border border-[#5E9387] rounded-full text-xs tracking-wide">
                        <?php echo t('hero.cta_contact'); ?>
                    </a>
                </div>
            </div>
            <div class="relative">
                <div class="absolute -top-8 -left-8 w-24 h-24 border border-[#D8C9B1]"></div>
                <img src="https://images.pexels.com/photos/274973/pexels-photo-274973.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940" alt="Portrait" class="rounded-2xl shadow-soft object-cover w-full h-full min-h-[420px]" loading="lazy">
            </div>
        </div>
    </section>

    <section class="container mx-auto px-4 py-16 grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php foreach (t('services.list') as $index => $service): ?>
            <div class="service-card group bg-white p-8 rounded-2xl shadow-soft border border-[#D8C9B1]/40 
                        transform transition-all duration-500 ease-out cursor-pointer
                        hover:scale-105 hover:shadow-xl hover:border-[#5E9387]/60 hover:-translate-y-3
                        opacity-0 translate-y-8 animate-fade-in-up"
                 style="animation-delay: <?php echo $index * 150; ?>ms;">
                <p class="text-sm uppercase tracking-[0.3em] text-[#5E738A] mb-4 
                         transition-all duration-300 group-hover:text-[#5E9387] group-hover:tracking-[0.4em]">
                    <?php echo t('services.title'); ?>
                </p>
                <h3 class="text-2xl font-semibold text-[#1C1E21] 
                          transition-all duration-300 group-hover:text-[#5E9387] group-hover:scale-105 origin-left">
                    <?php echo $service; ?>
                </h3>
            </div>
        <?php endforeach; ?>
    </section>

    <section class="bg-white py-16">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-[#5E738A]"><?php echo t('home.case_badge'); ?></p>
                    <h2 class="text-4xl font-semibold text-[#1C1E21]"><?php echo t('home.case_title'); ?></h2>
                </div>
                <a href="/<?php echo $current_lang; ?>/portfolio" class="text-[#5E9387] font-semibold"><?php echo t('home.view_all'); ?></a>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <?php foreach (array_slice(get_case_studies(), 0, 3) as $study): ?>
                    <article class="rounded-2xl overflow-hidden border border-[#D8C9B1]/50">
                        <div class="h-64 bg-cover bg-center" style="background-image:url('<?php echo $study['images'][0]; ?>');"></div>
                        <div class="p-6 space-y-3">
                            <p class="text-xs uppercase tracking-[0.3em] text-[#5E738A]"><?php echo strtoupper($study['category']); ?></p>
                            <h3 class="text-2xl font-semibold">
                                <?php echo $study['title'][$current_lang] ?? $study['title']['en']; ?>
                            </h3>
                            <p class="text-[#5E738A] text-sm">
                                <?php echo $study['description'][$current_lang] ?? $study['description']['en']; ?>
                            </p>
                            <a href="/<?php echo $current_lang; ?>/portfolio/<?php echo $study['slug']; ?>" class="inline-flex items-center gap-2 text-[#5E9387] font-semibold">
                                <?php echo t('home.explore'); ?>
                                <span>&rarr;</span>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
