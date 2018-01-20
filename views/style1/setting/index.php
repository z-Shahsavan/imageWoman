<div class="container-fluid">
    <div class="row setting">
        <div id="modaltaeedchnagemobile" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <!--                    <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title"></h4>
                                        </div>-->
                    <div class="modal-body">
                        <p>
                            کد تغییر شماره موبایل به شماره جدید ارسال شد<br> لطفا کد را در کادر زیر وارد نمایید
                        </p>
                        <form>
                            <div class="container">
                                <div class="row">
                                    <div class="input-field col-xs-12 right">
                                        <i class="mdi-action-toc prefix"></i>
                                        <input id="taeedtaghirmob" name="name" type="text" class="validate form-control input-deactive" length="6" placeholder="کد تغییر شماره موبایل">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer deactive-modal-footer">
                        <button class="btn waves-effect purple darken-2  pdbtn" type="button" id="btntaeedchangemob" name="action">
                            ذخیره تغییرات
                            <i class="mdi-content-send right"></i>
                        </button>
                        <button class="btn waves-effect purple darken-2  pdbtn" data-dismiss="modal" type="button" id="btncancelchangemob" name="action">
                            انصراف
                            <i class="mdi-content-send right"></i>
                        </button>
                        <div class="row">
                            <div id="msgerrchangemob" class="col-xs-12 pink-text text-darken-3 right-align none">این یک پیام است</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modalmsg" class="modal">
            <div class="modal-content">
                <h4 class="flow-text card-panel pink darken-3 white-text center-align">پر کردن فیلد های زیر اجباری می باشد.</h4>
                <ul class=""></ul>
            </div>
            <div class="modal-footer">
                <a class="modal-action modal-close waves-effect waves-green btn-flat ">قبول</a>
            </div>
        </div>

        <div id="modaltaeed" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <!--                    <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title"></h4>
                                        </div>-->
                    <div class="modal-body">
                        <p>
                            کد غیرفعال سازی اکانت به شماره موبایل شما ارسال شد<br> کد را در کادر زیر وارد نمایید
                        </p>
                        <form>
                            <div class="container">
                                <div class="row">
                                    <div class="input-field col-xs-12 right">
                                        <i class="mdi-action-toc prefix"></i>
                                        <input id="deactivecode" name="name" type="text" class="form-control validate input-deactive" length="50" placeholder="کد غیرفعال سازی">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer deactive-modal-footer">
                        <button class="btn waves-effect purple darken-2  pdbtn" type="button" id="btntaeeddsblacc" name="action">
                            <i class="glyphicon glyphicon-send"></i>
                            غیرفعال کردن اکانت
                        </button>
                        <button class="btn waves-effect purple darken-2  pdbtn" data-dismiss="modal" type="button" id="btncanceldsblacc" name="action">
                            <i class="glyphicon glyphicon-remove"></i>
                            انصراف
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="modaleditgallery" class="modal fade modaleditgallery-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-body">
                    <div class="modal-content">
                        <div class="row">
                            <form action="" enctype="multipart/form-data" id="formeditgal" method="post" autocomplete="off" class="col-xs-12 col-md-5 col-md-offset-1 container" >
                            <input type="hidden" id="idformeditgal" name="id" />
                            <div class="row">
                                <div class="input-field col-xs-12 margintop10">
                                    <label for="name">عنوان تصویر</label>
                                    <input id="name" name="name" type="text" class="validate form-control" length="50">
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-xs-12 margintop10">
                                    <label> نام مسابقه</label>
                                    <select id="competition" name="competition" class="col s11 form-control">
                                        <option value="" disabled selected>انتخاب مسابقه</option>
                                        [VARSUBJECTS]
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-xs-12 margintop10">
                                    <label> مکان</label>
                                    <select id="mozu" name="mozu" class="col s11 form-control">
                                        <option value="" disabled selected>مکان</option>
                                        [VARSTATES]
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-xs-12 margintop10">
                                    <label for="comment">توضیحات</label>
                                    <textarea id="comment" name="comment" class="materialize-textarea validate form-control" length="120"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-xs-12 col-md-12 margintop10">
                                    <label for="date">تاریخ</label>
                                    <input id="date" name="date" type="text" class="validate ltr form-control" length="10">
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-xs-12 margintop10">
                                    <label for="subject">تگ</label>
                                    <input id="subject" name="subject" type="text" class="validate form-control" length="75">
                                </div>
                            </div>
                            <div class="row mgbtm">
                                <div class="col-xs-12 margintopbottom10">
                                    <button class="btn waves-effect waves-light right" id="editimginfo" type="button" name="action">
                                        <i class="glyphicon glyphicon-ok"></i>
                                        ویرایش
                                    </button>
                                    <button id="btncloseedtgal" class="btn waves-effect waves-light pink darken-4 right mgright" data-dismiss="modal" type="reset" name="reset" style="margin-right: 20px;">
                                        <i class="glyphicon glyphicon-remove"></i>
                                        انصراف
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div id="msgerr" class="col-xs-12 pink-text text-darken-3 right-align none">این یک پیام است</div>
                                <div id="msgsuc" class="col-xs-12 teal-text text-darken-1 right-align none">این یک پیام است</div>
                            </div>
                        </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="grey lighten-3 mgbtmz">
            <!--    <div class="col s12 arrow_box"></div>-->
            <!--    <div class="col s12 reltive center-align">
                    <i class="mdi-action-settings purple-text icosec lgico"></i>
                </div>-->
            <div class="clearfix" style="background-color:#ECECEC;">
                <ul id="sidemenu" class="sidemenu" style="margin-top: 30px;">
                    <li id="okpic"><a href="#gallery-content" class="tooltipped open" data-position="bottom" data-delay="50" data-tooltip="تصاویر تایید شده"><i class="glyphicon glyphicon-camera iconvertical"></i></a></li>
                    <li id="notokpic"><a href="#taeednashode-content" class="tooltipped waiting" data-position="bottom" data-delay="50" data-tooltip="تصاویر در انتظار تایید"><i class="glyphicon glyphicon-picture iconvertical"></i></a></li>
                    <li><a href="#header-content" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="تغییر آواتار"><i class="glyphicon glyphicon-info-sign iconvertical"></i></a></li>
                    <li><a href="#home-content" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="تغییر مشخصات کاربری"><i class="glyphicon glyphicon-user iconvertical"></i></a></li>
                    <li><a href="#password-content" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="تغییر رمز عبور"><i class="glyphicon glyphicon-lock iconvertical"></i></a></li>
                    <li><a href="#disableacc" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="غیرفعال کردن اکانت"><i class="glyphicon glyphicon-minus-sign iconvertical"></i></a></li>
                </ul>
                <div id="content">
                    <div id="gallery-content" class="contentblock">
                        <!--                <div id="okimages" class="row center-align gallery">
                                            
                                        </div>-->
                        <div id="freewall" class="free-wall row center-align gallery">
                            [VARGALIMAGES]
                        </div>
                        <div id="pagingtaeedshode" class="row center-align mgtop">

                        </div>
                    </div>
                    <div id="taeednashode-content" class="contentblock hidden">
                        <div id="pendimages" class="row center-align gallery free-wall">

                        </div>
                        <div id="pagingtaeednashode" class="row center-align mgtop">

                        </div>
                    </div>
                    <div id="paging1" class="center-align mgtops load-more-image">
                        <input type="hidden" name="whichpg" id="whichpg" value="1">
                        <a id="btnmore" class="bwaves-effect waves-white  btn purple darken-3 more-img">
                            <img src="[VARURL]images/icons/refresh.png" />
                        </a>
                    </div>
                    <div id="waiting" class="center-align mgtops load-more-image" style="display: none">
                        <a id="wait" class="bwaves-effect waves-white  btn purple darken-3 load-img">
                            <img src="[VARURL]images/icons/refresh-wait.png" />
                        </a>
                    </div>
                    <div id="header-content" class="contentblock hidden regdiv avatar-setting">
                        <div class="container">
                            <div class="avatar">
                                <form action="upload.php" enctype="multipart/form-data" id="formheader" method="post" autocomplete="off" class="col-xs-12 mgtop z-depth-1 reltive minsh mgbtm bgblur bdr">
                                    <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="300000" />
                                    <h4 class="flow-text blue-grey darken-3 hdreg white-text">تغییر آواتار</h4>
                                    <div class="row reltive mgtop paddingtop40">
                                        <div class="input-field col-xs-12 center-align">
                                            <div id="imagePreview" style="background-image:url(../../../../images/header/e463db63812ae7229c6c3c1e5d17bec4.jpg)"></div>
                                        </div>
                                        <div class="dropdiv" id="filedrag" name="fileselect"></div>
                                        <div class="file-field input-field col-xs-12 center-align hdbtn" style="display: none;" >
                                            <input class="file-path validate none" type="text" />
                                            <input class="none select-cover-opacirt0" type="file" id="fileselect" name="fileselect" />
                                            <div class="cover-btn">انتخاب کاور</div>
                                        </div>
                                    </div>
                                    <div class="avatardiv">
                                        <img id="imgavatar" src="thumbnails/avatar/2.jpg" />
                                        <div class="file-field input-field selfl">
                                            <input class="file-path validate none" type="text" />
                                            <!--style="display:none"-->
                                            <a class="glyphicon glyphicon-plus-sign icon-add-image">
                                                <input type="file" id="fileavatar" class="fileavatar2" name="fileavatar" />
                                            </a>
                                            <a id="delav" class="glyphicon glyphicon-remove delete-avatar icon-del-image"></a>
                                            <!--                                <div class="btn purple darken-3 mdi-image-control-point">
                                                                                <span>انتخاب آواتار</span>
                                                                                <input type="file" id="fileavatar" class="mdi-image-control-point" name="fileavatar" />
                                                                            </div>-->
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col-xs-12 right mgtop">
                                            <!-- <i class="mdi-editor-format-list-bulleted prefix"></i> -->
                                            <label id="descriptionuserbody" for="descriptionuser" class="margintop30">توضیحاتی در مورد شما</label>
                                            <textarea id="descriptionuser" name="descriptionuser" class="form-control validate" length="150"></textarea>
                                        </div>
                                    </div>
                                    <div id="submitbutton" class="col-xs-12" style="display: none;">
                                        <button class="btn waves-effect waves-light pdbtn btn-large" type="button"><i class="glyphicon glyphicon-upload icon-btn"></i>ثبت تغییرات</button>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 loadingdiv">
                                            <button id="sendavt" class="btn waves-effect waves-light pdbtn btn-large margintop30" type="button"><i class="glyphicon glyphicon-upload icon-btn"></i>ثبت تغییرات</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div id="erruseravt" class="col-xs-12 pink-text text-darken-3 none">این یک پیام است</div>
                                        <div id="msguseravt" class="col-xs-12 teal-text text-darken-1 none">این یک پیام است</div>
                                    </div>
                                    <div class="row reltive mgbtmz">
                                        <div class="col-xs-12 m10 offset-m1">
                                            <div id="prgs"></div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="home-content" class="contentblock hidden regdiv">
                        <div class="container">
                            <div class="user-editing">
                                <form action="#" id="formuserinfo" method="post" autocomplete="off" class="col-xs-12 col-md-5 col-md-offset-3 mgtop z-depth-1 reltive minsh mgbtm bgblur bdr">
                                    <h4 class="flow-text blue-grey darken-3 hdreg white-text">ویرایش اطلاعات کاربری</h4>
                                    <div class="margon1030 margintop30">
                                        <div class="input-field col-xs-12 right">
                                            <i class="mdi-social-person prefix"></i>
                                            <label id="lbluname" for="name" class="margintop15">نام</label>
                                            <input id="uname" name="name" type="text" class="validate form-control" length="25">
                                            <!--<div class="req">*</div>-->
                                        </div>
                                    </div>
                                    <div class="margon1030">
                                        <div class="input-field col-xs-12 right">
                                            <i class="mdi-social-person prefix"></i>
                                            <label id="lblastname" for="lastname" class="margintop15">نام خانوادگی</label>
                                            <input id="lastname" name="lastname" type="text" class="validate form-control" length="25">
                                            <!--<div class="req">*</div>-->
                                        </div>
                                    </div>
                                    <!--                            <div class="row">
                                                                    <div class="input-field col s12 right">
                                                                        <i class="mdi-social-person prefix"></i>
                                                                        <input id="username" name="username" type="text" class="validate" length="25">
                                                                        <label id="lblusername" for="username">نام کاربری</label>
                                                                        <div class="req">*</div>
                                                                    </div>
                                                                </div>-->
                                    <div class="margon1030">
                                        <div class="input-field col-xs-12">
                                            <i class="mdi-maps-local-phone prefix"></i>
                                            <label id="lbltel" for="tel" class="margintop15">تلفن</label>
                                            <input id="tel" name="tel" type="tel" class="validate ltr form-control" length="12">
                                            <!--<div class="req">*</div>-->
                                        </div>
                                    </div>
                                    <div id="mobilerow" class="margon1030">
                                        <div class="input-field col-xs-12">
                                            <i class="mdi-hardware-phone-iphone prefix"></i>
                                            <label id="lblmobile" for="mobile" class="margintop15">موبایل</label>
                                            <input id="mobile" name="mobile" type="tel" class="validate ltr form-control" length="12">
                                            <!--<div class="req">*</div>-->
                                        </div>
                                    </div>
                                    <div class="margon1030">
                                        <div class="input-field col-xs-12">
                                            <i class="mdi-maps-beenhere prefix"></i>
                                            <label id="lblmelicode" for="melicode" class="margintop15">کد ملی</label>
                                            <input id="melicode" name="melicode" type="tel" class="validate ltr form-control" length="10">
                                            <!--<div class="req">*</div>-->
                                        </div>
                                    </div>
                                    <div class="margon1030">
                                        <div class="input-field col-xs-12">
                                            <i class="mdi-maps-pin-drop prefix"></i>
                                            <label id="lblpostcode" for="postcode" class="margintop15">کد پستی</label>
                                            <input id="postcode" name="postcode" type="tel" class="validate ltr form-control" length="10">
                                        </div>
                                    </div>
                                    <div class="margon1030">
                                        <div class="input-field col-xs-12 right">
                                            <i class="mdi-maps-place prefix"></i>
                                            <label id="lbladdress" for="address" class="margintop15">آدرس</label>
                                            <textarea id="address" name="address" class="materialize-textarea validate form-control" length="120"></textarea>
                                        </div>
                                    </div>
                                    <div class="margon1030">
                                        <div class="input-field col-xs-12">
                                            <i class="mdi-communication-email prefix"></i>
                                            <label id="lblmail" for="email" class="margintop15">ایمیل</label>
                                            <input id="email" name="email" type="email" class="validate ltr form-control">
                                        </div>
                                    </div>
                                    <div id="btnchinforow" class="margon1030">
                                        <div class="col-xs-12 col-md-6 right loadingdivedituser" >
                                            <button class="btn waves-effect purple darken-2 btn-large pdbtn margintop15 marginbottom15" type="button" id="edituserinfo" name="action">
                                                <i class="mdi-content-send right"></i>
                                                ثبت تغییرات
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row marginbottom15">
                                        <div id="erruser" class="col-xs-12 pink-text text-darken-3 none">این یک پیام است</div>
                                        <div id="msguser" class="col-xs-12 teal-text text-darken-1 none">این یک پیام است</div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="password-content" class="contentblock hidden regdiv">
                        <div class="container">
                            <div class="change-password">
                                <form action="#" id="formpassword" method="post" autocomplete="off" class="col-xs-12 col-md-5 col-md-offset-3 mgtop z-depth-1 reltive minsh mgbtm bgblur bdr">
                                    <h4 class="flow-text blue-grey darken-3 hdreg white-text">تغییر پسورد</h4>
                                    <div class="margon1030 margintop30">
                                        <div class="input-field col-xs-12">
                                            <i class="mdi-action-lock prefix"></i>
                                            <label for="password" class="margintop15">رمز عبور قبلی</label>
                                            <input id="oldpassword" name="oldpass" type="password" class="validate ltr form-control">
                                            <div class="req">*</div>
                                        </div>
                                    </div>
                                    <div class="margon1030">
                                        <div class="input-field col-xs-12">
                                            <i class="mdi-action-lock prefix"></i>
                                            <label for="password">رمز عبور جدید</label>
                                            <input id="password" name="password" type="password" class="validate ltr form-control">
                                            <div class="req">*</div>
                                        </div>
                                    </div>
                                    <div class="margon1030">
                                        <div class="input-field col-xs-12">
                                            <i class="mdi-action-lock prefix"></i>
                                            <label for="confrim" class="margintop15">تکرار رمز عبور</label>
                                            <input id="confrim" name="confrim" type="password" class="validate ltr form-control">
                                            <div class="req">*</div>
                                        </div>
                                    </div>
                                    <div class="margon1030">
                                        <div class="col-xs-12 col-md-6 right loadingdivchangepass">
                                            <button class="btn waves-effect purple darken-2 btn-large pdbtn margintop15 marginbottom15" type="button" id="changepasssend" name="action">
                                                ثبت تغییرات
                                                <i class="mdi-content-send right"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row marginbottom15">
                                        <div id="errpass" class="col-xs-12 pink-text text-darken-3 none">این یک پیام است</div>
                                        <div id="msgpass" class="col-xs-12 teal-text text-darken-1 none">این یک پیام است</div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="disableacc" class="contentblock hidden">
                        <div class="container">
                            <div class="deactive-account">
                                <form action="#" id="formpassword" method="post" autocomplete="off" class="col-xs-12 col-md-5 col-md-offset-3 mgtop z-depth-1 reltive minsh mgbtm bgblur bdr">
                                    <h4 class="flow-text blue-grey darken-3 hdreg white-text">غیر فعال کردن اکانت</h4>
                                    <div class="mgtop dsblacc">
                                        <p class="parag margintop30">در صورتی که میخواهید حساب خود را غیر فعال کنید بر روی کلید زیر کلیک نمایید</p>
                                    </div>
                                    <div class="col-xs-12 col-md-6 right margon1030">
                                        <button class="btn waves-effect purple darken-2 btn-large pdbtn" type="button" id="btndsblacc" name="action">
                                            غیرفعال کردن اکانت
                                            <i class="mdi-content-send right"></i>
                                        </button>
                                    </div>
                                    <div class="row marginbottom15">
                                        <div id="errpassdc" class="col-xs-12 pink-text text-darken-3 none">این یک پیام است</div>
                                        <div id="msgpassdc" class="col-xs-12 teal-text text-darken-1 none">این یک پیام است</div>
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