#!/bin/bash
# species をマウントした cgi3/syu.txt から投入する(1 行 = 1 種族、行番号を no とする)。
# 空のままだと「保存」で syu.txt が空で上書きされてしまうため。
set -e

SRC=/seed/syu.txt
if [ ! -f "$SRC" ]; then
  echo "[species] $SRC not found, skipped"
  exit 0
fi

awk 'BEGIN { print "INSERT INTO `species` (`no`, `species_name`) VALUES" }
     { sub(/\r$/, ""); gsub(/\\/, "\\\\"); gsub(/\x27/, "\\\x27");
       printf "%s(%d, \x27%s\x27)", (NR > 1 ? ",\n" : ""), NR, $0 }
     END { print ";" }' "$SRC" \
  | mariadb -uroot -p"$MARIADB_ROOT_PASSWORD" "$MARIADB_DATABASE"

echo "[species] imported $(wc -l < "$SRC") rows from $SRC"
