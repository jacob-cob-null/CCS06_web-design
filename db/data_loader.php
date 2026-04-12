<?php
/**
 * Loads the personal information block from content.json
 * @return array The personal information associative array
 */
function loadPersonalData() {
    $jsonPath = __DIR__ . '/../data/content.json';
    if (!file_exists($jsonPath)) {
        die("Error: content.json not found at " . $jsonPath);
    }

    $jsonData = file_get_contents($jsonPath);
    $data = json_decode($jsonData, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        die("Error: Failed to parse content.json - " . json_last_error_msg());
    }

    return isset($data['personalInfo']) ? $data['personalInfo'] : [];
}
?>
