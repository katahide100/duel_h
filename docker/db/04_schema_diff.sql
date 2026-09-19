-- 2014 年のダンプ (export_table_20140913.sql) 以降にコード側で追加されたカラム/テーブルを補う。
-- 定義はコードの参照箇所から割り出したもの(本番と型が完全一致する保証はない)。

-- 表示順 (PartsController / PacksController が rank で並べる)
ALTER TABLE `parts` ADD COLUMN `rank` int DEFAULT NULL;
ALTER TABLE `packs` ADD COLUMN `rank` int DEFAULT NULL;
UPDATE `parts` SET `rank` = `id`;
UPDATE `packs` SET `rank` = `id`;

-- 種族 (Species / PartsController の Specie モデル。no 順に cgi3/syu.txt へ書き出される)
CREATE TABLE IF NOT EXISTS `species` (
  `id` int NOT NULL AUTO_INCREMENT,
  `no` int DEFAULT NULL,
  `species_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
