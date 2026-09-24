-- =====================================================================
-- 20260924_fix_muji_gandhal_power.sql の事前確認 (読み取りのみ・何度実行してもよい)
-- =====================================================================

SET NAMES utf8;

-- 実行済みかどうか (1 行出たら実行済み。パッチ本体は流さない)
SHOW TABLES LIKE 'cards_bak_20260924_muji_power';

-- 対象 (1 件であること。power が空で evolution が 3500)
SELECT id, name, power, cost, evolution
FROM cards
WHERE name = '豪雷の求道者ムジ・ガンダール';

-- 進化欄が進化種別コード(1〜15)の範囲外になっているカード
-- (ムジ・ガンダール以外にも同じ入力ミスが無いか)
SELECT id, name, power, evolution
FROM cards
WHERE TRIM(IFNULL(evolution, '')) <> ''
  AND CAST(TRIM(IFNULL(evolution, '')) AS UNSIGNED) > 15
ORDER BY id;
