<?php

require_once 'Database.php';


class DbTable extends Database
{
    protected string $table;

    protected function insert($data)
    {
        $sql = "INSERT INTO $this->table (" . implode(", ", array_keys($data)) . ") 
        VALUES('" . implode("', '", array_values($data)) . "')";
        if ($this->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    protected function select($data)
    {
        $condition = array();
        foreach ($data as $key => $value) {
            $condition[] = "{$key} = '{$value}'";
        }
        $condition = join(' AND ', $condition);

        $sql = "SELECT * FROM $this->table WHERE {$condition}";
        if ($this->conn->query($sql)) {
            $_SESSION['select-result'] = $this->conn->query($sql);
        } else {
            $_SESSION['select-result'] = '';
        }
    }

    protected function update($values, $ids)
    {
        $valueSets = array();
        foreach ($values as $key => $value) {
            $valueSets[] = $key . " = '" . $value . "'";
        }

        $conditionSets = array();
        foreach ($ids as $key => $value) {
            $conditionSets[] = $key . " = '" . $value . "'";
        }

        $sql = "UPDATE $this->table SET " . join(",", $valueSets) . " WHERE " . join(" AND ", $conditionSets);

        if ($this->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }

    protected function delete($data)
    {
        $condition = array();
        foreach ($data as $key => $value) {
            $condition[] = "{$key} = '{$value}'";
        }

        $condition = join(' AND ', $condition);
        $sql = "DELETE FROM $this->table WHERE {$condition}";
        if ($this->conn->query($sql)) {
            return true;
        } else {
            return false;
        }
    }
}