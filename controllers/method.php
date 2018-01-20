<?php

class method extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->loadmethod();
        $this->view->render('method/index', $this->data);
    }

    public function loadmethod() {
        $txt = '';
		$result = $this->model->loadmethod();
        if($result){
        while ($row = $result->fetch()) {
            $txt.='<h6 class="teal-text text-darken-4">'.$row['ruls'].'</h6>
                <p class="grey-text text-darken-3 justify">'.str_replace(PHP_EOL, '<br>',htmlspecialchars($row['message'])).' </p>';
        }
        }
           $this->data["[VARMETHOD]"] = $txt;
    }

}
