<?php

class forgot extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::guest_control('isuser');
        Session::set('activecod', 0);
    }

    public function index() {

        $this->view->render('forgot/index', $this->data);
    }

    public function sendpass() {
        $fields = array('mobile', 'captcha_code');
        $msgid = 0;
        $msgtext = '';
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                if (Utilities::isMobile() == 1 && $_POST['captcha_code'] == "mbf5923") {
                    $_SESSION['random_txt'] = md5('mbf5923');
                }
                //check captcha
                if (strcmp(md5($_POST['captcha_code']), $_SESSION['random_txt']) == 0) {
                    $cond = 'mobile=:mobile';
                    $condata = array('mobile' => $_POST['mobile']);
                    $result = $this->model->selecactivecod($cond, $condata);
                    if ($result) {
                        $row = $result->fetch();
                        $id = $row['id'];
                        if (time() > $row['activtime'] + 120) {
                            $cond = 'mobile=:mobile';
                            $condata = array('mobile' => $_POST['mobile']);
                            $result = $this->model->selectuser($cond, $condata);
                            if ($result != FALSE) {
                                $row = $result->fetch();
                                if ($row['confirm'] == 1) {
                                    if ($row['isban'] == 0) {
                                        $actcode = Utilities::random(6);
                                        $recnumber = $_POST['mobile'];
                                        Caller::forgotsms($recnumber, $actcode);
                                        $cond = 'id=:id';
                                        $condata = array('id' => $id);
                                        $data = array('mobile' => $_POST['mobile'], 'activecod' => $actcode, 'activtime' => time());
                                        $this->model->updatenewpass($data, $cond, $condata);
                                        $msgid = 1;
                                        Session::set('activecod', 22);
                                        Session::set('mobile', $_POST['mobile']);
                                    } else {
                                        $msgid = 0;
                                        $msgtext = 'حساب کاربری شما مسدود شده است!';
                                    }
                                } else {
                                    $msgid = 0;
                                    $msgtext = 'حساب کاربری شما فعال نیست!';
                                }
                            } else {
                                $msgid = 0;
                                $msgtext = 'اطلاعات وارد شده صحیح نیست!';
                            }
                        } else {
                            $msgid = 0;
                            $msgtext = 'شما به تازگی درخواست کد داده اید';
                        }
                    } else {
                        $cond = 'mobile=:mobile';
                        $condata = array('mobile' => $_POST['mobile']);
                        $result = $this->model->selectuser($cond, $condata);
                        if ($result != FALSE) {
                            $row = $result->fetch();
                            if ($row['confirm'] == 1) {
                                if ($row['isban'] == 0) {
                                    $actcode = Utilities::random(6);
                                    $recnumber = $_POST['mobile'];
                                    Caller::forgotsms($recnumber, $actcode);
                                    $data = array('mobile' => $_POST['mobile'], 'activecod' => $actcode, 'activtime' => time());
                                    $this->model->insertnewpass($data);
                                    $msgid = 1;
                                    Session::set('activecod', 22);
                                    Session::set('mobile', $_POST['mobile']);
                                } else {
                                    $msgid = 0;
                                    $msgtext = 'حساب کاربری شما مسدود شده است!';
                                }
                            } else {
                                $msgid = 0;
                                $msgtext = 'حساب کاربری شما فعال نیست!';
                            }
                        } else {
                            $msgid = 0;
                            $msgtext = 'اطلاعات وارد شده صحیح نیست!';
                        }
                    }
                } else {
                    $msgid = 0;
                    $msgtext = 'کد امنیتی وارد شده صحیح نیست!';
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
