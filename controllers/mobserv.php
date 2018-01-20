<?php

class mobserv extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->render('error/index', $this->data);
    }

    public function mlogout() {
        $userid = Session::get('userid');
        $cond = 'id=:id';
        $condata = array('id' => $userid);
        $gcm = NULL;
        $this->model->gcmsave($gcm, $cond, $condata);
        $_SESSION = array();
        session_destroy();
        session_unset();
    }

    public function register() {
        $fields = array('username', 'password', 'confrim', 'mobile');
        if (Checkform::checkset($_POST, $fields)) {
            if (Checkform::checknotempty($_POST, $fields)) {

                //check username is english
                if (!Utilities::isenglish($_POST['username'])) {
                    //username is not english
                    $data = array('id' => '0', 'msg' => 'نام کاربری باید لاتین باشد');
                    $data = json_encode($data);
                    $this->view->render('register/index', $data, false, 0);
                    return FALSE;
                }

                //check mobile number
                if (strlen(trim($_POST['mobile'])) != 11 || Checkform::isinteger($_POST['mobile']) == FALSE) {
                    //mobile not true
                    $data = array('id' => '0', 'msg' => 'شماره موبایل وارد شده صحیح نیست');
                    $data = json_encode($data);
                    $this->view->render('register/index', $data, false, 0);
                    return FALSE;
                }


                //check password
                if (strlen(trim($_POST['password'])) < 6) {
                    //password is very small
                    $data = array('id' => '0', 'msg' => 'رمز عبور باید حداقل شش کاراکتر باشد');
                    $data = json_encode($data);
                    $this->view->render('register/index', $data, false, 0);
                    return FALSE;
                }
                if (Checkform::isspecial($_POST['password'], 2) == FALSE) {
                    //password is not secure
                    $data = array('id' => '0', 'msg' => 'رمز عبور انتخابی شما امنیت پایینی دارد');
                    $data = json_encode($data);
                    $this->view->render('register/index', $data, false, 0);
                    return FALSE;
                }

                if ($_POST['password'] != $_POST['confrim']) {
                    //password is not secure
                    $data = array('id' => '0', 'msg' => 'رمز عبور وارد شده با تکرار آن برابر نیست');
                    $data = json_encode($data);
                    $this->view->render('register/index', $data, false, 0);
                    return FALSE;
                }

                //check username not exist
                if ($this->model->checkuser($_POST['username']) == FALSE) {
                    //check mobile not exist
                    if ($this->model->checkmobile($_POST['mobile']) == FALSE) {
                        $data = array('name' => (isset($_POST['name'])) ? $_POST['name'] : '', 'family' => (isset($_POST['lastname'])) ? $_POST['lastname'] : '', 'username' => trim($_POST['username']), 'password' => md5(trim($_POST['password'])), 'melicode' => (isset($_POST['melicode'])) ? $_POST['melicode'] : '', 'postcode' => (isset($_POST['postcode'])) ? $_POST['postcode'] : '', 'address' => (isset($_POST['address'])) ? $_POST['address'] : '', 'tel' => (isset($_POST['tel'])) ? $_POST['tel'] : '', 'mobile' => $_POST['mobile'], 'mail' => (isset($_POST['email'])) ? $_POST['email'] : '', 'lastlogin' => time());
                        $userid = $this->model->register($data);
                        $actcode = Utilities::random(6);
                        //send sms in there
                        $recnumber = $_POST['mobile'];
                        Caller::sms($recnumber, $actcode);
                        ///////////////////////////////
                        $data = array('userid' => $userid);
                        $this->model->saveuser($data);
                        $data = array('userid' => $userid, 'activecode' => md5($actcode), 'activtime' => time());
                        $this->model->saveactivecode($data);
                        $data = array('id' => '1', 'msg' => 'ثبت نام شما با موفقیت انجام شد');
                        $data = json_encode($data);
                        $this->view->render('register/index', $data, false, 0);
                        return FALSE;
                    } else {
                        //mobile exist
                        $data = array('id' => '0', 'msg' => 'این شماره موبایل قبلا ثبت شده است');
                        $data = json_encode($data);
                        $this->view->render('register/index', $data, false, 0);
                    }
                } else {
                    //username exist
                    $data = array('id' => '0', 'msg' => 'این نام کاربری قبلا ثبت شده است');
                    $data = json_encode($data);
                    $this->view->render('register/index', $data, false, 0);
                }
            } else {
                //data is empty
                $data = array('id' => '0', 'msg' => 'لطفا تمامی موارد را وارد نمایید');
                $data = json_encode($data);
                $this->view->render('register/index', $data, false, 0);
            }
        } else {
            //data is empty
            $data = array('id' => '0', 'msg' => 'لطفا تمامی موارد را وارد نمایید');
            $data = json_encode($data);
            $this->view->render('register/index', $data, false, 0);
        }
    }

    public function active() {
        $fields = array('activecode');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $result = $this->model->checkactcode(md5($_POST['activecode']));
                if ($result != FALSE) {
                    $row = $result->fetch();
                    $this->model->deletecode(md5($_POST['activecode']));
                    $this->model->makeuseractive($row['userid']);
                    $data = array('id' => '1', 'msg' => 'فعال سازی با موفقییت انجام شد');
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
                $data = array('id' => '0', 'msg' => 'لطفا تمامی فیلد هارا پر کنید');
                $data = json_encode($data);
                $this->view->render('login/index', $data, false, 0);
            }
        } else {
            //all field rewier
            $data = array('id' => '0', 'msg' => 'لطفا تمامی فیلد هارا پر کنید');
            $data = json_encode($data);
            $this->view->render('login/index', $data, false, 0);
        }
    }

    public function sendpass() {
        $fields = array('mobile');
        $msgid = 0;
        $msgtext = '';
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $cond = 'mobile=:mobile';
                $condata = array('mobile' => $_POST['mobile']);
                $result = $this->model->selecactivecod($cond, $condata);
                if ($result) {
                    $row = $result->fetch();
                    $id = $row['id'];
                    if (time() > $row['activtime'] + 300) {
                        $cond = 'mobile=:mobile';
                        $condata = array('mobile' => $_POST['mobile']);
                        $result = $this->model->selectusername($cond, $condata);
                        if ($result != FALSE) {
                            $row = $result->fetch();
                            if ($row['confirm'] == 1) {
                                if ($row['isban'] == 0) {
                                    $actcode = Utilities::random(6);
                                    $recnumber = $_POST['mobile'];
                                    Caller::forgotsms($recnumber, $actcode);
                                    $cond = 'id=:id';
                                    $condata = array('id' => $id);
                                    $data = array('mobile' => $_POST['mobile'], 'activecod' => md5($actcode), 'activtime' => time());
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
                    $result = $this->model->selectusername($cond, $condata);
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
                $msgtext = 'لطفا همه موارد را وارد نمایید';
            }
        } else {
            $msgid = 0;
            $msgtext = 'لطفا همه موارد را وارد نمایید';
        }

        $data = array('id' => $msgid, 'msg' => $msgtext);
        $data = json_encode($data);
        $this->view->render('forgot/index', $data, false, 0);
    }

    public function checkcod() {
        $fields = array('newpass');
        $msgid = 0;
        $msgtext = '';
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            if (Checkform::checknotempty($_POST, $fields)) {
                $cond = 'activecod=:activecod';
                $condata = array('activecod' => ($_POST['newpass']));
                $result = $this->model->selectcod($cond, $condata);
                $cond = 'activtime < ' . (time() - 120);
                $resul = $this->model->delactivcod($cond);
                $cond = 'activecod=:activecod';
                $condata = array('activecod' => ($_POST['newpass']));
                $res = $this->model->selectedcod($cond, $condata);
                if ($result == TRUE && $res == FALSE) {
                    $msgid = 2;
                    $msgtext = '<a href="' . URL . 'forgot">اعتبار زمانی کدفعال سازی شما  پایان یافت برای دریافت کد جدید کلیک کنید.</a>';
                } elseif ($result == FALSE) {
                    $msgid = 3;
                    $msgtext = 'کد وارد شده معتبر نیست';
                } elseif ($result == TRUE) {
                    $msgid = 1;
                    $row = $result->fetch();
                    $cond = 'id=' . $row['id'];
                    $this->model->delactivcod($cond);
                    $cond = 'mobile=' . $row['mobile'];
                    $resuser = $this->model->selecteduser($cond);
                    $rowuser = $resuser->fetch();
                    $msgtext = htmlspecialchars($rowuser['username']);
                    Session::set('activecod', 20);
                }
            } else {
                $msgid = 0;
                $msgtext = 'لطفا  رمز را وارد نمایید';
            }
        } else {
            $msgid = 0;
            $msgtext = 'لطفا رمز را وارد نمایید';
        }
        $data = array('id' => $msgid, 'msg' => $msgtext);
        $data = json_encode($data);
        $this->view->render('forgot/index', $data, false, 0);
        return FALSE;
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

    public function login() {
        $fields = array('username', 'password');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $data = array('username' => $_POST['username'], 'password' => md5($_POST['password']));
                $result = $this->model->login($data);
                if ($result != FALSE) {
                    $row = $result->fetch();
                    if ($row['confirm'] != 0) {
                        if ($row['isban'] == 0) {
                            $rol = $row['isadmin'];
                            $userid = $row['id'];
                            $lastlogin = $row['lastlogin'];
                            $nameandfamily = '';
                            if ($row['name'] != '') {
                                $nameandfamily.= htmlspecialchars($row['name']) . ' ';
                            }
                            if ($row['family'] != '') {
                                $nameandfamily .= htmlspecialchars($row['family']);
                            }
                            if ($nameandfamily == '') {
                                $nameandfamily = htmlspecialchars($row['username']);
                            }
                            Session::set('nameandfam', $nameandfamily);
                            Session::set('isuser', $rol);
                            Session::set('userid', $userid);
                            Session::set('lastlogin', $lastlogin);
                            $data = array('loginip' => Utilities::userip(), 'lastlogin' => time());
                            $cond = 'id=:id';
                            $conddata = array('id' => $userid);
                            $this->model->setlogininfo($data, $cond, $conddata);
                            //login success
                            $data = array('id' => '1', 'msg' => 'شما با موفقیت وارد شدید', 'rol' => $rol);
                            $data = json_encode($data);
                            $this->view->render('login/index', $data, false, 0);
                            $this->setscore($userid, 3);
                            return FALSE;
                        } else {
                            //user is ban
                            $data = array('id' => '0', 'msg' => 'اکانت شما مسدود شده است');
                            $data = json_encode($data);
                            $this->view->render('login/index', $data, false, 0);
                        }
                    } else {
                        //acount not active
                        $data = array('id' => '0', 'msg' => 'حساب کاربری شما فعال نیست');
                        $data = json_encode($data);
                        $this->view->render('login/index', $data, false, 0);
                    }
                } else {
                    //login not true 
                    $data = array('id' => '0', 'msg' => 'نام کاربری یا رمز عبور');
                    $data = json_encode($data);
                    $this->view->render('login/index', $data, false, 0);
                }
            } else {
                //all field req
                $data = array('id' => '0', 'msg' => 'لطفا تمام اطلاعات را وارد نمایید');
                $data = json_encode($data);
                $this->view->render('login/index', $data, false, 0);
            }
        } else {
            //all field req
            $data = array('id' => '0', 'msg' => 'لطفا تمام اطلاعات را وارد نمایید');
            $data = json_encode($data);
            $this->view->render('login/index', $data, false, 0);
        }
    }

    public function loadcomps() {
        $i = 0;
        $data = array('fut' => '', 'now' => '', 'past' => '');
        $cond = 'isopen=3 ORDER by id DESC';
        $res = $this->model->others($cond);
        if ($res != FALSE) {
            while ($row = $res->fetch()) {
                $i++;
                if (($row['peopelwinno'] == 0) && ($row['peoplewinprise'] == 0)) {
                    $ispeople = 'ندارد';
                } else {
                    $ispeople = 'دارد';
                }
                $data['past'].='<div class="panel panel-default">
                                        <a data-toggle="collapse" data-parent="#accordion0" href="#collapse' . $i . '">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    ' . htmlspecialchars($row['name']) . '
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapse' . $i . '" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <table class="col-md-12 col-sm-12 col-xs-12">
                                                    <tr>
                                                        <th>سطح مسابقه:</th>
                                                        <td>' . htmlspecialchars($row['level']) . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تاریخ شروع:</th>
                                                        <td>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['startdate'])) . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تاریخ پایان:</th>
                                                        <td>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['enddate'])) . '</td>
                                                    </tr>
             
                                                    <tr>
                                                        <th>تعداد عکس های ارسالی:</th>
                                                        <td>' . $row['numofpic'] . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>مسابقه مردمی:</th>
                                                        <td>' . $ispeople . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تعداد برندگان:</th>
                                                        <td>' . $row['winno'] . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تعداد منتخبین:</th>
                                                        <td>' . $row['selno'] . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تعداد برندگان مسابقه مردمی:</th>
                                                        <td>' . $row['peopelwinno'] . '</td>
                                                    </tr>
                                                    <tr>
                                                        
                                                    </tr>
                                                </table class="col-md-12 col-sm-12 col-xs-12">
                                                <div id="description">
                                                    <p>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['decription'])) . '</p>
                                                </div>
                                                <div class="details">
                                                    <button type="button" id="btndetailslstcomp" data-compid="' . $row['id'] . '" class="btn btn-lg ">جزئیات</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
            }
        }

        $cond = 'isopen!=3 AND isopen!=0 ORDER by id DESC';
        $res = $this->model->others($cond);
        if ($res != FALSE) {
            while ($row = $res->fetch()) {
                $i++;
                if (($row['peopelwinno'] == 0) && ($row['peoplewinprise'] == 0)) {
                    $ispeople = 'ندارد';
                } else {
                    $ispeople = 'دارد';
                }
                $data['now'].='<div class="panel panel-default">
                                        <a data-toggle="collapse" data-parent="#accordion1" href="#collapse' . $i . '">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    ' . htmlspecialchars($row['name']) . '
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapse' . $i . '" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <table class="col-md-12 col-sm-12 col-xs-12">
                                                    <tr>
                                                        <th>سطح مسابقه:</th>
                                                        <td>' . htmlspecialchars($row['level']) . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تاریخ شروع:</th>
                                                        <td>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['startdate'])) . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تاریخ پایان:</th>
                                                        <td>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['enddate'])) . '</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th>تعداد عکس های ارسالی:</th>
                                                        <td>' . $row['numofpic'] . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>مسابقه مردمی:</th>
                                                        <td>' . $ispeople . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تعداد برندگان:</th>
                                                        <td>' . $row['winno'] . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تعداد منتخبین:</th>
                                                        <td>' . $row['selno'] . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تعداد برندگان مسابقه مردمی:</th>
                                                        <td>' . $row['peopelwinno'] . '</td>
                                                    </tr>
                                                    <tr>
                                                        
                                                    </tr>
                                                </table class="col-md-12 col-sm-12 col-xs-12">
                                                <div id="description">
                                                    <p>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['decription'])) . '</p>
                                                </div>
                                                <div class="details">
                                                    <button type="button" id="btndetailsnowcomp" data-compid="' . $row['id'] . '" class="btn btn-lg ">جزئیات</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
            }
        }

        $cond = 'isopen=0 ORDER by id DESC';
        $res = $this->model->others($cond);
        if ($res != FALSE) {
            while ($row = $res->fetch()) {
                $i++;
                if (($row['peopelwinno'] == 0) && ($row['peoplewinprise'] == 0)) {
                    $ispeople = 'ندارد';
                } else {
                    $ispeople = 'دارد';
                }
                $data['fut'].='<div class="panel panel-default">
                                        <a data-toggle="collapse" data-parent="#accordion2" href="#collapse' . $i . '">
                                            <div class="panel-heading">
                                                <h4 class="panel-title">
                                                    ' . htmlspecialchars($row['name']) . '
                                                </h4>
                                            </div>
                                        </a>
                                        <div id="collapse' . $i . '" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <table class="col-md-12 col-sm-12 col-xs-12">
                                                    <tr>
                                                        <th>سطح مسابقه:</th>
                                                        <td>' . htmlspecialchars($row['level']) . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تاریخ شروع:</th>
                                                        <td>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['startdate'])) . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تاریخ پایان:</th>
                                                        <td>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['enddate'])) . '</td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <th>تعداد عکس های ارسالی:</th>
                                                        <td>' . $row['numofpic'] . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>مسابقه مردمی:</th>
                                                        <td>' . $ispeople . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تعداد برندگان:</th>
                                                        <td>' . $row['winno'] . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تعداد منتخبین:</th>
                                                        <td>' . $row['selno'] . '</td>
                                                    </tr>
                                                    <tr>
                                                        <th>تعداد برندگان مسابقه مردمی:</th>
                                                        <td>' . $row['peopelwinno'] . '</td>
                                                    </tr>
                                                    <tr>
                                                        
                                                    </tr>
                                                </table class="col-md-12 col-sm-12 col-xs-12">
                                                <div id="description">
                                                    <p>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['decription'])) . '</p>
                                                </div>
                                                <div class="details">
                                                    <button type="button" id="btndetailsfutcomp" data-compid="' . $row['id'] . '" class="btn btn-lg ">جزئیات</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
            }
        }


        $data = json_encode($data);
        $compressed = gzcompress($data, 9);
        echo $compressed;
        //$this->view->render('index/index', $data, false, 0);
    }

    public function loadlastcomp() {
        $fields = array('compid');
        $return = array('images' => '<ul>', 'compname' => '', 'info' => '', 'montakhab' => '<ul>', 'winer' => '<div class="winners">', 'jayeze' => '');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $cond = 'compid=:compid AND confirm=1';
                $condata = array('compid' => $_POST['compid']);
                $result = $this->model->loadlastcomp($cond, $condata);
                if ($result != FALSE) {
                    while ($row = $result->fetch()) {
                        $thmname = Utilities::imgname('thumb', $row['id']) . '.jpg';
                        $return['images'].='<li class="col-md-4 col-sm-4 col-xs-4">
                                                <img id="imgdttopg" data-imgid="' . $row['id'] . '" src="' . URL . 'images/gallery/thumb/' . $thmname . '" class="img-responsive" />
                                        </li>';
                        if ($row['iswin'] == 2 || $row['iswin'] == 5) {
                            $return['montakhab'].='<li class="col-md-4 col-sm-4 col-xs-4">
                                                <img id="imgdttopg" data-imgid="' . $row['id'] . '" src="' . URL . 'images/gallery/thumb/' . $thmname . '" class="img-responsive" />
                                        </li>';
                        }
                        if ($row['iswin'] > 0 && $row['iswin'] != 2) {
                            if ($row['iswin'] == 4) {
                                $ismardom = '-برنده مردمی';
                            } elseif ($row['iswin'] == 5) {
                                $ismardom = 'برنده مردمی';
                            } else {
                                $ismardom = '';
                            }

                            $cond = 'imgid=:imgid AND cmpid=:cmpid';
                            $condata = array('imgid' => $row['id'], 'cmpid' => $row['compid']);
                            $reswin = $this->model->winrate($cond, $condata);
                            if ($reswin != FALSE) {
                                $rowwin = $reswin->fetch();
                                $resuser = $this->model->selectuser($row['userid']);
                                if ($resuser != FALSE) {
                                    $rowuser = $resuser->fetch();
                                    $userprfid = $rowuser['id'];
                                    if ($rowuser['name'] != '' && $rowuser['family'] != '') {
                                        $username = $rowuser['name'] . ' ' . $rowuser['family'];
                                    } else {
                                        $username = $rowuser['username'];
                                    }

                                    if ($rowuser['isavatar'] == 1) {
                                        $imgname = Utilities::imgname('avatar', $rowuser['id']) . '.jpg';
                                        $avatar = URL . '/images/avatar/' . $imgname;
                                    } else {
                                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                                        $avatar = URL . '/images/avatar/' . $imgname;
                                    }
                                } else {
                                    $username = '';
                                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                                    $avatar = URL . '/images/avatar/' . $imgname;
                                }
                                $return['winer'].='<div class="winner">
                                            <div class="image-winner">
                                                <img id="imgdttopg" data-imgid="' . $row['id'] . '" src="' . URL . 'images/gallery/thumb/' . $thmname . '" />
                                            </div>
                                            <div class="details-winner">
                                                <div class="image-name">
                                                    <h2>نام عکس:</h2>
                                                    <h1>' . $row['name'] . '</h2>
                                                </div>
                                                <div class="image-rank">
                                                    <h2>رتبه:</h2>
                                                    <h1>' . $rowwin['rate'] . $ismardom . '</h1>
                                                </div>
                                                <div class="image-award">
                                                    <h2>جایزه:</h2>
                                                    <h1>' . $rowwin['price'] . '</h1>
                                                </div>
                                                <div class="image-user">
                                                    <h2>برنده:</h2>
                                                    <a id="userproflnk" data-usid="' . $userprfid . '">
                                                        <div class="avator-user">
                                                            <h1>' . $username . '</h1>
                                                            <img src="' . $avatar . '" class="img-circle" />
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="hr-bottom" />';
                            }
                        }
                    }
                }
                $return['images'].='</ul>';
                $return['montakhab'].='</ul>';
                $return['winer'].='</div>';
                $cond = 'id=:id';
                $condata = array('id' => $_POST['compid']);
                $res = $this->model->others($cond, $condata);
                if ($res != FALSE) {
                    $row = $res->fetch();
                    $dvs = $this->loadvs($row['id']);
                    if (($row['peopelwinno'] == 0) && ($row['peoplewinprise'] == 0)) {
                        $ispeople = 'ندارد';
                    } else {
                        $ispeople = 'دارد';
                    }
                    $return['compname'] = $row['name'];
                    $return['info'] = '<div class="details-single-competition-last">
                                        <table class="col-md-12 col-sm-12 col-xs-12">
                                            <tr>
                                                <th>سطح مسابقه:</th>
                                                <td>' . $row['level'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>تاریخ شروع:</th>
                                                <td>' . Shamsidate::jdate('Y/m/d', $row['startdate']) . '</td>
                                            </tr>
                                            <tr>
                                                <th>تاریخ پایان:</th>
                                                <td>' . Shamsidate::jdate('Y/m/d', $row['enddate']) . '</td>
                                            </tr>
                                            <tr>
                                                <th>تعداد عکس های ارسالی:</th>
                                                <td>' . $row['numofpic'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>مسابقه مردمی:</th>
                                                <td>' . $ispeople . '</td>
                                            </tr>
                                            <tr>
                                                <th>تعداد برندگان:</th>
                                                <td>' . $row['winno'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>تعداد منتخبین:</th>
                                                <td>' . $row['selno'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>تعداد برندگان مسابقه مردمی:</th>
                                                <td>' . $row['peopelwinno'] . '</td>
                                            </tr>
                                            <tr>

                                            </tr>
                                        </table>
                                        <div class="description">
                                            <h4>توضیحات:</h4>
                                            <p>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['decription'])) . '</p>
                                        </div>
                                        <div class="awards">
                                            <h4>جوایز:</h4>
                                            <p>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['prise'])) . '</p>
                                        </div>
                                        <div class="awards">
                                            <h4>جوایز مسابقه مردمی:</h4>
                                            <p>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['peoplewinprise'])) . '</p>
                                        </div>
                                        <div class="referees">
                                            <h4>داوران:</h4>
                                            ' . $dvs . '
                                        </div>
                                    </div>';
                }
            }
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
        //$this->view->render('index/index', $data, false, 0);
    }

    public function loadnowcomp() {
        $fields = array('compid');
        $return = array('images' => '<ul>', 'compname' => '', 'info' => '');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $cond = 'compid=:compid AND confirm=1';
                $condata = array('compid' => $_POST['compid']);
                $result = $this->model->loadlastcomp($cond, $condata);
                if ($result != FALSE) {
                    while ($row = $result->fetch()) {
                        $thmname = Utilities::imgname('thumb', $row['id']) . '.jpg';
                        $return['images'].='<li class="col-md-4 col-sm-4 col-xs-4">
                                                <img id="imgdttopg" data-imgid="' . $row['id'] . '" src="' . URL . 'images/gallery/thumb/' . $thmname . '" class="img-responsive" />
                                        </li>';
                    }
                }
                $return['images'].='</ul>';
                $cond = 'id=:id';
                $condata = array('id' => $_POST['compid']);
                $res = $this->model->others($cond, $condata);
                if ($res != FALSE) {
                    $row = $res->fetch();
                    $dvs = $this->loadvs($row['id']);
                    if (($row['peopelwinno'] == 0) && ($row['peoplewinprise'] == 0)) {
                        $ispeople = 'ندارد';
                    } else {
                        $ispeople = 'دارد';
                    }
                    $return['compname'] = $row['name'];
                    $return['info'] = '<div class="details-single-competition">
                                        <table class="col-md-12 col-sm-12 col-xs-12">
                                            <tr>
                                                <th>سطح مسابقه:</th>
                                                <td>' . $row['level'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>تاریخ شروع:</th>
                                                <td>' . Shamsidate::jdate('Y/m/d', $row['startdate']) . '</td>
                                            </tr>
                                            <tr>
                                                <th>تاریخ پایان:</th>
                                                <td>' . Shamsidate::jdate('Y/m/d', $row['enddate']) . '</td>
                                            </tr>
                                            <tr>
                                                <th>تعداد عکس های ارسالی:</th>
                                                <td>' . $row['numofpic'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>مسابقه مردمی:</th>
                                                <td>' . $ispeople . '</td>
                                            </tr>
                                            <tr>
                                                <th>تعداد برندگان:</th>
                                                <td>' . $row['winno'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>تعداد منتخبین:</th>
                                                <td>' . $row['selno'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>تعداد برندگان مسابقه مردمی:</th>
                                                <td>' . $row['peopelwinno'] . '</td>
                                            </tr>
                                            <tr>

                                            </tr>
                                        </table>
                                        <div class="description">
                                            <h4>توضیحات:</h4>
                                            <p>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['decription'])) . '</p>
                                        </div>
                                        <div class="awards">
                                            <h4>جوایز:</h4>
                                            <p>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['prise'])) . '</p>
                                        </div>
                                        <div class="awards">
                                            <h4>جوایز مسابقه مردمی:</h4>
                                            <p>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['peoplewinprise'])) . '</p>
                                        </div>
                                        <div class="referees">
                                            <h4>داوران:</h4>
                                            ' . $dvs . '
                                        </div>
                                    </div>';
                }
            }
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
        //$this->view->render('index/index', $data, false, 0);
    }

    public function loadfutcomp() {
        $fields = array('compid');
        $return = array('compname' => '', 'info' => '');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $cond = 'id=:id';
                $condata = array('id' => $_POST['compid']);
                $res = $this->model->others($cond, $condata);
                if ($res != FALSE) {
                    $row = $res->fetch();
                    $dvs = $this->loadvs($row['id']);
                    if (($row['peopelwinno'] == 0) && ($row['peoplewinprise'] == 0)) {
                        $ispeople = 'ندارد';
                    } else {
                        $ispeople = 'دارد';
                    }
                    $return['compname'] = $row['name'];
                    $return['info'] = '<div class="details-competition-coming">
                                        <table class="col-md-12 col-sm-12 col-xs-12">
                                            <tr>
                                                <th>سطح مسابقه:</th>
                                                <td>' . $row['level'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>تاریخ شروع:</th>
                                                <td>' . Shamsidate::jdate('Y/m/d', $row['startdate']) . '</td>
                                            </tr>
                                            <tr>
                                                <th>تاریخ پایان:</th>
                                                <td>' . Shamsidate::jdate('Y/m/d', $row['enddate']) . '</td>
                                            </tr>
                                            <tr>
                                                <th>تعداد عکس های ارسالی:</th>
                                                <td>' . $row['numofpic'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>مسابقه مردمی:</th>
                                                <td>' . $ispeople . '</td>
                                            </tr>
                                            <tr>
                                                <th>تعداد برندگان:</th>
                                                <td>' . $row['winno'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>تعداد منتخبین:</th>
                                                <td>' . $row['selno'] . '</td>
                                            </tr>
                                            <tr>
                                                <th>تعداد برندگان مسابقه مردمی:</th>
                                                <td>' . $row['peopelwinno'] . '</td>
                                            </tr>
                                            <tr>

                                            </tr>
                                        </table>
                                        <div class="description">
                                            <h4>توضیحات:</h4>
                                            <p>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['decription'])) . '</p>
                                        </div>
                                        <div class="awards">
                                            <h4>جوایز:</h4>
                                            <p>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['prise'])) . '</p>
                                        </div>
                                        <div class="awards">
                                            <h4>جوایز مسابقه مردمی:</h4>
                                            <p>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['peoplewinprise'])) . '</p>
                                        </div>
                                        <div class="referees">
                                            <h4>داوران:</h4>
                                            ' . $dvs . '
                                        </div>
                                    </div>';
                }
            }
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
        //$this->view->render('index/index', $data, false, 0);
    }

    public function loadvs($cid) {
        $res = $this->model->loadvs($cid);
        $dlist = '';
        if ($res) {
            while ($row = $res->fetch()) {
                $result = $this->model->selectuser($row['did']);
                $rw = $result->fetch();
                if ($rw['isavatar'] == 1) {
                    $imgname = Utilities::imgname('avatar', $rw['id']) . '.jpg';
                } else {
                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                }

                if ($row['name'] != '' && $row['family'] != '') {
                    $userandfam = $row['name'] . ' ' . $row['family'];
                } else {
                    $userandfam = $row['username'];
                }
                $dlist.='<div class="name-referees">
                                                <a id="userproflnk" data-usid="' . $rw['id'] . '">
                                                    <div class="referee-image">
                                                        <img src="' . URL . '/images/avatar/' . $imgname . '" class="img-circle " />
                                                    </div>
                                                    <div class="referee-name">
                                                        <h4>' . $userandfam . '</h4>
                                                    </div>
                                                </a>
                                            </div>';
            }
        }
        return $dlist;
    }

    public function gcmsave() {
        $fields = array('username', 'password', 'regid');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $gcm = $_POST['regid'];
                $cond = 'username=:username AND password=:password';
                $condata = array('username' => ($_POST['username']), 'password' => md5(trim($_POST['password'])));
                $this->model->gcmsave($gcm, $cond, $condata);
            }
        }
    }

    public function singleimage() {
        $fields = array('imgid');
        $return = array('images' => '', 'imgid' => '', 'imgname' => '', 'compname' => '', 'rate' => '', 'avatar' => '', 'username' => '', 'date' => '', 'info' => '');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $resbazbin = $this->model->bazbinrate($_POST['imgid']);
                if ($resbazbin != FALSE) {
                    $rowbazbin = $resbazbin->fetch();
                    if ($rowbazbin['isok'] == 1) {
                        $rateforthis = TRUE;
                    } else {
                        $rateforthis = FALSE;
                    }
                } else {
                    $rateforthis = FALSE;
                }
                $cond = 'id=:id AND confirm=1';
                $condata = array('id' => $_POST['imgid']);
                $result = $this->model->loadlastcomp($cond, $condata);
                if ($result != FALSE) {
                    $row = $result->fetch();
                    $return['imgname'] = $row['name'];
                    $return['date'] = Shamsidate::jdate('Y/m/d', $row['date']);
                    $return['info'] = '<p>' . $row['comment'] . '</p>';
                    $thmname = Utilities::imgname('thumb', $row['id']) . '.jpg';
                    $return['imgid'] = $row['id'];
                    $return['images'] = URL . 'images/gallery/thumb/' . $thmname;
                    $cond = 'id=:id';
                    $condata = array('id' => $row['compid']);
                    $rescomp = $this->model->others($cond, $condata);
                    if ($rescomp != FALSE) {
                        $rowcomp = $rescomp->fetch();
                        $return['compname'] = $rowcomp['name'];
                        if ($rowcomp['peopelwinno'] != 0) {
                            $ispeople = 1;
                        } else {
                            $ispeople = 0;
                        }
                        //if (($rowcomp['startdate'] < (time() - (24 * 3600))) && ((time() - (48 * 3600)) < $rowcomp['enddate']) && $ispeople == 1 && $rateforthis == TRUE) {
                        if (((time() - (48 * 3600)) < $rowcomp['enddate']) && $ispeople == 1) {
                            $userid = Session::get('userid');
                            $resr = $this->model->loadrate($row['id'], $userid);
                            if ($resr) {
                                $rowrate = $resr->fetch();
                                $rate = $rowrate['rate'];
                            } else {
                                $rate = 0;
                            }
                            $return['rate'] = '<input id="input-id" type="number" value="' . $rate . '" class="rating" data-size="xs" data-rtl="true" />';
                        } else {
                            $return['rate'] = '';
                        }
                    }
                }
                $resuser = $this->model->selectuser($row['userid']);
                if ($resuser != FALSE) {
                    $rowuser = $resuser->fetch();
                    $return['userproflnk'] = $rowuser['id'];
                    if ($rowuser['name'] != '' && $rowuser['family'] != '') {
                        $return['username'] = $rowuser['name'] . ' ' . $rowuser['family'];
                    } else {
                        $return['username'] = $rowuser['username'];
                    }

                    if ($rowuser['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $rowuser['id']) . '.jpg';
                        $return['avatar'] = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $return['avatar'] = URL . '/images/avatar/' . $imgname;
                    }
                } else {
                    $return['username'] = '';
                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                    $return['avatar'] = URL . '/images/avatar/' . $imgname;
                }
            }
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function loadstates() {
        $return = array('states' => '', 'comp' => '');
        $states = $this->model->selectstates();
        if ($states) {
            $statesoption = '';
            while ($row = $states->fetch()) {
                $statesoption.='<option value="' . $row['id'] . '">' . $row['state'] . '</option>';
            }$return['states'] = $statesoption;
        }

        $competition = $this->model->selectcomp();
        if ($competition != FALSE) {
            $compoption = '';
            while ($row = $competition->fetch()) {
                $compoption.='<option value="' . $row['id'] . '" >' . $row['name'] . '</option>';
            }$return['comp'] = $compoption;
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function loadstatesup() {
        $return = array('states' => '', 'comp' => '');
        $states = $this->model->selectstates();
        if ($states) {
            $statesoption = '';
            while ($row = $states->fetch()) {
                $statesoption.='<option value="' . $row['id'] . '">' . $row['state'] . '</option>';
            }$return['states'] = $statesoption;
        }

        $competition = $this->model->selectcompnow();
        if ($competition != FALSE) {
            $compoption = '';
            while ($row = $competition->fetch()) {
                $compoption.='<option value="' . $row['id'] . '" >' . $row['name'] . '</option>';
            }$return['comp'] = $compoption;
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function search() {
        $return = array('images' => '<table class="table"><tbody>');
        if (isset($_POST['searchtxt'])) {
            if ($_POST['searchtxt'] == "") {
                $cond = '1 ORDER BY pid DESC';
                $condata = array();

                $infsearch = 0;
            } else {
                $word = explode(' ', ($_POST['searchtxt']));
                $cond = '';
                $i = 0;
                foreach ($word as $val) {
                    $cond.='pn LIKE :data' . $i . ' OR ';
                    $condata['data' . $i] = '%' . $val . '%';
                    $i++;
                    $cond.='pcmt LIKE :data' . $i . ' OR ';
                    $condata['data' . $i] = '%' . $val . '%';
                    $i++;
                }
                $cond = substr($cond, 0, strlen($cond) - 3);
                $cond.=' ORDER BY pid DESC';
                $infsearch = 1;
            }
        } elseif (isset($_POST['searchby'])) {
            switch ($_POST['searchby']) {
                case 2: {
                        $infsearchcomp = 'جستجو بر اساس مسابقات';
                        switch ($_POST['dropcomptype']) {
                            case 1: {
                                    if ($_POST['searchcompname'] == '') {
                                        $cond = 'confirm=1 ORDER BY cid DESC';
                                        $condata = array();
                                        $infsearchcomp = 'جدیدترین مسابقه';
                                    } elseif (($_POST['searchcompname']) != '') {
                                        $word = explode(' ', ($_POST['searchcompname']));
                                        $cond = 'confirm=1 AND (';
                                        $i = 0;
                                        foreach ($word as $val) {
                                            $cond.='pn LIKE :data' . $i . ' OR ';
                                            $condata['data' . $i] = '%' . $val . '%';
                                            $i++;
                                            $cond.='pcmt LIKE :data' . $i . ' OR ';
                                            $condata['data' . $i] = '%' . $val . '%';
                                            $i++;
                                        }
                                        $cond = substr($cond, 0, strlen($cond) - 3);
                                        $cond.=') ORDER BY cid DESC';
                                        $infsearchcomp = 'عبارت « ' . $_POST['searchcompname'] . '» در جدیدترین مسابقه';
                                    }
                                    break;
                                }
                            case 2: {
                                    if ($_POST['searchcompname'] == '') {
                                        $cond = 'confirm=1 ORDER BY numofpic DESC';
                                        $condata = array();
                                        $infsearchcomp = 'محبوبترین مسابقه';
                                    } else {
                                        $word = explode(' ', ($_POST['searchcompname']));
                                        $cond = 'confirm=1 AND (';
                                        $i = 0;
                                        foreach ($word as $val) {
                                            $cond.='pn LIKE :data' . $i . ' OR ';
                                            $condata['data' . $i] = '%' . $val . '%';
                                            $i++;
                                            $cond.='pcmt LIKE :data' . $i . ' OR ';
                                            $condata['data' . $i] = '%' . $val . '%';
                                            $i++;
                                        }
                                        $cond = substr($cond, 0, strlen($cond) - 3);
                                        $cond.=') ORDER BY numofpic DESC';
                                        $infsearchcomp = 'عبارت « ' . $_POST['searchcompname'] . '» در محبوبترین مسابقه';
                                    }
                                    break;
                                }
                            case 3: {
                                    if ($_POST['searchcompname'] == '') {
                                        if ($_POST['dropcomp'] == 0) {
                                            $cond = 'confirm=1 ORDER BY cid DESC';
                                            $condata = array();
                                            $infsearchcomp = 'جستجو بر اساس نام مسابقات';
                                        } else {
                                            $cond = 'cid=:cid AND confirm=1 ORDER BY pid DESC';
                                            $condata = array('cid' => $_POST['dropcomp']);
                                            $competition = $this->model->selectcomp();
                                            if ($competition != FALSE) {
                                                $compoption = '';
                                                while ($row = $competition->fetch()) {
                                                    $compoption.='<option value="' . $row['id'] . '"';
                                                    if ($row['id'] == $_POST['dropcomp']) {
                                                        $compoption.='selected';
                                                        session::set('compsearch', $row['name']);
                                                        $comp = session::get('compsearch');
                                                    }
                                                    $compoption.='>' . $row['name'] . '</option>';
                                                }//$this->data['[VARCOMPNAME]'] = $compoption;
                                            }
                                            $infsearchcomp = 'مسابقه  ' . $comp;
                                        }
                                    } elseif ($_POST['dropcomp'] != 0) {
                                        $word = explode(' ', ($_POST['searchcompname']));
                                        $cond = 'confirm=1 AND(';
                                        $i = 0;
                                        foreach ($word as $val) {
                                            $cond.='pn LIKE :data' . $i . ' OR ';
                                            $condata['data' . $i] = '%' . $val . '%';
                                            $i++;
                                            $cond.='pcmt LIKE :data' . $i . ' OR ';
                                            $condata['data' . $i] = '%' . $val . '%';
                                            $i++;
                                        }
                                        $cond = substr($cond, 0, strlen($cond) - 3);
                                        $cond.=') AND cid=:cid ORDER BY pid DESC';
                                        $condata['cid'] = $_POST['dropcomp'];
                                        $competition = $this->model->selectcomp();
                                        if ($competition != FALSE) {
                                            $compoption = '';
                                            while ($row = $competition->fetch()) {
                                                $compoption.='<option value="' . $row['id'] . '"';
                                                if ($row['id'] == $_POST['dropcomp']) {
                                                    $compoption.='selected';
                                                    session::set('compsearch', $row['name']);
                                                    $comp = session::get('compsearch');
                                                }
                                                $compoption.='>' . $row['name'] . '</option>';
                                            }//$this->data['[VARCOMPNAME]'] = $compoption;
                                        }
                                        $infsearchcomp = 'عبارت« ' . $_POST['searchcompname'] . '» در مسابقه ' . $comp;
                                    } else {
                                        $word = explode(' ', ($_POST['searchcompname']));
                                        $cond = 'confirm=1 AND (';
                                        $i = 0;
                                        foreach ($word as $val) {
                                            $cond.='pn LIKE :data' . $i . ' OR ';
                                            $condata['data' . $i] = '%' . $val . '%';
                                            $i++;
                                            $cond.='pcmt LIKE :data' . $i . ' OR ';
                                            $condata['data' . $i] = '%' . $val . '%';
                                            $i++;
                                        }
                                        $cond = substr($cond, 0, strlen($cond) - 3);
                                        $cond.=')  ORDER BY pid DESC';
                                        $infsearchcomp = 'عبارت« ' . $_POST['searchcompname'] . '»';
                                    }

                                    break;
                                }
                            case 4: {
                                    if ($_POST['searchcompname'] == '') {
                                        if (($_POST['tarikh1']) != '' && ($_POST['tarikh2']) != '') {
                                            $stime = explode('/', $_POST['tarikh1']);
                                            $st = Shamsidate::jmktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
                                            $etime = explode('/', $_POST['tarikh2']);
                                            $en = Shamsidate::jmktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);
                                            $cond = '(startdate>=:startdate AND enddate<=:enddate) AND confirm=1 ORDER BY pid DESC';
                                            $condata = array('startdate' => $st, 'enddate' => $en);
                                            $begin = $stime[0] . '/' . $stime[1] . '/' . $stime[2];
                                            $finish = $etime[0] . '/' . $etime[1] . '/' . $etime[2];
                                            $infsearchcomp = 'بازه زمانی ' . $begin . ' تا ' . $finish;
                                        } else {
                                            $cond = 'confirm=1 ORDER BY cid DESC';
                                            $condata = array();
                                            $infsearchcomp = 'همه تصاویر';
                                        }
                                    } else {
                                        if (($_POST['tarikh1']) != '' && ($_POST['tarikh2']) != '') {
                                            $word = explode(' ', ($_POST['searchcompname']));
                                            $i = 0;
                                            $cond = '(';
                                            foreach ($word as $val) {
                                                $cond.='pn LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                                $cond.='pcmt LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                            }
                                            $stime = explode('-', $_POST['tarikh1']);
                                            $st = Shamsidate::jmktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
                                            $etime = explode('-', $_POST['tarikh2']);
                                            $en = Shamsidate::jmktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);
                                            $cond = substr($cond, 0, strlen($cond) - 3);
                                            $cond.=') AND startdate>=:startdate AND enddate<=:enddate ORDER BY pid DESC';
                                            $condata['startdate'] = $st;
                                            $condata['enddate'] = $en;
                                            $begin = $stime[0] . '/' . $stime[1] . '/' . $stime[2];
                                            $finish = $etime[0] . '/' . $etime[1] . '/' . $etime[2];
                                            $infsearchcomp = 'عبارت« ' . $_POST['searchcompname'] . '» در بازه زمانی ' . $begin . ' تا ' . $finish;
                                        } else {
                                            $word = explode(' ', ($_POST['searchcompname']));
                                            $i = 0;
                                            $cond = '';
                                            foreach ($word as $val) {
                                                $cond.='pn LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                                $cond.='pcmt LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                            }
                                            $cond = substr($cond, 0, strlen($cond) - 3);
                                            $cond.=' ORDER BY cid DESC';
                                            $infsearchcomp = 'عبارت«' . $_POST['searchcompname'] . '»';
                                        }
                                    }
                                    break;
                                }
                            default :
                                if ($_POST['searchcompname'] == '') {
                                    $cond = '1 ORDER BY cid DESC';
                                    $condata = array();
                                } else {
                                    $word = explode(' ', ($_POST['searchcompname']));
                                    $cond = '';
                                    $i = 0;
                                    foreach ($word as $val) {
                                        $cond.='pn LIKE :data' . $i . ' OR ';
                                        $condata['data' . $i] = '%' . $val . '%';
                                        $i++;
                                        $cond.='pcmt LIKE :data' . $i . ' OR ';
                                        $condata['data' . $i] = '%' . $val . '%';
                                        $i++;
                                    }
                                    $cond = substr($cond, 0, strlen($cond) - 3);
                                    $cond.=' ORDER BY cid DESC';
                                    $infsearchcomp .= ' عبارت«' . $_POST['searchcompname'] . '»';
                                }
                        }$infsearch = 2;
                        break;
                    }
                case 4: {
                        if ($_POST['searchhashtag'] == '') {
                            $cond = 'confirm=1 ORDER BY pid DESC';
                            $condata = array();
                            $infsearchcomp = 'همه  تگ ها';
                        } else {
                            $cond = 'confirm=1 AND tags LIKE :data ORDER BY pid DESC';
                            $condata['data'] = ',' . $_POST['searchhashtag'] . ',';
                            $infsearchcomp = 'بر اساس تگ« ' . $_POST['searchhashtag'] . '»';
                        }$infsearch = 3;
                        break;
                    }
                case 5: {
                        if ($_POST['searchuser'] == '') {
                            $cond = 'confirm=1 ORDER BY pid DESC';
                            $condata = array();
                            $infsearchcomp = 'همه  کاربران';
                        } else {
                            $cond = 'confirm=1 AND username=:username ORDER BY pid DESC';
                            $condata = array('username' => $_POST['searchuser']);
                            $infsearchcomp = 'بر اساس نام کاربری «' . $_POST['searchuser'] . '»';
                        }$infsearch = 4;
                        break;
                    }
                case 6: {
                        if ($_POST['searchplace'] == '') {
                            if ($_POST['dropplace'] == 0) {
                                $cond = 'confirm=1 ORDER BY pid DESC';
                                $condata = array();
                                $infsearchcomp = 'همه   استان ها';
                            } else {
                                $cond = 'locateid=:locateid AND confirm=1 ORDER BY pid DESC';
                                $condata = array('locateid' => $_POST['dropplace']);
                                $states = $this->model->selectstates();
                                if ($states) {
                                    $statesoption = '';
                                    while ($row = $states->fetch()) {
                                        $statesoption.='<option value="' . $row['id'] . '"';
                                        if ($row['id'] == $_POST['dropplace']) {
                                            $statesoption.='selected';
                                            session::set('statesearch', $row['state']);
                                            $place = session::get('statesearch');
                                        }$statesoption.= ' >' . $row['state'] . '</option>';
                                    }//$this->data['[VARSTATES]'] = $statesoption;
                                }
                                $infsearchcomp = 'عکس های  گرفته شده در استان« ' . $place . '»';
                            }
                        } else {
                            if ($_POST['dropplace'] == 0) {
                                $searchtxt = $_POST['searchplace'];
                                $word = explode(' ', ($_POST['searchplace']));
                                $i = 0;
                                $cond = 'confirm=1 AND (';
                                foreach ($word as $val) {
                                    $cond.='pn LIKE :data' . $i . ' OR ';
                                    $condata['data' . $i] = '%' . $val . '%';
                                    $i++;
                                    $cond.='pcmt LIKE :data' . $i . ' OR ';
                                    $condata['data' . $i] = '%' . $val . '%';
                                    $i++;
                                }
                                $cond = substr($cond, 0, strlen($cond) - 3);
                                $cond.=') ORDER BY pid DESC';
                                $infsearchcomp = 'عبارت «' . $_POST['searchplace'] . '» ';
                            } else {
                                $searchtxt = $_POST['searchplace'];
                                $word = explode(' ', ($_POST['searchplace']));
                                $i = 0;
                                $cond = 'confirm=1 AND (';
                                foreach ($word as $val) {
                                    $cond.='pn LIKE :data' . $i . ' OR ';
                                    $condata['data' . $i] = '%' . $val . '%';
                                    $i++;
                                    $cond.='pcmt LIKE :data' . $i . ' OR ';
                                    $condata['data' . $i] = '%' . $val . '%';
                                    $i++;
                                }
                                $cond = substr($cond, 0, strlen($cond) - 3);
                                $cond.=') AND locateid=:locateid ORDER BY pid DESC';
                                $condata['locateid'] = $_POST['dropplace'];
                                $states = $this->model->selectstates();
                                if ($states) {
                                    $statesoption = '';
                                    while ($row = $states->fetch()) {
                                        $statesoption.='<option value="' . $row['id'] . '"';
                                        if ($row['id'] == $_POST['dropplace']) {
                                            $statesoption.='selected';
                                            session::set('statesearch', $row['state']);
                                            $place = session::get('statesearch');
                                        }$statesoption.= ' >' . $row['state'] . '</option>';
                                    }//$this->data['[VARSTATES]'] = $statesoption;
                                }$infsearchcomp = 'عبارت «' . $_POST['searchplace'] . '» در تصاویر گرفته شده در استان ' . $place;
                            }
                        }$infsearch = 5;

                        break;
                    }
            }
        } elseif (!isset($_POST['searchtxt'])) {
            $cond = '1 ORDER BY pid DESC';
            $condata = array();
            $infsearch = 0;
        }
        //$cond.=' '
        Session::set('serchcond', $cond);
        Session::set('condata', $condata);
        //$this->data['[VARIMAGECOUNT]'] = '';
        $cnt = 0;
        $photo = $this->model->searchphot($cond, $condata);
        $numofpage = 0;
        if ($photo != FALSE) {
            $cnt = $photo->rowCount();
            session::set('num', $cnt);
            $numofpage = ceil($cnt / 5);
            $item = '';
            $i = 0;
            while ($row = $photo->fetch()) {
                if ($i < 12) {
                    if ($row['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $row['id']) . '.jpg';
                        $thmname = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $thmname = URL . '/images/avatar/' . $imgname;
                    }
                    $picname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                    $picturname = URL . '/images/gallery/thumb/' . $picname;


                    $return['images'].='<tr>
                                                    <td>
                                                        <img id="imgdttopg" data-imgid="' . $row['pid'] . '" src="' . $picturname . '" />
                                                    </td>
                                                    <td>
                                                        <div class="name">
                                                            <h1>' . $row['pn'] . '</h1>
                                                        </div>
                                                        <div class="comp">
                                                            <h2>' . $row['cname'] . '</h2>
                                                        </div>
                                                        <div class="user">
                                                            <h3>' . htmlspecialchars($row['uname']) . ' ' . htmlspecialchars($row['uf']) . '</h3>
                                                        </div>
                                                        <div class="date">
                                                            <h4>' . Shamsidate::jdate('Y/m/d', $row['pdate']) . '</h4>
                                                        </div>
                                                    </td>
                                                </tr>';
                }$i++;
            }

            //$this->data['[VARSEARCH]'] = $item;
        }
        //$this->data['[VARIMAGECOUNT]'] = $numofpage;
        switch ($infsearch) {
            case 0: {
                    $inf = '<p class="col s12 m6 right">مورد جستجو : <span class="teal-text text-darken-4">...</span></p>
                       <p class="col s12 m6 right">تعداد یافت شده : <span class="teal-text text-darken-4">...</span></p>';
                    break;
                }
            case 1: {
                    $inf = '<p class="col s12 m6 right">مورد جستجو : <span class="teal-text text-darken-4">« ' . htmlspecialchars($_POST['searchtxt']) . ' »</span></p>
                       <p class="col s12 m6 right">تعداد یافت شده : <span class="teal-text text-darken-4">' . $cnt . '</span></p>';
                    break;
                }
            case 2: {
                    $inf = '<p class="col s12 m6 right">مورد جستجو : <span class="teal-text text-darken-4"> ' . htmlspecialchars($infsearchcomp) . '</span></p>
                       <p class="col s12 m6 right">تعداد یافت شده : <span class="teal-text text-darken-4">' . $cnt . '</span></p>';
                    break;
                }
            case 3: {
                    $inf = '<p class="col s12 m6 right">مورد جستجو : <span class="teal-text text-darken-4"> ' . htmlspecialchars($infsearchcomp) . '</span></p>
                       <p class="col s12 m6 right">تعداد یافت شده : <span class="teal-text text-darken-4">' . $cnt . '</span></p>';
                    break;
                }
            case 4: {
                    $inf = '<p class="col s12 m6 right">مورد جستجو : <span class="teal-text text-darken-4"> ' . htmlspecialchars($infsearchcomp) . '  </span></p>
                       <p class="col s12 m6 right">تعداد یافت شده : <span class="teal-text text-darken-4">' . $cnt . '</span></p>';
                    break;
                }
            case 5: {
                    $inf = '<p class="col s12 m6 right">مورد جستجو : <span class="teal-text text-darken-4"> ' . htmlspecialchars($infsearchcomp) . '</span></p>
                       <p class="col s12 m6 right">تعداد یافت شده : <span class="teal-text text-darken-4">' . $cnt . '</span></p>';
                    break;
                }
        }//$this->data['[VARINF]'] = $inf;


        $return['images'].='</tbody></table>';
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function pagingsearch() {
        $return = array('images' => '');
        $case = Session::get('search');
        $num = Session::get('num');
        if (isset($_POST['pid'])) {
            if ($case != FALSE) {
                $inf = '<p class="col s12 m6 right">مورد جستجو : <span class="teal-text text-darken-4">' . htmlspecialchars($case) . '</span></p>
                       <p class="col s12 m6 right">تعداد یافت شده : <span class="teal-text text-darken-4">' . $num . '</span></p>';
            } else {
                $inf = '<p class="col s12 m6 right">مورد جستجو : <span class="teal-text text-darken-4">...</span></p>
                       <p class="col s12 m6 right">تعداد یافت شده : <span class="teal-text text-darken-4">...</span></p>';
            }
            $word = explode(' ', ($case));
            $cond = '';
            $i = 0;
            foreach ($word as $val) {
                $cond.='pn LIKE :data' . $i . ' OR ';
                $condata['data' . $i] = '%' . $val . '%';
                $i++;
                $cond.='pcmt LIKE :data' . $i . ' OR ';
                $condata['data' . $i] = '%' . $val . '%';
                $i++;
            }$cond = substr($cond, 0, strlen($cond) - 3);
            $lmt = 12 * ($_POST['pid'] - 1);
            $cond .= ' ORDER BY pid DESC Limit ' . $lmt . ',12';
            $cond = Session::get('serchcond');
            $cond .= ' Limit ' . $lmt . ',12';
            $condata = Session::get('condata');
            $photo = $this->model->searchphot($cond, $condata);
            if ($photo != FALSE) {
                $item = '';
                while ($row = $photo->fetch()) {
                    if ($row['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $row['id']) . '.jpg';
                        $thmname = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $thmname = URL . '/images/avatar/' . $imgname;
                    }
                    $picname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                    $picturname = URL . '/images/gallery/thumb/' . $picname;


                    $return['images'].='<tr>
                                                    <td>
                                                        <img id="imgdttopg" data-imgid="' . $row['pid'] . '" src="' . $picturname . '" />
                                                    </td>
                                                    <td>
                                                        <div class="name">
                                                            <h1>' . $row['pn'] . '</h1>
                                                        </div>
                                                        <div class="comp">
                                                            <h2>' . $row['cname'] . '</h2>
                                                        </div>
                                                        <div class="user">
                                                            <h3>' . htmlspecialchars($row['uname']) . ' ' . htmlspecialchars($row['uf']) . '</h3>
                                                        </div>
                                                        <div class="date">
                                                            <h4>' . Shamsidate::jdate('Y/m/d', $row['pdate']) . '</h4>
                                                        </div>
                                                    </td>
                                                </tr>';
                }
            }
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function uploadpic() {
        $fields = array('compid');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                //check file
                $res = Photoutil::photocheck('0');
                switch ($res) {
                    case 1:
                        //file not post
                        $data = array('id' => '0', 'msg' => 'لطفا یک فایل انتخاب کنید');
                        $data = json_encode($data);
                        $compressed = gzcompress($data, 9);
                        echo $compressed;
                        return;
                        break;
                    case 2:
                        //mimetype not true
                        $data = array('id' => '0', 'msg' => 'پسوند فایل صحیح نمی باشد');
                        $data = json_encode($data);
                        $compressed = gzcompress($data, 9);
                        echo $compressed;
                        return;
                        break;
                    case 3:
                        //image is corrupted
                        $data = array('id' => '0', 'msg' => 'عکس شما دارای مشکل است');
                        $data = json_encode($data);
                        $compressed = gzcompress($data, 9);
                        echo $compressed;
                        return;
                        break;
                    case 4:
                        //image size not true
                        $data = array('id' => '0', 'msg' => 'اندازه عکس مناسب نیست');
                        $data = json_encode($data);
                        $compressed = gzcompress($data, 9);
                        echo $compressed;
                        return;
                        break;
                    case 5:
                        //image file size not true
                        $data = array('id' => '0', 'msg' => 'حجم فایل مناسب نیست');
                        $data = json_encode($data);
                        $compressed = gzcompress($data, 9);
                        echo $compressed;
                        return;
                        break;
                }
                $userid = Session::get('userid');
                if ($userid != FALSE) {
                    //save image
                    $cond = 'id=:id';
                    if (isset($_POST['location']) && !empty($_POST['location'])) {
                        $condata = array('id' => $_POST['location']);
                    } else {
                        $condata = array('id' => 32);
                    }
                    $re = $this->model->citynam($cond, $condata);
                    if ($re) {
                        $row = $re->fetch();
                        $locname = $row['state'];
                    }
                    if (isset($_POST['date']) && !empty($_POST['date'])) {
                        $data = explode('-', $_POST['date']);
                        $st = Shamsidate::jmktime(0, 0, 0, $data[1], $data[2], $data[0]);
                    } else {
                        $st = time();
                    }

                    if (isset($_POST['hashtag']) && !empty($_POST['hashtag'])) {
                        $hashtag = ',' . $_POST['hashtag'] . ',';
                    } else {
                        $hashtag = '';
                    }
                    if (isset($_POST['name']) && !empty($_POST['name'])) {
                        $name = $_POST['name'];
                    } else {
                        $name = 'بدون نام';
                    }
                    if (isset($_POST['comment']) && !empty($_POST['comment'])) {
                        $comment = $_POST['comment'];
                    } else {
                        $comment = '';
                    }
                    $data = array('userid' => $userid, 'name' => htmlspecialchars($name), 'tags' => htmlspecialchars($hashtag), 'locate' => htmlspecialchars($locname), 'date' => $st, 'comment' => htmlspecialchars($comment), 'compid' => $_POST['compid'], 'refrate' => 0);
                    $result = $this->model->saveimage($data);
                    Photoutil::saveimgandthumb($result, $res, 0);
                    //add to user photonumber
                    $this->model->edituser($userid);
                    $data = array('id' => '1', 'msg' => 'عکس شما با موفقیت ذخیره شد');
                    $data = json_encode($data);
                    $compressed = gzcompress($data, 9);
                    echo $compressed;
                    return;
                } else {
                    header('location:' . URL . 'login');
                }
            } else {
                //all field requier
                $data = array('id' => '0', 'msg' => 'لطفا تمامی موارد را وارد نمایید');
                $data = json_encode($data);
                $compressed = gzcompress($data, 9);
                echo $compressed;
                return;
            }
        } else {
            //all field requier
            $data = array('id' => '0', 'msg' => 'لطفا تمامی موارد را وارد نمایید');
            $data = json_encode($data);
            $compressed = gzcompress($data, 9);
            echo $compressed;
        }
    }

    public function loadusrprofile() {
        $return = array('avatar' => '', 'msg' => 1, 'usename' => '', 'score' => '', 'numofimages' => '', 'images' => '', 'noconfirm' => '', 'eftekharat' => '', 'folower' => '', 'folowing' => '', 'flernum' => 0, 'flingnum' => 0);
        $userid = Session::get('userid');
        if ($userid == FALSE) {
            $return['msg'] = 0;
            $data = json_encode($return);
            $compressed = gzcompress($data, 9);
            echo $compressed;
            return;
        }
        $result = $this->model->selectuser($userid);
        if ($result != FALSE) {
            $row = $result->fetch();
            if ($row['isavatar'] == 1) {
                $imgname = Utilities::imgname('avatar', $row['id']) . '.jpg';
                $return['avatar'] = URL . '/images/avatar/' . $imgname;
            } else {
                $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                $return['avatar'] = URL . '/images/avatar/' . $imgname;
            }

            if ($row['name'] == '' && $row['family'] == '') {
                $return['usename'] = $row['username'];
            } else {
                $return['usename'] = $row['name'] . ' ' . $row['family'];
            }
            $cond = 'userid=:userid';
            $condata = array('userid' => $userid);
            $resultscore = $this->model->score($cond, $condata);
            if ($resultscore != FALSE) {
                $rowscore = $resultscore->fetch();
                $return['score'] = $rowscore['confirm_photo'] + $rowscore['login_score'];
                $return['confscore'] = $rowscore['confirm_photo'];
                $return['logscore'] = $rowscore['login_score'];
            } else {
                $return['score'] = 0;
                $return['confscore'] = 0;
                $return['logscore'] = 0;
            }
            $return['numofimages'] = $row['photonumber'];
            $return['aboutme'] = $row['userinfo'];
            $cond = 'userid=:userid';
            $condata = array('userid' => $userid);
            $resphoto = $this->model->loadlastcomp($cond, $condata);
            if ($resphoto != FALSE) {
                while ($rowphoto = $resphoto->fetch()) {
                    $picname = Utilities::imgname('thumb', $rowphoto['id']) . '.jpg';
                    $picturname = URL . '/images/gallery/thumb/' . $picname;
                    if ($rowphoto['confirm'] == 1) {
                        $return['images'].='<li class="col-md-4 col-sm-4 col-xs-4">
                                                                    <a>
                                                                        <img id="imgdttopg" data-imgid="' . $rowphoto['id'] . '" src="' . $picturname . '" />
                                                                    </a>
                                                                </li>';
                    } elseif ($rowphoto['confirm'] == 0) {
                        $return['noconfirm'].='<li class="col-md-12 col-sm-12 col-xs-12">
                                                                    <a >
                                                                        <div class="image-check col-md-4 col-sm-4 col-xs-4 paddingleftright0">
                                                                            <img src="' . $picturname . '" />
                                                                        </div>
                                                                        <div class="details-check col-md-8 col-sm-8 col-xs-8 paddingleftright5">
                                                                            <div class="image-name-check">
                                                                                <h1 class="col-md-12 col-sm-12 col-xs-12 paddingleftright0">' . $rowphoto['name'] . '</h1>
                                                                            </div>
                                                                            <div class="image-status-check">
                                                                                <h1 class="col-md-12 col-sm-12 col-xs-12 paddingleftright0"></h1>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </li>';
                    }
                }
            }
            $cond = 'uid=:uid';
            $condata = array('uid' => $userid);
            $reseftekhar = $this->model->wins($cond, $condata);
            if ($reseftekhar != FALSE) {
                while ($roweftekhar = $reseftekhar->fetch()) {
                    $rescomp = $this->model->checkcompeftekhar($roweftekhar['cmpid']);
                    if ($rescomp != FALSE) {
                        $rowcomp = $rescomp->fetch();
                        if ($roweftekhar['wintype'] == 0) {
                            $rate = $roweftekhar['rate'];
                        } elseif ($roweftekhar['wintype'] == 1) {
                            $rate = 'منتخب داوری';
                        } elseif ($roweftekhar['wintype'] == 2) {
                            $rate = 'برنده مردمی';
                        } else {
                            $rate = '';
                        }
                        $return['eftekharat'] .= '<tr>
                                                                        <td>' . $rowcomp['name'] . '</td>
                                                                        <td>' . $rate . '</td>
                                                                        <td>' . $roweftekhar['price'] . '</td>
                                                                    </tr>';
                    }
                }
            }
            //load follower and following
            $selid = $userid;
            $ing = 0;
            $er = 0;
            $cond0 = 'fid=:flid';
            $condata0 = array('flid' => $selid);
            $res0 = $this->model->selfer($cond0, $condata0);
            if ($res0) {
                $er = $res0->rowCount();
                while ($row1 = $res0->fetch()) {
                    if ($row1['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $row1['userid']) . '.jpg';
                        $avat = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $avat = URL . '/images/avatar/' . $imgname;
                    }
                    if ($row1['name'] != '' && $row1['family'] != '') {
                        $username = htmlspecialchars($row1['name']) . ' ' . htmlspecialchars($row1['family']);
                    } else {
                        $username = htmlspecialchars($row1['username']);
                    }
                    $return['folower'].='<div class="details-user">
                                                                <a data-dismiss="modal" id="userproflnk" data-usid="' . $row1['userid'] . '">
                                                                    <div class="details-image">
                                                                        <img id="avtimg" src="' . $avat . '" class="img-circle " />
                                                                    </div>
                                                                    <div class="details-name">
                                                                        <h4 id="unameimg">' . $username . '</h4>
                                                                    </div>
                                                                </a>
                                                            </div>';
                }
            }
            $return['flernum'] = $er;
            $cond1 = 'userid=:uid';
            $condata1 = array('uid' => $selid);
            $res1 = $this->model->selfing($cond1, $condata1);
            if ($res1) {
                $ing = $res1->rowCount();
                while ($row1 = $res1->fetch()) {
                    if ($row1['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $row1['fid']) . '.jpg';
                        $avat = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $avat = URL . '/images/avatar/' . $imgname;
                    }
                    if ($row1['name'] != '' && $row1['family'] != '') {
                        $username = htmlspecialchars($row1['name']) . ' ' . htmlspecialchars($row1['family']);
                    } else {
                        $username = htmlspecialchars($row1['username']);
                    }
                    $return['folowing'].='<div class="details-user">
                                                                <a data-dismiss="modal" id="userproflnk" data-usid="' . $row1['fid'] . '">
                                                                    <div class="details-image">
                                                                        <img id="avtimg" src="' . $avat . '" class="img-circle " />
                                                                    </div>
                                                                    <div class="details-name">
                                                                        <h4 id="unameimg">' . $username . '</h4>
                                                                    </div>
                                                                </a>
                                                            </div>';
                }
            }
            $return['flingnum'] = $ing;
        } else {
            $return['msg'] = 0;
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function loadeditprof() {
        $return = array('usernameedit' => '', 'msg' => 1, 'nameedit' => '', 'familyedit' => '', 'phoneedit' => '', 'nationalidedit' => '', 'postalcodeedit' => '', 'addressedit' => '', 'emailedit' => '');
        $userid = Session::get('userid');
        if ($userid == FALSE) {
            $return['msg'] = 0;
            $data = json_encode($return);
            $compressed = gzcompress($data, 9);
            echo $compressed;
            return;
        }
        $result = $this->model->selectuser($userid);
        if ($result != FALSE) {
            $row = $result->fetch();
            $return['usernameedit'] = $row['username'];
            $return['nameedit'] = $row['name'];
            $return['familyedit'] = $row['family'];
            $return['phoneedit'] = $row['tel'];
            $return['nationalidedit'] = $row['melicode'];
            $return['postalcodeedit'] = $row['postcode'];
            $return['addressedit'] = $row['address'];
            $return['emailedit'] = $row['mail'];
        }

        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function saveeditprof() {
        $fields = array('usernameedit', 'nameedit', 'familyedit', 'phoneedit', 'nationalidedit', 'postalcodeedit', 'addressedit', 'emailedit');
        $fields1 = array('usernameedit');
        $return = array('id' => 0, 'msg' => '');
        $userid = Session::get('userid');
        if ($userid == FALSE) {
            $return['id'] = 2;
            $data = json_encode($return);
            $compressed = gzcompress($data, 9);
            echo $compressed;
            return;
        }
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields1)) {
                //check username not exist
                $cond = 'id!=:id AND username=:username';
                $condata = array('id' => $userid, 'username' => $_POST['usernameedit']);
                $resusername = $this->model->selectusername($cond, $condata);
                if ($resusername == FALSE) {
                    //check meli code
                    if (!empty($_POST['nationalidedit']) && !Utilities::ismelicode($_POST['nationalidedit'])) {
                        //melicode not true
                        $return['id'] = 0;
                        $return['msg'] = 'کد ملی صحیح نیست';
                        $data = json_encode($return);
                        $compressed = gzcompress($data, 9);
                        echo $compressed;
                        return;
                    }
                    //check username is english
                    if (!Utilities::isenglish($_POST['usernameedit'])) {
                        //username is not english
                        $return['id'] = 0;
                        $return['msg'] = 'نام کاربری باید با حروف لاتین باشد';
                        $data = json_encode($return);
                        $compressed = gzcompress($data, 9);
                        echo $compressed;
                        return;
                    }

                    //check melicode not exist
                    if (!empty($_POST['melicode']) && $this->model->checkmelicode($_POST['melicode'], $userid) != FALSE) {
                        //melicode is exist
                        $return['id'] = 0;
                        $return['msg'] = 'این کد ملی قبلا ثبت شده است';
                        $data = json_encode($return);
                        $compressed = gzcompress($data, 9);
                        echo $compressed;
                        return;
                    }
                    //check email
                    if (!empty($_POST['email']) && Checkform::isemail($_POST['email']) == FALSE) {
                        //mobile not true
                        $return['id'] = 0;
                        $return['msg'] = 'ایمیل وارد شده معتبر نیست';
                        $data = json_encode($return);
                        $compressed = gzcompress($data, 9);
                        echo $compressed;
                        return;
                    }

                    $updata = array('name' => $_POST['nameedit'], 'family' => $_POST['familyedit'], 'username' => $_POST['usernameedit'], 'melicode' => $_POST['nationalidedit'], 'postcode' => $_POST['postalcodeedit'], 'address' => $_POST['addressedit'], 'tel' => $_POST['phoneedit'], 'mail' => $_POST['emailedit']);
                    $cond = 'id=:id';
                    $condata = array('id' => $userid);
                    $this->model->saveeditprof($updata, $cond, $condata);
                    $return['id'] = 1;
                    $return['msg'] = 'اطلاعات با موفقیت ذخیره شد';
                } else {
                    $return['id'] = 0;
                    $return['msg'] = 'نام کاربری وارد شده در دسترس نیست';
                }
            } else {
                $return['id'] = 0;
                $return['msg'] = 'نام کاربری نمی تواند خالی باشد';
            }
        } else {
            $return['id'] = 0;
            $return['msg'] = 'نام کاربری نمی تواند خالی باشد';
        }

        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function editpassword() {
        $fields = array('password', 'newpass');
        $return = array('id' => 0, 'msg' => '');
        $userid = Session::get('userid');
        if ($userid == FALSE) {
            $return['id'] = 2;
            $data = json_encode($return);
            $compressed = gzcompress($data, 9);
            echo $compressed;
            return;
        }
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                //check old password
                $cond = 'id=:id AND password=:password';
                $condata = array('id' => $userid, 'password' => md5(trim($_POST['password'])));
                $resusername = $this->model->selectusername($cond, $condata);
                if ($resusername != FALSE) {
                    //check password
                    if (strlen(trim($_POST['newpass'])) < 6) {
                        //password is very small
                        $return['id'] = 0;
                        $return['msg'] = 'حداقل طول رمز عبور باید 6 کارکتر باشد';
                        $data = json_encode($return);
                        $compressed = gzcompress($data, 9);
                        echo $compressed;
                        return;
                    }
                    if (Checkform::isspecial($_POST['newpass'], 2) == FALSE) {
                        //password is not secure
                        $return['id'] = 0;
                        $return['msg'] = 'پسورد باید شامل کارکترهای ترکیبی باشد';
                        $data = json_encode($return);
                        $compressed = gzcompress($data, 9);
                        echo $compressed;
                        return;
                    }

                    $updata = array('password' => md5(trim($_POST['newpass'])));
                    $cond = 'id=:id';
                    $condata = array('id' => $userid);
                    $this->model->saveeditprof($updata, $cond, $condata);
                    $return['id'] = 1;
                    $return['msg'] = 'اطلاعات با موفقیت ذخیره شد';
                } else {
                    $return['id'] = 0;
                    $return['msg'] = 'رمزعبور قبلی صحیح نمی باشد';
                }
            } else {
                $return['id'] = 0;
                $return['msg'] = 'لطفا تمامی اطلاعات را وارد کنید';
            }
        } else {
            $return['id'] = 0;
            $return['msg'] = 'لطفا تمامی اطلاعات را وارد کنید';
        }

        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function changemobile() {

        $fields = array('newmob');
        $return = array('id' => 0, 'msg' => '');
        $userid = Session::get('userid');
        if ($userid == FALSE) {
            $return['id'] = 2;
            $data = json_encode($return);
            $compressed = gzcompress($data, 9);
            echo $compressed;
            return;
        }
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                //check mobile not exist
                if ($this->model->checkmobile($_POST['newmob']) == FALSE) {
                    if (strlen(trim($_POST['newmob'])) == 11) {
                        Session::set('newmobile', $_POST['newmob']);
                        $actcode = Utilities::random(6);
                        Session::set('changemob', $actcode);
                        $recnumber = $_POST['newmob'];
                        Caller::changemob($recnumber, $actcode);
                        $return['id'] = 1;
                        $return['msg'] = 'کد تغییر شماره را وارد نمایید';
                    } else {
                        $return['id'] = 0;
                        $return['msg'] = 'شماره وارد شده معتبر نیست';
                    }
                } else {
                    $return['id'] = 0;
                    $return['msg'] = 'این شماره قبلا ثبت شده است';
                }
            } else {
                $return['id'] = 0;
                $return['msg'] = 'لطفا شماره جدید را وارد کنید';
            }
        } else {
            $return['id'] = 0;
            $return['msg'] = 'لطفا شماره جدید را وارد کنید';
        }

        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function finchangemobile() {

        $fields = array('reccode');
        $return = array('id' => 0, 'msg' => '');
        $userid = Session::get('userid');
        $newmob = Session::get('newmobile');
        $actcode = Session::get('changemob');
        if ($userid == FALSE || $newmob == FALSE || $actcode == FALSE) {
            $return['id'] = 2;
            $data = json_encode($return);
            $compressed = gzcompress($data, 9);
            echo $compressed;
            return;
        }
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                //check mobile not exist
                if ($this->model->checkmobile($newmob) == FALSE) {
                    if (strlen(trim($newmob)) == 11) {
                        if ($actcode == trim($_POST['reccode'])) {

                            $updata = array('mobile' => $newmob);
                            $cond = 'id=:id';
                            $condata = array('id' => $userid);
                            $this->model->saveeditprof($updata, $cond, $condata);
                            $return['id'] = 1;
                            $return['msg'] = 'شماره همراه شما تغییر کرد';
                        } else {
                            $return['id'] = 0;
                            $return['msg'] = 'کد وارد شده صحیح نیست';
                        }
                    } else {
                        $return['id'] = 0;
                        $return['msg'] = 'شماره وارد شده معتبر نیست';
                    }
                } else {
                    $return['id'] = 0;
                    $return['msg'] = 'این شماره قبلا ثبت شده است';
                }
            } else {
                $return['id'] = 0;
                $return['msg'] = 'کد تغییر شماره را وارد نمایید';
            }
        } else {
            $return['id'] = 0;
            $return['msg'] = 'کد تغییر شماره را وارد نمایید';
        }

        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function loadusprof() {
        $return = array('avatar' => '', 'msg' => 1, 'usename' => '', 'score' => '', 'numofimages' => '', 'images' => '', 'noconfirm' => '', 'eftekharat' => '', 'isself' => 0, 'payam' => '', 'userid' => 0, 'folower' => '', 'folowing' => '', 'flernum' => 0, 'flingnum' => 0);
        $userid = (isset($_POST['usid']) ? $_POST['usid'] : FALSE);
        if ($userid == FALSE) {
            $return['msg'] = 0;
            $data = json_encode($return);
            $compressed = gzcompress($data, 9);
            echo $compressed;
            return;
        }
        $selfuserid = Session::get('userid');
        if ($userid == $selfuserid) {
            $return['isself'] = 1;
        } else {
            $cond = 'userid=:userid AND fid=:fid';
            $condata = array('userid' => $selfuserid, 'fid' => $userid);
            $res = $this->model->checkflw($cond, $condata);
            if ($res != FALSE) {
                $return['payam'] = 'دنبال نکردن';
            } else {
                $return['payam'] = 'دنبال کردن';
            }
            $return['isself'] = 0;
        }
        $result = $this->model->selectuser($userid);
        if ($result != FALSE) {
            $row = $result->fetch();
            if ($row['isavatar'] == 1) {
                $imgname = Utilities::imgname('avatar', $row['id']) . '.jpg';
                $return['avatar'] = URL . '/images/avatar/' . $imgname;
            } else {
                $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                $return['avatar'] = URL . '/images/avatar/' . $imgname;
            }
            $return['userid'] = $row['id'];
            if ($row['name'] == '' && $row['family'] == '') {
                $return['usename'] = $row['username'];
            } else {
                $return['usename'] = $row['name'] . ' ' . $row['family'];
            }
            $cond = 'userid=:userid';
            $condata = array('userid' => $userid);
            $resultscore = $this->model->score($cond, $condata);
            if ($resultscore != FALSE) {
                $rowscore = $resultscore->fetch();
                $return['score'] = $rowscore['confirm_photo'] + $rowscore['login_score'];
                $return['confscore'] = $rowscore['confirm_photo'];
                $return['logscore'] = $rowscore['login_score'];
            } else {
                $return['score'] = 0;
                $return['confscore'] = 0;
                $return['logscore'] = 0;
            }
            $return['numofimages'] = $row['photonumber'];
            $return['aboutme'] = $row['userinfo'];
            $cond = 'userid=:userid';
            $condata = array('userid' => $userid);
            $resphoto = $this->model->loadlastcomp($cond, $condata);
            if ($resphoto != FALSE) {
                while ($rowphoto = $resphoto->fetch()) {
                    $picname = Utilities::imgname('thumb', $rowphoto['id']) . '.jpg';
                    $picturname = URL . '/images/gallery/thumb/' . $picname;
                    if ($rowphoto['confirm'] == 1) {
                        $return['images'].='<li class="col-md-4 col-sm-4 col-xs-4">
                                                                    <a>
                                                                        <img id="imgdttopg" data-imgid="' . $rowphoto['id'] . '" src="' . $picturname . '" />
                                                                    </a>
                                                                </li>';
                    }
                }
            }
            $cond = 'uid=:uid';
            $condata = array('uid' => $userid);
            $reseftekhar = $this->model->wins($cond, $condata);
            if ($reseftekhar != FALSE) {
                while ($roweftekhar = $reseftekhar->fetch()) {
                    $rescomp = $this->model->checkcompeftekhar($roweftekhar['cmpid']);
                    if ($rescomp != FALSE) {
                        $rowcomp = $rescomp->fetch();
                        if ($roweftekhar['wintype'] == 0) {
                            $rate = $roweftekhar['rate'];
                        } elseif ($roweftekhar['wintype'] == 1) {
                            $rate = 'منتخب داوری';
                        } elseif ($roweftekhar['wintype'] == 2) {
                            $rate = 'برنده مردمی';
                        } else {
                            $rate = '';
                        }
                        $return['eftekharat'] .= '<tr>
                                                                        <td>' . $rowcomp['name'] . '</td>
                                                                        <td>' . $rate . '</td>
                                                                        <td>' . $roweftekhar['price'] . '</td>
                                                                    </tr>';
                    }
                }
            }


            //load follower and following
            $selid = $userid;
            $ing = 0;
            $er = 0;
            $cond0 = 'fid=:flid';
            $condata0 = array('flid' => $selid);
            $res0 = $this->model->selfer($cond0, $condata0);
            if ($res0) {
                $er = $res0->rowCount();
                while ($row1 = $res0->fetch()) {
                    if ($row1['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $row1['userid']) . '.jpg';
                        $avat = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $avat = URL . '/images/avatar/' . $imgname;
                    }
                    if ($row1['name'] != '' && $row1['family'] != '') {
                        $username = htmlspecialchars($row1['name']) . ' ' . htmlspecialchars($row1['family']);
                    } else {
                        $username = htmlspecialchars($row1['username']);
                    }
                    $return['folower'].='<div class="details-user">
                                                                <a data-dismiss="modal" id="userproflnk" data-usid="' . $row1['userid'] . '">
                                                                    <div class="details-image">
                                                                        <img id="avtimg" src="' . $avat . '" class="img-circle " />
                                                                    </div>
                                                                    <div class="details-name">
                                                                        <h4 id="unameimg">' . $username . '</h4>
                                                                    </div>
                                                                </a>
                                                            </div>';
                }
            }
            $return['flernum'] = $er;
            $cond1 = 'userid=:uid';
            $condata1 = array('uid' => $selid);
            $res1 = $this->model->selfing($cond1, $condata1);
            if ($res1) {
                $ing = $res1->rowCount();
                while ($row1 = $res1->fetch()) {
                    if ($row1['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $row1['fid']) . '.jpg';
                        $avat = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $avat = URL . '/images/avatar/' . $imgname;
                    }
                    if ($row1['name'] != '' && $row1['family'] != '') {
                        $username = htmlspecialchars($row1['name']) . ' ' . htmlspecialchars($row1['family']);
                    } else {
                        $username = htmlspecialchars($row1['username']);
                    }
                    $return['folowing'].='<div class="details-user">
                                                                <a data-dismiss="modal" id="userproflnk" data-usid="' . $row1['fid'] . '">
                                                                    <div class="details-image">
                                                                        <img id="avtimg" src="' . $avat . '" class="img-circle " />
                                                                    </div>
                                                                    <div class="details-name">
                                                                        <h4 id="unameimg">' . $username . '</h4>
                                                                    </div>
                                                                </a>
                                                            </div>';
                    ;
                }
            }
            $return['flingnum'] = $ing;
        } else {
            $return['msg'] = 0;
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function notifications() {
        $return = array('notify' => '');
        $userid = Session::get('userid');
        $result = $this->model->slenotmob($userid);
        if ($result != FALSE) {
            while ($row = $result->fetch()) {
                $return['notify'] .='<div class="single-notification paddingleftright15">
                                <h1 class="col-md-9 col-sm-9 col-xs-9">
                                    ' . $row['text'] . '
                                </h1>
                                <h2 class="col-md-3 col-sm-3 col-xs-3">
                                    ' . $row['date'] . '
                                </h2>
                            </div>';
            }
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function loadelanat() {
        $return = array('elanat' => '');
        $res = $this->model->loads();
        if ($res) {
            $list = '';
            while ($row = $res->fetch()) {
                $return['elanat'].=' <li>
                                    <div class="subject-notifications2">
                                        <h1>
                                            ' . htmlspecialchars($row['title']) . '
                                         </h1>
                                    </div>
                                    <div class="comment-notifications2">
                                        <p>
                                          ' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '
                                        </p>
                                    </div>
                                    <div class="file-notifications2">
                                        <a id="downloadfilest" url="' . URL . 'blogadmin/forcedw/' . $row['extention'] . '/' . $row['id'] . '">دریافت فایل</a>
                                    </div>
                            </li>';
            }
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function loadabout() {
        $return = array('about' => '');
        $ab = $this->model->loadabout('aboutus');
        if ($ab) {
            $abus = $ab->fetch();
            $return['about'] .='<p>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $abus['aboutus'])) . '</p>';
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function uslquestion() {
        $return = array('question' => '');
        $result = $this->model->load();
        if ($result) {
            $i = 1;
            while ($row = $result->fetch()) {

                $return['question'] .='<div class="panel panel-default">
                                <div class="panel-heading" data-toggle="collapse" data-parent="#accordionsoal" href="#collapses' . $i . '">
                                    <h4 class="panel-title">
                                        ' . str_replace(PHP_EOL, '</br>', $row['question']) . '
                                    </h4>
                                </div>
                                <div id="collapses' . $i . '" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        ' . str_replace(PHP_EOL, '</br>', $row['answer']) . '
                                    </div>
                                </div>
                            </div>';
                $i++;
            }
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function shive() {
        $return = array('shive' => '');
        $result = $this->model->loadmethod();
        if ($result) {
            $i = 1;
            while ($row = $result->fetch()) {

                $return['shive'] .='<div class="panel panel-default">
                                <div class="panel-heading" data-toggle="collapse" data-parent="#accordionshive" href="#collapseshive' . $i . '">
                                    <h4 class="panel-title">
                                        ' . $row['ruls'] . '
                                    </h4>
                                </div>
                                <div id="collapseshive' . $i . '" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        ' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['message'])) . '
                                    </div>
                                </div>
                            </div>';
                $i++;
            }
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function policy() {
        $return = array('policy' => '');
        $result = $this->model->loadrules();
        if ($result) {
            $i = 1;
            while ($row = $result->fetch()) {
                $return['policy'] .='<div class="panel panel-default">
                                <div class="panel-heading" data-toggle="collapse" data-parent="#accordionpolicy" href="#collapsepolicy' . $i . '">
                                    <h4 class="panel-title">
                                        ' . $row['rules'] . '
                                    </h4>
                                </div>
                                <div id="collapsepolicy' . $i . '" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        ' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '
                                    </div>
                                </div>
                            </div>';
                $i++;
            }
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function hoghoogh() {
        $return = array('hoghoogh' => '');
        $result = $this->model->loadcpy();
        if ($result) {
            $i = 1;
            while ($row = $result->fetch()) {
                $return['hoghoogh'] .='<div class="panel panel-default">
                                <div class="panel-heading" data-toggle="collapse" data-parent="#accordionhoghoogh" href="#collapsehoghoogh' . $i . '">
                                    <h4 class="panel-title">
                                        ' . $row['rules'] . '
                                    </h4>
                                </div>
                                <div id="collapsehoghoogh' . $i . '" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        ' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '
                                    </div>
                                </div>
                            </div>';
                $i++;
            }
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function loadcontact() {
        $return = array('contactinfo' => '');
        $result = $this->model->loadaddress();
        if ($result) {
            $i = 1;
            while ($row = $result->fetch()) {
                $return['contactinfo'] .='
                            <li>
                                <h5>تلفن: </h5>
                                <h6>' . $row['tell'] . '</h6>
                            </li>
                            <li>
                                <h5>نمابر: </h5>
                                <h6>' . $row['fax'] . '</h6>
                            </li>
                            <li>
                                <h5>پست الکترونیک: </h5>
                                <h6>' . $row['mail'] . '</h6>
                            </li>
                            <li>
                                <h4>سوالات ، پیشنهادات و انتقادات خود را برای ما ارسال نمایید.</h4>
                            </li>';
                $i++;
            }
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function sendcontact() {
        $return = array('msgid' => 0, 'msgtxt' => '');
        if (isset($_POST['message'])) {
            if (strlen($_POST['message']) != 0) {
                $userid = Session::get('userid');
                if ($userid == FALSE) {
                    $return['msgid'] = 0;
                    $return['msgtxt'] = 'خطا در ارسال اطلاعات!';
                } else {
                    $cond = 'id=:id';
                    $condata = array('id' => $userid);
                    $result = $this->model->selectusername($cond, $condata);
                    if ($result != FALSE) {
                        $row = $result->fetch();
                        if ($row['name'] != '' && $row['family'] != '') {
                            $name = htmlspecialchars($row['name']) . ' ' . htmlspecialchars($row['family']);
                        } else {
                            $name = $row['username'];
                        }

                        $data = array('name' => $name, 'tell' => $row['tel'], 'mobile' => $row['mobile'], 'mail' => $row['mail'], 'message' => htmlspecialchars($_POST['message']));
                        $id = $this->model->saveform($data);
                        if ($id != null) {
                            $return['msgid'] = 1;
                            $return['msgtxt'] = 'پیام شما با موفقیت ثبت شد';
                        } else {
                            $return['msgid'] = 0;
                            $return['msgtxt'] = 'خطا در ارسال اطلاعات!';
                        }
                    } else {
                        $return['msgid'] = 0;
                        $return['msgtxt'] = 'خطا در ارسال اطلاعات!';
                    }
                }
            } else {
                $return['msgid'] = 0;
                $return['msgtxt'] = 'لطفا پیام خود را وارد نمایید';
            }
        } else {
            $return['msgid'] = 0;
            $return['msgtxt'] = 'لطفا پیام خود را وارد نمایید';
        }

        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

    public function saverating() {
        $fields = array('rate', 'imgid');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $userid = Session::get('userid');
                if ($userid != FALSE) {
                    $res = $this->model->selrate($_POST['imgid'], $userid);
                    if ($res) {
                        $this->model->uprate($userid, $_POST['imgid'], $_POST['rate']);
                    } else {
                        $data = array('pid' => $_POST['imgid'], 'rate' => $_POST['rate'], 'uid' => $userid);
                        $this->model->saverate($data);
                    }
                    $resuser = $this->model->seluser($_POST['imgid']);
                    if ($resuser) {
                        $cnt = $resuser->rowCount();
                        while ($row = $resuser->fetch()) {
                            $sumrate+= $row['rate'];
                            $refrate = ($sumrate / $cnt);
                            $ref = round($refrate, 2);
                            $this->model->uprefate($_POST['imgid'], $ref);
                        }
                    }
                }
            }
        }
    }

    public function savefollow() {
        if (isset($_POST['idfl']) && !empty($_POST['idfl'])) {
            $thisuserid = Session::get('userid');
            if ($thisuserid != FALSE) {
                if ($_POST['idfl'] != $thisuserid) {
                    $cond = 'userid=:userid AND fid=:fid';
                    $condata = array('userid' => $thisuserid, 'fid' => $_POST['idfl']);
                    $res = $this->model->checkflw($cond, $condata);
                    if ($res != FALSE) {
                        $this->model->makeunflw($cond, $condata);
                        $resuser = $this->model->selectuser($thisuserid);
                        if ($resuser != FALSE) {
                            $rowuser = $resuser->fetch();
                            if ($rowuser['name'] != '' && $rowuser['family'] != '') {
                                $username = htmlspecialchars($rowuser['name']) . ' ' . htmlspecialchars($rowuser['family']);
                            } else {
                                $username = htmlspecialchars($rowuser['username']);
                            }
                            $text = $username . ' شما را دنبال نمی کند';
                            $href = 'blog/id/' . $rowuser['id'];
                            $ndate = Shamsidate::jdate('Y/m/d', time());
                            $users = array(htmlspecialchars($_POST['idfl']));
                            $this->addnote($text, $href, $ndate, $users);
                        }
                        $return = array('id' => 0);
                        $return = json_encode($return);
                        $compressed = gzcompress($return, 9);
                        echo $compressed;
                    } else {
                        $data = array('userid' => $thisuserid, 'fid' => $_POST['idfl']);
                        $this->model->makeflw($data);
                        $resuser = $this->model->selectuser($thisuserid);
                        if ($resuser != FALSE) {
                            $rowuser = $resuser->fetch();
                            if ($rowuser['name'] != '' && $rowuser['family'] != '') {
                                $username = htmlspecialchars($rowuser['name']) . ' ' . htmlspecialchars($rowuser['family']);
                            } else {
                                $username = htmlspecialchars($rowuser['username']);
                            }
                            $text = $username . ' شما را دنبال می کند';
                            $href = 'blog/id/' . $rowuser['id'];
                            $ndate = Shamsidate::jdate('Y/m/d', time());
                            $users = array(htmlspecialchars($_POST['idfl']));
                            $this->addnote($text, $href, $ndate, $users);
                        }
                        $return = array('id' => 1);
                        $return = json_encode($return);
                        $compressed = gzcompress($return, 9);
                        echo $compressed;
                    }
                }
            }
        }
    }

    public function violation() {
        if (isset($_SESSION['isuser'])) {
            $data = array();
            $fields = array('subject', 'comment');
            if (Checkform::checkset($_POST, $fields)) {
                if (Checkform::checknotempty($_POST, $fields)) {

                    $userid = Session::get('userid');
                    $data = array('subjectv' => ($_POST['subject']), 'comment' => ($_POST['comment']), 'idpic' => ($_POST['imgid']), 'uid' => $userid);
                    $this->model->saveviolation($data);
                    $data = array('id' => '1', 'msg' => 'اطلاعات با موفقیت ثبت شد.');
                    $data = json_encode($data);
                    $compressed = gzcompress($data, 9);
                    echo $compressed;
                } else {       //all field requier
                    $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
                    $data = json_encode($data);
                    $compressed = gzcompress($data, 9);
                    echo $compressed;
                }
            } else {       //all field requier
                $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
                $data = json_encode($data);
                $compressed = gzcompress($data, 9);
                echo $compressed;
            }
        } else {
            
        }
    }

    public function loadknown() {
        $return = array('known' => '');
        if (isset($_POST['contact']) && !empty($_POST['contact'])) {
            $contacts = $_POST['contact'];
            $contacts = explode('@', $contacts);
            foreach ($contacts as $person) {
                $person = explode(':', $person);
                $prname = $person[0];
                $prnumber = $person[1];
                $cond = 'mobile=:mobile AND confirm=1 AND isban=0';
                $condata = array('mobile' => $prnumber);
                $result = $this->model->selectusername($cond, $condata);
                if ($result != FALSE) {
                    $row = $result->fetch();
                    if ($row['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $row['id']) . '.jpg';
                        $avat = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $avat = URL . '/images/avatar/' . $imgname;
                    }
                    if ($prname == '') {
                        if ($row['name'] != '' && $row['family'] != '') {
                            $prname = htmlspecialchars($row['name']) . ' ' . htmlspecialchars($row['family']);
                        } else {
                            $prname = htmlspecialchars($row['username']);
                        }
                    }

                    $return['known'].='<div class="details-user">
                                                                <a id="userproflnk" data-usid="' . $row['id'] . '">
                                                                    <div class="details-image">
                                                                        <img id="avtimg" src="' . $avat . '" class="img-circle " />
                                                                    </div>
                                                                    <div class="details-name">
                                                                        <h4 id="unameimg">' . $prname . '</h4>
                                                                    </div>
                                                                </a>
                                                            </div>';
                }
            }
        }
        $data = json_encode($return);
        $compressed = gzcompress($data, 9);
        echo $compressed;
    }

}
