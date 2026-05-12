<?php

function xtheme_storage_dir(): string
{
    return '/boot/config/plugins/xtheme';
}

function xtheme_background_dir(): string
{
    return xtheme_storage_dir() . '/backgrounds';
}

function xtheme_config_path(): string
{
    return xtheme_storage_dir() . '/xtheme.cfg';
}

function xtheme_defaults(): array
{
    return [
        'enabled' => '1',
        'background_image' => '',
        'text_color' => '#e8edf5ff',
        'accent_color' => '#72e0ffff',
        'link_color' => '#72e0ffff',
        'highlight_value_color' => '#86efacff',
        'header_color' => '#101827d6',
        'menu_color' => '#0f1724cc',
        'title_color' => '#1320338c',
        'title_text_color' => '#f8fafcff',
        'panel_color' => '#1320337a',
        'progress_fill_color' => '#38bdf8e0',
        'progress_track_color' => '#2b3440eb',
        'panel_border_color' => '#ffffff2e',
        'background_blur' => '20',
        'glass_blur' => '12',
        'overlay_opacity' => '0.42',
    ];
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
            'theme_toggle_text' => 'Keep it simple: background, key colors, and a few glass controls.',
            'enable_theme' => 'Enable theme',
            'background_image_url' => 'Background image URL',
            'text_color' => 'Text color',
            'accent_color' => 'Accent color',
            'link_color' => 'Link text color',
            'highlight_value_color' => 'Highlight value color',
            'header_color' => 'Header color',
            'menu_color' => 'Menu color',
            'title_bar_color' => 'Title bar color',
            'title_text_color' => 'Title text color',
            'panel_color' => 'Panel color',
            'progress_fill_color' => 'Progress fill color',
            'progress_track_color' => 'Progress track color',
            'save_theme' => 'Save Theme',
            'background_title' => 'Background Image',
            'background_text' => 'Upload a local image or paste a remote image URL. Uploading fills the URL field for you.',
            'upload_image' => 'Upload image',
            'upload_background' => 'Upload Background',
            'clear_background' => 'Clear Background',
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
            'status_saving' => 'Saving XTheme settings...',
            'status_choose_image' => 'Choose an image first.',
            'status_uploading' => 'Uploading background...',
            'status_upload_unreadable' => 'Upload returned an unreadable response.',
            'status_upload_failed' => 'Upload failed.',
            'status_upload_refresh' => 'Security token expired. Refresh the page and try again.',
            'status_uploaded' => 'Background uploaded. Click Save Theme to apply it.',
            'status_cleared' => 'Background path cleared. Click Save Theme to apply it.',
            'upload_post_required' => 'POST required.',
            'upload_missing_file' => 'No image uploaded.',
            'upload_failed' => 'Upload failed.',
            'upload_invalid' => 'Invalid upload.',
            'upload_only_images' => 'Only JPG, PNG, GIF, and WEBP are supported.',
            'upload_too_large' => 'Image is too large. Use 15 MB or less.',
            'upload_store_failed' => 'Unable to store the uploaded image.',
            'upload_success' => 'Background uploaded. Click Save Theme to apply it.',
        ],
        'zh' => [
            'x_theme' => 'XTheme',
            'theme_toggle_title' => '主题设置',
            'theme_toggle_text' => '保持简单：只调背景、关键颜色和几项毛玻璃参数。',
            'enable_theme' => '启用主题',
            'background_image_url' => '背景图片地址',
            'text_color' => '文字颜色',
            'accent_color' => '强调色',
            'link_color' => '超链接文字颜色',
            'highlight_value_color' => '高亮数值颜色',
            'header_color' => '顶栏颜色',
            'menu_color' => '菜单颜色',
            'title_bar_color' => '标题栏颜色',
            'title_text_color' => '标题文字颜色',
            'panel_color' => '面板颜色',
            'progress_fill_color' => '进度条填充颜色',
            'progress_track_color' => '进度条底色',
            'save_theme' => '保存主题',
            'background_title' => '背景图片',
            'background_text' => '可以上传本地图片，也可以直接粘贴远程图片地址。上传成功后会自动填入背景地址。',
            'upload_image' => '上传图片',
            'upload_background' => '上传背景图',
            'clear_background' => '清空背景图',
            'glass_title' => '毛玻璃调节',
            'glass_text' => '用这几项来调背景模糊、面板毛玻璃和整体遮罩强度。',
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
            'status_saving' => '正在保存 XTheme 设置...',
            'status_choose_image' => '请先选择一张图片。',
            'status_uploading' => '正在上传背景图...',
            'status_upload_unreadable' => '上传返回内容无法识别。',
            'status_upload_failed' => '上传失败。',
            'status_upload_refresh' => '页面安全校验已失效，请刷新页面后重试。',
            'status_uploaded' => '背景图已上传，点击“保存主题”即可应用。',
            'status_cleared' => '背景图地址已清空，点击“保存主题”即可应用。',
            'upload_post_required' => '需要使用 POST 请求。',
            'upload_missing_file' => '没有收到上传图片。',
            'upload_failed' => '上传失败。',
            'upload_invalid' => '上传文件无效。',
            'upload_only_images' => '仅支持 JPG、PNG、GIF 和 WEBP 图片。',
            'upload_too_large' => '图片太大了，请控制在 15 MB 以内。',
            'upload_store_failed' => '无法保存上传图片。',
            'upload_success' => '背景图已上传，点击“保存主题”即可应用。',
        ],
    ];

    $language = xtheme_is_chinese() ? 'zh' : 'en';
    return $messages[$language][$key] ?? $messages['en'][$key] ?? $key;
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

    if (preg_match('#^/boot/config/plugins/xtheme/backgrounds/(.+)$#', $value, $matches)) {
        return '/plugins/xtheme/backgrounds/' . rawurlencode(basename($matches[1]));
    }

    if (preg_match('#^backgrounds/(.+)$#', $value, $matches)) {
        return '/plugins/xtheme/backgrounds/' . rawurlencode(basename($matches[1]));
    }

    if (preg_match('/^[A-Za-z0-9._-]+\.(jpe?g|png|gif|webp)$/i', $value)) {
        return '/plugins/xtheme/backgrounds/' . rawurlencode($value);
    }

    return '';
}

function xtheme_sanitize_config(array $input): array
{
    $defaults = xtheme_defaults();
    $config = array_merge($defaults, $input);

    return [
        'enabled' => xtheme_sanitize_bool($config['enabled'], $defaults['enabled']),
        'background_image' => xtheme_background_to_web($config['background_image']),
        'text_color' => xtheme_sanitize_color($config['text_color'], $defaults['text_color']),
        'accent_color' => xtheme_sanitize_color($config['accent_color'], $defaults['accent_color']),
        'link_color' => xtheme_sanitize_color($config['link_color'], $defaults['link_color']),
        'highlight_value_color' => xtheme_sanitize_color($config['highlight_value_color'], $defaults['highlight_value_color']),
        'header_color' => xtheme_sanitize_color($config['header_color'], $defaults['header_color']),
        'menu_color' => xtheme_sanitize_color_with_legacy_alpha($config['menu_color'], $defaults['menu_color'], $config['menu_opacity'] ?? xtheme_color_alpha($defaults['menu_color'])),
        'title_color' => xtheme_sanitize_color_with_legacy_alpha($config['title_color'], $defaults['title_color'], $config['title_opacity'] ?? xtheme_color_alpha($defaults['title_color'])),
        'title_text_color' => xtheme_sanitize_color($config['title_text_color'], $defaults['title_text_color']),
        'panel_color' => xtheme_sanitize_color_with_legacy_alpha($config['panel_color'], $defaults['panel_color'], $config['panel_opacity'] ?? xtheme_color_alpha($defaults['panel_color'])),
        'progress_fill_color' => xtheme_sanitize_color($config['progress_fill_color'], $defaults['progress_fill_color']),
        'progress_track_color' => xtheme_sanitize_color($config['progress_track_color'], $defaults['progress_track_color']),
        'panel_border_color' => xtheme_sanitize_color_with_legacy_alpha($config['panel_border_color'], $defaults['panel_border_color'], $config['panel_border_opacity'] ?? xtheme_color_alpha($defaults['panel_border_color'])),
        'background_blur' => xtheme_clamp_number($config['background_blur'], 0, 40, (float)$defaults['background_blur']),
        'glass_blur' => xtheme_clamp_number($config['glass_blur'], 0, 25, (float)$defaults['glass_blur']),
        'overlay_opacity' => xtheme_clamp_number($config['overlay_opacity'], 0.00, 0.90, (float)$defaults['overlay_opacity'], 2),
    ];
}

function xtheme_read_config(): array
{
    $defaults = xtheme_defaults();
    $cfgPath = xtheme_config_path();

    if (!is_file($cfgPath)) {
        return $defaults;
    }

    $raw = @parse_ini_file($cfgPath, true);
    $values = [];
    if (is_array($raw) && isset($raw['XTheme']) && is_array($raw['XTheme'])) {
        $values = $raw['XTheme'];
    }

    return xtheme_sanitize_config(array_merge($defaults, $values));
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
