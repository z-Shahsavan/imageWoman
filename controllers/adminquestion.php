<?php

class adminquestion extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::access_control('isuser', 'index#loginlink', 4);
    }

    public function index() {
        $this->view->render('adminquestion/index', $this->data);
    }

    public function loadquestion() {
        $txt = '';
        $result = $this->model->loadquestion();
        if ($result != FALSE) {
            while ($row = $result->fetch()) {
                $txt .= '<div class="pitem" id="id'.$row['id'] .'">
                            <div class="id none">'.$row['id'].'</div>
                            <div class="cnt col s12">
                                <h3 class="sbj hd">سوال: <span>' .htmlspecialchars($row['question'])  . '</span></h3>
                                <h3 class="cmt hd">توضیحات : <span>' .htmlspecialchars($row['answer'])  . '</span></h3>
                            </div>
                            <div class="btnsdiv col s12">
                                <a class="editcmp bwaves-effect waves-white teal darken-3 right btn"><i class="mdi-editor-mode-edit right"></i>ویرایش</a>
                                <a class="delcmt bwaves-effect waves-white pink darken-4 right btn mgright"><i class="mdi-action-delete right"></i>حذف</a>
                            </div>
                        </div>';
            }
        }
        $data = array('msg' => $txt);
        $data = json_encode($data);
        $this->view->render('adminquestion/index', $data, false, 0);
        return FALSE;
    }

    public function savequestion() {
        $data = array();
        $fields = array('question', 'comment');
        if (Checkform::checkset($_POST, $fields)) {

            if (Checkform::checknotempty($_POST, $fields)) {

                $data = array('question' =>($_POST['question']) , 'answer' =>($_POST['comment']) );
                $this->model->savequestion($data);
                $data = array('id' => '1', 'msg' => 'اطلاعات با موفقیت ثبت شد.');
                $data = json_encode($data);
                $this->view->render('adminmethod/index', $data, false, 0);
            } else {
                $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
                $data = json_encode($data);
                $this->view->render('adminmethod/index', $data, false, 0);
            }
        } else {       //all field requier
            $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
            $data = json_encode($data);
            $this->view->render('adminmethod/index', $data, false, 0);
        }
    }

    public function dltcmnt() {
        if (isset($_POST['dlt'])) {
            $dlt = $_POST['dlt'];
            $this->model->deletcmnt($dlt);
        }
    }
        public function edequestion() {
            $data=array();
            $fields=array('modquestion','modcomment');
            if(Checkform::checkset($_POST, $fields)){
                if (Checkform::checknotempty($_POST, $fields)) {
                    $updata=array('question'=>($_POST['modquestion']) ,'answer'=>($_POST['modcomment']) );
                    $condata=array('id'=>$_POST['idmod']);
                    $this->model->edequestion($updata,$condata);
                    $data = array('id' => '1', 'msg' => 'اطلاعات با موفقیت ثبت شد.');
                    $data = json_encode($data);
                    $this->view->render('adminquestion/index', $data, false, 0);
                }else {
                $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
                $data = json_encode($data);
                $this->view->render('adminquestion/index', $data, false, 0);
            }
            }else {
            $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
            $data = json_encode($data);
            $this->view->render('adminquestion/index', $data, false, 0);
        }           
        
    }

}
