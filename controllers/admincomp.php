<?php

class admincomp extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::access_control('isuser', 'index#loginlink', 4);
    }

    public function index() {
        $this->davaran();
        $this->bazbinha();
        $this->view->render('admincomp/index', $this->data);
    }

    public function savecomp() {
        $msgid = 0;
        $msgtxt = '';
        $fields = array('name', 'sath', 'startdate', 'enddate', 'comment', 'jayeze', 'idds', 'idbs', 'winno', 'selno', 'davarino');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $i = 0;
                $j = 0;
                $dd = explode('*', rtrim($_POST['idds'], '*'));
                $bb = explode('*', rtrim($_POST['idbs'], '*'));
                $data = '';
                $edate = explode('/', $_POST['enddate']);
                $sdate = explode('/', $_POST['startdate']);
                $data = array('name' => $_POST['name'], 'decription' => $_POST['comment'], 'level' => $_POST['sath'],
                    'startdate' => Shamsidate::jmktime(0, 0, 0, $sdate[1], $sdate[2], $sdate[0]),
                    'enddate' => Shamsidate::jmktime(23, 59, 59, $edate[1], $edate[2], $edate[0]), 'prise' => $_POST['jayeze'],
                    'winno' => $_POST['winno'], 'selno' => $_POST['selno'], 'davarino' => $_POST['davarino']);
                if (isset($_POST['ispeople'])) {
                    $fil = array('peoplecount', 'jayezepeople');
                    if (Checkform::checkset($_POST, $fil)) {
                        if (Checkform::checknotempty($_POST, $fields)) {
                            $data['peopelwinno'] = $_POST['peoplecount'];
                            $data['peoplewinprise'] = $_POST['jayezepeople'];
                        } else {
                            $msgtxt = 'لطفا اطلاعات بخش مسابقه مردمی را کامل کنید.!';
                            $msgid = 0;
                            $data = array('id' => $msgid, 'msg' => $msgtxt);
                            $data = json_encode($data);
                            $this->view->render('admincomp/index', $data, false, 0);
                            return;
                        }
                    } else {
                        $msgtxt = 'لطفا اطلاعات بخش مسابقه مردمی را کامل کنید.!';
                        $msgid = 0;
                        $data = array('id' => $msgid, 'msg' => $msgtxt);
                        $data = json_encode($data);
                        $this->view->render('admincomp/index', $data, false, 0);
                        return;
                    }
                }
                //  if (isset($_POST['isactive'])) {
                //   $data['isopen'] = 1;
                //  } else {
                $data['isopen'] = 0;
                //  }
                if (isset($_FILES["poster"]["name"])) {
                    $data['hasposter'] = 1;
                }
                $compid = $this->model->savecomp($data);
                if (isset($_FILES["poster"]["name"])) {
                    $pores=$this->saveposter($compid);
                }
                foreach ($dd as $value) {
                    $da[$i]['compid'] = $compid;
                    $da[$i]['did'] = $value;
                    $i++;
                }
                $this->model->addds('did,compid', $da);
                foreach ($bb as $value0) {
                    $ba[$j]['compid'] = $compid;
                    $ba[$j]['bid'] = $value0;
                    $j++;
                }

                $this->model->addbs('bid,compid', $ba);
                //notify was here
                $msgtxt = 'اطلاعات با موفقیت ثبت گردید';
                $msgid = 1;
            } else {
                $msgtxt = 'لطفا تمامی موارد را وارد نمایید!';
                $msgid = 0;
            }
        } else {
            $msgtxt = 'لطفا تمامی موارد را وارد نمایید!';
            $msgid = 0;
        }
        $data = array('id' => $msgid, 'msg' => $msgtxt);
        $data = json_encode($data);
        $this->view->render('admincomp/index', $data, false, 0);
//        if (isset($_POST['isactive'])) {
//            //add notify
//            $users = $this->userfornote();
//            $this->addnote('مسابقه ' . $_POST['name'] . ' آغاز شد.', 'comp/id/' . $compid, Shamsidate::jdate('H:i | l, j F Y', time()), $users);
//        }
    }

    public function saveposter($compid) {
        $postername = Utilities::imgname('poster', $compid) . '.jpg';
        move_uploaded_file($_FILES['poster']["tmp_name"], $_SERVER['DOCUMENT_ROOT'] .PROJECTNAME . "/images/poster/" . $postername);
    }

    public function editcomp() {
        $msgid = 0;
        $msgtxt = '';
        $fields = array('name', 'sath', 'startdate', 'enddate', 'comment', 'jayeze'
            , 'modwinno', 'modselno', 'moddavarino');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $i = 0;
                $dd = explode('*', rtrim($_POST['iddsed'], '*'));
                $bb = explode('*', rtrim($_POST['idbsed'], '*'));
                $edate = explode('/', $_POST['enddate']);
                $sdate = explode('/', $_POST['startdate']);
                $data = array('name' => $_POST['name'], 'decription' => $_POST['comment'], 'level' => $_POST['sath'],
                    'startdate' => Shamsidate::jmktime(0, 0, 0, $sdate[1], $sdate[2], $sdate[0]),
                    'enddate' => Shamsidate::jmktime(23, 59, 59, $edate[1], $edate[2], $edate[0]), 'prise' => $_POST['jayeze'],
                    'winno' => $_POST['modwinno'], 'selno' => $_POST['modselno'], 'davarino' => $_POST['moddavarino']);
                if (isset($_POST['ispeopleedit'])) {
                    $fil = array('peoplecountedit', 'jayezepeopleedit');
                    if (Checkform::checkset($_POST, $fil)) {
                        if (Checkform::checknotempty($_POST, $fields)) {
                            $data['peopelwinno'] = $_POST['peoplecountedit'];
                            $data['peoplewinprise'] = $_POST['jayezepeopleedit'];
                        } else {
                            $msgtxt = 'لطفا اطلاعات بخش مسابقه مردمی را کامل کنید.!';
                            $msgid = 0;
                            $data = array('id' => $msgid, 'msg' => $msgtxt);
                            $data = json_encode($data);
                            $this->view->render('admincomp/index', $data, false, 0);
                            return;
                        }
                    } else {
                        $msgtxt = 'لطفا اطلاعات بخش مسابقه مردمی را کامل کنید.!';
                        $msgid = 0;
                        $data = array('id' => $msgid, 'msg' => $msgtxt);
                        $data = json_encode($data);
                        $this->view->render('admincomp/index', $data, false, 0);
                        return;
                    }
                }
                //notify waz here
//                if (isset($_POST['isactiveedit'])) {
//                    $data['isopen'] = 1;
//                } else {
//                    $data['isopen'] = 0;
//                }
                $cond = 'id=:id';
                $condata = array('id' => $_POST['ideditcomp']);
                $this->model->editcomp($data, $cond, $condata);
                $compid = $_POST['ideditcomp'];
                $cond = 'compid=:compid';
                $condata = array('compid' => $compid);
                $result = $this->model->chosedv($cond, $condata);
                $addid = '';
                $dltid = '';
                $i = 0;
                if ($result) {
                    $dltdv = false;
                    while ($row = $result->fetch()) {
                        if (!in_array($row['did'], $dd)) {
                            $dltda[$i] = $row['did'];
                            $did[$i] = $row['did'];
                            $dltdv = true;
                        } else {
                            $did[$i] = $row['did'];
                        }$i++;
                    }
                    if ($dltdv) {
                        $cond = '(compid=:compid) AND (';
                        $condata['compid'] = $compid;
                        $i = 0;
                        foreach ($dltda as $value) {
                            $cond.='did=:did' . $i . ' OR ';
                            $condata['did' . $i] = $value;
                            $i++;
                        }
                        $cond = substr($cond, 0, strlen($cond) - 3);
                        $cond.=')';
                        $this->model->dltds($cond, $condata);
                    }
                    $i = 0;
                    foreach ($dd as $value) {
                        if (!in_array($value, $did)) {
                            $da[$i]['compid'] = $compid;
                            $da[$i]['did'] = $value;
                            $i++;
                        }
                    }
                } else {
                    $i = 0;
                    foreach ($dd as $value) {
                        $da[$i]['compid'] = $compid;
                        $da[$i]['did'] = $value;
                        $i++;
                    }
                }
                if ($i > 0 && $_POST['iddsed'] != '') {
                    $this->model->addds('did,compid', $da);
                }

                //**bazbinchange
                $cond = 'compid=:compid';
                $condata = array('compid' => $compid);
                $result = $this->model->chosebz($cond, $condata);
                $addid = '';
                $dltid = '';
                $i = 0;
                if ($result) {
                    $dltbz1 = false;
                    while ($row = $result->fetch()) {
                        if (!in_array($row['bid'], $bb)) {
                            $dltbz[$i] = $row['bid'];
                            $bid[$i] = $row['bid'];
                            $dltbz1 = true;
                        } else {
                            $bid[$i] = $row['bid'];
                        }$i++;
                    }
                    if ($dltbz1) {
                        $cond = '(compid=:compid) AND (';
                        $condata['compid'] = $compid;
                        $i = 0;
                        foreach ($dltbz as $value) {
                            $cond.='bid=:bid' . $i . ' OR ';
                            $condata['bid' . $i] = $value;
                            $i++;
                        }
                        $cond = substr($cond, 0, strlen($cond) - 3);
                        $cond.=')';
                        $this->model->dltbz($cond, $condata);
                    }
                    $j = 0;
                    foreach ($bb as $value0) {
                        if (!in_array($value0, $bid)) {
                            $ba[$j]['compid'] = $compid;
                            $ba[$j]['bid'] = $value0;
                            $j++;
                        }
                    }
                } else {
                    $j = 0;
                    foreach ($bb as $value0) {
                        $ba[$j]['compid'] = $compid;
                        $ba[$j]['bid'] = $value0;
                        $j++;
                    }
                }
                if ($j > 0 && $_POST['idbsed'] != '') {
                    $this->model->addbs('bid,compid', $ba);
                }
                $msgtxt = 'اطلاعات با موفقیت ثبت گردید';
                $msgid = 1;
            } else {
                $msgtxt = 'لطفا تمامی موارد را وارد نمایید!';
                $msgid = 0;
            }
        } else {
            $msgtxt = 'لطفا تمامی موارد را وارد نمایید!';
            $msgid = 0;
        }

        $data = array('id' => $msgid, 'msg' => $msgtxt);
        $data = json_encode($data);
        $this->view->render('admincomp/index', $data, false, 0);

//        if (isset($_POST['isactiveedit'])) {
//            //add notify
//            $users = $this->userfornote();
//            $this->addnote('مسابقه ' . $_POST['name'] . ' بروز شد.', 'comp/id/' . $_POST['ideditcomp'], Shamsidate::jdate('H:i | l, j F Y', time()), $users);
//        }
    }

    public function ajaxselectcomps() {
        $returndata = '';
        $cond = 'isopen!=:isopen AND isopen!=3';
        $condata = array('isopen' => 2);
        $result = $this->model->selectcomps($cond, $condata);
        $vaziat = '';
        $swch = 0;
        if ($result != FALSE) {
            while ($row = $result->fetch()) {
                switch ($row['isopen']) {
                    case 2:
                        $vaziat = 'گذشته';
                        $swch = 0;
                        break;
                    case 1:
                        $vaziat = 'فعال';
                        $swch = 1;
                        break;
                    case 0:
                        $vaziat = 'آینده';
                        $swch = 0;
                        break;
                }
                $returndata.='<div class="pitem" id="id' . $row['id'] . '">
                            <div class="id none">' . $row['id'] . '</div>
                            <div class="cnt col s12">
                                <h3 class="tl hd">نام مسابقه : <span>' . htmlspecialchars($row['name']) . '</span></h3>
                                <h3 class="st hd">وضعیت : <span>' . $vaziat . '</span></h3>
                                <h3 class="sath hd">سطح مسابقه : <span>' . $row['level'] . '</span></h3>
                                <h3 class="sdt hd">تاریخ شروع : <span>' . Shamsidate::jdate('Y/m/d', $row['startdate']) . '</span></h3>
                                <h3 class="edt hd">تاریخ پایان : <span>' . Shamsidate::jdate('Y/m/d', $row['enddate']) . '</span></h3>
                                <h3 class="cmt hd">توضیحات : <span>' . AntiXSS::clean_up($row['decription']) . '</span></h3>
                                <h3 class="jz hd">جوایز : <span>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['prise'])) . '</span></h3>
                                <h3 class="cntw hd">تعداد برندگان : <span>' . $row['winno'] . '</span></h3>
                                <h3 class="cntm hd">تعداد منتخبان : <span>' . $row['selno'] . '</span></h3>
                                <h3 class="cntd hd">تعداد راه یافتگان به بخش داوری : <span>' . $row['davarino'] . '</span></h3>';
                if ($row['peopelwinno'] != 0) {
                    $returndata.='<div class="isppl none">1</div>
                                <h3 class="cntppl hd">تعداد برندگان مسابقه مردمی : <span>' . $row['peopelwinno'] . '</span></h3>
                                <h3 class="jzppl hd">جوایز مسابقه مردمی : <span>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['peoplewinprise'])) . '</span></h3>';
                } else {
                    $returndata.='<div class="isppl none">0</div>
                            <h3 class="cntppl hd"></span></h3>
                                <h3 class="jzppl hd"></span></h3>';
                }
                $returndata.=' <div class="hd">داوران :</div><ul class="dv" >';
                $cond = 'cid=:cid';
                $condata = array('cid' => $row['id']);
                $res = $this->model->selectdavar($cond, $condata);
                if ($res != FALSE) {
                    while ($rowdv = $res->fetch()) {
                        if ($rowdv['dname'] != '' && $rowdv['dfamily'] != '') {
                            $davnamej = htmlspecialchars($rowdv['dname']) . ' ' . htmlspecialchars($rowdv['dfamily']);
                        } else {
                            $davnamej = $rowdv['username'];
                        }
                        $returndata.=' <li><div id="davarandivedit">' . $davnamej . '</div>
                                <div class="dvid none" id="">' . $rowdv['did'] . '</div>
                                </li>';
                    }
                }
                $returndata.='</ul> <div class="hd">بازبین ها :</div><ul class="bz paddingright30">';
                $cond = 'id=:id';
                $condata = array('id' => $row['id']);
                $res = $this->model->selectbazbin($cond, $condata);
                if ($res != FALSE) {
                    while ($rowdv = $res->fetch()) {
                        if ($rowdv['bname'] != '' && $rowdv['bfamily'] != '') {
                            $baznamej = htmlspecialchars($rowdv['bname']) . ' ' . htmlspecialchars($rowdv['bfamily']);
                        } else {
                            $baznamej = $rowdv['username'];
                        }
                        $returndata.=' <li><div id="bazbinhadivedit">' . $baznamej . '</div>
                                <div class="idbz none" id="">' . $rowdv['bid'] . '</div>
                                </li>';
                    }
                }
                $returndata.='</ul><div id="statuseach" class="status none">' . $swch . '</div>
                            </div>
                            <div class="btnsdiv col s12">
                                <a class="editcmp bwaves-effect waves-white teal darken-3 right btn"><i class="mdi-editor-mode-edit right"></i>ویرایش</a>
                                
                            </div>
                        </div>';
            }
        }
        $data = array('msg' => $returndata);
        $data = json_encode($data);
        $this->view->render('admincomp/index', $data, false, 0);
        return FALSE;
    }

    public function davaran() {
        $cond = 'isadmin=2';
        $result = $this->model->selectdavaran($cond);
        if ($result != FALSE) {
            $data = '';
            while ($row = $result->fetch()) {
                if ($row['name'] != '' && $row['family'] != '') {
                    $davarname = htmlspecialchars($row['name']) . ' ' . htmlspecialchars($row['family']);
                } else {
                    $davarname = $row['username'];
                }
                $data.='  <li class="active">
                    <div>' . $davarname . '</div>
                    <div class="id none">' . $row['id'] . '</div>
                </li>  ';
            }
            $this->data["[VARDAVARAN]"] = $data;
        }
    }

    public function bazbinha() {
        $cond = 'isadmin=3';
        $result = $this->model->selectbazbinha($cond);
        if ($result != FALSE) {
            $data = '';
            while ($row = $result->fetch()) {
                if ($row['name'] != '' && $row['family'] != '') {
                    $bazname = htmlspecialchars($row['name']) . ' ' . htmlspecialchars($row['family']);
                } else {
                    $bazname = $row['username'];
                }
                $data.='  <li class="active">
                    <div>' . $bazname . '</div>
                    <div class="id none">' . $row['id'] . '</div>
                </li>  ';
            }
            $this->data["[VARBAZS]"] = $data;
        }
    }

    public function loadfinishcomp() {
        $cond = 'isopen=2 ORDER by id DESC';
        $endda = time() - 48 * 3600;
        $res = $this->model->loadfinishcomp($cond);
        if ($res != FALSE) {
            $list = '';
            while ($row = $res->fetch()) {
                if ($row['enddate'] <= $endda) {
                    $btn = '<a id="competmam" class="bwaves-effect waves-white purple darken-3 right btn mgright"><i class="mdi-action-exit-to-app right"></i>اتمام مسابقه</a>';
                } else {
                    $btn = '';
                }
                $list.='<div class="pitem">
                            <div class="id none">' . $row['id'] . '</div>
                            <div class="cnt col s12">
                                <h3 class="tl hd">نام مسابقه : <span>' . htmlspecialchars($row['name']) . '</span></h3>
                                <h3 class="sath hd">سطح مسابقه : <span>' . $row['level'] . '</span></h3>
                                <h3 class="sdt hd">تاریخ شروع : <span>' . Shamsidate::jdate('Y/m/d', $row['startdate']) . '</span></h3>
                                <h3 class="edt hd">تاریخ پایان : <span>' . Shamsidate::jdate('Y/m/d', $row['enddate']) . '</span></h3>
                                <h3 class="cmt hd">توضیحات : <span>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['decription'])) . '</span></h3>
                                <h3 class="jz hd">جوایز : <span>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['prise'])) . '</span></h3>
                                <h3 class="cntw hd">تعداد برندگان : <span>' . $row['winno'] . '</span></h3>
                                <h3 class="cntm hd">تعداد منتخبان : <span>' . $row['selno'] . '</span></h3>
                                <h3 class="cntd hd">تعداد راه یافتگان به بخش داوری : <span>' . $row['davarino'] . '</span></h3>
                                <div class="isppl none">1</div>
                                <h3 class="cntppl hd">تعداد برندگان مسابقه مردمی : <span>' . $row['peopelwinno'] . '</span></h3>
                                <h3 class="jzppl hd">جوایز مسابقه مردمی : <span>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['peoplewinprise'])) . '</span></h3>
                                <div class="status none">1</div>
                            </div>
                            <div class="btnsdiv col s12">
                                ' . $btn . '
                            </div>
                        </div>';
            }
            $this->view->render('admincomp/index', $list, false, 0);
        }
    }

    public function loadarchv() {
        $cond = 'isopen=3 ORDER by id DESC';
        $res = $this->model->loadfinishcomp($cond);
        if ($res != FALSE) {
            $list = '';
            while ($row = $res->fetch()) {
                $winners = '';
                $montakh = '';
                $peopwin = '';
                $cond = 'cmpid=:cid';
                $coda = array('cid' => $row['id']);
                $winres = $this->model->winners($cond, $coda);
                if ($winres) {
                    while ($winrow = $winres->fetch()) {
                        $wi = '';
                        switch ($winrow['wintype']) {
                            case 0:
                                if ($winrow['nam'] != '' && $winrow['family'] != '') {
                                    $wi = htmlspecialchars($winrow['nam']) . ' ' . htmlspecialchars($winrow['family']);
                                } else {
                                    $wi = htmlspecialchars($winrow['username']);
                                }
                                $winners.='<a href="' . URL . 'blog/id/' . $winrow['uid'] . '">' . $wi . '</a>  |  ';
                                break;
                            case 1:
                                if ($winrow['nam'] != '' && $winrow['family'] != '') {
                                    $wi = htmlspecialchars($winrow['nam']) . ' ' . htmlspecialchars($winrow['family']);
                                } else {
                                    $wi = htmlspecialchars($winrow['username']);
                                }
                                $montakh.='<a href="' . URL . 'blog/id/' . $winrow['uid'] . '">' . $wi . '</a>  |  ';
                                break;
                            case 2:
                                if ($winrow['nam'] != '' && $winrow['family'] != '') {
                                    $wi = htmlspecialchars($winrow['nam']) . ' ' . htmlspecialchars($winrow['family']);
                                } else {
                                    $wi = htmlspecialchars($winrow['username']);
                                }
                                $peopwin.='<a href="' . URL . 'blog/id/' . $winrow['uid'] . '">' . $wi . '</a>  |  ';
                                break;
                        }
                    }
                    $winners = substr($winners, 0, strlen($winners) - 3);
                    $montakh = substr($montakh, 0, strlen($montakh) - 3);
                    $peopwin = substr($peopwin, 0, strlen($peopwin) - 3);
                }
                $list.='<div class="pitem">
                            <div class="id none">' . $row['id'] . '</div>
                            <div class="cnt col s12">
                                <h3 class="tl hd">نام مسابقه : <span>' . htmlspecialchars($row['name']) . '</span></h3>
                                <h3 class="sath hd">سطح مسابقه : <span>' . $row['level'] . '</span></h3>
                                <h3 class="sdt hd">تاریخ شروع : <span>' . Shamsidate::jdate('Y/m/d', $row['startdate']) . '</span></h3>
                                <h3 class="edt hd">تاریخ پایان : <span>' . Shamsidate::jdate('Y/m/d', $row['enddate']) . '</span></h3>
                                <h3 class="cmt hd">توضیحات : <span>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['decription'])) . '</span></h3>
                                <h3 class="jz hd">جوایز : <span>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['prise'])) . '</span></h3>
                                <h3 class="cntw hd">تعداد برندگان : <span>' . $row['winno'] . '</span></h3>'
                        . $winners .
                        '<h3 class="cntm hd">تعداد منتخبان : <span>' . $row['selno'] . '</span></h3>'
                        . $montakh .
                        '<h3 class="cntd hd">تعداد راه یافتگان به بخش داوری : <span>' . $row['davarino'] . '</span></h3>
                                <div class="isppl none">1</div>
                                <h3 class="cntppl hd">تعداد برندگان مسابقه مردمی : <span>' . $row['peopelwinno'] . '</span></h3>'
                        . $peopwin .
                        '<h3 class="jzppl hd">جوایز مسابقه مردمی : <span>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['peoplewinprise'])) . '</span></h3>
                                <div class="status none">1</div>
                            </div>
                        </div>';
            }
            $this->view->render('admincomp/index', $list, false, 0);
        }
    }

    public function endcomp() {
        $msgid = 0;
        $fields = array('id', 'cname');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $data = array('isopen' => 3);
                $cond = 'id=:id';
                $condata = array('id' => $_POST['id']);
                $this->model->updatecomps($data, $cond, $condata);
                $msgid = 1;
                $this->view->render('admincomp/index', json_encode(array('id' => $msgid)), false, 0);
                //add notify
                $users = $this->userfornote();
                $this->addnote('مسابقه ' . $_POST['cname'] . ' به پایان رسید.', 'comp/id/' . $_POST['id'], Shamsidate::jdate('y-m-d', time()), $users);
                $this->notifytowinners($_POST['id'], $_POST['cname']);
            } else {
                $msgid = 0;
                $this->view->render('admincomp/index', json_encode(array('id' => $msgid)), false, 0);
            }
        } else {
            $msgid = 0;
            $this->view->render('admincomp/index', json_encode(array('id' => $msgid)), false, 0);
        }
    }

    public function notifytowinners($compid, $cname) {
        $cond = 'cmpid=:cid';
        $condata = array('cid' => $compid);
        $res = $this->model->notifytowinners($cond, $condata);
        if ($res != FALSE) {
            $i = 0;
            $winnotify = array();
            $winun = array();
            while ($row = $res->fetch()) {
                $winnotify['text'] = 'عکس "' . $row['name'] . 'در مسابقه "' . $cname . '" ';
                switch ($row['wintype']) {
                    case 0:
                        $winnotify['text'].='رتبه ' . $row['rate'] . ' را در بخش داوری' . 'کسب کرد.';
                        break;
                    case 1:
                        $winnotify['text'].=' منتخب بخش داوری شد';
                        break;
                    case 2:
                        $winnotify['text'].='رتبه ' . $row['rate'] . ' را در بخش مسابقه مردمی کسب کرد.';
                        break;
                }
                $winnotify['ndate'] = Shamsidate::jdate('y-m-d', time());
                $winun[$i]['nid'] = $this->model->insnotify($winnotify);
                $winun[$i]['uid'] = $row['uid'];
                $i++;
            }
            $this->model->binsusernotify('nid,uid', $winun);
        }
    }

}
