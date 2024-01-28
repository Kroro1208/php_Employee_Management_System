<?php

declare(strict_types=1);

require_once(dirname(__DIR__) . "/library/common.php");


$id = "";
$name = "";
$nameKana = "";
$birthday = "";
$gender = "";
$organization = "";
$post = "";
$startDate = "";
$tel = "";
$mailAddress = "";
$errorMessage = "";
$successMessage = "";
$isEdit = false;
$isSave = false;


if (mb_strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
    // var_dump($_POST);
    $id = isset($_POST["id"]) ? $_POST["id"] : "";
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $nameKana = isset($_POST["name_kana"]) ? $_POST["name_kana"] : "";
    $birthday = isset($_POST["birthday"]) ? $_POST["birthday"] : "";
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : "";
    $organization = isset($_POST["organization"]) ? $_POST["organization"] : "";
    $post = isset($_POST["post"]) ? $_POST["post"] : "";
    $startDate = isset($_POST["start_date"]) ? $_POST["start_date"] : "";
    $tel = isset($_POST["tel"]) ? $_POST["tel"] : "";
    $mailAddress = isset($_POST["mail_address"]) ? $_POST["mail_address"] : "";

    // trueであれば登録ボタンが押されたということ
    $isSave = isset($_POST["save"]) && $_POST["save"] === "1";

    // trueなら既存データの更新
    $isEdit = isset($_POST["edit"]) && $_POST["edit"] === "1";

    if ($isEdit === true && $isSave === false) {
        if (!validateRequired($id)) {
            $errorMessage .= "エラーが発生しました。もう一度やり直してください <br>";
        } else if (!validateId($id)) {
            $errorMessage .= "エラーが発生しました。もう一度やり直してください <br>";
        } else {
            // 存在する社員か
            if (!Users::isExists($id)) {
                $errorMessage .= "エラーが発生しました。もう一度やり直してください。<br>";
            }
        }

        if ($errorMessage === "") {
            $sql = "SELECT * FROM users WHERE id = :id";
            $param = array("id" => $id);
            $user = Users::getById($id);

            $id = $user["id"];
            $name = $user["name"];
            $nameKana = $user["name_kana"];
            $birthday = $user["birthday"];
            $gender = $user["gender"];
            $organization = $user["organization"];
            $post = $user["post"];
            $startDate = $user["start_date"];
            $tel = $user["tel"];
            $mailAddress = $user["mail_address"];
        } else {
            // エラー画面表示
            $title = "エラー";
            require_once(dirname(__DIR__) . "/template/error.php");
            exit; //処理終了
        }
    }


    // POSTされた社員番号のチェック
    if ($isSave === true) {
        if (!validateRequired($id)) {
            $errorMessage .= "社員番号を入力してください <br>";
        } else if (!validateId($id)) {
            $errorMessage .= "社員番号は6桁の数値で入力してください <br>";
        } else {
            // 最後のチェック。重複していないか
            $exists = Users::isExists($id);
            if ($isEdit === false && $exists) {
                $errorMessage .= "登録済みの社員番号です。 <br>";
            } else if ($isEdit === true && !$exists) {
                $errorMessage = "存在しない社員番号です。 <br>";
            }
        }

        if (!validateRequired($name)) {
            $errorMessage .= "社員名を入力してください <br>";
        } else if (!validateMaxLength($name, 50)) {
            $errorMessage .= "社員名は50文字以内で入力してください <br>";
        }

        if (!validateRequired($nameKana)) {
            $errorMessage .= "社員名カナを入力してください <br>";
        } else if (!validateMaxLength($nameKana, 50)) {
            $errorMessage .= "社員名カナは50文字以内で入力してください <br>";
        }

        if (!validateRequired($birthday)) {
            $errorMessage .= "生年月日を入力してください <br>";
        } else if (!validateDate($birthday)) {
            $errorMessage .= "生年月日を正しく入力してください <br>";
        }

        if (!validateGender($gender)) {
            $errorMessage .= "性別を選択してください <br>";
        }

        if (!validateOrganization($organization)) {
            $errorMessage .= "部署を洗濯してください <br>";
        }

        if (!validatePost($post)) {
            $errorMessage .= "役職を選択してください <br>";
        }

        if (!validateRequired($startDate)) {
            $errorMessage .= "入社年月日を入力してください <br>";
        } else if (!validateDate($startDate)) {
            $errorMessage .= "入社年月日を正しく入力して下さい <br>";
        }

        if (!validateRequired($tel)) {
            $errorMessage .= "電話番号を入力してください <br>";
        } else if (!validateTel($tel)) {
            $errorMessage .= "電話番号は15桁以内の数字を入力して下さい <br>";
        }

        if (!validateRequired($mailAddress)) {
            $errorMessage .= "メールアドレスを入力してください";
        } else if (!validateMailAddress($mailAddress)) {
            $errorMessage .= "メールアドレスを正しく入力して下さい <br>";
        }

        if ($errorMessage === "") {
            DataBase::beginTransaction();

            if ($isEdit === false) {
                // 新規登録
                // 社員登録SQL発行
                Users::insert(
                    $id,
                    $name,
                    $nameKana,
                    $birthday,
                    $gender,
                    $organization,
                    $post,
                    $startDate,
                    $tel,
                    $mailAddress,
                );
            } else {
                Users::update(
                    $id,
                    $name,
                    $nameKana,
                    $birthday,
                    $gender,
                    $organization,
                    $post,
                    $startDate,
                    $tel,
                    $mailAddress,
                );
            }

            DataBase::commit();

            $successMessage = "登録完了しました";
            $isEdit = true;
        }
    }
}

$title = "社員登録";

require_once(TEMPLATE_DIR . "input.php");
