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
<FILE Name="/boot/config/plugins/__PLUGIN_NAME__/packages/__PACKAGE_TARGET_NAME__">
<__SOURCE_TAG__>__SOURCE_VALUE__</__SOURCE_TAG__>
<MD5>&md5;</MD5>
</FILE>
<FILE Run="/bin/bash">
<INLINE><![CDATA[
base64 -d /boot/config/plugins/__PLUGIN_NAME__/packages/__PACKAGE_TARGET_NAME__ > /boot/config/plugins/__PLUGIN_NAME__/packages/__PLUGIN_NAME__-__VERSION__-x86_64-1.txz
upgradepkg --reinstall --install-new /boot/config/plugins/__PLUGIN_NAME__/packages/__PLUGIN_NAME__-__VERSION__-x86_64-1.txz
rm -f /boot/config/plugins/__PLUGIN_NAME__/packages/__PACKAGE_TARGET_NAME__
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
rm -f $(ls /boot/config/plugins/__PLUGIN_NAME__/__PLUGIN_NAME__*.txz 2&gt;/dev/null | grep -v '__VERSION__')
</INLINE>
</FILE>
__PACKAGE_FILE_BLOCK__
<FILE Run="/bin/bash">
<INLINE><![CDATA[
mkdir -p /boot/config/plugins/xtheme/backgrounds
if [ ! -f /boot/config/plugins/xtheme/xtheme.cfg ]; then
  cp -f /usr/local/emhttp/plugins/xtheme/default.cfg /boot/config/plugins/xtheme/xtheme.cfg
fi
rm -rf /usr/local/emhttp/plugins/xtheme/backgrounds
ln -snf /boot/config/plugins/xtheme/backgrounds /usr/local/emhttp/plugins/xtheme/backgrounds
php /usr/local/emhttp/plugins/xtheme/scripts/login_hook_patch.php install >/dev/null 2>&1 || true
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
    $packageFileBlock = $packageFileBlock.Replace('__SOURCE_TAG__', $SourceTag)
    $packageFileBlock = $packageFileBlock.Replace('__SOURCE_VALUE__', $SourceValue)

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

Push-Location $sourceRoot
try {
    tar -cJf $packagePath .
} finally {
    Pop-Location
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
        -Md5Value $releaseMd5 `
        -DecodeBase64Package
    Copy-Item $releasePluginPath $rootPluginPath -Force
}

Write-Host "Built package: $packagePath"
Write-Host "MD5: $md5"
Write-Host "Local plugin file: $localPluginPath"
if ($PluginRepo) {
    Write-Host "Release plugin file: $rootPluginPath"
}
