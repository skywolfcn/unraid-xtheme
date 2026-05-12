# XTheme for Unraid

`xtheme` is a lightweight glass-style theme plugin for Unraid 7.2.x.

It is designed to replace older Theme Engine based workflows with a smaller settings page that focuses on:

- background image upload or URL
- text, accent, header, menu, and panel colors
- background blur
- glass blur
- overlay strength

The settings page appears in `Settings > User Preferences > XTheme`.

Author: `skywolf`

## Repo layout

- `source/xtheme/`
  The plugin payload that becomes the `.txz` package.
- `archive/`
  Generated package artifacts.
- `dist/local/`
  Generated local-install `.plg` for direct testing on a live Unraid server.
- `dist/release/`
  Generated GitHub-ready `.plg` for sharing with other users.

## Build

From PowerShell:

```powershell
.\build.ps1
```

That creates:

- `archive/xtheme-<version>-x86_64-1.txz`
- `dist/local/xtheme.plg`

To generate a public installable plugin file for GitHub hosting:

```powershell
.\build.ps1 -PluginRepo yourname/unraid-xtheme
```

That also creates:

- `dist/release/xtheme.plg`
- `xtheme.plg`

## Local install on a specific Unraid server

1. Build the plugin.
2. Copy `archive/xtheme-<version>-x86_64-1.txz` to `/boot/config/plugins/xtheme/packages/`.
3. Copy `dist/local/xtheme.plg` to `/boot/config/plugins/xtheme/xtheme.plg`.
4. Run:

```bash
plugin install /boot/config/plugins/xtheme/xtheme.plg
```

## Share with other Unraid users

1. Push this repo to GitHub.
2. Run:

```powershell
.\build.ps1 -PluginRepo yourname/unraid-xtheme
```

3. Commit and push:
   - `archive/*.txz`
   - `xtheme.plg`
4. Share the raw plugin URL:

```text
https://raw.githubusercontent.com/yourname/unraid-xtheme/main/xtheme.plg
```

## Recommended public repo

For this project, the default public repo name is:

```text
skywolfcn/unraid-xtheme
```
