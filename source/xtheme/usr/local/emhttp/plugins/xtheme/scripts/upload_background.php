<?php
require_once '/usr/local/emhttp/plugins/xtheme/include/theme_helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('upload_post_required'),
    ]);
}

if (!is_array($_POST) || !isset($_POST['content'])) {
    http_response_code(400);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('upload_invalid'),
    ]);
}

$encodedContent = preg_replace('/\s+/', '', (string)($_POST['content'] ?? ''));
if ($encodedContent === '') {
    http_response_code(400);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('upload_missing_file'),
    ]);
}

$allowed = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/gif' => 'gif',
    'image/webp' => 'webp',
];

$themeId = xtheme_theme_slug((string)($_POST['selected_theme_id'] ?? ($_POST['theme_id'] ?? 'current-theme')), 'current-theme');

$binary = base64_decode($encodedContent, true);
if ($binary === false) {
    http_response_code(400);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('upload_invalid'),
    ]);
}

if (strlen($binary) > 15 * 1024 * 1024) {
    http_response_code(413);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('upload_too_large'),
    ]);
}

$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime = $finfo->buffer($binary);
if (!isset($allowed[$mime])) {
    http_response_code(415);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('upload_only_images'),
    ]);
}

if (!is_dir(xtheme_background_dir())) {
    mkdir(xtheme_background_dir(), 0777, true);
}

if (!is_dir(xtheme_theme_background_dir($themeId))) {
    mkdir(xtheme_theme_background_dir($themeId), 0777, true);
}

foreach (glob(xtheme_theme_background_dir($themeId) . '/background.*') ?: [] as $existingFile) {
    @unlink($existingFile);
}

$extension = $allowed[$mime];
$targetName = 'background.' . $extension;
$targetPath = xtheme_theme_background_dir($themeId) . '/' . $targetName;

if (file_put_contents($targetPath, $binary, LOCK_EX) === false) {
    http_response_code(500);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('upload_store_failed'),
    ]);
}

xtheme_json_response([
    'ok' => true,
    'url' => xtheme_theme_background_web_path($themeId, $targetName),
    'message' => xtheme_text('upload_success'),
]);
