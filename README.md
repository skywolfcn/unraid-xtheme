# XTheme for Unraid

`xtheme` is a lightweight glass-style theme plugin for Unraid 7.2.x.

It is designed to replace older Theme Engine based workflows with a smaller settings page that focuses on:

- background image upload or URL
- text, accent, header, menu, and panel colors
- RGBA color pickers with transparency
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
.\build.ps1 -PluginRepo skywolfcn/unraid-xtheme
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

Install URL:

```text
https://github.com/skywolfcn/unraid-xtheme/releases/latest/download/xtheme.plg
```

Release workflow:

1. Build the public package:

```powershell
.\build.ps1 -Version 2026.05.12.106 -PluginRepo skywolfcn/unraid-xtheme
```

2. Commit and push:
   - `archive/xtheme-<version>-x86_64-1.txz.b64`
   - `xtheme.plg`
3. Users install from the release URL above.
4. For later updates, bump the version, rebuild, and push the new `xtheme.plg` plus matching `archive/*.txz.b64`.

## Updates in Unraid

Yes. If users install `XTheme` from the GitHub release `.plg` URL, Unraid can detect later plugin updates.

For updates to appear correctly:

- keep the install URL the same: `https://github.com/skywolfcn/unraid-xtheme/releases/latest/download/xtheme.plg`
- increase the plugin version every time
- push the updated `xtheme.plg`
- push the matching package file in `archive/`

## Recommended public repo

For this project, the default public repo name is:

```text
skywolfcn/unraid-xtheme
```
