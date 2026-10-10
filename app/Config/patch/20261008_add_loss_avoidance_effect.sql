-- =====================================================================
-- パッチ: 敗北回避のカードに効果 39(敗北回避) を足す
-- 作成: 2026-10-08 / 1 回だけ実行する想定
--
-- 敗北回避: バトルゾーンにある時に、ダイレクトアタックでの負けを防げるカード。
--   「自分がゲームに負ける時、かわりに〜」(ガブリエラ・フルメタル・レモン・S-MAX進化 等) と
--   「自分はゲームに負けない」(ボルシャック・ボルバルザーク・ドリーム・アルカディアス 等) の両方を含む。
--   例) "3,6"  → "3,6,39"
--       ""     → "39"
--
-- 対象: 下の 38 枚 (カード名で指定。2026-10-08 時点の duel-next data/cards.json から選定)
--   次のカードは対象外 (duel-next 側でカード名で判定する、または判定しない):
--   - 手札から使う 一王二命三眼槍 / 攻める側のカードの 傲慢の悪魔龍 スペルビア (カード名で判定)
--   - 山札切れでだけ負けない / クリーチャーの攻撃以外で負けない / シールドがある時だけ負けない
--   - 呪文の一時的な効果 (☆鉄壁と欠陥の砦☆・極凰呪文「バドフレア」・運命の決闘)
--   ※ モモキングｰMAX の「ｰ」は半角カタカナの長音 (U+FF70)、”血煙” の引用符は全角 (U+201D)。
--     どちらも card1.txt / duel-next の cards.json と同じ文字。エディタで置き換えないこと
--
-- duel-next はシールド 0 枚でダイレクトアタックが通る時、守る側のバトルゾーンに 39 のクリーチャーが
-- いれば、決着の前に「回避する／回避しない」を確認する (duel-next の app/duel/lossAvoidance.ts)。
-- cgi3 は 39 を使わない (フルメタル・レモン・ガブリエラはこれまでどおり action.pl の lemon_chk がカード名で判定)。
-- 先に流しても cgi3 / duel-next の動きは変わらない (duel-next は 39 対応のデプロイ後に効く)。
--
-- 処理:
--   1. 対象件数の確認
--   2. 変更前の effects を cards_bak_20261008_loss_avoidance に退避
--      (既に存在する = 実行済み なので、ここでエラーになって止まる)
--   3. 39 が無ければ末尾に足す
--   4. 結果の確認
--
-- 戻し方: 20261008_add_loss_avoidance_effect_rollback.sql
-- =====================================================================

SET NAMES utf8;

-- 1. 対象件数 (目安: 38 件 / 2026-10-08 時点の duel-next data/cards.json から算出)
SELECT COUNT(*) AS target_cards
FROM cards
WHERE name IN (
  '剛勇王機フルメタル・レモン',
  '光姫聖霊ガブリエラ',
  'メッチャ無敵なじーさん',
  '20thSP じーさん',
  '不敗のダイハード・リュウセイ',
  '「必然」の頂 リュウセイ / 「オレの勝利だオフコース！」',
  '頂天聖 レオザワルド',
  '奇天烈X グランドダイス',
  '”血煙” マキシマム',
  '始虹帝 ミノガミ',
  '大魔王 ウラギリダムス',
  '「是空」の鬼 ゲドウ権現',
  '一王伝双三眼槍',
  '一王二命三眼槍の封',
  '覇王ノワールモナーク',
  '炎怒の夜 アゲブロム',
  '怒像アゲ',
  '邪闘 デンジャラシス',
  '永炎の竜凰 ボルシャック・バクスザク',
  'ボルシャック・ボルバルザーク',
  'ボルシャック・ヴォルジャアク',
  '聖霊王ドリーム・アルカディアス',
  'E2連結 俺丸「ライバック」',
  'RinRin Kids',
  'ジョニー-MAX',
  'モモキングｰMAX',
  'MAX・ザ・ジョニー',
  'SUPREME-GUN・ザ・ジョニー',
  'Code:-MAX',
  'ゲンム-MAX',
  'ブランド-MAX',
  'バラギアラ-MAX',
  'MAX-Gジョラゴン',
  'サッヴァーク-MAX',
  'CRYMAX ジャオウガ',
  'CRY-S-MAX ジャオウガ',
  '「亜堕無」-鬼MAX',
  'EVE-鬼MAX'
);

-- 2. 退避 (再実行時はここで "Table already exists" になり止まる)
CREATE TABLE cards_bak_20261008_loss_avoidance AS
SELECT id, effects
FROM cards
WHERE name IN (
  '剛勇王機フルメタル・レモン',
  '光姫聖霊ガブリエラ',
  'メッチャ無敵なじーさん',
  '20thSP じーさん',
  '不敗のダイハード・リュウセイ',
  '「必然」の頂 リュウセイ / 「オレの勝利だオフコース！」',
  '頂天聖 レオザワルド',
  '奇天烈X グランドダイス',
  '”血煙” マキシマム',
  '始虹帝 ミノガミ',
  '大魔王 ウラギリダムス',
  '「是空」の鬼 ゲドウ権現',
  '一王伝双三眼槍',
  '一王二命三眼槍の封',
  '覇王ノワールモナーク',
  '炎怒の夜 アゲブロム',
  '怒像アゲ',
  '邪闘 デンジャラシス',
  '永炎の竜凰 ボルシャック・バクスザク',
  'ボルシャック・ボルバルザーク',
  'ボルシャック・ヴォルジャアク',
  '聖霊王ドリーム・アルカディアス',
  'E2連結 俺丸「ライバック」',
  'RinRin Kids',
  'ジョニー-MAX',
  'モモキングｰMAX',
  'MAX・ザ・ジョニー',
  'SUPREME-GUN・ザ・ジョニー',
  'Code:-MAX',
  'ゲンム-MAX',
  'ブランド-MAX',
  'バラギアラ-MAX',
  'MAX-Gジョラゴン',
  'サッヴァーク-MAX',
  'CRYMAX ジャオウガ',
  'CRY-S-MAX ジャオウガ',
  '「亜堕無」-鬼MAX',
  'EVE-鬼MAX'
);

-- 3. 39 を足す
--    s = 両端の "," を削った effects。39 が無ければ末尾に足す。
--    effects は varchar(20) なので、20 文字を超える場合は更新しない (目安: 0 件)
UPDATE cards c
JOIN (
  SELECT id, TRIM(BOTH ',' FROM IFNULL(effects, '')) AS s
  FROM cards_bak_20261008_loss_avoidance
) x ON x.id = c.id
SET c.effects = CASE
    WHEN FIND_IN_SET('39', x.s) > 0 THEN x.s
    WHEN TRIM(x.s) = '' THEN '39'
    ELSE CONCAT(x.s, ',39')
  END
WHERE CHAR_LENGTH(x.s) + 3 <= 20 OR FIND_IN_SET('39', x.s) > 0;

-- 4. 確認
--    ok_cards が target_cards と同じなら OK
SELECT COUNT(*) AS ok_cards
FROM cards c
JOIN cards_bak_20261008_loss_avoidance b ON b.id = c.id
WHERE FIND_IN_SET('39', c.effects) > 0;

--    39 が付かなかったカード (0 件であること。出たら手動で対応する)
SELECT c.id, c.name, b.effects AS before_effects, c.effects AS after_effects
FROM cards c
JOIN cards_bak_20261008_loss_avoidance b ON b.id = c.id
WHERE FIND_IN_SET('39', IFNULL(c.effects, '')) = 0
ORDER BY c.id;

--    全件の変更前後
SELECT c.id, c.name, b.effects AS before_effects, c.effects AS after_effects
FROM cards c
JOIN cards_bak_20261008_loss_avoidance b ON b.id = c.id
ORDER BY c.id;
