# 设置源目录和目标目录
$SourceDir = "E:\workspace" # 替换为你的源目录路径
$DestDir = "E:\workspace\Readme" # 替换为你的目标目录路径

# 确保目标目录存在
if (-Not (Test-Path -Path $DestDir)) {
    New-Item -ItemType Directory -Path $DestDir
}

# 获取源目录下的所有一级子目录
$subDirs = Get-ChildItem -Path $SourceDir -Directory

# 遍历一级子目录下的所有README.md文件
foreach ($dir in $subDirs) {
    $readmePath = Join-Path -Path $dir.FullName -ChildPath "README.md"
    if (Test-Path -Path $readmePath) {
        # 获取当前README.md文件所在的文件夹名称
        $folderName = $dir.BaseName
        # 构建目标文件路径
        $destFilePath = Join-Path -Path $DestDir -ChildPath "$folderName.md"
        # 复制并重命名文件到目标目录
        Copy-Item -Path $readmePath -Destination $destFilePath
    }
}