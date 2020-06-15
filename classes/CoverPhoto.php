<?php

require_once 'DbTable.php';

class CoverPhoto extends DbTable
{
    protected string $table = 'cover_photo';

    function save($data)
    {
        if ($this->insert($data)) {
            return true;
        } else {
            return false;
        }
    }

    function getCoverPhoto($data)
    {
        $this->select($data);
    }

    function edit($values, $keys)
    {
        if ($this->update($values, $keys)) {
            return true;
        } else {
            return false;
        }
    }

    function remove($data)
    {
        if($this->delete($data)){
            return true;
        } else {
            return false;
        }
    }

}