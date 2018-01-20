<?php
class Checkform {

    public static function checknotempty($data, $fields) {
        $res = TRUE;
        foreach ($fields as $val) {
            if (strcmp($data[$val], '') == 0) {
                $res = FALSE;
            }
        }
        if ($res == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function checkset($data, $fields) {
        $res = TRUE;
        foreach ($fields as $val) {
            if (!isset($data[$val])) {
                $res = FALSE;
            }
        }
        if ($res == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function isemail($str) {
        if (filter_var($str, FILTER_VALIDATE_EMAIL)) {
            return true;
        } else {
            return false;
        }
    }

    public static function isspecial($str, $cnt = 4) {
        $is_symbol = preg_match('/[+@#$%^&*!\?]/', $str);
        $is_numeric = preg_match('/[0-9]/', $str);
        $is_lchar = preg_match('/[a-z]/', $str);
        $is_uchar = preg_match('/[A-Z]/', $str);
        if ($is_symbol + $is_numeric + $is_lchar + $is_uchar < $cnt) {
            return false;
        } else {
            return true;
        }
    }

    public static function isinteger($str) {
        if (is_numeric($str)) {
            return true;
        } else {
            return false;
        }
    }

}
