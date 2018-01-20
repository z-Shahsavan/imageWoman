<?php

class gallery extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->loadimagesforgall();
        $this->view->render('gallery/index', $this->data);
    }

    const TOP = 12;

    public function loadimagesforgall() {
        $ispeople = 0;
        $this->data['[VARGALIMAGES]'] = '';
        $this->data['[VARIMAGECOUNT]'] = '';
        $this->data['[VARITEMRATE]'] = '';
        //count of image
        $res = $this->model->countofimage();
        if ($res != FALSE) {
            $cnt = $res->rowCount();
        } else {
            $cnt = 0;
        }
        $numofpage = ceil($cnt / self::TOP);
        $this->data['[VARIMAGECOUNT]'] = $numofpage;
        //load ALL IMAGE
        $cond = 'confirm=1 ORDER BY id DESC Limit ' . self::TOP;
        $res = $this->model->loadimagesforgall($cond);
        if ($res != FALSE) {
            $reall = '';
            $i = 0;
            while ($row = $res->fetch()) {
                $showrate = 0;
                $resuser = $this->model->loadusername($row['userid']);
                if ($resuser != FALSE) {
                    $rowuser = $resuser->fetch();
                    if ($rowuser['name'] != '' && $rowuser['family'] != '') {
                        $username = $rowuser['name'] . ' ' . $rowuser['family'];
                    } else {
                        $username = $rowuser['username'];
                    }
                    $username = htmlspecialchars($username);
                } else {
                    $username = $rowuser['username'];
                }
                $rescomp = $this->model->loadcompname($row['compid']);
                if ($rescomp != FALSE) {
                    $ispeople = '';
                    $rowcomp = $rescomp->fetch();
                    $compname = $rowcomp['name'];
                    if ($rowcomp['peopelwinno'] != 0) {
                        $ispeople = 1;
                    }

                    if ((time() - (48 * 3600)) < $rowcomp['enddate']) {
                        $showstar = 1;
                    } else {
                        $showstar = 0;
                    }
                } else {
                    $compname = '';
                }

//                $userid = $row['userid'];
//                $resr = $this->model->loadrate($row['id']);
//                if ($resr) {
//                    $rowrate = $resr->fetch();
//                    $rate = $rowrate['rate'];
//                } else {
//                    $rate = 0;
//                }
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
                $reall.=' ">
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
                                            <img src="' . URL . 'images/icons/score-icon.png"/>
                                            <span>' . $showrate . '</span>
                                        </div>';
                }
                $reall.='<a href="' . URL . 'blog/id/' . htmlspecialchars($rowuser['id']) . '">
                                            <div class="details-image1">
                                      <img  class="av" src="' . $vatar . '" />';
                $len = mb_strlen($row['name']);
                if ($len != 0) {
                    $reall.=' <span class="pn">' . htmlspecialchars($row['name']) . ' </span>';
                } else {
                    $reall.='<span class="pn"></span>  ';
                }
                $reall.=' </div>
                                </a>
                             </div>';
                if (Session::get('userid')) {
                    $reall.='  <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">
                             </a>';
                } else {
                    $reall.='  <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">';
                }

                $reall.=' <div class="id none">' . $row['id'] . '</div>
                                 <div class="us none"><a href="' . URL . 'blog/id/' . htmlspecialchars($rowuser['id']) . '" class="userlink" >' . $username . '</a></div>
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
            $this->data['[VARGALIMAGES]'] = $reall;
        }
    }

    public function paging() {
        $i = 0;
        $reall = '';
        $ispeople = 0;
        $returndata = '';
        if (isset($_POST['pid'])) {
            $lmt = self::TOP * ($_POST['pid'] - 1);
            $cond = 'confirm=1 ORDER BY id DESC Limit :lmt, :top ';
            $condata = array('lmt' => $lmt, 'top' => self::TOP);
            $res = $this->model->loadimagesforgall($cond, $condata);
            if ($res != FALSE) {
                while ($row = $res->fetch()) {
                    $showrate = 0;
                    $resuser = $this->model->loadusername($row['userid']);
                    if ($resuser != FALSE) {
                        $rowuser = $resuser->fetch();
                        if ($rowuser['name'] != '' && $rowuser['family'] != '') {
                            $username = $rowuser['name'] . ' ' . $rowuser['family'];
                        } else {
                            $username = $rowuser['username'];
                        }
                        $username = htmlspecialchars($username);
                    } else {
                        $username = '';
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
                    } else {
                        $compname = '';
                    }
//                    $userid = $row['userid'];
//                    $resr = $this->model->loadrate($row['id']);
//                    if ($resr) {
//                        $rowrate = $resr->fetch();
//                        $rate = $rowrate['rate'];
//                    } else {
//                        $rate = 0;
//                    }
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
                    $reall.=' ">
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
                                            <img src="' . URL . 'images/icons/score-icon.png"/>
                                            <span>' . $showrate . '</span>
                                        </div>';
                    }
                    $reall.='<a href="' . URL . 'blog/id/' . htmlspecialchars($rowuser['id']) . '">
                                            <div class="details-image1">
                                      <img  class="av" src="' . $vatar . '" />';
                    $len = mb_strlen($row['name']);
                    if ($len != 0) {
                        $reall.=' <span class="pn">' . htmlspecialchars($row['name']) . ' </span>';
                    } else {
                        $reall.='<span class="pn"></span>  ';
                    }
                    $reall.=' </div>
                                </a>
                             </div>';
                    if (Session::get('userid')) {
                        $reall.='  <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">
                             </a>';
                    } else {
                        $reall.='  <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">';
                    }

                    $reall.=' <div class="id none">' . $row['id'] . '</div>
                                 <div class="us none"><a href="' . URL . 'blog/id/' . htmlspecialchars($rowuser['id']) . '" class="userlink" >' . $username . '</a></div>
                                <div class="dt none">' . Shamsidate::jdate('j F Y', $row['date']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['compid'] . '" id="cmp">' . htmlspecialchars($compname) . '</a></div>
                                <div class="rt none">' . $showrate . '</div>
                              <input type="hidden"  id="shorno" value="' . $showstar . '">
                       </div>
                  ';
                    $i++;
                }$this->view->render('gallery/index', $reall, false, 0);
            }
        }
    }

    public function Violation() {
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
                    $this->view->render('adminmethod/index', $data, false, 0);
                } else {       //all field requier
                    $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
                    $data = json_encode($data);
                    $this->view->render('index/index', $data, false, 0);
                }
            } else {       //all field requier
                $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
                $data = json_encode($data);
                $this->view->render('index/index', $data, false, 0);
            }
        } else {
            
        }
    }

}
