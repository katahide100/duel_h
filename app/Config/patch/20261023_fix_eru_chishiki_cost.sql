-- =====================================================================
-- パッチ: デュエルメイト呪文「♪得る知識 これは嫌いと 飢えとした」のコストを入れる
-- 作成: 2026-10-23 / 1 回だけ実行する想定
--
-- コスト欄が空になっていた(入力漏れ)。正しくはコスト 4 (DM25-EX4。デュエル・マスターズ Wiki で確認)。
-- duel-next の対戦画面でコストが表示されなかった。
-- 同じバンキッシュのデュエルメイト呪文「♪英美なる トワイライトで 罰を強いた」はコスト 3 で入っている。
--
-- id は環境で変わり得るのでカード名と現在値(コストが空)で絞る。
-- 事前に *_check.sql で 1 件であることを確認してから流す。
-- ※ カード名の「♪」(U+266A) と区切りの半角スペースは card1.txt / duel-next の cards.json と同じ文字。エディタで置き換えないこと
--
-- 処理:
--   1. 対象の確認
--   2. 変更前の値を cards_bak_20261023_eru_chishiki_cost に退避
--      (既に存在する = 実行済み なので、ここでエラーになって止まる)
--   3. cost に 4 を入れる
--   4. 結果の確認
--
-- 流した後、管理画面の「パート一覧 → セーブ」で cgi3 の card1.txt を作り直し、
-- duel-next で npm run convert を流すと data/cards.json に反映される。
--
-- 戻し方: 20261023_fix_eru_chishiki_cost_rollback.sql
-- =====================================================================

SET NAMES utf8;

-- 1. 対象 (1 件であること)
SELECT id, name, cost
FROM cards
WHERE name = '♪得る知識 これは嫌いと 飢えとした'
  AND TRIM(IFNULL(cost, '')) = '';

-- 2. 退避 (再実行時はここで "Table already exists" になり止まる)
CREATE TABLE cards_bak_20261023_eru_chishiki_cost AS
SELECT id, cost
FROM cards
WHERE name = '♪得る知識 これは嫌いと 飢えとした'
  AND TRIM(IFNULL(cost, '')) = '';

-- 3. コストを入れる (空の場合だけ。既に何か入っていたら手で確認する)
UPDATE cards c
JOIN cards_bak_20261023_eru_chishiki_cost b ON b.id = c.id
SET c.cost = '4'
WHERE TRIM(IFNULL(c.cost, '')) = '';

-- 4. 確認 (after_cost=4 になっていること)
SELECT c.id, c.name, b.cost AS before_cost, c.cost AS after_cost
FROM cards c
JOIN cards_bak_20261023_eru_chishiki_cost b ON b.id = c.id;
