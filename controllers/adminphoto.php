<?php

class adminphoto extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::access_control('isuser', 'index#loginlink', 4);
    }

    public function index() {
        $this->data['[VARBIGIMG]'] = 'images/gallery/origsize/';
        $this->published();
        $this->view->render('adminphoto/index', $this->data);
    }

    public function published() {
        $cond = 'confirm =:confirm ORDER BY pid DESC';
        $condata ['confirm'] = 1;
        Session::set('serchcond', $cond);
        Session::set('condata', $condata);
        Session::set('utiliti', 'thumb');
        Session::set('imgpath', 'thumb/');
        Session::set('a', 1);
        $photo = $this->model->loadphoto($condata, $cond);
        $numofpage = 0;
        if ($photo != FALSE) {
            $cnt = $photo->rowCount();
            $numofpage = ceil($cnt / 12);
            $list = '';
            $i = 0;
            while ($row = $photo->fetch()) {
                if ($i < 12) {
                    if ($row['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                        $thmname = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $thmname = URL . '/images/avatar/' . $imgname;
                    }

                    if ($row['uname'] != '' && $row['uf'] != '') {
                        $username = htmlspecialchars($row['uname']) . '  ' . htmlspecialchars($row['uf']);
                    } else {
                        $username = htmlspecialchars($row['username']);
                    }
                    $i++;
                    $img2 = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                    $list.='<div class="pitem">
                                <div class="id none">' . $row['pid'] . '</div>
                                    <input type="hidden" id="uuid" value="' . $row['userid'] . '"/>
                                <div class="zoomimg col s12 m4 right"><img class="responsive-img" src="' . URL . 'images/gallery/thumb/' . $img2 . '"></div>
                                <div class="cnt col s12 m8 right">';
                    if (mb_strlen($row['pn']) != 0) {
                        $list.='<h3 class="tl hd">نام تصویر : <span>' . htmlspecialchars($row['pn']) . '</span></h3>';
                    }

                    $list.= '<h3 class="sbj hd">نام مسابقه : <a href="' . URL . 'comp/id/' . $row['compid'] . '"><span>' . htmlspecialchars($row['cname']) . '</span></a></h3>
                                    <img class="av" src="' . $thmname . '">
                                    <a href="' . URL . 'blog/id/' . $row['userid'] . '"><div class="us" id="us' . $row['userid'] . '">' . $username . '</div></a><div class="dt">';
                    if (mb_strlen($row['pdate']) != 0) {
                        $list.='<i class="mdi-image-filter-5 lgico grey-text "></i><span>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['pdate'])) . '</span>';
                    }
                    $list.='</div><div class="cmt right-align">' . str_replace(PHP_EOL, '<br>', htmlspecialchars($row['comment'])) . '</div>
                                    <div class="adr none"></div>
                                </div>
                                <div class="btnsdiv col s12">
                                    <a class="delcmt bwaves-effect waves-white pink darken-4 right btn mgright"><i class="mdi-action-delete right"></i>عدم تایید</a>
                                </div>
                            </div>';
                }
            }
            $this->data['[VARITEMPHOTO]'] = $list;
        }
        $this->data['[VARIMAGECOUNT]'] = $numofpage;
    }

    public function paging() {
        if (isset($_POST['pid'])) {
            $lmt = 12 * ($_POST['pid'] - 1);
            $cond = Session::get('serchcond');
            
            $condata = Session::get('condata');
            $utiliti = Session::get('utiliti');
            $imgpath = Session::get('imgpath');
            $a = Session::get('a');
            
            
            $allphot=$this->model->loadphoto($condata, $cond);
            if($allphot!=FALSE){
                $cnt=$allphot->rowCount();
                if($cnt<=12){
                    $noapp=1;
                }  else {
                    $cond .= ' Limit ' . $lmt . ',12';
                    $noapp=0;
                }
            } 
            
            $photo = $this->model->loadphoto($condata, $cond);
            $list = '';
            if ($photo != FALSE) {

                while ($row = $photo->fetch()) {
                    if ($row['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                        $thmname = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $thmname = URL . '/images/avatar/' . $imgname;
                    }
                    if ($row['uname'] != '' && $row['uf'] != '') {
                        $username = htmlspecialchars($row['uname']) . '  ' . htmlspecialchars($row['uf']);
                    } else {
                        $username = htmlspecialchars($row['username']);
                    }
                    $img2 = Utilities::imgname($utiliti, $row['pid']) . '.jpg';
                    $list.='<div class="pitem">
                            <div class="id none">' . $row['pid'] . '</div>
                            <input type="hidden" id="uuid" value="' . $row['userid'] . '"/>
                            <div class="zoomimg col s12 m4 right"><img class="responsive-img" src="' . URL . 'images/gallery/' . $imgpath . $img2 . '"></div>
                            <div class="cnt col s12 m8 right">';
                    if (mb_strlen($row['pn']) != 0) {
                        $list.='<h3 class="tl hd">نام تصویر : <span>' . htmlspecialchars($row['pn']) . '</span></h3>';
                    }
                    $list.='<h3 class="sbj hd">نام مسابقه : <a href="' . URL . 'comp/id/' . $row['compid'] . '"><span>' . htmlspecialchars($row['cname']) . '</span></a></h3>
                            <img class="av" src="' . $thmname . '">
                            <a href="' . URL . 'blog/id/' . $row['userid'] . '"><div class="us" id="us' . $row['userid'] . '">' . $username . '</div></a><div class="dt">';
                    if (mb_strlen($row['pdate']) != 0) {
                        $list.='<i class="mdi-image-filter-5 lgico grey-text "></i><span>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['pdate'])) . '</span>';
                    }
                    $list.='</div><div class="cmt right-align">' . str_replace(PHP_EOL, '<br>', htmlspecialchars($row['comment'])) . '</div>
                            <div class="adr none">' . $img2 . '</div></div>';
                    switch ($a) {
                        case 1: {
                                $list.='<div class="confirm none">1</div>
                                <div class="btnsdiv col s12">
                                <a class="delcmt bwaves-effect waves-white pink darken-4 right btn mgright"><i class="mdi-action-delete right"></i>عدم تایید</a>
                                </div></div>';
                                break;
                            }
                        case 2: {
                                $list.='<div class="confirm none">0</div>
                                <div class="btnsdiv col s12">
                                <a class="okcmt bwaves-effect waves-white right btn"><i class="mdi-action-done right"></i>تایید</a>
                                <a class="delcmt bwaves-effect waves-white pink darken-4 right btn mgright"><i class="mdi-action-delete right"></i>عدم تایید</a>
                                </div></div>';
                                break;
                            }
                        case 3: {
                                $list.='<div class="confirm none">3</div>
                                <div class="btnsdiv col s12">
                                <a class="okcmt bwaves-effect waves-white right btn"><i class="mdi-action-done right"></i>تایید</a>
                                </div></div>';
                                break;
                            }
                        case 4: {
                                $list.='<div class="confirm none">4</div>
                                <div class="btnsdiv col s12">
                                <a class="okcmt bwaves-effect waves-white right btn"><i class="mdi-action-done right"></i>تایید</a>
                                </div></div>';
                                break;
                            }
                    }
                }
                $return=array('list'=>$list,'noapp'=>$noapp);
                $return=  json_encode($return);
                $this->view->render('adminphoto/index', $return, false, 0);
            }
        }
    }

    public function loadphoto() {
        $this->data['[VARIMAGECOUNT]'] = '';
        if (isset($_POST['data'])) {
            switch ($_POST['data']) {
                case 'catall': {
                        $cond = 'confirm =:confirm';
                        $condata ['confirm'] = 1;
                        $imgpath = 'thumb/';
                        $utiliti = 'thumb';
                        $a = 1;
                        break;
                    }
                case 'catviewd': {
                        $cond = 'confirm =:confirm';
                        $condata ['confirm'] = 0;
                        $imgpath = 'thumb/';
                        $utiliti = 'thumb';
                        $a = 2;
                        break;
                    }
                case 'norelateweb': {
                        $cond = 'confirm =:confirm';
                        $condata['confirm'] = 3;
                        $imgpath = 'norelate/2site/';
                        $utiliti = '2site';
                        $a = 3;
                        break;
                    }
                case 'norelatecomp': {
                        $cond = 'confirm =:confirm';
                        $condata['confirm'] = 2;
                        $imgpath = 'norelate/2comp/';
                        $utiliti = '2comp';
                        $a = 4;
                        break;
                    }
            }
            $cond.=' ORDER BY pid DESC';
            Session::set('serchcond', $cond);
            Session::set('condata', $condata);
            Session::set('utiliti', $utiliti);
            Session::set('imgpath', $imgpath);
            Session::set('a', $a);
            $photo = $this->model->loadphoto($condata, $cond);
            $numofpage = 0;
            if ($photo != FALSE) {
                $cnt = $photo->rowCount();
                $numofpage = ceil($cnt / 12);
                $list = '';
                $i = 0;
                while ($row = $photo->fetch()) {
                    if ($i < 12) {
                        if ($row['isavatar'] == 1) {
                            $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                            $thmname = URL . '/images/avatar/' . $imgname;
                        } else {
                            $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                            $thmname = URL . '/images/avatar/' . $imgname;
                        }
                        if ($row['uname'] != '' && $row['uf'] != '') {
                            $username = htmlspecialchars($row['uname']) . '  ' . htmlspecialchars($row['uf']);
                        } else {
                            $username = htmlspecialchars($row['username']);
                        }
                        $i++;
                        $img2 = Utilities::imgname($utiliti, $row['pid']) . '.jpg';
                        $list.='<div class="pitem">
                                <div class="id none">' . $row['pid'] . '</div>
                                    <input type="hidden" id="uuid" value="' . $row['userid'] . '"/>
                                <div class="zoomimg col s12 m4 right"><img class="responsive-img" src="' . URL . 'images/gallery/' . $imgpath . $img2 . '"></div>
                                <div class="cnt col s12 m8 right">';
                        if (mb_strlen($row['pn']) != 0) {
                            $list.='<h3 class="tl hd">نام تصویر : <span>' . htmlspecialchars($row['pn']) . '</span></h3>';
                        }
                        $list.=' <h3 class="sbj hd">نام مسابقه : <a href="' . URL . 'comp/id/' . $row['compid'] . '"><span>' . htmlspecialchars($row['cname']) . '</span></a></h3>
                                    <img class="av" src="' . $thmname . '">
                                    <a href="' . URL . 'blog/id/' . $row['userid'] . '"><div class="us" id="us' . $row['userid'] . '">' . $username . '</div></a><div class="dt">';
                        if (mb_strlen($row['pdate']) != 0) {
                            $list.='<i class="mdi-image-filter-5 lgico grey-text "></i><span>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['pdate'])) . '</span>';
                        }
                        $list.='</div><div class="cmt right-align">' . str_replace(PHP_EOL, '<br>', htmlspecialchars($row['comment'])) . '</div>
                                    <div class="adr none"></div>
                                </div>';
                        switch ($a) {
                            case 1: {
                                    $list.='<div class="confirm none">1</div>
                                        <div class="btnsdiv col s12">
                                    <a class="delcmt bwaves-effect waves-white pink darken-4 right btn mgright"><i class="mdi-action-delete right"></i>عدم تایید</a>
                                </div>
                            </div>';
                                    break;
                                }
                            case 2: {
                                    $list.='<div class="confirm none">0</div>
                                        <div class="btnsdiv col s12">
                                    <a class="okcmt bwaves-effect waves-white right btn"><i class="mdi-action-done right"></i>تایید</a>
                                    <a class="delcmt bwaves-effect waves-white pink darken-4 right btn mgright"><i class="mdi-action-delete right"></i>عدم تایید</a>
                                </div>
                            </div>';
                                    break;
                                }
                            case 3: {
                                    $list.='<div class="confirm none">3</div>
                                        <div class="btnsdiv col s12">
                                    <a class="okcmt bwaves-effect waves-white right btn"><i class="mdi-action-done right"></i>تایید</a>
                                </div>
                            </div>';
                                    break;
                                }
                            case 4: {
                                    $list.='<div class="confirm none">4</div>
                                        <div class="btnsdiv col s12">
                                    <a class="okcmt bwaves-effect waves-white right btn"><i class="mdi-action-done right"></i>تایید</a>
                                </div>
                            </div>';
                                    break;
                                }
                        }
                    }
                }
                $data = array('msg' => $list);
                $data = json_encode($data);
                $this->view->render('adminphoto/index', $data, false, 0);
            }
            $this->data['[VARIMAGECOUNT]'] = $numofpage;
        }
    }

    public function searchphoto() {
        if (isset($_POST['searchphoto'])) {
            $cond = '';
            switch ($_POST['pidhide']) {
                case 'catall': {
                        $cond = '(confirm=:confirm)';
                        $condata['confirm'] = 1;
                        $imgpath = 'thumb/';
                        $utiliti = 'thumb';
                        $a = 1;
                        break;
                    }
                case 'catviewd': {
                        $cond = '(confirm=:confirm)';
                        $condata['confirm'] = 0;
                        $imgpath = 'thumb/';
                        $utiliti = 'thumb';
                        $a = 0;
                        break;
                    }
                case 'norelateweb': {
                        $cond = '(confirm=:confirm)';
                        $condata['confirm'] = 3;
                        $imgpath = 'norelate/2site/';
                        $utiliti = '2site';
                        $a = 3;
                        break;
                    }
                case 'norelatecomp': {
                        $cond = '(confirm=:confirm)';
                        $condata['confirm'] = 2;
                        $imgpath = 'norelate/2comp/';
                        $utiliti = '2comp';
                        $a = 2;
                        break;
                    }
            }
            $cond .= ' AND ((pn LIKE :pn) OR (cname LIKE :cname) OR (comment LIKE :comment) OR (username LIKE :username)) ORDER BY pid DESC';
            $condata['pn'] = '%' . $_POST['searchphoto'] . '%';
            $condata['cname'] = '%' . $_POST['searchphoto'] . '%';
            $condata['comment'] = '%' . $_POST['searchphoto'] . '%';
            $condata['username'] = '%' . $_POST['searchphoto'] . '%';
            Session::set('serchcond', $cond);
            Session::set('condata', $condata);
            Session::set('utiliti', $utiliti);
            Session::set('imgpath', $imgpath);
            Session::set('a', $a);
            $res = $this->model->loadphoto($condata, $cond);
            $numofpage = 0;
            if ($res) {
                $cnt = $res->rowCount();
                $numofpage = ceil($cnt / 12);
                $list = '';
                $i = 0;
                while ($row = $res->fetch()) {
                    if ($i < 12) {
                        if ($row['isavatar'] == 1) {
                            $imgname = Utilities::imgname('avatar', $row['id']) . '.jpg';
                            $thmname = URL . '/images/avatar/' . $imgname;
                        } else {
                            $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                            $thmname = URL . '/images/avatar/' . $imgname;
                        }
                        if ($row['uname'] != '' && $row['uf'] != '') {
                            $username = htmlspecialchars($row['uname']) . '  ' . htmlspecialchars($row['uf']);
                        } else {
                            $username = htmlspecialchars($row['username']);
                        }
                        $i++;
                        $img2 = Utilities::imgname($utiliti, $row['pid']) . '.jpg';
                        $list.='<div class="pitem">
                                <div class="id none">' . $row['pid'] . '</div>
                                    <input type="hidden" id="uuid" value="' . $row['userid'] . '"/>
                                <div class="zoomimg col s12 m4 right"><img class="responsive-img" src="' . URL . 'images/gallery/' . $imgpath . $img2 . '"></div>
                                <div class="cnt col s12 m8 right">';
                        if (mb_strlen($row['pn']) != 0) {
                            $list.='<h3 class="tl hd">نام تصویر : <span>' . htmlspecialchars($row['pn']) . '</span></h3>';
                        }
                        $list.=' <h3 class="sbj hd">نام مسابقه : <a href="' . URL . 'comp/id/' . $row['compid'] . '"><span>' . htmlspecialchars($row['cname']) . '</span></a></h3>
                                    <img class="av" src="' . $thmname . '">
                                    <a href="' . URL . 'blog/id/' . $row['userid'] . '"><div class="us" id="us' . $row['userid'] . '">' . $username . '</div></a> <div class="dt">';
                        if (mb_strlen($row['pdate']) != 0) {
                            $list.='<i class="mdi-image-filter-5 lgico grey-text "></i><span>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['pdate'])) . '</span>';
                        }
                        $list.=' </div><div class="cmt right-align">' . str_replace(PHP_EOL, '<br>', htmlspecialchars($row['comment'])) . '</div>
                                    <div class="adr none"></div>
                                </div>';
                        switch ($a) {
                            case 1: {
                                    $list.='<div class="confirm none">1</div>
                                        <div class="btnsdiv col s12">
                                    <a class="delcmt bwaves-effect waves-white pink darken-4 right btn mgright"><i class="mdi-action-delete right"></i>عدم تایید</a>
                                </div>
                            </div>';
                                    break;
                                }
                            case 2: {
                                    $list.='<div class="confirm none">0</div>
                                        <div class="btnsdiv col s12">
                                    <a class="okcmt bwaves-effect waves-white right btn"><i class="mdi-action-done right"></i>تایید</a>
                                    <a class="delcmt bwaves-effect waves-white pink darken-4 right btn mgright"><i class="mdi-action-delete right"></i>عدم تایید</a>
                                </div>
                            </div>';
                                    break;
                                }
                            case 3: {
                                    $list.='<div class="confirm none">3</div>
                                        <div class="btnsdiv col s12">
                                    <a class="okcmt bwaves-effect waves-white right btn"><i class="mdi-action-done right"></i>تایید</a>
                                </div>
                            </div>';
                                    break;
                                }
                            case 4: {
                                    $list.='<div class="confirm none">4</div>
                                        <div class="btnsdiv col s12">
                                    <a class="okcmt bwaves-effect waves-white right btn"><i class="mdi-action-done right"></i>تایید</a>
                                </div>
                            </div>';
                                    break;
                                }
                        }
                    }
                }
                $data = array('msg' => $list);
                $data = json_encode($data);
                $this->view->render('adminphoto/index', $data, false, 0);
            }$this->data['[VARIMAGECOUNT]'] = $numofpage;
        }
    }

    public function dltphoto() {
        $fields = array('id', 'whydeny');
        if (Checkform::checkset($_POST, $fields)) {
            if (Checkform::checknotempty($_POST, $fields)) {
                //minus score
                $resuid = $this->model->getuid('id=:pid', array('pid' => $_POST['id']));
                if ($resuid) {
                    $rowuid = $resuid->fetch();
                    $uid = $rowuid['userid'];
                    $this->minesscore($uid);
                }
                if ($_POST['whydeny'] == 2) {
                    $this->moveimg($_POST['id'], '2comp');
                }
                if ($_POST['whydeny'] == 3) {
                    $this->moveimg($_POST['id'], '2site');
                }
                $cond = 'id=:id';
                $condata = array('id' => $_POST['id']);
                $updata = array('confirm' => $_POST['whydeny']);
                $this->model->rejectphoto($updata, $cond, $condata);
            }
        }
    }

    public function confirmphoto() {
        if (isset($_POST['pconf'])) {
            $resuid = $this->model->getuid('id=:pid', array('pid' => $_POST['pid']));
            if ($resuid) {
                $rowuid = $resuid->fetch();
                $uid = $rowuid['userid'];
                $this->setscore($uid, 1);
            }
            if ($_POST['pconf'] == 4) {
                $this->comeback($_POST['pid'], '2comp');
            } elseif ($_POST['pconf'] == 3) {
                $this->comeback($_POST['pid'], '2site');
            }

            $cond = 'id=:id';
            $condtat = array('id' => $_POST['pid']);
            $updata = array('confirm' => 1);
            $this->model->confirmphoto($updata, $cond, $condtat);
        }
    }

    public function moveimg($imgid, $fld) {
        $imgs = Utilities::imgname('thumb', $imgid) . '.jpg';
        $imgd = Utilities::imgname($fld, $imgid) . '.jpg';
        $source = $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . "/images/gallery/thumb/" . $imgs;
        $dest = $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . '/images/gallery/norelate/' . $fld . '/' . $imgd;
        copy($source, $dest);
        $imgadd = glob($source);
        unlink($imgadd[0]);
    }

    public function comeback($imgid, $fld) {
        $imgd = Utilities::imgname('thumb', $imgid) . '.jpg';
        $imgs = Utilities::imgname($fld, $imgid) . '.jpg';
        $dest = $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . "/images/gallery/thumb/" . $imgd;
        $source = $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . '/images/gallery/norelate/' . $fld . '/' . $imgs;
        copy($source, $dest);
        $imgadd = glob($source);
        unlink($imgadd[0]);
    }

    public function delrate() {
        $fields = array('id', 'status', 'type');
        if (Checkform::checkset($_POST, $fields)) {
            if (Checkform::checknotempty($_POST, $fields)) {
                $this->model->delwinner($_POST['id'], $_POST['status'], $_POST['type']);
            }
        }
    }

    public function saverate() {
        $fields = array('comment', 'jayeze', 'winuser', 'id', 'wintype');
        if (Checkform::checkset($_POST, $fields)) {
            if (Checkform::checknotempty($_POST, $fields)) {
                $data = array();
                $data['cmnt'] = $_POST['comment'];
                if (isset($_POST['grade'])) {
                    $data['rate'] = $_POST['grade'];
                }
                $data['price'] = $_POST['jayeze'];
                $data['uid'] = $_POST['winuser'];
                $data['imgid'] = $_POST['id'];
                $data['wintype'] = $_POST['wintype'];
                switch ($data['wintype']) {
                    case 0:
                    case 1:
                        $data['cmpid'] = Session::get('dvid');
                        break;
                    case 2:
                        $data['cmpid'] = Session::get('poid');
                        break;
                }
                $this->model->savewinner($data, $_POST['winstatus']);
                $data = array('id' => '1', 'msg' => 'اطلاعات با موفقیت ثبت شد.');
                $data = json_encode($data);
                $this->view->render('adminphoto/index', $data, false, 0);
            } else {
                //all field requier
                $data = array('id' => '0', 'msg' => 'لطفا تمام فیلدها را پر کنید.');
                $data = json_encode($data);
                $this->view->render('adminphoto/index', $data, false, 0);
            }
        } else {
            //all field requier
            $data = array('id' => '0', 'msg' => 'لطفا تمام فیلدها را پر کنید.');
            $data = json_encode($data);
            $this->view->render('adminphoto/index', $data, false, 0);
        }
    }

    public function createlist($res) {
        $list1 = '';
        $refr = 0;
        $lastid = 0;
        while ($row = $res->fetch()) {
            $img = Utilities::imgname('thumb', $row['pid']) . '.jpg';
            if ($row['isavatar'] == 1) {
                $av = Utilities::imgname('avatar', $row['userid']) . '.jpg';
            } else {
                $av = Utilities::imgname('avatar', 'default') . '.jpg';
            }
            if ($row['uname'] != '' && $row['uf'] != '') {
                $username = htmlspecialchars($row['uname']) . '  ' . htmlspecialchars($row['uf']);
            } else {
                $username = htmlspecialchars($row['username']);
            }
            $list1.=' <div class="pitem">
                      <div class="id none">cd' . $row['pid'] . '</div>
                      <div class="iswin none">' . $row['iswin'] . '</div>
                      <div class="zoomimg col s12 m4 right">
                          <img class="responsive-img" src="' . URL . 'images/gallery/thumb/' . $img . '">
                      </div>
                      <div class="cnt col s12 m8 right">';
            if (mb_strlen($row['pn']) != 0) {
                $list1.='<h3 class="tl hd">نام تصویر : <span>' . htmlspecialchars($row['pn']) . '</span></h3>';
            }
            $list1.=' <img class="av" src="' . URL . 'images/avatar/' . $av . '">
                          <a href="' . URL . 'blog/id/' . $row['userid'] . '"><div class="us" id="us' . $row['userid'] . '">' . $username . '</div></a> <div class="dt">';
            if (mb_strlen($row['pdate']) != 0) {
                $list1.='<i class="mdi-image-filter-5 lgico grey-text "></i><span>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['pdate'])) . '</span>';
            }
            $list1.=' </div><div class="cmt right-align">' . str_replace(PHP_EOL, '<br>', htmlspecialchars($row['comment'])) . '</div>
                          <div class="dvrate right-align"><i class="mdi-image-filter-5 lgico grey-text "></i><span>' . $row['refrate'] . '</span></div>
                          <div class="adr none"></div>
                 
                      <div class="btnsdiv col s12">';
            switch ($row['iswin']) {
                case 0:
                case 3:
                    $list1.='<a class="winbtn bwaves-effect waves-white right btn"><i class="mdi-action-done right"></i>برنده داوری</a>
                         <a class="monbtn bwaves-effect waves-white purple darken-3 right btn mgright"><i class="mdi-action-done-all right"></i>منتخب داوری</a>';
                    break;
                case 1:
                case 4:
                    $list1.='<a class="winbtn2 bwaves-effect waves-white right btn"><i class="mdi-action-done right"></i>انصراف از اعلام بعنوان برنده</a>
                         <a class="monbtn bwaves-effect waves-white purple darken-3 right btn mgright none"><i class="mdi-action-done-all right"></i>منتخب داوری</a>';
                    break;
                case 2:
                case 5:
                    $list1.='<a class="winbtn bwaves-effect waves-white right btn none"><i class="mdi-action-done right"></i>برنده داوری</a>
                        <a class="monbtn2 bwaves-effect waves-white purple darken-3 right btn mgright"><i class="mdi-action-done-all right"></i>انصراف از اعلام بعنوان منتخب</a>';
                    break;
            }
            $list1.='</div> </div></div>';
            $refr = $row['refrate'];
            $lastid = $row['pid'];
        }
        return array($list1, $refr, $lastid);
    }

    public function loadseldav($selcomp = NULL) {
        $list = '<option>بدون مسابقه</option>';
        $cond = 'isopen=2 AND enddate<' . (time() - 48 * 3600);
        $res = $this->model->loadcomps($cond);
        if ($res) {
            $list = '';
            $i = 0;
            $dvno = 0;
            if (Session::get('dvid') || $selcomp) {
                if ($selcomp == NULL) {
                    $selcomp = Session::get('dvid');
                }
                while ($row = $res->fetch()) {
                    $list .= '<option value="' . $row['id'] . '"';
                    if (strcmp($row['id'], $selcomp) == 0) {
                        Session::set('dvid', $row['id']);
                        Session::set('dvcomp', htmlspecialchars($row['name']));
                        $dvno = $row['davarino'];
                        $list .= ' selected ';
                    }
                    $list .= ' >' . htmlspecialchars($row['name']) . '</option>';
                }
            } else {
                while ($row = $res->fetch()) {
                    $list .= '<option value="' . $row['id'] . '"';
                    if ($i == 0) {
                        Session::set('dvid', $row['id']);
                        Session::set('dvcomp', htmlspecialchars($row['name']));
                        $dvno = $row['davarino'];
                        $i = 1;
                    }
                    $list .= ' >' . htmlspecialchars($row['name']) . '</option>';
                }
            }
            $this->loaddavari($list, $dvno);
        } else {
            $this->view->render('adminphoto/index', json_encode(array('list1' => '', 'comps' => $list, 'pos' => 'loadseldav')), false, 0);
        }
    }

    public function loaddavari($comps, $dvno) {
        $list1 = '';
        $lastrate = 0;
        $lastid = 0;
        $cond = 'cmpid=:cid order by refrate desc limit 0,:dvno';
        $coda = array('cid' => Session::get('dvid'), 'dvno' => $dvno);
        $res = $this->model->loaddavari($cond, $coda);
        if ($res) {
            $temp = $this->createlist($res);
            $list1 .= $temp[0];
            $lastrate = $temp[1];
            $lastid = $temp[2];
            if ($lastrate > 0) {
                $cond = 'cmpid=:cid AND refrate=:lr AND pid!=:lstid';
                $coda = array('cid' => Session::get('dvid'), 'lr' => $lastrate, 'lstid' => $lastid);
                $res0 = $this->model->loaddavari($cond, $coda);
                if ($res0) {
                    $temp0 = $this->createlist($res0);
                    $list1 .= $temp0[0];
                }
            }
        }
        $this->view->render('adminphoto/index', json_encode(array('list1' => $list1, 'comps' => $comps, 'pos' => 'loaddavari')), false, 0);
    }

    public function loadselpeople($selcomp = NULL) {
        $list = '<option>بدون مسابقه</option>';
        $cond = 'peopelwinno!=0 AND isopen=2 AND enddate<' . (time() - 48 * 3600);
        $res = $this->model->loadcomps($cond);
        if ($res) {
            $list = '';
            $i = 0;
            $pono = 0;
            if (Session::get('poid') || $selcomp) {
                if ($selcomp == NULL) {
                    $selcomp = Session::get('poid');
                }
                while ($row = $res->fetch()) {
                    $list .= '<option value="' . $row['id'] . '"';
                    if (strcmp($row['id'], $selcomp) == 0) {
                        Session::set('poid', $row['id']);
                        Session::set('pocomp', htmlspecialchars($row['name']));
                        $pono = $row['peopelwinno'] * 3;
                        $list .= ' selected ';
                    }
                    $list .= ' >' . htmlspecialchars($row['name']) . '</option>';
                }
            } else {
                while ($row = $res->fetch()) {
                    $list .= '<option value="' . $row['id'] . '"';
                    if ($i == 0) {
                        Session::set('poid', $row['id']);
                        Session::set('pocomp', htmlspecialchars($row['name']));
                        $pono = $row['peopelwinno'] * 3;
                        $i = 1;
                    }
                    $list .= ' >' . htmlspecialchars($row['name']) . '</option>';
                }
            }
            $this->loadpeople($list, $pono);
        } else {
            $this->view->render('adminphoto/index', json_encode(array('list2' => '', 'comps' => $list)), false, 0);
        }
    }

    public function loadpeople($comps, $pono) {
        $pids = array();
        $liksums = array();
        $likcount = array();
        $list2 = '';
        $lik = 0;
        $lastid = 0;
        $cond = 'pid IN (select pid  from viw_photwin where cmpid=:cid)group by pid order by liksum DESC Limit :pono';
        $coda = array('cid' => Session::get('poid'), 'pono' => $pono);
        $res = $this->model->loadpowins('pid,sum(rate) as liksum,count(pid) as co', $cond, $coda); //$row['pid']//$row['liksum']
        if ($res) {
            while ($row = $res->fetch()) {
                $l = $row['pid'] . '*' . $row['liksum'] . '*' . $row['co'] . '<br>';
                array_push($pids, $row['pid']);
                array_push($liksums, $row['liksum']);
                array_push($likcount, $row['co']);
            }
            $resinfo = $this->model->loadpowinsinfo($pids, 'pid');
            if ($resinfo) {
                $temp = $this->createpolist($resinfo);
                $list2.=$temp[0];
                $lik = $temp[1];
                $lastid = $temp[2];
            }
        }
        $this->view->render('adminphoto/index', json_encode(array('list2' => $list2, 'comps' => $comps, 'position' => '1')), false, 0);
    }

    public function createpolist($res) {
        $list2 = '';
        $lik = 0;
        $lastid = 0;
        while ($row = $res->fetch()) {
            $img = Utilities::imgname('thumb', $row['pid']) . '.jpg';
            if ($row['isavatar'] == 1) {
                $av = Utilities::imgname('avatar', $row['userid']) . '.jpg';
            } else {
                $av = Utilities::imgname('avatar', 'default') . '.jpg';
            }//here

            if ($row['uname'] != '' && $row['uf'] != '') {
                $username = htmlspecialchars($row['uname']) . '  ' . htmlspecialchars($row['uf']);
            } else {
                $username = htmlspecialchars($row['username']);
            }
            $list2.=' <div class="pitem">
                                <div class="id none">cp' . $row['pid'] . '</div>
                                <div class="poiswin none">' . $row['iswin'] . '</div>
                                <div class="zoomimg col s12 m4 right">
                                    <img class="responsive-img" src="' . URL . 'images/gallery/thumb/' . $img . '">
                                </div>
                                <div class="cnt col s12 m8 right">';
            if (mb_strlen($row['pn']) != 0) {
                $list2.='<h3 class="tl hd">نام تصویر : <span>' . htmlspecialchars($row['pn']) . '</span></h3>';
            }
            $list2.=' <img class="av" src="' . URL . 'images/avatar/' . $av . '">
                                    <a href="' . URL . 'blog/id/' . $row['userid'] . '"><div class="us" id="us' . $row['userid'] . '">' . $username . '</div></a> <div class="dt">';
            if (mb_strlen($row['pdate']) != 0) {
                $list2.='<i class="mdi-image-filter-5 lgico grey-text "></i><span>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['pdate'])) . '</span>';
            }
            $list2.=' </div><div class="cmt right-align">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '</div>
                                    <div class="porate right-align"><i class="mdi-image-filter-5 lgico grey-text "></i><span>' . $row['imglike'] . '</span></div>
                                    <div class="adr none"></div>
                             
                                <div class="btnsdiv col s12">';
            switch ($row['iswin']) {
                case 0:
                case 1:
                case 2:
                    $list2.= '<a class="winbtn bwaves-effect waves-white right btn"><i class="mdi-action-done right"></i>برنده مردمی</a>';
                    break;
                case 3:
                case 4:
                case 5:
                    $list2.= '<a class="winbtn2 bwaves-effect waves-white right btn"><i class="mdi-action-done right"></i>انصراف از اعلام بعنوان برنده مردمی</a>';
                    break;
            }
            $list2.='</div></div></div>';
            $lik = $row['imglike'];
            $lastid = $row['pid'];
        }
        return array($list2, $lik, $lastid);
    }

    public function fordown() {
        $forzip = array();
        $i = 0;
        if (isset($_POST['selax'])) {
            $axs = $_POST['selax'];
            foreach ($axs as $ax) {
                $forzip[$i] = Utilities::imgname('origsize', $ax) . '.jpg';
                $i++;
            }
            $destname = 'zip/' . Utilities::imgname('zip', time()) . '.zip';
            Session::set('haszip', 'yes');
            $res = Createzip::Zip('images/gallery/origsize', $destname, $forzip);
            if ($res) {
                $this->view->render('adminphoto/index', json_encode(array('id' => 1, 'add' => URL . $destname)), false, 0);
            } else {
                $this->view->render('adminphoto/index', json_encode(array('id' => 0, 'add' => 'دانلود ناموفق')), false, 0);
            }
        }
    }

}
