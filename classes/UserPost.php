<?php

require_once 'DbTable.php';

class UserPost extends DbTable{

    protected string $table = 'post';

    function save ($data){
        if ($this->insert($data)) {
            return true;
        } else {
            return false;
        }
    }

    function getPosts($data){
        $this->select($data);
    }

    function remove($data){
        if($this->delete($data)){
            return true;
        } else {
            return false;
        }
    }

}
