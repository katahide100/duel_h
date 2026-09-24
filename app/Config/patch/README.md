# データパッチ

`cards` などのデータを直接書き換える1回限りの SQL。ファイル名は `YYYYMMDD_用途.sql`。

各パッチは3点セット:

| ファイル | 内容 |
| --- | --- |
| `*_check.sql` | 事前確認。読み取りのみで何度実行してもよい |
| `*.sql` | 本体。変更前の値を `cards_bak_<日付>_<用途>` に退避してから更新する（再実行すると `Table already exists` で止まる） |
| `*_rollback.sql` | 退避テーブルから戻して、退避テーブルを削除する |

実行例（ローカル: `docker compose up -d db`）:

```sh
docker exec -i duel_h-db-1 mysql -uduel -pduel duel_h < 20260924_move_legacy_evo14_check.sql
docker exec -i duel_h-db-1 mysql -uduel -pduel duel_h < 20260924_move_legacy_evo14.sql
```

**パッチを流しても `cgi3/card1.txt` / `card2.txt` は更新されない。**
管理画面でカードを保存する（`PartsController` の書き出しが走る）か、手動で書き出す必要がある。

## 2026-09-24 NEO進化 / G-NEO進化 の割り当て（この順に実行する）

| # | ファイル | 内容 |
| --- | --- | --- |
| 1 | `20260924_move_legacy_evo14` | 既存の進化コード 14/15 を 11（墓地進化）へ移して 14/15 を空ける |
| 2 | `20260924_fix_muji_gandhal_power` | 「豪雷の求道者ムジ・ガンダール」の進化欄に入っているパワー値（3500）を power へ移す |
| 3 | `20260924_assign_neo_evolution` | 能力テキストの「NEO進化：」に 14、「G-NEO進化：」に 15 を割り当てる |

**1 → 3 の順序は必須**（14 を空けてから割り当てる）。戻す時は逆順（3 → 1）。
