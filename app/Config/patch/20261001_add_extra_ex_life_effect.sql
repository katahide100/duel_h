-- =====================================================================
-- パッチ: 能力テキストに「■エクストラEXライフ（」を含むカードの効果 28(シールド・フォース) を
--         38(エクストラEXライフ) に置き換える
-- 作成: 2026-10-01 / 1 回だけ実行する想定
--
-- エクストラEXライフ: 「このクリーチャーを出す時、自分の山札の上から2枚をシールド化する。
--   このクリーチャーが離れる時、かわりにそのシールドのうち1つを墓地に置く」
-- EXライフ(37) と同じく、これまでは暫定で 28(シールド・フォース) を付けていた。
--   例) "6,28"        → "6,38"
--       "1,5,12,28"   → "1,5,12,38"
--       "12"          → "12,38"   (28 が無いカードは 38 を足すだけ)
--
-- 対象: cards.str に次のいずれかを含むカード
--   ■エクストラEXライフ（   (■ = U+25A0)
--   ◼︎エクストラEXライフ（  (◼ = U+25FC、後ろに U+FE0E が付くものと付かないもの)
--   ※ マーカー文字はエディタで U+FE0E が消えないよう 16 進で指定している
--   ※「■EXライフ（」(1 枚版。20260919_replace_shield_force_with_ex_life) とは別のカード
--
-- 能力テキストに本物の「シールド・フォース」もあるカードは 28 を残す (38 を足すだけ)。
--
-- cgi3 では暫定対応として 38 もシールド・フォースと同じ処理に流している (action.pl の sforth_chk)。
-- duel-next は app/duel/exLife.ts で本実装 (2 枚シールド化・1 枚を選んで墓地へ)。
-- **duel-next / cgi3 の 38 対応をデプロイしてから流すこと** (先に流すと、その間シールド・フォースとしても動かない)。
--
-- 処理:
--   1. 対象件数の確認
--   2. 変更前の effects を cards_bak_20261001_extra_ex_life に退避
--      (既に存在する = 実行済み なので、ここでエラーになって止まる)
--   3. 28 を外し (本物のシールド・フォースを持つカードを除く)、38 が無ければ末尾に足す
--   4. 結果の確認
--
-- 戻し方: 20261001_add_extra_ex_life_effect_rollback.sql
-- =====================================================================

SET NAMES utf8;

-- 1. 対象件数 (実行前の目安: 5 件 / 2026-10-01 時点の duel-next data/cards.json から算出)
SELECT COUNT(*) AS target_cards
FROM cards
WHERE str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'エクストラEXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BC USING utf8), 'エクストラEXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'エクストラEXライフ（%');

-- 2. 退避 (再実行時はここで "Table already exists" になり止まる)
CREATE TABLE cards_bak_20261001_extra_ex_life AS
SELECT id, effects, (str LIKE '%シールド・フォース%') AS keep_28
FROM cards
WHERE str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'エクストラEXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BC USING utf8), 'エクストラEXライフ（%')
   OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'エクストラEXライフ（%');

-- 3. 置き換え
--    s = effects から 28 を外したもの (",a,b," の形にして ",28," を "," に置換 → 両端の "," を削る)
--        ただし本物のシールド・フォースを持つカード (keep_28) は外さない
--    38 が無ければ s の末尾に足す。effects は varchar(20) なので、20 文字を超える場合は更新しない
UPDATE cards c
JOIN (
  SELECT id,
         IF(keep_28,
            TRIM(BOTH ',' FROM IFNULL(effects, '')),
            TRIM(BOTH ',' FROM REPLACE(CONCAT(',', IFNULL(effects, ''), ','), ',28,', ','))) AS s
  FROM cards_bak_20261001_extra_ex_life
) x ON x.id = c.id
SET c.effects = CASE
    WHEN FIND_IN_SET('38', x.s) > 0 THEN x.s
    WHEN TRIM(x.s) = '' THEN '38'
    ELSE CONCAT(x.s, ',38')
  END
WHERE CHAR_LENGTH(x.s) + 3 <= 20 OR FIND_IN_SET('38', x.s) > 0;

-- 4. 確認
--    ok_cards が target_cards と同じなら OK (38 があり、本物のシールド・フォースが無いカードは 28 も無い)
SELECT COUNT(*) AS ok_cards
FROM cards c
JOIN cards_bak_20261001_extra_ex_life b ON b.id = c.id
WHERE FIND_IN_SET('38', c.effects) > 0
  AND (b.keep_28 OR FIND_IN_SET('28', c.effects) = 0);

--    ok でないカード (0 件であること。出たら手動で対応する)
SELECT c.id, c.name, b.effects AS before_effects, c.effects AS after_effects, b.keep_28
FROM cards c
JOIN cards_bak_20261001_extra_ex_life b ON b.id = c.id
WHERE FIND_IN_SET('38', c.effects) = 0
   OR (NOT b.keep_28 AND FIND_IN_SET('28', c.effects) > 0)
ORDER BY c.id;

--    全件の変更前後
SELECT c.id, c.name, b.effects AS before_effects, c.effects AS after_effects, b.keep_28
FROM cards c
JOIN cards_bak_20261001_extra_ex_life b ON b.id = c.id
ORDER BY c.id;
