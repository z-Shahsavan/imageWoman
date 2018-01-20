<?php

class Link {

    public static function menulink($sesskey, $page = '') {
        $menu = '';
        $login = Session::get($sesskey);

        $numofnotify = '[VARNUMOFNOTIFY]';
        $notifytext = '';

        if ($login == FALSE) {
            $rol = 0;
        } else {
            if (Session::get('isavatar') == 1) {
                $imgname = Utilities::imgname('avatar', Session::get('userid')) . '.jpg';
                $vatar = URL . 'images/avatar/' . $imgname;
            } else {
                $imgname = Utilities::imgname('avatar', 'default') . '.jpg';
                $vatar = URL . 'images/avatar/' . $imgname;
            }

            $rol = $login;
            $usertime = Shamsidate::jdate('l d F oساعت h:i دقیقه A', Session::get('lastlogin'));
            $nameandfam = Session::get('nameandfam');
            $numpic = Session::get('numberpic');
            $score = Session::get('score');
        }
        $timenow = Shamsidate::jdate('o/m/d');
        switch ($rol) {
            case 0:
                //guest
                $menu = ' <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 paddingrightleft0">
                    <header>
                        <div class="top-menu col-md-9 col-sm-12 col-xs-12">
                            <ul class="col-md-4 col-xs-12 hide-index" style="z-index: 5;">
                                <li id="listlog" class="" style="background-color: transparent;padding-top: 10px;text-align: center;">
                                    <a href="#" data-toggle="modal" data-target="#accountModal1" style="background-color: #98B1FF;box-shadow: 0px 0px 2px #777777;border-radius: 25px;">
                                        <img style="width: 14px;" src="[VARURL]images/icons/login-icon.png">
                                        <span style="color: #ffffff;font-size: 12px">ورود کاربران</span>
                                    </a>
                                </li>
                                <li id="listreg" class="" style="padding-top: 9px;text-align: center;">
                                    <a href="#" data-toggle="modal" data-target="#accountModal2" style="background-color: #BFBFBF;box-shadow: 0px 0px 2px #777777;border-radius: 25px;">
                                        <img style="width: 20px;" src="[VARURL]images/icons/register-icon.png">
                                        <span style="color: #ffffff;font-size: 12px">ثبت نام</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- accountModal1 -->
                        <div class="modal fade hide-index" id="accountModal1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content accountModalcontent">
                                    <div class="modal-header">
                                        <div class="titel-mi-mod"><span style="color:#ffffff;font-size:32px;">ورود کاربران</span></div>
                                        <div class="shape-1"></div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="tab-content">
                                            <div id="logdiv" class="tab-pane fade in active" >
                                                 <form action="" enctype="multipart/form-data" id="formlogin" method="post" autocomplete="off">
                                                    <label for="username">نام کاربری:</label>
                                                    <input type="text" id="username" name="username" class="form-control"/>
                                                    <label for="password">پسورد:</label>
                                                    <input type="password" id="password" name="password" class="form-control"/>
                                                    <div class="btn-group btn-group-justified">
                                                        <div class="btn-group">
                                                            <button id="btnlogin" type="button" class="btn btn-primary">ورود</button>
                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">بستن</button>
                                                        </div>
                                                    </div>
                                                    <a href="' . URL . '/forgot" class="forgot-text"> رمز عبور خود را فراموش کرده ای؟</a>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div id="msgloginerr" class="text-right paddingtopbottom5 alert-error" style="display: none;">لطفا اطلاعات را وارد کنید.</div>
                                                            <!--<div id="msgsucmod" class="text-right paddingtopbottom5 alert-ok">اطلاعات با موفقیت ثبت شد.</div>-->
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- accountModa2 -->
                        <div class="modal fade hide-index" id="accountModal2" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content accountModalcontent">
                                    <div class="modal-header">
                                        <div class="titel-mi-mod"><span style="color:#ffffff;font-size:32px;">ثبت نام</span></div>
                                        <div class="shape-1"></div>                                        
                                    </div>
                                    <div class="modal-body">
                                        <div class="tab-content">
                                            <div id="register" class="tab-pane fade in">
                                                <div class="tab-content">
                                                    <div id="regdiv" class="tab-pane show" >
                                                        <form id="formreguser" class="form-group" method="post" action="" name="register_form">
                                                            <label for="username">نام کاربری:</label>
                                                            <input type="text" id="regusername" name="regusername" class="form-control"/>
                                                            <label for="password">پسورد:</label>
                                                            <input type="password" id="regpassword" name="regpassword" class="form-control"/>
                                                            <label for="password">موبایل:</label>
                                                            <input type="tel" id="regmobuser" name="regmobuser" class="form-control"/>

                                                            <div class="btn-group btn-group-justified">
                                                                <div class="btn-group">                                           
                                                                    <button id="reguserbtn" type="button" class="btn btn-primary btn-register" data-toggle="tab">ثبت نام</button>                                                           
                                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">بستن</button>
                                                                </div>
                                                            </div>
                                                          <div class="row">
                                                                <div class="col-md-12">
                                                                    <div id="registererrdiv" class="text-right paddingtopbottom5 alert-error" style="display: none;">لطفا اطلاعات را وارد کنید.</div>
                                                                    <!--<div id="msgsuc" class="text-right paddingtopbottom5 alert-ok" style="display: none;">اطلاعات با موفقیت ثبت شد.</div>-->
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="tab-pane fade activeaccount"  id="regpg2">
                                                        <form  id="formreguserpg2" method="post" autocomplete="off">
                                                            <p>کد فعالسازی به تلفن همراه شما ارسال شد!</p>
                                                            <label for="password">کد فعالسازی:</label>
                                                            <input type="text" class="form-control" name="regactcode" placeholder="کد فعالسازی را وارد نمایید">
                                                            <div class="btn-section">
                                                                <button id="reguserbtnpg2" type="button" class="btn btn-primary" style="float:initial !important;">
                                                                    <span class="glyphicon glyphicon-ok"></span>
                                                                    تایید
                                                                </button>
                                                                <button id="activecode" onclick="sendcode()" type="button" class="btn btn-primary left-section" style="float: left !important;width: 170px !important;display:none;">
                                                                    <span>کد فعالسازی دریافت نکرده اید؟</span>
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
                                                        </form>
                                                    </div>				                      
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </header>
                </div>
            </div>
        </div>
        ';
                break;
            case 1:
                $menu = '	<div class="container">
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
                $menu = '	<div class="container">
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
            case 4:
                $menu = '	<div class="container">
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
            case 3:
                $menu = '	<div class="container">
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
        }
        $data['[VARMENULINK]'] = $menu;
        return $data;
    }

}
