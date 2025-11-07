<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/language.php';
require_once __DIR__ . '/functions.php';

if (!headers_sent()) {
    header('Content-Type: text/html; charset=UTF-8');
}

$langFlags = [
    'tr' => '🇹🇷',
    'en' => '🇬🇧',
    'de' => '🇩🇪',
];
$langNames = [
    'tr' => 'Türkçe',
    'en' => 'English',
    'de' => 'Deutsch',
];
$currentFlag = $langFlags[$current_lang] ?? '🌐';
$currentLabel = $langNames[$current_lang] ?? strtoupper($current_lang);
?>
<!DOCTYPE html>
<html lang="<?php echo $current_lang; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? SITE_NAME; ?></title>
    <meta name="description" content="<?php echo $page_description ?? t('hero.subtitle'); ?>">
    <link rel="icon" type="image/png" href="/assets/images/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="/assets/css/custom.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
    <meta property="og:title" content="<?php echo $page_title ?? SITE_NAME; ?>">
    <meta property="og:description" content="<?php echo $page_description ?? t('hero.subtitle'); ?>">
    <meta property="og:image" content="<?php echo $og_image ?? '/assets/images/og-default.jpg'; ?>">
    <meta property="og:url" content="<?php echo SITE_URL . $_SERVER['REQUEST_URI']; ?>">
    <meta property="og:type" content="website">
</head>
<body class="bg-[#F2F2EF] text-[#1C1E21] font-['Source_Sans_Pro']">
<header class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="/<?php echo $current_lang; ?>" class="text-2xl font-bold text-[#1C1E21] tracking-tight">
            <?php echo t('brand.logo'); ?>
        </a>
        <ul class="hidden md:flex space-x-8 font-semibold">
            <li><a href="/<?php echo $current_lang; ?>" class="hover:text-[#5E9387] transition"><?php echo t('nav.home'); ?></a></li>
            <li><a href="/<?php echo $current_lang; ?>/portfolio" class="hover:text-[#5E9387] transition"><?php echo t('nav.portfolio'); ?></a></li>
            <li><a href="/<?php echo $current_lang; ?>/about" class="hover:text-[#5E9387] transition"><?php echo t('nav.about'); ?></a></li>
            <li><a href="/<?php echo $current_lang; ?>/services" class="hover:text-[#5E9387] transition"><?php echo t('nav.services'); ?></a></li>
            <li><a href="/<?php echo $current_lang; ?>/contact" class="hover:text-[#5E9387] transition"><?php echo t('nav.contact'); ?></a></li>
        </ul>
        <div class="flex items-center space-x-4">
            <div class="relative lang-switcher">
                <button id="langButton" class="flex items-center space-x-2 hover:text-[#5E9387]" aria-label="<?php echo $currentLabel; ?>">
                    <span class="text-xl leading-none"><?php echo $currentFlag; ?></span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div id="langDropdown" class="hidden absolute right-0 mt-2 w-40 bg-white rounded-lg shadow-lg overflow-hidden">
                    <?php foreach (SUPPORTED_LANGS as $lang): ?>
                        <a href="<?php echo getLangUrl($lang); ?>" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100">
                            <span class="text-lg leading-none"><?php echo $langFlags[$lang] ?? '🌐'; ?></span>
                            <span><?php echo $langNames[$lang] ?? strtoupper($lang); ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <button id="mobileMenuBtn" class="md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </nav>
    <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
        <ul class="py-4 px-4 space-y-2">
            <li><a href="/<?php echo $current_lang; ?>" class="block py-2 hover:text-[#5E9387]"><?php echo t('nav.home'); ?></a></li>
            <li><a href="/<?php echo $current_lang; ?>/portfolio" class="block py-2 hover:text-[#5E9387]"><?php echo t('nav.portfolio'); ?></a></li>
            <li><a href="/<?php echo $current_lang; ?>/about" class="block py-2 hover:text-[#5E9387]"><?php echo t('nav.about'); ?></a></li>
            <li><a href="/<?php echo $current_lang; ?>/services" class="block py-2 hover:text-[#5E9387]"><?php echo t('nav.services'); ?></a></li>
            <li><a href="/<?php echo $current_lang; ?>/contact" class="block py-2 hover:text-[#5E9387]"><?php echo t('nav.contact'); ?></a></li>
        </ul>
    </div>
</header>
