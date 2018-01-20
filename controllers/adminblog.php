<?php

class adminblog extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::access_control('isuser', 'index#loginlink', 4);
    }

    public function index() {
        $this->loads();
        $this->view->render('adminblog/index', $this->data);
    }

    public function upload() {
        $fields = array('subject', 'comment');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                //check file
                $res = $this->upfilecheck();
                switch ($res) {
                    case 1:
                        //file not post
                        $data = array('id' => '0', 'msg' => 'لطفا تمامی موارد را وارد کنید.');
                        $data = json_encode($data);
                        $this->view->render('adminblog/index', $data, false, 0);
                        return;
                        break;
                    case 2:
                        //mimetype not true
                        $data = array('id' => '0', 'msg' => 'نوع فایل مجاز نیست.');
                        $data = json_encode($data);
                        $this->view->render('adminblog/index', $data, false, 0);
                        return;
                        break;
                    case 3:
                        //image is corrupted
                        $data = array('id' => '0', 'msg' => 'فایل بارگذاری شده دارای مشکل است.');
                        $data = json_encode($data);
                        $this->view->render('adminblog/index', $data, false, 0);
                        return;
                        break;
                }
                //save site
                $data['title'] = ($_POST['subject']); //
                $data['comment'] = ($_POST['comment']); //
                $data['extention'] = $res; //
                $fid = $this->model->saveups($data); //
                $this->savefile($fid, $res);
                $data = array('id' => '1', 'msg' => 'اطلاعات با موفقیت ثبت شد.', 'fid' => $fid);
                $data = json_encode($data);
                $this->view->render('adminblog/index', $data, false, 0);
            } else {
                //all field requier
                $data = array('id' => '0', 'msg' => 'لطفا تمام فیلدها را پر کنید.');
                $data = json_encode($data);
                $this->view->render('adminblog/index', $data, false, 0);
            }
        } else {
            //all field requier
            $data = array('id' => '0', 'msg' => 'لطفا تمام فیلدها را پر کنید.');
            $data = json_encode($data);
            $this->view->render('adminblog/index', $data, false, 0);
        }
    }

    public function savefile($fid, $ext) {
        $imgname = Utilities::imgname('files', $fid) . '.' . $ext;
        move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . '/' . PROJECTNAME . "/files/" . $imgname);
    }

    public function loads() {
        $res = $this->model->loads();
        if ($res) {
            $list = '';
            while ($row = $res->fetch()) {
                $list.='<div class="pitem" id="it' . $row['id'] . '">
                            <div class="id none">' . $row['id'] . '</div>
                            <div class="cnt col s12">
                                <h3 class="sbj hd">موضوع: <span>' . htmlspecialchars($row['title']) . '</span></h3>
                                <h3 class="cmt hd">توضیحات : <span>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['comment'])) . '</span></h3>
                            </div>
                            <div class="btnsdiv col s12">
                                <a class="editcmp bwaves-effect waves-white teal darken-3 right btn"><i class="mdi-editor-mode-edit right"></i>ویرایش</a>
                                <a class="delcmt bwaves-effect waves-white pink darken-4 right btn mgright"><i class="mdi-action-delete right"></i>حذف</a>
                            </div>
                        </div>';
            }
            $this->data['[VARITEMS]'] = $list;
        }
    }

    public function upfilecheck() {
        //check is set
        if (isset($_FILES['file']['name'])) {
            //check not empty
            if (strcmp($_FILES['file']['name'], '') != 0) {
                //check image extentions
                $ext = explode(".", $_FILES['file']['name']);
                $ext = end($ext);
                $allowext = UPEXTENTIONS;
                $allowext = explode(',', $allowext);
                if (in_array(strtolower($ext), $allowext)) {
                  
                    if (in_array(strtolower($ext), $allowext)) {
                        //check image not corrupted
                        return $ext;
                        //file is corrupted
                        return 3; //?
                    } else {
                        //mimetype not true
                        return 2;
                    }
                } else {
                    //extention not true
                    return 2;
                }
            } else {
                //file is empty
                return 1;
            }
        } else {
            //file not set
            return 1;
        }
    }

    public function del() {
        if (isset($_POST['id'])) {
            $this->model->del($_POST['id']);
            $filen = Utilities::imgname('files', $_POST['id']);
            $address = $_SERVER['DOCUMENT_ROOT'] .  PROJECTNAME . '/files/' . $filen . '.*';
            $fadd = glob($address);
            unlink($fadd[0]);
        }
    }

    public function editit() {
        $fields = array('subject', 'comment', 'id');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            if (Checkform::checknotempty($_POST, $fields)) {
                //check file
                //save site
                $rwid = ($_POST['id']); //
                $data['title'] = ($_POST['subject']); //
                $data['comment'] = ($_POST['comment']); //
                $this->model->editups($data, $rwid); //
                $data = array('id' => '1', 'msg' => 'اطلاعات با موفقیت ثبت شد.', 'fid' => $_POST['id']);
                $data = json_encode($data);
                $this->view->render('adminblog/index', $data, false, 0);
            } else {
                //all field requier
                $data = array('id' => '0', 'msg' => 'لطفا تمام فیلدها را پر کنید.');
                $data = json_encode($data);
                $this->view->render('adminblog/index', $data, false, 0);
            }
        } else {
            //all field requier
            $data = array('id' => '0', 'msg' => 'لطفا تمام فیلدها را پر کنید.');
            $data = json_encode($data);
            $this->view->render('adminblog/index', $data, false, 0);
        }
    }
}
