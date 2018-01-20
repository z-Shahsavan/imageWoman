<?php

class bazbin extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::must_access('isuser', 'index#loginlink', 3);
    }

    const TOP = 20;

    public function index($selcomp = 0) {
        //assign photos to bazbin for publish
        $field = 'compid';
        $cond = '(confirm=0 OR isopen=1) AND bazid=0 group BY (compid)';
        $rows = $this->model->photos('viw_compphot', $field, $cond);
        if ($rows) {
            while ($row = $rows->fetch()) {
                $this->assignforpublish($row['compid']);
            }
        }

        if ($selcomp) {
            $this->loadpubselcomps($selcomp);
        } else {
            //show comps who isopen=1 or thire pictures who confirm=0
            $this->loadpubcomps();
        }

        $this->loadforpublishtab(0); //1
        //for each comp if isopen=2 and no photo with confirm=0, assign photos to bazbin for bazbini
        $cond0 = 'isopen=2 AND publishend=0';
        $res0 = $this->model->photos('viw_compphot', 'compid,confirm', $cond0);
        if ($res0) {
            $lastcmp = 0;
            while ($row0 = $res0->fetch()) {
                if ($row0['confirm'] == 0 || $lastcmp == $row0['compid']) {
                    $lastcmp = $row0['compid'];
                    continue;
                }
                $lastcmp = $row0['compid'];
                $this->model->setbaz20($row0['compid']);
                $this->model->setpublishend($row0['compid']); //set publishend=1
                $this->assignforbazbini($row0['compid']);
            }
        }
        $this->view->render('bazbin/index', $this->data);
    }

//find & send new images to client     
    public function findnew() {
        $cond = '(confirm=0 AND isopen=1 AND bazid=0) group BY (compid)';
        $rows = $this->model->photos('viw_compphot', 'compid', $cond);
        if ($rows) {
            while ($row = $rows->fetch()) {
                $this->assignforpublish($row['compid']);
            }
        }
        $list = $this->loadforpublishtab(0);
        $this->view->render('bazbin/index', $list, FALSE, 0);
    }

//for Publish part
    public function loadpubselcomps($selcomp) {
        $list = '<option option value="0">بدون عکس</option>';
        $res = $this->model->loadcomps('viw_compphot', 'confirm=0 AND bazid=:bazid group by compid', array('bazid' => Session::get('userid')));
        if ($res) {
            $list = '';
            while ($row = $res->fetch()) {
                $list .= '<option value="' . $row['compid'] . '"';
                if ($row['compid'] == $selcomp) {
                    $list .='selected';
                    Session::set('currpub', $row['compid']);
                    Session::set('currcomp', htmlspecialchars($row['name']));
                }
                $list .= ' >' . htmlspecialchars($row['name']) . '</option>';
            }
        }
        $this->data['[VARPUBCOMPS]'] = $list;
    }

    public function loadpubcomps() {
        $list = '<option value="0">بدون عکس</option>';

        $res = $this->model->loadcomps('viw_compphot', '(isopen=1 OR confirm=0) AND bazid=:bazid group by compid', array('bazid' => Session::get('userid')));
        $i = 0;
        if ($res) {
            $list = '';
            while ($row = $res->fetch()) {
                if ($i == 0) {
                    Session::set('currpub', $row['compid']);
                    Session::set('currcomp', htmlspecialchars($row['name']));
                }
                $i++;
                $list .= '<option value="' . $row['compid'] . '">' . htmlspecialchars($row['name']) . '</option>';
            }
        }
        $this->data['[VARPUBCOMPS]'] = $list;
    }

    public function moveimg($imgid, $fld) {
        $imgs = Utilities::imgname('thumb', $imgid) . '.jpg';
        $imgd = Utilities::imgname($fld, $imgid) . '.jpg';
        $source = $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . "/images/gallery/thumb/" . $imgs;
        $dest = $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . '/images/gallery/norelate/' . $fld . '/' . $imgd;
        copy($source, $dest); //?
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

    public function publish() {
        // $fields = array('whydeny');
        if (isset($_POST['score']) && $_POST['score'] != 0) {
            if ($_POST['score'] > 0) {
                //add score
                $resuid = $this->model->getuid('id=:pid', array('pid' => $_POST['id']));
                if ($resuid) {
                    $rowuid = $resuid->fetch();
                    $uid = $rowuid['userid'];
                    $this->setscore($uid, 1);
                }
            } elseif ($_POST['score'] < 0) {
                //minus score
                $resuid = $this->model->getuid('id=:pid', array('pid' => $_POST['id']));
                if ($resuid) {
                    $rowuid = $resuid->fetch();
                    $uid = $rowuid['userid'];
                    $this->minesscore($uid);
                }
            }
        }
        // if (Checkform::checkset($_POST, $fields)) {
        //  if (Checkform::checknotempty($_POST, $fields)) {
        if (isset($_POST['whydeny']) && $_POST['whydeny'] == 2) {
            $this->moveimg($_POST['id'], '2comp');
            $updata = array('confirm' => $_POST['whydeny']);
            $condata = array('id' => $_POST['id']);
            $cond = 'id=:id';
            $this->model->publish($updata, $cond, $condata);
            return;
        } elseif (isset($_POST['whydeny']) && $_POST['whydeny'] == 3) {
            $this->moveimg($_POST['id'], '2site');
            $updata = array('confirm' => $_POST['whydeny']);
            $condata = array('id' => $_POST['id']);
            $cond = 'id=:id';
            $this->model->publish($updata, $cond, $condata);
            return;
        } elseif (isset($_POST['norelate']) && $_POST['norelate'] == 2) {
            $this->comeback($_POST['id'], '2comp');
        } elseif (isset($_POST['norelate']) && $_POST['norelate'] == 3) {
            $this->comeback($_POST['id'], '2site');
        }
        // }
        //  }
        $updata = array('confirm' => $_POST['up']);
        $condata = array('id' => $_POST['id']);
        $cond = 'id=:id';
        $this->model->publish($updata, $cond, $condata);
    }

    public function loadforpublishtab($confirm, $fromajax = NULL) {//$confirm=0:all  =1:published  =2:archive
        Session::set('confirm', $confirm);
        Session::set('fromajax', $fromajax);
        $lmt = 1; //!!!!laod image from related folder
        if ($confirm == 2) {
            $cond = 'compid=:compid AND bazid=:bazid AND (confirm=2 OR confirm=3) ORDER BY id DESC';
            $condata = array('compid' => Session::get('currpub'), 'bazid' => Session::get('userid'));
        } else {
            $cond = 'compid=:compid AND confirm=:confirm AND bazid=:bazid ORDER BY id DESC';
            $condata = array('compid' => Session::get('currpub'), 'bazid' => Session::get('userid'), 'confirm' => $confirm);
        }
        Session::set('cond', $cond);
        Session::set('condata', $condata);
        $rows = $this->model->photpub($cond, $condata);
        if ($rows) {
            $list = '';
            $i = 0;
            while ($row = $rows->fetch()) {
                if ($i < self::TOP) {
                    $i++;

                    if ($row['isavatar'] == 1) {
                        $av = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                    } else {
                        $av = Utilities::imgname('avatar', 'default') . '.jpg';
                    }
                    $img = '';
                    if ($row['confirm'] == 0 || $row['confirm'] == 1) {
                        $img = Utilities::imgname('thumb', $row['id']) . '.jpg';
                        $img = 'images/gallery/thumb/' . $img;
                        if ($row['confirm'] == 0) {
                            $btn = '<a class="btn-enteshar btn right okcmt"><i class="glyphicon glyphicon-ok marginleft15 right"></i>انتشار</a>
                        <a class="delcmt btn-noenteshar right btn mgright"><i class="glyphicon glyphicon-trash marginleft15 right"></i>عدم انتشار</a>';
                        } else if ($confirm == 1) {
                            $btn = '<a class="btn-enteshar right btn okcmt"><i class="glyphicon glyphicon-repeat marginleft15 right"></i>بازنگری</a>
                        <a class="delcmt btn-noenteshar right btn mgright"><i class="glyphicon glyphicon-trash marginleft15 right"></i>عدم انتشار</a>';
                        }
                    } else if ($row['confirm'] == 2 || $row['confirm'] == 3) {
                        if ($row['confirm'] == 2) {
                            $img = Utilities::imgname('2comp', $row['id']) . '.jpg';
                            $img = 'images/gallery/norelate/2comp/' . $img;
                        }
                        if ($row['confirm'] == 3) {
                            $img = Utilities::imgname('2site', $row['id']) . '.jpg';
                            $img = 'images/gallery/norelate/2site/' . $img;
                        }
                        $btn = '<a class="overview btn-enteshar right btn mgright"><i class="glyphicon glyphicon-repeat marginleft15 right"></i>بازنگری</a>';
                    }
                    if ($row['name'] != '' && $row['family'] != '') {
                        $namefam = htmlspecialchars($row['name']) . '  ' . htmlspecialchars($row['family']);
                    } else {
                        $namefam = $row['username'];
                    }

                    $list.='<div class="pitem">
                                <div class="id none">' . $row['id'] . '</div>
                                <div class="zoomimg col-xs-12 col-md-4 right"><img class="responsive-img" src="' . URL . $img . '"></div>
                                <div class="cnt col-xs-12 col-md-8 right">';
                    if (mb_strlen($row['photonam']) != 0) {
                        $list.='<h3 class="tl hd">نام تصویر : <span>' . htmlspecialchars($row['photonam']) . '</span></h3>';
                    }
                    $list.='<h3 class="sbj hd">نام مسابقه : <span>' . Session::get('currcomp') . '</span></h3>
                                    <img class="av" src="' . URL . 'images/avatar/' . $av . '">
                                    <div class="us">' . $namefam . '</div>';
                    if (mb_strlen($row['date']) != 0) {
                        $list.='<div class="dt "><span>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['date'])) . '</span><i class="glyphicon glyphicon-calendar right"></i></div>';
                    }
                    $list.='<div class="cmt right-align">' . str_replace(PHP_EOL, '<br>', htmlspecialchars($row['comment'])) . '</div>
                                    <div class="cmt right-align"></div>
                                    <div class="adr none">' . $img . '?' . $i . '</div>
                                    <div class="none" id="confirm">' . $row['confirm'] . '</div>
                                </div>
                                <div class="btnsdiv col-xs-12">';
                    $list.=$btn;
                    $list.='</div></div>';
                }
            }if ($fromajax) {
                $this->view->render('bazbin/index', $list, FALSE, 0);
            } else {
                $this->data['[VARPHOTPUB]'] = $list;
            }
            return $list;
        }
    }

    public function pagingforpublishtab() {
        if (isset($_POST['pid'])) {
            $lmt = self::TOP * ($_POST['pid'] - 1);
            $confirm = Session::get('confirm');
            $cond = Session::get('cond');
//            $cond .= ' Limit ' . $lmt . ',' . self::TOP;
            $condata = Session::get('condata');
            $rowsha = $this->model->photpub($cond, $condata);
            if ($rowsha != FALSE) {
                $cnt = $rowsha->rowCount();
                if ($cnt <= self::TOP) {
                    $noapp = 1;
                } else {
                    $cond .= ' Limit ' . $lmt . ',' . self::TOP;
                    $noapp = 0;
                }
            }
            $rows = $this->model->photpub($cond, $condata);
            if ($rows) {
                $list = '';
                $i = 0;
                while ($row = $rows->fetch()) {
                    if ($i < self::TOP) {
                        $i++;
                        if ($row['isavatar'] == 1) {
                            $av = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                        } else {
                            $av = Utilities::imgname('avatar', 'default') . '.jpg';
                        }
                        $img = '';
                        if ($row['confirm'] == 0 || $row['confirm'] == 1) {
                            $img = Utilities::imgname('thumb', $row['id']) . '.jpg';
                            $img = 'images/gallery/thumb/' . $img;
                            if ($row['confirm'] == 0) {
                                $btn = '<a class="btn-enteshar btn right okcmt"><i class="glyphicon glyphicon-ok marginleft15 right"></i>انتشار</a>
                        <a class="delcmt btn-noenteshar right btn mgright"><i class="glyphicon glyphicon-trash marginleft15 right"></i>عدم انتشار</a>';
                            } else if ($confirm == 1) {
                                $btn = '<a class="btn-enteshar right btn okcmt"><i class="glyphicon glyphicon-repeat marginleft15 right"></i>بازنگری</a>
                        <a class="delcmt btn-noenteshar right btn mgright"><i class="glyphicon glyphicon-trash marginleft15 right"></i>عدم انتشار</a>';
                            }
                        } else if ($row['confirm'] == 2 || $row['confirm'] == 3) {
                            if ($row['confirm'] == 2) {
                                $img = Utilities::imgname('2comp', $row['id']) . '.jpg';
                                $img = 'images/gallery/norelate/2comp/' . $img;
                            }
                            if ($row['confirm'] == 3) {
                                $img = Utilities::imgname('2site', $row['id']) . '.jpg';
                                $img = 'images/gallery/norelate/2site/' . $img;
                            }
                            $btn = '<a class="okcmt btn-enteshar btn right okcmt"><i class="glyphicon glyphicon-ok marginleft15 right"></i>انتشار</a>
                    <a class="overview btn-enteshar right btn mgright"><i class="glyphicon glyphicon-repeat marginleft15 right"></i>بازنگری</a>';
                        }
                        $list.='<div class="pitem">
                                <div class="id none">' . $row['id'] . '</div>
                                <div class="zoomimg col-xs-12 col-md-4 right"><img class="responsive-img" src="' . URL . $img . '"></div>
                                <div class="cnt col-xs-12 col-md-8 right">';
                        if (mb_strlen($row['photonam']) != 0) {
                            $list.='<h3 class="tl hd">نام تصویر : <span>' . htmlspecialchars($row['photonam']) . '</span></h3>';
                        }
                        $list.='<h3 class="sbj hd">نام مسابقه : <span>' . Session::get('currcomp') . '</span></h3>
                                    <img class="av" src="' . URL . 'images/avatar/' . $av . '">';
                        if (mb_strlen($row['name']) == 0 || mb_strlen($row['family']) == 0) {
                            $list.=' <div class="us">' . htmlspecialchars($row['username']) . '</div>';
                        } else {
                            $list.=' <div class="us">' . htmlspecialchars($row['name']) . '  ' . htmlspecialchars($row['family']) . '</div>';
                        }
                        if (mb_strlen($row['date']) != 0) {
                            $list.=' <div class="dt "><span>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['date'])) . '</span><i class="glyphicon glyphicon-calendar right"></i></div>';
                        }
                        $list.='<div class="cmt right-align">' . str_replace(PHP_EOL, '<br>', htmlspecialchars($row['comment'])) . '</div>
                                    <div class="cmt right-align"></div>
                                    <div class="adr none">' . $img . '?' . $i . '</div>
                                    <div class="none" id="confirm">' . $row['confirm'] . '</div>
                                </div>
                                <div class="btnsdiv col s12">';
                        $list.=$btn;
                        $list.='</div></div>';
                    }

//                    return $list;
                }
//                $this->view->render('bazbin/index', $list, FALSE, 0);
                $return = array('list' => $list, 'noapp' => $noapp);
                $return = json_encode($return);
                $this->view->render('bazbin/index', $return, false, 0);
            }
        }
    }

    public function assignforpublish($compid) {
        $field = 'id';
        $cond = '(confirm=0 AND compid=:compid AND bazid=0) ORDER BY (id) ASC';
        $rows0 = $this->model->photos('tbl_photos', $field, $cond, array('compid' => $compid));
        if (!$rows0) {
            return;
        }
        $arr = array(); //عکسایی که بازبین ندارند
        $row0 = '';
        while ($row0 = $rows0->fetch()) {
            array_push($arr, $row0['id']);
        }
        $arrsize = sizeof($arr);
        $x = $arrsize; //تعداد عکسایی که بازبین ندارند
        $cond1 = 'bazid!=0 AND confirm=0 AND compid=:compid GROUP BY (bazid) ORDER BY num DESC, bazid DESC';
        $field1 = 'bazid,count(bazid) as num';
        $rows1 = $this->model->photos('tbl_photos', $field1, $cond1, array('compid' => $compid));
        $photobaz = array();
        $num = array();
        if ($rows1) {
            while ($row1 = $rows1->fetch()) {
                array_push($num, $row1['num']); //تعداد عکس هر بازبین
                array_push($photobaz, $row1['bazid']); //بازبین هایی که عکس دارند
            }
        }

        if ($x) {
            $y = 0;
            $cond2 = 'compid=:compid ORDER BY bid DESC';
            $rows2 = $this->model->bazs($cond2, array('compid' => $compid));
            if (!$rows2) {
                return;
            }
            $y = $rows2->rowCount();
            $bazs = array(); //آرایه بازبین ها
            if ($rows2) {
                while ($row2 = $rows2->fetch()) {
                    array_push($bazs, $row2['bid']);
                }
                if (sizeof($photobaz) != sizeof($bazs)) {
                    $temp = array();
                    foreach ($bazs as $value) {
                        if (!in_array($value, $photobaz)) {
                            array_push($temp, $value);
                        }
                    }
                    $photobaz = array_merge($photobaz, $temp);
                    for ($r = 0; $r < sizeof($temp); $r++) {
                        array_push($num, 0);
                    }
                }
                $t = floor($x / $y);
                $b = $x % $y;
                $counter = 0;
                $cond = 'bazid=(CASE';
                $conddata = array();
                $no = 0;
                $minidx = 0;
                $k = 0;
                while ($x > $no) {
                    $min = min($num);
                    for ($g = 0; $g < count($num); $g++) {
                        if ($num[$g] == $min) {
                            $minidx = $g;
                            $k = $g;
                            break;
                        }
                    }
                    $cond.=' WHEN (id=:da' . $counter . ') THEN ';
                    $conddata['da' . $counter] = $arr[$no];
                    $counter++;
                    $cond.=':da' . $counter;
                    $conddata['da' . $counter] = $photobaz[$k];
                    $counter++;
                    $num[$minidx] ++;
                    $no++;
                }
                $cond.=' ELSE bazid END);';
                $this->model->assignphotos($cond, $conddata);
            }
        }
    }

//for Bazbini part
    public function countokphotos() {
        $cond = 'compid=:compid AND confirm=1 AND bazid=' . Session::get('userid');
        $res = $this->model->okphotos($_SESSION['isopenid'], $cond);
        if ($res) {
            return $res->rowCount();
        } else {
            return 0;
        }
    }

    public function calcimgdiv($dvno) {
        $cond = 'compid=:cid order by bid DESC';
        $res = $this->model->bazs($cond, array('cid' => Session::get('isopenid')));
        $bazno = 0;
        $idx = 0;
        if ($res) {
            while ($row = $res->fetch()) {
                if ($row['bid'] == Session::get('userid')) {
                    $idx = $bazno;
                }
                $bazno++;
            }
        }
        if ($bazno != 0) {
            $mod = $dvno % $bazno;
            if ($mod != 0 && $idx != 0) {
                if ($idx <= $mod) {
                    $divimg = floor($dvno / $bazno);
                    $divimg++;
                } else {
                    $divimg = floor($dvno / $bazno);
                }
            } else {
                $divimg = floor($dvno / $bazno);
            }
            Session::set('divimg', $divimg - ($this->countokphotos()));
        }
    }

    public function count() {
        $this->data['[VARUSEROKIMAGECOUNT]'] = '';
        $this->data['[VARSERPENIMAGECOUNT]'] = '';
        $cond = 'compid=:compid AND confirm=1 AND bazid=' . Session::get('userid');
        $res = $this->model->okphotos($_SESSION['isopenid'], $cond);
        if ($res) {
            $this->data['[VARUSEROKIMAGECOUNT]'] = ceil($res->rowCount() / self::TOP);
            Session::set('okphno', $res->rowCount());
        } else {
            $this->data['[VARUSEROKIMAGECOUNT]'] = '0';
        }
        $r = $this->model->notokphotos($_SESSION['isopenid'], $cond);
        if ($r) {
            $this->data['[VARSERPENIMAGECOUNT]'] = ceil($r->rowCount() / self::TOP);
        } else {
            $this->data['[VARSERPENIMAGECOUNT]'] = '0';
        }
        if (!Session::get('okphno')) {
            Session::set('okphno', 0);
        }
    }

    public function assignforbazbini($compid) {
        $field = 'id';
        $cond = '(confirm=1 AND compid=:compid AND bazid=0) ORDER BY (id) ASC';
        $rows0 = $this->model->photos('tbl_photos', $field, $cond, array('compid' => $compid));
        if (!$rows0) {
            return;
        }
        $arr = array(); //عکسایی که بازبین ندارند
        $row0 = '';
        while ($row0 = $rows0->fetch()) {
            array_push($arr, $row0['id']);
        }
        $arrsize = sizeof($arr);
        $x = $arrsize; //تعداد عکسایی که بازبین ندارند
        $cond1 = 'bazid!=0 AND confirm=1 AND compid=:compid GROUP BY (bazid) ORDER BY num DESC, bazid ASC';
        $field1 = 'bazid,count(bazid) as num';
        $rows1 = $this->model->photos('tbl_photos', $field1, $cond1, array('compid' => $compid));
        $photobaz = array();
        $num = array();
        if ($rows1) {
            while ($row1 = $rows1->fetch()) {
                array_push($num, $row1['num']); //تعداد عکس هر بازبین
                array_push($photobaz, $row1['bazid']); //بازبین هایی که عکس دارند
            }
        }

        if ($x) {
            $y = 0;
            $cond2 = 'compid=:compid ORDER BY bid ASC';
            $rows2 = $this->model->bazs($cond2, array('compid' => $compid));
            if (!$rows2) {
                return;
            }
            $y = $rows2->rowCount();
            $bazs = array(); //آرایه بازبین ها
            if ($rows2) {
                while ($row2 = $rows2->fetch()) {
                    array_push($bazs, $row2['bid']);
                }
                if (sizeof($photobaz) != sizeof($bazs)) {
                    $temp = array();
                    foreach ($bazs as $value) {
                        if (!in_array($value, $photobaz)) {
                            array_push($temp, $value);
                        }
                    }
                    $photobaz = array_merge($photobaz, $temp);
                    for ($r = 0; $r < sizeof($temp); $r++) {
                        array_push($num, 0);
                    }
                }
                $t = floor($x / $y);
                $b = $x % $y;
                $counter = 0;
                $cond = 'bazid=(CASE';
                $conddata = array();
                $no = 0;
                $minidx = 0;
                $k = 0;
                while ($x > $no) {
                    $min = min($num);
                    for ($g = 0; $g < count($num); $g++) {
                        if ($num[$g] == $min) {
                            $minidx = $g;
                            $k = $g;
                            break;
                        }
                    }
                    $cond.=' WHEN (id=:da' . $counter . ') THEN ';
                    $conddata['da' . $counter] = $arr[$no];
                    $counter++;
                    $cond.=':da' . $counter;
                    $conddata['da' . $counter] = $photobaz[$k];
                    $counter++;
                    $num[$minidx] ++;
                    $no++;
                }
                $cond.=' ELSE bazid END);';
                $this->model->assignphotos($cond, $conddata);
            }
        }
    }

    public function loadnos() {
        if (!isset($_SESSION['isopenid'])) {
            $comps = $this->loadcomps();
        } else {
            $comps = $this->loadselcomps($_SESSION['isopenid'], 1);
        }
        $list2 = '';
        $cond = 'compid=:compid AND confirm=1 AND bazid=' . Session::get('userid') . ' ORDER BY id DESC ';
        Session::set('condnos', $cond);
        $nos = $this->model->notokphotos($_SESSION['isopenid'], $cond);
        if (!$nos) {
            return;
        }
        $i = 0;
        while ($row2 = $nos->fetch()) {
            if ($i < self::TOP) {
                $i++;
                $img2 = Utilities::imgname('thumb', $row2['id']) . '.jpg';
                if ($row2['isavatar'] == 1) {
                    $av = Utilities::imgname('avatar', $row2['userid']) . '.jpg';
                } else {
                    $av = Utilities::imgname('avatar', 'default') . '.jpg';
                }
                $list2.='<div class="pitem" id="novo">
                            <div class="id none" id="no">no' . $row2['id'] . '</div>
                            <div class="zoomimg col-xs-12 col-md-4 right"><img class="responsive-img" src="' . URL . 'images/gallery/thumb/' . $img2 . '"></div>
                            <div class="cnt col-xs-12 col-md-8 right">';
                if (mb_strlen($row2['name']) != 0) {
                    $list2.='<h3 class="tl hd">نام تصویر : <span>' . htmlspecialchars($row2['name']) . '</span></h3>';
                }
                $list2.='<h3 class="sbj hd">نام مسابقه : <span>' . $_SESSION['comp'] . '</span></h3>
                                <img class="av" src="' . URL . 'images/avatar/' . $av . '">';
                if (mb_strlen($row2['un']) == 0 || mb_strlen($row2['uf']) == 0) {
                    $list2.=' <div class="us">' . htmlspecialchars($row2['username']) . ' </div>';
                } else {
                    $list2.=' <div class="us">' . htmlspecialchars($row2['un']) . '  ' . htmlspecialchars($row2['uf']) . '</div>';
                }

                if (mb_strlen($row2['date']) != 0) {
                    $list2.='<div class="dt "><span>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row2['date'])) . '</span><i class="glyphicon glyphicon-calendar right"></i></div>';
                }
                $list2.=' <div class="cmt right-align"> ' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row2['bbcom'])) . ' </div>
                                <div class="adr none">' . URL . 'images/gallery/thumb/' . $img2 . '</div>
                            </div>
                            <div class="btnsdiv col-xs-12">
                                <a class="okcmt btn-noenteshar right btn"><i class="glyphicon glyphicon-ok marginleft15 right"></i>تایید</a>
                                <a class="rejectbtn btn-enteshar right btn mgright"><i class="glyphicon glyphicon-repeat marginleft15 right"></i>بازنگری</a>
                            </div>
                        </div>';
            }
        }
        $this->view->render('bazbin/index', json_encode(array('list2' => $list2, 'comps' => $comps, 'divimg' => Session::get('divimg'))), false, 0);
    }

    public function pagingloadnos() {
        if (isset($_POST['pidnos'])) {
            $lmt = self::TOP * ($_POST['pidnos'] - 1);
            $cond = Session::get('condnos');
//            $cond .= ' Limit ' . $lmt . ',' . self::TOP;
            $nosha = $this->model->notokphotos($_SESSION['isopenid'], $cond);
            if ($nosha != FALSE) {
                $cnt = $nosha->rowCount();
                if ($cnt <= self::TOP) {
                    $noapp = 1;
                } else {
                    $cond .= ' Limit ' . ',' . self::TOP;
                    $noapp = 0;
                }
            }
            $nos = $this->model->notokphotos($_SESSION['isopenid'], $cond);
            if (!$nos) {
                return;
            }
            $i = 0;
            while ($row2 = $nos->fetch()) {
                if ($i < self::TOP) {
                    $i++;
                    $img2 = Utilities::imgname('thumb', $row2['id']) . '.jpg';
                    if ($row2['isavatar'] == 1) {
                        $av = Utilities::imgname('avatar', $row2['userid']) . '.jpg';
                    } else {
                        $av = Utilities::imgname('avatar', 'default') . '.jpg';
                    }
                    $list2.='<div class="pitem" id="novo">
                            <div class="id none" id="no">no' . $row2['id'] . '</div>
                            <div class="zoomimg col-xs-12 col-md-4 right"><img class="responsive-img" src="' . URL . 'images/gallery/thumb/' . $img2 . '"></div>
                            <div class="cnt col-xs-12 col-md-8 right">';
                    if (mb_strlen($row2['name']) != 0) {
                        $list2.='<h3 class="tl hd">نام تصویر : <span>' . htmlspecialchars($row2['name']) . '</span></h3>';
                    }
                    $list2.='<h3 class="sbj hd">نام مسابقه : <span>' . $_SESSION['comp'] . '</span></h3>
                                <img class="av" src="' . URL . 'images/avatar/' . $av . '">';
                    if (mb_strlen($row1['un']) == 0 || mb_strlen($row1['uf']) == 0) {
                        $list2.='  <div class="us">' . htmlspecialchars($row2['username']) . '</div>';
                    } else {
                        $list2.='  <div class="us">' . htmlspecialchars($row2['un']) . '  ' . htmlspecialchars($row2['uf']) . '</div>';
                    }

                    if (mb_strlen($row2['date']) != 0) {
                        $list2.=' <div class="dt "><span>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row2['date'])) . '</span><i class="glyphicon glyphicon-calendar right"></i></div>';
                    }
                    $list2.='<div class="cmt right-align"> ' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row2['bbcom'])) . ' </div>
                                <div class="adr none">1.jpg</div>
                            </div>
                            <div class="btnsdiv col-xs-12">
                                <a class="okcmt bwaves-effect waves-white right btn"><i class="mdi-action-done right"></i>تایید</a>
                                <a class="rejectbtn btn-enteshar right btn mgright"><i class="glyphicon glyphicon-repeat right"></i>بازنگری</a>
                            </div>
                        </div>';
                }
            }
//            $this->view->render('bazbin/index', $list2, FALSE, 0);
            $return = array('list' => $list2, 'noapp' => $noapp);
            $return = json_encode($return);
            $this->view->render('bazbin/index', $return, false, 0);
        }
    }

    public function loadoks() {
        if (!isset($_SESSION['isopenid'])) {
            $comps = $this->loadcomps();
        } else {
            $comps = $this->loadselcomps($_SESSION['isopenid'], 1);
        }
        $list1 = '';

        $cond = 'compid=:compid AND confirm=1 AND bazid=' . Session::get('userid') . ' ORDER BY id DESC ';
        Session::set('condaccept', $cond);
        $oks = $this->model->okphotos($_SESSION['isopenid'], $cond);
        if (!$oks) {
            return;
        }
        $i = 0;
        while ($row1 = $oks->fetch()) {
            if ($i < self::TOP) {
                $i++;
                $img1 = Utilities::imgname('thumb', $row1['id']) . '.jpg';
                if ($row1['isavatar'] == 1) {
                    $av = Utilities::imgname('avatar', $row1['userid']) . '.jpg';
                } else {
                    $av = Utilities::imgname('avatar', 'default') . '.jpg';
                }
                $list1.='<div class="pitem" id="okvo">
                            <div class="id none" id="ok">ok' . $row1['id'] . '</div>
                            <div class="zoomimg col-xs-12 col-md-4 right"><img class="responsive-img" src="' . URL . 'images/gallery/thumb/' . $img1 . '"></div>
                            <div class="cnt col-xs-12 col-md-8 right">';
                if (mb_strlen($row1['name']) != 0) {
                    $list1.='<h3 class="tl hd">نام تصویر : <span>' . htmlspecialchars($row1['name']) . '</span></h3>';
                }
                $list1.='<h3 class="sbj hd">نام مسابقه : <span>' . $_SESSION['comp'] . '</span></h3>
                                <img class="av" src="' . URL . 'images/avatar/' . $av . '">';
                if (mb_strlen($row1['un']) == 0 || mb_strlen($row1['uf']) == 0) {
                    $list1.='<div class="us">' . htmlspecialchars($row1['username']) . ' </div>';
                } else {
                    $list1.='<div class="us">' . htmlspecialchars($row1['un']) . '  ' . htmlspecialchars($row1['uf']) . ' </div>';
                }

                if (mb_strlen($row1['date']) != 0) {
                    $list1.='<div class="dt "><span>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row1['date'])) . '</span><i class="glyphicon glyphicon-calendar right"></i></div>';
                }
                $list1.='<div class="cmt right-align">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row1['bbcom'])) . '</div>
                                <div class="adr none">' . URL . 'images/gallery/thumb/' . $img1 . '</div>
                            </div>
                            <div class="btnsdiv col-xs-12">
                                <a class="delcmt btn-noenteshar right btn"><i class="glyphicon glyphicon-remove marginleft15 right"></i>عدم تایید</a>
                                <a class="rejectbtn btn-enteshar right btn mgright"><i class="glyphicon glyphicon-repeat marginleft15 right"></i>بازنگری</a>
                            </div>
                        </div>';
            }
        }
        $this->view->render('bazbin/index', json_encode(array('list1' => $list1, 'comps' => $comps, 'divimg' => Session::get('divimg'))), false, 0);
    }

    public function pagingloadoks() {
        if (isset($_POST['pidoks'])) {
            $lmt = self::TOP * ($_POST['pidoks'] - 1);
            $cond = Session::get('condaccept');
//            $cond .= ' Limit ' . $lmt . ','.self::TOP;
            $oks = $this->model->okphotos($_SESSION['isopenid'], $cond);
            if (!$oks) {
                return;
            }
            $cnt = $oks->rowCount();
            if ($cnt <= self::TOP) {
                $noapp = 1;
            } else {
                $cond .= ' Limit ' . $lmt . ',' . self::TOP;
                $noapp = 0;
            }
            $okks = $this->model->okphotos($_SESSION['isopenid'], $cond);
            if (!$okks) {
                return;
            }
            $list1 = '';
            $i = 0;
            while ($row1 = $okks->fetch()) {
                if ($i < self::TOP) {
                    $i++;
                    $img1 = Utilities::imgname('thumb', $row1['id']) . '.jpg';
                    if ($row1['isavatar'] == 1) {
                        $av = Utilities::imgname('avatar', $row1['userid']) . '.jpg';
                    } else {
                        $av = Utilities::imgname('avatar', 'default') . '.jpg';
                    }
                    $list1.='<div class="pitem" id="okvo">
                            <div class="id none" id="ok">ok' . $row1['id'] . '</div>
                            <div class="zoomimg col-xs-12 col-md-4 right"><img class="responsive-img" src="' . URL . 'images/gallery/thumb/' . $img1 . '"></div>
                            <div class="cnt col-xs-12 col-md-8 right">';
                    if (mb_strlen($row1['name']) != 0) {
                        $list1.='<h3 class="tl hd">نام تصویر : <span>' . htmlspecialchars($row1['name']) . '</span></h3>';
                    }
                    $list1.='<h3 class="tl hd">نام تصویر : <span>' . htmlspecialchars($row1['name']) . '</span></h3>
                                <h3 class="sbj hd">نام مسابقه : <span>' . $_SESSION['comp'] . '</span></h3>
                                <img class="av" src="' . URL . 'images/avatar/' . $av . '">';
                    if (mb_strlen($row1['un']) == 0 || mb_strlen($row1['uf']) == 0) {
                        $list1.='<div class="us">' . htmlspecialchars($row1['username']) . '  </div>';
                    } else {
                        $list1.='<div class="us">' . htmlspecialchars($row1['un']) . '  ' . htmlspecialchars($row1['uf']) . ' </div>';
                    }

                    if (mb_strlen($row1['date']) != 0) {
                        $list1.='<div class="dt "><span>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row1['date'])) . '</span><i class="glyphicon glyphicon-calendar right"></i></div>';
                    }
                    $list1.='<div class="cmt right-align">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row1['bbcom'])) . '</div>
                                <div class="adr none">1.jpg</div>
                            </div>
                            <div class="btnsdiv col-xs-12">
                                <a class="delcmt btn-noenteshar right btn"><i class="glyphicon glyphicon-remove marginleft15 right"></i>عدم تایید</a>
                                <a class="rejectbtn btn-enteshar right btn mgright"><i class="glyphicon glyphicon-repeat marginleft15 right"></i>بازنگری</a>
                            </div>
                        </div>';
                }
            }
//            $this->view->render('bazbin/index', $list1, FALSE, 0);
            $return = array('list' => $list1, 'noapp' => $noapp);
            $return = json_encode($return);
            $this->view->render('bazbin/index', $return, false, 0);
        }
    }

    public function loadcomps() {
        Session::set('isopenid', NULL); //?
        $list = '<option>بدون مسابقه</option>';
        $cond = 'isopen=2  AND enddate<' . time() . ' AND ' . (time() - 24 * 3600) . '<enddate order by bazid'; //AND bazid=:bid
        $res = $this->model->loadcomps('viw_compphot', $cond); //,array('bid' => Session::get('userid'))
        $i = 0;
        if ($res) {
            $lastcmp = 0;
            while ($row = $res->fetch()) {
                if ($row['confirm'] == 0 || $lastcmp == $row['compid']) {
                    $lastcmp = $row['compid'];
                    continue;
                }
                if ($row['bazid'] == Session::get('userid')) {
                    $lastcmp = $row['compid'];
                    if ($i == 0) {
                        $list = '';
                        Session::set('isopenid', $row['compid']);
                        Session::set('comp', htmlspecialchars($row['name']));
                        $this->calcimgdiv($row['davarino']);
                    }
                    $i++;
                    $list .= '<option value="' . $row['compid'] . '">' . htmlspecialchars($row['name']) . '</option>';
                }
            }
        }
        return $list;
    }

    public function loadselcomps($selcomp, $returnhere = 0) {//$returnhere==1 : return to php
        $list = '<option>بدون عکس</option>';
        $cond = 'isopen=2  AND enddate<' . time() . ' AND ' . (time() - 24 * 3600) . '<enddate order by bazid'; //AND bazid=:bid
        $res = $this->model->loadcomps('viw_compphot', $cond); //, array('bid' => Session::get('userid')));
        if ($res) {
            $lastcmp = 0;
            $list = '';
            while ($row = $res->fetch()) {
                if ($row['confirm'] == 0 || $lastcmp == $row['compid']) {
                    $lastcmp = $row['compid'];
                    continue;
                }
                if ($row['bazid'] == Session::get('userid')) {
                    $lastcmp = $row['compid'];
                    $list .= '<option value="' . $row['compid'] . '"';
                    if (strcmp($row['compid'], $selcomp) == 0) {
                        Session::set('isopenid', $row['compid']);
                        Session::set('comp', htmlspecialchars($row['name']));
                        $this->calcimgdiv($row['davarino']);
                        $list .= ' selected ';
                    }
                    $list .= ' >' . htmlspecialchars($row['name']) . '</option>';
                }
            }
        }
        if ($returnhere) {
            return $list;
        }
        $this->loadphotos($list);
    }

    public function loadphotos($list = NULL) {
        $comps = '';
        if ($list) {
            $comps = $list;echo $_SESSION['isopenid'];
        } else if (isset($_SESSION['isopenid'])) {
            $comps = $this->loadselcomps($_SESSION['isopenid'], 1);
        } else if (!isset($_SESSION['isopenid']) || isset($_POST['ajaxreq'])) {
            $comps = $this->loadcomps();
        }
        if (!isset($_SESSION['isopenid'])) {
            $this->view->render('bazbin/index', json_encode(array('list' => '', 'comps' => $comps, 'divimg' => Session::get('divimg'))), false, 0);
            return;
        }
        $this->data['[VARIMAGECOUNT]'] = '';

        $cond = 'compid=:compid AND confirm=1 AND bazid=' . Session::get('userid');
        $res = $this->model->notinbazrate($_SESSION['isopenid'], $cond);
        $notinbaz = '';
        if (!$res) {
            $this->view->render('bazbin/index', json_encode(array('list' => '', 'comps' => $comps, 'divimg' => Session::get('divimg'))), false, 0);
            $this->data['[VARIMAGECOUNT]'] = '0';
            return;
        }
        $cond = 'compid=:compid AND confirm=1 AND bazid=' . Session::get('userid') . ' ORDER BY id DESC';
        $rows = $this->model->notinbazrate($_SESSION['isopenid'], $cond);
        if (!$rows) {
            $this->view->render('bazbin/index', json_encode(array('list' => '', 'comps' => $comps, 'divimg' => Session::get('divimg'))), false, 0);
            return;
        }
        Session::set('compcond', $cond);
        $i = 0;
        while ($row = $rows->fetch()) {
            if ($i < self::TOP) {
                $i++;
                $imgname = Utilities::imgname('thumb', $row['id']) . '.jpg';
                $img =URL .'images/gallery/thumb/' . $imgname;
                if ($row['isavatar'] == 1) {
                    $av = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                } else {
                    $av = Utilities::imgname('avatar', 'default') . '.jpg';
                }
                $notinbaz.='<div class="pitem" id="vote">
                            <div class="id none" id="vo">vo' . $row['id'] . '</div>
                            <div class="zoomimg col-xs-12 col-md-4 right"><img class="responsive-img" src="' . URL . 'images/gallery/thumb/' . $imgname . '"></div>
                            <div class="cnt col-xs-12 col-md-8 right">';
                if (mb_strlen($row['name']) != 0) {
                    $notinbaz.='<h3 class="tl hd">نام تصویر : <span>' . htmlspecialchars($row['name']) . '</span></h3>';
                }
                $notinbaz.=' <h3 class="sbj hd">نام مسابقه : <span>' . $_SESSION['comp'] . '</span></h3>
                                <img class="av" src="' . URL . 'images/avatar/' . $av . '">';
                if (mb_strlen($row['username']) == 0 || mb_strlen($row['family']) == 0) {
                    $notinbaz.='<div class="us">' . htmlspecialchars($row['uname']) . '</div>';
                } else {
                    $notinbaz.='  <div class="us">' . htmlspecialchars($row['username']) . '  ' . htmlspecialchars($row['family']) . '</div>';
                }

                if (mb_strlen($row['date']) != 0) {
                    $notinbaz.=' <div class="dt "><span>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['date'])) . '</span><i class="glyphicon glyphicon-calendar right"></i></div>';
                }
                $notinbaz.='<div class="cmt right-align">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '</div>
                            <div class="adr none">' . $img . '?' . $i . '</div>
                            </div>
                            <div class="btnsdiv col-xs-12">
                                <a class="okcmt btn-enteshar right btn"><i class="glyphicon glyphicon-ok marginleft15 right"></i>تایید</a>
                                <a class="delcmt btn-noenteshar right btn mgright"><i class="glyphicon glyphicon-remove marginleft15 right"></i>عدم تایید</a>
                            </div>
                        </div>';
            }
        }
        $this->view->render('bazbin/index', json_encode(array('list' => $notinbaz, 'comps' => $comps, 'divimg' => Session::get('divimg'))), false, 0);
    }

    public function pagingloadphotos() {
        if (isset($_POST['pidcomp'])) {
            $lmt = self::TOP * ($_POST['pidcomp'] - 1);
            $cond = Session::get('compcond');
//            $cond .= ' Limit ' . $lmt . ',' . self::TOP;
            $rowsha = $this->model->notinbazrate($_SESSION['isopenid'], $cond);
            if ($rowsha != FALSE) {
                $cnt = $rowsha->rowCount();
                if ($cnt <= self::TOP) {
                    $noapp = 1;
                } else {
                    $cond .= ' Limit ' . $lmt . ',' . self::TOP;
                    $noapp = 0;
                }
            }
            $rows = $this->model->notinbazrate($_SESSION['isopenid'], $cond);
            $i = 0;
            $notinbaz = '';
            if ($rows) {
                while ($row = $rows->fetch()) {
                    if ($i < self::TOP) {
                        $i++;
                        $imgname = Utilities::imgname('thumb', $row['id']) . '.jpg';
                        $img = URL . 'images/gallery/thumb/' . $imgname;
                        if ($row['isavatar'] == 1) {
                            $av = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                        } else {
                            $av = Utilities::imgname('avatar', 'default') . '.jpg';
                        }
                        $notinbaz.='<div class="pitem" id="vote">
                            <div class="id none" id="vo">vo' . $row['id'] . '</div>
                            <div class="zoomimg col-xs-12 col-md-4 right"><img class="responsive-img" src="' . URL . 'images/gallery/thumb/' . $imgname . '"></div>
                            <div class="cnt col-xs-12 col-md-8 right">';
                        if (mb_strlen($row['name']) != 0) {
                            $notinbaz.='<h3 class="tl hd">نام تصویر : <span>' . htmlspecialchars($row['name']) . '</span></h3>';
                        }
                        $notinbaz.='<h3 class="sbj hd">نام مسابقه : <span>' . $_SESSION['comp'] . '</span></h3>
                                <img class="av" src="' . URL . 'images/avatar/' . $av . '">';
                        if (mb_strlen($row['username']) == 0 || mb_strlen($row['family']) == 0) {
                            $notinbaz.='<div class="us">' . htmlspecialchars($row['uname']) . ' </div>';
                        } else {
                            $notinbaz.='<div class="us">' . htmlspecialchars($row['username']) . '  ' . htmlspecialchars($row['family']) . '</div>';
                        }
                        if (mb_strlen($row['date'])) {
                            $notinbaz.='<div class="dt "><span>' . htmlspecialchars(Shamsidate::jdate('Y/m/d', $row['date'])) . '</span><i class="glyphicon glyphicon-calendar right"></i></div>';
                        }

                        $notinbaz.='<div class="cmt right-align">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '</div>
                            <div class="adr none">' . $img . '?' . $i . '</div>
                            </div>
                            <div class="btnsdiv col-xs-12">
                                <a class="btn-enteshar right btn"><i class="glyphicon glyphicon-ok marginleft15 right"></i>تایید</a>
                                <a class="btn-noenteshar right btn mgright"><i class="glyphicon glyphicon-remove marginleft15 right"></i>عدم تایید</a>
                            </div>
                        </div>';
                    }
                }
            }
//            $this->view->render('bazbin/index', $notinbaz, FALSE, 0);
            $return = array('list' => $notinbaz, 'noapp' => $noapp);
            $return = json_encode($return);
            $this->view->render('bazbin/index', $return, false, 0);
        }
    }

    public function okfunc($id) {
        $this->model->okfunc($id);
    }

    public function notokfunc($xx, $a1) {
        $this->model->notokfunc($xx, htmlspecialchars($a1));
    }

    public function reject($xx, $a1) {
        $this->model->reject($xx, htmlspecialchars($a1));
    }

    public function addtoall() {
        if (isset($_POST['id'])) {
            $this->model->addtoall($_POST['id']);
        }
    }

    public function addtook() {
        if (isset($_POST['id'])) {
            $this->model->addtook($_POST['id']);
        }
    }

}

//<div class="cmt right-align">' . str_replace(PHP_EOL, '<br>', htmlspecialchars($row['comment'])) . '</div>