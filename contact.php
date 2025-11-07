<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/language.php';

$page_title = t('nav.contact') . ' - ' . t('brand.name');
$page_description = t('contact_page.description');
$page_scripts = [
    'https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js',
    '/assets/js/contact-form.js'
];
include __DIR__ . '/includes/header.php';
?>
<main class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-center mb-12"><?php echo t('nav.contact'); ?></h1>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <div>
            <form id="contactForm" class="space-y-6">
                <div>
                    <label for="name" class="block mb-2 font-semibold"><?php echo t('contact.form_name'); ?></label>
                    <input type="text" id="name" name="name" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-[#5E9387] focus:ring-2 focus:ring-[#5E9387] outline-none transition">
                </div>
                <div>
                    <label for="email" class="block mb-2 font-semibold"><?php echo t('contact.form_email'); ?></label>
                    <input type="email" id="email" name="email" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-[#5E9387] focus:ring-2 focus:ring-[#5E9387] outline-none transition">
                </div>
                <div>
                    <label for="subject" class="block mb-2 font-semibold"><?php echo t('contact.form_subject'); ?></label>
                    <input type="text" id="subject" name="subject" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-[#5E9387] focus:ring-2 focus:ring-[#5E9387] outline-none transition">
                </div>
                <div>
                    <label for="message" class="block mb-2 font-semibold"><?php echo t('contact.form_message'); ?></label>
                    <textarea id="message" name="message" rows="6" required class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-[#5E9387] focus:ring-2 focus:ring-[#5E9387] outline-none transition resize-none"></textarea>
                </div>
                <button type="submit" class="w-full bg-[#5E9387] text-white py-3 rounded-lg hover:bg-[#4a7769] transition font-semibold">
                    <?php echo t('contact.form_submit'); ?>
                </button>
            </form>
        </div>
        <div class="space-y-8">
            <div>
                <h2 class="text-2xl font-bold mb-4"><?php echo t('contact_page.heading'); ?></h2>
                <p class="text-gray-600 mb-6"><?php echo t('contact_page.description'); ?></p>
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-[#5E9387]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <a href="mailto:info@turkogluenes.com" class="hover:text-[#5E9387]">info@turkogluenes.com</a>
                    </div>
                    <div class="flex items-center space-x-3">
                        <svg class="w-6 h-6 text-[#5E9387]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <span><?php echo t('contact_page.location'); ?></span>
                    </div>
                </div>
            </div>
            <a href="https://wa.me/49XXXXXXXXX?text=Hello%20Enes,%20I%20found%20your%20website" target="_blank" class="inline-flex items-center gap-3 bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition">
                <?php echo t('contact.whatsapp'); ?>
            </a>
            <div>
                <h3 class="text-xl font-bold mb-4"><?php echo t('contact_page.follow'); ?></h3>
                <div class="flex space-x-4">
                    <a href="https://www.instagram.com/enesturkoglu" target="_blank" class="text-[#5E9387] hover:text-[#4a7769]"><?php echo t('common.instagram'); ?></a>
                    <a href="https://www.pexels.com/@enesturkoglu" target="_blank" class="text-[#5E9387] hover:text-[#4a7769]"><?php echo t('common.pexels'); ?></a>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
