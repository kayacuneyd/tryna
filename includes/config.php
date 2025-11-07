<?php
// Site settings
define('SITE_NAME', 'Enes Turkoglu Photography');
define('SITE_URL', 'https://turkogluenes.com');
define('DEFAULT_LANG', 'en');
define('SUPPORTED_LANGS', ['tr', 'en', 'de']);

// API keys (prefer environment variables in production)
define('PEXELS_API_KEY', getenv('PEXELS_API_KEY') ?: 'Ez30rkty1rEm8VdyTW2mg6rKKqEBFV2uWd27sZ17RNciQuRrYEHJRip6');
define('EMAILJS_SERVICE_ID', getenv('EMAILJS_SERVICE_ID') ?: 'service_yznjbci');
define('EMAILJS_TEMPLATE_ID', getenv('EMAILJS_TEMPLATE_ID') ?: 'template_ong59qd');
define('EMAILJS_PUBLIC_KEY', getenv('EMAILJS_PUBLIC_KEY') ?: 'M5jmEAKff7KbhoEZH');

// Pexels configuration
define('PEXELS_PHOTOGRAPHER', 'Enes Turkoglu');
define('PEXELS_COLLECTION_ID', getenv('PEXELS_COLLECTION_ID') ?: 'xdljarh');

// Timezone & default charset
date_default_timezone_set('Europe/Berlin');
ini_set('default_charset', 'UTF-8');
?>
