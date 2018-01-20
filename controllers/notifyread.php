<?php

class notifyread extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::access_control('isuser', 'index#loginlink', 1);
    }

    public function index() {
        $this->loadnotspg();
        $this->view->render('notifyread/index', $this->data);
    }
    
    public function loadnotspg() {
        $notlist = '';
        $nots = $this->model->loadnots();
        if ($nots) {
            while ($not = $nots->fetch()) {
                if ($not['status'] == 0) {
                        $notlist.='<tr class="tablenotificationunread deep-purple darken-1 notifipointer" id="'.$not['id'].'_notify_row" data-id="'.$not['id'].'" data-link="'.URL.$not['href'].'">
                        <td>'.$not['text'].'</td>
                        <td dir="rtl">'.$not['date'].'</td>
                    </tr>';
                }  else {
                    $notlist.='<tr class="tablenotificationread deep-purple lighten-5 notifipointer" id="'.$not['id'].'_notify_row" data-id="'.$not['id'].'" data-link="'.URL.$not['href'].'">
                        <td>'.$not['text'].'</td>
                        <td dir="rtl">'.$not['date'].'</td>
                    </tr>';
                }
            }
        }
        $this->data['[VARDATANOTIFY]']=$notlist;
    }

}
