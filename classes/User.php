<?php

require_once 'DbTable.php';

class User extends DbTable
{
    protected string $table = "user";

    function save($data)
    {
        if ($this->insert($data)) {
            return true;
        } else {
            return false;
        }
    }

    function login($data)
    {
        $this->select($data);
    }
}