<?php

class Style {
     public static function reqstyle(){
        if(isset($_COOKIE['style']) && file_exists('views/'.$_COOKIE['style'])){
            return $_COOKIE['style'];
        }else{
            return DEFAULT_STYLE;
        }
    }
    public static function liststyle(){
        $list= array_slice(scandir('views'),2);
        $opt='';
        $selectedstyle=  self::reqstyle();
        foreach ($list as $value) {
            $value=  explode('.', $value);
            if($value[0]==$selectedstyle){
               $selected='selected'; 
            }else{
                $selected='';
            }
            $opt.='<option value="'.$value[0].'" '.$selected.'>[LNG'.$value[0].']</option>';
        }
        return $opt;
}
}
