<?php

require_once 'Database.php';
require_once 'Session.php';


class DbTable extends Database
{
    protected string $table;
    private $db;

    protected function insert($data)
    {
        $this->db = Database::getDbClass();
        $sql = "INSERT INTO $this->table (" . implode(", ", array_keys($data)) . ") 
        VALUES('" . implode("', '", array_values($data)) . "')";
        if ($this->db->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    protected function select($data)
    {
        $condition = array();
        $this->db = Database::getDbClass();
        foreach ($data as $key => $value) {
            $condition[] = "{$key} = '{$value}'";
        }
        $condition = join(' AND ', $condition);

        $sql = "SELECT * FROM $this->table WHERE {$condition}";
        if ($this->db->conn->query($sql)) {
            $row = $this->db->conn->query($sql);
            Session::set('select_result', $row);
        } else {
            Session::set('select_result', '');
        }
    }

    protected function update($values, $keys)
    {
        $valueSets = array();
        $this->db = Database::getDbClass();
        foreach ($values as $key => $value) {
            $valueSets[] = $key . " = '" . $value . "'";
        }

        $conditionSets = array();
        foreach ($keys as $key => $value) {
            $conditionSets[] = $key . " = '" . $value . "'";
        }

        $sql = "UPDATE $this->table SET " . join(",", $valueSets) . " WHERE " . join(" AND ", $conditionSets);

        if ($this->db->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    protected function delete($data)
    {
        $condition = array();
        $this->db = Database::getDbClass();
        foreach ($data as $key => $value) {
            $condition[] = "{$key} = '{$value}'";
        }

        $condition = join(' AND ', $condition);
        $sql = "DELETE FROM $this->table WHERE {$condition}";
        if ($this->db->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
}