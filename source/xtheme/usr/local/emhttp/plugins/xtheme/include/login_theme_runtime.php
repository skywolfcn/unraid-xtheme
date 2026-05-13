<?php

function xtheme_login_theme_config_path(): string
{
    return '/boot/config/plugins/xtheme/xtheme.cfg';
}

function xtheme_login_theme_output_path(): string
{
    return '/boot/config/plugins/xtheme/login-theme.html';
}

function xtheme_login_theme_background_dir(): string
{
    return '/boot/config/plugins/xtheme/backgrounds';
}

function xtheme_login_theme_defaults(): array
{
    return [
        'enabled' => '1',
        'background_image' => '',
        'text_color' => '#e8edf5ff',
        'accent_color' => '#72e0ffff',
        'secondary_text_color' => '#dbe4f0ff',
        'panel_color' => '#1320337a',
        'panel_border_color' => '#ffffff2e',
        'background_blur' => '20',
        'glass_blur' => '12',
        'overlay_opacity' => '0.42',
    ];
}

function xtheme_login_theme_clamp($value, float $min, float $max, float $fallback, int $precision = 2): float
{
    if (!is_numeric($value)) {
        return $fallback;
    }

    $value = (float)$value;
    if ($value < $min) {
        $value = $min;
    } elseif ($value > $max) {
        $value = $max;
    }

    return round($value, $precision);
}

function xtheme_login_theme_sanitize_color($value, string $default = '#000000ff'): string
{
    $value = strtolower(trim((string)$value));
    $value = preg_replace('/[^0-9a-f#]/i', '', $value);
    if ($value === null) {
        $value = '';
    }

    if ($value === '') {
        return strtolower($default);
    }

    if ($value[0] !== '#') {
        $value = '#' . $value;
    }

    $hex = substr($value, 1);
    if (preg_match('/^[0-9a-f]{3}$/', $hex)) {
        $hex = preg_replace('/(.)/', '$1$1', $hex);
        return '#' . $hex . 'ff';
    }

    if (preg_match('/^[0-9a-f]{4}$/', $hex)) {
        return '#' . preg_replace('/(.)/', '$1$1', $hex);
    }

    if (preg_match('/^[0-9a-f]{6}$/', $hex)) {
        return '#' . $hex . 'ff';
    }

    if (preg_match('/^[0-9a-f]{8}$/', $hex)) {
        return '#' . $hex;
    }

    return strtolower($default);
}

function xtheme_login_theme_color_alpha(string $value): float
{
    $color = xtheme_login_theme_sanitize_color($value);
    $hex = substr($color, 1);
    return round(hexdec(substr($hex, 6, 2)) / 255, 2);
}

function xtheme_login_theme_color_scale_alpha(string $value, float $factor, float $min = 0.0, float $max = 1.0, string $default = '#000000ff'): string
{
    $color = xtheme_login_theme_sanitize_color($value, $default);
    $hex = substr($color, 1, 6);
    $alpha = xtheme_login_theme_clamp(xtheme_login_theme_color_alpha($color) * $factor, $min, $max, xtheme_login_theme_color_alpha($default), 2);
    return sprintf('#%s%02x', $hex, (int)round($alpha * 255));
}

function xtheme_login_theme_color_shift_alpha(string $value, float $delta, float $min = 0.0, float $max = 1.0, string $default = '#000000ff'): string
{
    $color = xtheme_login_theme_sanitize_color($value, $default);
    $hex = substr($color, 1, 6);
    $alpha = xtheme_login_theme_clamp(xtheme_login_theme_color_alpha($color) + $delta, $min, $max, xtheme_login_theme_color_alpha($default), 2);
    return sprintf('#%s%02x', $hex, (int)round($alpha * 255));
}

function xtheme_login_theme_hex_to_rgba(string $value, $opacity = null): string
{
    $color = xtheme_login_theme_sanitize_color($value);
    $hex = substr($color, 1);
    $alpha = $opacity === null
        ? xtheme_login_theme_color_alpha($color)
        : xtheme_login_theme_clamp($opacity, 0.0, 1.0, 1.0, 2);

    $red = hexdec(substr($hex, 0, 2));
    $green = hexdec(substr($hex, 2, 2));
    $blue = hexdec(substr($hex, 4, 2));

    return sprintf('rgba(%d, %d, %d, %s)', $red, $green, $blue, number_format($alpha, 2, '.', ''));
}

function xtheme_login_theme_local_background_file(string $value): string
{
    $value = trim($value);
    if ($value === '') {
        return '';
    }

    if (preg_match('#^/plugins/xtheme/backgrounds/([^/]+)/([^/]+)$#', $value, $matches)) {
        $candidate = xtheme_login_theme_background_dir() . '/' . rawurldecode($matches[1]) . '/' . basename(rawurldecode($matches[2]));
        return is_file($candidate) ? $candidate : '';
    }

    if (preg_match('#^/plugins/xtheme/backgrounds/([^/]+)$#', $value, $matches)) {
        $candidate = xtheme_login_theme_background_dir() . '/' . basename(rawurldecode($matches[1]));
        return is_file($candidate) ? $candidate : '';
    }

    if (preg_match('#^/boot/config/plugins/xtheme/backgrounds/([^/]+)/([^/]+)$#', $value, $matches)) {
        $candidate = xtheme_login_theme_background_dir() . '/' . $matches[1] . '/' . basename($matches[2]);
        return is_file($candidate) ? $candidate : '';
    }

    if (preg_match('#^/boot/config/plugins/xtheme/backgrounds/([^/]+)$#', $value, $matches)) {
        $candidate = xtheme_login_theme_background_dir() . '/' . basename($matches[1]);
        return is_file($candidate) ? $candidate : '';
    }

    return '';
}

function xtheme_login_theme_background_css(string $backgroundImage): string
{
    $backgroundImage = trim($backgroundImage);
    if ($backgroundImage === '') {
        return '';
    }

    $localFile = xtheme_login_theme_local_background_file($backgroundImage);
    if ($localFile !== '' && is_readable($localFile)) {
        $mime = 'image/jpeg';
        if (class_exists('finfo')) {
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $detected = (string)$finfo->file($localFile);
            if (preg_match('#^image/(jpeg|png|gif|webp)$#i', $detected)) {
                $mime = strtolower($detected);
            }
        }

        $binary = @file_get_contents($localFile);
        if (is_string($binary) && $binary !== '') {
            return 'data:' . $mime . ';base64,' . base64_encode($binary);
        }
    }

    if (preg_match('#^https?://#i', $backgroundImage)) {
        return $backgroundImage;
    }

    return '';
}

function xtheme_login_theme_read_config(): array
{
    $config = xtheme_login_theme_defaults();
    $path = xtheme_login_theme_config_path();
    if (!is_file($path)) {
        return $config;
    }

    $raw = @parse_ini_file($path, true, INI_SCANNER_RAW);
    if (is_array($raw) && isset($raw['XTheme']) && is_array($raw['XTheme'])) {
        $config = array_merge($config, $raw['XTheme']);
    }

    $config['enabled'] = ((string)($config['enabled'] ?? '0') === '1') ? '1' : '0';
    $config['background_image'] = trim((string)($config['background_image'] ?? ''));
    $config['text_color'] = xtheme_login_theme_sanitize_color($config['text_color'] ?? '', xtheme_login_theme_defaults()['text_color']);
    $config['accent_color'] = xtheme_login_theme_sanitize_color($config['accent_color'] ?? '', xtheme_login_theme_defaults()['accent_color']);
    $config['secondary_text_color'] = xtheme_login_theme_sanitize_color($config['secondary_text_color'] ?? '', xtheme_login_theme_defaults()['secondary_text_color']);
    $config['panel_color'] = xtheme_login_theme_sanitize_color($config['panel_color'] ?? '', xtheme_login_theme_defaults()['panel_color']);
    $config['panel_border_color'] = xtheme_login_theme_sanitize_color($config['panel_border_color'] ?? '', xtheme_login_theme_defaults()['panel_border_color']);
    $config['background_blur'] = (string)(int)xtheme_login_theme_clamp($config['background_blur'] ?? 20, 0, 40, 20, 0);
    $config['glass_blur'] = (string)(int)xtheme_login_theme_clamp($config['glass_blur'] ?? 12, 0, 40, 12, 0);
    $config['overlay_opacity'] = (string)xtheme_login_theme_clamp($config['overlay_opacity'] ?? 0.42, 0.0, 0.9, 0.42, 2);

    return $config;
}

function xtheme_login_theme_render_markup(array $config): string
{
    if (($config['enabled'] ?? '0') !== '1') {
        return '';
    }

    $backgroundImageCss = xtheme_login_theme_background_css((string)($config['background_image'] ?? ''));
    $textColor = xtheme_login_theme_hex_to_rgba((string)$config['text_color']);
    $secondaryTextColor = xtheme_login_theme_hex_to_rgba((string)$config['secondary_text_color']);
    $panelColor = xtheme_login_theme_hex_to_rgba((string)$config['panel_color']);
    $panelBorder = xtheme_login_theme_hex_to_rgba((string)$config['panel_border_color']);
    $inputColor = xtheme_login_theme_hex_to_rgba(xtheme_login_theme_color_shift_alpha((string)$config['panel_color'], 0.06, 0.08, 0.95));
    $placeholderColor = xtheme_login_theme_hex_to_rgba(xtheme_login_theme_color_scale_alpha((string)$config['text_color'], 0.60));
    $overlayColor = xtheme_login_theme_hex_to_rgba('#050b14', (float)$config['overlay_opacity']);
    $accentColor = xtheme_login_theme_hex_to_rgba((string)$config['accent_color']);
    $accentStrong = xtheme_login_theme_hex_to_rgba(xtheme_login_theme_color_scale_alpha((string)$config['accent_color'], 0.82));
    $glassBlur = (int)$config['glass_blur'];
    $backgroundBlur = (int)$config['background_blur'];
    $shadow = '0 18px 50px rgba(0, 0, 0, 0.28)';

    ob_start();
    ?>
<style id="xtheme-login-hook">
  body {
    background: transparent !important;
    color: <?= $textColor ?> !important;
    position: relative;
    min-height: 100vh;
    overflow: hidden;
  }

  body::before,
  body::after {
    content: '';
    position: fixed;
    inset: 0;
    pointer-events: none;
  }

  body::before {
    z-index: -2;
<?php if ($backgroundImageCss !== ''): ?>
    background-image: url('<?= htmlspecialchars($backgroundImageCss, ENT_QUOTES) ?>');
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
<?php else: ?>
    background:
      radial-gradient(circle at top left, rgba(114, 224, 255, 0.22), transparent 36%),
      radial-gradient(circle at top right, rgba(56, 189, 248, 0.18), transparent 28%),
      linear-gradient(135deg, #07111d 0%, #0c1628 42%, #020617 100%);
<?php endif; ?>
    filter: blur(<?= $backgroundBlur ?>px);
    transform: scale(1.06);
  }

  body::after {
    z-index: -1;
    background: <?= $overlayColor ?>;
  }

  #login {
    background: transparent !important;
    border: 1px solid <?= $panelBorder ?> !important;
    box-shadow: <?= $shadow ?> !important;
    overflow: hidden;
  }

  #login .content {
    background: <?= $panelColor ?> !important;
    color: <?= $textColor ?> !important;
    backdrop-filter: blur(<?= $glassBlur ?>px) saturate(1.20);
    -webkit-backdrop-filter: blur(<?= $glassBlur ?>px) saturate(1.20);
  }

  #login .form,
  #login h1,
  #login h2,
  #login .case,
  #login .content,
  #login .content * {
    color: <?= $textColor ?> !important;
  }

  #login h2,
  #login .case,
  #login .content small,
  #login .content .muted {
    color: <?= $secondaryTextColor ?> !important;
  }

  #login .error {
    color: #fda4af !important;
  }

  #login [type=email],
  #login [type=number],
  #login [type=password],
  #login [type=search],
  #login [type=tel],
  #login [type=text],
  #login [type=url],
  #login textarea {
    background: <?= $inputColor ?> !important;
    color: <?= $textColor ?> !important;
    border: 1px solid <?= $panelBorder ?> !important;
    box-shadow: none !important;
  }

  #login [type=email]::placeholder,
  #login [type=number]::placeholder,
  #login [type=password]::placeholder,
  #login [type=search]::placeholder,
  #login [type=tel]::placeholder,
  #login [type=text]::placeholder,
  #login [type=url]::placeholder,
  #login textarea::placeholder {
    color: <?= $placeholderColor ?> !important;
  }

  #login [type=email]:active,
  #login [type=email]:focus,
  #login [type=number]:active,
  #login [type=number]:focus,
  #login [type=password]:active,
  #login [type=password]:focus,
  #login [type=search]:active,
  #login [type=search]:focus,
  #login [type=tel]:active,
  #login [type=tel]:focus,
  #login [type=text]:active,
  #login [type=text]:focus,
  #login [type=url]:active,
  #login [type=url]:focus,
  #login textarea:active,
  #login textarea:focus {
    border-color: <?= $accentColor ?> !important;
    box-shadow: 0 0 0 1px <?= $accentColor ?> !important;
  }

  #login .button,
  #login button[type=submit] {
    color: #fff7ed !important;
    background: linear-gradient(135deg, <?= $accentStrong ?>, <?= $accentColor ?>) !important;
    border: none !important;
    box-shadow: 0 12px 28px rgba(255, 106, 31, 0.28) !important;
  }

  #login .button:hover,
  #login button[type=submit]:hover {
    filter: brightness(1.08);
  }

  #login a {
    color: <?= $accentColor ?> !important;
  }
</style>
<?php
    return (string)ob_get_clean();
}

function xtheme_login_theme_refresh_from_config(array $config): bool
{
    $outputPath = xtheme_login_theme_output_path();
    $dir = dirname($outputPath);
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }

    $markup = xtheme_login_theme_render_markup($config);
    if ($markup === '') {
        @unlink($outputPath);
        return true;
    }

    return @file_put_contents($outputPath, $markup, LOCK_EX) !== false;
}

function xtheme_login_theme_refresh(): bool
{
    return xtheme_login_theme_refresh_from_config(xtheme_login_theme_read_config());
}
