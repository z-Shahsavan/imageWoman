<?php
class Cache {
    public static function makecache($page,$data,$cache=0){
        if($cache>0){
            file_put_contents('cache/'.$page.'.php', $data);
        }
    }
    public static function getcache($page){
        $deafultstyle=Style::reqstyle();
        if(file_exists('cache/' . $page.'_'.$deafultstyle . '.php')){
                    if(filemtime('cache/' . $page.'_'.$deafultstyle . '.php')+CACHETIME>=  time()){
                        echo file_get_contents('cache/' . $page.'_'.$deafultstyle . '.php');
                        return TRUE;
                    }else{
                        unlink('cache/' . $page.'_'.$deafultstyle . '.php');
                        return FALSE;
                    }
                }else{
                    return FALSE;
                }
    }
}
