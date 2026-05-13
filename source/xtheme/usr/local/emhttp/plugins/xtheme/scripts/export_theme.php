<?php
require_once '/usr/local/emhttp/plugins/xtheme/include/theme_helpers.php';

$themes = xtheme_read_themes();
$currentConfig = xtheme_read_config();
$requestedThemeId = xtheme_theme_slug((string)($_GET['theme_id'] ?? $currentConfig['theme_id']), $currentConfig['theme_id']);
$theme = xtheme_find_theme($themes, $requestedThemeId);

if (!$theme) {
    http_response_code(404);
    exit('Theme not found.');
}

$archiveName = xtheme_theme_slug($theme['name'], 'xtheme-theme') . '.zip';
$tempPath = tempnam(sys_get_temp_dir(), 'xtheme-export-');
if ($tempPath === false) {
    http_response_code(500);
    exit('Unable to create export archive.');
}

$zipPath = $tempPath . '.zip';
@unlink($tempPath);

$zip = new ZipArchive();
if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
    http_response_code(500);
    exit('Unable to create export archive.');
}

$exportTheme = $theme;
$backgroundPath = xtheme_local_background_file((string)$exportTheme['background_image']);
if ($backgroundPath !== '') {
    $backgroundName = basename($backgroundPath);
    $exportTheme['background_image'] = 'backgrounds/' . $backgroundName;
    $zip->addFile($backgroundPath, 'backgrounds/' . $backgroundName);
}

$manifest = [
    'format' => 2,
    'plugin' => 'XTheme',
    'exported_at' => gmdate('c'),
    'theme' => $exportTheme,
    'config' => xtheme_public_config($exportTheme),
];

$zip->addFromString(
    'xtheme.json',
    json_encode($manifest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
);
$zip->close();

header('Content-Type: application/zip');
header('Content-Disposition: attachment; filename="' . $archiveName . '"');
header('Content-Length: ' . filesize($zipPath));
header('Cache-Control: no-store, no-cache, must-revalidate');
readfile($zipPath);
@unlink($zipPath);
exit;
