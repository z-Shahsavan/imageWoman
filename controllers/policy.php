<?php

class policy extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->loadrules();
        $this->view->render('policy/index', $this->data);
    }

    public function loadrules() {
        $rulist = '';
        $rows = $this->model->loadrules();
        $in='in';
        if ($rows) {
            $i=0;
            while ($row = $rows->fetch()) {
                $rulist .='<div class="panel panel-default">
      <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$i.'">
        <h4 class="panel-title">
          <a class="nonedecoration">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['rules'])) . '</a>
        </h4>
      </div>
      <div id="collapse'.$i.'" class="panel-collapse collapse '.$in.'">
        <div class="panel-body">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '</div>
      </div>
    </div>';
//                $rulist .= '<h6 class="teal-text text-darken-4">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['rules'])) . '</h6>
//                <p class="grey-text text-darken-3 justify">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '</p>
//                <div class="divider"></div>';
                $i++;
                $in='';
            }
             $this->data['[VARRULES]'] = $rulist;
        }
       
    }

}
