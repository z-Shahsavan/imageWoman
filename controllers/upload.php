<?php

class upload extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::access_control('isuser', 'index#loginlink', 1);
    }

    public function index() {
        $this->searchcontent();
        $this->view->render('upload/index', $this->data);
    }

    public function searchcontent() {
        $cityoption = '';
        $res = $this->model->cityname();
        if ($res != FALSE) {
            while ($row = $res->fetch()) {
                $cityoption.='<option value="' . $row['id'] . '"';
                $cityoption.='>' . $row['state'] . ' </option>';
            }
            $this->data["[VARCITY]"] = $cityoption;
        }
    }

    public function selectcomp() {
        $result = $this->model->comps();
        if ($result != FALSE) {
            $this->data['[VARCOMPS]'] = '';
            while ($row = $result->fetch()) {
                $this->data['[VARCOMPS]'].='<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
            }
        }
    }

    public function uppic() {
        $userid = Session::get('userid');
        $res = $this->model->isphoto($userid);
        if (!$res) {
            $data = array('id' => '2');
            $data = json_encode($data);
            $this->view->render('upload/index', $data, false, 0);
            return;
        } else {
            $data = array('id' => '3');
            $data = json_encode($data);
            $this->view->render('upload/index', $data, false, 0);
            return;
        }
    }

    public function uploadpic() {
        $fields = array('competition');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                if (isset($_POST['competition']) && strcmp($_POST['competition'], '') != 0) {
                    $result = $this->model->checkcomp($_POST['competition']);
                    if ($result != FALSE) {
                        $compid = $_POST['competition'];
                    } else {
                        $data = array('id' => '0', 'msg' => 'مسابقه انتخاب شده معتبر نیست');
                        $data = json_encode($data);
                        $this->view->render('upload/index', $data, false, 0);
                        return;
                    }
                } else {
                    //all field requier
                    $data = array('id' => '0', 'msg' => 'لطفا تمامی فیلد هارا پر کنید');
                    $data = json_encode($data);
                    $this->view->render('upload/index', $data, false, 0);
                    return;
                }
                    //check file
                    $res = Photoutil::photocheck('0');
                    switch ($res) {
                        case 1:
                            //file not post
                            $data = array('id' => '0', 'msg' => 'لطفا یک فایل انتخاب کنید');
                            $data = json_encode($data);
                            $this->view->render('upload/index', $data, false, 0);
                            return;
                            break;
                        case 2:
                            //mimetype not true
                            $data = array('id' => '0', 'msg' => 'فرمت فایل انتخابی مجاز نیست');
                            $data = json_encode($data);
                            $this->view->render('upload/index', $data, false, 0);
                            return;
                            break;
                        case 3:
                            //image is corrupted
                            $data = array('id' => '0', 'msg' => 'این عکس دارای مشکل است');
                            $data = json_encode($data);
                            $this->view->render('upload/index', $data, false, 0);
                            return;
                            break;
                        case 4:
                            //image size not true
                            $data = array('id' => '0', 'msg' => 'حداقل طول و عرض برای تصویر ارسالی باید به ترتیب برابر ' . IMAGE_MIN_HEIGHT . ' و ' . IMAGE_MIN_WIDTH . ' باشد');
                            $data = json_encode($data);
                            $this->view->render('upload/index', $data, false, 0);
                            return;
                            break;
                        case 5:
                            //image file size not true
                            $data = array('id' => '0', 'msg' => 'حجم فایل ارسالی باید بین  ' . IMAGE_MIN_SIZE . 'تا  ' . IMAGE_MAX_SIZE . 'باشد ');
                            $data = json_encode($data);
                            $this->view->render('upload/index', $data, false, 0);
                            return;
                            break;
                    }
                    $userid = Session::get('userid');
                    if ($userid != FALSE) {
                        //save image
                        $cond = 'id=:id';
                        if (isset($_POST['location'])&& !empty($_POST['location'])) {
                            $condata = array('id' => $_POST['location']);
                        } else {
                            $condata = array('id' => 32);
                        }
                        $re = $this->model->citynam($cond, $condata);
                        if ($re) {
                            $row = $re->fetch();
                            $locname = $row['state'];
                        }
                        if (isset($_POST['date']) && !empty($_POST['date'])) {
                            $data = explode('-', $_POST['date']);
                            $st = Shamsidate::jmktime(0, 0, 0, $data[1], $data[2], $data[0]);
                        } else {
                            $st = '';
                        }
                        if (isset($_POST['hashtag'])&& !empty($_POST['hashtag'])) {
                            $hashtag = ',' . $_POST['hashtag'] . ',';
                        }  else {
                            $hashtag ='';
                        }
                        if(isset($_POST['name'])&& !empty($_POST['name'])){
                            $name=  str_replace('ي', 'ی', $_POST['name']);
                            $name=  str_replace('ك', 'ک', $_POST['name']);
                        }  else {
                            $name='';
                        }
                        if(isset($_POST['comment'])&& !empty($_POST['comment'])){
                            $comment=str_replace('ي', 'ی', $_POST['comment']);
                            $comment=str_replace('ك', 'ک', $_POST['comment']);
                        }  else {
                            $comment='';
                        }
                        
                        $data = array('userid' => $userid, 'name' => htmlspecialchars($name), 'tags' => htmlspecialchars($hashtag), 'locate' => htmlspecialchars($locname), 'date' => $st, 'comment' => htmlspecialchars($comment), 'compid' => $compid);
                        $result = $this->model->saveimage($data);
                        Photoutil::saveimgandthumb($result,$res, 0);
                        //add to user photonumber
                        $this->model->edituser($userid);
                        $data = array('id' => '1', 'msg' => 'تصویر ارسالی شما ذخیره شد');
                        $data = json_encode($data);
                        $this->view->render('upload/index', $data, false, 0);
                        return;
                    } else {
                        header('location:' . URL . 'index#loginlink');
                    }
                
            } else {
                //all field requier
                $data = array('id' => '0', 'msg' => 'لطفا تمام فیلد هارا پر کنید');
                $data = json_encode($data);
                $this->view->render('upload/index', $data, false, 0);
            }
        } else {
            //all field requier
            $data = array('id' => '0', 'msg' => 'لطفا تمام فیلد هارا پر کنید');
            $data = json_encode($data);
            $this->view->render('upload/index', $data, false, 0);
        }
    }

    public function hashtagha() {
        $res = '';
        if (isset($_GET['tag'])) {
            $str = substr($_GET['tag'], 0, 1);
            if ($str == '#') {
                $st = substr($_GET['tag'], 1);
            } else {
                $st = substr($_GET['tag'], 0);
            }
            $cond = 'tags LIKE :data';
            $condata['data'] = '%' . $st . '%';
            $result = $this->model->hashtagha($cond, $condata);
            if ($result) {
                while ($row = $result->fetch()) {
                    $tag = explode(',', $row['tags']);
                    foreach ($tag as $tg) {
                        if (strstr($tg,$st)) {
                            $res .='{"key": "' . $tg . '", "value": "' . $tg . '"},';
                        }
                    }
                }
                $res = trim($res, ',');
                //$data = array('key' => $res,'value'=>$res);
                //$data = json_encode($res);
            } else {
                $res = '{"key": "", "value": ""}';
            }
            $this->view->render('upload/index', '[' . $res . ']', false, 0);
            return;
        } else {
            $res = '{"key": "", "value": ""},';

            $this->view->render('upload/index', $res, false, 0);
            return;
        }
    }

}
