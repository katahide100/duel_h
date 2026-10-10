-- =====================================================================
-- 20261008_add_loss_avoidance_effect.sql の事前確認 (読み取りのみ・何度実行してもよい)
-- =====================================================================

SET NAMES utf8;

-- 実行済みかどうか (1 行出たら実行済み。パッチ本体は流さない)
SHOW TABLES LIKE 'cards_bak_20261008_loss_avoidance';

-- 対象件数 (目安: 38 件。少なければ下の「見つからないカード名」を確認する)
--   has_39: 39 が既にあるカード (目安: 0 件) / too_long: 20 文字を超えて更新できないカード (目安: 0 件)
SELECT COUNT(*) AS target_cards,
       SUM(FIND_IN_SET('39', IFNULL(effects, '')) > 0) AS has_39,
       SUM(FIND_IN_SET('39', IFNULL(effects, '')) = 0
           AND CHAR_LENGTH(TRIM(BOTH ',' FROM IFNULL(effects, ''))) + 3 > 20) AS too_long
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

-- 見つからないカード名 (0 件であること。出たら DB のカード名の表記を確認する)
--   ※ モモキングｰMAX の「ｰ」は半角カタカナの長音 (U+FF70)、”血煙” の引用符は全角 (U+201D)。
--     どちらも card1.txt / duel-next の cards.json と同じ文字。エディタで置き換えないこと
SELECT t.name AS missing_name
FROM (
  SELECT '剛勇王機フルメタル・レモン' AS name
  UNION ALL SELECT '光姫聖霊ガブリエラ' AS name
  UNION ALL SELECT 'メッチャ無敵なじーさん' AS name
  UNION ALL SELECT '20thSP じーさん' AS name
  UNION ALL SELECT '不敗のダイハード・リュウセイ' AS name
  UNION ALL SELECT '「必然」の頂 リュウセイ / 「オレの勝利だオフコース！」' AS name
  UNION ALL SELECT '頂天聖 レオザワルド' AS name
  UNION ALL SELECT '奇天烈X グランドダイス' AS name
  UNION ALL SELECT '”血煙” マキシマム' AS name
  UNION ALL SELECT '始虹帝 ミノガミ' AS name
  UNION ALL SELECT '大魔王 ウラギリダムス' AS name
  UNION ALL SELECT '「是空」の鬼 ゲドウ権現' AS name
  UNION ALL SELECT '一王伝双三眼槍' AS name
  UNION ALL SELECT '一王二命三眼槍の封' AS name
  UNION ALL SELECT '覇王ノワールモナーク' AS name
  UNION ALL SELECT '炎怒の夜 アゲブロム' AS name
  UNION ALL SELECT '怒像アゲ' AS name
  UNION ALL SELECT '邪闘 デンジャラシス' AS name
  UNION ALL SELECT '永炎の竜凰 ボルシャック・バクスザク' AS name
  UNION ALL SELECT 'ボルシャック・ボルバルザーク' AS name
  UNION ALL SELECT 'ボルシャック・ヴォルジャアク' AS name
  UNION ALL SELECT '聖霊王ドリーム・アルカディアス' AS name
  UNION ALL SELECT 'E2連結 俺丸「ライバック」' AS name
  UNION ALL SELECT 'RinRin Kids' AS name
  UNION ALL SELECT 'ジョニー-MAX' AS name
  UNION ALL SELECT 'モモキングｰMAX' AS name
  UNION ALL SELECT 'MAX・ザ・ジョニー' AS name
  UNION ALL SELECT 'SUPREME-GUN・ザ・ジョニー' AS name
  UNION ALL SELECT 'Code:-MAX' AS name
  UNION ALL SELECT 'ゲンム-MAX' AS name
  UNION ALL SELECT 'ブランド-MAX' AS name
  UNION ALL SELECT 'バラギアラ-MAX' AS name
  UNION ALL SELECT 'MAX-Gジョラゴン' AS name
  UNION ALL SELECT 'サッヴァーク-MAX' AS name
  UNION ALL SELECT 'CRYMAX ジャオウガ' AS name
  UNION ALL SELECT 'CRY-S-MAX ジャオウガ' AS name
  UNION ALL SELECT '「亜堕無」-鬼MAX' AS name
  UNION ALL SELECT 'EVE-鬼MAX' AS name
) t
LEFT JOIN cards c ON c.name = t.name
WHERE c.id IS NULL;

-- 対象カード一覧
SELECT id, name, effects
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
)
ORDER BY id;
