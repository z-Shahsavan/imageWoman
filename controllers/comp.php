<?php

class comp extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->data['[VARHIDEVIDEO]'] = 'hidden';
        header('location:' . URL . 'gallery');
    }

    const Top1 = 12;

    public function id($id) {
        $this->data['[VARHIDEVIDEO]'] = 'hidden';
        $reall = '';
        Session::set('a', 1);
        Session::set('idcomps', $id);
        $ispeople = 0;
        if (strcmp($id, '') != 0 && is_numeric($id)) {
            $res = $this->model->subjectinfo($id);
            if ($res != FALSE) {
                $row = $res->fetch();
                $this->data['[VARGALIMAGESFOLDER]'] = URL . 'prize/image/';
                $this->data['[VARSUBJECTNAME]'] = htmlspecialchars($row['name']);
                $this->data['[VARTHISSUBID]'] = $row['id'];
                $this->data['[VARTHISCOMPDESC]'] = AntiXSS::clean_up(str_replace(PHP_EOL, '<br>', $row['decription']));
                if ($row['isopen'] == 1) {
                    $this->data['[VARPGHEADER]'] = '<div class="bg-grr">
                            <div class="uploadbtn-new ">
                                <a style="font-size: 20px;padding: 15px 30px;background-color: #F4F6F4;border-radius: 40px;" class="waves-effect waves-light btn  purple lighten-1" href="' . URL . 'upload#id' . $row['id'] . '">آپلود عکس</a>
                            </div>
                            <div class="left-section-head">
                                <div class="start-match">
                                    <div class="text-end"><span>تاریخ شروع</span></div>
                                    <div class="result-start-match">
                                        <span>' . Shamsidate::jdate('j F Y', $row['startdate']) . '</span>
                                        <div class="triangle-image"></div>
                                        <div class="triangle-image2"></div>
                                    </div>
                                </div>
                                <div class="end-match">
                                    <div class="text-end"><span>تاریخ پایان</span></div>
                                    <div class="result-end-match">
                                        <span>' . Shamsidate::jdate('j F Y', $row['enddate']) . '</span>
                                        <div class="triangle-image"></div>
                                        <div class="triangle-image2"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="right-section-head">
                                <div class="bg-level"><span class="image-level">
                                    <img src="[VARURL]images/icons/level.png"/>
                                        <span class="text-level">سطح مسابقه</span>
                                        <span class="result-level">' . htmlspecialchars($row['level']) . '</span>
                                </div>
                                <div class="bg-camera"><span class="camera-level">
                                    <img src="[VARURL]images/icons/camera.png"/>
                                    <span class="text-camera">تعداد عکس های ارسالی</span>
                                    <span class="result-camera">' . htmlspecialchars($row['numofpic']) . '</span>
                                </div>
                            </div></div>';
                } else {
                    $this->data['[VARPGHEADER]'] = '<div class="bg-grr">
                            <div class="left-section-head">
                                <div class="start-match">
                                    <div class="text-end"><span>تاریخ شروع</span></div>
                                    <div class="result-start-match">
                                        <span>' . Shamsidate::jdate('j F Y', $row['startdate']) . '</span>
                                        <div class="triangle-image"></div>
                                        <div class="triangle-image2"></div>
                                    </div>
                                </div>
                                <div class="end-match">
                                    <div class="text-end"><span>تاریخ پایان</span></div>
                                    <div class="result-end-match">
                                        <span>' . Shamsidate::jdate('j F Y', $row['enddate']) . '</span>
                                        <div class="triangle-image"></div>
                                        <div class="triangle-image2"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="right-section-head">
                                <div class="bg-level"><span class="image-level">
                                    <img src="[VARURL]images/icons/level.png"/>
                                        <span class="text-level">سطح مسابقه</span>
                                        <span class="result-level">' . htmlspecialchars($row['level']) . '</span>
                                </div>
                                <div class="bg-camera"><span class="camera-level">
                                    <img src="[VARURL]images/icons/camera.png"/>
                                    <span class="text-camera">تعداد عکس های ارسالی</span>
                                    <span class="result-camera">' . htmlspecialchars($row['numofpic']) . '</span>
                                </div>
                            </div>
                            </div>';
                }


                if ($row['isopen'] == 3) {
                    $vazemos = 2;
                    $this->data['[VARHEADBARANDE]'] = '<div class="col-md-2 col-sm-2 col-xs-6" >
                        <div class="circle-border">
                            <div id="winner" class="filter">
                                <a>برندگان </a>
                                <div class="line-select"></div>
                            </div>
                        </div>
                    </div>';
                    $this->data['[VARHEADPRICE]'] = '<div class="col-md-2 col-md-offset-1 col-sm-2 col-sm-offset-1 col-xs-6" >
                        <div class="circle-border">
                            <div id="prices" class="filter">
                                <a>اهدای جوایز</a>
                                <div class="line-select"></div>
                            </div>
                        </div>
                    </div>';
                } else {
                    $this->data['[VARHEADBARANDE]'] = '';
                    $this->data['[VARHEADPRICE]'] = '';
                }
            } else {
                header('location:' . URL . 'gallery');
            }
            $this->data['[VARGALIMAGES]'] = '';
            $this->data['[VARIMAGECOUNT]'] = '';
            $this->data['[VARITEMRATE]'] = '';

//check is user
            if (Session::get('isuser') != FALSE) {
                $this->data['[VARHIDDEN]'] = 'none';
            } else {
                $this->data['[VARHIDDEN]'] = '';
            }
//count of image

            $cnt = $row['numofpic'];

            $numofpage = ceil($cnt / self::Top1);
            $this->data['[VARIMAGECOUNT]'] = $numofpage;
//load all image
            $cond = 'confirm=1 AND compid=:compid ';
            Session::set('cond', $cond);
            $cond.='ORDER BY pid DESC Limit ' . self::Top1;
            $condata = array('compid' => $id);
            Session::set('condata', $condata);
            Session::set('cattab', 'allpic');
            Session::set('count', $cnt);
            $res = $this->model->loadimagesforgall($cond, $condata);
            if ($res != FALSE) {
                while ($row = $res->fetch()) {
                    $showrate = 0;
                    if ((time() - (48 * 3600)) < $row['enddate']) {
                        $showstar = 1;
                    } else {
                        $showstar = 0;
                    }
                    if ($row['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                        $vatar = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $vatar = URL . '/images/avatar/' . $imgname;
                    }
                    $imgname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                    $thmname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                    $ispeople = '';
                    if ($row['peopelwinno'] != 0) {
                        $ispeople = 1;
                    }

                    if (((time() - (48 * 3600)) < $row['enddate'])) {
                        $this->data['[VARITEMRATE]'] = 'show';
                    } else {
                        $this->data['[VARITEMRATE]'] = 'none';
                    }//az inja
//                    $this->data['[VARGALIMAGES]'] .= '<a>
//                        <div class="mix populer';
//                    if (Session::get('userid')) {
//                        $this->data['[VARGALIMAGES]'] .=' isusermix';
//                    }
                    if ($row['uname'] != '' && $row['uf'] != '') {
                        $username = htmlspecialchars($row['uname'] . ' ' . $row['uf']);
                    } else {
                        $username = htmlspecialchars($row['username']);
                    }
                    $reall.=' <div  class="brick';
                    if (Session::get('userid')) {
                        $reall.=' isusermix';
                    }
                    $reall.='">
                    <input type="hidden" name="idpic" id="idpic" value="' . $row['pid'] . '">
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
                    $reall.='<a href="' . URL . 'blog/id/' . $row['userid'] . '">
                                      <div class="details-image1">
                                      <img  class="av" src="' . $vatar . '" />';
                    $len = mb_strlen($row['pn']);
                    if ($len != 0) {
                        $reall.=' <span class="pn">' . htmlspecialchars($row['pn']) . ' </span>';
                    } else {
                        $reall.=' <span class="pn"></span>';
                    }
                    $reall.=' </div>
                                </a>
                             </div>';
                    $i = 0;
                    if (Session::get('userid')) {
                        $reall.='  <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">
                             </a>';
                    } else {
                        $reall.='  <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">';
                    }

                    $reall.=' <div class="id none" >' . $row['pid'] . '</div>
                                 <div class="us none"><a href="' . URL . 'blog/id/' . $row['userid'] . '" class="userlink" >' . $username . '</a></div>
                                <div class="dt none">' . Shamsidate::jdate('j F Y', $row['pdate']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['pcmt'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['compid'] . '" id="cmp">' . htmlspecialchars($row['cname']) . '</a></div>
                                <div class="rt none">' . $showrate . '</div>
                              <input type="hidden"  id="shorno" value="' . $showstar . '">
                       </div>';
                    $i++;
                }
            }
            $this->data['[VARGALIMAGES]'] = $reall;
            $this->view->render('comp/index', $this->data);
        } else {
            header('location:' . URL . 'gallery');
        }
    }

    public function loadphoto() {
        $this->data['[VARHIDEVIDEO]'] = 'hidden';
        $resall = '';
        $ispeople = 0;
        $a = 0;
        if (isset($_POST['data'])) {
            switch ($_POST['data']) {
                case 'allpic': {
                        $a = 2;
                        Session::set('cattab', 'allpic');
                        $cond = 'confirm=1 AND compid=:compid ';
                        Session::set('cond', $cond);
                        break;
                    }
                case 'davari': {
                        Session::set('cattab', 'davari');
                        Session::set('numoffetch', 0);
                        $this->picfordav();
                        return;
                        break;
                    }
                case 'davarsel': {
                        Session::set('cattab', 'davarsel');
                        $cond = 'confirm=1 AND (iswin=2 OR iswin=5) AND compid=:compid ';
                        Session::set('cond', $cond);
                        break;
                    }
                case 'winner': {
                        Session::set('cattab', 'winner');
                        $this->winner();
                        return;
                        break;
                    }
                case 'prices': {
                        Session::set('cattab', 'prices');
                        $this->prize();
                        return;
                        break;
                    }
                default:
                    Session::set('cattab', 'allpic');
                    $cond = 'confirm=1 AND compid=:compid ';
                    Session::set('cond', $cond);
                    break;
            }
        }
        if (Session::get('cattab') == 'davarsel') {
            $endcomp = 1;
        } else {
            $endcomp = 0;
        }
        $cond.=' ORDER BY pid DESC Limit ' . self::Top1;
        $condata = array('compid' => Session::get('idcomps'));
        Session::set('condata', $condata);
        $res = $this->model->loadimagesforgall($cond, $condata); //echo Session::get('idcomps');
        if ($res != FALSE) {
            $reall = '';
            while ($row = $res->fetch()) {
                $showrate = 0;
                $cond = 'imgid=:imgid ORDER BY wintype ASC';
                $condata = array('imgid' => $row['pid']);
                $resjayeze = $this->model->loadjayeze($cond, $condata);
                $jayeze = '<br>جوایز:<br>';
                if ($resjayeze != FALSE) {
                    while ($rowjayeze = $resjayeze->fetch()) {
                        $jayeze.=$rowjayeze['price'] . '<br>';
                    }
                }
                if ($row['isavatar'] == 1) {
                    $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                    $vatar = URL . '/images/avatar/' . $imgname;
                } else {
                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                    $vatar = URL . '/images/avatar/' . $imgname;
                }
                $imgname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                $thmname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                $resokbz = $this->model->loadisok($row['pid']);
                $ispeople = '';
                if ($row['peopelwinno'] != 0) {
                    $ispeople = 1;
                }
                if (((time() - (48 * 3600)) < $row['enddate']) && $a == 2) {
                    $ratemar = 1;
                } else {
                    $ratemar = 0;
                }
                $userid = $row['userid'];
//                $resr = $this->model->loadrate($row['pid'], $userid);
//                if ($resr) {
//                    $rowrate = $resr->fetch();
//                    $rate = $rowrate['rate'];
//                } else {
//                    $rate = 0;
//                }
//                $resall .= '<a><div class="mix populer';
//                if (Session::get('userid')) {
//                    $resall.=' isusermix';
//                }
                if ((time() - (48 * 3600)) < $row['enddate']) {
                    $showstar = 1;
                } else {
                    $showstar = 0;
                }
                if ($row['uname'] != '' && $row['uf'] != '') {
                    $username = htmlspecialchars($row['uname'] . ' ' . $row['uf']);
                } else {
                    $username = htmlspecialchars($row['username']);
                }
                $reall.=' <div  class="brick';
                if (Session::get('userid')) {
                    $reall.=' isusermix';
                }
                $reall.=' ">
                    <input type="hidden" name="idpic" id="idpic" value="' . $row['pid'] . '">
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
                $reall.='<a href="' . URL . 'blog/id/' . $row['userid'] . '">
                                            <div class="details-image1">
                                      <img  class="av" src="' . $vatar . '" />';
                $len = mb_strlen($row['pn']);
                if ($len != 0) {
                    $reall.=' <span class="pn">' . htmlspecialchars($row['pn']) . ' </span>';
                } else {
                    $reall.=' <span class="pn"></span>';
                }
                $reall.=' </div>
                                </a>
                             </div>';
                $i = 0; //echo Session::get('userid');
                if (Session::get('userid')) {
                    $reall.='  <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">
                             </a>';
                } else {
                    $reall.='  <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">';
                }

                $reall.=' <div class="id none">' . $row['pid'] . '</div>
                                <div class="us none"><a href="' . URL . 'blog/id/' . $row['userid'] . '" class="userlink" >' . $username . '</a></div>
                                <div class="dt none">' . Shamsidate::jdate('j F Y', $row['pdate']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['pcmt'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['compid'] . '" id="cmp">' . htmlspecialchars($row['cname']) . '</a></div>
                                <div class="rt none">' . $showrate . '</div>
                              <input type="hidden"  id="shorno" value="' . $showstar . '">
                       </div>';
                $i++;
            }
            $data = array('msg' => $reall, 'win' => '', 'rate' => $ratemar, 'endcomp' => $endcomp);
            $data = json_encode($data);
            $this->view->render('comp/index', $data, false, 0);
        };
    }

    private function picfordav($more = NULL) {
        $ratemar = '';
        $resdavar = '';
        $cnt = Session::get('count');
        $start = Session::get('numoffetch');
        $cond = 'id=:id';
        $condata = array('id' => Session::get('idcomps'));
        $result = $this->model->selisopen($cond, $condata);
        if ($result) {
            $row = $result->fetch();
            if ($row['isopen'] == 3) {
                if ($more) {
                    $cond = 'confirm=1 AND compid=:compid  ORDER BY pid DESC Limit ' . $start . ' , ' . $cnt;
                    $condata = array('compid' => Session::get('idcomps'));
                } else {
                    $cond = 'confirm=1 AND compid=:compid  ORDER BY pid DESC ';
                    $condata = array('compid' => Session::get('idcomps'));
                }
            } elseif ($row['isopen'] == 2) {
                if ($more) {
                    $cond = 'confirm=1 AND compid=:compid AND enddate<' . (time() - 24 * 3600) . ' AND ' . (time() - 48 * 3600) . '<enddate ORDER BY pid DESC Limit ' . $start . ' , ' . $cnt;
                    $condata = array('compid' => Session::get('idcomps'));
                } else {
                    $cond = 'confirm=1 AND compid=:compid AND enddate<' . (time() - 24 * 3600) . ' AND ' . (time() - 48 * 3600) . '<enddate ORDER BY pid DESC ';
                    $condata = array('compid' => Session::get('idcomps'));
                }
            }
        }
        $res = $this->model->loadimagesfordavs($cond, $condata);
        $reall = '';
        if ($res) {
            $i = 0;
            $c = 0;
            while ($row = $res->fetch()) {
                $showrate = 0;
                if ((time() - (48 * 3600)) < $row['enddate']) {
                    $showstar = 1;
                } else {
                    $showstar = 0;
                }
                if ($i >= self::Top1) {
                    break;
                }
                $c++;
                if ($more) {
                    $lmt = self::Top1 * ($more - 1);
                    $cond = 'imgid=:imgid AND isok=:isok ORDER BY imgid ORDER BY imgid DESC Limit ' . $lmt . ' , ' . self::Top1;
                    $condata = array('imgid' => $row['pid'], 'isok' => 1);
                } else {
                    $cond = 'imgid=:imgid AND isok=:isok ORDER BY imgid DESC Limit ' . self::Top1;
                    $condata = array('imgid' => $row['pid'], 'isok' => 1);
                }
                $resokbz = $this->model->loadisok($row['pid']);
                if ($resokbz) {
                    $rowisok = $resokbz->fetch();
                    $ispeople = '';
                    if ($row['peopelwinno'] != 0) {
                        $ispeople = 1;
                    }
                    if (((time() - (48 * 3600)) < $row['enddate'])) {
                        $ratemar = 1;
                    } else {
                        $ratemar = 0;
                    }
                    $userid = $row['userid'];
//                    $resr = $this->model->loadrate($row['pid']);
//                    if ($resr) {
//                        $rowrate = $resr->fetch();
//                        $rate = $rowrate['rate'];
//                    } else {
//                        $rate = 0;
//                    }
                    if ($row['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                        $vatar = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $vatar = URL . '/images/avatar/' . $imgname;
                    }
                    $imgname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                    $thmname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                    if (Session::get('userid')) {
                        $resdavar .=' isusermix';
                    }
                    if ($row['uname'] != '' && $row['uf'] != '') {
                        $usname = htmlspecialchars($row['uname'] . ' ' . $row['uf']);
                    } else {
                        $usname = htmlspecialchars($row['username']);
                    }
                    $reall.=' <div  class="brick';
                    if (Session::get('userid')) {
                        $reall.=' isusermix';
                    }
                    $reall.=' ">
                    <input type="hidden" name="idpic" id="idpic" value="' . $row['pid'] . '">
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
                                            <span>' . $showrate . '</span>
                                        </div>';
                    }
                    $reall.='<a href="' . URL . 'blog/id/' . $row['userid'] . '">
                                            <div class="details-image1">
                                      <img class="av" src="' . $vatar . '"  style="width:35px;height:35px;"/>';
                    $len = mb_strlen($row['pn']);
                    if ($len != 0) {
                        $reall.=' <span class="pn">' . htmlspecialchars($row['pn']) . ' </span>';
                    } else {
                        $reall.=' <span class="pn"></span>';
                    }
                    $reall.=' </div>
                                </a>
                             </div>';
                    $i = 0;
                    if (Session::get('userid')) {
                        $reall.='  <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">
                             </a>';
                    } else {
                        $reall.='  <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">';
                    }

                    $reall.=' <div class="id none">' . $row['pid'] . '</div>
                                 <div class="us none"><a href="' . URL . 'blog/id/' . $row['userid'] . '" class="userlink" >' . $usname . '</a></div>
                                <div class="dt none">' . Shamsidate::jdate('j F Y', $row['pdate']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['pcmt'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['compid'] . '" id="cmp">' . htmlspecialchars($row['cname']) . '</a></div>
                                <div class="rt none">' . $showrate . '</div>
                              <input type="hidden"  id="shorno" value="' . $showstar . '">
                       </div>';
                    $i++;
                }
            }Session::set('numoffetch', $c + Session::get('numoffetch'));
            $data = array('msg' => $reall, 'win' => '', 'rate' => $ratemar, 'endcomp' => 0);
            $data = json_encode($data);
            $this->view->render('comp/index', $data, false, 0);
        }
    }

    private function prize($more = NULL) {
        $res = $this->model->prizes('cmpid=:cid order by type', array('cid' => Session::get('idcomps')));
        if ($res) {
            $row = $res->fetch();
            $vid = '';
            $imgs = '';
            $text = '<p>' . $row['comment'] . '</p>';
            $c612 = 12;
            $i = 0;
            do {
                if ($row['type'] == 1) {
                    $srcvid = Utilities::imgname('film', $row['pfid']) . '.mp4';
                    $vid = '<div class="video-gallery col-xs-12 col-md-6">
                    <video width="100%" controls>
                        <source src="' . URL . '/prize/film/' . $srcvid . '" type="video/mp4">
                    </video>
                </div>';
                    $c612 = 6;
                }
                if ($row['type'] == 0) {
                    $imgname = Utilities::imgname('image', $row['pfid']) . '.jpg' . '?' . $i;
                    $srcimg = Utilities::imgname('thumb', $row['pfid']) . '.jpg';
                    $imgs .= '<div class="mix populer isusermix2 brick openprizemodal" data-toggle="modal" data-target="#prizeModal1" data-iswin="0" style="display: inline-block;">
                <a>
                    <div class="inner">
                        <img class="bgimg" src="' . URL . 'prize/thumb/' . $srcimg . '">
                    </div>
                </a>
                <div data-toggle="modal" data-target="#prizeModal" class="cnt">
                      <div class="adr">' . $imgname . '</div>
                </div>
            </div>';
//            <!-- prizeModal -->
//                <div id="prizeModal1" class="modal fade" role="dialog">
//                  <div class="modal-dialog modal-lg width100">
//                    <div class="modal-content hidepromodal">
//                      <div class="modal-header bordernone">
//                        <button type="button" class="close opacity8 fontsize44 floatright" data-dismiss="modal"><span class="colorf glyphicon glyphicon-remove"></span></button>
//                      </div>
//                      <div class="modal-body">
//                        <img src="' . URL . 'prize/image/' . $imgname . '" />
//                      </div>
//                    </div>
//                  </div>
//                </div>';
                }
                $i++;
            } while ($row = $res->fetch());
//            $prize = '<div class="one-section col-xs-12 col-md-12">'
//                    . '<div class="text-gallery col-xs-12 col-md-' . $c612 . '">' . $text . ' </div>'
//                    . $vid .
//                    '</div>' . $imgs;
            $hidddddvid='<div class="text-gallery col-xs-12 col-md-' . $c612 . '">' . $text . ' </div>'. $vid ;
            $prize = $imgs;
            $this->view->render('comp/index', json_encode(array('msg' => $prize,'hidddddvid'=>$hidddddvid)), false, 0);
        } else {
            $this->view->render('comp/index', json_encode(array('msg' => '')), false, 0);
        }
    }

    private function winner($more = NULL) {
        $reswinner = '';
        $winnertype = '<h6 class="winner teal-text text-lighten-1"></h6>';
        if ($more) {
            $lmt = self::Top1 * ($more - 1);
            $cond = 'confirm=1 AND compid=:compid AND(iswin=1 OR iswin=3 OR iswin=4) ORDER BY pid DESC Limit ' . $lmt . ' , ' . self::Top1;
        } else {
            $cond = 'confirm=1 AND compid=:compid AND iswin=1 OR iswin=3 OR iswin=4 ORDER BY pid DESC Limit ' . self::Top1;
        }
        $condata = array('compid' => Session::get('idcomps'));
        $res = $this->model->loadimagesforgall($cond, $condata);
        if ($res != FALSE) {
            $reall = '';
            while ($row = $res->fetch()) {
                $cond = 'imgid=:imgid ORDER BY wintype ASC';
                $condata = array('imgid' => $row['pid']);
                $resjayeze = $this->model->loadjayeze($cond, $condata);
                $jayeze = '<br>جوایز:';
                $jayezearray = array();
                $i = 0;
                if ($resjayeze != FALSE) {
                    while ($rowjayeze = $resjayeze->fetch()) {
                        $jayeze.=$rowjayeze['price'] . '<br>';
                        $jayezearray[$i] = $rowjayeze['rate'];
                        $i++;
                    }
                }
                switch ($row['iswin']) {
                    case 1:

                        $win = 'برنده داوری رتبه:' . $jayezearray[0];
                        break;
                    case 3:
                        $win = 'برنده مردمی';

                        break;
                    case 4:
                        $win = 'برنده داوری رتبه:' . $jayezearray[0] . ' -برنده مردمی';

                        break;
                }
                $win.=$jayeze;
                if ($row['isavatar'] == 1) {
                    $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                    $vatar = URL . '/images/avatar/' . $imgname;
                } else {
                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                    $vatar = URL . '/images/avatar/' . $imgname;
                }
                $imgname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                $thmname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                if ($row['uname'] != '' && $row['uf'] != '') {
                    $username = htmlspecialchars($row['uname'] . ' ' . $row['uf']);
                } else {
                    $username = htmlspecialchars($row['username']);
                }
                $reall.=' <div  class="brick';
                if (Session::get('userid')) {
                    $reall.=' isusermix';
                }
                $reall.=' ">
                    <input type="hidden" name="idpic" id="idpic" value="' . $row['pid'] . '">
                                    <div class="image-head">';
                $reall.='<a href="' . URL . 'blog/id/' . $row['userid'] . '">
                                            <div class="details-image1">
                                      <img class="av" src="' . $vatar . '"  style="width:35px;height:35px;"/>';
                $len = mb_strlen($row['pn']);
                if ($len != 0) {
                    $reall.=' <span class="pn">' . htmlspecialchars($row['pn']) . ' </span>';
                } else {
                    $reall.=' <span class="pn"></span>';
                }
                $reall.=' </div>
                                </a>
                             </div>';
//                    $i = 0;
                if (Session::get('userid')) {
                    $reall.='  <a href="" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">
                             </a>';
                } else {
                    $reall.='  <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">';
                }

                $reall.=' <div class="id none">' . $row['pid'] . '</div>
                                 <div class="us none"><a href="' . URL . 'blog/id/' . $row['userid'] . '" class="userlink" >' . $username . '</a></div>
                                <div class="dt none">' . Shamsidate::jdate('j F Y', $row['pdate']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['pcmt'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['compid'] . '" id="cmp">' . htmlspecialchars($row['cname']) . '</a></div>
                                    <div class="winner none">' . $win . '</div>
                         <input type="hidden"  id="shorno" value="0">
                       </div>';
            }
            $data = array('msg' => $reall, 'win' => $winnertype, 'rate' => 0, 'endcomp' => 2);
            $data = json_encode($data);
            $this->view->render('comp/index', $data, false, 0);
        }
    }

    public function paging() {
        $resall = '';
        $a = 0;
        $ispeople = 0;
        if (isset($_POST['pid'])) {
            $lmt = self::Top1 * ($_POST['pid'] - 1);
            $cattab = Session::get('cattab');
            $idcomp = Session::get('idcomps');
            switch ($cattab) {
                case 'allpic':
                    $a = 2;
                    $cond = Session::get('cond');
                    break;
                case 'davari':
                    $this->picfordav($_POST['pid']);
                    return;
                    break;
                case 'davarsel':
                    $cond = Session::get('cond');
                    break;
                case 'winner':
                    $this->winner($_POST['pid']);
                    return;
                    break;
            }
            $cond .= ' ORDER BY pid DESC Limit ' . $lmt . ',' . self::Top1;
            $condata = Session::get('condata');
            $res = $this->model->loadimagesforgall($cond, $condata);
            $reall = '';
            if ($res != FALSE) {
                while ($row = $res->fetch()) {
                    $showrate = 0;
                    $ispeople = '';
                    if ($row['peopelwinno'] != 0) {
                        $ispeople = 1;
                    }
                    if (((time() - (48 * 3600)) < $row['enddate']) && $a = 2) {
                        $ratemar = 1;
                    } else {
                        $ratemar = 0;
                    }
                    $userid = $row['userid'];
//                    $resr = $this->model->loadrate($row['pid']);
//                    if ($resr) {
//                        $rowrate = $resr->fetch();
//                        $rate = $rowrate['rate'];
//                    } else {
//                        $rate = 0;
//                    }
                    if ($row['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $row['pid']) . '.jpg';
                        $vatar = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $vatar = URL . '/images/avatar/' . $imgname;
                    }
                    $imgname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                    $thmname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                    if ($row['uname'] != '' && $row['uf'] != '') {
                        $username = htmlspecialchars($row['uname'] . ' ' . $row['uf']);
                    } else {
                        $username = htmlspecialchars($row['username']);
                    }
                    if ((time() - (48 * 3600)) < $row['enddate']) {
                        $showstar = 1;
                    } else {
                        $showstar = 0;
                    }
                    $reall.=' <div  class="brick';
                    if (Session::get('userid')) {
                        $reall.=' isusermix';
                    }
                    $reall.=' ">
                    <input type="hidden" name="idpic" id="idpic" value="' . $row['pid'] . '">
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
                                            <span>' . $showrate . '</span>
                                        </div>';
                    }
                    $reall.='<a href="' . URL . 'blog/id/' . $row['userid'] . '">
                                            <div class="details-image1">
                                      <img  class="av" src="' . $vatar . '" />';
                    $len = mb_strlen($row['pn']);
                    if ($len != 0) {
                        $reall.=' <span class="pn">' . htmlspecialchars($row['pn']) . ' </span>';
                    } else {
                        $reall.=' <span class="pn"></span>';
                    }
                    $reall.=' </div>
                                </a>
                             </div>';
                    $i = 0;
                    if (Session::get('userid')) {
                        $reall.='  <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">
                             </a>';
                    } else {
                        $reall.='  <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">';
                    }

                    $reall.=' <div class="id none">' . $row['pid'] . '</div>
                                 <div class="us none"><a href="' . URL . 'blog/id/' . $row['userid'] . '" class="userlink" >' . $username . '</a></div>
                                <div class="dt none">' . Shamsidate::jdate('j F Y', $row['pdate']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['pcmt'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['compid'] . '" id="cmp">' . htmlspecialchars($row['cname']) . '</a></div>
                                <div class="rt none">' . $showrate . '</div>
                              <input type="hidden"  id="shorno" value="' . $showstar . '">
                       </div>';
                    $i++;
                }
                $data = array('msg' => $reall, 'rate' => $ratemar, 'win' => '', 's' => 'bnk', 'endcomp' => 0);
                $data = json_encode($data);
                $this->view->render('comp/index', $data, false, 0);
            }
        }
    }

    public function saverate($a1, $a2) {
        $sumrate = 0;
        $ref = 0;
        $rescomp = $this->model->loadcompid($a1);
        if ($rescomp) {
            $rowcompid = $rescomp->fetch();
            $result = $this->model->loadcomp($rowcompid['compid']);
            if ($result) {
                $rowc = $result->fetch();
                if (((time() - (48 * 3600)) < $rowc['enddate']) && $rowc['peopelwinno'] != 0) {
                    $userid = Session::get('userid');
                    if ($userid != FALSE) {
                        $res = $this->model->selrate($a1, $userid);
                        if ($res) {
                            if (intval($a2) == 0) {
                                $condata = array('pid' => $a1, 'uid' => $userid);
                                $cond = 'pid=:pid AND uid=:uid';
                                $this->model->deluser($cond, $condata);
                            } else {
                                $this->model->uprate($userid, $a1, $a2);
                            }
                        } else {
                            if (intval($a2) != 0) {
                                $data = array('pid' => $a1, 'rate' => $a2, 'uid' => $userid);
                                $this->model->saverate($data);
                            }
                        }
                        $resuser = $this->model->seluser($a1);
                        if ($resuser) {
                            $cnt = $resuser->rowCount();
                            while ($row = $resuser->fetch()) {
                                $sumrate+= $row['rate'];
                                $refrate = ($sumrate / $cnt);
                                $ref = round($refrate, 2);
                                $this->model->uprefate($a1, $ref);
                            }
                        }
                        $data = array('msg' => $ref);
                        $data = json_encode($data);
                        $this->view->render('comp/index', $data, false, 0);
                    }
                }
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
                    $this->view->render('adminmethod/index', $data, false, 0);
                }
            } else {       //all field requier
                $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
                $data = json_encode($data);
                $this->view->render('adminmethod/index', $data, false, 0);
            }
        } else {
            
        }
    }

}
