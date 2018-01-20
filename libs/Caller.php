<?php
class Caller {
    public static function sms($recnumber,$actcode){
        require("external/WebServiceSample.php");
        $wsObj = new WebServiceSample();
        $wsObj->simpleEnqueueSample($recnumber,$actcode);
    }
    
    public static function deact($recnumber,$actcode){
        require("external/WebServiceSample.php");
        $wsObj = new WebServiceSample();
        $wsObj->deact($recnumber,$actcode);
    }
    
    public static function forgotsms($recnumber,$actcode){
        require("external/WebServiceSample.php");
        $wsObj = new WebServiceSample();
        $wsObj->forgotpass($recnumber,$actcode);
    }
    public static function changemob($recnumber,$actcode){
        require("external/WebServiceSample.php");
        $wsObj = new WebServiceSample();
        $wsObj->changemob($recnumber,$actcode);
    }
}
