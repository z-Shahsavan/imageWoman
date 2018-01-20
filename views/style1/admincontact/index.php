<div class="row" >
    <ul class="adminmnu col-xs-12">
        <li><a href="[VARURL]adminuser">مدیریت کاربران</a></li>
        <li><a href="[VARURL]adminphoto">تصاویر</a></li>
        <li><a href="[VARURL]admincomp">مسابقات</a></li>
        <li><a href="[VARURL]adminupload">تنظیمات آپلود</a></li>
        <li><a href="[VARURL]adminconfig">تنظیمات سایت</a></li>
        <li><a href="[VARURL]adminabout"> درباره ی ما</a></li>
        <li><a href="[VARURL]adminpolicy">قوانین سایت</a></li>
        <li><a href="[VARURL]admincopyright">حقوق استفاده کنندگان</a></li>
        <li><a href="[VARURL]adminmethod">شیوه ی فعالیت در سایت</a></li>
        <li><a href="[VARURL]admincontact" class="active">تماس با ما</a></li>
        <li><a href="[VARURL]adminquestion">سوالات رایج </a></li>
        <li><a href="[VARURL]adminblog">اعلانات </a></li>
        <li><a href="[VARURL]adminprize">اهدای جوایز </a></li>
         <li><a href="[VARURL]adminviolation">گزارش تخلفات </a></li>
        
    </ul>
</div>
<div id="modaledit" class="modal">
    <div class="modal-content">
        <form action="upload.php" enctype="multipart/form-data" id="formedit" method="post" autocomplete="off" class="col s12 m5 offset-m3 container">
            <input type="hidden" id="idformedit" name="id" />
            <div class="row mgtop">
                <div class="input-field col s12 right">
                    <i class="mdi-action-toc prefix"></i>
                    <input id="subjectedit" name="subject" type="text" class="validate" length="50">
                    <label for="subjectedit">عنوان</label>
                </div>
            </div>
            <div class="row mgbtmz">
                <div class="input-field col s12 right">
                    <i class="mdi-action-subject prefix"></i>
                    <textarea id="commentedit" name="comment" class="materialize-textarea validate" length="250"></textarea>
                    <label for="commentedit">توضیحات</label>
                </div>
            </div>
            <div class="row mgbtm">
                <div class="col s12">
                    <button class="btn waves-effect waves-light right" type="submit" name="action">
                        ویرایش
                        <i class="mdi-navigation-check right"></i>
                    </button>
                    <button id="btncloseedit" class="btn waves-effect waves-light pink darken-4 right mgright" type="reset" name="reset">
                        انصراف
                        <i class="mdi-navigation-check right"></i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div class="col s12 pink-text text-darken-3 right-align">این یک پیام است</div>
                <div class="col s12 teal-text text-darken-1 right-align">این یک پیام است</div>
            </div>
        </form>
    </div>
</div> 
<div id="cntmndiv" class="row grey lighten-3 mgbtmz">
    <div class="clearfix">
        <ul id="sidemenu" class="rtl">
            <li><a href="#reg-content" class="tooltipped open" data-position="bottom" data-delay="50" data-tooltip="ثبت تماس با ما"><i class="mdi-action-done-all Medium"></i></a></li>
            <li><a id="loadnewmsg" href="#new-content" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="پیام های جدید"><i class="mdi-image-style Medium"></i></a></li>
            <li><a id="readmsg" href="#viewed-content" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="پیام های دیده شده"><i class="mdi-notification-mms Medium"></i></a></li>
        </ul>
        <div id="content">
            <div id="reg-content" class="contentblock regdiv">
                <div class="row mgbtmz container">
                    <form action="#"  id="formreg" method="post" autocomplete="off" class="col s12 m5 offset-m3 mgtop z-depth-1 reltive minsh mgbtm bgblur bdr">
                        <div class="col s12 rtl">
                            <h4 class="flow-text blue-grey darken-3 hdreg white-text">تنظیمات تماس با ما</h4>
                        </div>
                        <div class="row mgtop">
                            <div class="input-field col s12">
                                <i class="mdi-maps-local-phone prefix"></i>
                                <input id="tel" name="tel" type="tel" class="validate ltr" length="12" value="[VARVALUETELL]">
                                <label for="tel">تلفن</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="mdi-hardware-phone-iphone prefix"></i>
                                <input id="fax" name="fax" type="tel" class="validate ltr" length="12" value="[VARVALUEFAX]">
                                <label for="fax">نمابر</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="mdi-communication-email prefix"></i>
                                <input id="email" name="email" type="email" class="validate ltr" value="[VARVALUEMAIL]">
                                <label for="email">ایمیل</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m6 right">
                                <button id="send" class="btn waves-effect purple darken-2  pdbtn" type="button" name="action">
                                    ثبت اطلاعات
                                    <i class="mdi-content-send right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div id="msgerr"  class="col s12 pink-text text-darken-3"  style="display: none">این یک پیام است</div>
                            <div id="msgsuc" class="col s12 teal-text text-darken-1"  style="display: none">این یک پیام است</div>
                        </div>
                    </form>
                </div>
                <div class="divider clear"></div>
            </div>
            <div id="new-content" class="contentblock hidden rtl">
                <div id="itemsdivnew" class="row container">

                </div>
                <div class="divider clear"></div>
                <div id="pagingcompetition" class="row center-align mgtop clear">

                </div>
            </div>
            <div id="viewed-content" class="contentblock hidden rtl">
                <div id="itemsdivviewed" class="row container">

                </div>
                <div class="divider clear"></div>
                <div id="pagingcompetition" class="row center-align mgtop clear">

                </div>
            </div>

        </div>
    </div>
</div>