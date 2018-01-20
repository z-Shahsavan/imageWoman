<?php

class adminupload extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::access_control('isuser', 'index#loginlink', 4);
    }

    public $data = array();

    public function index() {
         $this->load();
        $this->view->render('adminupload/index', $this->data);
    }

    public function load() {
        $result = $this->model->loadsiteinfo();
        $row = $result->fetch();
        $this->data['[VARVALUE1]'] = htmlspecialchars($row['min_size']);
        $this->data['[VARVALUE2]'] = htmlspecialchars($row['max_size']);
        $this->data['[VARVALUE3]'] = htmlspecialchars($row['max_siz_avatar']);
        $this->data['[VARVALUE5]'] = htmlspecialchars($row['width_img']);
        $this->data['[VARVALUE6]'] =htmlspecialchars( $row['height_img']);
        $ext=  explode(',', htmlspecialchars($row['format']));
        foreach($ext as $val){
            switch ($val){
                case 'jpg':
                case 'jpeg':
                    $this->data['[VARVALUE7]'] = 'checked="checked"';
                    break;
                case 'png':
                    $this->data['[VARVALUE8]'] = 'checked="checked"';
                    break;
                case 'gif':
                    $this->data['[VARVALUE9]'] = 'checked="checked"';
                    break;
            }
        }
        if ($row['watemark'] > 0) {
            $this->data['[VARVALUE10]'] = 'checked="checked"';
        }
    }

    public function configupload() {
         $data=array();
        $string = '';
        $fields = array('minsize', 'maxsize', 'maxavatar', 'widthimg', 'heightimg');
        //check isset
        if (Checkform::checkset($_POST, $fields)) {
            //check not empty
            $fields = array('widthimg', 'heightimg');
            if (Checkform::checknotempty($_POST, $fields)) {

                if (isset($_POST['iswatermark'])) {
                    $data = array('watemark' => 1);
                }else{
                    $data = array('watemark' => 0);
                }

                if (isset($_POST['jpg'])) {
                    $string.='jpg,jpeg';
                }
                if (isset($_POST['png'])) {
                    $string.=',png';
                }
                if (isset($_POST['gif'])) {
                    $string.= ',gif';
                }
                $data['format'] = htmlspecialchars($string);
                //save site
                if ($_POST['minsize'] < $_POST['maxsize']) {
                    $data['min_size'] = $_POST['minsize'];
                    $data['max_size'] = $_POST['maxsize'];
                } else {
                    //size not true
                    $data = array('id' => '0', 'msg' => 'حداقل سایز باید کوجکتر از حداکثر سایز باشد.');
                    $data = json_encode($data);
                    $this->view->render('adminupload/index', $data, false, 0);
                    return;
                }
               
                $data['max_siz_avatar'] = $_POST['maxavatar'];
                $data['width_img'] = $_POST['widthimg'];
                $data['height_img'] = $_POST['heightimg'];
                $this->model->saveconfigupload($data);
                $data = array('id' => '1', 'msg' => 'اطلاعات با موفقیت ثبت شد.');
                $data = json_encode($data);
                $this->view->render('adminupload/index', $data, false, 0);
            } else {
                //all field requier
                $data = array('id' => '0', 'msg' => 'لطفا تمام فیلدها را پر کنید.');
                $data = json_encode($data);
                $this->view->render('adminupload/index', $data, false, 0);
            }
        } else {
            //all field requier
            $data = array('id' => '0', 'msg' => 'لطفا تمام فیلدها را پر کنید.');
            $data = json_encode($data);
            $this->view->render('adminupload/index', $data, false, 0);
        }
    }

}
