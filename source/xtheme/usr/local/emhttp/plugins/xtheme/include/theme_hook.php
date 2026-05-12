<?php
require_once '/usr/local/emhttp/plugins/xtheme/include/theme_helpers.php';

$themeConfig = xtheme_read_config();
$backgroundImage = $themeConfig['background_image'];
$headerColor = xtheme_hex_to_rgba($themeConfig['header_color'], 0.84);
$headerColorSoft = xtheme_hex_to_rgba($themeConfig['header_color'], 0.58);
$menuColor = xtheme_hex_to_rgba($themeConfig['menu_color'], 0.80);
$panelColor = xtheme_hex_to_rgba($themeConfig['panel_color'], $themeConfig['panel_opacity']);
$panelColorStrong = xtheme_hex_to_rgba($themeConfig['panel_color'], min(0.95, (float)$themeConfig['panel_opacity'] + 0.08));
$panelColorSoft = xtheme_hex_to_rgba($themeConfig['panel_color'], max(0.10, (float)$themeConfig['panel_opacity'] - 0.12));
$panelBorder = xtheme_hex_to_rgba($themeConfig['panel_border_color'], $themeConfig['panel_border_opacity']);
$overlayColor = xtheme_hex_to_rgba('#050b14', $themeConfig['overlay_opacity']);
$accentSoft = xtheme_hex_to_rgba($themeConfig['accent_color'], 0.24);
$accentStrong = xtheme_hex_to_rgba($themeConfig['accent_color'], 0.36);
$inputColor = xtheme_hex_to_rgba($themeConfig['panel_color'], min(0.95, (float)$themeConfig['panel_opacity'] + 0.06));
$placeholderColor = xtheme_hex_to_rgba($themeConfig['text_color'], 0.60);
?>
<style id="xtheme-hook">
  .nav-item.XThemeHook {
    display: none !important;
  }

<?php if ($themeConfig['enabled'] === '1'): ?>
  html {
    --xtheme-text: <?= $themeConfig['text_color'] ?>;
    --xtheme-accent: <?= $themeConfig['accent_color'] ?>;
    --xtheme-header: <?= $headerColor ?>;
    --xtheme-header-soft: <?= $headerColorSoft ?>;
    --xtheme-menu: <?= $menuColor ?>;
    --xtheme-panel: <?= $panelColor ?>;
    --xtheme-panel-strong: <?= $panelColorStrong ?>;
    --xtheme-panel-soft: <?= $panelColorSoft ?>;
    --xtheme-panel-border: <?= $panelBorder ?>;
    --xtheme-overlay: <?= $overlayColor ?>;
    --xtheme-input: <?= $inputColor ?>;
    --xtheme-placeholder: <?= $placeholderColor ?>;
    --xtheme-shadow: 0 18px 50px rgba(0, 0, 0, 0.28);
    --xtheme-background-blur: <?= (int)$themeConfig['background_blur'] ?>px;
    --xtheme-glass-blur: <?= (int)$themeConfig['glass_blur'] ?>px;
  }

  body {
    background: transparent !important;
    color: var(--xtheme-text) !important;
    position: relative;
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
<?php if ($backgroundImage !== ''): ?>
    background-image: url('<?= htmlspecialchars($backgroundImage, ENT_QUOTES) ?>');
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
<?php else: ?>
    background:
      radial-gradient(circle at top left, rgba(114, 224, 255, 0.22), transparent 36%),
      radial-gradient(circle at top right, rgba(56, 189, 248, 0.18), transparent 28%),
      linear-gradient(135deg, #07111d 0%, #0c1628 42%, #020617 100%);
<?php endif; ?>
    filter: blur(var(--xtheme-background-blur));
    transform: scale(1.06);
  }

  body::after {
    z-index: -1;
    background: var(--xtheme-overlay);
  }

  #header,
  #menu,
  #footer,
  #title,
  table,
  textarea,
  select,
  input[type=text],
  input[type=password],
  input[type=number],
  input[type=email],
  input[type=url],
  input[type=search],
  button,
  button[type=button],
  input[type=button],
  input[type=submit],
  input[type=reset],
  a.button,
  div.user-list,
  .ca_holder,
  .notice,
  .warning,
  .sweet-alert,
  #sb-wrapper-inner,
  #sb-container,
  .tab,
  .logLine,
  .markdown-body pre {
    backdrop-filter: blur(var(--xtheme-glass-blur)) saturate(1.20);
    -webkit-backdrop-filter: blur(var(--xtheme-glass-blur)) saturate(1.20);
  }

  #header {
    background: linear-gradient(135deg, var(--xtheme-header), var(--xtheme-header-soft)) !important;
    border-bottom: 1px solid var(--xtheme-panel-border);
    box-shadow: var(--xtheme-shadow);
  }

  #menu,
  .nav-tile,
  .nav-tile.right {
    background: var(--xtheme-menu) !important;
  }

  #menu {
    border-bottom: 1px solid var(--xtheme-panel-border);
    box-shadow: var(--xtheme-shadow);
  }

  body,
  #header .logo,
  #header .text-left,
  #header .text-right a,
  #footer,
  label,
  .left,
  .right,
  .system,
  .icon,
  .nav-item.util span {
    color: var(--xtheme-text) !important;
  }

  #menu .nav-item a {
    color: var(--xtheme-text) !important;
  }

  #menu .nav-item.active a,
  #menu .nav-item a:hover,
  button,
  button[type=button],
  input[type=button],
  input[type=submit],
  a.button {
    background: <?= $accentSoft ?> !important;
    color: var(--xtheme-text) !important;
  }

  button:hover,
  button[type=button]:hover,
  input[type=button]:hover,
  input[type=submit]:hover,
  a.button:hover {
    background: <?= $accentStrong ?> !important;
  }

  #title,
  table,
  div.user-list,
  .ca_holder,
  .sweet-alert,
  .tab,
  textarea,
  select,
  input[type=text],
  input[type=password],
  input[type=number],
  input[type=email],
  input[type=url],
  input[type=search] {
    background: var(--xtheme-panel) !important;
    border: 1px solid var(--xtheme-panel-border) !important;
    box-shadow: var(--xtheme-shadow);
    color: var(--xtheme-text) !important;
  }

  table thead tr:first-child td,
  table.tablesorter thead tr th,
  table.disk_status thead tr:first-child td,
  table.share_status thead tr:first-child td,
  table tbody tr.tr_last,
  .nav-tabs > li > a,
  .tabs > span {
    background: var(--xtheme-panel-strong) !important;
    color: var(--xtheme-text) !important;
  }

  table tbody tr:nth-child(even),
  table.tablesorter tbody tr:nth-child(even),
  table.share_status tbody tr:nth-child(even),
  table.disk_status tbody tr:nth-child(even) {
    background: var(--xtheme-panel-soft) !important;
  }

  select,
  textarea,
  input[type=text],
  input[type=password],
  input[type=number],
  input[type=email],
  input[type=url],
  input[type=search] {
    background: var(--xtheme-input) !important;
  }

  input::placeholder,
  textarea::placeholder {
    color: var(--xtheme-placeholder) !important;
  }

  a,
  a.none,
  .blue-text {
    color: var(--xtheme-accent) !important;
  }

  .green-text,
  .passed,
  .green,
  .switch-button-label.on {
    color: #86efac !important;
  }

  .orange-text,
  .warning {
    color: #fdba74 !important;
  }

  .red-text,
  .failed {
    color: #fda4af !important;
  }
<?php endif; ?>
</style>
<script>
function XThemeHook() {
  return false;
}
</script>

