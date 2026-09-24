-- =====================================================================
-- 20260924_move_legacy_evo14.sql の取り消し
-- 退避テーブルの evolution に戻してから、退避テーブルを削除する
--
-- ※ パッチ3(20260924_assign_neo_evolution.sql)を実行済みの場合は、
--    先にパッチ3を rollback すること(14 が NEO進化として使われている)
-- =====================================================================

SET NAMES utf8;

UPDATE cards c
JOIN cards_bak_20260924_evo14 b ON b.id = c.id
SET c.evolution = b.evolution;

SELECT COUNT(*) AS restored_cards FROM cards_bak_20260924_evo14;

DROP TABLE cards_bak_20260924_evo14;
