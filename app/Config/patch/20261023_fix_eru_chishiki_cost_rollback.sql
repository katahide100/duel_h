-- =====================================================================
-- 20261023_fix_eru_chishiki_cost.sql の取り消し
-- 退避テーブルの cost に戻してから、退避テーブルを削除する
-- =====================================================================

SET NAMES utf8;

UPDATE cards c
JOIN cards_bak_20261023_eru_chishiki_cost b ON b.id = c.id
SET c.cost = b.cost;

SELECT COUNT(*) AS restored_cards FROM cards_bak_20261023_eru_chishiki_cost;

DROP TABLE cards_bak_20261023_eru_chishiki_cost;
