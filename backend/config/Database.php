<?php
namespace Config;

class Database
{
    /** @var \mysqli */
    private static $pdo = null;

    /**
     * Returns a shared mysqli connection.
     * Creates it on first call, reuses thereafter.
     */
    public static function getConnection(): \mysqli
    {
        if (self::$pdo === null) {
            // your DB credentials
            $host = "localhost";
            $user = "root";
            $pass = "";
            $db   = "echo";

            self::$pdo = new \mysqli($host, $user, $pass, $db);
            if (self::$pdo->connect_error) {
                // fail fast
                die("DB connection failed: " . self::$pdo->connect_error);
            }
            // optional: set charset
            self::$pdo->set_charset("utf8mb4");
        }
        return self::$pdo;
    }
}
?>
