<?php

class activecod extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        if (Session::get('activecod') == 22) {
            $this->view->render('activecod/index', $this->data);
        } else {
            header('location:' . URL . 'index#loginlink');
            exit();
        }
    }

    public function checkcod() {
        $fields = array('newpass');
        $msgid = 0;
        $msgtext = '';
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            if (Checkform::checknotempty($_POST, $fields)) {
                $cond = 'activecod=:activecod';
                $condata = array('activecod' => ($_POST['newpass']));
                $result = $this->model->selectcod($cond, $condata);
//                $cond = 'activtime < ' . (time() - 540);
//                $re = $this->model->selnotact($cond);
//                if ($re) {
//                    while ($row = $re->fetch()) {
//                        $cond = 'id=:id AND confirm= 0';
//                        $condata = array('id' => $row['userid']);
//                        $result = $this->model->selctusers($cond, $condata);
//                        if ($result) {
//                                $this->model->deletusernotactiv($cond, $condata);
//                          
//                        }
//                    }
//                }
//                $resul = $this->model->delactivcod($cond);

//                $re=$this->model->delactuser($cond);
                $cond = 'activecod=:activecod';
                $condata = array('activecod' => ($_POST['newpass']));
                $res = $this->model->selectedcod($cond, $condata);
//                if ($result == TRUE && $res == FALSE) {
//                    $msgid = 2;
//                    $msgtext = '<a href="' . URL . 'forgot">اعتبار زمانی کدفعال سازی شما  پایان یافت برای دریافت کد جدید کلیک کنید.</a>';
//                }
            if ($result == FALSE) {
                    $msgid = 3;
                    $msgtext = 'کد وارد شده معتبر نیست';
                } elseif ($result == TRUE) {
                    $msgid = 1;
                    $row = $result->fetch();
                    $cond = 'id=' . $row['id'];
                    $this->model->delactivcod($cond);
                    $cond = 'mobile=' . $row['mobile'];
                    $resuser = $this->model->selecteduser($cond);
                    $rowuser = $resuser->fetch();
                    $msgtext = htmlspecialchars($rowuser['username']);
                    Session::set('activecod', 20);
                }
            } else {
                $msgid = 0;
                $msgtext = 'لطفا  رمز را وارد نمایید';
            }
        } else {
            $msgid = 0;
            $msgtext = 'لطفا رمز را وارد نمایید';
        }
        $data = array('id' => $msgid, 'msg' => $msgtext);
        $data = json_encode($data);
        $this->view->render('forgot/index', $data, false, 0);
        return FALSE;
    }

}
