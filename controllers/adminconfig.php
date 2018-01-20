<?php

class adminconfig extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::access_control('isuser', 'index#loginlink', 4);
    }

    public function index() {
        $this->loadconfig();
        $this->view->render('adminconfig/index', $this->data);
    }

    public function loadconfig() {
        $result = $this->model->getsiteinf();
        $row = $result->fetch();
        $this->data['[VARSITENAME]'] = htmlspecialchars($row['sitename']);
        $this->data['[VARSITEADDRESS]'] =htmlspecialchars($row['address']) ;
        $this->data['[VARSITECACHEVAL]'] = htmlspecialchars($row['cashvalue']);
        if ($row['cashvalue'] > 0) {
            $this->data['[VARSITECACHEBTN]'] = 'checked="checked"';
        }
    }

    public function saveconfig() {
        $fields = array('sitename', 'siteaddress');

        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
//
//                //check file
                $res = Photoutil::logocheck('0');
                switch ($res) {
                    case 1:
                        //file not post
                        $data = array('id' => '0', 'msg' => 'لطفا تمامی موارد را وارد کنید.');
                        $data = json_encode($data);
                        $this->view->render('adminconfig/index', $data, false, 0);
                        return;
                        break;
                    case 2:
                        //mimetype not true
                        $data = array('id' => '0', 'msg' => 'نوع فایل مجاز نیست.');
                        $data = json_encode($data);
                        $this->view->render('adminconfig/index', $data, false, 0);
                        return;
                        break;
                    case 3:
                        //image is corrupted
                        $data = array('id' => '0', 'msg' => 'فایل بارگذاری شده دارای مشکل است.');
                        $data = json_encode($data);
                        $this->view->render('adminconfig/index', $data, false, 0);
                        return;
                        break;
                }
                //require cash
                if ($_POST['ischach'] == 'yes') {
                    if (isset($_POST['cachtime']) && strcmp($_POST['cachtime'], '') != 0) {
                        $data = array('cashvalue' => $_POST['cachtime']);
                    }
                } else {
                    $data = array('cashvalue' => 0);
                }
                //save site
                $data['sitename'] = ($_POST['sitename']);
                $data['address'] = ($_POST['siteaddress']);
                $this->model->savesite($data);
                Photoutil::savesitelogo(0);
                $data = array('id' => '1', 'msg' => 'اطلاعات با موفقیت ثبت شد.');
                $data = json_encode($data);
                $this->view->render('adminconfig/index', $data, false, 0);
            } else {
                //all field requier
                $data = array('id' => '0', 'msg' => 'لطفا تمام فیلدها را پر کنید.');
                $data = json_encode($data);
                $this->view->render('adminconfig/index', $data, false, 0);
            }
        } else {
            //all field requier
            $data = array('id' => '0', 'msg' => 'لطفا تمام فیلدها را پر کنید.');
            $data = json_encode($data);
            $this->view->render('adminconfig/index', $data, false, 0);
        }
    }

}
