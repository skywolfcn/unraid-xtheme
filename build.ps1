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
        [string]$VersionValue,
        [string]$Md5Value
    )

    $supportAttr = ''
    if ($SupportUrl) {
        $supportAttr = " support=""$SupportUrl"""
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
mkdir -p /boot/config/plugins/&name;/packages
rm -f $(ls /boot/config/plugins/&name;/&name;*.txz 2&gt;/dev/null | grep -v '&version;')
</INLINE>
</FILE>
<FILE Name="/boot/config/plugins/&name;/packages/&name;-&version;-x86_64-1.txz" Run="upgradepkg --reinstall --install-new">
<__SOURCE_TAG__>__SOURCE_VALUE__</__SOURCE_TAG__>
<MD5>&md5;</MD5>
</FILE>
<FILE Run="/bin/bash">
<INLINE><![CDATA[
mkdir -p /boot/config/plugins/xtheme/backgrounds
if [ ! -f /boot/config/plugins/xtheme/xtheme.cfg ]; then
  cp -f /usr/local/emhttp/plugins/xtheme/default.cfg /boot/config/plugins/xtheme/xtheme.cfg
fi
rm -rf /usr/local/emhttp/plugins/xtheme/backgrounds
ln -snf /boot/config/plugins/xtheme/backgrounds /usr/local/emhttp/plugins/xtheme/backgrounds
]]></INLINE>
</FILE>
<FILE Run="/bin/bash" Method="remove">
<INLINE><![CDATA[
removepkg __PLUGIN_NAME__-&version;-x86_64-1 2>/dev/null
rm -rf /usr/local/emhttp/plugins/xtheme
rm -rf /boot/config/plugins/xtheme
]]></INLINE>
</FILE>
</PLUGIN>
'@

    $xml = $xml.Replace('__PLUGIN_NAME__', $pluginName)
    $xml = $xml.Replace('__AUTHOR_NAME__', $authorName)
    $xml = $xml.Replace('__VERSION__', $VersionValue)
    $xml = $xml.Replace('__MD5__', $Md5Value)
    $xml = $xml.Replace('__PLUGIN_URL__', $PluginUrl)
    $xml = $xml.Replace('__SOURCE_TAG__', $SourceTag)
    $xml = $xml.Replace('__SOURCE_VALUE__', $SourceValue)
    $xml = $xml.Replace('__SUPPORT_ATTR__', $supportAttr)

    Set-Content -Path $Destination -Value $xml -Encoding utf8
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
    -VersionValue $Version `
    -Md5Value $md5

if ($PluginRepo) {
    $releasePluginPath = Join-Path $distReleaseDir "$pluginName.plg"
    $baseRawUrl = "https://raw.githubusercontent.com/$PluginRepo/$Branch"
    Write-PluginFile `
        -Destination $releasePluginPath `
        -PluginUrl "$baseRawUrl/$pluginName.plg" `
        -SupportUrl "https://github.com/$PluginRepo" `
        -SourceTag 'URL' `
        -SourceValue "$baseRawUrl/archive/$packageName" `
        -VersionValue $Version `
        -Md5Value $md5
    Copy-Item $releasePluginPath $rootPluginPath -Force
}

Write-Host "Built package: $packagePath"
Write-Host "MD5: $md5"
Write-Host "Local plugin file: $localPluginPath"
if ($PluginRepo) {
    Write-Host "Release plugin file: $rootPluginPath"
}
