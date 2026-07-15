param(
    [string]$Version = (Get-Date -Format 'yyyy.MM.dd'),
    [string]$PluginRepo,
    [string]$Branch = 'main'
)

$ErrorActionPreference = 'Stop'

$pluginName = 'xtheme'
$authorName = 'skywolf'
$repoRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
$sourceRoot = Join-Path $repoRoot "source\$pluginName"
$archiveDir = Join-Path $repoRoot 'archive'
$distLocalDir = Join-Path $repoRoot 'dist\local'
$distReleaseDir = Join-Path $repoRoot 'dist\release'
$packageName = "$pluginName-$Version-x86_64-1.txz"
$packagePath = Join-Path $archiveDir $packageName
$releasePackageTextName = "$packageName.b64"
$releasePackageTextPath = Join-Path $archiveDir $releasePackageTextName
$rootPluginPath = Join-Path $repoRoot "$pluginName.plg"

function Ensure-Dir {
    param([string]$Path)
    if (-not (Test-Path $Path)) {
        New-Item -ItemType Directory -Path $Path | Out-Null
    }
}

function Normalize-PageFiles {
    param([string]$Root)

    $utf8NoBom = [System.Text.UTF8Encoding]::new($false)
    Get-ChildItem -Path $Root -Recurse -Filter '*.page' -File | ForEach-Object {
        $raw = [System.IO.File]::ReadAllText($_.FullName)
        $normalized = $raw.Replace("`r`n", "`n").Replace("`r", "`n")
        if ($normalized -ne $raw) {
            [System.IO.File]::WriteAllText($_.FullName, $normalized, $utf8NoBom)
        }
    }
}

function Write-PluginFile {
    param(
        [string]$Destination,
        [string]$PluginUrl,
        [string]$SupportUrl,
        [string]$SourceTag,
        [string]$SourceValue,
        [string]$PackageTargetName,
        [string]$VersionValue,
        [string]$Md5Value,
        [string]$DownloadMd5Value,
        [switch]$DecodeBase64Package
    )

    $supportAttr = ''
    if ($SupportUrl) {
        $supportAttr = " support=""$SupportUrl"""
    }

    $packageFileBlock = @'
<FILE Name="/boot/config/plugins/__PLUGIN_NAME__/packages/__PACKAGE_TARGET_NAME__" Run="upgradepkg --reinstall --install-new">
<__SOURCE_TAG__>__SOURCE_VALUE__</__SOURCE_TAG__>
<MD5>&md5;</MD5>
</FILE>
'@

    if ($DecodeBase64Package) {
        $packageFileBlock = @'
<FILE Run="/bin/bash">
<INLINE><![CDATA[
set -e
pkg_dir="/boot/config/plugins/__PLUGIN_NAME__/packages"
pkg="$pkg_dir/__PLUGIN_NAME__-__VERSION__-x86_64-1.txz"
pkg_b64="$pkg_dir/__PACKAGE_TARGET_NAME__"
pkg_md5="__MD5__"
pkg_b64_md5="__DOWNLOAD_MD5__"
pkg_url="__SOURCE_VALUE__"
mkdir -p "$pkg_dir"
if [ ! -s "$pkg" ] || [ "$(md5sum "$pkg" 2>/dev/null | awk '{print $1}')" != "$pkg_md5" ]; then
  rm -f "$pkg" "$pkg_b64"
  wget -q -O "$pkg_b64" "$pkg_url"
  if [ "$(md5sum "$pkg_b64" | awk '{print $1}')" != "$pkg_b64_md5" ]; then
    echo "XTheme package download checksum mismatch"
    rm -f "$pkg_b64"
    exit 1
  fi
  base64 -d "$pkg_b64" > "$pkg"
  rm -f "$pkg_b64"
fi
if [ "$(md5sum "$pkg" | awk '{print $1}')" != "$pkg_md5" ]; then
  echo "XTheme cached package checksum mismatch"
  rm -f "$pkg"
  exit 1
fi
upgradepkg --reinstall --install-new "$pkg"
]]></INLINE>
</FILE>
'@
    }

    $xml = @'
<?xml version="1.0" standalone="yes"?>
<!DOCTYPE PLUGIN [
<!ENTITY name "__PLUGIN_NAME__">
<!ENTITY author "__AUTHOR_NAME__">
<!ENTITY version "__VERSION__">
<!ENTITY md5 "__MD5__">
<!ENTITY pluginURL "__PLUGIN_URL__">
]>
<PLUGIN name="&name;" author="&author;" version="&version;" pluginURL="&pluginURL;" icon="paint-brush" min="7.2.0" launch="Settings/XTheme"__SUPPORT_ATTR__>
<CHANGES>
###__VERSION__
- Initial release of a simplified glass theme plugin for Unraid 7.2.x
</CHANGES>
<FILE Run="/bin/bash">
<INLINE>
mkdir -p /boot/config/plugins/__PLUGIN_NAME__/packages
find /boot/config/plugins/__PLUGIN_NAME__/packages -maxdepth 1 -type f -name '__PLUGIN_NAME__-*.txz*' ! -name '__PLUGIN_NAME__-__VERSION__-x86_64-1.txz' ! -name '__PLUGIN_NAME__-__VERSION__-x86_64-1.txz.b64' -delete 2&gt;/dev/null || true
</INLINE>
</FILE>
__PACKAGE_FILE_BLOCK__
<FILE Run="/bin/bash">
<INLINE><![CDATA[
plugin_url="__PLUGIN_URL__"
case "$plugin_url" in
  file://*)
    cp -f "${plugin_url#file://}" /boot/config/plugins/xtheme.plg 2>/dev/null || true
    ;;
  http://*|https://*)
    wget -q -O /boot/config/plugins/xtheme.plg "$plugin_url" 2>/dev/null || true
    ;;
esac
rm -f /boot/config/plugins-error/xtheme.plg
mkdir -p /boot/config/plugins/xtheme/backgrounds
if [ ! -f /boot/config/plugins/xtheme/xtheme.cfg ]; then
  cp -f /usr/local/emhttp/plugins/xtheme/default.cfg /boot/config/plugins/xtheme/xtheme.cfg
fi
rm -rf /usr/local/emhttp/plugins/xtheme/backgrounds
ln -snf /boot/config/plugins/xtheme/backgrounds /usr/local/emhttp/plugins/xtheme/backgrounds
php /usr/local/emhttp/plugins/xtheme/scripts/login_hook_patch.php install >/dev/null 2>&1 || true
php /usr/local/emhttp/plugins/xtheme/scripts/refresh_login_theme.php >/dev/null 2>&1 || true
]]></INLINE>
</FILE>
<FILE Run="/bin/bash" Method="remove">
<INLINE><![CDATA[
php /usr/local/emhttp/plugins/xtheme/scripts/login_hook_patch.php remove >/dev/null 2>&1 || true
removepkg __PLUGIN_NAME__-__VERSION__-x86_64-1 2>/dev/null
rm -f /boot/config/plugins/__PLUGIN_NAME__.plg
rm -rf /usr/local/emhttp/plugins/xtheme
rm -rf /boot/config/plugins/xtheme
]]></INLINE>
</FILE>
</PLUGIN>
'@

    $packageFileBlock = $packageFileBlock.Replace('__PACKAGE_TARGET_NAME__', $PackageTargetName)
    $packageFileBlock = $packageFileBlock.Replace('__PLUGIN_NAME__', $pluginName)
    $packageFileBlock = $packageFileBlock.Replace('__VERSION__', $VersionValue)
    $packageFileBlock = $packageFileBlock.Replace('__MD5__', $Md5Value)
    $packageFileBlock = $packageFileBlock.Replace('__SOURCE_TAG__', $SourceTag)
    $packageFileBlock = $packageFileBlock.Replace('__SOURCE_VALUE__', $SourceValue)
    $packageFileBlock = $packageFileBlock.Replace('__DOWNLOAD_MD5__', $DownloadMd5Value)

    $xml = $xml.Replace('__PLUGIN_NAME__', $pluginName)
    $xml = $xml.Replace('__AUTHOR_NAME__', $authorName)
    $xml = $xml.Replace('__VERSION__', $VersionValue)
    $xml = $xml.Replace('__MD5__', $Md5Value)
    $xml = $xml.Replace('__PLUGIN_URL__', $PluginUrl)
    $xml = $xml.Replace('__SOURCE_TAG__', $SourceTag)
    $xml = $xml.Replace('__SOURCE_VALUE__', $SourceValue)
    $xml = $xml.Replace('__SUPPORT_ATTR__', $supportAttr)
    $xml = $xml.Replace('__PACKAGE_TARGET_NAME__', $PackageTargetName)
    $xml = $xml.Replace('__PACKAGE_FILE_BLOCK__', $packageFileBlock)

    $utf8NoBom = [System.Text.UTF8Encoding]::new($false)
    [System.IO.File]::WriteAllText($Destination, $xml, $utf8NoBom)
}

Ensure-Dir $archiveDir
Ensure-Dir $distLocalDir
Ensure-Dir $distReleaseDir

if (-not (Test-Path $sourceRoot)) {
    throw "Source path not found: $sourceRoot"
}

if (Test-Path $packagePath) {
    Remove-Item $packagePath -Force
}

if (Test-Path $releasePackageTextPath) {
    Remove-Item $releasePackageTextPath -Force
}

$stageRoot = Join-Path ([System.IO.Path]::GetTempPath()) ("xtheme-build-" + [System.Guid]::NewGuid().ToString('N'))
Copy-Item -Path $sourceRoot -Destination $stageRoot -Recurse
Normalize-PageFiles -Root $stageRoot

Push-Location $stageRoot
try {
    tar -cJf $packagePath .
} finally {
    Pop-Location
    if (Test-Path $stageRoot) {
        Remove-Item -LiteralPath $stageRoot -Recurse -Force
    }
}

$md5 = (Get-FileHash -Algorithm MD5 -Path $packagePath).Hash.ToLower()

$localPluginPath = Join-Path $distLocalDir "$pluginName.plg"
Write-PluginFile `
    -Destination $localPluginPath `
    -PluginUrl "file:///boot/config/plugins/$pluginName/$pluginName.plg" `
    -SupportUrl '' `
    -SourceTag 'LOCAL' `
    -SourceValue "/boot/config/plugins/$pluginName/packages/$packageName" `
    -PackageTargetName $packageName `
    -VersionValue $Version `
    -Md5Value $md5

if ($PluginRepo) {
    $releasePackageText = [Convert]::ToBase64String([IO.File]::ReadAllBytes($packagePath))
    [IO.File]::WriteAllText($releasePackageTextPath, $releasePackageText, [Text.Encoding]::ASCII)
    $releaseMd5 = (Get-FileHash -Algorithm MD5 -Path $releasePackageTextPath).Hash.ToLower()
    $releasePluginPath = Join-Path $distReleaseDir "$pluginName.plg"
    $baseRawUrl = "https://raw.githubusercontent.com/$PluginRepo/$Branch"
    $packageUrl = "$baseRawUrl/archive/$releasePackageTextName"
    Write-PluginFile `
        -Destination $releasePluginPath `
        -PluginUrl "$baseRawUrl/$pluginName.plg" `
        -SupportUrl "https://github.com/$PluginRepo" `
        -SourceTag 'URL' `
        -SourceValue $packageUrl `
        -PackageTargetName $releasePackageTextName `
        -VersionValue $Version `
        -Md5Value $md5 `
        -DownloadMd5Value $releaseMd5 `
        -DecodeBase64Package
    Copy-Item $releasePluginPath $rootPluginPath -Force
}

Write-Host "Built package: $packagePath"
Write-Host "MD5: $md5"
Write-Host "Local plugin file: $localPluginPath"
if ($PluginRepo) {
    Write-Host "Release plugin file: $rootPluginPath"
}
