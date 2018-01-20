<?php

class question extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load();
        $this->view->render('question/index', $this->data);
    }

    public function load() {
        $txt = '';
        $result = $this->model->load();
        $i=0;
         $in='in';
        if ($result) {
            while ($row = $result->fetch()) {
//            $txt .=' <p class="grey-text text-darken-3 justify">'.str_replace(PHP_EOL,'</br>',$row['question']).'</p>
//                <h6 class="teal-text text-darken-4">پاسخ :</h6>
//                <p class="teal-text text-darken-3 justify">'.str_replace(PHP_EOL,'</br>',$row['answer']).'</p>';
                $txt .=' <div class="panel panel-default">
    <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'">
        <h4 class="panel-title">
            <a class="nonedecoration">'.str_replace(PHP_EOL,'</br>',$row['question']).'</a>
        </h4>
    </div>
    <div id="collapse'.$i.'" class="panel-collapse collapse '.$in.'">
        <div class="panel-body">'.str_replace(PHP_EOL,'</br>',$row['answer']).'</div>
    </div>
</div>';
                $in='';
                $i++;
            }
            $this->data["[VARQUESTION]"] = $txt;
        }
        
    }

}
