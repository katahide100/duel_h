-- =====================================================================
-- 20261001_add_extra_ex_life_effect.sql の事前確認 (読み取りのみ・何度実行してもよい)
-- =====================================================================

SET NAMES utf8;

-- 実行済みかどうか (1 行出たら実行済み。パッチ本体は流さない)
SHOW TABLES LIKE 'cards_bak_20261001_extra_ex_life';

-- 対象件数 (目安: 5 件。0 件なら文字コードを疑う)
--   has_28: 28 を持つカード / keep_28: 本物のシールド・フォースもあり 28 を残すカード (目安: 0 件)
--   has_37: EXライフ(37) も付いているカード (目安: 0 件。出たら能力テキストを確認する)
--   has_38: 38 が既にあるカード / too_long: 20 文字を超えて更新できないカード
SELECT COUNT(*) AS target_cards,
       SUM(FIND_IN_SET('28', effects) > 0) AS has_28,
       SUM(str LIKE '%シールド・フォース%') AS keep_28,
       SUM(FIND_IN_SET('37', effects) > 0) AS has_37,
       SUM(FIND_IN_SET('38', effects) > 0) AS has_38,
       SUM(FIND_IN_SET('38', effects) = 0
           AND CHAR_LENGTH(TRIM(BOTH ',' FROM REPLACE(CONCAT(',', IFNULL(effects, ''), ','), ',28,', ','))) + 3 > 20) AS too_long
FROM cards
WHERE str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'エクストラEXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BC USING utf8), 'エクストラEXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'エクストラEXライフ（%');

-- 対象カード一覧
SELECT id, name, effects
FROM cards
WHERE str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'エクストラEXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BC USING utf8), 'エクストラEXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'エクストラEXライフ（%')
ORDER BY id;
