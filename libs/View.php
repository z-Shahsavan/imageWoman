<?php

class View {

    public function render($name, $data = '', $cache = false, $showstyle = 1) {
        $jsaddr = '';
        if ($showstyle == 1) {
            $directpage = explode('/', $name);
            $pagename = substr($directpage[0], 0, 5);
            if ($pagename == 'admin') {
                $deafultstyle = Style::reqstyle();
                $cssaddr = '';
                $list = array_slice(scandir(URL_ADMINCSS), 2);
                foreach ($list as $value) {
                    $cssaddr.='<link href="' . URL . URL_ADMINCSS . $value . '" rel="stylesheet" type="text/css"/>' . PHP_EOL;
                }
                    $privcssaddr = 'views/' . $deafultstyle . '/' . $directpage[0] . '/css/';
                    if (file_exists($privcssaddr)) {
                        $list = array_slice(scandir($privcssaddr), 2);
                        foreach ($list as $value) {
                            $cssaddr.='<link href="' . URL . $privcssaddr . $value . '" rel="stylesheet" type="text/css"/>' . PHP_EOL;
                        }
                    }
                    $data['[VARCSSADDR]'] = $cssaddr;
                    $jsaddr = '';
                    $list = array_slice(scandir(URL_ADMINJS), 2);
                    foreach ($list as $value) {
                        $jsaddr.='<script src="' . URL . URL_ADMINJS . $value . '"></script>' . PHP_EOL;
                    }
                    $privjsaddr = 'views/' . $deafultstyle . '/' . $directpage[0] . '/js/';
                    if (file_exists($privjsaddr)) {
                        $list = array_slice(scandir($privjsaddr), 2);
                        foreach ($list as $value) {
                            $jsaddr.='<script src="' . URL . $privjsaddr . $value . '"></script>' . PHP_EOL;
                        }
                    }
//                }
                $rout['[VARJSADDR]'] = file_get_contents('publicadmin/rout.js') . $jsaddr;
                $data['[VARURL]'] = URL;
//	$data['[VARSITENAME]'] = SITE_NAME;
                $data['[VARIMGURL]'] = URL_ADMINIMG;
                $lang = Language::reqlanguage();
                $data['[VARLANGSLCT]'] = Language::listlanguage();
                $data['[VARSCLCEDLNG]'] = '[LNG' . Language::selectedlanguage() . ']';
                $data['[VARSTYLSLCT]'] = Style::liststyle();
                $data = array_merge($rout, $data, $lang);
                $viewfile = file_get_contents('views/' . $deafultstyle . '/header/headeradmin.php');
                $viewfile.= file_get_contents('views/' . $deafultstyle . '/' . $name . '.php');
                $viewfile .= file_get_contents('views/' . $deafultstyle . '/footer/footeradmin.php');
                $filetoview = str_replace(array_keys($data), array_values($data), $viewfile);
                $filetoview = preg_replace('/\[[A-Z]{4,}\]/', '', $filetoview);
                if ($cache != FALSE) {
                    Cache::makecache($directpage[0] . '_' . $deafultstyle, $filetoview, CACHETIME);
                }
                echo $filetoview;
            } else {
                $deafultstyle = Style::reqstyle();
                $cssaddr = '';
                $list = array_slice(scandir(URL_USERCSS), 2);
                foreach ($list as $value) {
                    $cssaddr.='<link href="' . URL . URL_USERCSS . $value . '" rel="stylesheet" type="text/css"/>' . PHP_EOL;
                }
                $directpage = explode('/', $name);
                $privcssaddr = 'views/' . $deafultstyle . '/' . $directpage[0] . '/css/';
                if (file_exists($privcssaddr)) {
                    $list = array_slice(scandir($privcssaddr), 2);
                    foreach ($list as $value) {
                        $cssaddr.='<link href="' . URL . $privcssaddr . $value . '" rel="stylesheet" type="text/css"/>' . PHP_EOL;
                    }
                }
                $data['[VARCSSADDR]'] = $cssaddr;
                $jsaddr = '';
                $list = array_slice(scandir(URL_USERJS), 2);
                foreach ($list as $value) {
                    $jsaddr.='<script src="' . URL . URL_USERJS . $value . '"></script>' . PHP_EOL;
                }
                $directpage = explode('/', $name);
                $privjsaddr = 'views/' . $deafultstyle . '/' . $directpage[0] . '/js/';
                if (file_exists($privjsaddr)) {
                    $list = array_slice(scandir($privjsaddr), 2);
                    foreach ($list as $value) {
                        $jsaddr.='<script src="' . URL . $privjsaddr . $value . '"></script>' . PHP_EOL;
                    }
                }
                $rout['[VARJSADDR]'] = file_get_contents('publicuser/rout.js') . $jsaddr;
                $data['[VARURL]'] = URL;
//	$data['[VARSITENAME]'] = SITE_NAME;
                $data['[VARIMGURL]'] = URL_USERIMG;
                $lang = Language::reqlanguage();
                $data['[VARLANGSLCT]'] = Language::listlanguage();
                $data['[VARSCLCEDLNG]'] = '[LNG' . Language::selectedlanguage() . ']';
                $data['[VARSTYLSLCT]'] = Style::liststyle();
                $data = array_merge($rout, $data, $lang);
                if($directpage[0]!='index'){
                    $viewfile = file_get_contents('views/' . $deafultstyle . '/header/headeruser.php');
                }  else {
                    $viewfile ="";
                }
                
                $viewfile.= file_get_contents('views/' . $deafultstyle . '/' . $name . '.php');
                $viewfile .= file_get_contents('views/' . $deafultstyle . '/footer/footeruser.php');
                $filetoview = str_replace(array_keys($data), array_values($data), $viewfile);
                $filetoview = preg_replace('/\[[A-Z]{4,}\]/', '', $filetoview);
                if ($cache != FALSE) {
                    Cache::makecache($directpage[0] . '_' . $deafultstyle, $filetoview, CACHETIME);
                }
                echo $filetoview;
            }
        } else {
            echo $data;
        }
    }

}
