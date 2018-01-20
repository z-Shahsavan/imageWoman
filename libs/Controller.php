<?php

class Controller {

    public $view;
    public $model;
    public $data = array();

    function __construct() {
        $this->view = new View();
        $this->data = Link::menulink('isuser', 'idx');
        $this->data['[VARUSEROKIMAGECOUNT]'] = 0;
        $this->data['[VARSERPENIMAGECOUNT]'] = 0;
        $this->data['[VARIMAGECOUNT]'] = 0;
        $this->data['[VARUSERID]'] = 0;
        $this->data['[VARRECAPTCHA_SITEKEY]'] = RECAPTCHA_SITEKEY;
    }

    public function closecomp() {
        $this->model->closecomp();
    }

    public function opencomp() {
        $result = $this->model->opencomp();
        if ($result) {
            while ($row = $result->fetch()) {
                $users = $this->userfornote();
                $this->addnote('مسابقه ' . $row['name'] . ' آغاز شد.', 'comp/id/' . $row['id'], Shamsidate::jdate('H:i | l, j F Y', time()), $users);
            }
        }
    }

    public function loadnots() {
        $notlist = '';
        $nots = $this->model->loadnots();
        $i = 0;
        if ($nots) {
            while ($not = $nots->fetch()) {
                if ($not['status'] == 0) {
                    if ($i < 5) {
                        $notlist.='<li><a id="' . $not['id'] . '_notify" class="notificationunread waves-effect waves-light btn deep-purple darken-1" data-id="' . $not['id'] . '" data-link="' . URL . $not['href'] . '">' . $not['text'] . '</a></li>';
                    }
                    $i++;
                } else {
                    $notlist.='';
                }
            }
        }
        if ($i > 0) {
            $this->data['[VARNUMOFNOTIFY]'] = '<span id="notificationcount" class="badge red darken-1 circle">' . $i . '</span>';
            $this->data['[VARNUMOFNOTIFYJ]'] = '<span id="notificationmenucount" class="badge red left darken-1 circle" style="background-color: #727272  !important; color: rgb(255, 255, 255); min-width: 15px; right: 50px;height: 20px; margin-top: -35px; margin-right: 55px;font-size:14px;">' . $i . '</span>';
            $this->data['[VARNUMOFNOTIFYAVT]'] = '<span id="notificationavacount" class="badge red darken-1 circle" style="color: rgb(255, 255, 255); min-width: 25px; right: 15px; font-size: medium; height: 25px; margin-top: 25px; margin-right: 5px;">' . $i . '</span>';
        } else {
            $this->data['[VARNUMOFNOTIFY]'] = '';
            $this->data['[VARNUMOFNOTIFYJ]'] = '';
            $this->data['[VARNUMOFNOTIFYAVT]'] = '';
        }

        $this->data['[VARNOTIFYTEXT]'] = $notlist;
    }

    public function editnot($id) {
        $nots = $this->model->editnot($id);
        $return = array('id' => htmlspecialchars($id));
        $return = json_encode($return);
        echo $return;
    }

    public function addnote($text, $href, $ndate, $users = array()) {
        $i = 0;
        $nid = $this->model->addnote(htmlspecialchars($text), htmlspecialchars($href), $ndate);
        if (empty($users) || !$nid) {
            return;
        }
        foreach ($users as $value) {
            $da[$i]['nid'] = $nid;
            $da[$i]['uid'] = $value;
            $da[$i]['status'] = 0;
            $i++;
        }
        if (count($users) > 1) {
            $result = $this->model->loadmobileuser();
            if ($result != FALSE) {
                $i = 1;
                while ($row = $result->fetch()) {
                    //$registatoin_ids[$i]=$row['gcmid'];
                    $message = array("price" => $text . '$' . 'test');
                    $registatoin_ids = array($row['gcmid']);
                    GCM::send_notification($registatoin_ids, $message);
                }
            }
        } else {
            $cond = "id=:id AND gcmid!=''";
            $condata = array('id' => $users[0]);
            $result = $this->model->loadmobileuser($cond, $condata);
            if ($result != FALSE) {
                $i = 1;
                $row = $result->fetch();
                //$registatoin_ids[$i]=$row['gcmid'];
                $message = array("price" => $text . '$' . 'test');
                $registatoin_ids = array($row['gcmid']);
                GCM::send_notification($registatoin_ids, $message);
            }
        }



        $this->model->addch('nid,uid,status', $da);
    }

    public function userfornote() {
        $uids = array();
        $rows = $this->model->userfornote();
        if ($rows) {
            while ($row = $rows->fetch()) {
                array_push($uids, $row['id']);
            }
        }
        return $uids;
    }

    public function loadmodel($name) {
        $path = 'models/' . $name . '_model.php';
        if (file_exists($path)) {
            require $path;
            $classname = $name . '_model';
            $this->model = new $classname();
            $this->loadnots();
            $this->selectcomp();
            $this->delnoactiveuser();
            $this->selectbesusers();
            $this->loadnotefooter();
            $this->dltnotactive();
            $this->closecomp();
            $this->opencomp();
            $this->numofpic();
            $this->data['[SITETITLE]'] = SITE_NAME;
        }
//        if (Session::get('intro')>4) {
//            $this->sendactivecod();
//        }
    }

    public function numofpic() {
        $fields = 'count(id) as numofpic, compid';
        $cond = 'confirm=1 GROUP BY compid';
        $res = $this->model->numofpic($fields, $cond);
        if ($res) {
            $cond0 = 'numofpic=(CASE';
            $conddata = array();
            $i = 0;
            while ($row = $res->fetch()) {
                $cond0.=' WHEN (id=:da' . $i . ') THEN ';
                $conddata['da' . $i] = $row['compid'];
                $i++;
                $cond0.=':da' . $i;
                $conddata['da' . $i] = $row['numofpic'];
                $i++;
            }
            $cond0.=' ELSE numofpic END);';
            $this->model->updatenumofpic($cond0, $conddata);
        }
    }

    public function setlanguage($lang) {
        if (file_exists('language/' . $lang . '.php')) {
            switch ($lang) {
                case 'FA':
                case 'AR':
                    setcookie('style', 'style1', time() + (30 * 24 * 3600), '/');
                    break;
                case 'EN':
                    setcookie('style', 'style2', time() + (30 * 24 * 3600), '/');
                    break;
            }
            setcookie('lang', $lang, time() + (30 * 24 * 3600), '/');
        }
    }

    public function logout() {
        if (Session::get('haszip')) {
            $files = glob('zip/*'); // get all file names
            foreach ($files as $file) { // iterate files
                if (is_file($file)) {
                    unlink($file); // delete file
                }
            }
        }
        $_SESSION = array();
        session_destroy();
        session_unset();
        header('Location: ' . URL . 'index/index');
    }

    public function imgview() {
        $this->model->updateview();
        $fields = array('id');
//check isset
        if (Checkform::checkset($_POST, $fields)) {
//check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                if ($this->model->checkview($_POST['id'], Utilities::userip()) == FALSE) {
                    $this->model->addview($_POST['id'], Utilities::userip());
                }
            }
        }
    }

    public function imglike() {
        $fields = array('id');
//check isset
        if (Checkform::checkset($_POST, $fields)) {
//check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                if ($this->model->checklike($_POST['id'], Utilities::userip()) == FALSE) {
                    $this->model->addlike($_POST['id'], Utilities::userip());
                    $cond = 'id=:id';
                    $condata = array('id' => $_POST['id']);
                    $res = $this->model->giveuserlik($cond, $condata);
                    $row = $res->fetch();
                    $this->setscore($row['userid'], 6);
                    if (Session::get('isuser') != FALSE) {
                        $userid = Session::get('userid');
                        $this->setscore($userid, 2);
                    }
                } else {
                    $this->model->removelike($_POST['id'], Utilities::userip());
                    if (Session::get('isuser') != FALSE) {
                        $userid = Session::get('userid');
                        $this->setscore($userid, 5);
                    }
                }
            }
        }
    }

    public function selectcomp() {
        $res = $this->model->selectcur();
        if ($res != FALSE) {
            $i = 0;
            $this->data['[VARHEADERCOMP]'] = '<ul class="col s12 m2 right">
                <li class="divider"></li>';
            while ($row = $res->fetch()) {

                $i++;

                if ($i <= 7) {
                    $this->data['[VARHEADERCOMP]'].='<li><a href="' . URL . 'comp/id/' . $row['id'] . '">' . $row['name'] . '</a></li>';
                } else {
                    $this->data['[VARHEADERCOMP]'].='</ul>';
                    $i = 0;
                }
            }
            if ($i > 0) {
                $this->data['[VARHEADERCOMP]'].='</ul>';
            }
        }
    }

    public function delnoactiveuser() {
        $cond = 'confirm=0 AND lastlogin<' . time() - (24 * 3600);
        $this->model->delnoactiveuser($cond);
    }

    public function selectbesusers() {
        $res = $this->model->selectbesusers();
        if ($res != FALSE) {
            $this->data['[VARBESTUSRFORFOOT]'] = '';
            while ($row = $res->fetch()) {
                if ($row['isavatar'] == 1) {
                    $imgname = Utilities::imgname('avatar', $row['id']) . '.jpg';
                    $thmname = URL . '/images/avatar/' . $imgname;
                } else {
                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                    $thmname = URL . '/images/avatar/' . $imgname;
                }
                $this->data['[VARBESTUSRFORFOOT]'].='<li><a href="' . URL . 'blog/id/' . $row['id'] . '"><img src="' . $thmname . '" /></a></li>';
            }
        }
    }

    public function minesscore($uid) {
        $cond = 'userid=:userid';
        $condata = array('userid' => $uid);
        $res = $this->model->loadscore($cond, $condata);
        if ($res) {
            $row = $res->fetch();
            $confirm_photo = $row['confirm_photo'];
            $confirm_photo-=50;
            $updata = array('confirm_photo' => $confirm_photo);
            $this->model->newscore($updata, $cond, $condata);
        }
    }

    public function setscore($uid, $type) {
        $cond = 'userid=:userid';
        $condata = array('userid' => $uid);
        $res = $this->model->loadscore($cond, $condata);
        if ($res) {
            $row = $res->fetch();
            $confirm_photo = $row['confirm_photo'];
// $like_score = $row['like_score'];
            $login_score = $row['login_score'];
// $comment_score = $row['comment_score'];
            switch ($type) {
                case 1:
                    $confirm_photo+=50;
                    $updata = array('confirm_photo' => $confirm_photo);
                    break;
//                case 2:
//                    $like_score+=5;
//                    $updata = array('publish_score' => $like_score);
//                    break;
                case 3:
                    $login_score+=2;
                    $updata = array('login_score' => $login_score);
                    break;
//                case 4:
//                    $comment_score+=25;
//                    $updata = array('comment_score' => $comment_score);
//                    break;
//                case 5:
//                    $like_score-=5;
//                    $updata = array('like_score' => $like_score);
//                    break;
//                case 6:
//                    $like_score+=10;
//                    $updata = array('like_score' => $like_score);
//                    break;
            }

            $this->model->newscore($updata, $cond, $condata);
        }
    }

    public function loadnotefooter() {
        $txt = '';
        $res = $this->model->loadnotefooter();
        if ($res) {
            $row = $res->fetch();
            $txt = ' <p class="justify">' . mb_substr($row['aboutus'], 0, 50) . '</p>';
        }
        $this->data["[VARFOOTER]"] = $txt;
    }

    public function selmenucomp() {
        $txt = '';
        if (isset($_POST['data'])) {
            switch ($_POST['data']) {
                case 'past' :
                    $cond = 'isopen=3 ORDER by id DESC';
                    break;
                case 'peresent':
                    $cond = 'isopen!=3 AND isopen!=0 ORDER by id DESC';
                    break;
                case 'futuer':
                    $cond = 'isopen=0 ORDER by id DESC';
                    break;
            }


            $res = $this->model->loadcomp($cond);
            if ($res) {
                while ($row = $res->fetch()) {
                    $txt .='<li class="mgtop15 main-menu-style"><a href="' . URL . 'comp/id/' . $row['id'] . '">' . $row['name'] . '</a></li>';
                }
            }
            $data = array('msg' => $txt);
            $data = json_encode($data);
            $this->view->render('comp/index', $data, false, 0);
        }
    }

    public function sendactivecod() {
        $tt = Session::get('codeactive');
        if (Session::get('codeactive') < 3) {
            $i = intval(Session::get('codeactive'));
            $i++;
            Session::set('codeactive', $i);
//        $fields = array('mobile', 'captcha_code');
            $msgid = 0;
            $msgtext = '';
            //check isset
//        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
//            if (Checkform::checknotempty($_POST, $fields)) {
//                if (strcmp(md5($_POST['captcha_code']), $_SESSION['random_txt']) == 0) {
            $cond = 'mobile=:mobile';
            $condata = array('mobile' => session::get('mobilenumber'));
            $result = $this->model->selectuid($cond, $condata);
            if ($result) {
                $row = $result->fetch();
                $id = $row['id'];
                $cond = 'userid=:userid';
                $condata = array('userid' => $row['id']);
                $res = $this->model->selectusers($cond, $condata);
                if ($res) {
                    $row = $res->fetch();
                    if (time() > $row['activtime'] + 120) {
                        $cond = 'userid=:userid';
                        $condata = array('userid' => $id);
                        $resis = $this->model->iscode($cond, $condata);
                        if ($resis) {
                            $actcode = Utilities::random(6);
                            $recnumber = session::get('mobilenumber');
                            Caller::sms($recnumber, session::get('activevalue'));
//                            $cond = 'userid=:userid';
//                            $condata = array('userid' => $id);
//                            $data = array('activtime' => time());
//                            $this->model->updatenewpas($data, $cond, $condata);
                            $msgid = 1;
                        } else {
                            $actcode = Utilities::random(6);
                            $recnumber = session::get('mobilenumber');
                            Caller::sms($recnumber, $actcode);
                            $data = array('userid' => $id, 'activecode' => md5($actcode), 'activtime' => time());
                            $this->model->insertnewactive($data);
//                            $cond = 'userid=:userid';
//                            $condata = array('userid' => $id);
//                            $data = array('activecode' => md5($actcode), 'activtime' => time());
//                            $this->model->insertnewpass($data, $cond, $condata);
                            $msgid = 1;
                        }
                    } else {

                        $msgid = 2;
                        $msgtext = 'شما به تازگی درخواست کد داده اید';
                    }
                } else {
                    $cond = 'mobile=:mobile';
                    $condata = array('mobile' => session::get('mobilenumber'));
                    $res = $this->model->selectuid($cond, $condata);
                    if ($res) {
                        $row = $res->fetch();
                        if ($row['confirm'] == 0) {
                            $actcode = Utilities::random(6);
                            $recnumber = session::get('mobilenumber');
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
                $msgtext = 'به علت تاخیر بیش از حد لطفا مراحل عضویت را از ابتدا شروع کنید';
            }
//                } else {
//                    $msgid = 0;
//                    $msgtext = 'کد امنیتی صحیح نیست';
//                }
//            } else {
//                $msgid = 0;
//                $msgtext = 'لطفا همه موارد را وارد نمایید';
//            }
//        } else {
//            $msgid = 0;
//            $msgtext = 'لطفا همه موارد را وارد نمایید';
//        }
            $data = array('id' => $msgid, 'msg' => $msgtext);
            $data = json_encode($data);
            $this->view->render('index/index', $data, false, 0);
            return FALSE;
        } else {
            $data = array('id' => 0, 'msg' => 'سیستم دچار مشکل شده است');
            $data = json_encode($data);
            $this->view->render('index/index', $data, false, 0);
            return FALSE;
        }
    }

    public function dltnotactive() {
        $condd = 'activtime < ' . (time() - 480);
        $res = $this->model->selnotact($condd);
        if ($res) {
            while ($row = $res->fetch()) {
                $cond = 'id=:id AND confirm= 0';
                $condata = array('id' => $row['userid']);
                $result = $this->model->selctusers($cond, $condata);
                if ($result) {
                    $this->model->deletusernotactiv($cond, $condata);
                    $condd = 'activtime < ' . (time() - 480);
                    $this->model->delactivcod($condd);
                }
            }
        }
    }

}
