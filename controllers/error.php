<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of error
 *
 * @author ST-1
 */

class error extends Controller {
    //put your code here
    function __construct() {
        parent::__construct();
    }
    public function index() {
        $this->view->render('error/index', $this->data);
    }
}

