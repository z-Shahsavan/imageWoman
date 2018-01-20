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
        <li><a href="[VARURL]adminquestion" class="active">سوالات رایج </a></li>
        <li><a href="[VARURL]adminblog">اعلانات </a></li>
        <li><a href="[VARURL]adminprize">اهدای جوایز </a></li>
         <li><a href="[VARURL]adminviolation">گزارش تخلفات </a></li>
    </ul>
</div>
<div id="modaledit" class="modal">
    <div class="modal-content">
        <form action="upload.php" enctype="multipart/form-data" id="formedit" method="post" autocomplete="off" class="col s12 m5 offset-m3 container">
            <input type="hidden" id="idformedit" name="idmod" />
            <div class="row mgbtmz">
                <div class="input-field col s12 right">
                    <i class="mdi-action-subject prefix"></i>
                    <textarea id="questionedit" name="modquestion" class="materialize-textarea validate" length="250"></textarea>
                    <label for="questionedit">سوال</label>
                </div>
            </div>
            <div class="row mgbtmz">
                <div class="input-field col s12 right">
                    <i class="mdi-action-subject prefix"></i>
                    <textarea id="commentedit" name="modcomment" class="materialize-textarea validate" length="250"></textarea>
                    <label for="commentedit">توضیحات</label>
                </div>
            </div>
            <div class="row mgbtm">
                <div class="col s12">
                    <button id="edit" class="btn waves-effect waves-light right" type="button" name="action">
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
                <div id="msgerrmod" class="col s12 pink-text text-darken-3 right-align" style="display: none">این یک پیام است</div>
                <div id="msgsucmod" class="col s12 teal-text text-darken-1 right-align" style="display: none">این یک پیام است</div>
            </div>
        </form>
    </div>
</div>
<div id="cntmndiv" class="row grey lighten-3 mgbtmz">
    <div class="clearfix">
        <ul id="sidemenu" class="rtl">
            <li><a href="#reg-content" class="tooltipped open" data-position="bottom" data-delay="50" data-tooltip="ثبت موضوع جدید"><i class="mdi-action-done-all Medium"></i></a></li>
            <li><a id="editfaqhead" href="#edit-content" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="ویرایش موضوعات"><i class="mdi-editor-mode-edit Medium"></i></a></li>
        </ul>
        <div id="content">
            <div id="reg-content" class="contentblock regdiv">
                <div class="row mgbtmz container">
                    <form action="#"  id="formreg" method="post" autocomplete="off" class="col s12 m5 offset-m3 mgtop z-depth-1 reltive minsh mgbtm bgblur bdr">
                        <div class="col s12 rtl">
                            <h4 class="flow-text blue-grey darken-3 hdreg white-text">سوال جدید</h4>
                        </div>
                        <div class="row mgbtmz">
                            <div class="input-field col s12 right mgtop">
                                <i class="mdi-action-subject prefix"></i>
                                <textarea id="question" name="question" class="materialize-textarea validate" length="250"></textarea>
                                <label for="question">سوال</label>
                            </div>
                        </div>
                        <div class="row mgbtmz">
                            <div class="input-field col s12 right">
                                <i class="mdi-action-subject prefix"></i>
                                <textarea id="comment" name="comment" class="materialize-textarea validate" length="250"></textarea>
                                <label for="comment">توضیحات</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <button id="send" class="btn waves-effect waves-light pdbtn" type="button" name="action">
                                    ثبت اطلاعات
                                    <i class="mdi-maps-beenhere right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div id="msgerr" class="col s12 pink-text text-darken-3" style="display: none">این یک پیام است</div>
                            <div id="msgsuc" class="col s12 teal-text text-darken-1" style="display: none">این یک پیام است</div>
                        </div>
                    </form>
                </div>
                <div class="divider clear"></div>
            </div>
            <div id="edit-content" class="contentblock hidden rtl">
                <div id="itemsdiv" class="row container">
                </div>
                <div class="divider clear"></div>
                <div id="pagingcompetition" class="row center-align mgtop clear">

                </div>
            </div>
        </div>
    </div>
</div>
