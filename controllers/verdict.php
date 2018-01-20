<?php

class verdict extends Controller {

    public $pubcompid;

    function __construct() {
        parent::__construct();
        Useraccess::access_control('isuser', 'index#loginlink', 2);
        $this->pubcompid = 0;
    }

    const TOP = 12;

    public function index() {
        $this->loadsubjectcomp();
        $this->loaddata();
        $this->view->render('verdict/index', $this->data);
    }

    public function loaddata() {

//        if ($this->pubcompid != 0) {
        $this->data['[VARTHISCOMPIMG]'] = '';
        $this->data['[VARIMAGECOUNT]'] = '';
        $this->data['[VARGALIMAGESFOLDER]'] = URL . 'images/gallery/origsize/';
        //
        $resimg = $this->model->imageofcomp($this->pubcompid);
//        $resimg = $this->model->imageofcomp(47);
        if ($resimg != FALSE) {
//            $forcnt = $this->model->allimageofcomp(47);
            $forcnt = $this->model->allimageofcomp($this->pubcompid);
            $cnt = $forcnt->rowCount();
            $numofpage = ceil($cnt / 24);
            $this->data['[VARIMAGECOUNT]'] = $numofpage;
            $i = 1;
            while ($rowimg = $resimg->fetch()) {
                $resuser = $this->model->loadusername($rowimg['userid']);
                if ($resuser != FALSE) {
                    $rowuser = $resuser->fetch();
                    if ($rowuser['name'] != '' && $rowuser['family'] != '') {
                        $username = htmlspecialchars($rowuser['name'] . ' ' . $rowuser['family']);
                    } else {
                        $username = htmlspecialchars($rowuser['username']);
                    }

//                        $username = $rowuser['name'] . ' ' . $rowuser['family'];
//                        $username = htmlspecialchars($username);
                    if ($rowuser['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $rowuser['id']) . '.jpg';
                        $vatar = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $vatar = URL . '/images/avatar/' . $imgname;
                    }
                } else {
                    $username = '';
                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                    $vatar = URL . '/images/avatar/' . $imgname;
                }


                //select rate
                $resrate = $this->model->loadrate(Session::get('userid'), $rowimg['id']);
                if ($resrate != FALSE) {
                    $rowrate = $resrate->fetch();
                    if ($rowrate['issize'] == 1) {
                        $imgrate =0;
                        $issize = $rowrate['issize'];
                        $cls = 'none';
                    } else {
                        $imgrate = $rowrate['rate'];
                        $issize = $rowrate['issize'];
                        $cls = 'show';
                    }
                } else {
                    $imgrate = 0;
                    $issize = 0;
                    $cls = 'none';
                }

                $imgname = Utilities::imgname('origsize', $rowimg['id']) . '.jpg';
                $thmname = Utilities::imgname('thumb', $rowimg['id']) . '.jpg';
                $this->data['[VARTHISCOMPIMG]'].='<div class="brick">
                                <div class="image-head">
                                <div class="score-image1">
                                <div class="id none">' . $rowimg['id'] . '</div>
                                <div class="issize none">' . $issize . '</div>
                                <div class="adr none">' . $imgname . '</div>
                                <img src="' . URL . 'images/icons/score-icon.png"  />
                                <span class="rt ' . $cls . '">' . $imgrate . '</span>
                                </div>
                                <a href="#">
                                <div class="details-image1">
                                <span class="image-name">' . htmlspecialchars($rowimg['name']) . '</span>
                                </div>
                                </a>
                                </div>
                                <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="image-indexing" src="' . URL . 'images/gallery/thumb/' . $thmname . '?' . $i . '" width="100%">
                                </a>
                                <div class="details-usering">
                                <img src="' . $vatar . '" />
                                <span>' . $username . '</span>
                               </div>
                               <div class="details-calendaring">
                               <span class="glyphicon glyphicon-calendar"></span>
                               <span>' . Shamsidate::jdate('j F Y', $rowimg['date']) . '</span>
                            </div>
                        </div>';
                $i++;
            }
        }
//        }
    }

    public function checkissize() {
//        $inf = json_decode($_POST['inf']);
        $fields = array('idimgrate', 'datasize');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                if ($_POST['datasize'] == 1) {
                    $res = $this->model->select(Session::get('userid'), $_POST['idimgrate']);
                    if ($res != FALSE) {

                        $this->model->uprate(Session::get('userid'), $_POST['idimgrate']);
                        $this->view->render('verdict/index', 1, false, 0);
//            }  elseif($_POST['datasize']==0) {
//                 $this->model->upnewrate(Session::get('userid'), $_POST['idimgrat'],$_POST['rt']);
//            }
                    } else {
                        $this->model->savesrart(Session::get('userid'), $_POST['idimgrate']);
                    }
                }
            }
        }
    }

    public function saverate() {
        $fields = array('id', 'rate');
        $sumrate = 0;
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                //select rate
                $resrate = $this->model->loadrate(Session::get('userid'), $_POST['id']);
                if ($resrate != FALSE) {
                    $this->model->updaterate(Session::get('userid'), $_POST['id'], $_POST['rate']);
                } else {
                    $this->model->saverate(Session::get('userid'), $_POST['id'], $_POST['rate']);
                }
                $resuser = $this->model->seluser($_POST['id']);
                if ($resuser) {
                    $cnt = $resuser->rowCount();
                    while ($row = $resuser->fetch()) {
                        $sumrate+= $row['rate'];
                        $refrate = ($sumrate / $cnt);
                        $ref = round($refrate, 2);
                        $this->model->uprefate($_POST['id'], $ref);
                    }
                }
                $data = array('msg' => $ref);
                $data = json_encode($data);
                $this->view->render('verdict/index', $data, false, 0);
            }
        }
    }

    public function loadcompdata() {
        $fields = array('id');
        $THISCOMPIMG = '';
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                $cond = 'id=:id';
                $condata = array('id' => $_POST['id']);
                $res = $this->model->checkcomps($cond, $condata);
                Session::set('compid', $_POST['id']);
                if ($res != FALSE) {

                    while ($row = $res->fetch()) {
                        $cond = 'confirm=1 AND compid=:compid Limit ' . self::TOP;
                        $condata = array('compid' => $row['id']);
                        $resimg = $this->model->imageofcomps($cond, $condata);
                        if ($resimg != FALSE) {
//                            $forcnt = $this->model->allimageofcomp($row['id']);
////                            $cnt = $forcnt->rowCount();
////                            $numofpage = ceil($cnt / 24);
////                            $IMAGECOUNT = $numofpage;
                            $i = 1;
                            while ($rowimg = $resimg->fetch()) {
                                $resuser = $this->model->loadusername($rowimg['userid']);
                                if ($resuser != FALSE) {
                                    $rowuser = $resuser->fetch();
                                    $username = $rowuser['name'] . ' ' . $rowuser['family'];
                                    $username = htmlspecialchars($username);
                                    if ($rowuser['isavatar'] == 1) {
                                        $imgname = Utilities::imgname('avatar', $rowuser['id']) . '.jpg';
                                        $vatar = URL . '/images/avatar/' . $imgname;
                                    } else {
                                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                                        $vatar = URL . '/images/avatar/' . $imgname;
                                    }
                                } else {
                                    $username = '';
                                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                                    $vatar = URL . '/images/avatar/' . $imgname;
                                }


                                //select rate
                                $resrate = $this->model->loadrate(Session::get('userid'), $rowimg['id']);
                                if ($resrate != FALSE) {
                                    $rowrate = $resrate->fetch();
                                    $imgrate = $rowrate['rate'];
                                    $issize = $rowrate['issize'];
                                } else {
                                    $imgrate = 0;
                                    $issize = 0;
                                }

                                $imgname = Utilities::imgname('origsize', $rowimg['id']) . '.jpg';
                                $thmname = Utilities::imgname('thumb', $rowimg['id']) . '.jpg';
                                $THISCOMPIMG.='<div class="brick">
                                <div class="image-head">
                                <div class="score-image1">
                                <div class="id none">' . $rowimg['id'] . '</div>
                                <div class="issize none">' . $issize . '</div>
                                <div class="adr none">' . $imgname . '</div>
                                <img src="' . URL . 'images/icons/score-icon.png" />
                                <span class="rt">' . $imgrate . '</span>
                                </div>
                                <a href="#">
                                <div class="details-image1">
                                <span class="image-name">نام عکس:' . htmlspecialchars($rowimg['name']) . '</span>
                                </div>
                                </a>
                                </div>
                                <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="image-indexing" src="' . URL . 'images/gallery/thumb/' . $thmname . '?' . $i . '" width="100%">
                                </a>
                                <div class="details-usering">
                                <img src="' . $vatar . '" />
                                <span>' . $username . '</span>
                               </div>
                               <div class="details-calendaring">
                               <span class="glyphicon glyphicon-calendar"></span>
                               <span>' . Shamsidate::jdate('j F Y', $rowimg['date']) . '</span>
                            </div>
                        </div>';
                                $i++;
                            }
                        }
                    }
                }
            }
        }
        $data = array('images' => $THISCOMPIMG);
        $data = json_encode($data);
        $this->view->render('verdict/index', $data, false, 0);
    }

    public function loadcompg() {
        $THISCOMPIMG = '';
        if (isset($_POST['pid'])) {
            $cond = 'id=:id';
            $condata = array('id' => Session::get('compid'));
            $res = $this->model->checkcomps($cond, $condata);
            if ($res != FALSE) {
                while ($row = $res->fetch()) {
                    $condata = array();
                    $cond = 'confirm=1 AND compid=:compid';
                    $lmt = self::TOP * ($_POST['pid'] - 1);
                    $cond .= ' Limit :lmt ,:top ';
                    $condata['lmt'] = $lmt;
                    $condata['top'] = self::TOP;
                    $condata['compid'] = $row['id'];

                    $resimg = $this->model->imageofcomps($cond, $condata);
                    if ($resimg != FALSE) {
                        $i = 1;
                        while ($rowimg = $resimg->fetch()) {
                            $resuser = $this->model->loadusername($rowimg['userid']);
                            if ($resuser != FALSE) {
                                $rowuser = $resuser->fetch();
                                $username = $rowuser['name'] . ' ' . $rowuser['family'];
                                $username = htmlspecialchars($username);
                                if ($rowuser['isavatar'] == 1) {
                                    $imgname = Utilities::imgname('avatar', $rowuser['id']) . '.jpg';
                                    $vatar = URL . '/images/avatar/' . $imgname;
                                } else {
                                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                                    $vatar = URL . '/images/avatar/' . $imgname;
                                }
                            } else {
                                $username = '';
                                $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                                $vatar = URL . '/images/avatar/' . $imgname;
                            }


                            //select rate
                            $resrate = $this->model->loadrate(Session::get('userid'), $rowimg['id']);
                            if ($resrate != FALSE) {
                                $rowrate = $resrate->fetch();
                                $imgrate = $rowrate['rate'];
                                $issize = $rowrate['issize'];
                                $cls = 'show';
                            } else {
                                $imgrate = 0;
                                $issize = 0;
                                $cls = 'none';
                            }

                            $imgname = Utilities::imgname('origsize', $rowimg['id']) . '.jpg';
                            $thmname = Utilities::imgname('thumb', $rowimg['id']) . '.jpg';
                            $THISCOMPIMG.='<div class="brick">
                                <div class="image-head">
                                <div class="score-image1">
                                <div class="id none">' . $rowimg['id'] . '</div>
                                <div class="issize none">' . $issize . '</div>
                                <div class="adr none">' . $imgname . '</div>
                                <img src="' . URL . 'images/icons/score-icon.png" />
                                <span class="rt ' . $cls . '">' . $imgrate . '</span>
                                </div>
                                <a href="#">
                                <div class="details-image1">
                                <span class="image-name">نام عکس:' . htmlspecialchars($rowimg['name']) . '</span>
                                </div>
                                </a>
                                </div>
                                <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="image-indexing" src="' . URL . 'images/gallery/thumb/' . $thmname . '?' . $i . '" width="100%">
                                </a>
                                <div class="details-usering">
                                <img src="' . $vatar . '" />
                                <span>' . $username . '</span>
                               </div>
                               <div class="details-calendaring">
                               <span class="glyphicon glyphicon-calendar"></span>
                               <span>' . Shamsidate::jdate('j F Y', $rowimg['date']) . '</span>
                            </div>
                        </div>';
                            $i++;
                        }
                    }
                }
            }
            $this->view->render('verdict/index', $THISCOMPIMG, false, 0);
        }
    }

    public function loadsubjectcomp() {
//           echo '12';
        $userid = Session::get('userid');
        $result = $this->model->loadsubjectcomp($userid);
        if ($result) {

            $res = $result->rowCount();
            $this->data['[VARCOMPNAME]'] = '<label>انتخاب مسابقه</label><select id="competition" name="competition"  class="form-control" onchange="changeCompatition(this.value)">';
            if ($res == 1) {
                $row = $result->fetch();
                $this->pubcompid = $row['cid'];
                $this->data['[VARCOMPNAME]'] = '<h5>' . $row['cname'] . '</h5>';
            } else {
                while ($row = $result->fetch()) {
                    if ($this->pubcompid == 0) {
                        $this->pubcompid = $row['cid'];
                        $this->data['[VARCOMPINFO]'] = htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['cdecription']));
                    }
                    $this->data['[VARCOMPNAME]'] .= '
                    <option value="' . $row['cid'] . '">' . $row['cname'] . '</option>';
                }
                $this->data['[VARCOMPNAME]'] .='</select>';
            }
        }
    }

    public function download() {
        if (isset($_POST['inf'])) {
            $imgname = Utilities::imgname('origsize', $_POST['inf']) . '.jpg';
            $data = array('images' => '"' . URL . 'images/gallery/origsize/' . $imgname . '"');
            $data = json_encode($data);
            $this->view->render('verdict/index', $data, false, 0);
        }
    }

}
