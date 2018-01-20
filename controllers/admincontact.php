<?php

class admincontact extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::access_control('isuser', 'index#loginlink', 4);
    }

    public function index() {
        $this->load();
        $this->view->render('admincontact/index', $this->data);
    }

    public function load() {
        $result = $this->model->load();
        if ($result != FALSE) {
            $row = $result->fetch();
            $this->data['[VARVALUETELL]'] = htmlspecialchars($row['tell']);
            $this->data['[VARVALUEFAX]'] = htmlspecialchars($row['fax']);
            $this->data['[VARVALUEMAIL]'] = htmlspecialchars($row['mail']);
        }
    }

    public function editcontact() {
        $data = array();
        $fields = array('tel', 'fax', 'email');
        if (Checkform::checkset($_POST, $fields)) {

            if (Checkform::checknotempty($_POST, $fields)) {

                $data = array('tell' => ($_POST['tel']), 'fax' => ($_POST['fax']), 'mail' => ($_POST['email']));
                $this->model->editcontact($data);
                $data = array('id' => '1', 'msg' => 'اطلاعات با موفقیت ثبت شد.');
                $data = json_encode($data);
                $this->view->render('admincontact/index', $data, false, 0);
            } else {
                $data = array('id' => '0', 'msg' => 'لطفا فیلدها را پر کنید.');
                $data = json_encode($data);
                $this->view->render('admincontact/index', $data, false, 0);
            }
        } else {
            $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
            $data = json_encode($data);
            $this->view->render('admincontact/index', $data, false, 0);
        }
    }

    public function loadunreadmessage() {
        $txt = '';
        $result = $this->model->loadunreadmessage();
        if ($result != FALSE) {
            while ($row = $result->fetch()) {
                $txt.=' <div class="pitem">
                            <div class="id none">' . $row['id'] . '</div>
                            <div class="cnt col s12">
                                <h3 class="nm hd">نام و نام خانوادگی: <span>' . htmlspecialchars($row['name']) . '</span></h3>
                                <h3 class="tl hd">تلفن : <span>' . htmlspecialchars($row['tell']) . '</span></h3>
                                <h3 class="mb hd">موبایل : <span>' . htmlspecialchars($row['mobile']) . '</span></h3>
                                <h3 class="em hd">Email : <span>' . htmlspecialchars($row['mail']) . '</span></h3>
                                <h3 class="cmt hd">متن پیام : <span>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['message'])) . '</span></h3>
                            </div>
                            <div class="btnsdiv col s12">
                                <a class="delcmt bwaves-effect waves-white pink darken-4 right btn"><i class="mdi-action-delete right"></i>دیده شده</a>
                            </div>
                        </div>';
            }
        }
        $data = array('msg' => $txt);
        $data = json_encode($data);
        $this->view->render('admincontact/index', $data, false, 0);
        return FALSE;
    }

    public function updcmnt() {
        if (isset($_POST['dlt'])) {
            $dlt = $_POST['dlt'];
            $this->model->updcmnt($dlt);
        }
    }

    public function loadreadmessage() {
        $txt = '';
        $result = $this->model->loadreadmessage();
        if ($result != FALSE) {
            while ($row = $result->fetch()) {

                $txt.='    <div class="pitem">
                            <div class="cnt col s12">
                                <h3 class="nm hd">نام و نام خانوادگی: <span>' . htmlspecialchars($row['name']) . '</span></h3>
                                <h3 class="tl hd">تلفن : <span>' . htmlspecialchars($row['tell']) . '</span></h3>
                                <h3 class="mb hd">موبایل : <span>' . htmlspecialchars($row['mobile']) . '</span></h3>
                                <h3 class="em hd">Email : <span>' . htmlspecialchars($row['mail']) . '</span></h3>
                                <h3 class="cmt hd">متن پیام : <span>' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['message'])) . '</span></h3>
                            </div>
                        </div>';
            }
        }
        $data = array('msg' => $txt);
        $data = json_encode($data);
        $this->view->render('admincontact/index', $data, false, 0);
        return FALSE;
    }

}
