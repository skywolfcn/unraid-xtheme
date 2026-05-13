<?php

$mode = strtolower(trim((string)($argv[1] ?? 'install')));
$targets = [
    '/usr/local/emhttp/webGui/include/.login.php',
    '/usr/local/emhttp/webGui/include/.set-password.php',
];

$marker = "<?php /* XTheme login hook start */ @include '/usr/local/emhttp/plugins/xtheme/include/login_theme_hook.php'; /* XTheme login hook end */ ?>";

foreach ($targets as $target) {
    if (!is_file($target) || !is_readable($target) || !is_writable($target)) {
        continue;
    }

    $content = @file_get_contents($target);
    if (!is_string($content) || $content === '') {
        continue;
    }

    if ($mode === 'remove') {
        $updated = preg_replace(
            '#\s*<\?php /\* XTheme login hook start \*/ @include \'/usr/local/emhttp/plugins/xtheme/include/login_theme_hook\.php\'; /\* XTheme login hook end \*/ \?>\s*#',
            "\n",
            $content,
            1
        );
        if (is_string($updated) && $updated !== $content) {
            @file_put_contents($target, $updated, LOCK_EX);
        }
        continue;
    }

    if (strpos($content, 'XTheme login hook start') !== false) {
        continue;
    }

    $updated = str_replace('</head>', "  {$marker}\n</head>", $content, $count);
    if ($count > 0 && $updated !== $content) {
        @file_put_contents($target, $updated, LOCK_EX);
    }
}
