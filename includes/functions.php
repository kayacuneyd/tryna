<?php
require_once __DIR__ . '/config.php';

function get_case_studies() {
    static $case_studies = null;
    if ($case_studies === null) {
        $data_file = __DIR__ . '/../data/case-studies.php';
        if (file_exists($data_file)) {
            $case_studies = require $data_file;
        } else {
            $case_studies = [];
        }
    }

    return $case_studies;
}

function get_case_study_by_slug($slug) {
    foreach (get_case_studies() as $study) {
        if ($study['slug'] === $slug) {
            return $study;
        }
    }

    return null;
}
?>