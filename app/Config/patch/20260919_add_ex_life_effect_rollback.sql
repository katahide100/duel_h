-- =====================================================================
-- 20260919_add_ex_life_effect.sql の取り消し
-- 退避テーブルの effects に戻してから、退避テーブルを削除する
-- =====================================================================

SET NAMES utf8;

UPDATE cards c
JOIN cards_bak_20260919_ex_life b ON b.id = c.id
SET c.effects = b.effects;

SELECT COUNT(*) AS restored_cards FROM cards_bak_20260919_ex_life;

DROP TABLE cards_bak_20260919_ex_life;
