<?php

class Database
{
    public object $conn;

    function __construct()
    {
        $this->conn = new mysqli('localhost', 'root', '', 'login');
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    function __destruct()
    {
        $this->conn->close();
    }
}