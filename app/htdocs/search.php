<?php

declare(strict_types=1);

require_once(dirname(__DIR__) . "/library/common.php");


$id = "";
$nameKana = "";
$gender = "";
$whereSql = "";
$param = [];
$errorMessage = "";
$successMessage = "";

// POST送信かつif文を押下する
if (mb_strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
    $isDelete = (isset($_POST["delete"]) && $_POST["delete"] === "1" ? true : false);

    if ($isDelete === true) {
        $deleteId = isset($_POST["id"]) ? $_POST["id"] : "";
        if (!validateRequired($deleteId)) {
            $errorMessage .= "社員番号が不正です. <br>";
        } else if (!validateId($deleteId)) {
            $errorMessage .= "社員番号が不正です. <br>";
        } else { //不正じゃない場合社員番号のチェック
            if (!Users::isExists($deleteId)) {
                $errorMessage .= "社員番号が不正です。<br>";
            }
        }

        if ($errorMessage === "") {
            // トランザクション開始
            DataBase::beginTransaction();
            // 社員情報削除
            Users::deleteById($deleteId);

            // commit
            DataBase::commit();
            $successMessage = "削除完了しました。<br>";
        } else {
            // エラー有
            echo $errorMessage;
        }
    }
}

$param = [];

// 変数の初期化
$id = isset($_GET["id"]) ? $_GET["id"] : "";
$nameKana = isset($_GET["name"]) ? $_GET["name"] : "";
$gender = isset($_GET["gender"]) ? $_GET["gender"] : "";



//件数取得SQL
$count = Users::searchCount($id, $nameKana, $gender);


//社員情報取得SQL
$data = Users::searchData($id, $nameKana, $gender);

$title = "社員検索";

require_once(TEMPLATE_DIR . "search.php");
