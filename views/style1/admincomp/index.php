<div class="row" dir="rtl">
    <ul class="adminmnu col-xs-12">
         <li><a href="[VARURL]adminuser">مدیریت کاربران</a></li>
        <li><a href="[VARURL]adminphoto">تصاویر</a></li>
        <li><a href="[VARURL]admincomp" class="active">مسابقات</a></li>
        <li><a href="[VARURL]adminupload">تنظیمات آپلود</a></li>
        <li><a href="[VARURL]adminconfig">تنظیمات سایت</a></li>
        <li><a href="[VARURL]adminabout"> درباره ی ما</a></li>
        <li><a href="[VARURL]adminpolicy">قوانین سایت</a></li>
        <li><a href="[VARURL]admincopyright">حقوق استفاده کنندگان</a></li>
        <li><a href="[VARURL]adminmethod">شیوه ی فعالیت در سایت</a></li>
        <li><a href="[VARURL]admincontact">تماس با ما</a></li>
        <li><a href="[VARURL]adminquestion">سوالات رایج </a></li>
        <li><a href="[VARURL]adminblog">اعلانات </a></li>
        <li><a href="[VARURL]adminprize">اهدای جوایز </a></li>
         <li><a href="[VARURL]adminviolation">گزارش تخلفات </a></li>
    </ul>
</div>
<div id="modaleditcomp" class="modal modal2">
    <div class="modal-content">
        <form action="#" enctype="multipart/form-data" id="formeditgal" method="post" autocomplete="off" class="col s12 m5 offset-m3 container">
            <input type="hidden" id="idformedit" name="ideditcomp" />
            <div class="row mgtop">
                <div class="input-field col s12 right ">
                    <i class="mdi-action-toc prefix"></i>
                    <input id="nameedit" name="name" type="text" class="validate" length="50">
                    <label for="nameedit">عنوان مسابقه</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 right">
                    <i class="mdi-communication-clear-all prefix"></i>
                    <input id="sath" name="sath" type="text" class="validate" length="50">
                    <label for="sath">سطح مسابقه</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m8 right">
                    <i class="mdi-image-filter-1 prefix"></i>
                    <input id="startdate" name="startdate" type="text" class="validate ltr" length="10" readonly="on">
                    <label for="startdate">تاریخ شروع</label>
                </div>
                <div class="input-field col s12 m4 right">
                    <img id="date_btn_1" src="[VARURL]/images/icons/cal.png" style="vertical-align: top;" />
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 m8 right">
                    <i class="mdi-image-filter-1 prefix"></i>
                    <input id="enddate" name="enddate" type="text" class="validate ltr" length="10">
                    <label for="enddate">تاریخ پایان</label>
                </div>
                <div class="input-field col s12 m4 right">
                    <img id="date_btn_2" src="[VARURL]/images/icons/cal.png" style="vertical-align: top;" />
                </div>
            </div>
            <div class="row mgbtmz">
                <div class="input-field col s12 right">
                    <i class="mdi-action-subject prefix"></i>
                    <textarea id="commentedit" name="comment" class="materialize-textarea validate" length="250"></textarea>
                    <label for="commentedit">توضیحات</label>
                </div>
            </div>
            <div class="row mgbtmz">
                <div class="input-field col s12 right">
                    <i class="mdi-social-plus-one prefix"></i>
                    <input type="number" id="modwinno" name="modwinno" class="validate">
                    <label for="modwinno">تعداد برندگان</label>
                </div>
            </div>
            <div class="row mgbtmz">
                <div class="input-field col s12 right">
                    <i class="mdi-social-plus-one prefix"></i>
                    <input type="number" id="modselno" name="modselno" class="validate">
                    <label for="modselno">تعداد عکس منتخب</label>
                </div>
            </div>
            <div class="row mgbtmz">
                <div class="input-field col s12 right">
                    <i class="mdi-social-plus-one prefix"></i>
                    <input type="number" id="moddavarino" name="moddavarino" class="validate">
                    <label for="moddavarino">تعداد راه یافته به مرحله داوری</label>
                </div>
            </div>
            <div class="row mgbtmz">
                <div class="input-field col s12 right">
                    <i class="mdi-action-wallet-giftcard prefix"></i>
                    <textarea id="jayeze" name="jayeze" class="materialize-textarea validate" length="250"></textarea>
                    <label for="jayeze">جوایز</label>
                </div>
            </div>
            <div class="row ltr">
                    <div class="col s12 ">
                        <span class="right rtl">مسابقه مردمی :</span>
                        <div class="switch right ltr mgright">
                            <label>
                                فعال
                                <input type="checkbox" id="ispeopleedit" name="ispeopleedit">
                                <span class="lever"></span>
                                غیر فعال
                            </label>
                        </div>
                    </div>
                </div>
                <div id="divpeopleedit" class="row mgbtmz none">
                    <div class="input-field col s12 m9 right">
                        <i class="mdi-image-filter-5 prefix"></i>
                        <input id="peoplecountedit" name="peoplecountedit" type="text" class="validate ltr">
                        <label for="peoplecountedit">تعداد برندگان مسابقه مردمی</label>
                    </div>
                    <div class="input-field col s12 right">
                        <i class="mdi-action-wallet-giftcard prefix"></i>
                        <textarea id="jayezeppledit" name="jayezepeopleedit" class="materialize-textarea validate" length="250"></textarea>
                        <label for="jayezeppledit">جوایز مسابقه مردمی</label>
                    </div>
                </div>
            <div class="row">
                <div class="col s12">
                    <a id="seldavaredit" name="openmodal" class="waves-effect waves-light btn purple darken-3" onclick="davaran()"><i class="material-icons left"></i>انتخاب داوران</a>
                </div>
                <ul id="davarandivedit" class="col s12">
                </ul>
            </div>
            <div class="row">
                <div class="col s12">
                    <a id="selbazedit" name="openmodal" class="waves-effect waves-light btn purple darken-3" onclick="bazbinha()"><i class="material-icons left"></i>انتخاب بازبین ها</a>
                </div>
                <ul id="bazbinhadivedit" class="col s12">
                </ul>
            </div>
<!--            <div class="row">
                <div class="col s12 ltr">
                    <div class="switch right">
                        <label>
                            فعال
                            <input type="checkbox" id="isactiveedit" name="isactiveedit" checked="checked">
                            <span class="lever"></span>
                            غیر فعال
                        </label>
                    </div>
                </div>
            </div>-->
            <div class="row mgbtm">
                <div class="col s12">
                    <button id="editcomp" class="btn waves-effect waves-light right" type="button" name="action">
                        ویرایش
                        <i class="mdi-navigation-check right"></i>
                    </button>
                    <button id="btncloseedit" class="btn waves-effect waves-light pink darken-4 right mgright" type="reset" name="reset">
                        بستن
                        <i class="mdi-navigation-check right"></i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div id="msgerrmod" class="col s12 pink-text text-darken-3 right-align" style="display: none;">این یک پیام است</div>
                <div id="msgsucmod" class="col s12 teal-text text-darken-1 right-align" style="display: none;">این یک پیام است</div>
            </div>
            <input type="hidden" id="iddavs" name="iddsed" />
            <input type="hidden" id="idbazs" name="idbsed" />
        </form>
    </div>
</div>
<div id="modaldavaran" class="modal">
    <div class="modal-content">
        <div class="type none"></div>
        <ul class="lstdavaran">
            [VARDAVARAN]  
        </ul>
        <div class="row mgbtm">
            <div class="col s12">
                <button id="btnchangedavar" class="btn waves-effect waves-light right" type="submit" name="action">
                    تغییر
                    <i class="mdi-navigation-check right"></i>
                </button>
                <button id="btnclosedavar" class="btn waves-effect waves-light pink darken-4 right mgright" type="reset" name="reset">
                    انصراف
                    <i class="mdi-navigation-check right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<div id="modalbazs" class="modal">
    <div class="modal-content">
        <div class="type none"></div>
        <ul class="lstbazs">
            [VARBAZS]  
        </ul>
        <div class="row mgbtm">
            <div class="col s12">
                <button id="btnchangebaz" class="btn waves-effect waves-light right" type="submit" name="action">
                    تغییر
                    <i class="mdi-navigation-check right"></i>
                </button>
                <button id="btnclosebaz" class="btn waves-effect waves-light pink darken-4 right mgright" type="reset" name="reset">
                    انصراف
                    <i class="mdi-navigation-check right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<div id="cntmndiv" class="row grey lighten-3 mgbtmz">
    <div class="clearfix">
        <ul id="sidemenu" class="rtl">
            <li><a href="#reg-content" class="tooltipped open" data-position="bottom" data-delay="50" data-tooltip="ثبت مسابقه جدید"><i class="mdi-action-done-all Medium"></i></a></li>
            <li><a id="editcomphead" href="#edit-content" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="ویرایش مسابقات"><i class="mdi-editor-mode-edit Medium"></i></a></li>
            <li><a id="endforever" href="#endcomp" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="پایان مسابقه"><i class="mdi-content-remove-circle-outline Medium"></i></a></li>
            <li><a id="archives" href="#archivecomps" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="آرشیو مسابقات"><i class="mdi-image-style"></i></a></li>
        </ul>
        <div id="content">
            <div id="reg-content" class="contentblock regdiv">
                <div class="row mgbtmz container">
                    <form action="#" enctype="multipart/form-data" id="formregcomp" method="post" autocomplete="off" class="col s12 m5 offset-m3 mgtop z-depth-1 reltive minsh mgbtm bgblur bdr">
                        <div class="col s12 rtl">
                            <h4 class="flow-text blue-grey darken-3 hdreg white-text">مسابقه جدید</h4>
                        </div>
                        <div class="row mgtop">
                            <div class="input-field col s12 right">
                                <i class="mdi-action-toc prefix"></i>
                                <input id="namecmp" name="name" type="text" class="validate" length="50">
                                <label for="namecmp">عنوان مسابقه</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 right">
                                <i class="mdi-communication-clear-all prefix"></i>
                                <input id="sathcmp" name="sath" type="text" class="validate" length="50">
                                <label for="sathcmp">سطح مسابقه</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m8 right">
                                <i class="mdi-image-filter-1 prefix"></i>
                                <input id="startdatecmp" name="startdate" type="text" class="validate ltr" length="10" readonly="on">
                                <label for="startdatecmp">تاریخ شروع</label>
                            </div>
                            <div class="input-field col s12 m4 right">
                                <img id="date_btn_3" src="[VARURL]/images/icons/cal.png" style="vertical-align: top;" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m8 right">
                                <i class="mdi-image-filter-1 prefix"></i>
                                <input id="enddatecmp" name="enddate" type="text" class="validate ltr" length="10" readonly="on">
                                <label for="enddatecmp">تاریخ پایان</label>
                            </div>
                            <div class="input-field col s12 m4 right">
                                <img id="date_btn_4" src="[VARURL]/images/icons/cal.png" style="vertical-align: top;" />
                            </div>
                        </div>
                        <div class="row mgbtmz">
                            <div class="input-field col s12 right">
                                <i class="mdi-action-subject prefix"></i>
                                <textarea id="commenteditcmp" name="comment" class="materialize-textarea validate" length="250"></textarea>
                                <label for="commenteditcmp">توضیحات</label>
                            </div>
                        </div>
                        <div class="row mgbtmz">
                            <div class="input-field col s12 right">
                                <i class="mdi-social-plus-one prefix"></i>
                                <input type="number" id="winno" name="winno" class="validate">
                                <label for="winno">تعداد برندگان</label>
                            </div>
                        </div>
                        <div class="row mgbtmz">
                            <div class="input-field col s12 right">
                                <i class="mdi-social-plus-one prefix"></i>
                                <input type="number" id="selno" name="selno" class="validate">
                                <label for="selno">تعداد عکس منتخب</label>
                            </div>
                        </div>
                        <div class="row mgbtmz">
                            <div class="input-field col s12 right">
                                <i class="mdi-social-plus-one prefix"></i>
                                <input type="number" id="davarino" name="davarino" class="validate">
                                <label for="davarino">تعداد راه یافته به مرحله داوری</label>
                            </div>
                        </div>
                        <div class="row mgbtmz">
                            <div class="input-field col s12 right">
                                <i class="mdi-action-wallet-giftcard prefix"></i>
                                <textarea id="jayezecmp" name="jayeze" class="materialize-textarea validate" length="250"></textarea>
                                <label for="jayezecmp">جوایز</label>
                            </div>
                        </div>

                        <div class="divider mgbtm"></div>
                        <div class="row ltr">
                            <div class="col s12 ">
                                <span class="right rtl">مسابقه مردمی :</span>
                                <div class="switch right ltr mgright">
                                    <label>
                                        فعال
                                        <input type="checkbox" id="ispeople" name="ispeople">
                                        <span class="lever"></span>
                                        غیر فعال
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div id="divpeople" class="row mgbtmz none">
                                <div class="input-field col s12 m9 right">
                                    <i class="mdi-social-plus-one prefix"></i>
                                    <input id="peoplecount" name="peoplecount" type="number" class="validate">
                                    <label for="peoplecount">تعداد برندگان مسابقه مردمی</label>
                                </div>
                                <div class="input-field col s12 right">
                                    <i class="mdi-action-wallet-giftcard prefix"></i>
                                    <textarea id="jayezeppl" name="jayezepeople" class="materialize-textarea validate" length="250"></textarea>
                                    <label for="jayezeppl">جوایز مسابقه مردمی</label>
                                </div>
                            </div>
                        <div class="divider"></div>
                        <div class="row mgtop">
                            <div class="col s12">
                                <a id="seldavar" class="waves-effect waves-light btn purple darken-3"><i class="material-icons left"></i>انتخاب داوران</a>
                            </div>
                            <input type="hidden" id="idds" name="idds" />
                            <ul id="davarandiv" class="col s12">

                            </ul>
                        </div>
                        <div class="divider"></div>
                        <div class="row mgtop">
                            <div class="col s12">
                                <a id="selbazbin" class="waves-effect waves-light btn purple darken-3"><i class="material-icons left"></i>انتخاب بازبین ها</a>
                            </div>
                            <input type="hidden" id="idbs" name="idbs" />
                            <ul id="bazsdiv" class="col s12">

                            </ul>
                        </div>

                        <div class="divider mgbtm"></div>
                        <div class="row">
                            <div class="file-field input-field">
                                <input class="file-path validate" type="text">
                                <div class="btn teal darken-3" style="margin-top: -66px;">
                                    <span>انتخاب پوستر</span>
                                    <input id="poster" type="file" name="poster">
                                </div>
                            </div>
                        </div>
<!--                        <div class="row">
                            <div class="col s12 ">
                                <div class="switch right ltr">
                                    <label>
                                        فعال
                                        <input type="checkbox" id="isactive" name="isactive" checked="checked">
                                        <span class="lever"></span>
                                        غیر فعال
                                    </label>
                                </div>
                            </div>
                        </div>-->
                        <div class="row">
                            <div class="col s12">
                                <button id="savecomp" class="btn waves-effect waves-light pdbtn" type="button" name="action">
                                    ثبت اطلاعات
                                    <i class="mdi-maps-beenhere right"></i>
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div id="msgerr" class="col s12 pink-text text-darken-3" style="display: none;">این یک پیام است</div>
                            <div id="msgsuc" class="col s12 teal-text text-darken-1" style="display: none;">این یک پیام است</div>
                        </div>
                    </form>
                </div>
                <div class="divider clear"></div>
            </div>
            <div id="edit-content" class="contentblock hidden rtl">
                <div id="compsdiv" class="row container">
                    <!--[VARCOMPS]-->
                </div>
                <div class="divider clear"></div>
                <div id="pagingcompetition" class="row center-align mgtop clear">

                </div>
            </div>
            <div id="endcomp" class="contentblock hidden rtl">
                 <div id="compsfinish" class="row container">
                    
                </div>
                <div class="divider clear"></div>
            </div>
            
            <div id="archivecomps" class="contentblock hidden rtl">
                <div id="archvcmp" class="row container">
                    
                </div>
                <div class="divider clear"></div>
            </div>
        </div>
    </div>
</div>