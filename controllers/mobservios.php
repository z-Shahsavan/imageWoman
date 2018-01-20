<?php

class mobservios extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->view->render('error/index', $this->data);
    }

    public function mlogout($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'mlogout', 'Status' => 'success');
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنیتی نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
        $cond = 'id=:id';
        $condata = array('id' => $userid);
        $gcm = '';
        $this->model->gcmsave($gcm, $cond, $condata);
        $_SESSION = array();
        session_destroy();
        session_unset();
        $data = json_encode($return);
        echo $data;
    }

    public function register($input) {
        $da = base64_decode($input);
        $da = json_decode($da, true);
//        print_r($da);
//check username is english
        if (!Utilities::isenglish($da['Username'])) {
//username is not english
            $data = array('Status' => 'failed', 'Tag' => 'register', 'data' => array('Msg' => 'نام کاربری باید لاتین باشد'));
            $data = json_encode($data);
            echo $data;
            return FALSE;
        }

//check mobile number
        if (strlen(trim($da['Mobile'])) != 11 || Checkform::isinteger($da['Mobile']) == FALSE) {
//mobile not true
            $data = array('Status' => 'failed', 'Tag' => 'register', 'data' => array('Msg' => 'شماره موبایل وارد شده صحیح نیست'));
            $data = json_encode($data);
            echo $data;
            return FALSE;
        }


//check password
        if (strlen(trim($da['Password'])) < 6) {
//password is very small
            $data = array('Status' => 'failed', 'Tag' => 'register', 'data' => array('Msg' => 'رمز عبور باید حداقل شش کاراکتر باشد'));
            $data = json_encode($data);
            echo $data;
            return FALSE;
        }
        if (Checkform::isspecial($da['Password'], 2) == FALSE) {
//password is not secure
            $data = array('Status' => 'failed', 'Tag' => 'register', 'data' => array('Msg' => 'رمز عبور انتخابی شما امنیت پایینی دارد'));
            $data = json_encode($data);
            echo $data;
            return FALSE;
        }

//        if ($_POST['password'] != $_POST['confrim']) {
//            //password is not secure
//            $data = array('id' => '0', 'msg' => 'رمز عبور وارد شده با تکرار آن برابر نیست');
//            $data = json_encode($data);
//            $this->view->render('register/index', $data, false, 0);
//            return FALSE;
//        }
//check username not exist
        if ($this->model->checkuser($da['Username']) == FALSE) {
//check mobile not exist
            if ($this->model->checkmobile($da['Mobile']) == FALSE) {
                $data = array('username' => trim($da['Username']), 'password' => $da['Password'], 'mobile' => $da['Mobile']);
                $userid = $this->model->register($data);
                $actcode = Utilities::random(6);
//send sms in there
                $recnumber = $da['Mobile'];
                Caller::sms($recnumber, $actcode);
///////////////////////////////
                $data = array('userid' => $userid);
                $this->model->saveuser($data);
                $data = array('userid' => $userid, 'activecode' => md5($actcode), 'activtime' => time());
                $this->model->saveactivecode($data);
                $data = array('Status' => 'success', 'Tag' => 'register', 'data' => array('Msg' => 'ثبت نام شما با موفقیت انجام شد،منتظر پیامک حاوی کد تایید باشید '));
                $data = json_encode($data);
                echo $data;
                return FALSE;
            } else {
//mobile exist
                $data = array('Status' => 'failed', 'Tag' => 'register', 'data' => array('Msg' => 'این شماره موبایل قبلا ثبت شده است'));
                $data = json_encode($data);
                echo $data;
            }
        } else {
//username exist
            $data = array('Status' => 'failed', 'Tag' => 'register', 'data' => array('Msg' => 'این نام کاربری قبلا ثبت شده است'));
            $data = json_encode($data);
            echo $data;
        }
    }

    public function active($input) {
        $da = base64_decode($input);
        $da = json_decode($da, true);
        $result = $this->model->checkactcode(md5($da['VerifyCode']));
        if ($result != FALSE) {
            $row = $result->fetch();
            $this->model->deletecode(md5($da['VerifyCode']));
            $this->model->makeuseractive($row['userid']);
            $data = array('Status' => 'success', 'Tag' => 'active', 'data' => array('Msg' => 'فعال سازی با موفقییت انجام شد'));
            $data = json_encode($data);
            echo $data;
//                    $this->view->render('login/index', $data, false, 0);
        } else {
//active code not rrue
            $data = array('Status' => 'failed', 'Tag' => 'active', 'data' => array('Msg' => 'کد فعال سازی صحیح نمی باشد'));
            $data = json_encode($data);
            echo $data;
//                    $this->view->render('login/index', $data, false, 0);
        }
    }

    public function sendpass($input) {
        $da = base64_decode($input);
        $da = json_decode($da, true);
        $cond = 'mobile=:mobile';
        $condata = array('mobile' => $da['Mobile']);
        $result = $this->model->selecactivecod($cond, $condata);
        if ($result) {
            $row = $result->fetch();
            $id = $row['id'];
            if (time() > $row['activtime'] + 300) {
                $cond = 'mobile=:mobile';
                $condata = array('mobile' => $da['Mobile']);
                $result = $this->model->selectusername($cond, $condata);
                if ($result != FALSE) {
                    $row = $result->fetch();
                    if ($row['confirm'] == 1) {
                        if ($row['isban'] == 0) {
                            $actcode = Utilities::random(6);
                            $recnumber = $da['Mobile'];
                            Caller::forgotsms($recnumber, $actcode);
                            $cond = 'id=:id';
                            $condata = array('id' => $id);
                            $data = array('mobile' => $da['Mobile'], 'activecod' => md5($actcode), 'activtime' => time());
                            $this->model->updatenewpass($data, $cond, $condata);
//                            $msgid = 1;
                            $data = array('Status' => 'success', 'Tag' => 'sendpass', 'data' => array('Msg' => '', 'Username' => $row['username'], 'VerifyID' => $row['id']));
                            $data = json_encode($data);
                            echo $data;
                            Session::set('activecod', 22);
                            Session::set('mobile', $da['Mobile']);
                        } else {
//                            $msgid = 0;
//                            $msgtext = 'حساب کاربری شما مسدود شده است!';
                            $data = array('Status' => 'failed', 'Tag' => 'sendpass', 'data' => array('Msg' => 'حساب کاربری شما مسدود شده است!', 'Username' => $row['username']));
                            $data = json_encode($data);
                            echo $data;
                        }
                    } else {
//                        $msgid = 0;
//                        $msgtext = 'حساب کاربری شما فعال نیست!';
                        $data = array('Status' => 'failed', 'Tag' => 'sendpass', 'data' => array('Msg' => 'حساب کاربری شما فعال نیست!', 'Username' => $row['username']));
                        $data = json_encode($data);
                        echo $data;
                    }
                } else {
//                    $msgid = 0;
//                    $msgtext = 'اطلاعات وارد شده صحیح نیست!';
                    $data = array('Status' => 'failed', 'Tag' => 'sendpass', 'data' => array('Msg' => 'اطلاعات وارد شده صحیح نیست!', 'Username' => $row['username']));
                    $data = json_encode($data);
                    echo $data;
                }
            } else {
//                $msgid = 0;
//                $msgtext = 'شما به تازگی درخواست کد داده اید';
                $data = array('Status' => 'failed', 'Tag' => 'sendpass', 'data' => array('Msg' => 'شما به تازگی درخواست کد داده اید', 'Username' => $row['username']));
                $data = json_encode($data);
                echo $data;
            }
        } else {
            $cond = 'mobile=:mobile';
            $condata = array('mobile' => $da['Mobile']);
            $result = $this->model->selectusername($cond, $condata);
            if ($result != FALSE) {
                $row = $result->fetch();
                if ($row['confirm'] == 1) {
                    if ($row['isban'] == 0) {
                        $actcode = Utilities::random(6);
                        $recnumber = $da['Mobile'];
                        Caller::forgotsms($recnumber, $actcode);
                        $data = array('mobile' => $da['Mobile'], 'activecod' => $actcode, 'activtime' => time());
                        $this->model->insertnewpass($data);
//                        $msgid = 1;
                        $data = array('Status' => 'success', 'Tag' => 'sendpass', 'data' => array('Msg' => '', 'Username' => $row['username'], 'VerifyID' => $row['id']));
                        $data = json_encode($data);
                        echo $data;
                        Session::set('activecod', 22);
                        Session::set('mobile', $da['Mobile']);
                    } else {
//                        $msgid = 0;
//                        $msgtext = 'حساب کاربری شما مسدود شده است!';
                        $data = array('Status' => 'failed', 'Tag' => 'sendpass', 'data' => array('Msg' => 'حساب کاربری شما مسدود شده است!', 'Username' => $row['username']));
                        $data = json_encode($data);
                        echo $data;
                    }
                } else {
//                    $msgid = 0;
//                    $msgtext = 'حساب کاربری شما فعال نیست!';
                    $data = array('Status' => 'failed', 'Tag' => 'sendpass', 'data' => array('Msg' => 'حساب کاربری شما فعال نیست!', 'Username' => $row['username']));
                    $data = json_encode($data);
                    echo $data;
                }
            } else {
//                $msgid = 0;
//                $msgtext = 'اطلاعات وارد شده صحیح نیست!';
                $data = array('Status' => 'failed', 'Tag' => 'sendpass', 'data' => array('Msg' => 'اطلاعات وارد شده صحیح نیست!', 'Username' => $row['username']));
                $data = json_encode($data);
                echo $data;
            }
        }
    }

    public function checkcod($input) {
        $da = base64_decode($input);
        $da = json_decode($da, true);
        $cond = 'activecod=:activecod';
        $condata = array('activecod' => ($da['VerifyCode']));
        $result = $this->model->selectcod($cond, $condata);
        $cond = 'activtime < ' . (time() - 120);
        $resul = $this->model->delactivcod($cond);
        $cond = 'activecod=:activecod';
        $condata = array('activecod' => ($da['VerifyCode']));
        $res = $this->model->selectedcod($cond, $condata);
        if ($result == TRUE && $res == FALSE) {
            $data = array('Status' => 'expire', 'Tag' => 'checkcod', 'data' => array('Msg' => 'اعتبار زمانی کد فعال سازی تمام شده است'));
            $data = json_encode($data);
            echo $data;
            return FALSE;
        } elseif ($result == FALSE) {
            $data = array('Status' => 'failed', 'Tag' => 'checkcod', 'data' => array('Msg' => 'کد وارد شده معتبر نیست'));
            $data = json_encode($data);
            echo $data;
            return FALSE;
        } elseif ($result == TRUE) {
            $data = array('Status' => 'success', 'Tag' => 'checkcod', 'data' => array('Msg' => ''));
            $data = json_encode($data);
            echo $data;
            $row = $result->fetch();
            $cond = 'id=' . $row['id'];
            $this->model->delactivcod($cond);
            $cond = 'mobile=' . $row['mobile'];
            $resuser = $this->model->selecteduser($cond);
            $rowuser = $resuser->fetch();
            $msgtext = htmlspecialchars($rowuser['username']);
        }
    }

    public function newpass($input) {
        $da = base64_decode($input);
        $da = json_decode($da, true);
        if (isset($da['Password']) && isset($da['VerifyID'])) {
            $cond = 'id=:id';
            $condata = array('id' => $da['VerifyID']);
            $updata['password'] = (trim($da['Password']));
            $userid = $this->model->editregister($updata, $cond, $condata);
            $data = array('Status' => 'success', 'Tag' => 'newpass', 'data' => array('Msg' => 'پسورد شما با موفقیت تغییر یافت'));
            $data = json_encode($data);
            echo $data;
        } else {
            $data = array('Status' => 'failed', 'Tag' => 'newpass', 'data' => array('Msg' => 'لطفا تمام موارد را وارد نمایید'));
            $data = json_encode($data);
            echo $data;
        }
    }

    public function login($input) {
        $da = base64_decode($input);
        $da = json_decode($da, true);
        if (isset($da['Token'])) {
//            echo $da['Token'];
            $cond = 'token=:token';
            $data = array('token' => $da['Token']);
            $result = $this->model->login($cond, $data);
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
                        $data = array('Status' => 'success', 'Tag' => 'login', 'data' => array('Msg' => 'شما با موفقیت وارد شدید', 'Token' => md5(time() + $userid)));
                        $data = json_encode($data);
//                    $data = base64_encode($data);
                        echo $data;
                        $this->setscore($userid, 3);
                        return FALSE;
                    } else {
//user is ban
                        $data = array('Status' => 'failed', 'Tag' => 'login', 'data' => array('Msg' => 'اکانت شما مسدود شده است'));
                        $data = json_encode($data);
//                    $data = base64_encode($data);
                        echo $data;
                    }
                } else {
//acount not active
                    $data = array('Status' => 'failed', 'Tag' => 'login', 'data' => array('Msg' => 'حساب کاربری شما فعال نیست'));
                    $data = json_encode($data);
//                $data = base64_encode($data);
                    echo $data;
                }
            } else {
//login not true 
                $data = array('Status' => 'failed', 'Tag' => 'login', 'data' => array('Msg' => 'نام کاربری یا رمز عبور صحیح نیست'));
                $data = json_encode($data);
//            $data = base64_encode($data);
                echo $data;
            }
        } else {
            $cond = 'username=:username AND password=:password';
            $data = array('username' => $da['Username'], 'password' => $da['Password']);
            $result = $this->model->login($cond, $data);
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
                        $token = md5(time() + $userid);
                        Session::set('nameandfam', $nameandfamily);
                        Session::set('isuser', $rol);
                        Session::set('userid', $userid);
                        Session::set('lastlogin', $lastlogin);
                        Session::set('token', $token);
                        $data = array('loginip' => Utilities::userip(), 'lastlogin' => time(), 'token' => md5(time() + $userid), 'deviceld' => $da['DeviceId'], 'devicever' => $da['DeviceVer']);
                        $cond = 'id=:id';
                        $conddata = array('id' => $userid);
                        $this->model->setlogininfo($data, $cond, $conddata);
//login success
                        $data = array('Status' => 'success', 'Tag' => 'login', 'data' => array('Msg' => 'شما با موفقیت وارد شدید', 'Token' => md5(time() + $userid)));
                        $data = json_encode($data);
//                    $data = base64_encode($data);
                        echo $data;
                        $this->setscore($userid, 3);
                        return FALSE;
                    } else {
//user is ban
                        $data = array('Status' => 'failed', 'Tag' => 'login', 'data' => array('Msg' => 'اکانت شما مسدود شده است'));
                        $data = json_encode($data);
//                    $data = base64_encode($data);
                        echo $data;
                    }
                } else {
//acount not active
                    $data = array('Status' => 'failed', 'Tag' => 'login', 'data' => array('Msg' => 'حساب کاربری شما فعال نیست'));
                    $data = json_encode($data);
//                $data = base64_encode($data);
                    echo $data;
                }
            } else {
//login not true 
                $data = array('Status' => 'failed', 'Tag' => 'login', 'data' => array('Msg' => 'نام کاربری یا رمز عبور صحیح نیست'));
                $data = json_encode($data);
//            $data = base64_encode($data);
                echo $data;
            }
        }
    }

    public function lastcomps() {
        $i = 0;
//      $x=array('status'=>'','tag'=>'','data'=>array('CompetitionList'=>array(array('id'=>'','ImageUrl'=>'','name'=>''),array('id'=>'','ImageUrl'=>'','name'=>''))));
        $return = array('Status' => 'success', 'Tag' => 'lastcomps', 'data' => array('CompetitionList' => array()));
//        $data = array('fut' => '', 'now' => '', 'past' => '');
        $cond = 'isopen=3 ORDER by id DESC';
        $res = $this->model->others($cond);
        if ($res != FALSE) {
            while ($row = $res->fetch()) {
                $i++;
                if ($row['hasposter'] == 1) {
                    $imgurl = URL . 'images/poster/' . Utilities::imgname('poster', $row['id']) . '.jpg';
                    array_push($return['data']['CompetitionList'], array('ID' => $row['id'], 'ImageUrl' => $imgurl, 'Name' => $row['name'], 'StartDate' => Shamsidate::jdate('j F Y', $row['startdate']), 'EndDate' => Shamsidate::jdate('j F Y', $row['enddate']), 'Level' => $row['level']));
                } else {
                    array_push($return['data']['CompetitionList'], array('ID' => $row['id'], 'ImageUrl' => '', 'Name' => $row['name'], 'StartDate' => Shamsidate::jdate('j F Y', $row['startdate']), 'EndDate' => Shamsidate::jdate('j F Y', $row['enddate']), 'Level' => $row['level']));
                }
            }
            $data = json_encode($return);
            echo $data;
        } else {
            $return = array('Status' => 'failed', 'Tag' => 'lastcomps', 'data' => array('Msg' => 'مسابقه ای یافت نشد'));
            $data = json_encode($return);
            echo $data;
        }
    }

    public function nowcomps($input) {
        $da = base64_decode($input);
        $da = json_decode($da, true);
        if (isset($da['Token'])) {
            $token = $this->token($da['Token']);
            if ($token) {
                $i = 0;
//        $x=array('status'=>'','tag'=>'','data'=>array('CompetitionList'=>array(array('id'=>'','ImageUrl'=>'','name'=>''),array('id'=>'','ImageUrl'=>'','name'=>''))));
                $return = array('Status' => 'success', 'Tag' => 'nowcomps', 'data' => array('CompetitionList' => array()));
//        $data = array('fut' => '', 'now' => '', 'past' => '');
                $cond = 'isopen!=3 AND isopen!=0 ORDER by id DESC';
                $res = $this->model->others($cond);
                if ($res != FALSE) {
                    while ($row = $res->fetch()) {
                        $i++;
                        if ($row['hasposter'] == 1) {
                            $imgurl = URL . 'images/poster/' . Utilities::imgname('poster', $row['id']) . '.jpg';
                            array_push($return['data']['CompetitionList'], array('ID' => $row['id'], 'ImageUrl' => $imgurl, 'Name' => $row['name'], 'StartDate' => Shamsidate::jdate('j F Y', $row['startdate']), 'EndDate' => Shamsidate::jdate('j F Y', $row['enddate']), 'Level' => $row['level']));
                        } else {
                            array_push($return['data']['CompetitionList'], array('ID' => $row['id'], 'ImageUrl' => '', 'Name' => $row['name'], 'StartDate' => Shamsidate::jdate('j F Y', $row['startdate']), 'EndDate' => Shamsidate::jdate('j F Y', $row['enddate']), 'Level' => $row['level']));
                        }
                    }
                    $data = json_encode($return);
                    echo $data;
                } else {
                    $return = array('Status' => 'failed', 'Tag' => 'nowcomps', 'data' => array('Msg' => 'مسابقه ای یافت نشد'));
                    $data = json_encode($return);
                    echo $data;
                }
            } else {
                $return = array('Status' => 'failed', 'Tag' => 'nowcomps', 'data' => array('Msg' => 'token expire'));
                $data = json_encode($return);
                echo $data;
                return;
            }
        }
    }

    public function futcomps() {
        $i = 0;
//        $x=array('status'=>'','tag'=>'','data'=>array('CompetitionList'=>array(array('id'=>'','ImageUrl'=>'','name'=>''),array('id'=>'','ImageUrl'=>'','name'=>''))));
        $return = array('Status' => 'success', 'Tag' => 'futcomps', 'data' => array('CompetitionList' => array()));
//        $data = array('fut' => '', 'now' => '', 'past' => '');
        $cond = 'isopen=0 ORDER by id DESC';
        $res = $this->model->others($cond);
        if ($res != FALSE) {
            while ($row = $res->fetch()) {
                $i++;
                if ($row['hasposter'] == 1) {
                    $imgurl = URL . 'images/poster/' . Utilities::imgname('poster', $row['id']) . '.jpg';
                    array_push($return['data']['CompetitionList'], array('ID' => $row['id'], 'ImageUrl' => $imgurl, 'Name' => $row['name'], 'StartDate' => Shamsidate::jdate('j F Y', $row['startdate']), 'EndDate' => Shamsidate::jdate('j F Y', $row['enddate']), 'Level' => $row['level']));
                } else {
                    array_push($return['data']['CompetitionList'], array('ID' => $row['id'], 'ImageUrl' => '', 'Name' => $row['name'], 'StartDate' => Shamsidate::jdate('j F Y', $row['startdate']), 'EndDate' => Shamsidate::jdate('j F Y', $row['enddate']), 'Level' => $row['level']));
                }
            }
            $data = json_encode($return);
            echo $data;
        } else {
            $return = array('Status' => 'failed', 'Tag' => 'futcomps', 'data' => array('Msg' => 'مسابقه ای یافت نشد'));
            $data = json_encode($return);
            echo $data;
        }
    }

    public function imagecomp($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'imagecomp', 'Status' => 'success', 'Msg' => '', 'Page' => 1, 'TotalPage' => 1, 'Data' => array());
        if (!isset($input['CompetitionID'])) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنيتي نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
        if (isset($input['Page']) && $input['Page'] > 1) {
            $page = $input['Page'] * 12;
            $i = (($input['Page'] - 1) * 12) + 1;
            $return['Page'] = $input['Page'];
        } else {
            $return['Page'] = 1;
            $page = 12;
            $i = 1;
        }
        $cond = 'compid=:compid AND confirm=1';
        $condata = array('compid' => $input['CompetitionID']);
        $resphoto = $this->model->loadlastcomp($cond, $condata);
        if ($resphoto != FALSE) {
            $cnt = $resphoto->rowCount();
            $numofpage = ceil($cnt / 12);
            $return['TotalPage'] = $numofpage;
            $j = 1;
            while ($rowphoto = $resphoto->fetch()) {
                if ($j >= $i && $i <= $page) {
                    $cond = 'id=:id';
                    $condata = array('id' => $da['CompetitionID']);
                    $rescomp = $this->model->others($cond, $condata);
                    if ($rescomp != FALSE) {
                        $rwcomp = $rescomp->fetch();
                        $compname = $rwcomp['name'];
                    } else {
                        $compname = '';
                    }
                    $picname = Utilities::imgname('thumb', $rowphoto['id']) . '.jpg';
                    $picturname = URL . '/images/gallery/thumb/' . $picname;
                    $return['Status'] = 'success';
                    $return['Data']['Images'][] = array('ImageUrl' => $picturname, 'CompetitionName' => $compname, 'ImageName' => $rowphoto['name'], 'Rate' => $rowphoto['imglike'], 'Date' => Shamsidate::jdate('Y/m/d', $rowphoto['date']), 'ID' => $rowphoto['id']);

                    $i++;
                }
                $j++;
            }
        }
        $data = json_encode($return);
        echo $data;
    }

    public function detailcomp($input) {
        $da = base64_decode($input);
        $da = json_decode($da, true);
        $return = array('Status' => 'success', 'Tag' => 'detailcomp', 'data' => array('Level' => '', 'StartDate' => '', 'EndDate' => '', 'CompetitionName' => '', 'CountOfImage' => '', 'PublicCompetition' => '', 'Winners' => '', 'Selected' => '', 'PublicWinners' => '', 'Description' => '', 'Prize' => '', 'PrizePublic' => ''), 'Judges' => array());
        if (isset($da['CompetitionID'])) {
//            $cond = 'compid=:compid AND confirm=1';
//            $condata = array('compid' => $da['CompetitionID']);
//            $result = $this->model->loadlastcomp($cond, $condata);
//            if ($result != FALSE) {
//                while ($row = $result->fetch()) {
//                    $thmname = URL . 'images/gallery/thumb/' . Utilities::imgname('thumb', $row['id']) . '.jpg';
//                    $return['Imageurl'][] = $thmname;
//                }
//            }
            $cond = 'id=:id';
            $condata = array('id' => $da['CompetitionID']);
            $res = $this->model->others($cond, $condata);
            if ($res != FALSE) {
                $row = $res->fetch();
                $dvs = $this->loadvs($row['id']);
                if (($row['peopelwinno'] == 0) && ($row['peoplewinprise'] == 0)) {
                    $ispeople = 'ندارد';
                } else {
                    $ispeople = 'دارد';
                }
                $return['data']['CompetitionName'] = $row['name'];
                $return['data']['Level'] = $row['level'];
                $return['data']['StartDate'] = Shamsidate::jdate('Y/m/d', $row['startdate']);
                $return['data']['EndDate'] = Shamsidate::jdate('Y/m/d', $row['enddate']);
                $return['data']['CountOfImage'] = $row['numofpic'];
                $return['data']['PublicCompetition'] = $ispeople;
                $return['data']['Winners'] = $row['winno'];
                $return['data']['Selected'] = $row['selno'];
                $return['data']['PublicWinners'] = $row['peopelwinno'];
                $return['data']['Description'] = $row['decription'];
                $return['data']['Prize'] = $row['prise'];
                $return['data']['PrizePublic'] = $row['peoplewinprise'];
                $return['Judges'] = $dvs;
//                $return['Imageurl'] = $dvs;
//        }}
//            }Judges
            }
            $data = json_encode($return);
            echo $data;
        }
    }

    public function selected($input) {
        $da = base64_decode($input);
        $da = json_decode($da, true);
        $return = array('Status' => 'failed', 'Tag' => 'selected', 'data' => array('Msg' => '', 'Selected' => array()));
        if (isset($da['CompetitionID'])) {
            $cond = 'compid=:compid AND confirm=1';
            $condata = array('compid' => $da['CompetitionID']);
            $result = $this->model->loadlastcomp($cond, $condata);
            if ($result != FALSE) {
                while ($row = $result->fetch()) {
                    if ($row['iswin'] == 2 || $row['iswin'] == 5) {
//                        $userid = $this->token($da['Token']);
//                        $resuser = $this->model->selectuser($userid);
//                        if ($resuser != FALSE) {
//                            $rowuser = $resuser->fetch();
//                            $userprfid = $rowuser['id'];
//                            if ($rowuser['name'] != '' && $rowuser['family'] != '') {
//                                $username = $rowuser['name'] . ' ' . $rowuser['family'];
//                            } else {
//                                $username = $rowuser['username'];
//                            }
                        $imgurl = URL . 'images/gallery/thumb/' . Utilities::imgname('thumb', $row['id']) . '.jpg';
                        $montakhab = $this->model->selectuser($row['userid']);
                        if ($montakhab != FALSE) {
                            $monavatar = $montakhab->fetch();
                            if ($monavatar['isavatar'] == 1) {
                                $imgname = Utilities::imgname('avatar', $monavatar['id']) . '.jpg';
                                $avatar = URL . '/images/avatar/' . $imgname;
                            } else {
                                $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                                $avatar = URL . '/images/avatar/' . $imgname;
                            }
                            if ($monavatar['name'] != '' && $monavatar['family'] != '') {
                                $username = $monavatar['name'] . ' ' . $monavatar['family'];
                            } else {
                                $username = $monavatar['username'];
                            }
                        }

//                            $return['montakhab'].='<li class="col-md-4 col-sm-4 col-xs-4">
//                                                <img id="imgdttopg" data-imgid="' . $row['id'] . '" src="' . URL . 'images/gallery/thumb/' . $thmname . '" class="img-responsive" />
//                                        </li>';
                        $return['Status'] = 'success';
                        $return['data']['Selected'][] = array('ID' => $row['id'], 'ImageUrl' => $imgurl, 'ImageName' => $row['name'], 'WinnerName' => $username, 'AvatarUrl' => $avatar);
//                        }
                    }
                }
                $data = json_encode($return);
                echo $data;
            }
        }
    }

    public function giveprize($input) {
        $da = base64_decode($input);
        $da = json_decode($da, true);
        $return = array('Status' => 'success', 'Tag' => 'giveprize', 'data' => array('Msg' => '', 'Description' => '', 'Video' => ''), 'Image' => array());
        if (isset($da['CompetitionID'])) {
            $res = $this->model->prizes('cmpid=:cid order by type', array('cid' => $da['CompetitionID']));
            if ($res) {
                $row = $res->fetch();
                $vid = '';
                $imgs = array();
                $return['data']['Description'] = $row['comment'];
                $i = 0;
                do {
                    if ($row['type'] == 1) {
                        $srcvid = Utilities::imgname('film', $row['pfid']) . '.mp4';
                        $return['data']['Video'] = URL . '/prize/film/' . $srcvid;
                    }
                    if ($row['type'] == 0) {
                        //$imgname = Utilities::imgname('image', $row['pfid']) . '.jpg' . '?' . $i;
                        $srcimg = Utilities::imgname('thumb', $row['pfid']) . '.jpg';
                        $imgs = URL . 'prize/thumb/' . $srcimg;
                        $return['Image'][] = array('ImageUrl' => $imgs);
                    }
                    $i++;
                } while ($row = $res->fetch());

                $data = json_encode($return);
                echo $data;
            } else {
                $return = array('Status' => 'failed', 'Tag' => 'giveprize', 'data' => array('Msg' => 'موردی یافت نشد'));
                $data = json_encode($return);
                echo $data;
            }
        }
    }

    public function winner($input) {
        $da = base64_decode($input);
        $da = json_decode($da, true);
        $return = array('Status' => 'success', 'Tag' => 'winner', 'data' => array('Msg' => '', 'Winner' => array()));
        if (isset($da['CompetitionID'])) {
            $cond = 'compid=:compid AND confirm=1';
            $condata = array('compid' => $da['CompetitionID']);
            $result = $this->model->loadlastcomp($cond, $condata);
            if ($result != FALSE) {
                while ($row = $result->fetch()) {
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
                            $imgname = URL . 'images/gallery/thumb/' . Utilities::imgname('thumb', $rowwin['imgid']) . '.jpg';
                            $return['data']['Winner'][] = array('ID' => $row['id'], 'ImageUrl' => $imgname, 'Ispublic' => $ismardom, 'Avatar' => $avatar, 'ImageName' => $row['name'], 'WinnerName' => $username, 'Pris' => $rowwin['price'], 'Rank' => $rowwin['rate']);
                        }
                    }
                }
                $data = json_encode($return);
                echo $data;
            }
        }
    }

    public function loadlastcomp() {
        $fields = array('compid');
        $return = array('images' => '<ul>', 'compname' => '', 'info' => '', 'montakhab' => '<ul>', 'winer' => '<div class="winners">', 'jayeze' => '');
//check isset
//        if (Checkform::checkset($_POST, $fields)) {
//check not empty
//            if (Checkform::checknotempty($_POST, $fields)) {
//        if (isset($da['Token'])) {
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
            if (($row['peopelwinno'] == 0 ) && ($row['peoplewinprise'] == 0)) {
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
//        }}
//            }
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
                    if (($row['peopelwinno'] == 0 ) && ($row['peoplewinprise'] == 0)) {
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
                    if (($row['peopelwinno'] == 0 ) && ($row['peoplewinprise'] == 0)) {
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
        $dlist = array();
        if ($res) {
            while ($row = $res->fetch()) {
                $result = $this->model->selectuser($row['did']);
                $rw = $result->fetch();
                if ($rw['isavatar'] == 1) {
                    $imgname = URL . '/images/avatar/' . Utilities::imgname('avatar', $rw['id']) . '.jpg';
                } else {
                    $imgname = URL . '/images/avatar/' . Utilities::imgname('avatar', 'default') . '.jpg';
                }

                if ($row['name'] != '' && $row['family'] != '') {
                    $userandfam = $row['name'] . ' ' . $row['family'];
                } else {
                    $userandfam = $row['username'];
                }
                array_push($dlist, array('id' => $rw['id'], 'avatarimg' => $imgname, 'name' => $userandfam));

//                $dlist.='<div class="name-referees">
//                                                <a id="userproflnk" data-usid="' . $rw['id'] . '">
//                                                    <div class="referee-image">
//                                                        <img src="' . URL . '/images/avatar/' . $imgname . '" class="img-circle " />
//                                                    </div>
//                                                    <div class="referee-name">
//                                                        <h4>' . $userandfam . '</h4>
//                                                    </div>
//                                                </a>
//                                            </div>';
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

    public function singleimage($input) {
        $da = base64_decode($input);
        $da = json_decode($da, true);
//        $fields = array('imgid');
        $return = array('Status' => 'success', 'Tag' => 'singleimage', 'data' => array('ImageUrl' => '', 'ImageID' => '', 'IsRating' => '', 'ImageName' => '', 'CompetitionName' => '', 'UserRate' => '', 'rate' => '', 'Avatar' => '', 'User' => '', 'UserID' => '', 'Date' => '', 'Description' => ''));
//check isset
//        if (Checkform::checkset($_POST, $fields)) {
//check not empty
//            if (Checkform::checknotempty($_POST, $fields)) {
        $resbazbin = $this->model->bazbinrate($da['ID']);
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
        $condata = array('id' => $da['ID']);
        $result = $this->model->loadlastcomp($cond, $condata);
        if ($result != FALSE) {
            $row = $result->fetch();
            $return['data']['ImageName'] = $row['name'];
            $return['data']['rate'] = $row['refrate'];
            $return['data']['Date'] = Shamsidate::jdate('Y/m/d', $row['date']);
            $return['data']['Description'] = $row['comment'];
            $thmname = Utilities::imgname('thumb', $row['id']) . '.jpg';
            $return['data']['ImageID'] = $row['id'];
            $return['data']['ImageUrl'] = URL . 'images/gallery/thumb/' . $thmname;
            $cond = 'id=:id';
            $condata = array('id' => $row['compid']);
            $rescomp = $this->model->others($cond, $condata);
            if ($rescomp != FALSE) {
                $rowcomp = $rescomp->fetch();
                $return['data']['CompetitionName'] = $rowcomp['name'];
                if ($rowcomp['peopelwinno'] != 0) {
                    $ispeople = 1;
                } else {
                    $ispeople = 0;
                }
//if (($rowcomp['startdate'] < (time() - (24 * 3600))) && ((time() - (48 * 3600)) < $rowcomp['enddate']) && $ispeople == 1 && $rateforthis == TRUE) {
                if (((time() - (48 * 3600 ) ) < $rowcomp['enddate'] ) && $ispeople == 1) {
//                    $userid = Session::get('userid');
                    $userid = $this->token($da['Token']);
                    $resr = $this->model->loadrate($row['id'], $userid);
                    if ($resr) {
                        $rowrate = $resr->fetch();
                        $rate = $rowrate['rate'];
                    } else {
                        $rate = -1;
                    }
                    $return['data']['UserRate'] = $rate;
                    $return['data']['IsRating'] = 1;
                } else {
                    $return['data']['IsRating'] = 0;
                }
            }
        }
        $resuser = $this->model->selectuser($row['userid']);
        if ($resuser != FALSE) {
            $rowuser = $resuser->fetch();
            $return['data']['UserID'] = $rowuser['id'];
            if ($rowuser['name'] != '' && $rowuser['family'] != '') {
                $return['data']['User'] = $rowuser['name'] . ' ' . $rowuser['family'];
            } else {
                $return['data']['User'] = $rowuser['username'];
            }

            if ($rowuser['isavatar'] == 1) {
                $imgname = Utilities::imgname('avatar', $rowuser['id']) . '.jpg';
                $return['data']['Avatar'] = URL . '/images/avatar/' . $imgname;
            } else {
                $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                $return['data']['Avatar'] = URL . '/images/avatar/' . $imgname;
            }
        } else {
            $return['data']['username'] = '';
            $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
            $return['data']['Avatar'] = URL . '/images/avatar/' . $imgname;
        }
//            }
//        }
        $data = json_encode($return);
//        $compressed = gzcompress($data, 9);
        echo $data;
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

    public function searchs($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'searchs', 'Status' => 'success', 'Msg' => '', 'Page' => 1, 'TotalPage' => 1, 'data' => array());
        $return['Page'] = 1;
        $page = 12;
        $d = 1;
        if (isset($input['Text'])) {
            if ($input['Text'] == "") {
                $cond = 'confirm=1 ORDER BY pid DESC';
                $condata = array();
            } else {
                $word = explode(' ', ($input['Text']));
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
                $cond.=') ORDER BY pid DESC';
            }
        }

        if (isset($input['Page']) && $input['Page'] > 1) {
            $page = $input['Page'] * 12;
            $d = (($input['Page'] - 1) * 12) + 1;

            $return['Page'] = $input['Page'];
        } else {
            $return['Page'] = 1;
            $page = 12;
            $d = 1;
        }

        $photo = $this->model->searchphot($cond, $condata);
        if ($photo != FALSE) {
            $cnt = $photo->rowCount();
            $numofpage = ceil($cnt / 12);
            $return['TotalPage'] = $numofpage;
            $j = 1;
            while ($row = $photo->fetch()) {
                if ($row['username'] == '') {
                    $username = $row['uname'] . ' ' . $row['fname'];
                } else {
                    $username = $row['username'];
                }
//                 echo '/'.$j.'/'.$d.'/'.$page.'/////';
                if ($j >= $d && $d <= $page) {

                    $picname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                    $picturname = URL . '/images/gallery/thumb/' . $picname;
                    $return['data']['Images'][] = array('ImageUrl' => $picturname, 'CompetitionName' => $row['cname'], 'ImageName' => $row['pn'], 'UserName' => $username, 'Rate' => $row['imglike'], 'Date' => Shamsidate::jdate('Y/m/d', $row['pdate']), 'ID' => $row['pid']);
                    $return['Status'] = 'success';
                    $d++;
                }
                $j++;
            }

            if ($return['TotalPage'] < $return['Page']) {
                $return = array('Tag' => 'searchs', 'Status' => 'failed', 'data' => array('Msg' => 'موردی یافت نشد!'));
                $data = json_encode($return);
                echo $data;
            } else {
                $data = json_encode($return);
                echo $data;
            }
        } else {
            $return = array('Tag' => 'searchs', 'Status' => 'failed', 'data' => array('Msg' => 'موردی یافت نشد!'));
            $data = json_encode($return);
            echo $data;
        }
    }

    public function searchtag($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'searchtag', 'Status' => 'success', 'Msg' => '', 'Page' => 1, 'TotalPage' => 1, 'data' => array());
        $return['Page'] = 1;
        $page = 12;
        $d = 1;
//        echo $input['Tag'];
        if ($input['Tag'] == '') {
            $cond = 'confirm=1 ORDER BY pid DESC';
            $condata = array();
        } else {
            $cond = 'confirm=1 AND tags LIKE :data ORDER BY pid DESC';
            $condata['data'] = ',' . $input['Tag'] . ',';
        }

        if (isset($input['Page']) && $input['Page'] > 1) {
            $page = $input['Page'] * 12;
            $d = (($input['Page'] - 1) * 12) + 1;
            $return['Page'] = $input['Page'];
        } else {
            $return['Page'] = 1;
            $page = 12;
            $d = 1;
        }

        $photo = $this->model->searchphot($cond, $condata);
        if ($photo != FALSE) {
            $cnt = $photo->rowCount();
            $numofpage = ceil($cnt / 12);
            $return['TotalPage'] = $numofpage;
            $j = 1;
            while ($row = $photo->fetch()) {
                if ($row['username'] == '') {
                    $username = $row['uname'] . ' ' . $row['fname'];
                } else {
                    $username = $row['username'];
                }
                if ($j >= $d && $d <= $page) {
                    $picname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                    $picturname = URL . '/images/gallery/thumb/' . $picname;
                    $return['data']['Images'][] = array('ImageUrl' => $picturname, 'CompetitionName' => $row['cname'], 'ImageName' => $row['pn'], 'UserName ' => $username, 'Rate' => $row['imglike'], 'Date' => Shamsidate::jdate('Y/m/d', $row['pdate']), 'ID' => $row['pid']);
                    $return['Status'] = 'success';
                    $d++;
                }
                $j++;
            }
            $data = json_encode($return);
            echo $data;
        } else {
            $return = array('Tag' => 'searchtag', 'Status' => 'failed', 'data' => array('Msg' => 'موردی یافت نشد!'));
            $data = json_encode($return);
            echo $data;
        }
    }

    public function searchuser($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'searchuser', 'Status' => 'success', 'Msg' => '', 'Page' => 1, 'TotalPage' => 1, 'data' => array());
        $return['Page'] = 1;
        $page = 12;
        $d = 1;
        if ($input['Text'] == '') {
            $cond = 'confirm=1 ORDER BY pid DESC';
            $condata = array();
        } else {
            $cond = 'confirm=1 AND username=:username ORDER BY pid DESC';
            $condata = array('username' => $input['Text']);
        }

        if (isset($input['Page']) && $input['Page'] > 1) {
            $page = $input['Page'] * 12;
            $d = (($input['Page'] - 1) * 12) + 1;
            $return['Page'] = $input['Page'];
        } else {
            $return['Page'] = 1;
            $page = 12;
            $d = 1;
        }

        $photo = $this->model->searchphot($cond, $condata);
        if ($photo != FALSE) {
            $cnt = $photo->rowCount();
            $numofpage = ceil($cnt / 12);
            $return['TotalPage'] = $numofpage;
            $j = 1;
            while ($row = $photo->fetch()) {
                if ($row['username'] == '') {
                    $username = $row['uname'] . ' ' . $row['fname'];
                } else {
                    $username = $row['username'];
                }
                if ($j >= $d && $d <= $page) {
                    $picname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                    $picturname = URL . '/images/gallery/thumb/' . $picname;
                    $return['data']['Images'][] = array('ImageUrl' => $picturname, 'CompetitionName' => $row['cname'], 'ImageName' => $row['pn'], 'UserName ' => $username, 'Rate' => $row['imglike'], 'Date' => Shamsidate::jdate('Y/m/d', $row['pdate']), 'ID' => $row['pid']);
                    $return['Status'] = 'success';
                    $d++;
                }
                $j++;
            }
            $data = json_encode($return);
            echo $data;
        } else {
            $return = array('Tag' => 'searchuser', 'Status' => 'failed', 'data' => array('Msg' => 'موردی یافت نشد!'));
            $data = json_encode($return);
            echo $data;
        }
    }

    public function searchplaces($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'searchplaces', 'Status' => 'success', 'Msg' => '', 'Page' => 1, 'TotalPage' => 1, 'data' => array());
        $return['Page'] = 1;
        $page = 12;
        $d = 1;

        if (isset($input['Page']) && $input['Page'] > 1) {
            $page = $input['Page'] * 12;
            $d = (($input['Page'] - 1) * 12) + 1;
            $return['Page'] = $input['Page'];
        } else {
            $return['Page'] = 1;
            $page = 12;
            $d = 1;
        }

        if ($input['Text'] == '') {
            if ($input['StateID'] == 0) {
                $cond = 'confirm=1 ORDER BY pid DESC';
                $condata = array();
            } else {
                $cond = 'locateid=:locateid AND confirm=1 ORDER BY pid DESC';
                $condata = array('locateid' => $input['StateID']);
            }
        } else {
            if ($input['StateID'] == 0) {
                $word = explode(' ', ($input['Text']));
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
            } else {
                $word = explode(' ', ($input['Text']));
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
                $condata['locateid'] = $input['StateID'];
            }
        }
        $photo = $this->model->searchphot($cond, $condata);
        if ($photo != FALSE) {
            $cnt = $photo->rowCount();
            $numofpage = ceil($cnt / 12);
            $return['TotalPage'] = $numofpage;
            $j = 1;
            while ($row = $photo->fetch()) {
                if ($row['username'] == '') {
                    $username = $row['uname'] . ' ' . $row['fname'];
                } else {
                    $username = $row['username'];
                }
                if ($j >= $d && $d <= $page) {
                    $picname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                    $picturname = URL . '/images/gallery/thumb/' . $picname;
                    $return['data']['Images'][] = array('ImageUrl' => $picturname, 'CompetitionName' => $row['cname'], 'ImageName' => $row['pn'], 'UserName ' => $username, 'Rate' => $row['imglike'], 'Date' => Shamsidate::jdate('Y/m/d', $row['pdate']), 'ID' => $row['pid']);
                    $return['Status'] = 'success';
                    $d++;
                }
                $j++;
            }
            $data = json_encode($return);
            echo $data;
        } else {
            $return = array('Tag' => 'searchplaces', 'Status' => 'failed', 'data' => array('Msg' => 'موردی یافت نشد!'));
            $data = json_encode($return);
            echo $data;
        }
    }

    public function searchcomp($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        //????$input['Type'] echo nemishavad vali echo 12,12ra echo mikonad????
//        echo $input['Type'];
        $return = array('Tag' => 'searchcomp', 'Status' => 'success', 'Msg' => '', 'Page' => 1, 'TotalPage' => 1, 'data' => array());
        $return['Page'] = 1;
        $page = 12;
        $d = 1;

        if (isset($input['Page']) && $input['Page'] > 1) {
            $page = $input['Page'] * 12;
            $d = (($input['Page'] - 1) * 12) + 1;
            $return['Page'] = $input['Page'];
        } else {
            $return['Page'] = 1;
            $page = 12;
            $d = 1;
        }

        if (isset($input['Type'])) {
            switch ($input['Type']) {
                case 1:
                    $cond = 'confirm=1 ORDER BY cid DESC';
                    $condata = array();
                    break;
                case 2:
                    $cond = 'confirm=1 ORDER BY numofpic DESC';
                    $condata = array();
                    break;
                case 3:
                    if ($input['CompetitionID'] == 0) {
                        $cond = 'confirm=1 ORDER BY cid DESC';
                        $condata = array();
                    } else {
                        $cond = 'cid=:cid AND confirm=1 ORDER BY pid DESC';
                        $condata = array('cid' => $input['CompetitionID']);
                    }
                    break;
                case 4:
                    if (($input['FromDate'] ) != '' && ($input['ToDate'] ) != '') {
                        $stime = explode('/', $input['FromDate']);
                        $st = Shamsidate::jmktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
                        $etime = explode('/', $input['ToDate']);
                        $en = Shamsidate::jmktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);
                        $cond = '(startdate>=:startdate AND enddate<=:enddate) AND confirm=1 ORDER BY pid DESC';
                        $condata = array('startdate' => $st, 'enddate' => $en);
                        $begin = $stime[0] . '/' . $stime[1] . '/' . $stime[2];
                        $finish = $etime[0] . '/' . $etime[1] . '/' . $etime[2];
                        $infsearchcomp = 'بازه زمانی ' . $begin . ' تا ' . $finish;
                    } else {
                        $cond = 'confirm=1 ORDER BY cid DESC';
                        $condata = array();
                    }
                    break;
            }
            $photo = $this->model->searchphot($cond, $condata);
            if ($photo != FALSE) {
                $cnt = $photo->rowCount();
                $numofpage = ceil($cnt / 12);
                $return['TotalPage'] = $numofpage;
                $j = 1;
                while ($row = $photo->fetch()) {
                    if ($row['username'] == '') {
                        $username = $row['uname'] . ' ' . $row['fname'];
                    } else {
                        $username = $row['username'];
                    }
                    if ($j >= $d && $d <= $page) {
                        $picname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                        $picturname = URL . '/images/gallery/thumb/' . $picname;
                        $return['data']['Images'][] = array('ImageUrl' => $picturname, 'CompetitionName' => $row['cname'], 'ImageName' => $row['pn'], 'UserName ' => $username, 'Rate' => $row['imglike'], 'Date' => Shamsidate::jdate('Y/m/d', $row['pdate']), 'ID' => $row['pid']);
                        $return['Status'] = 'success';
                        $d++;
                    }
                    $j++;
                }
                $data = json_encode($return);
                echo $data;
            } else {
                $return = array('Tag' => 'searchcomp', 'Status' => 'failed', 'data' => array('Msg' => 'موردی یافت نشد'));
                $data = json_encode($return);
                echo $data;
            }
        } else {
            $return = array('Tag' => 'searchcomp', 'Status' => 'failed', 'data' => array('Msg' => 'اطلاعات ورودی کافی نیست'));
            $data = json_encode($return);
            echo $data;
        }
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
                                    } elseif (($_POST['searchcompname'] ) != '') {
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
                                        if (($_POST['tarikh1'] ) != '' && ($_POST['tarikh2'] ) != '') {
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
                                        if (($_POST['tarikh1'] ) != '' && ($_POST['tarikh2'] ) != '') {
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
                        $imgname = Utilities::imgname('avatar', $row['pid']) . '.jpg';
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

    public function uploadpic() {
        $fields = array('CompetitionID', 'Token');
        $return = array('Tag' => 'uploadpic', 'Status' => 'success', 'Msg' => '');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                //check file
                $res = Photoutil::photocheck('0');
                switch ($res) {
                    case 1:
                        //file not post
                        $return['Status'] = 'failed';
                        $return['Msg'] = 'لطفا یک فایل انتخاب کنید';
                        $data = json_encode($return);
                        echo $data;
                        return;
                        break;
                    case 2:
                        //mimetype not true
                        $return['Status'] = 'failed';
                        $return['Msg'] = 'پسوند فایل صحیح نمی باشد';
                        $data = json_encode($return);
                        echo $data;
                        return;
                        break;
                    case 3:
                        //image is corrupted
                        $return['Status'] = 'failed';
                        $return['Msg'] = 'عکس شما دارای مشکل است';
                        $data = json_encode($return);
                        echo $data;
                        return;
                        break;
                    case 4:
                        //image size not true
                        $return['Status'] = 'failed';
                        $return['Msg'] = 'اندازه عکس مناسب نیست';
                        $data = json_encode($return);
                        echo $data;
                        return;
                        break;
                    case 5:
                        //image file size not true
                        $return['Status'] = 'failed';
                        $return['Msg'] = 'حجم فایل مناسب نیست';
                        $data = json_encode($return);
                        echo $data;
                        return;
                        break;
                }
                $userid = $this->token($_POST['Token']);
                if ($userid != FALSE) {
                    //save image
                    $cond = 'id=:id';
                    if (isset($_POST['StateID']) && !empty($_POST['StateID'])) {
                        $condata = array('id' => $_POST['StateID']);
                    } else {
                        $condata = array('id' => 32);
                    }
                    $re = $this->model->citynam($cond, $condata);
                    if ($re) {
                        $row = $re->fetch();
                        $locname = $row['state'];
                    }
                    if (isset($_POST['Date']) && !empty($_POST['Date'])) {
                        $data = explode('-', $_POST['Date']);
                        $st = Shamsidate::jmktime(0, 0, 0, $data[1], $data[2], $data[0]);
                    } else {
                        $st = time();
                    }

                    if (isset($_POST['ImageTags']) && !empty($_POST['ImageTags'])) {
                        $hashtag = ',' . $_POST['ImageTags'] . ',';
                    } else {
                        $hashtag = '';
                    }
                    if (isset($_POST['Title']) && !empty($_POST['Title'])) {
                        $name = $_POST['Title'];
                    } else {
                        $name = 'بدون نام';
                    }
                    if (isset($_POST['Description']) && !empty($_POST['Description'])) {
                        $comment = $_POST['Description'];
                    } else {
                        $comment = '';
                    }
                    $data = array('userid' => $userid, 'name' => htmlspecialchars($name), 'tags' => htmlspecialchars($hashtag), 'locate' => htmlspecialchars($locname), 'date' => $st, 'comment' => htmlspecialchars($comment), 'compid' => $_POST['CompetitionID'], 'refrate' => 0);
                    $result = $this->model->saveimage($data);
                    Photoutil::saveimgandthumb($result, $res, 0);
                    //add to user photonumber
                    $this->model->edituser($userid);
                    $return['Status'] = 'success';
                    $return['Msg'] = 'عکس شما با موفقیت ذخیره شد';
                    $data = json_encode($return);
                    echo $data;
                    return;
                } else {
                    $return['Status'] = 'failed';
                    $return['Msg'] = 'اطلاعات امنیتی صحیح نیست';
                    $data = json_encode($return);
                    echo $data;
                    return;
                }
            } else {
                //all field requier
                $return['Status'] = 'failed';
                $return['Msg'] = 'لطفا تمامی موارد را وارد نمایید';
                $data = json_encode($return);
                echo $data;
                return;
            }
        } else {
            //all field requier
            $return['Status'] = 'failed';
            $return['Msg'] = 'لطفا تمامی موارد را وارد نمایید';
            $data = json_encode($return);
            echo $data;
        }
    }

    public function changeavatar() {
        $return = array('Tag' => 'changeavatar', 'Status' => 'success', 'Msg' => '');
        if (isset($_POST['Token']) && !empty($_POST['Token'])) {
            $userid = $this->token($_POST['Token']);
            if ($userid != FALSE) {
                $updata = array();
                //check avatar
                $avatar = Photoutil::avatarcheck('vatar');
                $isavatar = FALSE;
                switch ($avatar) {
                    case 1:
                        $isavatar = FALSE;
                        break;
                    case 2:
                        //avatar photo not true
                        $return['Status'] = 'failed';
                        $return['Msg'] = 'فرمت تصویر انتخابی  مجاز نیست';
                        $data = json_encode($return);
                        $this->view->render('setting/index', $data, false, 0);
                        return;
                        break;
                    case 3:
                        $return['Status'] = 'failed';
                        $return['Msg'] = 'تصویر انتخابی دارای مشکل است';
                        $data = json_encode($return);
                        $this->view->render('setting/index', $data, false, 0);
                        return;
                        break;
                    default :
                        $isavatar = TRUE;
                        break;
                }
                if ($isavatar == TRUE) {
                    $imgname = Utilities::imgname('avatar', $userid) . '.jpg';
                    Photoutil::convertImage($_FILES['vatar']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . '/images/avatar/' . $imgname, $avatar, 100);
                    Photoutil::make_thumbacatar($_SERVER['DOCUMENT_ROOT'] . '/' . PROJECTNAME . '/images/avatar/' . $imgname, $_SERVER['DOCUMENT_ROOT'] . '/' . PROJECTNAME . '/images/avatar/' . $imgname, 200);
                    $updata['isavatar'] = 1;
                }
                $cond = 'id=:id';
                $condata = array('id' => $userid);
                $this->model->editavatar($updata, $cond, $condata);

                $return['Status'] = 'success';
                $return['Msg'] = 'تغییرات شما ثبت شد';
                $data = json_encode($return);
                $this->view->render('setting/index', $data, false, 0);
                return;
            } else {
                $return['Status'] = 'failed';
                $return['Msg'] = 'اطلاعات امنیتی صحیح نیست';
                $data = json_encode($return);
                echo $data;
            }
        } else {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنیتی صحیح نیست';
            $data = json_encode($return);
            echo $data;
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

    public function abusereport($input) {
        $da = base64_decode($input);
        $da = json_decode($da, true);

        $fields = array('Token', 'Text', 'ImageID', 'Title');

        if (isset($da['Text'])) {
            if (strlen($da['Text']) != 0) {
//                $userid = Session::get('userid');
                $userid = $this->token($da['Token']);
                if ($userid == FALSE) {
//                    echo 1;
//                    $return['msgid'] = 0;
//                    $return['msgtxt'] = 'خطا در ارسال اطلاعات!';
                    $return = array('Status' => 'failed', 'Tag' => 'abusereport', 'data' => array('Msg' => 'خطا در ارسال اطلاعات!'));
                } else {
//                      echo 2;
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
                        $data = array('subjectv' => htmlspecialchars($da['Title']), 'comment' => htmlspecialchars($da['Text']), 'idpic' => htmlspecialchars($da['ImageID']), 'uid' => $userid);
                        $id = $this->model->saveviolation($data);
                        if ($id != null) {
//                            $return['msgid'] = 1;
//                            $return['msgtxt'] = 'پیام شما با موفقیت ثبت شد';
                            $return = array('Status' => 'success', 'Tag' => 'abusereport', 'data' => array('Msg' => 'پیام شما با موفقیت ثبت شد'));
                        } else {
//                            $return['msgid'] = 0;
//                            $return['msgtxt'] = 'خطا در ارسال اطلاعات!';
                            $return = array('Status' => 'failed', 'Tag' => 'abusereport', 'data' => array('Msg' => 'خطا در ارسال اطلاعات!'));
                        }
                    } else {
//                        $return['msgid'] = 0;
//                        $return['msgtxt'] = 'خطا در ارسال اطلاعات!';
                        $return = array('Status' => 'failed', 'Tag' => 'abusereport', 'data' => array('Msg' => 'خطا در ارسال اطلاعات!'));
                    }
                }
            } else {
//                $return['msgid'] = 0;
//                $return['msgtxt'] = 'لطفا پیام خود را وارد نمایید';
                $return = array('Status' => 'failed', 'Tag' => 'abusereport', 'data' => array('Msg' => 'لطفا پیام خود را وارد نمایید'));
            }
        } else {
//            $return['msgid'] = 0;
//            $return['msgtxt'] = 'لطفا پیام خود را وارد نمایید';
            $return = array('Status' => 'failed', 'Tag' => 'abusereport', 'data' => array('Msg' => 'لطفا پیام خود را وارد نمایید'));
        }

        $data = json_encode($return);
//        $compressed = gzcompress($data, 9);
        echo $data;
    }

    public function saverating($input) {
        $da = base64_decode($input);
        $da = json_decode($da, true);

        $fields = array('Token', 'Rate', 'ID');
//check isset
        if (Checkform::checkset($da, $fields)) {
//check not empty
            if (Checkform::checknotempty($da, $fields)) {
                $userid = $this->token($da['Token']);
                if ($userid != FALSE) {
                    $res = $this->model->selrate($da['ID'], $userid);
                    if ($res) {
                        $this->model->uprate($userid, $da['ID'], $da['Rate']);
                    } else {
                        $data = array('pid' => $da['ID'], 'rate' => $da['Rate'], 'uid' => $userid);
                        $this->model->saverate($data);
                    }
                    $resuser = $this->model->seluser($da['ID']);
                    if ($resuser) {
                        $cnt = $resuser->rowCount();
                        while ($row = $resuser->fetch()) {
                            $sumrate+= $row['rate'];
                            $refrate = ($sumrate / $cnt);
                            $ref = round($refrate, 2);
                            $this->model->uprefate($da['ID'], $ref);
                        }
                    }
                    $data = array('Status' => 'success', 'Tag' => 'saverating', 'data' => array('Msg' => 'امتیاز شما با موفقیت ثبت شد'));
                    $data = json_encode($data);
                    echo $data;
                }
            }
        }
    }

    public function savefollow($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'savefollow', 'Status' => 'success', 'Msg' => '');
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنیتی نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }



        if (isset($input['UserID']) && !empty($input['UserID'])) {
            $thisuserid = $userid;
            $idfl = $input['UserID'];
            if ($thisuserid != FALSE) {
                if ($idfl != $thisuserid) {
                    $cond = 'userid=:userid AND fid=:fid';
                    $condata = array('userid' => $thisuserid, 'fid' => $idfl);
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
                            $users = array(htmlspecialchars($idfl));
                            $this->addnote($text, $href, $ndate, $users);
                            $return['Msg'] = 'این کاربر را دیگر دنبال نمی کنید';
                            $data = json_encode($return);
                            echo $data;
                            return;
                        }
                    } else {
                        $data = array('userid' => $thisuserid, 'fid' => $idfl);
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
                            $users = array(htmlspecialchars($idfl));
                            $this->addnote($text, $href, $ndate, $users);
                            $return['Msg'] = 'از هم اکنون این کاربر را دنبال می کنید';
                            $data = json_encode($return);
                            echo $data;
                            return;
                        }
                    }
                } else {
                    $return['Status'] = 'failed';
                    $return['Msg'] = 'اطلاعات نامعتبر است';
                    $data = json_encode($return);
                    echo $data;
                    return;
                }
            }
        } else {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات نامعتبر است';
            $data = json_encode($return);
            echo $data;
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

    public function token($input) {
        $cond = 'token=:token';
        $condata = array('token' => trim($input));
        $res = $this->model->iduser($cond, $condata);
        if ($res) {
            $row = $res->fetch();
            $userid = $row['id'];
            return $userid;
        } else {
            return FALSE;
        }
    }

    public function stateslist($token) {
        $result = $this->model->selectstates();
        $return = array('Tag' => 'stateslist', 'Status' => 'success', 'Msg' => '', 'data' => array('States' => array()));
        if ($result != FALSE) {
            $return['Status'] = 'success';
            while ($row = $result->fetch()) {
//$States=array('Id'=>$row['id'],'Name'=>$row['state']);
                $return['data']['States'][] = array('Id' => $row['id'], 'Name' => $row['state']);
            }
        } else {
            $return['Status'] = 'failed';
        }
        $return = json_encode($return);
        echo $return;
    }

    public function profile_edit($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $fields = array('Token', 'FirstName', 'LastName', 'UserName', 'Tell', 'NationalID', 'PostalCode', 'Address', 'Email', 'Description');
        //print_r($input);
        $fields1 = array('UserName');
        $return = array('Tag' => 'profile_edit', 'Status' => 'success', 'Msg' => '');
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنيتي نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
//check isset
        //if (Checkform::checkset($input, $fields)) {
//check not empty
        if (Checkform::checknotempty($input, $fields1)) {
//check username not exist
            $cond = 'id!=:id AND username=:username';
            $condata = array('id' => $userid, 'username' => $input['UserName']);
            $resusername = $this->model->selectusername($cond, $condata);
            if ($resusername == FALSE) {
//check meli code
                if (!empty($input['NationalID']) && !Utilities::ismelicode($input['NationalID'])) {
//melicode not true
                    $return['Status'] = 'failed';
                    $return['Msg'] = 'کد ملي صحيح نيست';
                    $data = json_encode($return);
                    echo $data;
                    return;
                }
//check username is english
                if (!Utilities::isenglish($input['UserName'])) {
//username is not english
                    $return['Status'] = 'failed';
                    $return['Msg'] = 'نام کاربري بايد با حروف لاتين باشد';
                    $data = json_encode($return);
                    echo $data;
                    return;
                }

//check melicode not exist
                if (!empty($input['NationalID']) && $this->model->checkmelicode($input['NationalID'], $userid) != FALSE) {
//melicode is exist
                    $return['Status'] = 'failed';
                    $return['Msg'] = 'اين کد ملي قبلا ثبت شده است';
                    $data = json_encode($return);
                    echo $data;
                    return;
                }
//check email
                if (!empty($input['Email']) && Checkform::isemail($input['Email']) == FALSE) {
//mobile not true
                    $return['Status'] = 'failed';
                    $return['Msg'] = 'ايميل وارد شده معتبر نيست';
                    $data = json_encode($return);
                    echo $data;
                    return;
                }

                $updata = array('name' => $input['FirstName'], 'family' => $input['LastName'], 'username' => $input['UserName'], 'melicode' => $input['NationalID'], 'postcode' => $input['PostalCode'], 'address' => $input['Address'], 'tel' => $input['Tell'], 'mail' => $input['Email'], 'userinfo' => $input['Description']);
                $cond = 'id=:id';
                $condata = array('id' => $userid);
                $this->model->saveeditprof($updata, $cond, $condata);
                $return['Status'] = 'Success';
                $return['Msg'] = 'اطلاعات با موفقيت ذخيره شد';
            } else {
                $return['Status'] = 'failed';
                $return['Msg'] = 'نام کاربري وارد شده در دسترس نيست';
            }
        } else {
            $return['Status'] = 'failed';
            $return['Msg'] = 'نام کاربري نمي تواند خالي باشد';
        }
//        } else {
//            $return['Status'] = 'failed';
//            $return['Msg'] = 'لطفا همه اطلاعات را ارسال نمایید';
//        }

        $data = json_encode($return);
        echo $data;
    }

    public function pass_edit($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $fields = array('Token', 'PrePass', 'NewPass');
        $return = array('Tag' => 'pass_edit', 'Status' => 'success', 'Msg' => '');
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنيتي نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
//check isset
        if (Checkform::checkset($input, $fields)) {
//check not empty
            if (Checkform::checknotempty($input, $fields)) {
//check old password
                $cond = 'id=:id AND password=:password';
                $condata = array('id' => $userid, 'password' => $input['PrePass']);
                $resusername = $this->model->selectusername($cond, $condata);
                if ($resusername != FALSE) {
                    $updata = array('password' => trim($input['NewPass']));
                    $cond = 'id=:id';
                    $condata = array('id' => $userid);
                    $this->model->saveeditprof($updata, $cond, $condata);
                    $return['Status'] = 'Success';
                    $return['Msg'] = 'اطلاعات با موفقيت ذخيره شد';
                } else {
                    $return['Status'] = 'failed';
                    $return['Msg'] = 'رمزعبور قبلي صحيح نمي باشد';
                }
            } else {
                $return['Status'] = 'failed';
                $return['Msg'] = 'لطفا تمامي اطلاعات را وارد کنيد';
            }
        } else {
            $return['Status'] = 'failed';
            $return['Msg'] = 'لطفا تمامي اطلاعات را وارد کنيد';
        }

        $data = json_encode($return);
        echo $data;
    }

    public function Mobile_editA($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $fields = array('Token', 'NewMobile');
        $return = array('Tag' => 'Mobile_editA', 'Status' => 'success', 'Msg' => '', 'Code' => '');
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنيتي نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
//check isset
        if (Checkform::checkset($input, $fields)) {
//check not empty
            if (Checkform::checknotempty($input, $fields)) {
//check mobile not exist
                if ($this->model->checkmobile($input['NewMobile']) == FALSE) {
                    if (strlen(trim($input['NewMobile'])) == 11) {
                        $actcode = Utilities::random(6);
                        $recnumber = $input['NewMobile'];
                        Caller::changemob($recnumber, $actcode);
                        $return['Status'] = 'success';
                        $return['Code'] = md5($actcode . '5923');
                        $return['Msg'] = 'کد تغيير شماره را وارد نماييد';
                    } else {
                        $return['Status'] = 'failed';
                        $return['Msg'] = 'شماره وارد شده معتبر نيست';
                    }
                } else {
                    $return['Status'] = 'failed';
                    $return['Msg'] = 'اين شماره قبلا ثبت شده است';
                }
            } else {
                $return['Status'] = 'failed';
                $return['Msg'] = 'لطفا شماره جديد را وارد کنيد';
            }
        } else {
            $return['Status'] = 'failed';
            $return['Msg'] = 'لطفا شماره جديد را وارد کنيد';
        }

        $data = json_encode($return);
        echo $data;
    }

    public function Mobile_editB($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $fields = array('Token', 'VerifyCode', 'NewMobile', 'Code');
        $return = array('Tag' => 'Mobile_editB', 'Status' => 'success', 'Msg' => '');
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنيتي نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
//check isset
        if (Checkform::checkset($input, $fields)) {
//check not empty
            if (Checkform::checknotempty($input, $fields)) {
                $newmob = $input['NewMobile'];
                $actcode = $input['Code'];
//check mobile not exist
                if ($this->model->checkmobile($newmob) == FALSE) {
                    if (strlen(trim($newmob)) == 11) {
                        if ($actcode == md5(trim($input['VerifyCode']) . '5923')) {
                            $updata = array('mobile' => $newmob);
                            $cond = 'id=:id';
                            $condata = array('id' => $userid);
                            $this->model->saveeditprof($updata, $cond, $condata);
                            $return['Status'] = 'success';
                            $return['Msg'] = 'شماره همراه شما تغيير کرد';
                        } else {
                            $return['Status'] = 'failed';
                            $return['Msg'] = 'کد وارد شده صحيح نيست';
                        }
                    } else {
                        $return['Status'] = 'failed';
                        $return['Msg'] = 'شماره وارد شده معتبر نيست';
                    }
                } else {
                    $return['Status'] = 'failed';
                    $return['Msg'] = 'اين شماره قبلا ثبت شده است';
                }
            } else {
                $return['Status'] = 'failed';
                $return['Msg'] = 'کد تغيير شماره را وارد نماييد';
            }
        } else {
            $return['Status'] = 'failed';
            $return['Msg'] = 'کد تغيير شماره را وارد نماييد';
        }

        $data = json_encode($return);
        echo $data;
    }

    public function uslquestion($input) {
        $return = array('Tag' => 'uslquestion', 'Status' => 'success', 'Msg' => '', 'Data' => array());
        $result = $this->model->load();
        if ($result) {
            while ($row = $result->fetch()) {
                $return['Status'] = 'success';
                $return['Data']['Faq'][] = array('Title' => $row['question'], 'Text' => $row['answer']);
            }
        }
        $data = json_encode($return);
        echo $data;
    }

    public function notifications($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'notifications', 'Status' => 'success', 'Msg' => '', 'Data' => array('Events' => array()));
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنيتي نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
        $result = $this->model->slenotmob($userid);
        if ($result != FALSE) {
            while ($row = $result->fetch()) {
                $return['Status'] = 'success';
                $return['Data']['Events'][] = array('Text' => $row['text'], 'Date' => $row['date']);
            }
        }
        $data = json_encode($return);
        echo $data;
    }

    public function shive($input) {
        $return = array('Tag' => 'shive', 'Status' => 'success', 'Msg' => '', 'Data' => array('How' => array()));
        $result = $this->model->loadmethod();
        if ($result) {
            while ($row = $result->fetch()) {
                $return['Status'] = 'success';
                $return['Data']['How'][] = array('Title' => $row['ruls'], 'Text' => $row['message']);
            }
        }
        $data = json_encode($return);
        echo $data;
    }

    public function policy($input) {
        $return = array('Tag' => 'policy', 'Status' => 'success', 'Msg' => '', 'Data' => array('Ruls' => array()));
        $result = $this->model->loadrules();
        if ($result) {
            while ($row = $result->fetch()) {
                $return['Status'] = 'success';
                $return['Data']['Ruls'][] = array('Title' => $row['rules'], 'Text' => $row['comment']);
            }
        }
        $data = json_encode($return);
        echo $data;
    }

    public function hoghoogh($input) {
        $return = array('Tag' => 'policy', 'Status' => 'success', 'Msg' => '', 'Data' => array('Terms' => array()));
        $result = $this->model->loadcpy();
        if ($result) {
            while ($row = $result->fetch()) {
                $return['Status'] = 'success';
                $return['Data']['Terms'][] = array('Title' => $row['rules'], 'Text' => $row['comment']);
            }
        }
        $data = json_encode($return);
        echo $data;
    }

    public function follower($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'Follower', 'Status' => 'success', 'Msg' => '', 'Data' => array('FollowerList' => array()));
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنيتي نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
        $cond0 = 'fid=:flid';
        $condata0 = array('flid' => $userid);
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
                $return['Status'] = 'success';
                $return['Data']['FollowerList'][] = array('UserName' => $username, 'AvatarImg' => $avat, 'ID' => $row1['userid']);
            }
        }
        $data = json_encode($return);
        echo $data;
    }

    public function following($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'following', 'Status' => 'success', 'Msg' => '', 'Data' => array('FollowingList' => array()));
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنيتي نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
        $cond1 = 'userid=:uid';
        $condata1 = array('uid' => $userid);
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
                $return['Status'] = 'success';
                $return['Data']['FollowingList'][] = array('UserName' => $username, 'AvatarImg' => $avat, 'ID' => $row1['fid']);
            }
        }
        $data = json_encode($return);
        echo $data;
    }

    public function loaduserimage($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'loaduserimage', 'Status' => 'success', 'Msg' => '', 'Page' => 1, 'TotalPage' => 1, 'Data' => array('Images' => array()));
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنيتي نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
        if (isset($input['Page']) && $input['Page'] > 1) {
            $page = $input['Page'] * 12;
            $i = (($input['Page'] - 1) * 12) + 1;
            $return['Page'] = $input['Page'];
        } else {
            $return['Page'] = 1;
            $page = 12;
            $i = 1;
        }
        $cond = 'userid=:userid AND confirm=1';
        $condata = array('userid' => $userid);
        $resphoto = $this->model->loadlastcomp($cond, $condata);
        if ($resphoto != FALSE) {
            $cnt = $resphoto->rowCount();
            $numofpage = ceil($cnt / 12);
            $return['TotalPage'] = $numofpage;
            $j = 1;
            while ($rowphoto = $resphoto->fetch()) {
                if ($j >= $i && $i <= $page) {
                    $cond = 'id=:id';
                    $condata = array('id' => $rowphoto['compid']);
                    $rescomp = $this->model->others($cond, $condata);
                    if ($rescomp != FALSE) {
                        $rwcomp = $rescomp->fetch();
                        $compname = $rwcomp['name'];
                    } else {
                        $compname = '';
                    }
                    $picname = Utilities::imgname('thumb', $rowphoto['id']) . '.jpg';
                    $picturname = URL . '/images/gallery/thumb/' . $picname;
                    $return['Status'] = 'success';
                    $return['Data']['Images'][] = array('ImageUrl' => $picturname, 'CompetitionName' => $compname, 'ImageName' => $rowphoto['name'], 'Date' => Shamsidate::jdate('Y/m/d', $rowphoto['date']), 'ID' => $rowphoto['id']);
                    $i++;
                }
                $j++;
            }
        }
        $data = json_encode($return);
        echo $data;
    }

    public function livecomp($input) {
        $return = array('Status' => 'success', 'Msg' => '', 'Tag' => 'livecomp', 'Data' => array('Competitions' => array()));
        $cond = 'isopen!=3 AND isopen!=0 ORDER by id DESC';
        $res = $this->model->others($cond);
        if ($res != FALSE) {
            while ($row = $res->fetch()) {
                $return['Status'] = 'success';
                $return['Data']['Competitions'][] = array('ID' => $row['id'], 'Name' => $row['name']);
            }
            $data = json_encode($return);
            echo $data;
        } else {
            $return['Status'] = 'failed';
            $return['Msg'] = 'مسابقه ای یافت نشد';
            $data = json_encode($return);
            echo $data;
        }
    }

    public function loadpendinguserimage($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'loadpendinguserimage', 'Status' => 'success', 'Msg' => '', 'Data' => array('Images' => array()));
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنیتی نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
        $cond = 'userid=:userid AND confirm=0';
        $condata = array('userid' => $userid);
        $resphoto = $this->model->loadlastcomp($cond, $condata);
        if ($resphoto != FALSE) {
            while ($rowphoto = $resphoto->fetch()) {
                $cond = 'id=:id';
                $condata = array('id' => $rowphoto['compid']);
                $rescomp = $this->model->others($cond, $condata);
                if ($rescomp != FALSE) {
                    $rwcomp = $rescomp->fetch();
                    $compname = $rwcomp['name'];
                } else {
                    $compname = '';
                }
                $picname = Utilities::imgname('thumb', $rowphoto['id']) . '.jpg';
                $picturname = URL . '/images/gallery/thumb/' . $picname;
                $return['Status'] = 'success';
                $return['Data']['Images'][] = array('ImageUrl' => $picturname, 'CompetitionName' => $compname, 'ImageName' => $rowphoto['name'], 'Date' => Shamsidate::jdate('Y/m/d', $rowphoto['date']), 'ID' => $rowphoto['id']);
            }
        }
        $data = json_encode($return);
        echo $data;
    }

    public function ranks($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'ranks', 'Status' => 'success', 'Msg' => '', 'Data' => array('Ranks' => array()));
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنیتی نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
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
                    $return['Status'] = 'success';
                    $return['Data']['Ranks'][] = array('CompetitionName' => $rowcomp['name'], 'Rank' => $rate, 'Prise' => $roweftekhar['price']);
                }
            }
        }
        $data = json_encode($return);
        echo $data;
    }

    public function points($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'points', 'Status' => 'success', 'Msg' => '', 'Data' => array('Points' => array()));
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنیتی نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
        $cond = 'userid=:userid';
        $condata = array('userid' => $userid);
        $resultscore = $this->model->score($cond, $condata);
        if ($resultscore != FALSE) {
            $rowscore = $resultscore->fetch();
            $return['Status'] = 'success';
            $return['Data']['Points'][] = array('PointName' => 'تایید عکس', 'Value' => $rowscore['confirm_photo']);
            $return['Data']['Points'][] = array('PointName' => 'ورود به سامانه', 'Value' => $rowscore['login_score']);
        } else {
            $return['Data']['Points'][] = array('PointName' => 'تایید عکس', 'Value' => 0);
            $return['Data']['Points'][] = array('PointName' => 'ورود به سامانه', 'Value' => 0);
        }
        $data = json_encode($return);
        echo $data;
    }

    public function userdata($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'userdata', 'Status' => 'success', 'Msg' => '', 'FirstName' => '', 'LastName' => '', 'UserName' => '', 'Tell' => '', 'NationalID' => '', 'PostalCode' => '', 'Address' => '', 'Email' => '', 'Mobile' => '', 'Score' => '', 'ImagesCount' => '', 'FollowerCount' => '', 'FollwingCount' => '', 'Description' => '', 'Avatar' => '');
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنیتی نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
        $result = $this->model->selectuser($userid);
        if ($result != FALSE) {
            $row = $result->fetch();
            $return['Status'] = 'success';
            $return['UserName'] = $row['username'];
            $return['FirstName'] = $row['name'];
            $return['LastName'] = $row['family'];
            $return['Tell'] = $row['tel'];
            $return['NationalID'] = $row['melicode'];
            $return['PostalCode'] = $row['postcode'];
            $return['Address'] = $row['address'];
            $return['Email'] = $row['mail'];
            $return['Mobile'] = $row['mobile'];
            $return['ImagesCount'] = $row['photonumber'];
            $return['Description'] = ($row['userinfo'] != NULL ? $row['userinfo'] : '');
            ;
            if ($row['isavatar'] == 1) {
                $imgname = Utilities::imgname('avatar', $row['id']) . '.jpg';
                $avat = URL . '/images/avatar/' . $imgname;
            } else {
                $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                $avat = URL . '/images/avatar/' . $imgname;
            }
            $return['Avatar'] = $avat;

            $cond0 = 'fid=:flid';
            $condata0 = array('flid' => $userid);
            $res0 = $this->model->selfer($cond0, $condata0);
            if ($res0 != FALSE) {
                $er = $res0->rowCount();
            } else {
                $er = 0;
            }
            $return['FollowerCount'] = $er;

            $cond1 = 'userid=:uid';
            $condata1 = array('uid' => $userid);
            $res1 = $this->model->selfing($cond1, $condata1);
            if ($res1 != FALSE) {
                $ing = $res1->rowCount();
            } else {
                $ing = 0;
            }
            $return['FollwingCount'] = $ing;

            $cond = 'userid=:userid';
            $condata = array('userid' => $userid);
            $resultscore = $this->model->score($cond, $condata);
            if ($resultscore != FALSE) {
                $rowscore = $resultscore->fetch();
                $return['Score'] = $rowscore['confirm_photo'] + $rowscore['login_score'];
            } else {
                $return['Score'] = 0;
            }
        } else {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنیتی نامعتبر است';
        }
        $data = json_encode($return);
        echo $data;
    }

    public function loadotheruserimage($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'loadotheruserimage', 'Status' => 'success', 'Msg' => '', 'Page' => 1, 'TotalPage' => 1, 'Data' => array('Images' => array()));
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنيتي نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
        $userid = $input['UserID'];
        if (isset($input['Page']) && $input['Page'] > 1) {
            $page = $input['Page'] * 12;
            $i = (($input['Page'] - 1) * 12) + 1;
            $return['Page'] = $input['Page'];
        } else {
            $return['Page'] = 1;
            $page = 12;
            $i = 1;
        }
        $cond = 'userid=:userid AND confirm=1';
        $condata = array('userid' => $userid);
        $resphoto = $this->model->loadlastcomp($cond, $condata);
        if ($resphoto != FALSE) {
            $cnt = $resphoto->rowCount();
            $numofpage = ceil($cnt / 12);
            $return['TotalPage'] = $numofpage;
            $j = 1;
            while ($rowphoto = $resphoto->fetch()) {
                if ($j >= $i && $i <= $page) {
                    $cond = 'id=:id';
                    $condata = array('id' => $rowphoto['compid']);
                    $rescomp = $this->model->others($cond, $condata);
                    if ($rescomp != FALSE) {
                        $rwcomp = $rescomp->fetch();
                        $compname = $rwcomp['name'];
                    } else {
                        $compname = '';
                    }
                    $picname = Utilities::imgname('thumb', $rowphoto['id']) . '.jpg';
                    $picturname = URL . '/images/gallery/thumb/' . $picname;
                    $return['Status'] = 'success';
                    $return['Data']['Images'][] = array('ImageUrl' => $picturname, 'CompetitionName' => $compname, 'ImageName' => $rowphoto['name'], 'Date' => Shamsidate::jdate('Y/m/d', $rowphoto['date']), 'ID' => $rowphoto['id']);
                    $i++;
                }
                $j++;
            }
        }
        $data = json_encode($return);
        echo $data;
    }

    public function otherpoints($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'otherpoints', 'Status' => 'success', 'Msg' => '', 'Data' => array('Points' => array()));
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنیتی نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
        $userid = $input['UserID'];
        $cond = 'userid=:userid';
        $condata = array('userid' => $userid);
        $resultscore = $this->model->score($cond, $condata);
        if ($resultscore != FALSE) {
            $rowscore = $resultscore->fetch();
            $return['Status'] = 'success';
            $return['Data']['Points'][] = array('PointName' => 'تایید عکس', 'Value' => $rowscore['confirm_photo']);
            $return['Data']['Points'][] = array('PointName' => 'ورود به سامانه', 'Value' => $rowscore['login_score']);
        } else {
            $return['Data']['Points'][] = array('PointName' => 'تایید عکس', 'Value' => 0);
            $return['Data']['Points'][] = array('PointName' => 'ورود به سامانه', 'Value' => 0);
        }
        $data = json_encode($return);
        echo $data;
    }

    public function otherranks($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'otherranks', 'Status' => 'success', 'Msg' => '', 'Data' => array('Ranks' => array()));
        $userid = $this->token($input['Token']);
        if ($userid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنیتی نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
        $userid = $input['UserID'];
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
                    $return['Status'] = 'success';
                    $return['Data']['Ranks'][] = array('CompetitionName' => $rowcomp['name'], 'Rank' => $rate, 'Prise' => $roweftekhar['price']);
                }
            }
        }
        $data = json_encode($return);
        echo $data;
    }

    public function otheruserdata($input) {
        $input = base64_decode($input);
        $input = json_decode($input, TRUE);
        $return = array('Tag' => 'otheruserdata', 'Status' => 'success', 'Msg' => '', 'FirstName' => '', 'LastName' => '', 'UserName' => '', 'Tell' => '', 'NationalID' => '', 'PostalCode' => '', 'Address' => '', 'Email' => '', 'Mobile' => '', 'Score' => '', 'ImagesCount' => '', 'FollowerCount' => '', 'FollwingCount' => '', 'Description' => '', 'Avatar' => '', 'IsSelf' => 0, 'IsFollowing' => 0);
        $selfuserid = $this->token($input['Token']);
        if ($selfuserid == FALSE) {
            $return['Status'] = 'failed';
            $return['Msg'] = 'اطلاعات امنیتی نامعتبر است';
            $data = json_encode($return);
            echo $data;
            return;
        }
        $userid = $input['UserID'];
        if ($userid == $selfuserid) {
            $return['IsSelf'] = 1;
        } else {
            $cond = 'userid=:userid AND fid=:fid';
            $condata = array('userid' => $selfuserid, 'fid' => $userid);
            $res = $this->model->checkflw($cond, $condata);
            if ($res != FALSE) {
                $return['IsFollowing'] = 1;
            } else {
                $return['IsFollowing'] = 0;
            }
            $return['IsSelf'] = 0;
        }


        $result = $this->model->selectuser($userid);
        if ($result != FALSE) {
            $row = $result->fetch();
            $return['Status'] = 'success';
            $return['UserName'] = $row['username'];
            $return['FirstName'] = $row['name'];
            $return['LastName'] = $row['family'];
            $return['Tell'] = $row['tel'];
            $return['NationalID'] = $row['melicode'];
            $return['PostalCode'] = $row['postcode'];
            $return['Address'] = $row['address'];
            $return['Email'] = $row['mail'];
            $return['Mobile'] = $row['mobile'];
            $return['ImagesCount'] = $row['photonumber'];
            $return['Description'] = ($row['userinfo'] != NULL ? $row['userinfo'] : '');
            ;
            if ($row['isavatar'] == 1) {
                $imgname = Utilities::imgname('avatar', $row['id']) . '.jpg';
                $avat = URL . '/images/avatar/' . $imgname;
            } else {
                $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                $avat = URL . '/images/avatar/' . $imgname;
            }
            $return['Avatar'] = $avat;

            $cond0 = 'fid=:flid';
            $condata0 = array('flid' => $userid);
            $res0 = $this->model->selfer($cond0, $condata0);
            if ($res0 != FALSE) {
                $er = $res0->rowCount();
            } else {
                $er = 0;
            }
            $return['FollowerCount'] = $er;

            $cond1 = 'userid=:uid';
            $condata1 = array('uid' => $userid);
            $res1 = $this->model->selfing($cond1, $condata1);
            if ($res1 != FALSE) {
                $ing = $res1->rowCount();
            } else {
                $ing = 0;
            }
            $return['FollwingCount'] = $ing;

            $cond = 'userid=:userid';
            $condata = array('userid' => $userid);
            $resultscore = $this->model->score($cond, $condata);
            if ($resultscore != FALSE) {
                $rowscore = $resultscore->fetch();
                $return['Score'] = $rowscore['confirm_photo'] + $rowscore['login_score'];
            } else {
                $return['Score'] = 0;
            }
        } else {
            $return['Status'] = 'failed';
            $return['Msg'] = 'کاربر مورد نظر یافت نشد';
        }
        $data = json_encode($return);
        echo $data;
    }

}
