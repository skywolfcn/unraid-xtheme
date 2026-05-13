<?php
require_once '/usr/local/emhttp/plugins/xtheme/include/theme_helpers.php';

$themeConfig = xtheme_live_config();
$backgroundImage = $themeConfig['background_image'];
$textColor = xtheme_hex_to_rgba($themeConfig['text_color']);
$accentColor = xtheme_hex_to_rgba($themeConfig['accent_color']);
$linkColor = xtheme_hex_to_rgba($themeConfig['link_color']);
$highlightColor = xtheme_hex_to_rgba($themeConfig['highlight_value_color']);
$headerColor = xtheme_hex_to_rgba($themeConfig['header_color']);
$headerColorSoft = xtheme_hex_to_rgba(xtheme_color_scale_alpha($themeConfig['header_color'], 0.69));
$menuColor = xtheme_hex_to_rgba($themeConfig['menu_color']);
$titleColor = xtheme_hex_to_rgba($themeConfig['title_color']);
$titleTextColor = xtheme_hex_to_rgba($themeConfig['title_text_color']);
$secondaryTextColor = xtheme_hex_to_rgba($themeConfig['secondary_text_color']);
$panelColor = xtheme_hex_to_rgba($themeConfig['panel_color']);
$panelColorStrong = xtheme_hex_to_rgba(xtheme_color_shift_alpha($themeConfig['panel_color'], 0.08, 0.08, 1.0));
$panelColorSoft = xtheme_hex_to_rgba(xtheme_color_shift_alpha($themeConfig['panel_color'], -0.12, 0.10, 1.0));
$progressFillColor = xtheme_hex_to_rgba($themeConfig['progress_fill_color']);
$progressTrackColor = xtheme_hex_to_rgba($themeConfig['progress_track_color']);
$panelBorder = xtheme_hex_to_rgba($themeConfig['panel_border_color']);
$overlayColor = xtheme_hex_to_rgba('#050b14', $themeConfig['overlay_opacity']);
$accentSoft = xtheme_hex_to_rgba(xtheme_color_scale_alpha($themeConfig['accent_color'], 0.24));
$accentStrong = xtheme_hex_to_rgba(xtheme_color_scale_alpha($themeConfig['accent_color'], 0.36));
$inputColor = xtheme_hex_to_rgba(xtheme_color_shift_alpha($themeConfig['panel_color'], 0.06, 0.08, 0.95));
$placeholderColor = xtheme_hex_to_rgba(xtheme_color_scale_alpha($themeConfig['text_color'], 0.60));
?>
<style id="xtheme-hook">
  .nav-item.XThemeHook {
    display: none !important;
  }

<?php if ($themeConfig['enabled'] === '1'): ?>
  html {
    --xtheme-text: <?= $textColor ?>;
    --xtheme-accent: <?= $accentColor ?>;
    --xtheme-link: <?= $linkColor ?>;
    --xtheme-highlight: <?= $highlightColor ?>;
    --xtheme-header: <?= $headerColor ?>;
    --xtheme-header-soft: <?= $headerColorSoft ?>;
    --xtheme-menu: <?= $menuColor ?>;
    --xtheme-title: <?= $titleColor ?>;
    --xtheme-title-text: <?= $titleTextColor ?>;
    --xtheme-text-secondary: <?= $secondaryTextColor ?>;
    --xtheme-panel: <?= $panelColor ?>;
    --xtheme-panel-strong: <?= $panelColorStrong ?>;
    --xtheme-panel-soft: <?= $panelColorSoft ?>;
    --xtheme-progress-fill: <?= $progressFillColor ?>;
    --xtheme-progress-track: <?= $progressTrackColor ?>;
    --xtheme-panel-border: <?= $panelBorder ?>;
    --xtheme-overlay: <?= $overlayColor ?>;
    --xtheme-input: <?= $inputColor ?>;
    --xtheme-placeholder: <?= $placeholderColor ?>;
    --xtheme-shadow: 0 18px 50px rgba(0, 0, 0, 0.28);
    --xtheme-background-blur: <?= (int)$themeConfig['background_blur'] ?>px;
    --xtheme-glass-blur: <?= (int)$themeConfig['glass_blur'] ?>px;
    --sidebar-background: var(--xtheme-panel) !important;
    --sidebar-text: var(--xtheme-text) !important;
    --ca-legacy-background-color: var(--xtheme-panel) !important;
    --template-background: var(--xtheme-panel) !important;
    --template-hover-background: var(--xtheme-panel-strong) !important;
    --border-color: var(--xtheme-panel-border) !important;
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
  div.title,
  table:not(.dashboard),
  table.dashboard tbody,
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
  .markdown-body pre,
  table.dashboard span.outer.solid {
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
  #title,
  div.title,
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

  #header .text-right,
  #header .text-right a,
  #header .text-right span,
  #header .text-right i {
    color: var(--xtheme-text-secondary) !important;
  }

  #title,
  div.title {
    background: var(--xtheme-title) !important;
    border: 1px solid var(--xtheme-panel-border) !important;
    box-shadow: var(--xtheme-shadow);
    color: var(--xtheme-title-text) !important;
  }

  div.title,
  div.title span,
  div.title a,
  div.title i,
  div.title .left,
  div.title .right {
    color: var(--xtheme-title-text) !important;
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

  .xtheme-save-button,
  input[type=button].xtheme-save-button,
  input[type=submit].xtheme-save-button,
  .xtheme-save-button:hover,
  .xtheme-save-button:focus,
  input[type=button].xtheme-save-button:hover,
  input[type=button].xtheme-save-button:focus,
  input[type=submit].xtheme-save-button:hover,
  input[type=submit].xtheme-save-button:focus {
    background: linear-gradient(135deg, #ff8a1f, #ff5a1f) !important;
    color: #fff7ed !important;
    border: none !important;
    box-shadow: 0 12px 28px rgba(255, 106, 31, 0.28) !important;
  }

  .xtheme-save-button:hover,
  .xtheme-save-button:focus,
  input[type=button].xtheme-save-button:hover,
  input[type=button].xtheme-save-button:focus,
  input[type=submit].xtheme-save-button:hover,
  input[type=submit].xtheme-save-button:focus {
    background: linear-gradient(135deg, #ff9a3d, #ff6b2f) !important;
  }

  table:not(.dashboard),
  table.dashboard tbody,
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

  table.dashboard,
  table.dashboard td.stopgap {
    background: transparent !important;
    border: none !important;
    box-shadow: none !important;
  }

  table.dashboard tbody {
    background: var(--xtheme-panel) !important;
    border: 1px solid var(--xtheme-panel-border) !important;
    box-shadow: var(--xtheme-shadow);
  }

  table.dashboard tbody tr:not(:first-child) > td {
    background: transparent !important;
  }

  table thead tr:first-child td,
  table:not(.dashboard).tablesorter thead tr th,
  table:not(.dashboard).disk_status thead tr:first-child td,
  table:not(.dashboard).share_status thead tr:first-child td,
  table:not(.dashboard) tbody tr.tr_last,
  table.dashboard tbody tr:first-child > td,
  .nav-tabs > li > a,
  .tabs > span {
    background: var(--xtheme-panel-strong) !important;
    color: var(--xtheme-text) !important;
  }

  table:not(.dashboard) tbody tr:nth-child(even),
  table:not(.dashboard).tablesorter tbody tr:nth-child(even),
  table:not(.dashboard).share_status tbody tr:nth-child(even),
  table:not(.dashboard).disk_status tbody tr:nth-child(even),
  table.dashboard tbody tr:not(:first-child):nth-child(even) > td {
    background: var(--xtheme-panel-soft) !important;
  }

  table.dashboard span.outer.solid {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin: 0 12px 12px 0 !important;
    padding: 8px 12px;
    border-radius: 12px;
    border: 1px solid var(--xtheme-panel-border) !important;
    background: linear-gradient(135deg, var(--xtheme-panel-strong), var(--xtheme-panel-soft)) !important;
    box-shadow: 0 10px 24px rgba(0, 0, 0, 0.16);
    color: var(--xtheme-text) !important;
  }

  table.dashboard span.outer.solid > span.hand {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 34px;
    min-height: 34px;
  }

  table.dashboard span.outer.solid > span.inner {
    color: var(--xtheme-text) !important;
  }

  .usage-bar,
  .usage-disk {
    background: var(--xtheme-progress-track) !important;
  }

  .usage-bar > span,
  .usage-disk > span:first-child,
  .usage-disk.sys > span:first-child,
  .usage-disk.mm > span:first-child {
    background: var(--xtheme-progress-fill) !important;
  }

  .sidenav,
  .searchArea,
  .searchAreaHolder,
  .mobileMenu,
  .menuItems,
  .mobileOverlay,
  .sidebar,
  #alternateView,
  #alternateView table,
  #sidenavContent,
  .popupCloseArea,
  .popupCloseArea > div {
    background: var(--xtheme-panel) !important;
    background-color: var(--xtheme-panel) !important;
    background-image: none !important;
    color: var(--xtheme-text) !important;
    border-color: var(--xtheme-panel-border) !important;
  }

  .menuItems *,
  .searchArea *,
  .sidenav *,
  #alternateView *,
  #sidenavContent * {
    border-color: var(--xtheme-panel-border) !important;
  }

  .menuItems,
  .searchArea,
  .searchAreaHolder,
  .sidenav,
  #alternateView,
  #alternateView table,
  #sidenavContent {
    box-shadow: var(--xtheme-shadow);
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
    color: var(--xtheme-link) !important;
  }

  table.dashboard td span.load,
  .green-text,
  .passed,
  .green,
  .switch-button-label.on {
    color: var(--xtheme-highlight) !important;
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
function XThemeApplyStyleToNodes(selector, styles) {
  if (!document || typeof document.querySelectorAll !== 'function') {
    return;
  }

  document.querySelectorAll(selector).forEach(function(node) {
    Object.keys(styles).forEach(function(property) {
      node.style.setProperty(property, styles[property], 'important');
    });
  });
}

function XThemeApplyCommunityApplicationsTheme() {
<?php if ($themeConfig['enabled'] === '1'): ?>
  if (document && document.documentElement && document.documentElement.style) {
    document.documentElement.style.setProperty('--sidebar-background', '<?= addslashes($panelColor) ?>');
    document.documentElement.style.setProperty('--sidebar-text', '<?= addslashes($textColor) ?>');
    document.documentElement.style.setProperty('--ca-legacy-background-color', '<?= addslashes($panelColor) ?>');
    document.documentElement.style.setProperty('--template-background', '<?= addslashes($panelColor) ?>');
    document.documentElement.style.setProperty('--template-hover-background', '<?= addslashes($panelColorStrong) ?>');
    document.documentElement.style.setProperty('--border-color', '<?= addslashes($panelBorder) ?>');
  }

  XThemeApplyStyleToNodes('.menuItems,.searchArea,.searchAreaHolder,.mobileMenu,.mobileOverlay,.sidenav,#alternateView,#alternateView table,#sidenavContent,.popupCloseArea,.popupCloseArea > div', {
    'background': '<?= addslashes($panelColor) ?>',
    'background-color': '<?= addslashes($panelColor) ?>',
    'background-image': 'none',
    'color': '<?= addslashes($textColor) ?>',
    'border-color': '<?= addslashes($panelBorder) ?>'
  });

  XThemeApplyStyleToNodes('.menuItems a,.menuItems div,.menuItems span,.menuItems li,.searchArea a,.searchArea div,.searchArea span,.sidenav a,.sidenav div,.sidenav span,#alternateView a,#alternateView div,#alternateView span,#sidenavContent a,#sidenavContent div,#sidenavContent span', {
    'color': '<?= addslashes($textColor) ?>',
    'border-color': '<?= addslashes($panelBorder) ?>'
  });

  XThemeApplyStyleToNodes('.selectedMenu,.menuItems .selectedMenu,.menuItems .selectedMenu a', {
    'color': '<?= addslashes($accentColor) ?>'
  });
<?php endif; ?>
}

function XThemeHook() {
  XThemeApplyCommunityApplicationsTheme();

<?php if ($themeConfig['enabled'] === '1'): ?>
  if (!window.__xthemeCAObserver && typeof MutationObserver !== 'undefined' && document && document.body) {
    window.__xthemeCAObserver = new MutationObserver(function() {
      XThemeApplyCommunityApplicationsTheme();
    });
    window.__xthemeCAObserver.observe(document.body, { childList: true, subtree: true });
  }
<?php endif; ?>

  return false;
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', XThemeHook);
} else {
  XThemeHook();
}
</script>
