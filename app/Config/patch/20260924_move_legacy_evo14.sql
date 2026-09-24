-- =====================================================================
-- パッチ1/3: 既存の進化コード 14 のカードを 11(墓地進化) に移す
-- 作成: 2026-09-24 / 1 回だけ実行する想定
--
-- NEO進化に 14、G-NEO進化に 15 を割り当てる(20260924_assign_neo_evolution.sql)ため、
-- 先に 14 を使っている既存カードを空けておく。**必ずパッチ3より先に実行する。**
--
-- 対象(2026-09-24 時点の cgi3/card1.txt から算出 / 2 件):
--   大宇宙ジオ・リバース   進化-自分の水または闇のクリーチャー1体の上に置く
--   悪魔神ザビ・リブラ     進化-自分の光または自然のクリーチャー1体の上に置く
--
-- cgi3 の action.pl put_cre_chk は「12 以上は墓地進化V・GV」と範囲で分岐しているため、
-- この2枚はこれまでも墓地進化系として扱われていた。挙動を変えないために 11(墓地進化) にする。
-- ※ 15 を使っているカードは現行データには無い(過去の書き出しにあった分は既に別の値)。
--    念のため 15 も同じ扱いにする。
--
-- 処理:
--   1. 対象件数の確認
--   2. 変更前の evolution を cards_bak_20260924_evo14 に退避
--      (既に存在する = 実行済み なので、ここでエラーになって止まる)
--   3. evolution を 11 に更新
--   4. 結果の確認
--
-- 戻し方: 20260924_move_legacy_evo14_rollback.sql
-- =====================================================================

SET NAMES utf8;

-- 1. 対象件数 (実行前の目安: 2 件)
SELECT COUNT(*) AS target_cards
FROM cards
WHERE TRIM(IFNULL(evolution, '')) IN ('14', '15');

-- 2. 退避 (再実行時はここで "Table already exists" になり止まる)
CREATE TABLE cards_bak_20260924_evo14 AS
SELECT id, evolution
FROM cards
WHERE TRIM(IFNULL(evolution, '')) IN ('14', '15');

-- 3. 墓地進化(11) に移す
UPDATE cards c
JOIN cards_bak_20260924_evo14 b ON b.id = c.id
SET c.evolution = '11';

-- 4. 確認 (moved_cards が 1. の件数と同じなら OK / 14・15 の残りは 0 件であること)
SELECT COUNT(*) AS moved_cards
FROM cards c
JOIN cards_bak_20260924_evo14 b ON b.id = c.id
WHERE c.evolution = '11';

SELECT COUNT(*) AS remaining_14_15
FROM cards
WHERE TRIM(IFNULL(evolution, '')) IN ('14', '15');

SELECT c.id, c.name, b.evolution AS before_evolution, c.evolution AS after_evolution
FROM cards c
JOIN cards_bak_20260924_evo14 b ON b.id = c.id
ORDER BY c.id;
