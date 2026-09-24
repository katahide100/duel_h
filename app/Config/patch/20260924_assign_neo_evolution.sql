-- =====================================================================
-- パッチ3/3: 能力テキストの「NEO進化：」「G-NEO進化：」に進化コードを割り当てる
-- 作成: 2026-09-24 / 1 回だけ実行する想定
--
--   14 = NEO進化 / 15 = G-NEO進化
--
-- **必ずパッチ1(20260924_move_legacy_evo14.sql)を先に実行する。**
-- 14 を使っている既存カードが残っていると混ざる。
--
-- 対象の絞り込み:
--   箇条書きマーカーの直後に「NEO進化：」または「G-NEO進化：」が来るものだけ。
--   「NEO進化」という語は他のカードの本文にも出てくる（例:「これをNEO進化クリーチャーの下に置く」）ため、
--   マーカー直後であること＋直後に「：」が来ることの両方を条件にする。
--   マーカー文字はエディタで異体字セレクタ(U+FE0E/U+FE0F)が消えないよう 16 進で指定している。
--   ハイフンは半角「-」と全角「－」、コロンは全角「：」と半角「:」の両方がある。
--
-- 2026-09-24 時点の cgi3/card2.txt での件数: G-NEO進化 57 件 / NEO進化 259 件
--
-- 対象外（マーカーと「NEO進化：」の間に語が入るため当たらない。必要なら手で設定する）:
--   喜蛇の虚 エルヴリド      ■超無限G-NEO進化：…（実質 G-NEO進化）
--   アビスラブ=ジャシン帝    ■S-NEO進化(墓地)：…（実質 NEO進化）
--
-- 処理:
--   1. 対象件数の確認
--   2. 変更前の evolution と割り当てる値を cards_bak_20260924_neo_evo に退避
--      (既に存在する = 実行済み なので、ここでエラーになって止まる)
--   3. evolution を更新
--   4. 結果の確認
--
-- 戻し方: 20260924_assign_neo_evolution_rollback.sql
-- =====================================================================

SET NAMES utf8;

-- 1. 対象件数 (目安: 316 件 = G-NEO 57 + NEO 259)
SELECT COUNT(*) AS target_cards
FROM cards
WHERE
  str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'G-', 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'G-', 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'G-', 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'G-', 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), 'G-', 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), 'G-', 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), 'G-', 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), 'G-', 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), 'G-', 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), 'G-', 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', ':', '%')
;

-- 2. 退避 + 割り当てる進化コードの決定
--    「G-NEO進化：」は「NEO進化：」を含まない（間に "G-" が入るのでマーカー直後の条件を満たさない）が、
--    取り違えないよう G-NEO を先に判定する
CREATE TABLE cards_bak_20260924_neo_evo AS
SELECT id,
       evolution AS before_evolution,
       CASE WHEN
      str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'G-', 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
      OR str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'G-', 'NEO進化', ':', '%')
      OR str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
      OR str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', ':', '%')
      OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'G-', 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
      OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'G-', 'NEO進化', ':', '%')
      OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
      OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', ':', '%')
      OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), 'G-', 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
      OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), 'G-', 'NEO進化', ':', '%')
      OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
      OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', ':', '%')
      OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), 'G-', 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
      OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), 'G-', 'NEO進化', ':', '%')
      OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
      OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', ':', '%')
      OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), 'G-', 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
      OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), 'G-', 'NEO進化', ':', '%')
      OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
      OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', ':', '%')
            THEN '15' ELSE '14' END AS new_evolution
FROM cards
WHERE
  str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'G-', 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), 'G-', 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296A0 USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'G-', 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), 'G-', 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), 'G-', 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), 'G-', 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BEEFB88F USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), 'G-', 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), 'G-', 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE296AAEFB88F USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), 'G-', 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), 'G-', 'NEO進化', ':', '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', CONVERT(0xEFBC9A USING utf8), '%')
  OR str LIKE CONCAT('%', CONVERT(0xE297BCEFB88E20 USING utf8), CONVERT(0x47EFBC8D USING utf8), 'NEO進化', ':', '%')
;

-- 2-2. 変更前に進化コードが入っていたカード (2026-09-24 時点では 7 件・すべて 8=マナ進化)
--      いずれも能力文はバトルゾーンのNEO進化なので、上書きして良い
SELECT c.id, c.name, b.before_evolution, b.new_evolution
FROM cards c
JOIN cards_bak_20260924_neo_evo b ON b.id = c.id
WHERE TRIM(IFNULL(b.before_evolution, '')) <> ''
ORDER BY c.id;

-- 3. 割り当て
UPDATE cards c
JOIN cards_bak_20260924_neo_evo b ON b.id = c.id
SET c.evolution = b.new_evolution;

-- 4. 確認 (updated_cards が 1. の件数と同じなら OK)
SELECT COUNT(*) AS updated_cards
FROM cards c
JOIN cards_bak_20260924_neo_evo b ON b.id = c.id
WHERE c.evolution = b.new_evolution;

SELECT c.evolution, COUNT(*) AS cards
FROM cards c
JOIN cards_bak_20260924_neo_evo b ON b.id = c.id
GROUP BY c.evolution;

SELECT c.id, c.name, b.before_evolution, c.evolution AS after_evolution
FROM cards c
JOIN cards_bak_20260924_neo_evo b ON b.id = c.id
ORDER BY c.id;
