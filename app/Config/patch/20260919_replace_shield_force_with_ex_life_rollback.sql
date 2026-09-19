-- =====================================================================
-- 20260919_replace_shield_force_with_ex_life.sql の取り消し
-- 退避テーブルの effects に戻してから、退避テーブルを削除する
-- (add_ex_life_effect を先に実行していた場合は、その実行後の状態に戻る)
-- =====================================================================

SET NAMES utf8;

UPDATE cards c
JOIN cards_bak_20260919_ex_life_sf b ON b.id = c.id
SET c.effects = b.effects;

SELECT COUNT(*) AS restored_cards FROM cards_bak_20260919_ex_life_sf;

DROP TABLE cards_bak_20260919_ex_life_sf;
