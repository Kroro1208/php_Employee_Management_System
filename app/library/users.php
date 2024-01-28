<?php

declare(strict_types=1);
require_once(LIBRARY_DIR . "database.php");


class Users
{
    /**
     * 社員番号をkeyにして社員が存在するか確認
     */

    public static function isExists(string $id): bool
    {
        $sql = "SELECT COUNT(*) AS count FROM users WHERE id = :id";
        $param = ["id" => $id];
        $count = DataBase::fetch($sql, $param);
        if ($count["count"] >= 1) {
            return true;
        } else {
            return false;
        }
    }

    // 社員番号をkeyにして社員情報を取得

    public static function getById(string $id): array
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $param = ["id" => $id];
        return DataBase::fetch($sql, $param);
    }

    public static function deleteById(string $id): bool
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $param = ["id" => $id];
        return DataBase::execute($sql, $param);
    }

    // 検索条件にヒットした社員件数を取得

    public static function searchCount(string $id, string $nameKana, string $gender)
    {
        list($whereSql, $param) = self::getSearchWhereSqlAndParam($id, $nameKana, $gender);
        $sql = "SELECT COUNT(*) AS count FROM users WHERE 1 = 1 {$whereSql}";
        $count = DataBase::fetch($sql, $param);
        return $count["count"];
    }

    // 検索条件にヒットした社員情報を取得
    public static function searchData(string $id, string $nameKana, string $gender): array
    {
        list($whereSql, $param) = self::getSearchWhereSqlAndParam($id, $nameKana, $gender);
        $sql = "SELECT * FROM users WHERE 1 = 1 {$whereSql} ORDER BY id";
        return DataBase::fetchAll($sql, $param);
    }


    public static function insert(
        string $id,
        string $name,
        string $nameKana,
        string $birthday,
        string $gender,
        string $organization,
        string $post,
        string $startDate,
        string $tel,
        string $mailAddress
    ): bool {
        $sql = "INSERT INTO users (";
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
        $sql .= ") VALUES (";
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
        $sql .= " NOW(), ";
        $sql .= " NOW() ";
        $sql .= ")";

        $param = [
            "id" => $id,
            "name" => $name,
            "name_kana" => $nameKana,
            "birthday" => $birthday,
            "gender" => $gender,
            "organization" => $organization,
            "post" => $post,
            "start_date" => $startDate,
            "tel" => $tel,
            "mail_address" => $mailAddress
        ];
        return DataBase::execute($sql, $param);
    }

    public static function update(
        string $id,
        string $name,
        string $nameKana,
        string $birthday,
        string $gender,
        string $organization,
        string $post,
        string $startDate,
        string $tel,
        string $mailAddress
    ): bool {
        $sql = "UPDATE users ";
        $sql .= "SET name = :name, ";
        $sql .= " name_kana = :name_kana, ";
        $sql .= " birthday = :birthday, ";
        $sql .= " gender = :gender, ";
        $sql .= " organization = :organization, ";
        $sql .= " post = :post, ";
        $sql .= " start_date = :start_date, ";
        $sql .= " tel = :tel, ";
        $sql .= " mail_address = :mail_address ";
        $sql .= "WHERE id = :id";

        $param = [
            "id" => $id,
            "name" => $name,
            "name_kana" => $nameKana,
            "birthday" => $birthday,
            "gender" => $gender,
            "organization" => $organization,
            "post" => $post,
            "start_date" => $startDate,
            "tel" => $tel,
            "mail_address" => $mailAddress
        ];
        return DataBase::execute($sql, $param);
    }

    public static function getSearchWhereSqlAndParam(string $id, string $nameKana, string $gender): array
    {
        $whereSql = "";
        $param = [];

        if ($id !== "") {
            $whereSql .= "AND id = :id";
            $param["id"] = $id;
        }

        if ($nameKana !== "") {
            $whereSql .= "AND name_kana LIKE :name_kana";
            $param["name_kana"] = $nameKana . "%";
        }

        if ($gender !== "") {
            $whereSql .= "AND gender = :gender";
            $param["gender"] = $gender;
        }
        return [$whereSql, $param];
    }
}
