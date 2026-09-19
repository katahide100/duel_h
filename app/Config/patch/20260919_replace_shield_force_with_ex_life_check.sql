-- =====================================================================
-- 20260919_replace_shield_force_with_ex_life.sql の事前確認 (読み取りのみ・何度実行してもよい)
-- =====================================================================

SET NAMES utf8;

-- 実行済みかどうか (1 行出たら実行済み。パッチ本体は流さない)
SHOW TABLES LIKE 'cards_bak_20260919_ex_life_sf';

-- 対象件数 (目安: 97 件。0 件なら文字コードを疑う)
--   has_28: 28 を外すカード / has_37: 37 が既にあるカード / too_long: 20 文字を超えて更新できないカード
SELECT COUNT(*) AS target_cards,
       SUM(FIND_IN_SET('28', effects) > 0) AS has_28,
       SUM(FIND_IN_SET('37', effects) > 0) AS has_37,
       SUM(FIND_IN_SET('37', effects) = 0
           AND CHAR_LENGTH(TRIM(BOTH ',' FROM REPLACE(CONCAT(',', IFNULL(effects, ''), ','), ',28,', ','))) + 3 > 20) AS too_long
FROM cards
WHERE str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'EXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BC USING utf8), 'EXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'EXライフ（%');

-- 対象カード一覧
SELECT id, name, effects
FROM cards
WHERE str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'EXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BC USING utf8), 'EXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'EXライフ（%')
ORDER BY id;
