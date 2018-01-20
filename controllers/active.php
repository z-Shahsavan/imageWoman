<?php

class active extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::guest_control('isuser');
    }

    public function index() {
        $this->view->render('active/index', $this->data);
    }

    public function active() {
        $fields = array('regactcode');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $result = $this->model->checkactcode(md5($_POST['regactcode']));
                if ($result != FALSE) {
                    $row = $result->fetch();
                    $this->model->deletecode(md5($_POST['regactcode']));
                    $this->model->makeuseractive($row['userid']);
                    $data = array('id' => '1', 'msg' => 'فعال سازی با موفقیت انجام شد','userid'=> $row['userid']);
                    $data = json_encode($data);
                    $this->view->render('login/index', $data, false, 0);
                } else {
                    //active code not rrue
                    $data = array('id' => '0', 'msg' => 'کد فعال سازی صحیح نمی باشد');
                    $data = json_encode($data);
                    $this->view->render('login/index', $data, false, 0);
                }
            } else {
                //all field rewier
                $data = array('id' => '0', 'msg' => 'لطفا کد فعالسازی را وارد کنید');
                $data = json_encode($data);
                $this->view->render('login/index', $data, false, 0);
            }
        } else {
            //all field rewier
            $data = array('id' => '0', 'msg' => 'لطفا کد فعالسازی را وارد کنید');
            $data = json_encode($data);
            $this->view->render('login/index', $data, false, 0);
        }
    }

}
