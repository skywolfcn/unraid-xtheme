<?php
require_once '/usr/local/emhttp/plugins/xtheme/include/theme_helpers.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('upload_post_required'),
    ]);
}

$mode = strtolower(trim((string)($_POST['mode'] ?? 'save')));
if (!in_array($mode, ['save', 'create', 'delete'], true)) {
    $mode = 'save';
}

$currentConfig = xtheme_read_config();
$themes = xtheme_read_themes();
$selectedThemeId = xtheme_theme_slug((string)($_POST['selected_theme_id'] ?? $currentConfig['theme_id']), $currentConfig['theme_id']);
$themeName = xtheme_sanitize_theme_title($_POST['theme_name'] ?? ($currentConfig['theme_name'] ?? 'Theme'), $currentConfig['theme_name'] ?? 'Theme');

if ($mode === 'delete') {
    $existingTheme = xtheme_find_theme($themes, $selectedThemeId);
    if (!$existingTheme) {
        http_response_code(404);
        xtheme_json_response([
            'ok' => false,
            'message' => xtheme_text('status_delete_failed'),
        ]);
    }

    if (!xtheme_can_delete_theme((string)$existingTheme['id'])) {
        http_response_code(400);
        xtheme_json_response([
            'ok' => false,
            'message' => xtheme_text('delete_blocked'),
        ]);
    }

    $remainingThemes = array_values(array_filter($themes, static function (array $theme) use ($existingTheme): bool {
        return ($theme['id'] ?? '') !== ($existingTheme['id'] ?? '');
    }));

    if (!$remainingThemes) {
        http_response_code(500);
        xtheme_json_response([
            'ok' => false,
            'message' => xtheme_text('status_delete_failed'),
        ]);
    }

    $fallbackTheme = xtheme_find_theme($remainingThemes, 'current-theme') ?: $remainingThemes[0];

    if (!xtheme_delete_theme_record((string)$existingTheme['id'])) {
        http_response_code(500);
        xtheme_json_response([
            'ok' => false,
            'message' => xtheme_text('status_delete_failed'),
        ]);
    }

    $activeConfig = $currentConfig;
    $activeConfig['theme_id'] = $fallbackTheme['id'];
    $activeConfig['theme_name'] = $fallbackTheme['name'];
    foreach (xtheme_shareable_keys() as $key) {
        $activeConfig[$key] = $fallbackTheme[$key];
    }

    if (!xtheme_write_config($activeConfig)) {
        http_response_code(500);
        xtheme_json_response([
            'ok' => false,
            'message' => xtheme_text('status_delete_failed'),
        ]);
    }

    xtheme_sync_dynamix_display($activeConfig);

    xtheme_json_response([
        'ok' => true,
        'theme_id' => $fallbackTheme['id'],
        'theme_name' => $fallbackTheme['name'],
        'message' => xtheme_text('status_deleted'),
    ]);
}

$postedTheme = [
    'name' => $themeName,
];

foreach (xtheme_shareable_keys() as $key) {
    if (array_key_exists($key, $_POST)) {
        $postedTheme[$key] = $_POST[$key];
    }
}

if ($mode === 'create') {
    $themeId = xtheme_generate_theme_id($themes);
} else {
    $existingTheme = xtheme_find_theme($themes, $selectedThemeId);
    if ($existingTheme) {
        $themeId = $existingTheme['id'];
        $postedTheme = array_merge($existingTheme, $postedTheme);
    } else {
        $themeId = xtheme_generate_theme_id($themes);
    }
}

$themeRecord = xtheme_sanitize_theme_record(array_merge($postedTheme, [
    'id' => $themeId,
    'name' => $themeName,
]));

if (!xtheme_write_theme_record($themeRecord)) {
    http_response_code(500);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('status_upload_failed'),
    ]);
}

$activeConfig = $currentConfig;
$activeConfig['theme_id'] = $themeRecord['id'];
$activeConfig['theme_name'] = $themeRecord['name'];
foreach (xtheme_shareable_keys() as $key) {
    $activeConfig[$key] = $themeRecord[$key];
}

if (!xtheme_write_config($activeConfig)) {
    http_response_code(500);
    xtheme_json_response([
        'ok' => false,
        'message' => xtheme_text('status_upload_failed'),
    ]);
}

xtheme_sync_dynamix_display($activeConfig);

xtheme_json_response([
    'ok' => true,
    'theme_id' => $themeRecord['id'],
    'theme_name' => $themeRecord['name'],
]);
