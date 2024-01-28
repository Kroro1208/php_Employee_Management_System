<?php

declare(strict_types=1);

// シングルトンパターン
class DataBase
{
    private static PDO $pdo;

    private function __construct()
    {
    }

    private static function getInstance(): PDO
    {
        if (!isset(self::$pdo)) {
            self::$pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8",
                DB_USER,
                DB_PASS
            );
        }
        return self::$pdo;
    }

    public static function beginTransaction(): void
    {
        if (self::getInstance()->inTransaction()) { // inTransactionは組み込みメソッド(beginTransaction()が呼び出されているかどうかをチェックする)
            return;
        }
        self::getInstance()->beginTransaction();
    }


    public static function commit(): void
    {
        if (!self::getInstance()->inTransaction()) {
            return;
        }
        self::getInstance()->commit();
    }

    public static function rollback(): void
    {
        if (!self::getInstance()->inTransaction()) {
            return;
        }
        self::getInstance()->rollBack();
    }

    // SQL実行の取得結果が1行以上の場合
    // fetch,fetchAllはselect文用
    public static function fetch(string $sql, array $param = []): array
    {
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($param);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // SQL実行の取得結果が2行以上の場合
    public static function fetchAll(string $sql, array $param = []): array
    {
        $stmt = self::getInstance()->prepare($sql);
        $stmt->execute($param);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // executeはinsert, update, delete用
    public static function execute(string $sql, array $param = []): bool
    {
        $stmt = self::getInstance()->prepare($sql);
        return $stmt->execute($param); // クエリの実行が成功したかどうかを真偽値で返す
    }
}
