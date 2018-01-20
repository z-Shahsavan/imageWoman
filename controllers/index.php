<?php

class index extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        if (!isset($_SESSION['isuser'])) {
            $this->loadslide();
            $this->loadtedadpic();
            $this->selectedpic();
//        $this->winnerpic();
//        $this->winnerpicmardomi();
            $this->data['[VARFORMHA]'] = '<div class="user-panel-new">
                
                <div class="titel-mi"><span>وارد شوید!</span></div><!-- end of titel-mi -->
                <div class="shape-1"></div>
                
                <form action="" enctype="multipart/form-data" id="formlogin" method="post" autocomplete="off" class="form-user-mi" >
                    <input type="text" id="username" name="username" placeholder="نام کاربری">
                    <input type="password" id="password" name="password"  placeholder="رمز عبور"><br/>

                    <button id="btnlogin" type="button" class="btn-mi">ورود</button>
                    <div class="">
                        <div class="col-md-12">
                            <div id="msgloginerr" class="text-right paddingtopbottom5 alert-error" style="display: none;font-family: iran;">لطفا اطلاعات را وارد کنید.</div>
                            <!--<div id="msgsucmod" class="text-right paddingtopbottom5 alert-ok">اطلاعات با موفقیت ثبت شد.</div>-->
                        </div>
                    </div>
                </form><!-- end of titel-mi -->
                
                <form id="formreguser" method="post" action="" name="register_form" class="form-user-mi hide" >
                    <input id="regusername" name="regusername" type="text" placeholder="نام کاربری">
                    <input type="password" id="regpassword" name="regpassword" placeholder="گذر واژه">
                    <input type="text" id="regmobuser" name="regmobuser" placeholder="شماره تلفن همراه"><br/>
                    <button id="reguserbtn" type="button" class="btn-mi">ثبت نام</button>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="registererrdiv" class="text-right paddingtopbottom5 alert-error" style="display: none;font-family: iran;">لطفا اطلاعات را وارد کنید.</div>
                            <!--<div id="msgsuc" class="text-right paddingtopbottom5 alert-ok" style="display: none;font-family: iran;">اطلاعات با موفقیت ثبت شد.</div>-->
                        </div>
                    </div>
                </form><!-- end of reguser -->

                <form id="formreguserpg2" method="post" autocomplete="off" class="hide active-code-mi">
                    <p>کد فعالسازی به تلفن همراه شما ارسال شد!</p>
                    <label for="password">کد فعالسازی:</label>
                    <input type="text" class="form-control" name="regactcode" placeholder="کد فعالسازی را وارد نمایید">
                    <div class="btn-section">
                        <button id="reguserbtnpg2" type="button" class="btn btn-primary" style="float:initial !important;">
                            <span class="glyphicon glyphicon-ok"></span>
                            تایید
                        </button>
                        <button id="activecode" onclick="sendcode()" type="button" class="btn btn-primary left-section" style="float: left !important;width: 170px !important;display:none;    margin-top: 10px;">
                            <span style="font-size:12px;">کد فعالسازی دریافت نکرده اید؟</span>
                        </button> 
                        <span id="activecodetimer" class="left-section left-section-second">55</span>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="registererrdivact" class="text-right paddingtopbottom5 alert-error" style="display: none;">لطفا اطلاعات را وارد کنید.</div>
                            <div id="msgerr" class="text-right paddingtopbottom5 alert-ok" style="display: none;">اطلاعات با موفقیت ثبت شد.</div>
                            <div id="msgsuc" class="text-right paddingtopbottom5 alert-ok" style="display: none;">اطلاعات با موفقیت ثبت شد.</div>
                        </div>
                    </div>
                </form><!-- end of code-active form -->


                <form action="#" id="formreg" method="post" autocomplete="off" class="form-user-mi2 hide">
                    <input id="mobile" name="mobile" type="text" placeholder="شماره تلفن همراه">
                    <input type="text" name="captcha_code" autocomplete="off" id="Captcha1Edit"  placeholder="کد امنیتی">
                    <img src="[VARURL]captcha/captcha.php" id="captcha" alt="Click for new image" title="Click for new image" 
                         style="cursor: pointer; width: 100px; height: 43px; font-size: 10px;border: 1px solid #A7A7A7;" onclick="this.src = "[VARURL]captcha/captcha.php?" + Math.random()" />
                    <br/>
                    <button id="send" type="button" class="btn-mi">ارسال کد فعال سازی</button>
                    <div class="row">
                        <div id="msgerr4" class="col-xs-12 pink-text text-darken-3" style="display: none;font-family: iran;color: red;">این یک پیام است</div>
                        <div id="msgsuc4" class="col-xs-12 teal-text text-darken-1" style="display: none;font-family: iran;">این یک پیام است</div>
                    </div>
                </form><!-- end of titel-mi -->
                

                <form action="#" id="formregactivcod" method="post" autocomplete="off" class=" form-user-mi2 hide"  >
                    <input id="newpass" name="newpass" type="text" placeholder="کد فعال سازی">
                    <br/>
                    <button type="button" id="sendactcod" class="btn-mi">تایید</button>
                    <div class="row marginbottom10">
                        <div id="msgerrs" class="col-xs-12 pink-text text-darken-3" style="display: none;font-family: iran;color: red;">این یک پیام است</div>
                        <div id="msgsucs" class="col-xs-12 teal-text text-darken-1" style="display: none;font-family: iran;">این یک پیام است</div>
                    </div>
                </form><!-- end of titel-mi -->
                

                <form action="#" id="formpassword" method="post" autocomplete="off" class="padding10form col-md-12 mgtop z-depth-1 reltive minsh mgbtm bgblur bdr hide" style="font-family:iran;direction: rtl;padding: 0px 40px;">
                          <h4 class="flow-text blue-grey darken-3 text-center padding10">پسورد جدید</h4>
                          <div class="row mgtop">
                              <div class="input-field col-xs-12">
                                  <i class="mdi-social-person prefix"></i>  
                                  [VARUSER]
                              </div>
                          </div>
                          <div class="row mgtop">
                              <div class="input-field col-xs-12">
                                  <i class="mdi-action-lock prefix"></i>
                                  <label for="password">رمز عبور جدید</label>
                                  <input id="password" name="password" type="password" class="validate ltr form-control">
                              </div>
                          </div>

                          <div class="row">
                              <div class="input-field col-xs-12">
                                  <i class="mdi-action-lock prefix"></i>
                                  <label for="confrim">تکرار رمز عبور</label>
                                  <input id="confrim" name="confrim" type="password" class="validate ltr form-control">
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-xs-12 col-md-6 right">
                                  <button class="btn waves-effect purple darken-2 pdbtn form-control btnsending btn-primary" style="margin-top:10px;" type="button" id="changepasssend" name="action">
                                      تایید
                                      <i class="mdi-content-send right"></i>
                                  </button>
                              </div>
                          </div>
                          <div class="row padding10">
                              <div id="errpass" class="col-xs-12 pink-text text-darken-3 none">این یک پیام است</div>
                              <div id="msgpass" class="col-xs-12 teal-text text-darken-1 none">این یک پیام است</div>
                          </div>
                      </form>
                      
                <hr class="hr-footer"/>
                
                <div class="row footer-mi">
                    <span id="txt-member" data-text="1" class="border-left">عضو نیستید؟ ثبت نام کنید</span>
                    <span id="passforget">رمز عبور را فراموش کردم</span>
                </div><!-- footer-mi -->
                
            </div><!-- end of user-panel-new -->';
            $this->view->render('index/index', $this->data);
        } else {
            $uid = Session::get('isuser');
            if (Session::get('isavatar') == 1) {
                $imgname = Utilities::imgname('avatar', Session::get('userid')) . '.jpg';
                $vatar = URL . 'images/avatar/' . $imgname;
            } else {
                $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                $vatar = URL . 'images/avatar/' . $imgname;
            }
            $usertime = Shamsidate::jdate('l d F oساعت h:i دقیقه A', Session::get('lastlogin'));
            $nameandfam = Session::get('nameandfam');
            $numpic = Session::get('numberpic');
            $score = Session::get('score');
             $timenow = Shamsidate::jdate('o/m/d');
               $numofnotify = '[VARNUMOFNOTIFY]';
            switch ($uid) {
                case 1:
 $this->data['[VARFORMHA]'] = ' <div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 paddingrightleft0">
				<header>
					
					<div class="top-menu col-md-9 col-sm-12 col-xs-12">
						<ul class="col-md-12 col-xs-12">
							<li class="col-md-4 col-sm-12 col-xs-12">
								<div class="user-profile">
									<a  href="' . URL . 'blog/id/' . Session::get('userid') . '">
										<img src="' . $vatar . '">
										<span>' . $nameandfam . '</span>
									</a>
								</div>
								<div class="score-image">
									<a href="#">
										<i class="glyphicon glyphicon-picture tooltipped" data-toggle="tooltip" data-placement="right" title="تعداد عکس"></i>' . $numpic . '								
									</a>
									<a href="#">
										<i class="glyphicon glyphicon-star tooltipped" data-toggle="tooltip" data-placement="right" title="امتیاز"></i>' . $score . '
									</a>
								</div>
							</li>
							<li class="col-md-4 col-sm-12 col-xs-12">
								<div class="user-details">
									<ul>
										<li><a href="' . URL . 'blog/id/' . Session::get('userid') . '" data-placement="bottom" class="glyphicon glyphicon-user tooltipped" data-toggle="tooltip" title="بخش کاربری"></a></li>
										<li><a href="' . URL . 'upload" data-placement="bottom" class="glyphicon glyphicon-upload tooltipped" data-toggle="tooltip" data-toggle="tooltip" title="آپلود عکس"></a></li>
										<li>' . $numofnotify . '<a href="' . URL . 'notifyread" data-placement="bottom" class="glyphicon glyphicon-bell tooltipped" data-toggle="tooltip" title="اعلان"></a></li>
										<li><a href="' . URL . 'setting" data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-cog tooltipped" data-toggle="tooltip" title="تنظیمات"></a></li>
										<li><a href="' . URL . 'index/logout"  data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-log-out tooltipped" data-toggle="tooltip" title="خروج"></a></li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</header>
			</div>
		</div>
	</div>';

                    break;
                case 2:

 $this->data['[VARFORMHA]'] = '	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 paddingrightleft0">
				<header>
					
					<div class="top-menu col-md-9 col-sm-12 col-xs-12">
						<ul class="col-md-12 col-xs-12">
							<li class="col-md-4 col-sm-12 col-xs-12">
								<div class="user-profile">
									<a  href="' . URL . 'blog/id/' . Session::get('userid') . '">
										<img src="' . $vatar . '">
										<span>' . $nameandfam . '</span>
									</a>
								</div>
								<div class="score-image">
									<a href="#">
										<i class="glyphicon glyphicon-picture tooltipped" data-placement="right" data-toggle="tooltip" title="تعداد عکس"></i>' . $numpic . '								
									</a>
									<a href="#">
										<i class="glyphicon glyphicon-star tooltipped" data-placement="right" data-toggle="tooltip" title="امتیاز"></i>' . $score . '
									</a>
								</div>
							</li>
							<li class="col-md-4 col-sm-12 col-xs-12">
								<div class="user-details">
									<ul>
										<li><a href="' . URL . 'verdict" data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-user tooltipped" title="بخش داوری"></a></li>
										<li><a href="' . URL . 'upload" data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-upload tooltipped" title="آپلود عکس"></a></li>
										<li>' . $numofnotify . '<a href="' . URL . 'notifyread" data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-bell tooltipped" title="اعلان"></a></li>
										<li><a href="' . URL . 'setting" data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-cog tooltipped" title="تنظیمات"></a></li>
										<li><a href="' . URL . 'index/logout"  data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-log-out tooltipped" title="خروج"></a></li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</header>
			</div>
		</div>
	</div>';
                    break;
                case 3:

 $this->data['[VARFORMHA]'] = '	<div class="container">
		<div class="row">
			<div class="col-lg-12 col-md-12 paddingrightleft0">
				<header>
					
					<div class="top-menu col-md-9 col-sm-12 col-xs-12">
						<ul class="col-md-12 col-xs-12">
							<li class="col-md-4 col-sm-12 col-xs-12">
								<div class="user-profile">
									<a  href="' . URL . 'blog/id/' . Session::get('userid') . '">
										<img src="' . $vatar . '">
										<span>' . $nameandfam . '</span>
									</a>
								</div>
								<div class="score-image">
									<a href="#">
										<i class="glyphicon glyphicon-picture tooltipped" data-placement="right" data-toggle="tooltip" title="تعداد عکس"></i>' . $numpic . '								
									</a>
									<a href="#">
										<i class="glyphicon glyphicon-star tooltipped" data-placement="right" data-toggle="tooltip" title="امتیاز"></i>' . $score . '
									</a>
								</div>
							</li>
							<li class="col-md-4 col-sm-12 col-xs-12">
								<div class="user-details">
									<ul>
										<li><a href="' . URL . 'bazbin" data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-user tooltipped" title="بخش بازبینی"></a></li>
										<li><a href="' . URL . 'upload" data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-upload tooltipped" title="آپلود عکس"></a></li>
										<li>' . $numofnotify . '<a href="' . URL . 'notifyread" data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-bell tooltipped" title="اعلان"></a></li>
										<li><a href="' . URL . 'setting" data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-cog tooltipped" title="تنظیمات"></a></li>
										<li><a href="' . URL . 'index/logout"  data-toggle="tooltip" data-placement="bottom" class="glyphicon glyphicon-log-out tooltipped" title="خروج"></a></li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</header>
			</div>
		</div>
	</div>';
                    break;
                case 4:
 $this->data['[VARFORMHA]'] = '	<div class="container">
		<div class="row"  style="margin-bottom:0px;">
			<div class="col-lg-12 col-md-12 paddingrightleft0">
				<header>
					
					<div class="top-menu col-md-9 col-sm-12 col-xs-12">
						<ul class="col-md-12 col-xs-12">
							<li class="col-md-4 col-sm-12 col-xs-12">
								<div class="user-profile">
									<a  href="' . URL . 'blog/id/' . Session::get('userid') . '">
										<img src="' . $vatar . '">
										<span>' . $nameandfam . '</span>
									</a>
								</div>
								<div class="score-image">
									<a href="#">
										<i class="glyphicon glyphicon-picture tooltipped" data-position="right" data-delay="50" data-tooltip="تعداد عکس" data-toggle="tooltip" data-placement="right" title="تعداد عکس"></i>' . $numpic . '								
									</a>
									<a href="#">
										<i class="glyphicon glyphicon-star tooltipped" data-position="right" data-delay="50" data-tooltip="امتیاز" data-toggle="tooltip" data-placement="right" title="امتیاز"></i>' . $score . '
									</a>
								</div>
							</li>
							<li class="col-md-4 col-sm-12 col-xs-12">
								<div class="user-details">
									<ul>
										<li><a href="' . URL . 'adminuser" data-position="bottom" data-delay="50" class="glyphicon glyphicon-user tooltipped" data-tooltip="بخش مدیریت" data-toggle="tooltip" data-placement="bottom" title="بخش مدیریت"></a></li>
										<li><a href="' . URL . 'upload" data-position="bottom" data-delay="50" class="glyphicon glyphicon-upload tooltipped" data-tooltip="آپلود عکس" data-toggle="tooltip" data-placement="bottom" title="آپلود عکس"></a></li>
										<li>' . $numofnotify . '<a href="' . URL . 'notifyread" data-position="bottom" data-delay="50" class="glyphicon glyphicon-bell tooltipped" data-tooltip="اعلان" data-toggle="tooltip" data-placement="bottom" title="اعلان"></a></li>
										<li><a href="' . URL . 'setting" data-position="bottom" data-delay="50" class="glyphicon glyphicon-cog tooltipped" data-tooltip="تنظیمات" data-toggle="tooltip" data-placement="bottom" title="تنظیمات"></a></li>
										<li><a href="' . URL . 'index/logout" data-position="bottom" data-delay="50" class="glyphicon glyphicon-log-out tooltipped" data-tooltip="خروج" data-toggle="tooltip" data-placement="bottom" title="خروج"></a></li>
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</header>
			</div>
		</div>
	</div>';

                    break;
            }
            $this->loadslide();
            $this->loadtedadpic();
            $this->selectedpic();
           
            $this->view->render('index/index', $this->data);
        }
    }

    const TOP = 12;

    public function loadtedadpic() {
        $numpic = 0;
        $tedad = 0;
        $tedaduser = 0;
        $item = '';
        $cond = 'isopen!=3 AND isopen!=0 AND hasposter=1 ORDER by id DESC';
        $pics = $this->model->loadslide($cond);
        if ($pics) {
            $row = $pics->fetch();
            $cond = 'id=:id';
            $condata = array('id' => $row['id']);
            $res = $this->model->loadpic($cond, $condata);
            if ($res) {
                $rowp = $res->fetch();
                $numpic = $rowp['numofpic'];
            }
            $condok = 'compid=:compid AND confirm=1';
            $condatak = array('compid' => $row['id']);
            $result = $this->model->loadpics($condok, $condatak);
            if ($result) {
                $tedad = $result->rowCount();
            }
            $condu = 'compid=:compid group by userid';
            $condatau = array('compid' => $row['id']);
            $resul = $this->model->loaduser($condu, $condatau);
            if ($resul) {
                $tedaduser = $resul->rowCount();
            }
        }
        $item .= '  <div class="sendimage col-md-12">
                        <div class="row">
                            <div class="details-sendimage">
                                <span>عکس های ارسال شده</span>
                                <h3 id="sendphoto"> ' . $numpic . ' عکس</h3>
                            </div>
                            <div class="image-sendimage">
                                <img src="[VARURL]images/icons/sendimage-icon.png" alt="عکس های ارسال شده" class="img-responsive" />
                            </div>
                        </div>
                    </div>
                    <div class="confirmationimage col-md-12">
                        <div class="row">
                            <div class="details-confirmationimage">
                                <span>عکس های تایید شده</span>
                                <h3 id="okphoto">' . $tedad . ' عکس</h3>
                            </div>
                            <div class="image-confirmationimage">
                                <img src="[VARURL]images/icons/confirmationimage-icon.png" alt="عکس های تایید شده" class="img-responsive" />
                            </div>	
                        </div>
                    </div>
                    <div class="participantimage col-md-12">
                        <div class="row">
                            <div class="details-participantimage">
                                <span>تعداد شرکت کنندگان</span>
                                <h3 id="tedadsh">' . $tedaduser . ' نفر</h3>
                            </div>
                            <div class="image-participantimage">
                                <img src="[VARURL]images/icons/participantimage-icon.png" alt="تعداد شرکت کنندگان" class="img-responsive" />
                            </div>		
                        </div>
                    </div>';

        $this->data['[VARTEDAD]'] = $item;
    }

    public function loadslide() {
        $cond = 'isopen!=3 AND isopen!=0 AND hasposter=1 ORDER by id DESC';
        $pics = $this->model->loadslide($cond);
        if ($pics) {
            $item = '';
            $active = 'active';
            while ($row = $pics->fetch()) {
                $imgname = Utilities::imgname('poster', $row['id']) . '.jpg';
                $imgback = URL . '/images/poster/' . $imgname;
                $item .='<div class="item ' . $active . '">
                  <input type="hidden" id="compid" value="' . $row['id'] . '">
			<img src="' . $imgback . '" alt="slider" class="img-responsive">
                             <div class="carousel-caption">
                         </div>
                    </div>';
                $active = '';
            }
            $this->data['[VARIMGSLIDE]'] = $item;
        }
    }

    public function numofpics() {

        $numpic = 0;
        $tedad = 0;
        $tedaduser = 0;
        if (isset($_POST['cid'])) {
//            echo $_POST['cid'];
            $cond = 'id=:id';
            $condata = array('id' => $_POST['cid']);
            $res = $this->model->loadpic($cond, $condata);
            if ($res) {
                $row = $res->fetch();
                $numpic = $row['numofpic'];
            }
            $condok = 'compid=:compid AND confirm=1';
            $condatak = array('compid' => $_POST['cid']);
            $result = $this->model->loadpics($condok, $condatak);
            if ($result) {
                $tedad = $result->rowCount();
            }
            $condu = 'compid=:compid group by userid';
            $condatau = array('compid' => $_POST['cid']);
            $resul = $this->model->loaduser($condu, $condatau);
            if ($resul) {
                $tedaduser = $resul->rowCount();
            }
            $data = array('tedadpic' => $numpic, 'okpic' => $tedad, 'user' => $tedaduser);
            $return = json_encode($data);
            echo $return;
            //$this->view->render('index/index', $return, false, 0);
            return FALSE;
        }
    }

    public function selectedpic() {
//        $cond = 'confirm=1 AND (iswin=2 OR iswin=5) ORDER BY pid DESC Limit ';
        $cond = 'confirm=1 AND iswin=1 OR iswin=3 OR iswin=4 ORDER BY pid DESC Limit ';
        Session::set('cond1', $cond);
        $cond.=self::TOP;
        $res = $this->model->forselectedpic($cond);
        if ($res) {
            $reall = '';
            $i = 0;
            while ($row = $res->fetch()) {
                if ($row['isavatar'] == 1) {
                    $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                    $vatar = URL . 'images/avatar/' . $imgname;
                } else {
                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                    $vatar = URL . 'images/avatar/' . $imgname;
                }
                $imgname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                $ashar = explode('.', $row['imglike']);
                if ($row['peopelwinno'] != 0) {
                    $ispeople = 1;
                }
                if ($row['uname'] != '' && $row['uf'] != '') {
                    $username = htmlspecialchars($row['uname'] . ' ' . $row['uf']);
                } else {
                    $username = htmlspecialchars($row['username']);
                }
                $reall.=' <div class="brick" id="gallery">
                    <input type="hidden" name="idpic" value="' . $row['pid'] . '">
                                    <div class="image-head">
                                        <div class="score-image1';
                if ($row['imglike'] == 0) {
                    $reall.=' none';
                }if ($ashar[1] == 0) {
                    $rate = $ashar[0];
                } else {
                    $rate = $row['imglike'];
                }
                $reall.='"><img src="' . URL . 'images/icons/score-icon.png" />
                                            <span>' . $rate . '</span>
                                        </div>
                                        <a href="' . URL . 'blog/id/' . htmlspecialchars($row['userid']) . '">
                                            <div class="details-image1">
                                      <img  class="av" src="' . $vatar . '" />';
                $len = mb_strlen($row['pn']);
                if ($len != 0) {
                    $reall.=' <span class="pn">' . htmlspecialchars($row['pn']) . ' </span>';
                } else {
                    $reall.=' <span class="pn"></span>';
                }
                $reall.=' </div>
                                </a>
                             </div>
                             <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">
                             </a>
                             <div class="id none">' . $row['pid'] . '</div>
                                 <div class="us none"><a href="' . URL . 'blog/id/' . htmlspecialchars($row['userid']) . '" class="userlink" >' . $username . '</a></div>
                                <div class="dt none">' . Shamsidate::jdate('j F Y', $row['pdate']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['pcmt'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['compid'] . '" id="cmp">' . htmlspecialchars($row['cname']) . '</a></div>
                                <div class="rt none">' . $rate . '</div>
                       </div>
                  ';
                $i++;
            }
            if (isset($_POST['state'])) {
                $this->view->render('index/index', $reall, FALSE, 0);
            } else {
                $this->data['[VARWINPIC]'] = $reall;
            }
        }
    }

    public function winnerpic() {
        $cond = 'confirm=1 AND iswin=1 OR iswin=3 OR iswin=4 ORDER BY pid DESC Limit ';
        Session::set('cond2', $cond);
        $cond.=self::TOP;
        $res = $this->model->forselectedpic($cond);
        if ($res) {
            $reall = '';
            $i = 0;
            while ($row = $res->fetch()) {
                if ($row['peopelwinno'] != 0) {
                    $ispeople = 1;
                } else {
                    $ispeople = 0;
                }
                if ($row['isavatar'] == 1) {
                    $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                    $vatar = URL . 'images/avatar/' . $imgname;
                } else {
                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                    $vatar = URL . 'images/avatar/' . $imgname;
                }
                $imgname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                $ispeople = 0;
                $ashar = explode('.', $row['imglike']);

                if ($row['uname'] != '' && $row['uf'] != '') {
                    $username = htmlspecialchars($row['uname'] . ' ' . $row['uf']);
                } else {
                    $username = htmlspecialchars($row['username']);
                }
                $reall.=' <div class="brick" id="gallery">
                    <input type="hidden" name="idpic" value="' . $row['pid'] . '">
                                    <div class="image-head">
                                        <div class="score-image1';
                if ($row['imglike'] == 0) {
                    $reall.=' none';
                }if ($ashar[1] == 0) {
                    $rate = $ashar[0];
                } else {
                    $rate = $row['imglike'];
                }//echo $rate;
                $reall.='"><img src="' . URL . 'images/icons/score-icon.png" />
                                            <span>' . $rate . '</span>
                                        </div>
                                        <a href="' . URL . 'blog/id/' . htmlspecialchars($row['userid']) . '">
                                            <div class="details-image1">
                                      <img  class="av" src="' . $vatar . '" />';
                $len = mb_strlen($row['pn']);
                if ($len != 0) {
                    $reall.=' <span class="pn">' . htmlspecialchars($row['pn']) . ' </span>';
                } else {
                    $reall.=' <span class="pn"></span>';
                }
                $reall.=' </div>
                                </a>
                             </div>
                             <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">
                             </a>
                             <div class="id none">' . $row['pid'] . '</div>
                                 <div class="us none"><a href="' . URL . 'blog/id/' . htmlspecialchars($row['userid']) . '" class="userlink" >' . $username . '</a></div>
                                <div class="dt none">' . Shamsidate::jdate('j F Y', $row['pdate']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['pcmt'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['compid'] . '" id="cmp">' . htmlspecialchars($row['cname']) . '</a></div>
                                <div class="rt none">' . $rate . '</div>
                       </div>
                  ';
                $i++;
            }
            $this->view->render('index/index', $reall, FALSE, 0);
//            $this->data['[VARWINPIC]'] = $reall;
        }
    }

//
    public function winnerpicmardomi() {
        $cond = 'confirm=1 AND iswin=1 OR iswin=3 OR iswin=4 ORDER BY pid DESC Limit ';
        Session::set('cond3', $cond);
        $cond.=self::TOP;
        $res = $this->model->forselectedpic($cond);
        if ($res) {
            $reall = '';
            $i = 0;
            while ($row = $res->fetch()) {
                if ($row['peopelwinno'] != 0) {
                    $ispeople = 1;
                } else {
                    $ispeople = 0;
                }
                if ($row['isavatar'] == 1) {
                    $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                    $vatar = URL . 'images/avatar/' . $imgname;
                } else {
                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                    $vatar = URL . 'images/avatar/' . $imgname;
                }
                $imgname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                $ashar = explode('.', $row['imglike']);

                if ($row['uname'] != '' && $row['uf'] != '') {
                    $username = htmlspecialchars($row['uname'] . ' ' . $row['uf']);
                } else {
                    $username = htmlspecialchars($row['username']);
                }
                if ($ispeople == 1) {
                    $reall.=' <div class="brick" id="gallery">
                    <input type="hidden" name="idpic" value="' . $row['pid'] . '">
                                    <div class="image-head">
                                        <div class="score-image1';
                    if ($row['imglike'] == 0) {
                        $reall.=' none';
                    }if ($ashar[1] == 0) {
                        $rate = $ashar[0];
                    } else {
                        $rate = $row['imglike'];
                    }
                    $reall.='"><img src="' . URL . 'images/icons/score-icon.png" />
                                            <span>' . $rate . '</span>
                                        </div>
                                        <a href="' . URL . 'blog/id/' . htmlspecialchars($row['userid']) . '">
                                            <div class="details-image1">
                                      <img  class="av" src="' . $vatar . '" />';
                    $len = mb_strlen($row['pn']);
                    if ($len != 0) {
                        $reall.=' <span class="pn">' . htmlspecialchars($row['pn']) . ' </span>';
                    } else {
                        $reall.=' <span class="pn"></span>';
                    }
                    $reall.=' </div>
                                </a>
                             </div>
                             <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">
                             </a>
                             <div class="id none">' . $row['pid'] . '</div>
                                 <div class="us none"><a href="' . URL . 'blog/id/' . htmlspecialchars($row['userid']) . '" class="userlink" >' . $username . '</a></div>
                                <div class="dt none">' . Shamsidate::jdate('j F Y', $row['pdate']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['pcmt'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['compid'] . '" id="cmp">' . htmlspecialchars($row['cname']) . '</a></div>
                                <div class="rt none">' . $rate . '</div>
                       </div>
                  ';
                    $i++;
                }
            }
//            $this->data['[VARMARDOMIPIC]'] = $reall;
            $this->view->render('index/index', $reall, FALSE, 0);
        }
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
                    $this->view->render('adminmethod/index', $data, false, 0);
                } else {       //all field requier
                    $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
                    $data = json_encode($data);
                    $this->view->render('index/index', $data, false, 0);
                }
            } else {       //all field requier
                $data = array('id' => '0', 'msg' => 'لطفا اطلاعات را وارد کنید.');
                $data = json_encode($data);
                $this->view->render('index/index', $data, false, 0);
            }
        } else {
            
        }
    }

    public function paging() {
        if (isset($_POST['pgid'])) {
            $lmt = self::TOP * ($_POST['pgid'] - 1);
            switch ($_POST['whichpg']) {
                case 1: {
                        $cond = Session::get('cond1') . ':lmt , :top';
                        $condata = array('lmt' => $lmt, 'top' => self::TOP);
                        $res = $this->model->forselectedpic($cond, $condata);
                        if ($res) {
                            $reall = '';
                            $i = 0;
                            while ($row = $res->fetch()) {
                                if ($row['isavatar'] == 1) {
                                    $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                                    $vatar = URL . 'images/avatar/' . $imgname;
                                } else {
                                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                                    $vatar = URL . 'images/avatar/' . $imgname;
                                }
                                $imgname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                                if ($row['peopelwinno'] != 0) {
                                    $ispeople = 1;
                                }
                                if ($row['uname'] != '' && $row['uf'] != '') {
                                    $username = htmlspecialchars($row['uname'] . ' ' . $row['uf']);
                                } else {
                                    $username = htmlspecialchars($row['username']);
                                }

                                $reall.=' <div class="brick" id="gallery">
                    <input type="hidden" name="idpic" value="' . $row['pid'] . '">
                                    <div class="image-head">
                                        <div class="score-image1">
                                            <img src="' . URL . 'images/icons/score-icon.png" />
                                            <span>' . $row['imglike'] . '</span>
                                        </div>
                                        <a href="' . URL . 'blog/id/' . htmlspecialchars($row['userid']) . '">
                                            <div class="details-image1">
                                      <img  class="av" src="' . $vatar . '" />';
                                $len = mb_strlen($row['pn']);
                                if ($len != 0) {
                                    $reall.=' <span class="pn">' . htmlspecialchars($row['pn']) . ' </span>';
                                } else {
                                    $reall.=' <span class="pn"></span>';
                                }
                                $reall.=' </div>
                                </a>
                             </div>
                             <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">
                             </a>
                             <div class="id none">' . $row['pid'] . '</div>
                                 <div class="us none"><a class="userlink" >' . $username . '</a></div>
                                <div class="dt none">' . Shamsidate::jdate('j F Y', $row['pdate']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['pcmt'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['compid'] . '" id="cmp">' . htmlspecialchars($row['cname']) . '</a></div>
                                <div class="rt none">' . $row['imglike'] . '</div>
                       </div>
                  ';
                                $i++;
                            }
                            $this->view->render('index/index', $reall, FALSE, 0);
                        }
                        break;
                    }
                case 2: {
                        $cond = Session::get('cond2') . ':lmt , :top';
                        $condata = array('lmt' => $lmt, 'top' => self::TOP);
                        $res = $this->model->forselectedpic($cond, $condata);
                        if ($res) {
                            $reall = '';
                            $i = 0;
                            while ($row = $res->fetch()) {
                                if ($row['isavatar'] == 1) {
                                    $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                                    $vatar = URL . 'images/avatar/' . $imgname;
                                } else {
                                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                                    $vatar = URL . 'images/avatar/' . $imgname;
                                }
                                $imgname = Utilities::imgname('thumb', $row['pid']) . '.jpg';
                                if ($row['peopelwinno'] != 0) {
                                    $ispeople = 1;
                                } else {
                                    $ispeople = 0;
                                }
                                if ($row['uname'] != '' && $row['uf'] != '') {
                                    $username = htmlspecialchars($row['uname'] . ' ' . $row['uf']);
                                } else {
                                    $username = htmlspecialchars($row['username']);
                                }
                                $reall.=' <div class="brick" id="gallery">
                    <input type="hidden" name="idpic" value="' . $row['pid'] . '">
                                    <div class="image-head">
                                        <div class="score-image1">
                                            <img src="' . URL . 'images/icons/score-icon.png" />
                                            <span>' . $row['imglike'] . '</span>
                                        </div>
                                        <a href="' . URL . 'blog/id/' . htmlspecialchars($row['userid']) . '">
                                            <div class="details-image1">
                                      <img  class="av" src="' . $vatar . '" />';
                                $len = mb_strlen($row['pn']);
                                if ($len != 0) {
                                    $reall.=' <span class="pn">' . htmlspecialchars($row['pn']) . ' </span>';
                                } else {
                                    $reall.=' <span class="pn"></span>';
                                }
                                $reall.=' </div>
                                </a>
                             </div>
                             <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">
                             </a>
                             <div class="id none">' . $row['pid'] . '</div>
                                 <div class="us none"><a class="userlink" >' . $username . '</a></div>
                                <div class="dt none">' . Shamsidate::jdate('j F Y', $row['pdate']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['pcmt'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['compid'] . '" id="cmp">' . htmlspecialchars($row['cname']) . '</a></div>
                                <div class="rt none">' . $row['imglike'] . '</div>
                       </div>
                  ';
                                $i++;
                            }
                            $this->view->render('index/index', $reall, FALSE, 0);
//            $this->data['[VARWINPIC]'] = $reall;
                        }
                        break;
                    }
                case 3: {
                        $cond = Session::get('cond2') . ':lmt , :top';
                        $condata = array('lmt' => $lmt, 'top' => self::TOP);
                        $res = $this->model->forselectedpic($cond, $condata);
                        if ($res) {
                            $reall = '';
                            $i = 0;
                            while ($row = $res->fetch()) {
                                if ($row['peopelwinno'] != 0) {
                                    $ispeople = 1;
                                } else {
                                    $ispeople = 0;
                                }

                                if ($row['isavatar'] == 1) {
                                    $imgname = Utilities::imgname('avatar', $row['userid']) . '.jpg';
                                    $vatar = URL . 'images/avatar/' . $imgname;
                                } else {
                                    $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                                    $vatar = URL . 'images/avatar/' . $imgname;
                                }
                                $imgname = Utilities::imgname('thumb', $row['pid']) . '.jpg';

                                if ($row['uname'] != '' && $row['uf'] != '') {
                                    $username = htmlspecialchars($row['uname'] . ' ' . $row['uf']);
                                } else {
                                    $username = htmlspecialchars($row['username']);
                                }
                                if ($ispeople == 1) {
                                    $reall.=' <div class="brick" id="gallery">
                    <input type="hidden" name="idpic" value="' . $row['pid'] . '">
                                    <div class="image-head">
                                        <div class="score-image1">
                                            <img src="' . URL . 'images/icons/score-icon.png" />
                                            <span>' . $row['imglike'] . '</span>
                                        </div>
                                        <a href="' . URL . 'blog/id/' . htmlspecialchars($row['userid']) . '">
                                            <div class="details-image1">
                                      <img  class="av" src="' . $vatar . '" />';
                                    $len = mb_strlen($row['pn']);
                                    if ($len != 0) {
                                        $reall.=' <span class="pn">' . htmlspecialchars($row['pn']) . ' </span>';
                                    } else {
                                        $reall.=' <span class="pn"></span>';
                                    }
                                    $reall.=' </div>
                                </a>
                             </div>
                             <a href="#" data-toggle="modal" data-target="#imgModal">
                                <img class="bgimg" src="' . URL . 'images/gallery/thumb/' . $imgname . '?' . $i . '" width="100%">
                             </a>
                             <div class="id none">' . $row['pid'] . '</div>
                                 <div class="us none"><a class="userlink" >' . $username . '</a></div>
                                <div class="dt none">' . Shamsidate::jdate('j F Y', $row['pdate']) . '</div>
                                <div class="cmt none">' . htmlspecialchars(str_replace(PHP_EOL, '<br>', $row['pcmt'])) . '</div>
                                <div class="cmp none">
                                <a href="' . URL . 'comp/id/' . $row['compid'] . '" id="cmp">' . htmlspecialchars($row['cname']) . '</a></div>
                                <div class="rt none">' . $row['imglike'] . '</div>
                       </div>
                  ';
                                    $i++;
                                }
                            }
//            $this->data['[VARMARDOMIPIC]'] = $reall;
                            $this->view->render('index/index', $reall, FALSE, 0);
                        }
                        break;
                    }
            }
        }
    }

}
