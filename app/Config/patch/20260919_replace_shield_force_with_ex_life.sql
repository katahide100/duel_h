-- =====================================================================
-- パッチ: 能力テキストに「■EXライフ（」を含むカードの効果 28(シールド・フォース) を 37(EXライフ) に置き換える
-- 作成: 2026-09-19 / 1 回だけ実行する想定
--
-- 20260919_add_ex_life_effect.sql (37 を足すだけ) の後継。
-- あちらを実行済みでも未実行でも、これ 1 本で同じ結果になる。
--   例) "3,12,28"    → "3,12,37"
--       "3,12,28,37" → "3,12,37"   (add_ex_life_effect 実行済みの場合)
--       "6,12"       → "6,12,37"   (28 が無いカードは 37 を足すだけ)
--
-- 対象: cards.str に次のいずれかを含むカード (add_ex_life_effect と同じ条件)
--   ■EXライフ（   (■ = U+25A0)
--   ◼︎EXライフ（  (◼ = U+25FC、後ろに U+FE0E が付くものと付かないもの)
--   ※「■エクストラEXライフ（」(2 枚シールド化する別能力) は対象外
--   ※ マーカー文字はエディタで U+FE0E が消えないよう 16 進で指定している
--
-- cgi3 では暫定対応として 37 をシールド・フォースと同じ処理に流している (action.pl の sforth_chk)。
--
-- 処理:
--   1. 対象件数の確認
--   2. 変更前の effects を cards_bak_20260919_ex_life_sf に退避
--      (既に存在する = 実行済み なので、ここでエラーになって止まる)
--   3. 28 を外し、37 が無ければ末尾に足す
--   4. 結果の確認
--
-- 戻し方: 20260919_replace_shield_force_with_ex_life_rollback.sql
-- =====================================================================

SET NAMES utf8;

-- 1. 対象件数 (実行前の目安: 97 件 / 2026-09-19 時点の cgi3/card2.txt から算出)
SELECT COUNT(*) AS target_cards
FROM cards
WHERE str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'EXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BC USING utf8), 'EXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'EXライフ（%');

-- 2. 退避 (再実行時はここで "Table already exists" になり止まる)
CREATE TABLE cards_bak_20260919_ex_life_sf AS
SELECT id, effects
FROM cards
WHERE str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'EXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BC USING utf8), 'EXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'EXライフ（%');

-- 3. 置き換え
--    s = effects から 28 を外したもの (",a,b," の形にして ",28," を "," に置換 → 両端の "," を削る)
--    37 が無ければ s の末尾に足す。effects は varchar(20) なので、20 文字を超える場合は更新しない
UPDATE cards c
JOIN cards_bak_20260919_ex_life_sf b ON b.id = c.id
JOIN (
  SELECT id,
         TRIM(BOTH ',' FROM REPLACE(CONCAT(',', IFNULL(effects, ''), ','), ',28,', ',')) AS s
  FROM cards_bak_20260919_ex_life_sf
) x ON x.id = c.id
SET c.effects = CASE
    WHEN FIND_IN_SET('37', x.s) > 0 THEN x.s
    WHEN TRIM(x.s) = '' THEN '37'
    ELSE CONCAT(x.s, ',37')
  END
WHERE CHAR_LENGTH(x.s) + 3 <= 20 OR FIND_IN_SET('37', x.s) > 0;

-- 4. 確認
--    ok_cards が target_cards と同じなら OK (28 が無く 37 がある)
SELECT COUNT(*) AS ok_cards
FROM cards c
JOIN cards_bak_20260919_ex_life_sf b ON b.id = c.id
WHERE FIND_IN_SET('37', c.effects) > 0
  AND FIND_IN_SET('28', c.effects) = 0;

--    ok でないカード (0 件であること。出たら手動で対応する)
SELECT c.id, c.name, b.effects AS before_effects, c.effects AS after_effects
FROM cards c
JOIN cards_bak_20260919_ex_life_sf b ON b.id = c.id
WHERE FIND_IN_SET('37', c.effects) = 0
   OR FIND_IN_SET('28', c.effects) > 0
ORDER BY c.id;

--    全件の変更前後
SELECT c.id, c.name, b.effects AS before_effects, c.effects AS after_effects
FROM cards c
JOIN cards_bak_20260919_ex_life_sf b ON b.id = c.id
ORDER BY c.id;
