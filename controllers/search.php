<?php

class search extends Controller {

    function __construct() {
        parent::__construct();
    }

    const TOP = 12;

    public function index() {
        $this->loadstates();
        $this->loadcompetion();
        $this->searchphoto();
        $this->view->render('search/index', $this->data, FALSE);
    }

    public function loadcompetion() {
        $competition = $this->model->selectcomp();
        if ($competition != FALSE) {
            $compoption = '';
            while ($row = $competition->fetch()) {
                $compoption.='<option value="' . $row['id'] . '" >' . $row['name'] . '</option>';
            }$this->data['[VARCOMPNAME]'] = $compoption;
        }
    }

    public function loadstates() {
        $states = $this->model->selectstates();
        if ($states) {
            $statesoption = '';
            while ($row = $states->fetch()) {
                $statesoption.='<option value="' . $row['id'] . '">' . $row['state'] . '</option>';
            }$this->data['[VARSTATES]'] = $statesoption;
        }
    }

    public function searchphoto() {
//        Session::set('state', 1);
        $this->data['[VARUSERID]']=1;
        if (isset($_POST['searchtxt'])) {
            if ($_POST['searchtxt'] == "") {
                $this->data['[VARUSERID]']=0;
//                Session::set('state', 0);
                return FALSE;
            } else {
                if(mb_strlen($_POST['searchtxt'])>2){
                $word = explode(' ', ($_POST['searchtxt']));
                $cond = 'confirm=1 AND (';
                $i = 0;
                foreach ($word as $val) {
                    if (mb_strlen($val) > 2) {
                        $cond.='pn LIKE :data' . $i . ' OR ';
                        $condata['data' . $i] = '%' . $val . '%';
                        $i++;
                        $cond.='pcmt LIKE :data' . $i . ' OR ';
                        $condata['data' . $i] = '%' . $val . '%';
                        $i++;
                        $cond.='cname LIKE :data' . $i . ' OR ';
                        $condata['data' . $i] = '%' . $val . '%';
                        $i++;
                        $cond.='username LIKE :data' . $i . ' OR ';
                        $condata['data' . $i] = '%' . $val . '%';
                        $i++;
                    } 
                }
                $cond = substr($cond, 0, strlen($cond) - 3);
                $cond.=') ORDER BY pid DESC';
                $infsearch = 1;
        }else{
            return FALSE;
        }
         }
        } elseif (isset($_POST['searchby'])) {
//            Session::set('state', 1);
            $this->data['[VARUSERID]']=1;
            switch ($_POST['searchby']) {
                case 2: {
                        $infsearchcomp = 'جستجو بر اساس مسابقات';
                        switch ($_POST['dropcomptype']) {
                            case 1: {
                                    if ($_POST['searchcompname'] == '') {
                                        $cond = 'confirm=1 ORDER BY cid DESC';
                                        $condata = array();
                                        $infsearchcomp = 'جدیدترین مسابقه';
                                    } elseif (($_POST['searchcompname']) != '' && mb_strlen(($_POST['searchcompname']))>2) {
                                        $word = explode(' ', ($_POST['searchcompname']));
                                        $cond = 'confirm=1 AND (';
                                        $i = 0;
                                        foreach ($word as $val) {
                                            if (mb_strlen($val) > 2) {
                                                $cond.='pn LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                                $cond.='pcmt LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                                $cond.='cname LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                                $cond.='username LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                            } 
                                        }
                                        $cond = substr($cond, 0, strlen($cond) - 3);
                                        $cond.=') ORDER BY cid DESC';
                                        $infsearchcomp = 'عبارت « ' . $_POST['searchcompname'] . '» در جدیدترین مسابقه';
                                    }else{
                                        return FALSE;
                                    }
                                    break;
                                }
                            case 2: {
                                    if ($_POST['searchcompname'] == '') {
                                        $cond = 'confirm=1 ORDER BY numofpic DESC';
                                        $condata = array();
                                        $infsearchcomp = 'محبوبترین مسابقه';
                                    } elseif(mb_strlen($_POST['searchcompname'])>2) {
                                        $word = explode(' ', ($_POST['searchcompname']));
                                        $cond = 'confirm=1 AND (';
                                        $i = 0;
                                        foreach ($word as $val) {
                                            if (mb_strlen($val) > 2) {
                                                $cond.='pn LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                                $cond.='pcmt LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                                $cond.='cname LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                                $cond.='username LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                            } 
                                        }
                                        $cond = substr($cond, 0, strlen($cond) - 3);
                                        $cond.=') ORDER BY numofpic DESC';
                                        $infsearchcomp = 'عبارت « ' . $_POST['searchcompname'] . '» در محبوبترین مسابقه';
                                    }else{
                                        return FALSE;
                                    }
                                    break;
                                }
                            case 3: {
                                    if ($_POST['searchcompname'] == '') {
                                        if ($_POST['dropcomp'] == 0) {
                                            $cond = 'confirm=1 ORDER BY cid DESC';
                                            $condata = array();
                                            $infsearchcomp = 'جستجو بر اساس نام مسابقات';
                                        } else {
                                            $cond = 'confirm=1 AND cid=:cid ORDER BY pid DESC';
                                            $condata = array('cid' => $_POST['dropcomp']);
                                            $competition = $this->model->selectcomp();
                                            if ($competition != FALSE) {
                                                $compoption = '';
                                                while ($row = $competition->fetch()) {
                                                    $compoption.='<option value="' . $row['id'] . '"';
                                                    if ($row['id'] == $_POST['dropcomp']) {
                                                        $compoption.='selected';
                                                        session::set('compsearch', $row['name']);
                                                        $comp = session::get('compsearch');
                                                    }
                                                    $compoption.='>' . $row['name'] . '</option>';
                                                }$this->data['[VARCOMPNAME]'] = $compoption;
                                            }
                                            $infsearchcomp = 'مسابقه  ' . $comp;
                                        }
                                    } elseif ($_POST['dropcomp'] != 0 && mb_strlen($_POST['searchcompname'])>2) {
                                        $word = explode(' ', ($_POST['searchcompname']));
                                        $cond = 'confirm=1 AND (';
                                        $i = 0;
                                        foreach ($word as $val) {
                                            if (mb_strlen($val) > 2) {
                                                $cond.='pn LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                                $cond.='pcmt LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                                $cond.='cname LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                                $cond.='username LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                            } 
                                        }
                                        $cond = substr($cond, 0, strlen($cond) - 3);
                                        $cond.=') AND cid=:cid ORDER BY pid DESC';
                                        $condata['cid'] = $_POST['dropcomp'];
                                        $competition = $this->model->selectcomp();
                                        if ($competition != FALSE) {
                                            $compoption = '';
                                            while ($row = $competition->fetch()) {
                                                $compoption.='<option value="' . $row['id'] . '"';
                                                if ($row['id'] == $_POST['dropcomp']) {
                                                    $compoption.='selected';
                                                    session::set('compsearch', htmlspecialchars($row['name']));
                                                    $comp = session::get('compsearch');
                                                }
                                                $compoption.='>' . htmlspecialchars($row['name']) . '</option>';
                                            }$this->data['[VARCOMPNAME]'] = $compoption;
                                        }
                                        $infsearchcomp = 'عبارت« ' . $_POST['searchcompname'] . '» در مسابقه ' . $comp;
                                    } elseif(mb_strlen($_POST['searchcompname'])>2) {
                                        $word = explode(' ', ($_POST['searchcompname']));
                                        $cond = 'confirm=1 AND (';
                                        $i = 0;
                                        foreach ($word as $val) {
                                            if (mb_strlen($val) > 2) {
                                                $cond.='pn LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                                $cond.='pcmt LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                                $cond.='cname LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                                $cond.='username LIKE :data' . $i . ' OR ';
                                                $condata['data' . $i] = '%' . $val . '%';
                                                $i++;
                                            } 
                                        }
                                        $cond = substr($cond, 0, strlen($cond) - 3);
                                        $cond.=')  ORDER BY pid DESC';
                                        $infsearchcomp = 'عبارت« ' . $_POST['searchcompname'] . '»';
                                    }else{
                                        return FALSE;
                                    }
                                    break;
                                }
                            case 4: {
                                    if ($_POST['searchcompname'] == '' ) {
                                        if (($_POST['tarikh1']) != '' && ($_POST['tarikh2']) != '') {
                                            $stime = explode('-', $_POST['tarikh1']);
                                            $st = Shamsidate::jmktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
                                            $etime = explode('-', $_POST['tarikh2']);
                                            $en = Shamsidate::jmktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);
                                            $cond = 'confirm=1 AND startdate>=:startdate AND enddate<=:enddate ORDER BY pid DESC';
                                            $condata = array('startdate' => $st, 'enddate' => $en);
                                            $begin = $stime[0] . '/' . $stime[1] . '/' . $stime[2];
                                            $finish = $etime[0] . '/' . $etime[1] . '/' . $etime[2];
                                            $infsearchcomp = 'بازه زمانی ' . $begin . ' تا ' . $finish;
                                        } else {
                                            $cond = 'confirm=1 ORDER BY cid DESC';
                                            $condata = array();
                                            $infsearchcomp = 'همه تصاویر';
                                        }
                                    } elseif(mb_strlen($_POST['searchcompname'])>2) {
                                        if (($_POST['tarikh1']) != '' && ($_POST['tarikh2']) != '' ) {
                                            $word = explode(' ', ($_POST['searchcompname']));
                                            $i = 0;
                                            $cond = 'confirm=1 AND (';
                                            foreach ($word as $val) {
                                                if (mb_strlen($val) > 2) {
                                                    $cond.='pn LIKE :data' . $i . ' OR ';
                                                    $condata['data' . $i] = '%' . $val . '%';
                                                    $i++;
                                                    $cond.='pcmt LIKE :data' . $i . ' OR ';
                                                    $condata['data' . $i] = '%' . $val . '%';
                                                    $i++;
                                                    $cond.='cname LIKE :data' . $i . ' OR ';
                                                    $condata['data' . $i] = '%' . $val . '%';
                                                    $i++;
                                                    $cond.='username LIKE :data' . $i . ' OR ';
                                                    $condata['data' . $i] = '%' . $val . '%';
                                                    $i++;
                                                } 
                                            }
                                            $stime = explode('-', $_POST['tarikh1']);
                                            $st = Shamsidate::jmktime(0, 0, 0, $stime[1], $stime[2], $stime[0]);
                                            $etime = explode('-', $_POST['tarikh2']);
                                            $en = Shamsidate::jmktime(23, 59, 59, $etime[1], $etime[2], $etime[0]);
                                            $cond = substr($cond, 0, strlen($cond) - 3);
                                            $cond.=') AND startdate>=:startdate AND enddate<=:enddate ORDER BY pid DESC';
                                            $condata['startdate'] = $st;
                                            $condata['enddate'] = $en;
                                            $begin = $stime[0] . '/' . $stime[1] . '/' . $stime[2];
                                            $finish = $etime[0] . '/' . $etime[1] . '/' . $etime[2];
                                            $infsearchcomp = 'عبارت« ' . $_POST['searchcompname'] . '» در بازه زمانی ' . $begin . ' تا ' . $finish;
                                        } elseif(mb_strlen($_POST['searchcompname'])>2) {
                                            $word = explode(' ', ($_POST['searchcompname']));
                                            $i = 0;
                                            $cond = 'confirm=1 AND (';
                                            foreach ($word as $val) {
                                                if (mb_strlen($val) > 2) {
                                                    $cond.='pn LIKE :data' . $i . ' OR ';
                                                    $condata['data' . $i] = '%' . $val . '%';
                                                    $i++;
                                                    $cond.='pcmt LIKE :data' . $i . ' OR ';
                                                    $condata['data' . $i] = '%' . $val . '%';
                                                    $i++;
                                                    $cond.='cname LIKE :data' . $i . ' OR ';
                                                    $condata['data' . $i] = '%' . $val . '%';
                                                    $i++;
                                                    $cond.='username LIKE :data' . $i . ' OR ';
                                                    $condata['data' . $i] = '%' . $val . '%';
                                                    $i++;
                                                } 
                                            }
                                            $cond = substr($cond, 0, strlen($cond) - 3);
                                            $cond.=') ORDER BY cid DESC';
                                            $infsearchcomp = 'عبارت«' . $_POST['searchcompname'] . '»';
                                        }
                                    }else{
                                        return FALSE;
                                    }
                                    break;
                                }
                            default :
                                if ($_POST['searchcompname'] == '') {
                                    $cond = 'confirm=1 ORDER BY cid DESC';
                                    $condata = array();
                                } elseif(mb_strlen($_POST['searchcompname'])>2)  {
                                    $word = explode(' ', ($_POST['searchcompname']));
                                    $cond = 'confirm=1 AND (';
                                    $i = 0;
                                    foreach ($word as $val) {
                                        if (mb_strlen($val) > 2) {
                                            $cond.='pn LIKE :data' . $i . ' OR ';
                                            $condata['data' . $i] = '%' . $val . '%';
                                            $i++;
                                            $cond.='pcmt LIKE :data' . $i . ' OR ';
                                            $condata['data' . $i] = '%' . $val . '%';
                                            $i++;
                                            $cond.='cname LIKE :data' . $i . ' OR ';
                                            $condata['data' . $i] = '%' . $val . '%';
                                            $i++;
                                            $cond.='username LIKE :data' . $i . ' OR ';
                                            $condata['data' . $i] = '%' . $val . '%';
                                            $i++;
                                        } 
                                    }
                                    $cond = substr($cond, 0, strlen($cond) - 3);
                                    $cond.=') ORDER BY cid DESC';
                                    $infsearchcomp .= ' عبارت«' . $_POST['searchcompname'] . '»';
                                }else{
                                    return FALSE;
                                }
                        }$infsearch = 2;
                        break;
                    }
                case 4: {
                        if ($_POST['searchhashtag'] == '') {
                            $cond = 'confirm=1 ORDER BY pid DESC';
                            $condata = array();
                            $infsearchcomp = 'همه  تگ ها';
                        } else {
                            $cond = 'tags LIKE :data ORDER BY pid DESC';
                            $condata['data'] = ',' . $_POST['searchhashtag'] . ',';
                            $infsearchcomp = 'بر اساس تگ« ' . $_POST['searchhashtag'] . '»';
                        }$infsearch = 3;
                        break;
                    }
                case 5: {
                        if ($_POST['searchuser'] == '') {
                            $cond = 'confirm=1 ORDER BY pid DESC';
                            $condata = array();
                            $infsearchcomp = 'همه  کاربران';
                        } else {
                            $cond = 'username=:username ORDER BY pid DESC';
                            $condata = array('username' => $_POST['searchuser']);
                            $infsearchcomp = 'بر اساس نام کاربری «' . $_POST['searchuser'] . '»';
                        }$infsearch = 4;
                        break;
                    }
                case 6: {
                        if ($_POST['searchplace'] == '') {
                            if ($_POST['dropplace'] == 0) {
                                $cond = 'confirm=1 ORDER BY pid DESC';
                                $condata = array();
                                $infsearchcomp = 'همه   استان ها';
                            } else {
                                $cond = 'locateid=:locateid ORDER BY pid DESC';
                                $condata = array('locateid' => $_POST['dropplace']);
                                $states = $this->model->selectstates();
                                if ($states) {
                                    $statesoption = '';
                                    while ($row = $states->fetch()) {
                                        $statesoption.='<option value="' . $row['id'] . '"';
                                        if ($row['id'] == $_POST['dropplace']) {
                                            $statesoption.='selected';
                                            session::set('statesearch', htmlspecialchars($row['state']));
                                            $place = session::get('statesearch');
                                        }$statesoption.= ' >' . htmlspecialchars($row['state']) . '</option>';
                                    }$this->data['[VARSTATES]'] = $statesoption;
                                }
                                $infsearchcomp = 'عکس های  گرفته شده در استان« ' . $place . '»';
                            }
                        } elseif(mb_strlen($_POST['searchplace'])>2) {
                            if ($_POST['dropplace'] == 0 ) {
                                $searchtxt = $_POST['searchplace'];
                                $word = explode(' ', ($_POST['searchplace']));
                                $i = 0;
                                $cond = 'confirm=1 AND (';
                                foreach ($word as $val) {
                                    if (mb_strlen($val) > 2) {
                                        $cond.='pn LIKE :data' . $i . ' OR ';
                                        $condata['data' . $i] = '%' . $val . '%';
                                        $i++;
                                        $cond.='pcmt LIKE :data' . $i . ' OR ';
                                        $condata['data' . $i] = '%' . $val . '%';
                                        $i++;
                                        $cond.='cname LIKE :data' . $i . ' OR ';
                                        $condata['data' . $i] = '%' . $val . '%';
                                        $i++;
                                        $cond.='username LIKE :data' . $i . ' OR ';
                                        $condata['data' . $i] = '%' . $val . '%';
                                        $i++;
                                    } 
                                }
                                $cond = substr($cond, 0, strlen($cond) - 3);
                                $cond.=') ORDER BY pid DESC';
                                $infsearchcomp = 'عبارت «' . $_POST['searchplace'] . '» ';
                            } else {
                                $searchtxt = $_POST['searchplace'];
                                $word = explode(' ', ($_POST['searchplace']));
                                $i = 0;
                                $cond = 'confirm=1 AND (';
                                foreach ($word as $val) {
                                    if (mb_strlen($val) > 2) {
                                        $cond.='pn LIKE :data' . $i . ' OR ';
                                        $condata['data' . $i] = '%' . $val . '%';
                                        $i++;
                                        $cond.='pcmt LIKE :data' . $i . ' OR ';
                                        $condata['data' . $i] = '%' . $val . '%';
                                        $i++;
                                        $cond.='cname LIKE :data' . $i . ' OR ';
                                        $condata['data' . $i] = '%' . $val . '%';
                                        $i++;
                                        $cond.='username LIKE :data' . $i . ' OR ';
                                        $condata['data' . $i] = '%' . $val . '%';
                                        $i++;
                                    } 
                                }
                                $cond = substr($cond, 0, strlen($cond) - 3);
                                $cond.=') AND locateid=:locateid ORDER BY pid DESC';
                                $condata['locateid'] = $_POST['dropplace'];
                                $states = $this->model->selectstates();
                                if ($states) {
                                    $statesoption = '';
                                    while ($row = $states->fetch()) {
                                        $statesoption.='<option value="' . $row['id'] . '"';
                                        if ($row['id'] == $_POST['dropplace']) {
                                            $statesoption.='selected';
                                            session::set('statesearch', htmlspecialchars($row['state']));
                                            $place = session::get('statesearch');
                                        }$statesoption.= ' >' . htmlspecialchars($row['state']) . '</option>';
                                    }$this->data['[VARSTATES]'] = $statesoption;
                                }$infsearchcomp = 'عبارت «' . $_POST['searchplace'] . '» در تصاویر گرفته شده در استان ' . $place;
                            }
                        }else{
                            return FALSE;
                        }$infsearch = 5;
                        break;
                    }
            }
        } else {
            $this->data['[VARUSERID]']=0;
            return FALSE;
            
        }
//        if (sizeof($condata)==0) {
//            return FALSE;
//        }
        Session::set('serchcond', $cond);
        Session::set('condata', $condata);
        $this->data['[VARIMAGECOUNT]'] = '';
        $cnt = 0;
        $photo = $this->model->searchphot($cond, $condata);
        $numofpage = 0;
        if ($photo != FALSE) {
            $cnt = $photo->rowCount();
            session::set('num', $cnt);
            $numofpage = ceil($cnt / self::TOP);
            $item = '';
            $i = 0;
            while ($row = $photo->fetch()) {
                $showrate=0;
                if ($i < self::TOP) {

                    if ((time() - (48 * 3600)) < $row['enddate']) {
                        $showstar = 1;
                    } else {
                        $showstar = 0;
                    }
//                    $userid = Session::get('userid');
//                    $resr = $this->model->loadrate($row['pid'], $userid);
//                    if ($resr) {
//                        $rowrate = $resr->fetch();
//                        $rate = $rowrate['rate'];
//                    } else {
//                        $rate = 0;
//                    }
                    if ($row['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                        $thmname = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $thmname = URL . '/images/avatar/' . $imgname;
                    }
                    $picname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                    $picturname = URL . '/images/gallery/thumb/' . $picname;
                    $item.='<div id="gallery" class="brick';
                    if (Session::get('userid')) {
                        $item .=' isusermix';
                    }
                    $item.='"><input type="hidden" name="idpic" id="idpic" value="' . $row['pid'] . '">
                                    <div class="image-head">';
                    
                    if ($row['ispeopel'] != 0) {
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
                        $item .=' <div class="score-image1 ' . $cls . '">
                                        <img src="' . URL . 'images/icons/score-icon.png" class="' . $cls . ' resultrate" /> <span>' .$showrate. '</span>
                                        </div>';
                    }
                                        $item .='<a href="' . URL . 'blog/id/' . htmlspecialchars($row['userid']) . '">
                                            <div class="details-image1">
                                      <img  class="av" src="' . $thmname . '" />';
                    if ($row['pn'] != '') {
                        $item.='<span class="pn">' . htmlspecialchars($row['pn']) . ' </span>  ';
                    }else{
                        $item.='<span class="pn"></span>  ';
                    }//<a href="#" data-toggle="modal" data-target="#imgModal"> 538
                    $item.='</div>
                                </a>
                             </div>';
                    if (Session::get('userid')) {
                           $item.='  <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . $picturname. '?' . $i . '" width="100%">
                             </a>';
                    }else{
                        $item.=' <img class="bgimg" src="' . $picturname. '?' . $i . '" width="100%">';
                    }
                          $item.=' <div class="us none"><a href="' . URL . 'blog/id/' . htmlspecialchars($row['userid']) . '" class="userlink" > ';
                             //<a href="#" data-toggle="modal" data-target="#imgModal">
                               // <img class="bgimg" src="' .$picturname. '?' . $i . '" width="100%">
                             //<div class="us none"><a class="userlink" ></a> ';
                    if (mb_strlen($row['uname']) == 0 || mb_strlen($row['uf']) == 0) {//</a> 540
                        $item.=htmlspecialchars($row['username']) . '</a></div>';
                    } else {
                        $item.=htmlspecialchars($row['uname']) . ' ' . htmlspecialchars($row['uf']) . '</a></div>';
                    }
                    $item.='<div class="dt none">' . Shamsidate::jdate('j F Y', $row['pdate']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['pcmt'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['cid'] . '" id="cmp">' . htmlspecialchars($row['cname']) . '</a></div>
                                <div class="rt none">' . $showrate . '</div>
                              <input type="hidden"  id="shorno" value="' . $showstar . '">
                       </div>';
                }$i++;
            }
//            Session::set('state', 1);
            $this->data['[VARSEARCH]'] = $item;
        }
        $this->data['[VARIMAGECOUNT]'] = $numofpage;
        switch ($infsearch) {
            case 0: {
                    $inf = '<p class="col-md-6 col-xs-6 right text-center">مورد جستجو : <span class="teal-text text-darken-4">...</span></p>
                       <p class="col-md-6 col-xs-6 right text-center">تعداد یافت شده : <span class="teal-text text-darken-4">...</span></p>';
                    break;
                }
            case 1: {
                    $inf = '<p class="col-md-6 col-xs-6 right text-center">مورد جستجو : <span class="teal-text text-darken-4">« ' . htmlspecialchars($_POST['searchtxt']) . ' »</span></p>
                       <p class="col-md-6 col-xs-6 right text-center">تعداد یافت شده : <span class="teal-text text-darken-4">' . $cnt . '</span></p>';
                    break;
                }
            case 2: {
                    $inf = '<p class="col-md-6 col-xs-6 right text-center">مورد جستجو : <span class="teal-text text-darken-4"> ' . htmlspecialchars($infsearchcomp) . '</span></p>
                       <p class="col-md-6 col-xs-6 right text-center">تعداد یافت شده : <span class="teal-text text-darken-4">' . $cnt . '</span></p>';
                    break;
                }
            case 3: {
                    $inf = '<p class="col-md-6 col-xs-6 right text-center">مورد جستجو : <span class="teal-text text-darken-4"> ' . htmlspecialchars($infsearchcomp) . '</span></p>
                       <p class="col-md-6 col-xs-6 right text-center">تعداد یافت شده : <span class="teal-text text-darken-4">' . $cnt . '</span></p>';
                    break;
                }
            case 4: {
                    $inf = '<p class="col-md-6 col-xs-6 right text-center">مورد جستجو : <span class="teal-text text-darken-4"> ' . htmlspecialchars($infsearchcomp) . '  </span></p>
                       <p class="col-md-6 col-xs-6 right text-center">تعداد یافت شده : <span class="teal-text text-darken-4">' . $cnt . '</span></p>';
                    break;
                }
            case 5: {
                    $inf = '<p class="col-md-6 col-xs-6 right text-center">مورد جستجو : <span class="teal-text text-darken-4"> ' . htmlspecialchars($infsearchcomp) . '</span></p>
                       <p class="col-md-6 col-xs-6 right text-center">تعداد یافت شده : <span class="teal-text text-darken-4">' . $cnt . '</span></p>';
                    break;
                }
        }
        $this->data['[VARINF]'] = $inf;
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
                    $this->view->render('method/index', $data, false, 0);
                } else {       //all field requier
                    $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
                    $data = json_encode($data);
                    $this->view->render('method/index', $data, false, 0);
                }
            } else {       //all field requier
                $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
                $data = json_encode($data);
                $this->view->render('method/index', $data, false, 0);
            }
        } else {
            
        }
    }

    public function paging() {
//        $flag = Session::get('state');
//        if ($flag==0) {//echo 1234567890;
//            return FALSE;
//        }
        $case = Session::get('search');
        $num = Session::get('num');
        if (isset($_POST['pid'])) {
            if ($case != FALSE) {
                $inf = '<p class="col-md-6 col-xs-6 right text-center">مورد جستجو : <span class="teal-text text-darken-4">' . htmlspecialchars($case) . '</span></p>
                       <p class="col-md-6 col-xs-6 right text-center">تعداد یافت شده : <span class="teal-text text-darken-4">' . $num . '</span></p>';
            } else {
                $inf = '<p class="col-md-6 col-xs-6 right text-center">مورد جستجو : <span class="teal-text text-darken-4">...</span></p>
                       <p class="col-md-6 col-xs-6 right text-center">تعداد یافت شده : <span class="teal-text text-darken-4">...</span></p>';
            }
            $word = explode(' ', ($case));
            $cond = 'confirm=1 AND (';
            $i = 0;

            $lmt = self::TOP * ($_POST['pid'] - 1);
            $cond = Session::get('serchcond');
            $cond .= ' Limit ' . $lmt . ',' . self::TOP;
            $condata = Session::get('condata');
            $photo = $this->model->searchphot($cond, $condata);
            if ($photo != FALSE) {
                $item = '';
                while ($row = $photo->fetch()) {
                    $showrate=0;
                     if ((time() - (48 * 3600)) < $row['enddate']) {
                        $showstar = 1;
                    } else {
                        $showstar = 0;
                    }
//                    $userid = Session::get('userid');
//                    $resr = $this->model->loadrate($row['pid'], $userid);
//                    if ($resr) {
//                        $rowrate = $resr->fetch();
//                        $rate = $rowrate['rate'];
//                    } else {
//                        $rate = 0;
//                    }
                    if ($row['isavatar'] == 1) {
                        $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                        $thmname = URL . '/images/avatar/' . $imgname;
                    } else {
                        $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                        $thmname = URL . '/images/avatar/' . $imgname;
                    }
                    $picname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                    $picturname = URL . '/images/gallery/thumb/' . $picname;
//                   
                     $item.='<div id="gallery" class="brick';
                    if (Session::get('userid')) {
                        $item .=' isusermix';
                    }
                    $item.='"><input type="hidden" name="idpic" id="idpic" value="' . $row['pid'] . '">
                                    <div class="image-head">';
                    
                    if ($row['ispeopel'] != 0) {
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
                        $item .=' <div class="score-image1 ' . $cls . '">
                                        <img src="' . URL . 'images/icons/score-icon.png" class="' . $cls . '" /> <span>' .$showrate. '</span>
                                        </div>';
                    }
                                        $item .='<a href="' . URL . 'blog/id/' . htmlspecialchars($row['userid']) . '">
                                            <div class="details-image1">
                                      <img  class="av" src="' . $thmname . '" />';
                    if ($row['pn'] != '') {
                        $item.='<span class="pn">' . htmlspecialchars($row['pn']) . ' </span>  ';//<h3 class="tl hd">ظ†ط§ظ… طھطµظˆغŒط± : <span>' . $row['pn'] . '</span></h3>
                    }else{
                        $item.='<span class="pn"></span>  ';
                    }
                    $item.='</div>
                                </a>
                             </div>';
                    if (Session::get('userid')) {
                           $item.='  <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . $picturname. '?' . $i . '" width="100%">
                             </a>';
                    }else{
                        $item.=' <img class="bgimg" src="' . $picturname. '?' . $i . '" width="100%">';
                    }
                          $item.=' <div class="us none"><a href="' . URL . 'blog/id/' . htmlspecialchars($row['userid']) . '" class="userlink" > ';
                    if (mb_strlen($row['uname']) == 0 || mb_strlen($row['uf']) == 0) {
                        $item.=htmlspecialchars($row['username']) . '</a></div>';
                    } else {
                        $item.=htmlspecialchars($row['uname']) . ' ' . htmlspecialchars($row['uf']) . '</a></div>';
                    }
                    $item.='<div class="dt none">' . Shamsidate::jdate('j F Y', $row['pdate']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['pcmt'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['cid'] . '" id="cmp">' . htmlspecialchars($row['cname']) . '</a></div>
                                <div class="rt none">' . $showrate . '</div>
                              <input type="hidden"  id="shorno" value="' . $showstar . '">
                                    
                       </div>';
                }$this->data['[VARINF]'] = $inf;
                $this->view->render('search/index', $item, false, 0);
            }
        }
    }

}
