<?php

class reactiv extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->render('reactiv/index', $this->data);
    }

    public function sendpass() {
        $fields = array('mobile', 'captcha_code');
        $msgid = 0;
        $msgtext = '';
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                if (strcmp(md5($_POST['captcha_code']), $_SESSION['random_txt']) == 0) {
                    $cond = 'mobile=:mobile';
                    $condata = array('mobile' => $_POST['mobile']);
                    $result = $this->model->selectuid($cond, $condata);
                    if ($result) {
                        $row = $result->fetch();
                        $id = $row['id'];
                        $cond = 'userid=:userid';
                        $condata = array('userid' => $row['id']);
                        $res = $this->model->selectuser($cond, $condata);
                        if ($res) {
                            $row = $res->fetch();
                            if (time() > $row['activtime'] + 120) {
                                $actcode = Utilities::random(6);
                                $recnumber = $_POST['mobile'];
                                Caller::sms($recnumber, $actcode);
                                $cond = 'userid=:userid';
                                $condata = array('userid' => $id);
                                $data = array('activecode' => md5($actcode));
                                $this->model->updatenewpass($data, $cond, $condata);
                                $msgid = 1;
                            } else {
                                $msgid = 2;
                                $msgtext = 'شما به تازگی درخواست کد داده اید';
                            }
                        } else {
                            $cond = 'mobile=:mobile';
                            $condata = array('mobile' => $_POST['mobile']);
                            $res = $this->model->selectuid($cond, $condata);
                            if ($res) {
                                $row = $res->fetch();
                                if ($row['confirm'] == 0) {
                                    $actcode = Utilities::random(6);
                                    $recnumber = $_POST['mobile'];
                                    Caller::sms($recnumber, $actcode);
                                    $data = array('userid' => $row['id'], 'activecode' => md5($actcode), 'activtime' => time());
                                    $this->model->insertnewactive($data);
                                    $msgid = 1;
                                } else {
                                    $msgid = 0;
                                    $msgtext = 'حساب کاربری شما فعال است';
                                }
                            }
                        }
                    } else {
                        $msgid = 0;
                        $msgtext = 'شماره موبایل وجود ندارد';
                    }
                } else {
                    $msgid = 0;
                    $msgtext = 'کد امنیتی صحیح نیست';
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
        $this->view->render('forgot/index', $data, false, 0);
        return FALSE;
    }

}
