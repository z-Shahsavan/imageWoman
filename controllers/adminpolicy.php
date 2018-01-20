<?php

class adminpolicy extends Controller {
    function __construct() {
        parent::__construct();
        Useraccess::access_control('isuser', 'index#loginlink', 4);
    }
    public function index() {
        $this->view->render('adminpolicy/index', $this->data);
    }
    
    public function loadrules(){
         $result = $this->model->loadrules();
         $item='';
        while($row = $result->fetch()){
            $item.='<div class="pitem" id="id'.$row['id'].'">
                            <div class="id none">'.$row['id'].'</div>
                            <div class="cnt col s12">
                                <h3 class="sbj hd">موضوع: <span>'.htmlspecialchars($row['rules']).'</span></h3>
                                <h3 class="cmt hd">توضیحات : <span>'. htmlspecialchars($row['comment']).' </span></h3>
                            </div>
                            <div class="btnsdiv col s12">
                                <a class="editcmp bwaves-effect waves-white teal darken-3 right btn"><i class="mdi-editor-mode-edit right"></i>ویرایش</a>
                                <a class="delcmt bwaves-effect waves-white pink darken-4 right btn mgright"><i class="mdi-action-delete right"></i>حذف</a>
                            </div>
                        </div>';
        }
        $data = array('msg' => $item);
        $data = json_encode($data);
        $this->view->render('adminpolicy/index', $data, false, 0);
        return FALSE;
    }

    public function regrules(){
        $data=array();
        $fields=array('subject','comment');
        if(Checkform::checkset($_POST, $fields)){
            if (Checkform::checknotempty($_POST, $fields)) {
                $data=array('rules'=>($_POST['subject']), 'comment'=>($_POST['comment']));
                $this->model->regrules($data);
                $data = array('id' => '1', 'msg' => 'اطلاعات با موفقیت ثبت شد.');
                $data = json_encode($data);
                $this->view->render('adminpolicy/index', $data, false, 0);
            }else {
                $data = array('id' => '0', 'msg' => 'لطفا فیلدها را پر کنید.');
                $data = json_encode($data);
                $this->view->render('adminpolicy/index', $data, false, 0);
            }
        }else {
            $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
            $data = json_encode($data);
            $this->view->render('adminpolicy/index', $data, false, 0);
        }
    }
     public function dltcmnt() {
         if (isset($_POST['dlt'])) {
             $dlt=$_POST['dlt'];
            $this->model-> deletcmnt($dlt);
         }
    }
    public function edepolicy() {
            $data=array();
            $fields=array('subjectmod','commentmod');
            if(Checkform::checkset($_POST, $fields)){
                if (Checkform::checknotempty($_POST, $fields)) {
                    $updata=array('rules'=>($_POST['subjectmod']),'comment'=>($_POST['commentmod']));
                    $condata=array('id'=>$_POST['idmod']);
                    $this->model->edepolicy($updata,$condata);
                    $data = array('id' => '1', 'msg' => 'اطلاعات با موفقیت ثبت شد.');
                    $data = json_encode($data);
                    $this->view->render('adminpolicy/index', $data, false, 0);
                }else {
                $data = array('id' => '0', 'msg' => 'لطفا فیلدها را پر کنید.');
                $data = json_encode($data);
                $this->view->render('adminpolicy/index', $data, false, 0);
            }
            }else {
            $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
            $data = json_encode($data);
            $this->view->render('adminpolicy/index', $data, false, 0);
        }           
        
    }
}