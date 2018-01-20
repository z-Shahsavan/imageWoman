<?php

class setting extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::access_control('isuser', 'index#loginlink', 1);
    }

    const TOP = 12;

    public function index() {
        $this->loadcomp();
        $this->loadlocation();
        $this->loadokimages();
        $this->view->render('setting/index', $this->data);
    }

    public function loadcomp() {
        $res = $this->model->loadcomps();
        if ($res != FALSE) {
            $this->data['[VARSUBJECTS]'] = '';
            while ($row = $res->fetch()) {
                $this->data['[VARSUBJECTS]'].='<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
            }
        }
    }

    public function delav() {
        $this->model->delav(array('isavatar' => 0), 'id=:uid', array('uid' => Session::get('userid')));
        $av = Utilities::imgname('avatar', Session::get('userid')) . '.jpg';
        $address = $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . '/images/avatar/' . $av;
        unlink($address);
        Session::set('isavatar', 0);
        $this->view->render('setting/index', Utilities::imgname('avatar', 'default') . '.jpg', FALSE, 0);
    }

    public function loadlocation() {
        $res = $this->model->loadlocation();
        if ($res != FALSE) {
            $this->data['[VARSTATES]'] = '';
            while ($row = $res->fetch()) {
                $this->data['[VARSTATES]'].='<option value="' . $row['id'] . '">' . htmlspecialchars($row['state']) . '</option>';
            }
        }
    }

    public function loadokimages() {
        $returndata = '';
        $userid = Session::get('userid');
        if ($userid != FALSE) {
            if (!isset($_POST['tab']) || $_POST['tab'] == 1) {
                $cond = 'confirm=1 AND userid=:userid';
                Session::set('cond', $cond);
                $cond.=' Limit ' . self::TOP;
                $condata = array('userid' => $userid);
                Session::set('condata', $condata);
                $result = $this->model->loadokimage($cond, $condata);
                if ($result != FALSE) {
                    while ($row = $result->fetch()) {
                        $res = $this->model->loadlocation($row['locate']);
                        if ($res != FALSE) {
                            $rowloc = $res->fetch();
                            $locid = $rowloc['id'];
                        } else {
                            $locid = 32;
                        }

                        $thmname = Utilities::imgname('thumb', $row['id']) . '.jpg';
                        $returndata.='<div class="brick" style="box-shadow: 0px 0px 2px #888888;">
                        <div class="image-head">
                            <a href="#">
                                <div class="details-image1">
                                    <span style="padding: 5px;">' . htmlspecialchars($row['name']) . '</span>
                               </div>
                               <div class="id none">' . $row['id'] . '</div>
                               <div class="mozuval none">' . $locid . '</div>
                               <h3 class="dt1 tl none">' . htmlspecialchars($row['name']) . '</h3>
                               <div class="dt none">' . Shamsidate::jdate('Y/m/d', $row['date']) . '</div>
                               <div class="tg none">' . htmlspecialchars($row['tags']) . '</div>
                               <div class="cmp none">' . $row['compid'] . '</div>
                               <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '</div>
                            </a>
                        </div>
                        <a href="#"><img src="' . URL . 'images/gallery/thumb/' . $thmname . '" width="100%"></a>
                    </div>';
                    }
                    if (isset($_POST['tab'])) {
                        $this->view->render('setting/index', $returndata, FALSE, 0);
                    } else {
                        $this->data['[VARGALIMAGES]'] = $returndata;
                    }
                }
            } else {
                $cond = 'confirm=0 AND userid=:userid';
                Session::set('cond', $cond);
                $cond.=' Limit ' . self::TOP;
                $condata = array('userid' => $userid);
                Session::set('condata', $condata);
                $result = $this->model->loadokimage($cond, $condata);
                if ($result != FALSE) {
                    while ($row = $result->fetch()) {
                        $res = $this->model->loadlocation($row['locate']);
                        if ($res != FALSE) {
                            $rowloc = $res->fetch();
                            $locid = $rowloc['id'];
                        } else {
                            $locid = 32;
                        }
                        $thmname = Utilities::imgname('thumb', $row['id']) . '.jpg';
                        //check comp
                        $returndata.='<div class="brick operation-hover" style="box-shadow: 0px 0px 2px #888888;">
                        <div class="image-head">
                            <a href="#">
                                <div class="details-image1">
                                    <span style="padding: 5px;">' . htmlspecialchars($row['name']) . '</span>
                                </div>
                                  <div class="id none">' . $row['id'] . '</div>
                               <div class="mozuval none">' . $locid . '</div>
                               <h3 class="dt1 tl none">' . htmlspecialchars($row['name']) . '</h3>
                               <div class="dt none">' . Shamsidate::jdate('Y/m/d', $row['date']) . '</div>
                               <div class="tg none">' . htmlspecialchars($row['tags']) . '</div>
                               <div class="cmp none">' . $row['compid'] . '</div>
                               <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '</div>
                            </a>
                            <div class="operation-details">
                                <a id="delitm" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                <a id="edititm" href="#" data-toggle="modal" data-target="#modaleditgallery"><span class="glyphicon glyphicon-pencil"></span></a>
                            </div>
                        </div>
                        <a href="#"><img src="' . URL . 'images/gallery/thumb/' . $thmname . '" width="100%"></a>
                    </div>';
                    }
                }
                $this->view->render('setting/index', $returndata, FALSE, 0);
            }
        } else {
            header('Location: ' . URL . 'index#loginlink');
        }
    }

    public function paging() {
        $ispeople = '';
        $returndata = '';
        if (isset($_POST['pid'])) {
            switch ($_POST['whichpg']) {
                case 1: {
                        $cond = Session::get('cond'); //echo $cond;
                        $condata = Session::get('condata');
                        $lmt = self::TOP * ($_POST['pid'] - 1);
                        $cond .= ' Limit :lmt ,:top ';
                        $condata['lmt'] = $lmt;
                        $condata['top'] = self::TOP;
                        //. $lmt . ', ' . self::TOP;
                        $result = $this->model->loadokimage($cond, $condata);
                        if ($result != FALSE) {
                            while ($row = $result->fetch()) {
                                $res = $this->model->loadlocation($row['locate']);
                                if ($res != FALSE) {
                                    $rowloc = $res->fetch();
                                    $locid = $rowloc['id'];
                                } else {
                                    $locid = 32;
                                }

                                $thmname = Utilities::imgname('thumb', $row['id']) . '.jpg';
                                $returndata.='<div class="brick" style="box-shadow: 0px 0px 2px #888888;">
                        <div class="image-head">
                            <a href="#">
                                <div class="details-image1">
                                    <span style="padding: 5px;">' . htmlspecialchars($row['name']) . '</span>
                               </div>
                               <div class="id none">' . $row['id'] . '</div>
                               <div class="mozuval none">' . $locid . '</div>
                               <h3 class="dt1 tl none">' . htmlspecialchars($row['name']) . '</h3>
                               <div class="dt none">' . Shamsidate::jdate('Y/m/d', $row['date']) . '</div>
                               <div class="tg none">' . htmlspecialchars($row['tags']) . '</div>
                               <div class="cmp none">' . $row['compid'] . '</div>
                               <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '</div>
                            </a>
                        </div>
                        <a href="#"><img src="' . URL . 'images/gallery/thumb/' . $thmname . '" width="100%"></a>
                    </div>';
                            }
                        }
                        $this->view->render('setting/index', $returndata, false, 0);
                        return FALSE;
                        break;
                    }
                case 2: {
                        $cond = Session::get('cond'); //echo $cond;
                        $condata = Session::get('condata');
                        $lmt = self::TOP * ($_POST['pid'] - 1);
                        $cond .= ' Limit :lmt ,:top ';
                        $condata['lmt'] = $lmt;
                        $condata['top'] = self::TOP;
                        $result = $this->model->loadokimage($cond, $condata);
                        if ($result != FALSE) {
                            while ($row = $result->fetch()) {
                                $res = $this->model->loadlocation($row['locate']);
                                if ($res != FALSE) {
                                    $rowloc = $res->fetch();
                                    $locid = $rowloc['id'];
                                } else {
                                    $locid = 32;
                                }
                                $thmname = Utilities::imgname('thumb', $row['id']) . '.jpg';
                                //check comp
                                $returndata.='<div class="brick operation-hover" style="box-shadow: 0px 0px 2px #888888;">
                        <div class="image-head">
                            <a href="#">
                                <div class="details-image1">
                                    <span style="padding: 5px;">' . htmlspecialchars($row['name']) . '</span>
                                </div>
                                  <div class="id none">' . $row['id'] . '</div>
                               <div class="mozuval none">' . $locid . '</div>
                               <h3 class="dt1 tl none">' . htmlspecialchars($row['name']) . '</h3>
                               <div class="dt none">' . Shamsidate::jdate('Y/m/d', $row['date']) . '</div>
                               <div class="tg none">' . htmlspecialchars($row['tags']) . '</div>
                               <div class="cmp none">' . $row['compid'] . '</div>
                               <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '</div>
                            </a>
                            <div class="operation-details">
                                <a id="delitm" href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                <a id="edititm" href="#" data-toggle="modal" data-target="#modaleditgallery"><span class="glyphicon glyphicon-pencil"></span></a>
                            </div>
                        </div>
                        <a href="#"><img src="' . URL . 'images/gallery/thumb/' . $thmname . '" width="100%"></a>
                    </div>';
                            }
                        }
                        $this->view->render('setting/index', $returndata, FALSE, 0);
                    }
                    break;
            }
        }
    }

    public function pagingokimage() {
        $returndata = '';
        $fields = array('idxid', 'pgid');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $userid = Session::get('userid');
                if ($userid != FALSE) {
                    switch ($_POST['idxid']) {
                        case 1:
                            $lmt = self::top * ($_POST['pgid'] - 1);
                            $cond = 'confirm=1 AND userid=:userid Limit ' . $lmt . ',' . self::top;
                            $condata = array('userid' => $userid);
                            $result = $this->model->loadokimage($cond, $condata);
                            if ($result != FALSE) {
                                while ($row = $result->fetch()) {
                                    $res = $this->model->loadlocation($row['locate']);
                                    if ($res != FALSE) {
                                        $rowloc = $res->fetch();
                                        $locid = $rowloc['id'];
                                    } else {
                                        $locid = 32;
                                    }

                                    $thmname = Utilities::imgname('thumb', $row['id']) . '.jpg';
//check comp
                                    $returndata.='<div class="brick" style="box-shadow: 0px 0px 2px #888888;">
                        <div class="image-head">
                            <a href="#">
                                <div class="details-image1">
                                    <span style="padding: 5px;">' . htmlspecialchars($row['name']) . '</span>
                                </div>
                            </a>
                        </div>
                        <a href="#"><img src="' . URL . 'images/gallery/thumb/' . $thmname . '" width="100%"></a>
                    </div>';
                                }
                            }
                            break;
                        case 2:
                            $lmt = self::top * ($_POST['pgid'] - 1);
                            $cond = 'confirm=0 AND userid=:userid Limit ' . $lmt . ',' . self::top;
                            $condata = array('userid' => $userid);
                            $result = $this->model->loadokimage($cond, $condata);
                            if ($result != FALSE) {
                                while ($row = $result->fetch()) {
                                    $res = $this->model->loadlocation($row['locate']);
                                    if ($res != FALSE) {
                                        $rowloc = $res->fetch();
                                        $locid = $rowloc['id'];
                                    } else {
                                        $locid = 32;
                                    }
                                    $thmname = Utilities::imgname('thumb', $row['id']) . '.jpg';
//check comp
                                    $returndata.='<div class="brick operation-hover" style="box-shadow: 0px 0px 2px #888888;">
                        <div class="image-head">
                            <a href="#">
                                <div class="details-image1">
                                    <span style="padding: 5px;">' . htmlspecialchars($row['name']) . '</span>
                                </div>
                            </a>
                            <div class="operation-details">
                                <a  href="#"><span class="glyphicon glyphicon-remove"></span></a>
                                <a  href="#" data-toggle="modal" data-target="#modaleditgallery"><span class="glyphicon glyphicon-pencil"></span></a>
                            </div>
                        </div>
                        <a href="#"><img src="' . URL . 'images/gallery/thumb/' . $thmname . '" width="100%"></a>
                    </div>';
                                }
                            }
                            break;
                    }
                } else {
                    header('Location: ' . URL . 'index#loginlink');
                }
            }
        }
        $data = array('id' => '1', 'msg' => $returndata);
        $data = json_encode($data);
        $this->view->render('setting/index', $data, false, 0);
    }

    public function editimage() {
        $returndata = '';
        $fields = array('id', 'competition'); //, 'name', 'comment', 'date', 'subject'
//check isset
        if (Checkform::checkset($_POST, $fields)) {
//check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $userid = Session::get('userid');
                if ($userid != FALSE) {
                    if (isset($_POST['mozu']) && !empty($_POST['mozu'])) {
                        $resloc = $this->model->loadlocationbyid($_POST['mozu']);
                        if ($resloc != FALSE) {
                            $rowloc = $resloc->fetch();
                            $location = $rowloc['state'];
                        } else {
                            $location = 'سایر';
                        }
                    } else {
                        $location = 'سایر';
                    }
                    if (isset($_POST['date']) && !empty($_POST['date'])) {
                        $data = explode('/', $_POST['date']);
                        $st = Shamsidate::jmktime(0, 0, 0, $data[1], $data[2], $data[0]);
                    } else {
                        $st = time();
                    }

                    $updata = array('name' => (isset($_POST['name'])) ? $_POST['name'] : '', 'comment' => (isset($_POST['comment'])) ? $_POST['comment'] : '', 'date' => $st, 'tags' => (isset($_POST['subject'])) ? $_POST['subject'] : '', 'compid' => $_POST['competition'], 'locate' => $location, 'bazid' => 0);
                    $cond = 'id=:id and userid=:userid';
                    $condata = array('id' => $_POST['id'], 'userid' => $userid, 'confirm' => 0);
                    $this->model->editimage($updata, $cond, $condata);
//data is saved
                    $data = array('id' => '1', 'msg' => 'اطلاعات ثبت شد');
                    $data = json_encode($data);
                    $this->view->render('setting/index', $data, false, 0);
                } else {
                    header('Location: ' . URL . 'index#loginlink');
                }
            } else {
//all field rquier
                $data = array('id' => '0', 'msg' => 'لطفا تمامی فیلد هارا پر کنید');
                $data = json_encode($data);
                $this->view->render('setting/index', $data, false, 0);
            }
        } else {
//all field rquier
            $data = array('id' => '0', 'msg' => 'لطفا تمامی فیلد هارا پر کنید');
            $data = json_encode($data);
            $this->view->render('setting/index', $data, false, 0);
        }
    }

    public function changeimgavat() {
        $returndata = '';
        $userid = Session::get('userid');
        if ($userid != FALSE) {
            $updata = array();
//check header file
            $header = Photoutil::photocheck(0);
            $isheader = FALSE;
            switch ($header) {
                case 1:
                    $isheader = FALSE;
                    break;
                case 2:
//header photo not true
                    $data = array('id' => '0', 'msg' => 'فرمت عکس ارسالی مجاز نیست');
                    $data = json_encode($data);
                    $this->view->render('setting/index', $data, false, 0);
                    return;
                    break;
                case 3:
                    $data = array('id' => '0', 'msg' => 'تصویر انتخابی دارای مشکل است');
                    $data = json_encode($data);
                    $this->view->render('setting/index', $data, false, 0);
                    return;
                    break;
                case 4:
                    $data = array('id' => '0', 'msg' => 'تصویر انتخابی کوچکتر از اندازه استاندارد است');
                    $data = json_encode($data);
                    $this->view->render('setting/index', $data, false, 0);
                    return;
                    break;
                case 5:
                    $data = array('id' => '0', 'msg' => 'تصویر انتخابی بزرگتر از اندازه استاندارد است');
                    $data = json_encode($data);
                    $this->view->render('setting/index', $data, false, 0);
                    return;
                    break;
                default :
                    $isheader = TRUE;
                    break;
            }
            if ($isheader == TRUE) {
                $imgname = Utilities::imgname('header', $userid) . '.jpg';
                Photoutil::convertImage($_FILES[0]['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . '/images/header/' . $imgname, $header, 100);
                $updata['isheader'] = 1;
            }
//check avatar
            $avatar = Photoutil::avatarcheck('vatar');
            $isavatar = FALSE;
            switch ($avatar) {
                case 1:
                    $isavatar = FALSE;
                    break;
                case 2:
//avatar photo not true
                    $data = array('id' => '0', 'msg' => 'فرمت تصویر انتخابی  مجاز نیست');
                    $data = json_encode($data);
                    $this->view->render('setting/index', $data, false, 0);
                    return;
                    break;
                case 3:
                    $data = array('id' => '0', 'msg' => 'تصویر انتخابی دارای مشکل است');
                    $data = json_encode($data);
                    $this->view->render('setting/index', $data, false, 0);
                    return;
                    break;
//                case 4:
//                    $data = array('id' => '0', 'msg' => 'حجم فایل باید حداکثر ' . AVATAR_MAX_SIZE . ' کیلوبایت باشد');
//                    $data = json_encode($data);
//                    $this->view->render('setting/index', $data, false, 0);
//                    return;
//                    break;
                default :
                    $isavatar = TRUE;
                    break;
            }
            $vatar = '';
            if ($isavatar == TRUE) {
                $imgname = Utilities::imgname('avatar', $userid) . '.jpg';
                Photoutil::convertImage($_FILES['vatar']['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . '/images/avatar/' . $imgname, $avatar, 100);
                Photoutil::make_thumbacatar($_SERVER['DOCUMENT_ROOT'] . '/' . PROJECTNAME . '/images/avatar/' . $imgname, $_SERVER['DOCUMENT_ROOT'] . '/' . PROJECTNAME . '/images/avatar/' . $imgname, 200);
                $updata['isavatar'] = 1;
                $vatar = URL . '/images/avatar/' . $imgname;
            }
            $fields = array('userinfo');
//check isset
            if (Checkform::checkset($_POST, $fields)) {
//check not empty
                if (Checkform::checknotempty($_POST, $fields)) {
                    $updata['userinfo'] = $_POST['userinfo'];
                }
            }
            $cond = 'id=:id';
            $condata = array('id' => $userid);
            $this->model->edituser($updata, $cond, $condata);
            Session::set('isavatar', 1);
            $data = array('vatar' => $vatar, 'id' => '1', 'msg' => 'تغییرات شما ثبت شد');
            $data = json_encode($data);
            $this->view->render('setting/index', $data, false, 0);
            return;
        } else {
            header('Location: ' . URL . 'index#loginlink');
        }
    }

    public function loadavatar() {
        $returndata = '';
        $userid = Session::get('userid');
        if ($userid != FALSE) {
            $result = $this->model->selectuser($userid);
            if ($result != FALSE) {
                $hasav = 0;
                $row = $result->fetch();
                if ($row['isavatar'] == 1) {
                    $hasav = 1;
                    $imgname = Utilities::imgname('avatar', $userid) . '.jpg';
                    $vatar = URL . '/images/avatar/' . $imgname;
                } else {
                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                    $vatar = URL . '/images/avatar/' . $imgname;
                }

                if ($row['isheader'] == 1) {
                    $imgname = Utilities::imgname('header', $userid) . '.jpg';
                    $header = URL . '/images/header/' . $imgname;
                } else {
                    $imgname = Utilities::imgname('header', 'default') . '.jpg';
                    $header = URL . '/images/header/' . $imgname;
                }
                $info = $row['userinfo'];
                $data = array('userinfo' => $info, 'header' => $header, 'vatar' => $vatar, 'hasav' => $hasav);
                $data = json_encode($data);
                $this->view->render('setting/index', $data, false, 0);
            } else {
                header('Location: ' . URL . 'index#loginlink');
            }
        } else {
            header('Location: ' . URL . 'index#loginlink');
        }
    }

    public function loadinfo() {
        $returndata = '';
        $userid = Session::get('userid');
        if ($userid != FALSE) {
            $result = $this->model->selectuser($userid);
            if ($result != FALSE) {
                $row = $result->fetch();
                $data = array('name' => $row['name'], 'family' => $row['family'], 'melicode' => $row['melicode'], 'postcode' => $row['postcode'], 'address' => $row['address'], 'tel' => $row['tel'], 'mobile' => $row['mobile'], 'mail' => $row['mail']);
                $data = json_encode($data);
                $this->view->render('setting/index', $data, false, 0);
            } else {
                header('Location: ' . URL . 'index#loginlink');
            }
        } else {
            header('Location: ' . URL . 'index#loginlink');
        }
    }

    public function changeinfo() {
        $returndata = '';
        $userid = Session::get('userid');
        if ($userid != FALSE) {
            $fields = array('mobile');
            if (Checkform::checkset($_POST, $fields)) {
                if (Checkform::checknotempty($_POST, $fields)) {
//check melicode is true
                    $melicode = 0;
                    if (isset($_POST['melicode']) && !empty($_POST['melicode'])) {
                        $melicode = 1;
                        if (!Utilities::ismelicode($_POST['melicode'])) {
//melicode not true
                            $data = array('id' => '0', 'msg' => 'کد ملی وارد شده صحیح نیست');
                            $data = json_encode($data);
                            $this->view->render('setting/index', $data, false, 0);
                            return FALSE;
                        }
                    } else {
                        $melicode = 0;
                    }

//check mobile not exist
                    if ($this->model->checkmobile($_POST['mobile'], $userid) == FALSE) {
//check melicode not exist
                        if ($melicode == 1) {
                            $vaz = $this->model->checkmelicode($_POST['melicode'], $userid);
                        } else {
                            $vaz = FALSE; //melicode not exist
                        }

                        if ($vaz == FALSE) {
                            $userid = Session::get('userid');
                            $data = array('name' => $_POST['name'], 'family' => $_POST['lastname'], 'melicode' => $_POST['melicode'], 'postcode' => (isset($_POST['postcode'])) ? $_POST['postcode'] : '', 'address' => (isset($_POST['address'])) ? $_POST['address'] : '', 'tel' => $_POST['tel'], 'mobile' => $_POST['mobile'], 'mail' => (isset($_POST['email'])) ? $_POST['email'] : '');
                            $cond = 'id=:id';
                            $condata = array('id' => $userid);
                            $this->model->edituser($data, $cond, $condata);
//                            }
                            $res = $this->model->selectuser($userid);
                            $row = $res->fetch();
                            if (strcmp($row['mobile'], $_POST['mobile']) != 0) {
//send sms in there
                            }
                            $data = array('id' => '1', 'msg' => 'تغییرات با موفقیت ثبت شد');
                            $data = json_encode($data);
                            $this->view->render('setting/index', $data, false, 0);
                            return FALSE;
                        } else {
//melicode is exist
                            $data = array('id' => '0', 'msg' => 'این کد ملی در سیستم وجود دارد');
                            $data = json_encode($data);
                            $this->view->render('setting/index', $data, false, 0);
                        }
                    } else {
//mobile exist
                        $data = array('id' => '0', 'msg' => 'این شماره موبایل در سیستم وجود دارد');
                        $data = json_encode($data);
                        $this->view->render('setting/index', $data, false, 0);
                    }
                } else {
//data is empty
                    $data = array('id' => '0', 'msg' => 'لطفا موارد خواسته شده را وارد نمایید');
                    $data = json_encode($data);
                    $this->view->render('setting/index', $data, false, 0);
                }
            } else {
//data not post
                $this->index();
            }
        } else {
            header('Location: ' . URL . 'index#loginlink');
        }
    }

    public function changepass() {
        $returndata = '';
        $userid = Session::get('userid');
        if ($userid != FALSE) {
            $fields = array('oldpass', 'password', 'confrim');
            if (Checkform::checkset($_POST, $fields)) {
                if (Checkform::checknotempty($_POST, $fields)) {
//check old pass
                    $res = $this->model->selectuser($userid);
                    $row = $res->fetch();
//check pass and confirm
                    if (strcmp($_POST['confrim'], $_POST['password']) == 0) {
                        if (strcmp($row['password'], md5($_POST['oldpass'])) == 0) {
                            $updata = array('password' => md5($_POST['password']));
                            $cond = 'id=:id';
                            $condata = array('id' => $userid);
                            $this->model->edituser($updata, $cond, $condata);
//password changed
                            $data = array('id' => '1', 'msg' => 'رمز عبور شما تغییر کرد');
                            $_SESSION = array();
                            session_destroy();
                            session_unset();
                            $data = json_encode($data);
                            $this->view->render('setting/index', $data, false, 0);
                        } else {
//old pass not true
                            $data = array('id' => '0', 'msg' => 'رمز عبور قبلی وارد شده صحیح نیست');
                            $data = json_encode($data);
                            $this->view->render('setting/index', $data, false, 0);
                        }
                    } else {
//pass and confirm not equal
                        $data = array('id' => '0', 'msg' => 'رمزعبور وارد شده با تکرار آن برابر نیست');
                        $data = json_encode($data);
                        $this->view->render('setting/index', $data, false, 0);
                    }
                } else {
//data is empty
                    $data = array('id' => '0', 'msg' => 'لطفا اطلاعات خواسته شده را وارد نمایید');
                    $data = json_encode($data);
                    $this->view->render('setting/index', $data, false, 0);
                }
            } else {
//data is empty
                $data = array('id' => '0', 'msg' => 'لطفا اطلاعات خواسته شده را وارد نمایید');
                $data = json_encode($data);
                $this->view->render('setting/index', $data, false, 0);
            }
        } else {
            header('Location: ' . URL . 'index#loginlink');
        }
    }

    public function delimage() {
        $returndata = '';
        $userid = Session::get('userid');
        if ($userid != FALSE) {
            $fields = array('id');
//check isset
            if (Checkform::checkset($_POST, $fields)) {
//check not empty
                if (Checkform::checknotempty($_POST, $fields)) {
                    $cond = 'id=:id AND userid=:userid AND confirm=0';
                    $condata = array('id' => $_POST['id'], 'userid' => $userid);
                    $res = $this->model->loadokimage($cond, $condata);
                    if ($res != FALSE) {
                        $row = $res->fetch();
                        $imgname = Utilities::imgname('origsize', $row['id']) . '.jpg';
                        $thmname = Utilities::imgname('thumb', $row['id']) . '.jpg';
//                        $imgname = $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . '/images/gallery/origsize/' . $imgname;
                        $thmname = $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . '/images/gallery/thumb/' . $thmname;
                        $this->model->delimage($cond, $condata);
//                        unlink($imgname);
                        unlink($thmname);
                    }
                }
            }
        }
    }

    public function senddeactive() {
        $msgid = 0;
        $msgtext = '';
        $userid = Session::get('userid');
        $resuser = $this->model->selectuser($userid);
        if ($resuser != FALSE) {
            $rowuser = $resuser->fetch();
            if ($userid != FALSE) {
                $cond = 'userid=:userid';
                $condata = array('userid' => $rowuser['id']);
                $res = $this->model->checkdeactivecode($cond, $condata);
                if ($res != FALSE) {
                    $row = $res->fetch();
                    if (time() > $row['acttinme'] + 300) {
                        $actcode = Utilities::random(6);
                        $recnumber = $rowuser['mobile'];
                        Caller::deact($recnumber, $actcode);
                        $cond = 'userid=:userid';
                        $condata = array('userid' => $userid);
                        $data = array('deccode' => md5($actcode));
                        $this->model->updatedeactivecode($data, $cond, $condata);
                        $msgid = 1;
                    } else {
                        $msgid = 0;
                        $msgtext = 'شما به تازگی درخواست کد داده اید';
                    }
                } else {
                    $actcode = Utilities::random(6);
                    $recnumber = $rowuser['mobile'];
                    Caller::deact($recnumber, $actcode);
                    $data = array('deccode' => md5($actcode), 'userid' => $rowuser['id'], 'acttinme' => time());
                    $this->model->savedeactivecode($data);
                    $msgid = 1;
                }
            }
        }
        $data = array('id' => $msgid, 'msg' => $msgtext);
        $data = json_encode($data);
        $this->view->render('setting/index', $data, false, 0);
    }

    public function makedeactive() {
        $fields = array('regactcode');
        $msgid = 0;
        $msgtext = '';
//check isset
        $userid = Session::get('userid');
        $resuser = $this->model->selectuser($userid);
        if ($resuser != FALSE) {
            $rowuser = $resuser->fetch();
            if (Checkform::checkset($_POST, $fields)) {
//check not empty
                if (Checkform::checknotempty($_POST, $fields)) {
                    $cond = 'userid=:userid AND deccode=:deccode';
                    $condata = array('userid' => $rowuser['id'], 'deccode' => md5($_POST['regactcode']));
                    $result = $this->model->checkdeactivecode($cond, $condata);
                    if ($result != FALSE) {

                        $cond = 'acttinme < ' . (time() - 120);
                        $this->model->deldeactivecode($cond);
                        $cond = 'userid=:userid AND deccode=:deccode';
                        $condata = array('userid' => $rowuser['id'], 'deccode' => md5($_POST['regactcode']));
                        $result = $this->model->checkdeactivecode($cond, $condata);
                        if ($result != FALSE) {
                            $cond = 'userid=:userid AND deccode=:deccode';
                            $condata = array('userid' => $rowuser['id'], 'deccode' => md5($_POST['regactcode']));
                            $this->model->deldeactivecode($cond, $condata);
                            $cond = 'id=:userid';
                            $condata = array('userid' => $rowuser['id']);
//
                            $updata = array();
                            $mobres = $this->model->getusermobile('mobile', $cond, $condata);
                            $mobile = 0;
                            if ($mobres) {
                                $mobrow = $mobres->fetch();
                                $mobile = $mobrow['mobile'];
                                $updata['mobile'] = substr($mobile, 2);
                            }
                            $updata['confirm'] = 0;
                            $this->model->edituser($updata, $cond, $condata);
                            $_SESSION = array();
                            session_destroy();
                            session_unset();
                            $msgid = 1;
                            $msgtext = 'اکانت شما غیرفعال شد';
                        } else {
                            $msgid = 0;
                            $msgtext = 'اعتبار زمانی کد شما پایان یافته است';
                        }
                    } else {
                        $msgid = 0;
                        $msgtext = 'کد وارد شده صحیح نیست';
                    }
                } else {
                    $msgid = 0;
                    $msgtext = 'لطفا کد غیرفعال سازی را وارد نمایید';
                }
            } else {
                $msgid = 0;
                $msgtext = 'لطفا کد غیرفعال سازی را وارد نمایید';
            }
        }

        $data = array('id' => $msgid, 'msg' => $msgtext);
        $data = json_encode($data);
        $this->view->render('setting/index', $data, false, 0);
    }

    public function checknewmob() {
        $returndata = '';
        $userid = Session::get('userid');
        if ($userid != FALSE) {
            $fields = array('mobile');
            if (Checkform::checkset($_POST, $fields)) {
                if (Checkform::checknotempty($_POST, $fields)) {
//check mobile not exist
                    if ($this->model->checkmobile($_POST['mobile'], $userid) == FALSE) {
//check if change mobile
                        if ($this->model->checkmobile($_POST['mobile'], 0) == FALSE) {
//mobile change
                            if (strlen(trim($_POST['mobile'])) == 11) {
                                if (isset($_POST['melicode']) && !empty($_POST['melicode'])) {
                                    if (!Utilities::ismelicode($_POST['melicode'])) {
                                        //melicode not true
                                        $data = array('id' => '0', 'msg' => 'کد ملی وارد شده صحیح نیست');
                                        $data = json_encode($data);
                                        $this->view->render('setting/index', $data, false, 0);
                                        return FALSE;
                                    } else {
                                        $vaz = $this->model->checkmelicode($_POST['melicode'], $userid);
                                        if ($vaz != FALSE) {
                                            $data = array('id' => '0', 'msg' => 'این کد ملی در سیستم وجود دارد');
                                            $data = json_encode($data);
                                            $this->view->render('setting/index', $data, false, 0);
                                            return FALSE;
                                        }
                                    }
                                }
                                Session::set('newmobile', $_POST['mobile']);
                                $actcode = Utilities::random(6);
                                Session::set('changemob', $actcode);
                                $recnumber = $_POST['mobile'];
                                Caller::changemob($recnumber, $actcode);
                                $data = array('id' => '1', 'msg' => 'لطفا جهت ادامه عملیات ابتدا کد فعال سازی را وارد نمایید');
                                $data = json_encode($data);
                                $this->view->render('setting/index', $data, false, 0);
                            } else {
                                $data = array('id' => '0', 'msg' => 'شماره وارد شده معتبر نیست');
                                $data = json_encode($data);
                                $this->view->render('setting/index', $data, false, 0);
                            }
                        } else {
//mobile exist
                            $data = array('id' => '2', 'msg' => '');
                            $data = json_encode($data);
                            $this->view->render('setting/index', $data, false, 0);
                        }
                    } else {
//mobile exist
                        $data = array('id' => '0', 'msg' => 'این شماره موبایل در سیستم وجود دارد');
                        $data = json_encode($data);
                        $this->view->render('setting/index', $data, false, 0);
                    }
                } else {
//data is empty
                    $data = array('id' => '0', 'msg' => 'لطفا موارد خواسته شده را وارد نمایید');
                    $data = json_encode($data);
                    $this->view->render('setting/index', $data, false, 0);
                }
            } else {
//data is empty
                $data = array('id' => '0', 'msg' => 'لطفا موارد خواسته شده را وارد نمایید');
                $data = json_encode($data);
                $this->view->render('setting/index', $data, false, 0);
            }
        } else {
//data is empty
            $data = array('id' => '0', 'msg' => 'لطفا موارد خواسته شده را وارد نمایید');
            $data = json_encode($data);
            $this->view->render('setting/index', $data, false, 0);
        }
    }

    public function chackcodechange() {
        $fields = array('reccode');
        $return = array('id' => 0, 'msg' => '');
        $userid = Session::get('userid');
        $newmob = Session::get('newmobile');
        $actcode = Session::get('changemob');
        if ($userid == FALSE || $newmob == FALSE || $actcode == FALSE) {
            $data = array('id' => '0', 'msg' => 'عملیات انجام نشد');
            $data = json_encode($data);
            $this->view->render('setting/index', $data, false, 0);
            return;
        }
//check isset
        if (Checkform::checkset($_POST, $fields)) {
//check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
//check mobile not exist
                if ($this->model->checkmobilejad($newmob) == FALSE) {
                    if (strlen(trim($newmob)) == 11) {
                        if ($actcode == trim($_POST['reccode'])) {
                            $updata = array('mobile' => $newmob);
                            $cond = 'id=:id';
                            $condata = array('id' => $userid);
                            $this->model->edituser($updata, $cond, $condata);
                            $data = array('id' => '1', 'msg' => 'عملیات انجام نشد');
                            $data = json_encode($data);
                            $this->view->render('setting/index', $data, false, 0);
                        } else {
                            $data = array('id' => '0', 'msg' => 'کد وارد شده صحیح نیست');
                            $data = json_encode($data);
                            $this->view->render('setting/index', $data, false, 0);
                        }
                    } else {
                        $data = array('id' => '0', 'msg' => 'شماره وارد شده معتبر نیست');
                        $data = json_encode($data);
                        $this->view->render('setting/index', $data, false, 0);
                    }
                } else {
                    $data = array('id' => '0', 'msg' => 'این شماره قبلا ثبت شده است');
                    $data = json_encode($data);
                    $this->view->render('setting/index', $data, false, 0);
                }
            } else {
                $data = array('id' => '0', 'msg' => 'کد تغییر شماره را وارد نمایید');
                $data = json_encode($data);
                $this->view->render('setting/index', $data, false, 0);
            }
        } else {
            $data = array('id' => '0', 'msg' => 'کد تغییر شماره را وارد نمایید');
            $data = json_encode($data);
            $this->view->render('setting/index', $data, false, 0);
        }
    }

}
