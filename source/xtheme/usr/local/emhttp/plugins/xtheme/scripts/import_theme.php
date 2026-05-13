<?php
require_once '/usr/local/emhttp/plugins/xtheme/include/theme_helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('import_post_required'),
    ]);
}

if (!is_array($_POST) || !isset($_POST['content'])) {
    http_response_code(400);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('import_invalid'),
    ]);
}

$encodedContent = preg_replace('/\s+/', '', (string)($_POST['content'] ?? ''));
if ($encodedContent === '') {
    http_response_code(400);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('import_missing_file'),
    ]);
}

$binary = base64_decode($encodedContent, true);
if ($binary === false) {
    http_response_code(400);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('import_invalid'),
    ]);
}

if (strlen($binary) > 30 * 1024 * 1024) {
    http_response_code(413);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('import_too_large'),
    ]);
}

$tempPath = tempnam(sys_get_temp_dir(), 'xtheme-import-');
if ($tempPath === false) {
    http_response_code(500);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('import_invalid'),
    ]);
}

$zipPath = $tempPath . '.zip';
@unlink($tempPath);
if (file_put_contents($zipPath, $binary, LOCK_EX) === false) {
    http_response_code(500);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('import_invalid'),
    ]);
}

$zip = new ZipArchive();
if ($zip->open($zipPath) !== true) {
    @unlink($zipPath);
    http_response_code(415);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('import_invalid_archive'),
    ]);
}

$manifestRaw = $zip->getFromName('xtheme.json');
if ($manifestRaw === false) {
    $zip->close();
    @unlink($zipPath);
    http_response_code(422);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('import_invalid_manifest'),
    ]);
}

$manifest = json_decode($manifestRaw, true);
if (!is_array($manifest)) {
    $zip->close();
    @unlink($zipPath);
    http_response_code(422);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('import_invalid_manifest'),
    ]);
}

$themePayload = [];
if (isset($manifest['theme']) && is_array($manifest['theme'])) {
    $themePayload = $manifest['theme'];
} elseif (isset($manifest['config']) && is_array($manifest['config'])) {
    $themePayload = $manifest['config'];
}

if (!$themePayload) {
    $zip->close();
    @unlink($zipPath);
    http_response_code(422);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('import_invalid_manifest'),
    ]);
}

$themes = xtheme_read_themes();
$importName = xtheme_sanitize_theme_title($themePayload['name'] ?? basename((string)($_POST['filename'] ?? 'Imported Theme'), '.zip'), 'Imported Theme');
$importId = xtheme_generate_theme_id($themes);
$rawBackgroundValue = (string)($themePayload['background_image'] ?? '');

if (preg_match('#^backgrounds/(?:[A-Za-z0-9._-]+/)?([A-Za-z0-9._-]+\.(jpe?g|png|gif|webp))$#i', $rawBackgroundValue, $matches)) {
    $backgroundEntry = preg_match('#^backgrounds/#', $rawBackgroundValue) ? $rawBackgroundValue : ('backgrounds/' . $matches[1]);
    $backgroundBinary = $zip->getFromName($backgroundEntry);
    if ($backgroundBinary === false && $backgroundEntry !== ('backgrounds/' . $matches[1])) {
        $backgroundEntry = 'backgrounds/' . $matches[1];
        $backgroundBinary = $zip->getFromName($backgroundEntry);
    }
    if ($backgroundBinary === false) {
        $zip->close();
        @unlink($zipPath);
        http_response_code(422);
        xtheme_json_response([
            'ok' => false,
            'message' => xtheme_text('import_invalid_manifest'),
        ]);
    }

    if (!is_dir(xtheme_background_dir())) {
        @mkdir(xtheme_background_dir(), 0777, true);
    }

    if (!is_dir(xtheme_theme_background_dir($importId))) {
        @mkdir(xtheme_theme_background_dir($importId), 0777, true);
    }

    $safeName = preg_replace('/[^A-Za-z0-9._-]/', '-', basename($matches[1]));
    if ($safeName === '' || $safeName === '.' || $safeName === '..') {
        $zip->close();
        @unlink($zipPath);
        http_response_code(422);
        xtheme_json_response([
            'ok' => false,
            'message' => xtheme_text('import_invalid_manifest'),
        ]);
    }

    foreach (glob(xtheme_theme_background_dir($importId) . '/background.*') ?: [] as $existingFile) {
        @unlink($existingFile);
    }

    $backgroundPath = xtheme_theme_background_dir($importId) . '/' . $safeName;
    if (file_put_contents($backgroundPath, $backgroundBinary, LOCK_EX) === false) {
        $zip->close();
        @unlink($zipPath);
        http_response_code(500);
        xtheme_json_response([
            'ok' => false,
            'message' => xtheme_text('import_store_failed'),
        ]);
    }

    $themePayload['background_image'] = xtheme_theme_background_web_path($importId, $safeName);
}

$zip->close();
@unlink($zipPath);

$themeRecord = xtheme_sanitize_theme_record(array_merge($themePayload, [
    'id' => $importId,
    'name' => $importName,
]));

if (!xtheme_write_theme_record($themeRecord)) {
    http_response_code(500);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('import_invalid'),
    ]);
}

$activeConfig = xtheme_read_config();
$activeConfig['theme_id'] = $themeRecord['id'];
$activeConfig['theme_name'] = $themeRecord['name'];
foreach (xtheme_shareable_keys() as $key) {
    $activeConfig[$key] = $themeRecord[$key];
}

xtheme_write_config($activeConfig);
xtheme_sync_dynamix_display($activeConfig);

xtheme_json_response([
    'ok' => true,
    'message' => xtheme_text('import_success'),
    'theme_id' => $themeRecord['id'],
    'theme_name' => $themeRecord['name'],
]);
