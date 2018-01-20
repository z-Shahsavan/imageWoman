<?php

class blog extends Controller {

    private $isind = FALSE;

    function __construct() {
        parent::__construct();
    }

    const TOP = 12;

    public function index() {
        $userid = Session::get('userid');
        if ($userid == FALSE) {
            header('Location: ' . URL . 'index#loginlink');
            return;
        }
        $this->isind = TRUE;
        $this->id($userid);
        $this->calcscore(0);
        $this->loadfollow(Session::get('userid'));
        $this->view->render('blog/index', $this->data);
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
                            $ndate = Shamsidate::jdate('j F Y', time());
                            $users = array(htmlspecialchars($_POST['idfl']));
                            $this->addnote($text, $href, $ndate, $users);
                        }
                        $return = array('id' => 0);
                        $return = json_encode($return);
                        echo $return;
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
                            $ndate = Shamsidate::jdate('j F Y', time());
                            $users = array(htmlspecialchars($_POST['idfl']));
                            $this->addnote($text, $href, $ndate, $users);
                        }
                        $return = array('id' => 1);
                        $return = json_encode($return);
                        echo $return;
                    }
                }
            }
        }
    }

    public function loadfollow($selid) {
        $ing = 0;
        $er = 0;
        $cond0 = 'fid=:flid';
        $condata0 = array('flid' => $selid);
        $res0 = $this->model->selfer($cond0, $condata0);
        if ($res0) {
            $this->data['[VARFOLLOWERINFO]'] = '';
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
                $this->data['[VARFOLLOWERINFO]'].='<li class="collection-item avatar">
<img style="position: relative;" src="' . $avat . '" alt="تصوير دنبال کننده" class="circle">
<span class="title"><a href="' . URL . 'blog/id/' . $row1['userid'] . '">' . $username . '</a></span>
 </li>';
            }
        }
        $this->data['[VARFOLLOWING]'] = $er;
        $cond1 = 'userid=:uid';
        $condata1 = array('uid' => $selid);
        $res1 = $this->model->selfing($cond1, $condata1);
        if ($res1) {
            $this->data['[VARFOLLOWINGINFO]'] = '';
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
                $this->data['[VARFOLLOWINGINFO]'].='<li class="collection-item avatar">
<img style="position: relative;" src="' . $avat . '" alt="تصوير دنبال کننده" class="circle">
<span class="title"><a href="' . URL . 'blog/id/' . $row1['fid'] . '">' . $username . '</a></span>
 </li>';
            }
        }
        $this->data['[VARFOLLOWER]'] = $ing;
    }

    public function id($id) {
        $result = $this->model->selectuser($id);
        if ($result != FALSE) {
            $this->loadfollow($id);
            $this->calcscore($id);

            $row = $result->fetch();
            $this->data['[VARUSERID]'] = $row['id'];
            $thisuserid = Session::get('userid');
            if ($thisuserid != FALSE) {
                if ($thisuserid != $row['id']) {
                    $cond = 'userid=:userid AND fid=:fid';
                    $condata = array('userid' => $thisuserid, 'fid' => $row['id']);
                    $res = $this->model->checkflw($cond, $condata);
                    if ($res != FALSE) {
                        $payam = 'دنبال نکردن';
                    } else {
                        $payam = 'دنبال کردن';
                    }
                    $this->data['[VARFLWLINK]'] = '<div class="divider"></div>
        <a id="btnflw" data-userid="' . $row['id'] . '" style="margin-top: 5px; margin-bottom: 5px;background-color: orange;color: #ffffff;" class="waves-effect waves-light btn cyan lighten-2">' . $payam . '</a>';
                } else {
                    $this->data['[VARFLWLINK]'] = '';
                }
            } else {
                $this->data['[VARFLWLINK]'] = '';
            }


            if ($row['isavatar'] == 1) {
                $imgname = Utilities::imgname('avatar', $row['id']) . '.jpg';
                $this->data['[VARAVATAR]'] = URL . '/images/avatar/' . $imgname;
            } else {
                $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                $this->data['[VARAVATAR]'] = URL . '/images/avatar/' . $imgname;
            }

            if ($row['name'] != '' && $row['family'] != '') {
                $username = htmlspecialchars($row['name']) . ' ' . htmlspecialchars($row['family']);
            } else {
                $username = htmlspecialchars($row['username']);
            }
            $this->data['[VARUSERNAME]'] = $username;
            $this->data['[VARUSERINFO]'] = htmlspecialchars($row['userinfo']);
            $amar = $this->model->selectuserinfo($row['id']);
            $this->data['[VARUSERPHOTONUMBER]'] = $amar[0];
            Session::set('blogerid', $row['id']);
            $this->loadimagesforgall($row['id']);
            ///load page
            if ($this->isind == FALSE) {
                $this->view->render('blog/index', $this->data);
            }
        } else {
            //user not exist
            header('Location: ' . URL . 'index');
        }
    }

    public function loadimagesforgall($blogerid = NULL) {
//        echo $blogerid;
        $ispeople = '';
        $reall = '';
        if (Session::get('isuser') != FALSE) {
            $this->data['[VARHIDDEN]'] = 'none';
        } else {
            $this->data['[VARHIDDEN]'] = '';
        }
        if ($blogerid == NULL) {
            $blogerid = Session::get('blogerid');
        }
        //count of image
        $res = $this->model->countofimage($blogerid);
        if ($res != FALSE) {
            $cnt = $res->rowCount();
        } else {
            $cnt = 0;
        }
        $numofpage = ceil($cnt / self::TOP);
        if (!isset($_POST['tab']) || $_POST['tab'] == 1) {
            $cond = 'confirm=1 AND userid=:userid ORDER BY imglike DESC';
            Session::set('cond', $cond);
        } else {
            $cond = 'confirm=1 AND userid=:userid ORDER BY id DESC';
            Session::set('cond', $cond);
        }
        $cond.=' Limit ' . self::TOP;
        $condata = array('userid' => $blogerid);
        Session::set('condata', $condata);
        $res = $this->model->loadimagesforgall($cond, $condata);
        if ($res != FALSE) {
            $i=0;
            while ($row = $res->fetch()) {
                $showrate=0;
                $resuser = $this->model->selectuser($row['userid']);
                if ($resuser != FALSE) {
                    $rowuser = $resuser->fetch();
                    $username = $rowuser['name'] . ' ' . $rowuser['family'];
                    if ($username != ' ') {
                        $username = htmlspecialchars($username);
                    } else {
                        $username = htmlspecialchars($rowuser['username']);
                    }
                    $rescomp = $this->model->loadcompname($row['compid']);
                    if ($rescomp != FALSE) {

                        $rowcomp = $rescomp->fetch();
                        $compname = $rowcomp['name'];
                        if ($rowcomp['peopelwinno'] != 0) {
                            $ispeople = 1;
                        }
                        if (((time() - (48 * 3600)) < $rowcomp['enddate'])) {
                            $showstar = 1;
                        } else {
                            $showstar = 0;
                        }
                    }
                } else {
                    $username = '';
                }

//                $userid = Session::get('userid');
                $resr = $this->model->loadrate($row['id']);
                if ($resr) {
                    $rowrate = $resr->fetch();
                    $rate = $rowrate['rate'];
                } else {
                    $rate = 0;
                }
                if ($rowuser['isavatar'] == 1) {
                    $imgname = Utilities::imgname('avatar', $rowuser['id']) . '.jpg';
                    $vatar = URL . '/images/avatar/' . $imgname;
                } else {
                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                    $vatar = URL . '/images/avatar/' . $imgname;
                }
                $imgname = Utilities::imgname('thumb', $row['id']) . '.jpg';
                $thmname = Utilities::imgname('thumb', $row['id']) . '.jpg';
                                $reall.=' <div  class="brick';
                if (Session::get('userid')) {
                    $reall.=' isusermix';
                }
                $reall.=' " id="gallery">
                    <input type="hidden" name="idpic" value="' . $row['id'] . '">
                                    <div class="image-head">';
                if ($ispeople == 1) {
                    $ratee = explode('.', $row['imglike']);
                    if ($ratee[1] == '00') {
                        if ($ratee[0] == '0') {
                            $showrate = 0;
                            $cls = 'none';
                        } else {
                            $showrate = $ratee[0];
                            $cls = 'show';
                        }
                    } else {
                        $showrate = $row['imglike'];
                        $cls = 'show';
                    }

                    $reall.=' <div class="score-image1 ' . $cls . '">
                                            <img src="' . URL . 'images/icons/score-icon.png" />
                                            <span>' .$showrate. '</span>
                                        </div>';
                }
                $reall.='<div class="details-image1">';
                $len = mb_strlen($row['name']);
                if ($len != 0) {
                    $reall.=' <span class="pn">' . htmlspecialchars($row['name']) . ' </span>';
                }else{
                    $reall.=' <span class="pn"></span>';
                }
                $reall.=' </div>
                               
                             </div>';
                if (Session::get('userid')) {
                    $reall.='  <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">
                             </a>';
                } else {
                    $reall.='  <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">';
                }

                $reall.=' <div class="id none">' . $row['id'] . '</div>
                                 <div class="us none"><a class="userlink" >' . $username . '</a></div>
                                <div class="dt none">' . Shamsidate::jdate('j F Y', $row['date']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['compid'] . '" id="cmp">' . htmlspecialchars($compname) . '</a></div>
                                <div class="rt none">' . $showrate . '</div>
                              <input type="hidden"  id="shorno" value="' . $showstar . '">
                       </div>
                  ';
                $i++;
            }
            if (isset($_POST['tab'])) {
                $this->view->render('blog/index', $reall, FALSE, 0);
            } else {
                $this->data['[VARGALIMAGES]'] = $reall;
            }
        }
    }

    public function paging() {
        $ispeople = '';
        $reall = '';
        if (isset($_POST['pid'])) {
            $cond = Session::get('cond');
            $condata = Session::get('condata');
//        $fields = array('idxid', 'pgid', 'thisuserpgid');
//                switch ($_POST['idxid']) {
//                    case 1:
            $lmt = self::TOP * ($_POST['pid'] - 1);
            $cond .= ' Limit ' . $lmt . ', ' . self::TOP;
//            $condata = array('userid' => $_POST['thisuserpgid']);
            $res = $this->model->loadimagesforgall($cond, $condata);
            if ($res != FALSE) {
                $i=0;
                while ($row = $res->fetch()) {
                    $showrate=0;
                    $resuser = $this->model->selectuser($row['userid']);
                    if ($this->model->checklike($row['id'], Utilities::userip()) == FALSE) {
                        $like = 0;
                    } else {
                        $like = 1;
                    }
                    if ($resuser != FALSE) {
                        $rowuser = $resuser->fetch();
                        $username = $rowuser['name'] . ' ' . $rowuser['family'];
                        if ($username != ' ') {
                            $username = htmlspecialchars($username);
                        } else {
                            $username = htmlspecialchars($rowuser['username']);
                        }
                        $username = htmlspecialchars($username);
                        $rescomp = $this->model->loadcompname($row['compid']);
                        if ($rescomp != FALSE) {

                            $rowcomp = $rescomp->fetch();
                            $compname = $rowcomp['name'];
                            if ($rowcomp['peopelwinno'] != 0) {
                                $ispeople = 1;
                            }
                            if (((time() - (48 * 3600)) < $rowcomp['enddate'])) {
                                $showstar = 1;
                            } else {
                                $showstar =0;
                            }
                        }
                    } else {
                        $username = '';
                    }
                    $userid = Session::get('userid');
                    $resr = $this->model->loadrate($row['id']);
                    if ($resr) {
                        $rowrate = $resr->fetch();
                        $rate = $rowrate['rate'];
                    } else {
                        $rate = 0;
                    }
                    if ($rowuser['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $rowuser['id']) . '.jpg';
                        $vatar = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $vatar = URL . '/images/avatar/' . $imgname;
                    }
                    $imgname = Utilities::imgname('thumb', $row['id']) . '.jpg';
                    $thmname = Utilities::imgname('thumb', $row['id']) . '.jpg';
                                 $reall.=' <div  class="brick';
                if (Session::get('userid')) {
                    $reall.=' isusermix';
                }
                $reall.=' " id="gallery">
                    <input type="hidden" name="idpic" value="' . $row['id'] . '">
                                    <div class="image-head">';
                if ($ispeople == 1) {
                    $ratee = explode('.', $row['imglike']);
                    if ($ratee[1] == '00') {
                        if ($ratee[0] == '0') {
                            $showrate = 0;
                            $cls = 'none';
                        } else {
                            $showrate = $ratee[0];
                            $cls = 'show';
                        }
                    } else {
                        $showrate = $row['imglike'];
                        $cls = 'show';
                    }

                    $reall.=' <div class="score-image1 ' . $cls . '">
                                            <img src="' . URL . 'images/icons/score-icon.png" />
                                            <span>' .$showrate . '</span>
                                        </div>';
                }
                $reall.='<div class="details-image1"> ';
                $len = mb_strlen($row['name']);
                if ($len != 0) {
                    $reall.=' <span class="pn">' . htmlspecialchars($row['name']) . ' </span>';
                }else{
                    $reall.=' <span class="pn"></span>';
                }
                $reall.=' </div>
                              
                             </div>';
                if (Session::get('userid')) {
                    $reall.='  <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">
                             </a>';
                } else {
                    $reall.='  <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">';
                }

                $reall.=' <div class="id none">' . $row['id'] . '</div>
                                 <div class="us none"><a class="userlink" >' . $username . '</a></div>
                                <div class="dt none">' . Shamsidate::jdate('j F Y', $row['date']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['compid'] . '" id="cmp">' . htmlspecialchars($compname) . '</a></div>
                                <div class="rt none">' .$showrate . '</div>
                              <input type="hidden"  id="shorno" value="' . $showstar . '">
                       </div>
                  ';
                $i++;
                }
            }
            $this->view->render('gallery/index', $reall, false, 0);
            return FALSE;
        }
    }

    public function calcscore($id) {
        $txt = '';
        if ($id != 0) {
            $rows = $this->model->calcscore($id);
        } else {
            $rows = $this->model->calcscore(Session::get('userid'));
        }

        $score = 0;
        if ($rows) {
            $row = $rows->fetch();
            foreach ($row as $key => $value) {
                $score+=$value;
            }
            $score-=$row['userid'];
            $score-=$row['id'];


            $txt = ' <p class="padding-style2">تاییدشدن عکس  : <span>' . $row['confirm_photo'] . '</span></p>
                <p class="padding-style2">ورود : <span>' . $row['login_score'] . '</span></p>
                <p class="padding-style2">جمع امتیاز : <span>' . $score . '</span></p>';
        }
        $this->data['[VARSCORE]'] = $txt;

        if ($id != 0) {
            $res = $this->model->wininfo($id);
        } else {
            $res = $this->model->wininfo(Session::get('userid'));
        }

        $wins = '';
        if ($res) {
            while ($r = $res->fetch()) {
                $wins .= '<div class="divider marginbottom10"></div>
                <p style="direction: rtl;">مسابقه : <span>' . $r['compname'] . '</span></p>
                <p style="direction: rtl;">رتبه : <span>' . $r['cmnt'] . '</span></p>
                <p style="direction: rtl;">جایزه : <span>' . $r['price'] . '</span></p>
                <br/>';
            }
        }
        $this->data['[VARWINS]'] = $wins;
    }

}
