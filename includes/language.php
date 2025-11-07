<?php
session_start();

require_once __DIR__ . '/config.php';

function getCurrentLang() {
    if (isset($_GET['lang']) && in_array($_GET['lang'], SUPPORTED_LANGS, true)) {
        $_SESSION['lang'] = $_GET['lang'];
    } elseif (!isset($_SESSION['lang'])) {
        $_SESSION['lang'] = DEFAULT_LANG;
    }

    return $_SESSION['lang'];
}

$current_lang = getCurrentLang();

$translations = [];
$lang_file = __DIR__ . "/../languages/{$current_lang}.php";
if (file_exists($lang_file)) {
    require $lang_file;
}

function t($key) {
    global $translations;
    $keys = explode('.', $key);
    $value = $translations;

    foreach ($keys as $k) {
        if (isset($value[$k])) {
            $value = $value[$k];
        } else {
            return $key;
        }
    }

    return $value;
}

function getLangUrl($lang) {
    $current_path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $current_path = preg_replace('/^\/(tr|en|de)/', '', $current_path);
    return "/{$lang}{$current_path}";
}
?>