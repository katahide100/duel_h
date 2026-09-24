-- =====================================================================
-- 20260924_move_legacy_evo14.sql の事前確認 (読み取りのみ・何度実行してもよい)
-- =====================================================================

SET NAMES utf8;

-- 実行済みかどうか (1 行出たら実行済み。パッチ本体は流さない)
SHOW TABLES LIKE 'cards_bak_20260924_evo14';

-- 対象件数 (目安: 2 件)
SELECT COUNT(*) AS target_cards
FROM cards
WHERE TRIM(IFNULL(evolution, '')) IN ('14', '15');

-- 対象カード一覧 (能力テキストも見て、墓地進化にして良いか確認する)
SELECT id, name, evolution, LEFT(str, 80) AS str_head
FROM cards
WHERE TRIM(IFNULL(evolution, '')) IN ('14', '15')
ORDER BY id;

-- 進化コードの分布 (想定外の値が無いか)
SELECT TRIM(IFNULL(evolution, '')) AS evolution, COUNT(*) AS cards
FROM cards
GROUP BY TRIM(IFNULL(evolution, ''))
ORDER BY CAST(TRIM(IFNULL(evolution, '')) AS UNSIGNED), evolution;
