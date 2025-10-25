# Gitメモ

### 掃除
```bash
# gitに関係ないファイルとディレクトリを消す
git clean -fd

# gitignoreされているファイルとディレクトリも消す（node_modules等）
git clean -fdx
```

### ブランチを作成して切り替え
```bash
# ブランチを作成して切り替え
git switch -c new-feature
```
### 複数ブランチの削除
```bash
# 複数ブランチの削除
git branch -D sitemap nnnnnn backup
```

### ブランチ名の変更
```bash
# 1. ローカルで名前変更
git branch -m 古い名前 新しい名前

# 2. 新しい名前でプッシュ
git push origin 新しい名前

# 3. 古い名前を削除
git push origin --delete 古い名前
```

### Remote変更
```bash
# リモートリポジトリを追加
git remote add origin git@github.com:k-kanoh/playbooks.git

# リモートリポジトリの確認
git remote -v

# 初回プッシュ
git push -u origin main
```

### タグ操作
```bash
# タグを作成
git tag v1.0

# ローカルのタグを削除
git tag -d v1.0

# タグをリモートにプッシュ
git push origin v1.0

# リモートのタグを削除
git push --delete origin v1.0
```

### ログの確認
```bash
# すべてのブランチ（リモート含む）
git log --oneline --graph --all

# ローカルブランチのみ
git log --oneline --graph --branches
```

※ `--graph`なしだとブランチの分岐・合流が分からないため、Claudeに喰わせる場合は必須

### 履歴をリセットして現在の状態を新しいInitial commitにする
```bash
# 現在の内容を保持したまま履歴を持たない新しいブランチを作成
git checkout --orphan new_main

# 新しい Initial commit を作成（すべてのファイルは既にステージング済み）
git commit -m "Initial commit"

# 古い main ブランチを削除
git branch -D main

# new_main を main にリネーム
git branch -m main

# リモートに強制プッシュ
git push -f origin main
```

### developブランチをmainブランチにする
```bash
# developブランチの内容でmainブランチを上書き
git switch develop
git branch -f main develop
git switch main
```

※ `.git/refs/heads/main`を develop の HEAD と同じコミットIDにするのと同じ

## Git履歴の線形化

### 基本的な手順
![tree](/images/3b38ed1af9120abea095cfecce1c02e2.png)
```bash
# mainブランチをスタート地点に戻す
git reset --hard 79cc18d

# 79cc18dの後に1コミット（002a491）追加
git cherry-pick 002a491

# 79cc18dの後に6コミット（古a31111c7～新1c5f5dd）追加
git cherry-pick 79cc18d..1c5f5dd
```

### コミットをまとめる
```bash
# mainブランチをスタート地点に戻す
git reset --hard 79cc18d

# ❌これは不可
git cherry-pick --squash 79cc18d..1c5f5dd

# squashマージ
git merge --squash sitemap
```

**重要**: cherry-pickもsquashマージも、元のブランチとは独立した新しいコミットとして作られるため、グラフ上で線はつながらない

#### なぜ cherry-pick --squash がないのか
- `git cherry-pick`の目的は「個別のコミットを適用すること」
- squashしたいなら`git merge --squash`を使うべき、という設計思想

| やりたいこと | コマンド |
|------------|---------|
| 複数コミットを個別に適用 | `git cherry-pick A..B` |
| 複数コミットを1つにまとめて適用 | `git merge --squash` |

squashが目的なら`git merge --squash`が正解です！
