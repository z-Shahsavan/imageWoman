<?php

class Session {
    private static function init(){
        @session_start();
        session_set_cookie_params ( '0' , '/' , URL , false ,  TRUE );
//        session_regenerate_id(true);
    }
    public static function set($key,$value){
        self::init();
        $_SESSION[$key]=$value;
    }
    public static function get($key){
        self::init();
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }else{
            return false;
        }
    }
    public static function destroy(){
        self::init();
        session_destroy();
    }
}
