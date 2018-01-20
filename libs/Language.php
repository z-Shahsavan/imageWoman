<?php
class Language {
    public static function reqlanguage($string=null){
        if(isset($_COOKIE['lang']) && file_exists('language/'.$_COOKIE['lang'].'.php')){
            require_once 'language/'.$_COOKIE['lang'].'.php';
        }else{
            require_once 'language/'.DEFAULT_LANGUAGE.'.php';
        }
        if($string==null){
            return $lng;
        }else{
            return $lng[$string];
        }
    }
    public static function selectedlanguage(){
        if(isset($_COOKIE['lang']) && file_exists('language/'.$_COOKIE['lang'].'.php')){
            return $_COOKIE['lang'];
        }else{
             return DEFAULT_LANGUAGE;
        }
    }
    public static function listlanguage(){
        $list= array_slice(scandir('language'),2);
        $opt='';
        $selectedlang=  self::selectedlanguage();
        $gemble='fstlng';
        foreach ($list as $value) {
            $value=  explode('.', $value);
            if($value[0]==$selectedlang){
               $selected='activemnu'; 
            }else{
                $selected='';
            }
            $opt.='<li class="left lnglnk '.$gemble.' '.$selected.'"><a href="#" onclick="selectlanguage(\''.$value[0].'\')" ><i class="mdi-action-language left"></i>[LNG'.$value[0].']</a></li>';
            $gemble='';
        }
        return $opt;
}
public static function listlanguagees(){
        $list= array_slice(scandir('language'),2);
        $opt='';
        $selectedlang=  self::selectedlanguage();
        $gemble='';
        foreach ($list as $value) {
            $value=  explode('.', $value);
            if($value[0]==$selectedlang){
               $selected='activemnu'; 
            }else{
                $selected='';
            }
            $opt.='<li class="left lnglnk '.$gemble.' '.$selected.'"><a href="#" onclick="selectlanguage(\''.$value[0].'\')" ><i class="mdi-action-language left"></i>[LNG'.$value[0].']</a></li>';
            $gemble='';
        }
        return $opt;
}
    }
