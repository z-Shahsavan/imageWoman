<?php

class newpass extends Controller {

    function __construct() {
        parent::__construct();
    }

    public $idus;

    public function index() {

        if (Session::get('activecod') == 20) {
            $cond = 'mobile=:mobile';
            $condata = array('mobile' => Session::get('mobile'));
            $result = $this->model->selectusername($cond, $condata);
            if ($result) {
                $row = $result->fetch();
                $str = '<label for="password">نام کاربری:' . $row['username'] . '</label>';
            }
            $this->data['[VARUSER]'] = $str;
            $this->view->render('newpass/index', $this->data);
        } else {
            header('location:' . URL . 'index#loginlink');
        }
    }

    public function newpass() {
        $fields = array('password', 'confrim');
        $msgid = 0;
        $msgtext = '';
        if (Checkform::checkset($_POST, $fields)) {
            if (Checkform::checknotempty($_POST, $fields)) {
                if (strlen(trim($_POST['password'])) < 6) {
                    //password is very small
                    $data = array('id' => '0', 'msg' => 'رمز عبور حداقل باید 6 کاراکتر باشد');
                    $data = json_encode($data);
                    $this->view->render('newpass/index', $data, false, 0);
                    return FALSE;
                }
                if (Checkform::isspecial($_POST['password'], 2) == FALSE) {
                    //password is not secure
                    $data = array('id' => '0', 'msg' => 'رمز عبور انتخابی شما امنیت پایینی دارد');
                    $data = json_encode($data);
                    $this->view->render('newpass/index', $data, false, 0);
                    return FALSE;
                }
            
            
            if (strcmp(md5(trim($_POST['password'])), md5(trim($_POST['confrim']))) == 0) {
                $cond = 'mobile=:mobile';
                $condata = array('mobile' => Session::get('mobile'));
                $updata['password'] = md5(trim($_POST['password']));
                $userid = $this->model->editregister($updata, $cond, $condata);
                $msgid = 1;
            } else {
                //pass and confirm not equal
                $msgid = 0;
                $msgtext = 'رمز عبور با تکرار آن برابر نیست';
            }
        } else {
            $msgid = 0;
            $msgtext = 'لطفا همه موارد را وارد نمایید';
        }
        } else {
            $msgid = 0;
            $msgtext = 'لطفا همه موارد را وارد نمایید';
        }
        $data = array('id' => $msgid, 'msg' => $msgtext);
        $data = json_encode($data);
        $this->view->render('newpass/index', $data, false, 0);
        return FALSE;
    }

}
