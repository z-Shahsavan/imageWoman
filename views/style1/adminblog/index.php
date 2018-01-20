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
        <li><a href="[VARURL]admincontact">تماس با ما</a></li>
        <li><a href="[VARURL]adminquestion">سوالات رایج </a></li>
        <li><a href="[VARURL]adminblog" class="active">اعلانات </a></li>
        <li><a href="[VARURL]adminprize">اهدای جوایز </a></li>
         <li><a href="[VARURL]adminviolation">گزارش تخلفات </a></li>
        </ul>
    </div>
<div id="modaledit" class="modal">
        <div class="modal-content">
            <form action="[VARURL]adminblog/editit" onSubmit="return false" enctype="multipart/form-data" id="formedit" method="post" autocomplete="off" class="col s12 m5 offset-m3 container">
                <input type="hidden" id="idformedit" name="id" />
                <div class="row mgtop">
                    <div class="input-field col s12 right">
                        <i class="mdi-action-toc prefix"></i>
                        <input id="subjectedit" name="subject" type="text" class="validate" length="50">
                        <label for="subjectedit">عنوان</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12 right">
                        <i class="mdi-action-subject prefix"></i>
                        <textarea id="commentedit" name="comment" class="materialize-textarea validate" length="250"></textarea>
                        <label for="commentedit">توضیحات</label>
                    </div>
                </div>
                <div class="row mgbtm">
                    <div class="col s12">
                        <button id="editup"  class="btn waves-effect waves-light right" type="submit" name="action">
                            ویرایش
                            <i class="mdi-navigation-check right"></i>
                        </button>
                        <button id="btncloseedit" class="btn waves-effect waves-light pink darken-4 right mgright" type="reset" name="reset">
                            انصراف
                            <i class="mdi-navigation-check right"></i>
                        </button>
                    </div>
                </div>
                <div class="row" id="editmsg">
                    <div class="col s12 pink-text text-darken-3 right-align" id="erredit"></div>
                    <div class="col s12 teal-text text-darken-1 right-align" id="okedit"></div>
                </div>
            </form>
        </div>
    </div>
    <div id="cntmndiv" class="row grey lighten-3 mgbtmz">
        <div class="clearfix">
            <ul id="sidemenu" class="rtl">
                <li><a id="rgcont" href="#reg-content" class="tooltipped open" data-position="bottom" data-delay="50" data-tooltip="ثبت موضوع جدید"><i class="mdi-action-done-all Medium"></i></a></li>
                <li><a id="edcont" href="#edit-content" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="ویرایش موضوعات"><i class="mdi-editor-mode-edit Medium"></i></a></li>
            </ul>
            <div id="content">
                <div id="reg-content" class="contentblock regdiv">
                    <div class="row mgbtmz container">
                        <form action="[VARURL]adminblog/upload" onSubmit="return false;" enctype="multipart/form-data" id="formreg" method="post" autocomplete="off" class="col s12 m5 offset-m3 mgtop z-depth-1 reltive minsh mgbtm bgblur bdr">
                            <div class="col s12 rtl borderh4">
                                <h4 class="flow-text blue-grey darken-3 hdreg white-text">مدیریت بلاگ</h4>
                            </div>
                            <div class="row mgtop">
                                <div class="input-field col s12 right">
                                    <i class="mdi-action-toc prefix"></i>
                                    <input id="subject" name="subject" type="text" class="validate" length="50">
                                    <label for="subject">عنوان</label>
                                </div>
                            </div>
                            <div class="row right-align">
                                <div class="input-field col s12 right">
                                    <i class="mdi-action-subject prefix"></i>
                                    <textarea id="comment" name="comment" class="materialize-textarea validate" length="250"></textarea>
                                    <label for="comment">توضیحات</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="file-field input-field">
                                    <input class="file-path validate" type="text">
                                    <div class="btn teal darken-3">
                                        <span>انتخاب فایل</span>
                                        <input id="infile" type="file" name="file">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12">
                                    <button id="sendup" class="btn waves-effect waves-light pdbtn" type="submit" name="action">
                                        ثبت اطلاعات
                                        <i class="mdi-maps-beenhere right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 pink-text text-darken-3" id="errmsg"></div>
                                <div class="col s12 teal-text text-darken-1" id="okmsg"></div>
                            </div>
                        </form>
                    </div>
                    <div class="divider clear"></div>
                </div>
                <div id="edit-content" class="contentblock hidden rtl">
                    <div id="itemsdiv" class="row container">
                        <!-- Item -->
                        [VARITEMS]
                    </div>
                    <div class="divider clear"></div>
                    <div id="pagingcompetition" class="row center-align mgtop clear">

                    </div>
                </div>
            </div>
        </div>
    </div>
    