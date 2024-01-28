<?php

require_once("library/log.php");
$logFile = __DIR__ . "/log/import_user.log";
writeLog($logFile, "社員情報バッチ開始");
$dataCount = 0;

try {
    // データベース接続
    $username = "udemy_user";
    $password = "udemy_pass";
    $hostname = "db";
    $db = "udemy_db";
    $pdo = new PDO("mysql:host={$hostname};dbname={$db};charset=utf8", $username, $password);

    // 社員情報CSV情報オープン
    $fp = fopen(__DIR__ . "/import_users.csv", "r");

    // トランザクション
    $pdo->beginTransaction();
    // ファイルを1行ずつ読み込み
    while ($data = fgetcsv($fp)) {

        // 社員番号をキーにして社員情報取得
        $sql = "SELECT COUNT(*) AS count FROM users WHERE id = :id";
        $params = [":id" => $data[0]];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // debug
        // var_dump($data[0]);
        // var_dump($result);

        // SQLの結果は0件?
        if ($result["count"] === "0") {
            // 社員情報更新SQL実行
            $sql = "INSERT INTO users ( ";
            $sql .= " id, ";
            $sql .= " name, ";
            $sql .= " name_kana, ";
            $sql .= " birthday, ";
            $sql .= " gender, ";
            $sql .= " organization, ";
            $sql .= " post, ";
            $sql .= " start_date, ";
            $sql .= " tel, ";
            $sql .= " mail_address, ";
            $sql .= " created, ";
            $sql .= " updated ";
            $sql .= ") VALUES ( ";
            $sql .= " :id, ";
            $sql .= " :name, ";
            $sql .= " :name_kana, ";
            $sql .= " :birthday, ";
            $sql .= " :gender, ";
            $sql .= " :organization, ";
            $sql .= " :post, ";
            $sql .= " :start_date, ";
            $sql .= " :tel, ";
            $sql .= " :mail_address, ";
            $sql .= " NOW(), "; // 登録日時
            $sql .= " NOW() "; // 更新日時
            $sql .= ")";
            // var_dump($data[0]);
            // var_dump("登録");
        } else {
            $sql = "UPDATE users ";
            $sql .= "SET name = :name, ";
            $sql .= "name_kana = :name_kana, ";
            $sql .= "birthday = :birthday, ";
            $sql .= "gender = :gender, ";
            $sql .= "organization = :organization, ";
            $sql .= "post = :post, ";
            $sql .= "start_date = :start_date, ";
            $sql .= "tel = :tel, ";
            $sql .= "mail_address = :mail_address, ";
            $sql .= "updated = NOW() "; //更新日時
            $sql .= "WHERE id = :id";
            // var_dump($data[0]);
            // var_dump("更新");
        }

        $param = array(
            "id" => $data[0],
            "name" => $data[1],
            "name_kana" => $data[2],
            "birthday" => $data[3],
            "gender" => $data[4],
            "organization" => $data[5],
            "post" => $data[6],
            "start_date" => $data[7],
            "tel" => $data[8],
            "mail_address" => $data[9],
        );
        $stmt = $pdo->prepare($sql);
        $stmt->execute($param);
        $dataCount++;
    }



    // 社員情報登録SQL実行

    // コミット
    $pdo->commit();

    // クローズ
    fclose($fp);
} catch (Exception $e) {
    $pdo->rollback();
    $dataCount = 0;
    writeLog($logFile, "エラーが発生しました" . $e->getMessage());
}

writeLog($logFile, "社員情報バッチ終了 [処理件数: {$dataCount}件]");
