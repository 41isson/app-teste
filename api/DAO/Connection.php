<?php
namespace DAO;

class Connection {
    public function getConnection() {
        $hostname = "localhost";
        $username = "root";
        $password = "";
        $database = "meteorologia";
        $port = 3306;

        $conn = new \mysqli($hostname, $username, $password, $database, $port);
        return $conn;
    }
}
