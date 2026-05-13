<?php

function xtheme_storage_dir(): string
{
    return '/boot/config/plugins/xtheme';
}

function xtheme_background_dir(): string
{
    return xtheme_storage_dir() . '/backgrounds';
}

function xtheme_theme_background_dir(string $themeId): string
{
    return xtheme_background_dir() . '/' . xtheme_theme_slug($themeId, 'theme');
}

function xtheme_theme_background_web_prefix(string $themeId): string
{
    return '/plugins/xtheme/backgrounds/' . rawurlencode(xtheme_theme_slug($themeId, 'theme'));
}

function xtheme_theme_background_web_path(string $themeId, string $fileName): string
{
    return xtheme_theme_background_web_prefix($themeId) . '/' . rawurlencode($fileName);
}

function xtheme_config_path(): string
{
    return xtheme_storage_dir() . '/xtheme.cfg';
}

function xtheme_dynamix_config_path(): string
{
    return '/boot/config/plugins/dynamix/dynamix.cfg';
}

function xtheme_dynamix_backup_path(): string
{
    return xtheme_storage_dir() . '/dynamix-display-backup.json';
}

function xtheme_dynamix_backup_keys(): array
{
    return [
        'theme',
        'background',
        'header',
        'headermetacolor',
    ];
}

function xtheme_dynamix_theme_dir(): string
{
    return '/usr/local/emhttp/plugins/dynamix/styles/themes';
}

function xtheme_themes_dir(): string
{
    return xtheme_storage_dir() . '/themes';
}

function xtheme_defaults(): array
{
    return [
        'theme_id' => 'current-theme',
        'theme_name' => 'Current Theme',
        'enabled' => '1',
        'dynamix_theme' => 'black',
        'background_image' => '',
        'text_color' => '#e8edf5ff',
        'accent_color' => '#72e0ffff',
        'link_color' => '#72e0ffff',
        'highlight_value_color' => '#86efacff',
        'header_color' => '#101827d6',
        'menu_color' => '#0f1724cc',
        'title_color' => '#1320338c',
        'title_text_color' => '#f8fafcff',
        'secondary_text_color' => '#dbe4f0ff',
        'panel_color' => '#1320337a',
        'progress_fill_color' => '#38bdf8e0',
        'progress_track_color' => '#2b3440eb',
        'panel_border_color' => '#ffffff2e',
        'background_blur' => '20',
        'glass_blur' => '12',
        'overlay_opacity' => '0.42',
        'dynamix_state_active' => '0',
        'dynamix_backup_theme' => '',
        'dynamix_backup_header' => '',
        'dynamix_backup_headermetacolor' => '',
    ];
}

function xtheme_shareable_keys(): array
{
    return [
        'enabled',
        'dynamix_theme',
        'background_image',
        'text_color',
        'accent_color',
        'link_color',
        'highlight_value_color',
        'header_color',
        'menu_color',
        'title_color',
        'title_text_color',
        'secondary_text_color',
        'panel_color',
        'progress_fill_color',
        'progress_track_color',
        'panel_border_color',
        'background_blur',
        'glass_blur',
        'overlay_opacity',
    ];
}

function xtheme_local_state_keys(): array
{
    return [
        'dynamix_state_active',
        'dynamix_backup_theme',
        'dynamix_backup_header',
        'dynamix_backup_headermetacolor',
    ];
}

function xtheme_builtin_themes(): array
{
    return [
        [
            'id' => 'ocean-glass',
            'name' => 'Ocean Glass',
            'enabled' => '1',
            'dynamix_theme' => 'black',
            'background_image' => '',
            'text_color' => '#e8edf5ff',
            'accent_color' => '#72e0ffff',
            'link_color' => '#72e0ffff',
            'highlight_value_color' => '#86efacff',
            'header_color' => '#101827d6',
            'menu_color' => '#0f1724cc',
            'title_color' => '#1320338c',
            'title_text_color' => '#f8fafcff',
            'secondary_text_color' => '#dbe4f0ff',
            'panel_color' => '#1320337a',
            'progress_fill_color' => '#38bdf8e0',
            'progress_track_color' => '#2b3440eb',
            'panel_border_color' => '#ffffff2e',
            'background_blur' => '20',
            'glass_blur' => '12',
            'overlay_opacity' => '0.42',
        ],
        [
            'id' => 'midnight-ember',
            'name' => 'Midnight Ember',
            'enabled' => '1',
            'dynamix_theme' => 'black',
            'background_image' => '',
            'text_color' => '#fff4ebff',
            'accent_color' => '#ff8a3dff',
            'link_color' => '#ffb26bff',
            'highlight_value_color' => '#ffd166ff',
            'header_color' => '#1b1212e0',
            'menu_color' => '#221615cc',
            'title_color' => '#3a24128f',
            'title_text_color' => '#fff4ebff',
            'secondary_text_color' => '#f7cfb2ff',
            'panel_color' => '#2617107d',
            'progress_fill_color' => '#ff8a3de6',
            'progress_track_color' => '#3a2a20eb',
            'panel_border_color' => '#ffb37a33',
            'background_blur' => '18',
            'glass_blur' => '10',
            'overlay_opacity' => '0.48',
        ],
        [
            'id' => 'aurora-frost',
            'name' => 'Aurora Frost',
            'enabled' => '1',
            'dynamix_theme' => 'azure',
            'background_image' => '',
            'text_color' => '#eefafcff',
            'accent_color' => '#68f0d8ff',
            'link_color' => '#7ee7ffff',
            'highlight_value_color' => '#b6ffb0ff',
            'header_color' => '#0d2432d4',
            'menu_color' => '#113244bf',
            'title_color' => '#14384d73',
            'title_text_color' => '#f3fdffff',
            'secondary_text_color' => '#d4f0f8ff',
            'panel_color' => '#15354f61',
            'progress_fill_color' => '#5eead4e8',
            'progress_track_color' => '#2a4254d9',
            'panel_border_color' => '#bdf7ff36',
            'background_blur' => '16',
            'glass_blur' => '14',
            'overlay_opacity' => '0.28',
        ],
        [
            'id' => 'mono-slate',
            'name' => 'Mono Slate',
            'enabled' => '1',
            'dynamix_theme' => 'gray',
            'background_image' => '',
            'text_color' => '#f5f7faff',
            'accent_color' => '#cbd5e1ff',
            'link_color' => '#e2e8f0ff',
            'highlight_value_color' => '#f8fafcff',
            'header_color' => '#0f172ad9',
            'menu_color' => '#1e293bcc',
            'title_color' => '#33415585',
            'title_text_color' => '#f8fafcff',
            'secondary_text_color' => '#cbd5e1ff',
            'panel_color' => '#1e293b73',
            'progress_fill_color' => '#94a3b8e6',
            'progress_track_color' => '#334155e6',
            'panel_border_color' => '#e2e8f026',
            'background_blur' => '22',
            'glass_blur' => '12',
            'overlay_opacity' => '0.50',
        ],
        [
            'id' => 'sunrise-silk',
            'name' => 'Sunrise Silk',
            'enabled' => '1',
            'dynamix_theme' => 'white',
            'background_image' => '',
            'text_color' => '#142033ff',
            'accent_color' => '#ff8a3dff',
            'link_color' => '#ef6c00ff',
            'highlight_value_color' => '#22c55eff',
            'header_color' => '#fff7edee',
            'menu_color' => '#fff1d6db',
            'title_color' => '#ffe2b280',
            'title_text_color' => '#1f2937ff',
            'secondary_text_color' => '#5b6472ff',
            'panel_color' => '#fff9f0c2',
            'progress_fill_color' => '#fb923ce6',
            'progress_track_color' => '#e5d5c3ee',
            'panel_border_color' => '#f59e0b33',
            'background_blur' => '10',
            'glass_blur' => '8',
            'overlay_opacity' => '0.12',
        ],
        [
            'id' => 'graphite-lime',
            'name' => 'Graphite Lime',
            'enabled' => '1',
            'dynamix_theme' => 'gray',
            'background_image' => '',
            'text_color' => '#eef6e9ff',
            'accent_color' => '#84cc16ff',
            'link_color' => '#bef264ff',
            'highlight_value_color' => '#d9f99dff',
            'header_color' => '#121711e8',
            'menu_color' => '#171f15d6',
            'title_color' => '#24311f8f',
            'title_text_color' => '#f7fee7ff',
            'secondary_text_color' => '#d9f99dff',
            'panel_color' => '#1c27186e',
            'progress_fill_color' => '#84cc16e6',
            'progress_track_color' => '#2f3d2ae8',
            'panel_border_color' => '#d9f99d2b',
            'background_blur' => '20',
            'glass_blur' => '11',
            'overlay_opacity' => '0.40',
        ],
    ];
}

function xtheme_builtin_theme_ids(): array
{
    $themeIds = [];
    foreach (xtheme_builtin_themes() as $theme) {
        $themeIds[] = xtheme_theme_slug((string)($theme['id'] ?? ''), xtheme_theme_slug((string)($theme['name'] ?? 'theme'), 'theme'));
    }

    return array_values(array_unique(array_filter($themeIds)));
}

function xtheme_protected_theme_ids(): array
{
    return array_values(array_unique(array_merge(
        ['current-theme'],
        xtheme_builtin_theme_ids()
    )));
}

function xtheme_can_delete_theme(string $themeId): bool
{
    $themeId = xtheme_theme_slug($themeId);
    if ($themeId === '') {
        return false;
    }

    return !in_array($themeId, xtheme_protected_theme_ids(), true);
}

function xtheme_locale(): string
{
    if (session_status() === PHP_SESSION_NONE) {
        @session_start();
    }

    $locale = $_SESSION['locale'] ?? ($_COOKIE['locale'] ?? 'en_US');
    return strtolower((string)$locale);
}

function xtheme_is_chinese(): bool
{
    return strpos(xtheme_locale(), 'zh') === 0;
}

function xtheme_text(string $key): string
{
    static $messages = [
        'en' => [
            'x_theme' => 'XTheme',
            'theme_toggle_title' => 'Theme Settings',
            'theme_toggle_text' => 'Keep it simple: background, Dynamix theme, key colors, and a few glass controls.',
            'theme_list' => 'Theme scheme',
            'theme_name' => 'Theme name',
            'create_theme' => 'Create Theme',
            'delete_theme' => 'Delete Theme',
            'enable_theme' => 'Enable theme',
            'dynamix_theme' => 'Unraid Dynamix color theme',
            'background_image_url' => 'Background image URL',
            'text_color' => 'Text color',
            'accent_color' => 'Accent color',
            'link_color' => 'Link text color',
            'highlight_value_color' => 'Highlight value color',
            'header_color' => 'Header color',
            'menu_color' => 'Menu color',
            'title_bar_color' => 'Title bar color',
            'title_text_color' => 'Title text color',
            'secondary_text_color' => 'Secondary text color',
            'panel_color' => 'Panel color',
            'progress_fill_color' => 'Progress fill color',
            'progress_track_color' => 'Progress track color',
            'save_theme' => 'Save Theme',
            'background_title' => 'Background Image',
            'background_text' => 'Upload a local image or paste a remote image URL. Uploading fills the URL field for you.',
            'upload_image' => 'Upload image',
            'upload_background' => 'Upload Background',
            'clear_background' => 'Clear Background',
            'share_title' => 'Theme Sharing',
            'share_text' => 'Export the current theme as a ZIP package or import a shared package. Local wallpapers are bundled automatically.',
            'export_theme' => 'Export Theme',
            'import_theme' => 'Import Theme',
            'import_archive' => 'Theme ZIP file',
            'glass_title' => 'Glass Tuning',
            'glass_text' => 'Tune blur and transparency for the backdrop and glass panels.',
            'background_blur' => 'Background blur',
            'glass_blur' => 'Glass blur',
            'overlay_strength' => 'Overlay strength',
            'color_title' => 'Color Palette',
            'panel_border_color' => 'Panel border color',
            'color_alpha' => 'Opacity',
            'picker_close' => 'Close',
            'picker_open' => 'Open color picker',
            'picker_input' => 'Color value field',
            'picker_hue' => 'Hue slider',
            'picker_alpha' => 'Opacity slider',
            'theme_azure' => 'Azure',
            'theme_black' => 'Black',
            'theme_gray' => 'Gray',
            'theme_white' => 'White',
            'status_saving' => 'Saving XTheme settings...',
            'status_deleting' => 'Deleting theme...',
            'status_choose_image' => 'Choose an image first.',
            'status_choose_theme_archive' => 'Choose a theme ZIP file first.',
            'status_uploading' => 'Uploading background...',
            'status_importing' => 'Importing theme package...',
            'status_upload_unreadable' => 'Upload returned an unreadable response.',
            'status_upload_failed' => 'Upload failed.',
            'status_import_failed' => 'Theme import failed.',
            'status_delete_failed' => 'Theme delete failed.',
            'status_upload_refresh' => 'Security token expired. Refresh the page and try again.',
            'status_uploaded' => 'Background uploaded. Click Save Theme to apply it.',
            'status_imported' => 'Theme imported. The page will refresh to apply it.',
            'status_cleared' => 'Background path cleared. Click Save Theme to apply it.',
            'status_deleted' => 'Theme deleted. The page will refresh to switch to another theme.',
            'delete_confirm' => 'Delete theme "{name}"? This cannot be undone.',
            'delete_blocked' => 'The current theme or a built-in theme cannot be deleted.',
            'upload_post_required' => 'POST required.',
            'upload_missing_file' => 'No image uploaded.',
            'upload_invalid' => 'Invalid upload.',
            'upload_only_images' => 'Only JPG, PNG, GIF, and WEBP are supported.',
            'upload_too_large' => 'Image is too large. Use 15 MB or less.',
            'upload_store_failed' => 'Unable to store the uploaded image.',
            'upload_success' => 'Background uploaded. Click Save Theme to apply it.',
            'import_post_required' => 'POST required.',
            'import_missing_file' => 'No theme package uploaded.',
            'import_invalid' => 'Invalid theme package upload.',
            'import_too_large' => 'Theme package is too large. Use 30 MB or less.',
            'import_invalid_archive' => 'Theme package must be a ZIP file.',
            'import_invalid_manifest' => 'Theme package is missing a valid manifest.',
            'import_store_failed' => 'Unable to store the imported wallpaper.',
            'import_success' => 'Theme imported successfully.',
        ],
        'zh' => [
            'x_theme' => 'XTheme',
            'theme_toggle_title' => '主题设置',
            'theme_toggle_text' => '保持简单：只调整背景、Dynamix 主题、关键颜色和少量毛玻璃参数。',
            'theme_list' => '主题方案',
            'theme_name' => '主题名称',
            'create_theme' => '新建主题',
            'delete_theme' => '删除主题',
            'enable_theme' => '启用主题',
            'dynamix_theme' => 'Unraid Dynamix 颜色主题',
            'background_image_url' => '背景图片地址',
            'text_color' => '文字颜色',
            'accent_color' => '强调色',
            'link_color' => '超链接文字颜色',
            'highlight_value_color' => '高亮数值颜色',
            'header_color' => '顶栏颜色',
            'menu_color' => '菜单颜色',
            'title_bar_color' => '标题栏颜色',
            'title_text_color' => '标题文字颜色',
            'secondary_text_color' => '次要文本颜色',
            'panel_color' => '面板颜色',
            'progress_fill_color' => '进度条填充颜色',
            'progress_track_color' => '进度条底色',
            'save_theme' => '保存主题',
            'background_title' => '背景图片',
            'background_text' => '可以上传本地图片，也可以直接粘贴远程图片地址。上传成功后会自动填入背景地址。',
            'upload_image' => '上传图片',
            'upload_background' => '上传背景图',
            'clear_background' => '清空背景图',
            'share_title' => '主题分享',
            'share_text' => '可以把当前主题导出成 ZIP 分享给别人，也可以导入别人分享的 ZIP。上传的本地壁纸会自动一起打包。',
            'export_theme' => '导出主题',
            'import_theme' => '导入主题',
            'import_archive' => '主题 ZIP 文件',
            'glass_title' => '毛玻璃调节',
            'glass_text' => '用这几项来调整背景模糊、面板毛玻璃和整体遮罩强度。',
            'background_blur' => '背景模糊',
            'glass_blur' => '毛玻璃模糊',
            'overlay_strength' => '遮罩强度',
            'color_title' => '颜色设置',
            'panel_border_color' => '面板边框颜色',
            'color_alpha' => '透明度',
            'picker_close' => '关闭',
            'picker_open' => '打开取色器',
            'picker_input' => '颜色输入框',
            'picker_hue' => '色相滑杆',
            'picker_alpha' => '透明度滑杆',
            'theme_azure' => '蓝色',
            'theme_black' => '黑色',
            'theme_gray' => '灰色',
            'theme_white' => '白色',
            'status_saving' => '正在保存 XTheme 设置...',
            'status_deleting' => '正在删除主题...',
            'status_choose_image' => '请先选择一张图片。',
            'status_choose_theme_archive' => '请先选择一个主题 ZIP 文件。',
            'status_uploading' => '正在上传背景图...',
            'status_importing' => '正在导入主题包...',
            'status_upload_unreadable' => '上传返回内容无法识别。',
            'status_upload_failed' => '上传失败。',
            'status_import_failed' => '主题导入失败。',
            'status_delete_failed' => '主题删除失败。',
            'status_upload_refresh' => '页面安全校验已失效，请刷新页面后重试。',
            'status_uploaded' => '背景图上传成功，点击保存主题即可应用。',
            'status_imported' => '主题已导入，页面即将刷新并应用。',
            'status_cleared' => '背景图地址已清空，点击保存主题即可应用。',
            'status_deleted' => '主题已删除，页面即将刷新并切换到其他主题。',
            'delete_confirm' => '确定删除主题“{name}”吗？此操作无法撤销。',
            'delete_blocked' => '当前主题或内置主题不允许删除。',
            'upload_post_required' => '需要使用 POST 请求。',
            'upload_missing_file' => '没有收到上传图片。',
            'upload_invalid' => '上传文件无效。',
            'upload_only_images' => '仅支持 JPG、PNG、GIF 和 WEBP 图片。',
            'upload_too_large' => '图片太大了，请控制在 15 MB 以内。',
            'upload_store_failed' => '无法保存上传图片。',
            'upload_success' => '背景图上传成功，点击保存主题即可应用。',
            'import_post_required' => '需要使用 POST 请求。',
            'import_missing_file' => '没有收到主题包。',
            'import_invalid' => '主题包上传无效。',
            'import_too_large' => '主题包太大了，请控制在 30 MB 以内。',
            'import_invalid_archive' => '主题包必须是 ZIP 文件。',
            'import_invalid_manifest' => '主题包缺少有效配置清单。',
            'import_store_failed' => '无法保存导入的壁纸文件。',
            'import_success' => '主题导入成功。',
        ],
    ];

    $language = xtheme_is_chinese() ? 'zh' : 'en';
    return $messages[$language][$key] ?? $messages['en'][$key] ?? $key;
}

function xtheme_theme_label(string $theme): string
{
    $map = [
        'azure' => xtheme_text('theme_azure'),
        'black' => xtheme_text('theme_black'),
        'gray' => xtheme_text('theme_gray'),
        'white' => xtheme_text('theme_white'),
    ];

    return $map[$theme] ?? ucfirst($theme);
}

function xtheme_theme_slug(string $value, string $default = 'theme'): string
{
    $value = strtolower(trim($value));
    $value = preg_replace('/[^a-z0-9]+/', '-', $value);
    $value = trim((string)$value, '-');
    return $value !== '' ? $value : $default;
}

function xtheme_sanitize_theme_title($value, string $default = 'Theme'): string
{
    $value = trim((string)$value);
    if ($value === '') {
        return $default;
    }

    $value = preg_replace('/[\x00-\x1F\x7F]/u', '', $value);
    return mb_substr(trim((string)$value), 0, 60);
}

function xtheme_theme_file_path(string $themeId): string
{
    return xtheme_themes_dir() . '/' . xtheme_theme_slug($themeId) . '.json';
}

function xtheme_sanitize_theme_record(array $input, array $fallback = []): array
{
    $themeDefaults = xtheme_public_config(xtheme_defaults());
    $merged = array_merge($themeDefaults, $fallback, $input);

    $name = xtheme_sanitize_theme_title($merged['name'] ?? ($fallback['name'] ?? 'Theme'), $fallback['name'] ?? 'Theme');
    $id = xtheme_theme_slug((string)($merged['id'] ?? ''), xtheme_theme_slug($name, 'theme'));

    $theme = [
        'id' => $id,
        'name' => $name,
    ];

    foreach (xtheme_shareable_keys() as $key) {
        $theme[$key] = $merged[$key] ?? $themeDefaults[$key];
    }

    return xtheme_public_config(xtheme_sanitize_config(array_merge(xtheme_defaults(), $theme))) + [
        'id' => $id,
        'name' => $name,
    ];
}

function xtheme_unique_theme_id(array $themes, string $baseName, string $preferredId = ''): string
{
    $existing = [];
    foreach ($themes as $theme) {
        if (is_array($theme) && isset($theme['id'])) {
            $existing[] = xtheme_theme_slug((string)$theme['id']);
        }
    }

    $base = xtheme_theme_slug($preferredId !== '' ? $preferredId : $baseName, 'theme');
    $candidate = $base;
    $suffix = 2;
    while (in_array($candidate, $existing, true)) {
        $candidate = $base . '-' . $suffix;
        $suffix++;
    }

    return $candidate;
}

function xtheme_generate_theme_id(array $themes, string $prefix = 'theme'): string
{
    $prefix = xtheme_theme_slug($prefix, 'theme');

    for ($attempt = 0; $attempt < 20; $attempt++) {
        try {
            $random = bin2hex(random_bytes(6));
        } catch (Throwable $error) {
            $random = substr(md5(uniqid((string)mt_rand(), true)), 0, 12);
        }

        $candidate = $prefix . '-' . strtolower($random);
        if (!xtheme_find_theme($themes, $candidate)) {
            return $candidate;
        }
    }

    return xtheme_unique_theme_id($themes, $prefix, $prefix . '-' . date('YmdHis'));
}

function xtheme_read_theme_file(string $path): ?array
{
    if (!is_file($path)) {
        return null;
    }

    $raw = @file_get_contents($path);
    if ($raw === false || trim($raw) === '') {
        return null;
    }

    $data = json_decode($raw, true);
    if (!is_array($data)) {
        return null;
    }

    return xtheme_sanitize_theme_record($data);
}

function xtheme_write_theme_record(array $theme): bool
{
    $theme = xtheme_sanitize_theme_record($theme);
    if (!is_dir(xtheme_themes_dir())) {
        @mkdir(xtheme_themes_dir(), 0777, true);
    }

    $payload = json_encode($theme, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    return @file_put_contents(xtheme_theme_file_path($theme['id']), $payload . "\n", LOCK_EX) !== false;
}

function xtheme_delete_directory(string $path): bool
{
    if ($path === '' || !file_exists($path)) {
        return true;
    }

    if (is_file($path) || is_link($path)) {
        return @unlink($path);
    }

    $items = @scandir($path);
    if (!is_array($items)) {
        return false;
    }

    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }

        $childPath = $path . '/' . $item;
        if (!xtheme_delete_directory($childPath)) {
            return false;
        }
    }

    return @rmdir($path);
}

function xtheme_delete_theme_record(string $themeId): bool
{
    $themeId = xtheme_theme_slug($themeId);
    if ($themeId === '') {
        return false;
    }

    $themePath = xtheme_theme_file_path($themeId);
    if (is_file($themePath) && !@unlink($themePath)) {
        return false;
    }

    $backgroundPath = xtheme_theme_background_dir($themeId);
    if (!xtheme_delete_directory($backgroundPath)) {
        return false;
    }

    return true;
}

function xtheme_read_themes(): array
{
    if (!is_dir(xtheme_themes_dir())) {
        @mkdir(xtheme_themes_dir(), 0777, true);
    }

    $themes = [];
    foreach (glob(xtheme_themes_dir() . '/*.json') ?: [] as $path) {
        $theme = xtheme_read_theme_file($path);
        if ($theme) {
            $themes[$theme['id']] = $theme;
        }
    }

    $currentConfig = xtheme_read_config();
    $dirty = false;

    if (!$themes) {
        $currentTheme = xtheme_sanitize_theme_record(array_merge(
            [
                'id' => xtheme_theme_slug((string)($currentConfig['theme_id'] ?? 'current-theme'), 'current-theme'),
                'name' => xtheme_sanitize_theme_title($currentConfig['theme_name'] ?? 'Current Theme', 'Current Theme'),
            ],
            xtheme_public_config($currentConfig)
        ));
        $themes[$currentTheme['id']] = $currentTheme;
        $dirty = true;
    }

    foreach (xtheme_builtin_themes() as $builtinTheme) {
        $builtinId = xtheme_theme_slug((string)($builtinTheme['id'] ?? ''), xtheme_theme_slug((string)($builtinTheme['name'] ?? 'theme'), 'theme'));
        if (!isset($themes[$builtinId])) {
            $builtinTheme['id'] = $builtinId;
            $themes[$builtinId] = xtheme_sanitize_theme_record($builtinTheme);
            $dirty = true;
        }
    }

    $selectedThemeId = xtheme_theme_slug((string)($currentConfig['theme_id'] ?? ''), 'current-theme');
    $selectedTheme = xtheme_find_theme(array_values($themes), $selectedThemeId);
    if (!$selectedTheme) {
        $selectedTheme = xtheme_sanitize_theme_record(array_merge(
            [
                'id' => $selectedThemeId,
                'name' => xtheme_sanitize_theme_title($currentConfig['theme_name'] ?? 'Current Theme', 'Current Theme'),
            ],
            xtheme_public_config($currentConfig)
        ));
        $themes[$selectedTheme['id']] = $selectedTheme;
        $dirty = true;
    }

    if ($dirty) {
        foreach ($themes as $theme) {
            xtheme_write_theme_record($theme);
        }
    }

    if (
        $currentConfig['theme_id'] !== $selectedTheme['id'] ||
        $currentConfig['theme_name'] !== $selectedTheme['name']
    ) {
        $currentConfig['theme_id'] = $selectedTheme['id'];
        $currentConfig['theme_name'] = $selectedTheme['name'];
        xtheme_write_config($currentConfig);
    }

    uasort($themes, static function (array $left, array $right): int {
        return strcasecmp($left['name'], $right['name']);
    });

    return array_values($themes);
}

function xtheme_find_theme(array $themes, string $themeId): ?array
{
    $themeId = xtheme_theme_slug($themeId);
    foreach ($themes as $theme) {
        if (is_array($theme) && ($theme['id'] ?? '') === $themeId) {
            return $theme;
        }
    }

    return null;
}

function xtheme_sanitize_bool($value, string $default = '1'): string
{
    $value = (string)$value;
    if ($value === '0' || $value === '1') {
        return $value;
    }

    return $default;
}

function xtheme_sanitize_color($value, string $default): string
{
    $default = trim((string)$default);
    if (!preg_match('/^#[0-9a-fA-F]{6}([0-9a-fA-F]{2})?$/', $default)) {
        $default = '#000000ff';
    } elseif (preg_match('/^#[0-9a-fA-F]{6}$/', $default)) {
        $default .= 'ff';
    }

    $value = trim((string)$value);
    if (preg_match('/^#[0-9a-fA-F]{8}$/', $value)) {
        return strtolower($value);
    }

    if (preg_match('/^#[0-9a-fA-F]{6}$/', $value)) {
        return strtolower($value . 'ff');
    }

    return strtolower($default);
}

function xtheme_alpha_to_hex($value): string
{
    $alpha = (float)xtheme_clamp_number($value, 0, 1, 1, 2);
    return strtolower(str_pad(dechex((int)round($alpha * 255)), 2, '0', STR_PAD_LEFT));
}

function xtheme_color_hex6(string $value, string $default = '#000000ff'): string
{
    return substr(xtheme_sanitize_color($value, $default), 0, 7);
}

function xtheme_color_alpha(string $value, string $default = '#000000ff'): float
{
    $color = xtheme_sanitize_color($value, $default);
    return round(hexdec(substr($color, 7, 2)) / 255, 2);
}

function xtheme_color_with_alpha(string $value, $alpha, string $default = '#000000ff'): string
{
    return xtheme_color_hex6($value, $default) . xtheme_alpha_to_hex($alpha);
}

function xtheme_sanitize_color_with_legacy_alpha($value, string $default, $legacyAlpha = null): string
{
    $value = trim((string)$value);
    if (preg_match('/^#[0-9a-fA-F]{8}$/', $value)) {
        return strtolower($value);
    }

    if (preg_match('/^#[0-9a-fA-F]{6}$/', $value)) {
        return strtolower($value) . xtheme_alpha_to_hex($legacyAlpha ?? 1);
    }

    return xtheme_sanitize_color($default, $default);
}

function xtheme_color_scale_alpha(string $value, float $factor, float $min = 0.0, float $max = 1.0, string $default = '#000000ff'): string
{
    $alpha = xtheme_color_alpha($value, $default) * $factor;
    $alpha = max($min, min($max, $alpha));
    return xtheme_color_with_alpha($value, $alpha, $default);
}

function xtheme_color_shift_alpha(string $value, float $delta, float $min = 0.0, float $max = 1.0, string $default = '#000000ff'): string
{
    $alpha = xtheme_color_alpha($value, $default) + $delta;
    $alpha = max($min, min($max, $alpha));
    return xtheme_color_with_alpha($value, $alpha, $default);
}

function xtheme_color_parts(string $value, string $default = '#000000ff'): array
{
    $color = xtheme_sanitize_color($value, $default);
    $alpha = xtheme_color_alpha($color, $default);

    return [
        'value' => $color,
        'hex' => xtheme_color_hex6($color, $default),
        'alpha' => number_format($alpha, 2, '.', ''),
        'percent' => (string)round($alpha * 100),
    ];
}

function xtheme_clamp_number($value, float $min, float $max, float $default, int $precision = 0): string
{
    if (!is_numeric($value)) {
        $number = $default;
    } else {
        $number = (float)$value;
    }

    if ($number < $min) {
        $number = $min;
    }
    if ($number > $max) {
        $number = $max;
    }

    if ($precision === 0) {
        return (string)(int)round($number);
    }

    return number_format($number, $precision, '.', '');
}

function xtheme_background_to_web($value): string
{
    $value = trim((string)$value);
    if ($value === '') {
        return '';
    }

    if (preg_match('#^https?://#i', $value)) {
        return filter_var($value, FILTER_VALIDATE_URL) ? $value : '';
    }

    if (preg_match('#^/plugins/xtheme/backgrounds/[A-Za-z0-9._%-]+$#', $value)) {
        return $value;
    }

    if (preg_match('#^/plugins/xtheme/backgrounds/[A-Za-z0-9._%-]+/[A-Za-z0-9._%-]+$#', $value)) {
        return $value;
    }

    if (preg_match('#^/boot/config/plugins/xtheme/backgrounds/([A-Za-z0-9._-]+)/([A-Za-z0-9._-]+\.(jpe?g|png|gif|webp))$#i', $value, $matches)) {
        return xtheme_theme_background_web_path($matches[1], $matches[2]);
    }

    if (preg_match('#^/boot/config/plugins/xtheme/backgrounds/(.+)$#', $value, $matches)) {
        return '/plugins/xtheme/backgrounds/' . rawurlencode(basename($matches[1]));
    }

    if (preg_match('#^backgrounds/([A-Za-z0-9._-]+)/([A-Za-z0-9._-]+\.(jpe?g|png|gif|webp))$#i', $value, $matches)) {
        return xtheme_theme_background_web_path($matches[1], $matches[2]);
    }

    if (preg_match('#^backgrounds/(.+)$#', $value, $matches)) {
        return '/plugins/xtheme/backgrounds/' . rawurlencode(basename($matches[1]));
    }

    if (preg_match('/^[A-Za-z0-9._-]+\.(jpe?g|png|gif|webp)$/i', $value)) {
        return '/plugins/xtheme/backgrounds/' . rawurlencode($value);
    }

    return '';
}

function xtheme_dynamix_themes(): array
{
    static $themes = null;
    if ($themes !== null) {
        return $themes;
    }

    $themes = [];
    $themeDir = xtheme_dynamix_theme_dir();
    if (is_dir($themeDir)) {
        $files = @scandir($themeDir) ?: [];
        foreach ($files as $file) {
            if (!preg_match('/^([a-z0-9_-]+)\.css$/i', $file, $matches)) {
                continue;
            }

            $themeName = strtolower($matches[1]);
            $themes[$themeName] = $themeName;
        }
    }

    if (!$themes) {
        $themes = [
            'azure' => 'azure',
            'black' => 'black',
            'gray' => 'gray',
            'white' => 'white',
        ];
    }

    ksort($themes);
    return array_values($themes);
}

function xtheme_sanitize_theme_name($value, string $default): string
{
    $available = xtheme_dynamix_themes();
    $default = strtolower(trim($default));
    if (!in_array($default, $available, true)) {
        $default = $available[0] ?? 'black';
    }

    $value = strtolower(trim((string)$value));
    if ($value !== '' && in_array($value, $available, true)) {
        return $value;
    }

    return $default;
}

function xtheme_sanitize_config(array $input): array
{
    $defaults = xtheme_defaults();
    $config = array_merge($defaults, $input);

    return [
        'theme_id' => xtheme_theme_slug((string)($config['theme_id'] ?? $defaults['theme_id']), xtheme_theme_slug((string)$defaults['theme_id'])),
        'theme_name' => xtheme_sanitize_theme_title($config['theme_name'] ?? $defaults['theme_name'], $defaults['theme_name']),
        'enabled' => xtheme_sanitize_bool($config['enabled'], $defaults['enabled']),
        'dynamix_theme' => xtheme_sanitize_theme_name($config['dynamix_theme'], $defaults['dynamix_theme']),
        'background_image' => xtheme_background_to_web($config['background_image']),
        'text_color' => xtheme_sanitize_color($config['text_color'], $defaults['text_color']),
        'accent_color' => xtheme_sanitize_color($config['accent_color'], $defaults['accent_color']),
        'link_color' => xtheme_sanitize_color($config['link_color'], $defaults['link_color']),
        'highlight_value_color' => xtheme_sanitize_color($config['highlight_value_color'], $defaults['highlight_value_color']),
        'header_color' => xtheme_sanitize_color($config['header_color'], $defaults['header_color']),
        'menu_color' => xtheme_sanitize_color_with_legacy_alpha($config['menu_color'], $defaults['menu_color'], $config['menu_opacity'] ?? xtheme_color_alpha($defaults['menu_color'])),
        'title_color' => xtheme_sanitize_color_with_legacy_alpha($config['title_color'], $defaults['title_color'], $config['title_opacity'] ?? xtheme_color_alpha($defaults['title_color'])),
        'title_text_color' => xtheme_sanitize_color($config['title_text_color'], $defaults['title_text_color']),
        'secondary_text_color' => xtheme_sanitize_color($config['secondary_text_color'], $defaults['secondary_text_color']),
        'panel_color' => xtheme_sanitize_color_with_legacy_alpha($config['panel_color'], $defaults['panel_color'], $config['panel_opacity'] ?? xtheme_color_alpha($defaults['panel_color'])),
        'progress_fill_color' => xtheme_sanitize_color($config['progress_fill_color'], $defaults['progress_fill_color']),
        'progress_track_color' => xtheme_sanitize_color($config['progress_track_color'], $defaults['progress_track_color']),
        'panel_border_color' => xtheme_sanitize_color_with_legacy_alpha($config['panel_border_color'], $defaults['panel_border_color'], $config['panel_border_opacity'] ?? xtheme_color_alpha($defaults['panel_border_color'])),
        'background_blur' => xtheme_clamp_number($config['background_blur'], 0, 40, (float)$defaults['background_blur']),
        'glass_blur' => xtheme_clamp_number($config['glass_blur'], 0, 25, (float)$defaults['glass_blur']),
        'overlay_opacity' => xtheme_clamp_number($config['overlay_opacity'], 0.00, 0.90, (float)$defaults['overlay_opacity'], 2),
        'dynamix_state_active' => xtheme_sanitize_bool($config['dynamix_state_active'], $defaults['dynamix_state_active']),
        'dynamix_backup_theme' => strtolower(trim((string)$config['dynamix_backup_theme'])),
        'dynamix_backup_header' => strtolower(preg_replace('/[^0-9a-f]/i', '', (string)$config['dynamix_backup_header'] ?? '')),
        'dynamix_backup_headermetacolor' => strtolower(preg_replace('/[^0-9a-f]/i', '', (string)$config['dynamix_backup_headermetacolor'] ?? '')),
    ];
}

function xtheme_public_config(array $config): array
{
    $config = xtheme_sanitize_config($config);
    $public = [];
    foreach (xtheme_shareable_keys() as $key) {
        $public[$key] = $config[$key];
    }

    return $public;
}

function xtheme_ini_quote(string $value): string
{
    return '"' . addcslashes($value, "\\\"") . '"';
}

function xtheme_write_config(array $input): bool
{
    $config = xtheme_sanitize_config($input);
    $lines = ['[XTheme]'];
    foreach (xtheme_defaults() as $key => $_default) {
        $lines[] = $key . '=' . xtheme_ini_quote((string)($config[$key] ?? ''));
    }
    $content = implode("\n", $lines) . "\n";

    $dir = dirname(xtheme_config_path());
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }

    $written = @file_put_contents(xtheme_config_path(), $content, LOCK_EX) !== false;
    if ($written) {
        require_once __DIR__ . '/login_theme_runtime.php';
        if (function_exists('xtheme_login_theme_refresh_from_config')) {
            xtheme_login_theme_refresh_from_config($config);
        }
    }

    return $written;
}

function xtheme_read_config(): array
{
    $defaults = xtheme_defaults();
    $cfgPath = xtheme_config_path();

    if (!is_file($cfgPath)) {
        return $defaults;
    }

    $raw = @parse_ini_file($cfgPath, true, INI_SCANNER_RAW);
    $values = [];
    if (is_array($raw) && isset($raw['XTheme']) && is_array($raw['XTheme'])) {
        $values = $raw['XTheme'];
    }

    $dynamixDisplay = xtheme_read_ini_sections(xtheme_dynamix_config_path())['display'] ?? [];
    if (is_array($dynamixDisplay)) {
        if (!array_key_exists('dynamix_theme', $values) && !empty($dynamixDisplay['theme'])) {
            $values['dynamix_theme'] = (string)$dynamixDisplay['theme'];
        }

        if (!array_key_exists('secondary_text_color', $values) && !empty($dynamixDisplay['headermetacolor'])) {
            $metaColor = preg_replace('/[^0-9a-f]/i', '', (string)$dynamixDisplay['headermetacolor']);
            if (preg_match('/^[0-9a-f]{3}$/i', $metaColor)) {
                $metaColor = preg_replace('/(.)/', '$1$1', $metaColor);
            }
            if (preg_match('/^[0-9a-f]{6}$/i', $metaColor)) {
                $values['secondary_text_color'] = '#' . strtolower($metaColor) . 'ff';
            }
        }
    }

    return xtheme_sanitize_config(array_merge($defaults, $values));
}

function xtheme_read_ini_sections(string $path): array
{
    if (!is_file($path)) {
        return [];
    }

    $parsed = @parse_ini_file($path, true, INI_SCANNER_RAW);
    return is_array($parsed) ? $parsed : [];
}

function xtheme_write_ini_sections(string $path, array $sections): bool
{
    $lines = [];
    foreach ($sections as $section => $values) {
        $lines[] = '[' . $section . ']';
        if (is_array($values)) {
            foreach ($values as $key => $value) {
                $lines[] = $key . '=' . xtheme_ini_quote((string)$value);
            }
        }
    }

    $content = implode("\n", $lines) . "\n";
    return @file_put_contents($path, $content, LOCK_EX) !== false;
}

function xtheme_capture_dynamix_backup(array $display): array
{
    $backup = [];
    foreach (xtheme_dynamix_backup_keys() as $key) {
        if (array_key_exists($key, $display)) {
            $backup[$key] = (string)$display[$key];
        }
    }

    return $backup;
}

function xtheme_write_dynamix_backup(array $display): bool
{
    $backup = xtheme_capture_dynamix_backup($display);
    $dir = dirname(xtheme_dynamix_backup_path());
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }

    $payload = json_encode($backup, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    return is_string($payload) && @file_put_contents(xtheme_dynamix_backup_path(), $payload . "\n", LOCK_EX) !== false;
}

function xtheme_read_dynamix_backup(): array
{
    $path = xtheme_dynamix_backup_path();
    if (!is_file($path)) {
        return [];
    }

    $raw = @file_get_contents($path);
    if (!is_string($raw) || trim($raw) === '') {
        return [];
    }

    $data = json_decode($raw, true);
    if (!is_array($data)) {
        return [];
    }

    $backup = [];
    foreach (xtheme_dynamix_backup_keys() as $key) {
        if (array_key_exists($key, $data)) {
            $backup[$key] = (string)$data[$key];
        }
    }

    return $backup;
}

function xtheme_clear_dynamix_backup(): void
{
    @unlink(xtheme_dynamix_backup_path());
}

function xtheme_sync_dynamix_display(array $themeConfig): array
{
    $themeConfig = xtheme_sanitize_config($themeConfig);
    $dynamixPath = xtheme_dynamix_config_path();
    $sections = xtheme_read_ini_sections($dynamixPath);
    if (!$sections) {
        return $themeConfig;
    }

    $display = $sections['display'] ?? [];
    if (!is_array($display)) {
        $display = [];
    }

    $needsConfigWrite = false;
    $needsDynamixWrite = false;

    if ($themeConfig['enabled'] === '1') {
        if ($themeConfig['dynamix_state_active'] !== '1') {
            $themeConfig['dynamix_state_active'] = '1';
            $themeConfig['dynamix_backup_theme'] = strtolower((string)($display['theme'] ?? ''));
            $themeConfig['dynamix_backup_header'] = strtolower((string)($display['header'] ?? ''));
            $themeConfig['dynamix_backup_headermetacolor'] = strtolower((string)($display['headermetacolor'] ?? ''));
            xtheme_write_dynamix_backup($display);
            $needsConfigWrite = true;
        }

        $desiredTheme = xtheme_sanitize_theme_name($themeConfig['dynamix_theme'], 'black');
        $desiredHeader = strtolower(ltrim(xtheme_color_hex6($themeConfig['title_text_color']), '#'));
        $desiredMeta = strtolower(ltrim(xtheme_color_hex6($themeConfig['secondary_text_color']), '#'));

        if (strtolower((string)($display['theme'] ?? '')) !== $desiredTheme) {
            $display['theme'] = $desiredTheme;
            $needsDynamixWrite = true;
        }

        if (strtolower((string)($display['header'] ?? '')) !== $desiredHeader) {
            $display['header'] = $desiredHeader;
            $needsDynamixWrite = true;
        }

        if (strtolower((string)($display['headermetacolor'] ?? '')) !== $desiredMeta) {
            $display['headermetacolor'] = $desiredMeta;
            $needsDynamixWrite = true;
        }
    } elseif ($themeConfig['dynamix_state_active'] === '1') {
        $backupDisplay = xtheme_read_dynamix_backup();
        if (!$backupDisplay) {
            $backupDisplay = array_filter([
                'theme' => $themeConfig['dynamix_backup_theme'],
                'header' => $themeConfig['dynamix_backup_header'],
                'headermetacolor' => $themeConfig['dynamix_backup_headermetacolor'],
            ], static function ($value): bool {
                return $value !== '';
            });
        }

        foreach ($backupDisplay as $key => $value) {
            if ((string)($display[$key] ?? '') !== (string)$value) {
                $display[$key] = (string)$value;
                $needsDynamixWrite = true;
            }
        }

        $themeConfig['dynamix_state_active'] = '0';
        $themeConfig['dynamix_backup_theme'] = '';
        $themeConfig['dynamix_backup_header'] = '';
        $themeConfig['dynamix_backup_headermetacolor'] = '';
        xtheme_clear_dynamix_backup();
        $needsConfigWrite = true;
    }

    if ($needsDynamixWrite) {
        $sections['display'] = $display;
        xtheme_write_ini_sections($dynamixPath, $sections);
    }

    if ($needsConfigWrite) {
        xtheme_write_config($themeConfig);
    }

    return xtheme_sanitize_config($themeConfig);
}

function xtheme_live_config(): array
{
    return xtheme_sync_dynamix_display(xtheme_read_config());
}

function xtheme_local_background_file(string $value): string
{
    $value = trim($value);
    if ($value === '') {
        return '';
    }

    if (preg_match('#^/plugins/xtheme/backgrounds/([^/]+)/([^/]+)$#', $value, $matches)) {
        $candidate = xtheme_theme_background_dir(rawurldecode($matches[1])) . '/' . basename(rawurldecode($matches[2]));
        return is_file($candidate) ? $candidate : '';
    }

    if (preg_match('#^/plugins/xtheme/backgrounds/([^/]+)$#', $value, $matches)) {
        $candidate = xtheme_background_dir() . '/' . basename(rawurldecode($matches[1]));
        return is_file($candidate) ? $candidate : '';
    }

    if (preg_match('#^/boot/config/plugins/xtheme/backgrounds/([^/]+)/([^/]+)$#', $value, $matches)) {
        $candidate = xtheme_theme_background_dir($matches[1]) . '/' . basename($matches[2]);
        return is_file($candidate) ? $candidate : '';
    }

    if (preg_match('#^/boot/config/plugins/xtheme/backgrounds/([^/]+)$#', $value, $matches)) {
        $candidate = xtheme_background_dir() . '/' . basename($matches[1]);
        return is_file($candidate) ? $candidate : '';
    }

    return '';
}

function xtheme_hex_to_rgba(string $hex, $opacity = null): string
{
    $color = xtheme_sanitize_color($hex, '#000000ff');
    $hex = ltrim($color, '#');
    $opacity = $opacity === null ? xtheme_color_alpha($color, '#000000ff') : (float)xtheme_clamp_number($opacity, 0, 1, 1, 2);

    $red = hexdec(substr($hex, 0, 2));
    $green = hexdec(substr($hex, 2, 2));
    $blue = hexdec(substr($hex, 4, 2));

    return sprintf('rgba(%d, %d, %d, %s)', $red, $green, $blue, number_format($opacity, 2, '.', ''));
}

function xtheme_json_response(array $payload): void
{
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($payload);
    exit;
}
