<?php
session_start();
class DB
{
    static $db = null;
    static function __callStatic($name, $arguments)
    {
        self::$db ??= new PDO("mysql:host=localhost;dbname=C_Module;charset=utf8mb4;", "root", "", [19 => 2, 3 => 2]);
        return match ($name) {
            "exec" => self::$db->exec($arguments[0]),
            "fetch" => self::$db->query($arguments[0])->fetch(),
            "fetchAll" => self::$db->query($arguments[0])->fetchAll(),
        };
        throw new \Exception('Not implemented');
    }
}
