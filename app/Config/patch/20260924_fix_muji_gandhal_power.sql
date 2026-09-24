-- =====================================================================
-- パッチ2/3: 「豪雷の求道者ムジ・ガンダール」の進化欄に入っているパワー値を直す
-- 作成: 2026-09-24 / 1 回だけ実行する想定
--
-- パワー欄が空で、進化欄に 3500 が入っている(パワーの入力ミス)。
-- 進化欄は本来 1〜15 の進化種別コードなので、cgi3 では 3500 が
-- 「12 以上 = 墓地進化V・GV」に該当してしまい、墓地から進化元を探しに行っていた。
--
-- id は環境で変わり得るのでカード名と現在値で絞る。
-- 事前に *_check.sql で 1 件であることを確認してから流す。
--
-- 処理:
--   1. 対象の確認
--   2. 変更前の値を cards_bak_20260924_muji_power に退避
--      (既に存在する = 実行済み なので、ここでエラーになって止まる)
--   3. power に 3500 を入れ、evolution を空にする
--   4. 結果の確認
--
-- 戻し方: 20260924_fix_muji_gandhal_power_rollback.sql
-- =====================================================================

SET NAMES utf8;

-- 1. 対象 (1 件であること)
SELECT id, name, power, evolution
FROM cards
WHERE name = '豪雷の求道者ムジ・ガンダール'
  AND TRIM(IFNULL(evolution, '')) = '3500';

-- 2. 退避 (再実行時はここで "Table already exists" になり止まる)
CREATE TABLE cards_bak_20260924_muji_power AS
SELECT id, power, evolution
FROM cards
WHERE name = '豪雷の求道者ムジ・ガンダール'
  AND TRIM(IFNULL(evolution, '')) = '3500';

-- 3. パワーに移して進化欄を空にする
--    (パワー欄が空の場合だけ入れる。既に何か入っていたら手で確認する)
UPDATE cards c
JOIN cards_bak_20260924_muji_power b ON b.id = c.id
SET c.power = '3500',
    c.evolution = ''
WHERE TRIM(IFNULL(c.power, '')) = '';

-- 4. 確認 (power=3500 / evolution が空になっていること)
SELECT c.id, c.name,
       b.power AS before_power, b.evolution AS before_evolution,
       c.power AS after_power, c.evolution AS after_evolution
FROM cards c
JOIN cards_bak_20260924_muji_power b ON b.id = c.id;

-- 進化欄に進化種別コードでない値が残っていないか (0 件であること)
SELECT id, name, evolution
FROM cards
WHERE TRIM(IFNULL(evolution, '')) <> ''
  AND CAST(TRIM(IFNULL(evolution, '')) AS UNSIGNED) > 15;
