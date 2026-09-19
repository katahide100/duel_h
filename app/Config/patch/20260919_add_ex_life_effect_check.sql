-- =====================================================================
-- 20260919_add_ex_life_effect.sql の事前確認 (読み取りのみ・何度実行してもよい)
-- =====================================================================

SET NAMES utf8;

-- 実行済みかどうか (1 行出たら実行済み。パッチ本体は流さない)
SHOW TABLES LIKE 'cards_bak_20260919_ex_life';

-- 対象件数 (目安: 97 件 / 2026-09-19 時点の cgi3/card2.txt から算出。0 件なら文字コードを疑う)
SELECT COUNT(*) AS target_cards,
       SUM(FIND_IN_SET('37', REPLACE(IFNULL(effects, ''), ' ', '')) > 0) AS already_has_37,
       SUM(CHAR_LENGTH(IFNULL(effects, '')) + 3 > 20) AS too_long
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
