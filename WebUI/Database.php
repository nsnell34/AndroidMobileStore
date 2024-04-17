<?php

class Database
{
    private $user = "nicholas.s.snell@undcsmysql";
    private $password = "nick5382";
    private $database = "nicholas_s_snell";
    private $host = "undcsmysql.mysql.database.azure.com";
    public $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

}