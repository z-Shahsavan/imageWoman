<?php

class Bootstrap {

    function __construct() {
        $url = isset($_GET['url']) ? $_GET['url'] : 'index';
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $url = explode('/', $url);
        $parm = array_slice($url, 2);
        $path = 'controllers/' . $url[0] . '.php';
        if (file_exists($path)) {
            require($path);
            $controller = new $url[0]();
            $controller->loadmodel($url[0]);
        } else {
            $this->error($path.' Page not found!');
            die;
        }
        if (isset($url[1])) {
            if (method_exists($controller, $url[1])) {
                $numofparm = new ReflectionMethod($url[0], $url[1]);
                $numparm = $numofparm->getNumberOfRequiredParameters();
                if ($numparm <= count($parm)) {
                    call_user_func_array(array($controller, $url[1]), $parm);
                } else {
                    $this->error('Argument Missing!');
                }
            } else {
                $this->error('Function not exist!');
            }
        }else{
            if(Cache::getcache($url[0])){
                return;
            }else{
                $controller->index();
            }
            
            
        }
    }
    public function error($msg) {
        $errorcontroller='controllers/'.URL_ERROR.'.php';
        require($errorcontroller);
                    $controller = new error();
                    $errdata=array('[VAREROORMSG]'=>$msg);
                    $controller->index($errdata);
    }
}
