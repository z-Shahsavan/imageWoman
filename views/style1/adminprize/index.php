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
        <li><a href="[VARURL]adminblog" >اعلانات </a></li>
         <li><a href="[VARURL]adminprize" class="active">اهدای جوایز </a></li>
        <li><a href="[VARURL]adminviolation">گزارش تخلفات </a></li>
    </ul>
</div>
<div id="cntmndiv" class="row grey lighten-3 mgbtmz">
<!--    <div class="col s12 arrow_box"></div>
    <div class="col s12 reltive center-align">
        <i class="mdi-action-settings purple-text icosec lgico"></i>
    </div>-->
    <div class="clearfix">

        <div id="content">
            <div id="reg-content" class="contentblock regdiv">
                <div class="row mgbtmz container">
                    <form action="[VARURL]adminblog/upload" onSubmit="return false;" enctype="multipart/form-data" id="formuppr" method="post" autocomplete="off" class="col s12 m5 offset-m3 mgtop z-depth-1 reltive minsh mgbtm bgblur bdr">
                        <div class="col s12 rtl borderh4">
                            <h4 class="flow-text blue-grey darken-3 hdreg white-text">اهدای جوایز</h4>
                        </div>
                        <div class="row mgtop">
                            <div class="input-field col s12">
                                <i class="mdi-image-blur-on prefix"></i>
                                <select id="competition" name="competition" class="col s11">
                                    <option value="" disabled selected>انتخاب مسابقه</option>
                                    [VARCOMPS]
<!--                                    <option value="1">مسابقه 1</option>
                                    <option value="2">مسابقه 2</option>
                                    <option value="3">مسابقه 3</option>-->
                                </select>
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
                                    <span>انتخاب ویدئو</span>
                                    <input id="infile_vid" type="file" name="file_vid">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="file-field input-field">
                                <input class="file-path validate" type="text">
                                <div class="btn teal darken-3">
                                    <span>انتخاب تصاویر</span>
                                    <input id="infile_pics" type="file" name="file_pics">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12">
                                <button id="sendup" class="btn waves-effect waves-light pdbtn" type="button" name="action">
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
