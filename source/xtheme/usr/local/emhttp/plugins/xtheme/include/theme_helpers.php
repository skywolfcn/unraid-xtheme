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
        'text_color' => '#e8edf5',
        'accent_color' => '#72e0ff',
        'header_color' => '#101827',
        'menu_color' => '#0f1724',
        'panel_color' => '#132033',
        'panel_opacity' => '0.72',
        'panel_border_color' => '#ffffff',
        'panel_border_opacity' => '0.18',
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
            'header_color' => 'Header color',
            'menu_color' => 'Menu color',
            'panel_color' => 'Panel color',
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
            'panel_opacity' => 'Panel opacity',
            'panel_border_color' => 'Panel border color',
            'panel_border_opacity' => 'Panel border opacity',
            'status_saving' => 'Saving XTheme settings...',
            'status_choose_image' => 'Choose an image first.',
            'status_uploading' => 'Uploading background...',
            'status_upload_unreadable' => 'Upload returned an unreadable response.',
            'status_upload_failed' => 'Upload failed.',
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
            'header_color' => '顶栏颜色',
            'menu_color' => '菜单颜色',
            'panel_color' => '面板颜色',
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
            'panel_opacity' => '面板透明度',
            'panel_border_color' => '面板边框颜色',
            'panel_border_opacity' => '面板边框透明度',
            'status_saving' => '正在保存 XTheme 设置...',
            'status_choose_image' => '请先选择一张图片。',
            'status_uploading' => '正在上传背景图...',
            'status_upload_unreadable' => '上传返回内容无法识别。',
            'status_upload_failed' => '上传失败。',
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
    $value = trim((string)$value);
    if (preg_match('/^#[0-9a-fA-F]{6}$/', $value)) {
        return strtolower($value);
    }
    return strtolower($default);
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
        'header_color' => xtheme_sanitize_color($config['header_color'], $defaults['header_color']),
        'menu_color' => xtheme_sanitize_color($config['menu_color'], $defaults['menu_color']),
        'panel_color' => xtheme_sanitize_color($config['panel_color'], $defaults['panel_color']),
        'panel_opacity' => xtheme_clamp_number($config['panel_opacity'], 0.10, 1.00, (float)$defaults['panel_opacity'], 2),
        'panel_border_color' => xtheme_sanitize_color($config['panel_border_color'], $defaults['panel_border_color']),
        'panel_border_opacity' => xtheme_clamp_number($config['panel_border_opacity'], 0.00, 1.00, (float)$defaults['panel_border_opacity'], 2),
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

function xtheme_hex_to_rgba(string $hex, $opacity): string
{
    $hex = ltrim(xtheme_sanitize_color($hex, '#000000'), '#');
    $opacity = (float)xtheme_clamp_number($opacity, 0, 1, 1, 2);

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

