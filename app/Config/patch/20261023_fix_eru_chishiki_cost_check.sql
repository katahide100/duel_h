-- =====================================================================
-- 20261023_fix_eru_chishiki_cost.sql の事前確認 (読み取りのみ・何度実行してもよい)
-- =====================================================================

SET NAMES utf8;

-- 実行済みかどうか (1 行出たら実行済み。パッチ本体は流さない)
SHOW TABLES LIKE 'cards_bak_20261023_eru_chishiki_cost';

-- 対象 (1 件であること。cost が空)
SELECT id, name, cost, power
FROM cards
WHERE name = '♪得る知識 これは嫌いと 飢えとした';

-- 同じバンキッシュのデュエルメイト呪文 (参考: コスト 3 で入っていること)
SELECT id, name, cost
FROM cards
WHERE name = '♪英美なる トワイライトで 罰を強いた';
