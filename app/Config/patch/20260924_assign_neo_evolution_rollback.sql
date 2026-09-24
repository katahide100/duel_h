-- =====================================================================
-- 20260924_assign_neo_evolution.sql の取り消し
-- 退避テーブルの evolution に戻してから、退避テーブルを削除する
-- =====================================================================

SET NAMES utf8;

UPDATE cards c
JOIN cards_bak_20260924_neo_evo b ON b.id = c.id
SET c.evolution = b.before_evolution;

SELECT COUNT(*) AS restored_cards FROM cards_bak_20260924_neo_evo;

DROP TABLE cards_bak_20260924_neo_evo;
