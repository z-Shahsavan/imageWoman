<?php

class Outputformat {

    public static function orginalformatdate($date) {
        $day = substr($date, 6);
        $month = substr($date, 4, 2);
        $year = substr($date, 0, 4);
        $orgdate = $year . '/' . $month . '/' . $day;
        return $orgdate;
    }

    public static function formatMoney($number, $fractional = false) {
        if ($fractional) {
            $number = sprintf('%.2f', $number);
        }
        while (true) {
            $replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
            if ($replaced != $number) {
                $number = $replaced;
            } else {
                break;
            }
        }
        return $number;
    }

}
