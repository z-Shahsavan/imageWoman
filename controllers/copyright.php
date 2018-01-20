<?php

class copyright extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->loadcpy();
        $this->view->render('copyright/index', $this->data);
    }

    public function loadcpy() {
        $rulist = '';
        $rows = $this->model->loadcpy();
        if ($rows) {
            while ($row = $rows->fetch()) {
                $rulist .= '<h6 class="teal-text text-darken-4">' . htmlspecialchars($row['rules']). '</h6>
                <p class="grey-text text-darken-3 justify">' . htmlspecialchars( $row['comment']) . '</p>
                <div class="divider"></div>';
//                $rulist .= '<h6 class="teal-text text-darken-4">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['rules'])) . '</h6>
//                <p class="grey-text text-darken-3 justify">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '</p>
//                <div class="divider"></div>';
            }
        }
        $this->data['[VARCPYS]'] = $rulist;
    }

}
