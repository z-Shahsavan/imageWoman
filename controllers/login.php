<?php

class login extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::guest_control('isuser');
    }

    public function index() {
        if (Session::get('userid')) {
            $this->view->render('index/index', $this->data);
        }
    }

    public function login() {
        $fields = array('uid', 'pass');
        if (Checkform::checkset($_POST, $fields)) {
            if (Checkform::checknotempty($_POST, $fields)) {
                $uid=$_POST['uid'];
                $pass=$_POST['pass'];
                $data = array('username' => $uid, 'password' => md5($pass));
                $result = $this->model->login($data);
                if ($result != FALSE) {
                    $row = $result->fetch();
                    if ($row['confirm'] != 0) {
                        if ($row['isban'] == 0) {
                            $rol = $row['isadmin'];
                            $userid = $row['id'];
                            $isavatar = $row['isavatar'];
                            $lastlogin = $row['lastlogin'];
                            $nameandfamily = '';
                            $resa = $this->model->score($userid);
                            if ($resa) {
                                $rowsc = $resa->fetch();
                                $score = ($rowsc['confirm_photo']) + ($rowsc['login_score']);
                                Session::set('score', $score);
                            }
                            if ($row['name'] != '') {
                                $nameandfamily.= htmlspecialchars($row['name']) . ' ';
                            }
                            if ($row['family'] != '') {
                                $nameandfamily .= htmlspecialchars($row['family']);
                            }
                            if ($nameandfamily == '') {
                                $nameandfamily = htmlspecialchars($row['username']);
                            }
                            $res = $this->model->numberphoto($userid);

                            if ($res) {
                                $rowp = $res->fetch();
                                $tedad = $rowp['nphoto'];
                                Session::set('numberpic', $tedad);
                            }
                            Session::set('nameandfam', $nameandfamily);
                            Session::set('isuser', $rol);
                            Session::set('userid', $userid);
                            Session::set('isavatar', $isavatar);
                            Session::set('lastlogin', $lastlogin);
                            $data = array('loginip' => Utilities::userip(), 'lastlogin' => time());
                            $cond = 'id=:id';
                            $conddata = array('id' => $userid);
                            $this->model->setlogininfo($data, $cond, $conddata);
                            //login success
                            $this->setscore($userid, 3);
                            $data = array('id' => '1', 'msg' => 'شما وارد شدید', 'rol' => $rol,'userid'=>$userid);
                            $data = json_encode($data);
                            $this->view->render('index/index', $data, false, 0);
                            //return FALSE;
                        } else {
                            //user is ban
                            $data = array('id' => '0', 'msg' => 'شما از سایت اخراج شدید');
                            $data = json_encode($data);
                            $this->view->render('index/index', $data, false, 0);
                        }
                    } else {
                        //acount not active
                        $data = array('id' => '0', 'msg' => 'حساب کاربری شما فعال نمیباشد');
                        $data = json_encode($data);
                        $this->view->render('index/index', $data, false, 0);
                    }
                } else {
                    //login not true 
                    $data = array('id' => '0', 'msg' => 'نام کاربری یا رمز عبور صحیح نیست');
                    $data = json_encode($data);
                    $this->view->render('index/index', $data, false, 0);
                }
            }
        }
    }

}
