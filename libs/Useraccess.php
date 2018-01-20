<?php

class Useraccess {

    public static function access_control($seskey, $page = NULL, $role = NULL) {
        if (is_null($role)) {
            $login = Session::get($seskey);
            if ($login == FALSE) {
                Session::destroy();
                $topage = (is_null($page) ? 'index' : $page);
                header('location: ' . URL . $topage);
                exit();
            }
        } else {
            $login = Session::get($seskey);
            if ($login == FALSE) {
                Session::destroy();
                $topage = (is_null($page) ? 'index' : $page);
                header('location: ' . URL . $topage);
                exit();
            } else {
                if ($role > $login) {
                    $topage = (is_null($page) ? 'index' : $page);
                    header('location: ' . URL . $topage);
                     exit();
                }
            }
        }
    }

    public static function must_access($seskey, $page = NULL, $role = NULL) {
        $login = Session::get($seskey);
        if ($login == FALSE) {
            Session::destroy();
            $topage = (is_null($page) ? 'index' : $page);
            header('location: ' . URL . $topage);
           exit();
        } else {
            if ($role != $login) {
                $topage = (is_null($page) ? 'index' : $page);
                header('location: ' . URL . $topage);
                  exit();
            }
        }
    }

    public static function guest_control($seskey, $page = NULL) {
        $login = Session::get($seskey);
        if ($login != FALSE) {
            $topage = (is_null($page) ? 'index' : $page);
            header('location: ' . URL . $topage);
              exit();
        }
    }

}
