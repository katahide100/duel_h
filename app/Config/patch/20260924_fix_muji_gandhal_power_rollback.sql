-- =====================================================================
-- 20260924_fix_muji_gandhal_power.sql の取り消し
-- 退避テーブルの power / evolution に戻してから、退避テーブルを削除する
-- =====================================================================

SET NAMES utf8;

UPDATE cards c
JOIN cards_bak_20260924_muji_power b ON b.id = c.id
SET c.power = b.power,
    c.evolution = b.evolution;

SELECT COUNT(*) AS restored_cards FROM cards_bak_20260924_muji_power;

DROP TABLE cards_bak_20260924_muji_power;
