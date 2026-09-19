-- =====================================================================
-- パッチ: 能力テキストに「■EXライフ（」を含むカードに効果 37(EXライフ) を追加する
-- 作成: 2026-09-19 / 1 回だけ実行する想定
--
-- 対象: cards.str に次のいずれかを含むカード
--   ■EXライフ（   (■ = U+25A0)
--   ◼︎EXライフ（  (◼ = U+25FC、後ろに U+FE0E が付くものと付かないもの)
--   ※「■エクストラEXライフ（」(2 枚シールド化する別能力) は対象外
--   ※ マーカー文字はエディタで U+FE0E が消えないよう 16 進で指定している
--
-- 処理:
--   1. 対象件数の確認
--   2. 変更前の effects を cards_bak_20260919_ex_life に退避
--      (既に存在する = 実行済み なので、ここでエラーになって止まる)
--   3. effects に 37 を追加 (既に 37 があるカードは変更しない)
--   4. 結果の確認
--
-- 戻し方: 20260919_add_ex_life_effect_rollback.sql
-- =====================================================================

SET NAMES utf8;

-- 1. 対象件数 (実行前の目安: 97 件 / 2026-09-19 時点の cgi3/card2.txt から算出)
SELECT COUNT(*) AS target_cards
FROM cards
WHERE str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'EXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BC USING utf8), 'EXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'EXライフ（%');

-- 1-2. effects は varchar(20)。",37" を足すと 20 文字を超えるカード (0 件であること)
--      該当カードは 3. で更新せずに残す(切り詰め防止)。4. の件数が 1. と合わなくなるので手動で対応する
SELECT id, name, effects, CHAR_LENGTH(effects) + 3 AS new_length
FROM cards
WHERE (str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'EXライフ（%')
    OR str LIKE CONCAT('%', CONVERT(0xE297BC USING utf8), 'EXライフ（%')
    OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'EXライフ（%'))
  AND CHAR_LENGTH(IFNULL(effects, '')) + 3 > 20;

-- 2. 退避 (再実行時はここで "Table already exists" になり止まる)
CREATE TABLE cards_bak_20260919_ex_life AS
SELECT id, effects
FROM cards
WHERE str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'EXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BC USING utf8), 'EXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'EXライフ（%');

-- 3. 効果 37 を追加 (空なら "37"、それ以外は末尾に ",37")
UPDATE cards c
JOIN cards_bak_20260919_ex_life b ON b.id = c.id
SET c.effects = IF(TRIM(IFNULL(c.effects, '')) = '', '37', CONCAT(c.effects, ',37'))
WHERE FIND_IN_SET('37', REPLACE(IFNULL(c.effects, ''), ' ', '')) = 0
  AND CHAR_LENGTH(IFNULL(c.effects, '')) + 3 <= 20;

-- 4. 確認 (updated_cards が 1 の件数と同じなら OK)
SELECT COUNT(*) AS updated_cards
FROM cards c
JOIN cards_bak_20260919_ex_life b ON b.id = c.id
WHERE FIND_IN_SET('37', REPLACE(c.effects, ' ', '')) > 0;

SELECT c.id, c.name, b.effects AS before_effects, c.effects AS after_effects
FROM cards c
JOIN cards_bak_20260919_ex_life b ON b.id = c.id
ORDER BY c.id;
