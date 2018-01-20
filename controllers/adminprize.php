<?php

class adminprize extends Controller {

    function __construct() {
        parent::__construct();
        Useraccess::access_control('isuser', 'index#loginlink', 4);
    }

    public function index() {
        $this->comps();
        $this->view->render('adminprize/index', $this->data);
    }

    public function comps() {
        $this->data['[VARCOMPS]'] = '';
        $res = $this->model->comps('isopen=3');
        if ($res) {
            while ($row = $res->fetch()) {
                $this->data['[VARCOMPS]'].='<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
            }
        }
    }

    public function upload() {
        $fields = array('competition', 'comment');
        if (Checkform::checkset($_POST, $fields)) {
            if (Checkform::checknotempty($_POST, $fields)) {
                $resisrepeat = $this->model->isrepeat('cmpid=:cid', array('cid' => $_POST['competition']));
                if ($resisrepeat) {//so have to edit:delete pictures and film and insert new s
                    $rowisrepeat = $resisrepeat->fetch();
                    $prizeid = $rowisrepeat['id'];
                    //delete from tbl_prize
                    $conddel = 'id=:id';
                    $condatadel = array('id' => $prizeid);
                    $this->model->deletelastprze($conddel, $condatadel);
                    //select all in tbl_prizefiles
                    $condselall = 'prizeid=:id';
                    $condataselall = array('id' => $prizeid);
                    $resall = $this->model->selectallfiles($condselall, $condataselall);
                    //delete images and videos
                    if ($resall) {
                        while ($rowall = $resall->fetch()) {
                            if ($rowall['type'] == 0) {//file is image
                                $address = $_SERVER['DOCUMENT_ROOT'] . '/' . PROJECTNAME . '/prize/image/' . Utilities::imgname('image', $rowall['id']) . '.*';
                                $imgadd = glob($address);
                                unlink($imgadd[0]);
                                $address = $_SERVER['DOCUMENT_ROOT'] . '/' . PROJECTNAME . '/prize/thumb/' . Utilities::imgname('thumb', $rowall['id']) . '.*';
                                $imgadd = glob($address);
                                unlink($imgadd[0]);
                            } elseif ($rowall['type'] == 1) {//file is video
                                $address = $_SERVER['DOCUMENT_ROOT'] . '/' . PROJECTNAME . '/prize/film/' . Utilities::imgname('film', $rowall['id']) . '.*';
                                $imgadd = glob($address);
                                unlink($imgadd[0]);
                            }
                        }
                        //delete all in tbl_prizefiles
                        $this->model->deleteallfile($condselall, $condataselall);
                    }
                    //insert in tbl_prize
                    $prizeid = $this->model->insertprize(array('cmpid' => $_POST['competition'], 'comment' => $_POST['comment']));
//                    $updaisread=array( 'comment' => $_POST['comment']);
//                    $condisread='cmpid=:cid';
//                    $codataisread=array('cid' => $_POST['competition']);
//                    $this->model->updateprize($updaisread,$condisread,$codataisread);
                } else {
                    $prizeid = $this->model->insertprize(array('cmpid' => $_POST['competition'], 'comment' => $_POST['comment']));
                }

                if ($prizeid) {
                    //check film file
                    $res = $this->upvidcheck();
                    if ($res) {
                        $vidtemp = explode(".", $_FILES['file_vid']['name']);
                        $vidext = end($vidtemp);
                        $id = $this->model->insertimg(array('prizeid' => $prizeid, 'type' => 1));
                        $vidname = Utilities::imgname('film', $id) . '.' . $vidext;
                        move_uploaded_file($_FILES["file_vid"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . "/prize/film/" . $vidname);
                    }
                    //extract zip file and save images
                    if (isset($_FILES["file_pics"]["name"])&& strlen(trim($_FILES["file_pics"]["name"])>0)) {
                        mkdir($_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . '/extract');
                        mkdir($_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . '/upload');
                        move_uploaded_file($_FILES["file_pics"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . '/' . PROJECTNAME . "/upload/" . $_FILES["file_pics"]["name"]);
                        $zip = new ZipArchive;
                        $res = $zip->open($_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . "/upload/" . $_FILES["file_pics"]["name"]);
                        $zip->extractTo($_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . "/extract/");
                        $zip->close();
                        $handle = opendir($_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . '/extract/');
                        while (false !== ($entry = readdir($handle))) {
                            $ok = $this->upimgcheck($entry, $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . '/extract/' . $entry);
                            if ($ok) {
                                $id = $this->model->insertimg(array('prizeid' => $prizeid, 'type' => 0));
                                $temp = explode(".", $entry);
                                $extension = end($temp);
                                $this->saveimageandthumb($extension, $id, $entry, 'extract', 'image', 'thumb', '/prize/image/', '/prize/thumb/');
                            }
                        }
                        $this->delTree($_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . '/extract');
                        $this->delTree($_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . '/upload');
                    }
                    $this->view->render('adminprize/index', json_encode(array('id' => '1', 'msg' => 'آپلود با موفقیت انجام شد')), false, 0);
                } else {
                    //insert unsuccess
                }
            } else {
                $this->view->render('adminprize/index', json_encode(array('id' => '0', 'msg' => 'لطفا تمام فیلدها را پر کنید.')), false, 0);
            }
        } else {
            $this->view->render('adminprize/index', json_encode(array('id' => '0', 'msg' => 'لطفا تمام فیلدها را پر کنید.')), false, 0);
        }
    }

    public static function saveimageandthumb($ext, $id, $name, $sourcefolder, $destfolder, $thumbfolder, $destpath, $thumbdestpath) {//,$thumbdestpath
        $imgname = Utilities::imgname($destfolder, $id) . '.jpg';
        $thmname = Utilities::imgname($thumbfolder, $id) . '.jpg';
        //save image
        $source = $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . "/" . $sourcefolder . "/" . $name;
        $dest = $_SERVER['DOCUMENT_ROOT'] . PROJECTNAME . $destpath . $imgname;
        copy($source, $dest);
        unlink($source);
        //convert ext to jpg & create thumb
        Photoutil::convertImage($_SERVER['DOCUMENT_ROOT'] . '/' . PROJECTNAME . $destpath . $imgname, $_SERVER['DOCUMENT_ROOT'] . '/' . PROJECTNAME . $destpath . $imgname, $ext, 100);
        Photoutil::make_thumb($_SERVER['DOCUMENT_ROOT'] . '/' . PROJECTNAME . $destpath . $imgname, $_SERVER['DOCUMENT_ROOT'] . '/' . PROJECTNAME . $thumbdestpath . $thmname, 300);
    }

    public function upimgcheck($filename, $path) {
        if (isset($filename)) {
            if (strcmp($filename, '') != 0) {
                $ext = explode(".", $filename);
                $ext = end($ext);
                $allowext = array("gif", "jpeg", "jpg", "png", "bmp");
                if (in_array(strtolower($ext), $allowext)) {
                    $imginfo_array = getimagesize($path);
                    if ($imginfo_array != false) {
                        $mime_type = $imginfo_array['mime'];
                        $ext = '';
                        switch ($mime_type) {
                            case "image/jpeg":
                            case "image/pjpeg":
                                $ext = 'jpg';
                                break;
                            case "image/png":
                                $ext = 'png';
                                break;
                            case "image/bmp":
                                $ext = 'bmp';
                                break;
                            case "image/gif":
                                $ext = 'gif';
                                break;
                        }
                        if (in_array(strtolower($ext), $allowext)) {
                            //if (ImageCreateFromString(file_get_contents($tempFile)) != false) {//check image not corrupted
                            return TRUE; //or return $ext;
                            // } else {
                            //  return 3; //image is corrupted
                            // }
                        } else {
                            return FALSE; //mimetype not true
                        }
                    } else {
                        return FALSE; //mimetype not true
                    }
                } else {
                    return FALSE; //file is empty
                }
            } else {
                return FALSE; //file not set
            }
        }
    }

    public function upvidcheck() {
        if (isset($_FILES['file_vid']['name'])) {
            if (strcmp($_FILES['file_vid']['name'], '') != 0) {
                $ext = explode(".", $_FILES['file_vid']['name']);
                $ext = end($ext);
                if (strcmp(strtolower($ext), 'mp4') == 0) {
                    return 1;
                }
            }
        }
        return 0;
    }

    public function delTree($dir) {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }

}
