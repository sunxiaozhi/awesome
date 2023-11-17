删除.git文件夹可能会导致git存储库中的问题。如果要删除所有提交历史记录，但将代码保持在当前状态，可以按照以下方式安全地执行此操作：

1、尝试 运行，相当于创建了一个新的分支
```shell
git checkout --orphan latest_branch
```

2、添加所有文件
```shell
git add -A
```

3、提交更改
```shell
git commit -am "commit message"
```

4、删除分支，假设你需要删除的提交记录是在master分支，那么就删除master分支。具体的可以根据git branch，进行查看。现在github上的主分支已经不是master分支，而是main分支，因为自动美国在2020年6月13日爆发“Black Lives Matter”运动以后，为了安抚愈演愈烈的民众情绪，GitHub 就宣布将替换掉 master 等术语，以避免联想奴隶制。GitHub 官方表示，从2020年 10 月 1 日起，在该平台上创建的所有新的源代码仓库将默认被命名为 "main"，而不是原先的"master"。值得注意的是，现有的存储库不会受到此更改影响。master主分支已经改为main分支。
```shell
git branch -D master
```

5、将当前分支重命名
```shell
git branch -m master
```

6、最后，强制更新存储库，可能会存在分支受保护的情况，需要解除分支的强制推送保护，再重新强制推送。
```shell
git push -f origin master
```