# ローカル Docker 環境

CakePHP 2.10 の管理画面 (PHP 7.4 + Apache) と MariaDB 10.6 を起動する。

```sh
docker compose up -d --build   # 起動
docker compose down            # 停止
docker compose down -v         # 停止 + DB 破棄 (次回起動時に初期データを再投入)
```

- 管理画面: http://localhost:8081 （ログイン: `local` / `local`）
- DB: `localhost:3307`（`duel` / `duel`, DB 名 `duel_h`, root パスワード `root`）

## テスト

PHPUnit は入れていないので、`app/Test/Standalone/` のスクリプトを php で直接実行する。

```sh
docker compose exec web php app/Test/Standalone/CsvConditionTest.php
```

## 前提

`duel_h` と同じ階層に `cgi3` があること。

```
workspace/
├── duel_h/   ← このリポジトリ (/var/www/duel_h)
└── cgi3/     ← 生成ファイルの書き出し先 (/var/www/cgi3)
```

## 仕組み

- `app/Config/core.php` / `database.php` は gitignore 対象。無ければ起動時に `docker/config/` からコピーされる（既にあれば上書きしない）。
- DB は初回起動時に `docker-entrypoint-initdb.d` で以下を順に投入する。
  1. `app/Config/export_table_20140913.sql` — テーブル定義
  2. `app/Config/export_data_20140913.sql` — データ (2014/09/13 時点)
  3. `docker/db/03_local_user.sql` — ローカル用ログインユーザー
  4. `docker/db/04_schema_diff.sql` — 2014 年以降にコードで追加されたカラム/テーブル (`parts.rank`, `packs.rank`, `species`)
  5. `docker/db/05_species_seed.sh` — `cgi3/syu.txt` から種族を投入

## 注意

- **カードデータは 2014 年時点のもの。** この状態で「保存」系の操作をすると、`cgi3` の `action.pl` / `deck.cgi` / `cust.cgi` / `syu.txt` が古いデータから再生成されて上書きされる。実行したら `cgi3` 側で `git diff` を確認し、不要なら `git checkout` で戻すこと。
- 本番の DB ダンプを使う場合は、`docker-compose.yml` の 01/02/04/05 のマウントを外して本番ダンプ 1 本に差し替え、`docker compose down -v` してから起動する（本番ダンプは現行スキーマなので 04/05 は不要。本番の `users` はパスワードが本番の salt 依存なので、ローカルでは `local` ユーザーでログインする）。
