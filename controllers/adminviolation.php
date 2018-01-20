<?php

class adminviolation extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::access_control('isuser', 'index#loginlink', 4);
    }

    const TOP = 12;

    public function index() {
        $this->data['[VARBIGIMG]'] = 'images/gallery/origsize/';
        $this->published();
        $this->view->render('adminviolation/index', $this->data);
    }

    public function published() {
        $violatcount = $this->model->loadviolateco();
        if ($violatcount != FALSE) {
            $cnt = $violatcount->rowCount();
        } else {
            $cnt = 0;
        }
        Session::set('countpic', $cnt);
        $numofpage = ceil($cnt / self::TOP);
//        $this->data['[VARIMAGECOUNT]'] = $numofpage;
        $list1 = array();
        $list = '';
        $cond = '1 ORDER BY idpic DESC';
        $violat = $this->model->loadviolate($cond);
        $perpicid = 0;
        $gozareshat = '';
        $i = 0;
        if ($violat != FALSE) {
            while ($row = $violat->fetch()) {
                if ($i < self::TOP) {
                    if ($row['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                        $thmname = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $thmname = URL . '/images/avatar/' . $imgname;
                    }
                    $img2 = Utilities::imgname('thumb', $row['idpic']) . '.jpg';
                    if ($perpicid != $row['idpic']) {
                        if ($perpicid != 0) {
                            $list.=$list1[$perpicid];
                        }
                        $perpicid = $row['idpic'];
                        $list1[$perpicid] = '';
                        $gozareshat = '<h3 class="sbj hd">نام مسابقه : <span>' . htmlspecialchars($row['cname']) . '</span></h3><img class="av" src="' . $thmname . '">';
                        if (mb_strlen($row['name']) == 0 || mb_strlen($row['family']) == 0) {
                            $gozareshat .= ' <div class="us">' . htmlspecialchars($row['username']) . '</div></br>';
                        } else {
                            $gozareshat .= ' <div class="us">' . htmlspecialchars($row['name']) . ' ' . htmlspecialchars($row['family']) . '</div></br>';
                        }
                        $gozareshat .= '<h3 class="tl hd">عنوان تخلف : <span>' . htmlspecialchars($row['subject']) . '</span></h3>
                                    <div class="cmt right-align">' . str_replace(PHP_EOL, '<br>', htmlspecialchars($row['comment'])) . '</div>';
                        $list1[$perpicid] = '<div class="pitem">
                                <div class="id none">' . $row['id'] . '</div>
                                    <input type="hidden" id="uuid" value="' . $row['id'] . '"/>
                                <div class="zoomimg col s12 m4 right"><img class="responsive-img" src="' . URL . 'images/gallery/thumb/' . $img2 . '"></div>
                                <div id="thisviolation" class="cnt col s12 m8 right">' . $gozareshat . '
                                </div>
                                <div class="btnsdiv col s12">
                                    <a class="delcmt bwaves-effect waves-white pink darken-4 right btn mgright"><i class="mdi-action-delete right"></i> حذف</a>
                                </div>
                            </div>';
                    } else {
                        $gozareshat.='<img class="av" src="' . $thmname . '">';
                        if (mb_strlen($row['name']) == 0 || mb_strlen($row['family']) == 0) {
                            $gozareshat .= ' <div class="us">' . htmlspecialchars($row['username']) . '</div></br>';
                        } else {
                            $gozareshat .= ' <div class="us">' . htmlspecialchars($row['name']) . ' ' . htmlspecialchars($row['family']) . '</div></br>';
                        }
                        $gozareshat.='<h3 class="tl hd">عنوان تخلف : <span>' . htmlspecialchars($row['subject']) . '</span></h3>
                                    <div class="cmt right-align">' . str_replace(PHP_EOL, '<br>', htmlspecialchars($row['comment'])) . '</div>';
                        $list1[$perpicid] = '<div class="pitem">
                                <div class="id none">' . $row['id'] . '</div>
                                    <input type="hidden" id="uuid" value="' . $row['id'] . '"/>
                                <div class="zoomimg col s12 m4 right"><img class="responsive-img" src="' . URL . 'images/gallery/thumb/' . $img2 . '"></div>
                                <div id="thisviolation" class="cnt col s12 m8 right">' . $gozareshat . '</div>
                                <div class="btnsdiv col s12">
                                    <a class="delcmt bwaves-effect waves-white pink darken-4 right btn mgright"><i class="mdi-action-delete right"></i> حذف</a>
                                </div>
                            </div>';
                    }
                }$i++;
            }
            Session::set('picid', $perpicid);
            if (isset($list1[$perpicid])) {
                $list.=$list1[$perpicid];
            }

            $this->data['[VARITEMPHOTO]'] = $list;
        }
//        $this->data['[VARIMAGECOUNT]'] = $numofpage;
    }

    public function dltviolate() {
        if (isset($_POST['inf'])) {
            $cond = 'id=:id';
            $condata = array('id' => $_POST['inf']);
            $this->model->delviolate($cond, $condata);
        }
    }

    public function paging() {
        $list1 = array();
        $list = '';
        $count = Session::get('countpic');
        if (isset($_POST['pid'])) {
            $lmt = self::TOP * ($_POST['pid'] - 1);
            $cond = '1 ORDER BY idpic DESC Limit ' . $lmt . ',' . ($count - $lmt);
            $violat = $this->model->loadviolate($cond);
            $perpicid = 0;
            $gozareshat = '';
            $i = 0;
            if ($violat != FALSE) {
                while ($row = $violat->fetch()) {
                    if ($i < self::TOP) {
                        if ($row['isavatar'] == 1) {
                            $imgname = Utilities::imgname('avatar', $row['idpic']) . '.jpg';
                            $thmname = URL . '/images/avatar/' . $imgname;
                        } else {
                            $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                            $thmname = URL . '/images/avatar/' . $imgname;
                        }
                        $img2 = Utilities::imgname('thumb', $row['idpic']) . '.jpg';
                        if ($perpicid != $row['idpic']) {
                            if ($perpicid != 0) {
                                $list.=$list1[$perpicid];
                            }
                            $perpicid = $row['idpic'];
                            $list1[$perpicid] = '';
                            $gozareshat = '<h3 class="sbj hd">نام مسابقه : <span>' . htmlspecialchars($row['cname']) . '</span></h3><img class="av" src="' . $thmname . '">';
                            if (mb_strlen($row['name']) == 0 || mb_strlen($row['family']) == 0) {
                                $gozareshat .= ' <div class="us">' . htmlspecialchars($row['username']) . '</div></br>';
                            } else {
                                $gozareshat .= ' <div class="us">' . htmlspecialchars($row['name']) . ' ' . htmlspecialchars($row['family']) . '</div></br>';
                            }

                            $gozareshat .= '<h3 class="tl hd">عنوان تخلف : <span>' . htmlspecialchars($row['subject']) . '</span></h3>
                                    <div class="cmt right-align">' . str_replace(PHP_EOL, '<br>', htmlspecialchars($row['comment'])) . '</div>';
                            $list1[$perpicid] = '<div class="pitem">
                                <div class="id none">' . $row['id'] . '</div>
                                    <input type="hidden" id="uuid" value="' . $row['id'] . '"/>
                                <div class="zoomimg col s12 m4 right"><img class="responsive-img" src="' . URL . 'images/gallery/thumb/' . $img2 . '"></div>
                                <div id="thisviolation" class="cnt col s12 m8 right">' . $gozareshat . '
                                </div>
                                <div class="btnsdiv col s12">
                                    <a class="delcmt bwaves-effect waves-white pink darken-4 right btn mgright"><i class="mdi-action-delete right"></i> حذف</a>
                                </div>
                            </div>';
                        } else {
                            $gozareshat.='<img class="av" src="' . $thmname . '">';
                            if (mb_strlen($row['name']) == 0 || mb_strlen($row['family']) == 0) {
                                $gozareshat .= ' <div class="us">' . htmlspecialchars($row['username']) . '</div></br>';
                            } else {
                                $gozareshat .= ' <div class="us">' . htmlspecialchars($row['name']) . ' ' . htmlspecialchars($row['family']) . '</div></br>';
                            }
                            $gozareshat.='<h3 class="tl hd">عنوان تخلف : <span>' . htmlspecialchars($row['subject']) . '</span></h3>
                                    <div class="cmt right-align">' . str_replace(PHP_EOL, '<br>', htmlspecialchars($row['comment'])) . '</div>';
                            $list1[$perpicid] = '<div class="pitem">
                                <div class="id none">' . $row['id'] . '</div>
                                    <input type="hidden" id="uuid" value="' . $row['id'] . '"/>
                                <div class="zoomimg col s12 m4 right"><img class="responsive-img" src="' . URL . 'images/gallery/thumb/' . $img2 . '"></div>
                                <div id="thisviolation" class="cnt col s12 m8 right">' . $gozareshat . '</div>
                                <div class="btnsdiv col s12">
                                    <a class="delcmt bwaves-effect waves-white pink darken-4 right btn mgright"><i class="mdi-action-delete right"></i> حذف</a>
                                </div>
                            </div>';
                        }
                    }
//                       
                }$i++;
            }
            Session::set('picid', $perpicid);
            if (isset($list1[$perpicid])) {
                $list.=$list1[$perpicid];
            }
            $this->view->render('adminviolation/index', $list, false, 0);
        }
    }

}
