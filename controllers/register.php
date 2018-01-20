<?php

class register extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::guest_control('isuser');
    }

    public function index() {
        $this->view->render('register/index', $this->data);
    }

    public function register() {
        $fields = array('regusername', 'regpassword', 'regmobuser');
        if (Checkform::checkset($_POST, $fields)) {
            if (Checkform::checknotempty($_POST, $fields)) {

                //check username is english
                if (!Utilities::isenglish($_POST['regusername'])) {
                    //username is not english
                    $data = array('id' => '0', 'msg' => 'نام کاربری باید به صورت لاتین باشد');
                    $data = json_encode($data);
                    $this->view->render('register/index', $data, false, 0);
                    return FALSE;
                }

                //check mobile number
                if (strlen(trim($_POST['regmobuser'])) != 11 || Checkform::isinteger($_POST['regmobuser']) == FALSE) {
                    //mobile not true
                    $data = array('id' => '0', 'msg' => 'شماره موبایل صحیح نیست');
                    $data = json_encode($data);
                    $this->view->render('register/index', $data, false, 0);
                    return FALSE;
                }


                //check password
                if (strlen(trim($_POST['regpassword'])) < 6) {
                    //password is very small
                    $data = array('id' => '0', 'msg' => 'رمز عبور باید حداقل شش کاراکتر باشد');
                    $data = json_encode($data);
                    $this->view->render('register/index', $data, false, 0);
                    return FALSE;
                }
                if (Checkform::isspecial($_POST['regpassword'], 2) == FALSE) {
                    //password is not secure
                    $data = array('id' => '0', 'msg' => 'رمز عبور انتخابی شما امنیت پایینی دارد');
                    $data = json_encode($data);
                    $this->view->render('register/index', $data, false, 0);
                    return FALSE;
                }

                //check username not exist
                if ($this->model->checkuser($_POST['regusername']) == FALSE) {
                    //check mobile not exist
                    if ($this->model->checkmobile($_POST['regmobuser']) == FALSE) {
                        $data = array('name' => (isset($_POST['name'])) ? $_POST['name'] : '', 'family' => (isset($_POST['lastname'])) ? $_POST['lastname'] : '', 'username' => trim($_POST['regusername']), 'password' => md5(trim($_POST['regpassword'])), 'melicode' => (isset($_POST['melicode'])) ? $_POST['melicode'] : '', 'postcode' => (isset($_POST['postcode'])) ? $_POST['postcode'] : '', 'address' => (isset($_POST['address'])) ? $_POST['address'] : '', 'tel' => (isset($_POST['tel'])) ? $_POST['tel'] : '', 'mobile' => $_POST['regmobuser'], 'mail' => (isset($_POST['email'])) ? $_POST['email'] : '', 'lastlogin' => time());
                        $userid = $this->model->register($data);
                        $actcode = Utilities::random(6);
                        //send sms in there
                        $recnumber = $_POST['regmobuser'];
                        Caller::sms($recnumber, $actcode);
                        ///////////////////////////////
                        $data = array('userid' => $userid);
                      $this->model->saveuser($data);
                        $data = array('userid' => $userid, 'activecode' => md5($actcode), 'activtime' => time());
                        $this->model->saveactivecode($data);
                        Session::set('mobilenumber',$_POST['regmobuser']);
                        Session::set('activevalue',$actcode);
                        Session::set('codeactive',1);
//                        Session::set('iduser',$id);
                        $data = array('id' => '1', 'msg' => 'ثبت نام شما با موفقیت انجام شد');
                        $data = json_encode($data);
                        $this->view->render('register/index', $data, false, 0);
                        return FALSE;
                    } else {
                        //mobile exist
                        $data = array('id' => '0', 'msg' => 'این شماره موبایل وجود دارد');
                        $data = json_encode($data);
                        $this->view->render('register/index', $data, false, 0);
                    }
                } else {
                    //username exist
                    $data = array('id' => '0', 'msg' => 'این نام کاربری وجود دارد');
                    $data = json_encode($data);
                    $this->view->render('register/index', $data, false, 0);
                }
            } else {
                //data is empty
                $data = array('id' => '0', 'msg' => 'لطفا تمامی موارد خواسته شده را وارد کنید');
                $data = json_encode($data);
                $this->view->render('register/index', $data, false, 0);
            }
        } else {
            //data is empty
                $data = array('id' => '0', 'msg' => 'لطفا تمامی موارد خواسته شده را وارد کنید');
                $data = json_encode($data);
                $this->view->render('register/index', $data, false, 0);
        }
    }

}
