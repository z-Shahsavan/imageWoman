<?php

class contact extends Controller {

    function __construct() {
        parent::__construct();
    }

    public $data = array();

    public function index() {
        $this->loadaddress();
        $this->view->render('contact/index', $this->data);
    }

    public function loadaddress() {
        $txt = '';
        $result = $this->model->loadaddress();
        if ($result) {
            while ($row = $result->fetch()) {
                $txt.=' <div class="col-xs-12 col-md-6" style="padding: 40px 0px;">
                        <div class="row">
                            <p class="col-xs-12 right">تلفن : ' . htmlspecialchars($row['tell']) . '</p>
                            <p class="col-xs-12 right">نمابر : ' . htmlspecialchars($row['fax']) . '</p>
                            <p class="col-xs-12 right">پست الکترونیکی : ' . htmlspecialchars($row['mail']) . '</p>
                        </div>';
            }
        }
        $this->data["[VARADDRESS]"] = $txt;
    }

    public function saveform() {
        $fields = array('name', 'email', 'tel', 'message', 'mobile');

        if (Checkform::checkset($_POST, $fields)) {
            if (Checkform::checknotempty($_POST, $fields)) {

                if (mb_strlen($_POST['name'], 'utf-8') > 30) {
                    $data = array('id' => '0', 'msg' => 'حداقل کاراکتر ورودی برای نام رعایت نشده است.');
                    $data = json_encode($data);
                    $this->view->render('contact/index', $data, false, 0);
                }
                if (strlen(trim($_POST['tel'])) > 15 || Checkform::isinteger($_POST['tel']) == FALSE) {
                    //mobile not true
                    $data = array('id' => '0', 'msg' => 'شماره تلفن وارد شده صحیح نیست');
                    $data = json_encode($data);
                    $this->view->render('contact/index', $data, false, 0);
                    return FALSE;
                }
                if (strlen(trim($_POST['mobile'])) != 11 || Checkform::isinteger($_POST['mobile']) == FALSE) {
                    //mobile not true
                    $data = array('id' => '0', 'msg' => 'شماره موبایل صحیح نیست');
                    $data = json_encode($data);
                    $this->view->render('contact/index', $data, false, 0);
                    return FALSE;
                }
                if (Checkform::isemail($_POST['email']) == FALSE) {
                    //mobile not true
                    $data = array('id' => '0', 'msg' => 'ایمیل وارد شده صحیح نیست');
                    $data = json_encode($data);
                    $this->view->render('contact/index', $data, false, 0);
                    return FALSE;
                }


                $data = array('name' => ($_POST['name']), 'tell' => ($_POST['tel']), 'mobile' => ($_POST['mobile']), 'mail' => ($_POST['email']), 'message' => ($_POST['message']));
                if (md5($_POST['captcha_code']) == $_SESSION['random_txt']) {
                    $id = $this->model->saveform($data);
                    if ($id != null) {
                        $data = array('id' => '1', 'msg' => 'اطلاعات با موفقیت ثبت شد.');
                        $data = json_encode($data);
                        $this->view->render('contact/index', $data, false, 0);
                    } else {
                        
                    }
                } else {
                    $data = array('id' => '0', 'msg' => 'کد امنیتی وارد شده صحیح نیست.');
                    $data = json_encode($data);
                    $this->view->render('contact/index', $data, false, 0);
                }
            } else {
                //data is empty
                $data = array('id' => '0', 'msg' => 'لطفا تمامی موارد خواسته شده را وارد کنید');
                $data = json_encode($data);
                $this->view->render('contact/index', $data, false, 0);
            }
        } else {
            //data is empty
            $data = array('id' => '0', 'msg' => 'لطفا تمامی موارد خواسته شده را وارد کنید');
            $data = json_encode($data);
            $this->view->render('contact/index', $data, false, 0);
        }
    }

}
