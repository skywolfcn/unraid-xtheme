<?php
require_once '/usr/local/emhttp/plugins/xtheme/include/theme_helpers.php';

$themeConfig = xtheme_read_config();
if (($themeConfig['enabled'] ?? '0') !== '1') {
    return;
}

$backgroundImage = (string)($themeConfig['background_image'] ?? '');
$backgroundImageCss = '';
$backgroundImageFile = xtheme_local_background_file($backgroundImage);
if ($backgroundImageFile !== '' && is_file($backgroundImageFile) && is_readable($backgroundImageFile)) {
    $mime = 'image/jpeg';
    if (class_exists('finfo')) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $detectedMime = (string)$finfo->file($backgroundImageFile);
        if (preg_match('#^image/(jpeg|png|gif|webp)$#i', $detectedMime)) {
            $mime = strtolower($detectedMime);
        }
    }

    $binary = @file_get_contents($backgroundImageFile);
    if (is_string($binary) && $binary !== '') {
        $backgroundImageCss = 'data:' . $mime . ';base64,' . base64_encode($binary);
    }
} elseif (preg_match('#^https?://#i', $backgroundImage)) {
    $backgroundImageCss = $backgroundImage;
}

$textColor = xtheme_hex_to_rgba($themeConfig['text_color']);
$secondaryTextColor = xtheme_hex_to_rgba($themeConfig['secondary_text_color']);
$panelColor = xtheme_hex_to_rgba($themeConfig['panel_color']);
$panelBorder = xtheme_hex_to_rgba($themeConfig['panel_border_color']);
$inputColor = xtheme_hex_to_rgba(xtheme_color_shift_alpha($themeConfig['panel_color'], 0.06, 0.08, 0.95));
$placeholderColor = xtheme_hex_to_rgba(xtheme_color_scale_alpha($themeConfig['text_color'], 0.60));
$overlayColor = xtheme_hex_to_rgba('#050b14', $themeConfig['overlay_opacity']);
$accentColor = xtheme_hex_to_rgba($themeConfig['accent_color']);
$accentStrong = xtheme_hex_to_rgba(xtheme_color_scale_alpha($themeConfig['accent_color'], 0.82));
$glassBlur = (int)($themeConfig['glass_blur'] ?? 12);
$backgroundBlur = (int)($themeConfig['background_blur'] ?? 20);
$shadow = '0 18px 50px rgba(0, 0, 0, 0.28)';
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
