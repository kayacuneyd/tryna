<footer class="bg-[#1C1E21] text-[#F2F2EF] py-12 mt-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div>
                <h3 class="text-xl font-bold mb-4"><?php echo t('brand.name'); ?></h3>
                <p class="text-gray-400"><?php echo t('hero.subtitle'); ?></p>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4"><?php echo t('nav.home'); ?></h3>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="/<?php echo $current_lang; ?>/portfolio" class="hover:text-[#5E9387]"><?php echo t('nav.portfolio'); ?></a></li>
                    <li><a href="/<?php echo $current_lang; ?>/about" class="hover:text-[#5E9387]"><?php echo t('nav.about'); ?></a></li>
                    <li><a href="/<?php echo $current_lang; ?>/services" class="hover:text-[#5E9387]"><?php echo t('nav.services'); ?></a></li>
                    <li><a href="/<?php echo $current_lang; ?>/contact" class="hover:text-[#5E9387]"><?php echo t('nav.contact'); ?></a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xl font-bold mb-4"><?php echo t('footer.follow'); ?></h3>
                <div class="flex space-x-4">
                    <a href="https://www.instagram.com/turkogluenes" target="_blank" class="hover:text-[#5E9387]">
                        <span class="text-sm"><?php echo t('common.instagram'); ?></span>
                    </a>
                    <a href="https://www.pexels.com/@turkogluenes" target="_blank" class="hover:text-[#5E9387]">
                        <span class="text-sm"><?php echo t('common.pexels'); ?></span>
                    </a>
                </div>
                <a href="https://wa.me/49XXXXXXXXX?text=Hello%20Enes" target="_blank" class="inline-flex items-center gap-2 mt-4 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                    <?php echo t('contact.whatsapp'); ?>
                </a>
            </div>
        </div>
        <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400 text-sm tracking-wide">
            <p>
                <?php printf(t('footer.rights'), date('Y'), t('brand.name')); ?>
            </p>
        </div>
    </div>
</footer>
<script src="/assets/js/main.js"></script>
<?php if (!empty($page_scripts)): ?>
    <?php foreach ($page_scripts as $script): ?>
        <script src="<?php echo $script; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>
</html>
