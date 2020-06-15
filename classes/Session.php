<?php

class Session {
    static function start (){
        session_start();
    }

    static function set($key, $value){
        $_SESSION[$key] = $value;
    }

    static function get($key){
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    static function destroy(){
        session_destroy();
    }
}