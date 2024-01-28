<?php

// ファイルオープン
$fp = fopen(__DIR__ . "/input.csv", "r");

// ファイルを1行ずつ読み込み

$lineCount = 0;
$manCount = 0;
$womanCount = 0;
while ($data = fgetcsv($fp)) {
    $lineCount++;

    if ($lineCount === 1) {
        continue;
    }
    var_dump($data);

    if ($data[4] === "男性") {
        $manCount++;
    } else {
        $womanCount++;
    }
}

fclose($fp);

echo "$manCount, $womanCount";

// 出力ファイルへ
$fpOut = fopen(__DIR__ . "/output.csv","w");
// ヘッダー行へ書き込み
$header = ["男性", "女性"];
fputcsv($fpOut, $header);

$outputData = [$manCount, $womanCount];
fputcsv($fpOut, $outputData);

