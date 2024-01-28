<?php

/**
 * ログを出力
 * @param string $fileNae 出力するログファイル名
 * @param string $message 出力するメッセージ
 * @return void
 */
function writeLog($fileName, $message)
{
    $now = date("Y/m/d H:i:s");
    $log = "{$now} {$message}\n";

    $fp = fopen($fileName, "a"); // aは追記モード
    fwrite($fp, $log);
    fclose($fp);
}
