<?php

class adminabout extends Controller {

    function __construct() {

        parent::__construct();
        Useraccess::access_control('isuser', 'index#loginlink', 4);
    }

    public function index() {
        $this->load();
        $this->view->render('adminabout/index', $this->data);
    }

    public function load() {
        $result = $this->model->load();
        if ($result) {
            $row = $result->fetch();
            $this->data['[VARVALUEABOUT]'] = htmlspecialchars($row['aboutus']);
        }
    }

    public function editaboutus() {
        $data = array();
        $fields = array('comment');
        if (Checkform::checkset($_POST, $fields)) {

            if (Checkform::checknotempty($_POST, $fields)) {

                $data = array('aboutus' =>($_POST['comment']) );
                $this->model->editaboutus($data);
                $data = array('id' => '1', 'msg' => 'اطلاعات با موفقیت ثبت شد.');
                $data = json_encode($data);
                $this->view->render('adminupload/index', $data, false, 0);
            } else {
                $data = array('id' => '0', 'msg' => 'لطفا فیلدها را پر کنید.');
                $data = json_encode($data);
                $this->view->render('adminupload/index', $data, false, 0);
            }
        } else {
            $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
            $data = json_encode($data);
            $this->view->render('adminupload/index', $data, false, 0);
        }
    }

}
