<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'newAPI');

class PdoConfig
{
    public $db;

    function __construct()
    {
         $db = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME.";port=3306", DB_USER, DB_PASSWORD);
         $db->exec("set character set utf8");
         $db->query("SET NAMES utf8");

         $this->db = $db;
    }
}
