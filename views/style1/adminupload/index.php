<div class="row" >
    <ul class="adminmnu col-xs-12">
        <li><a href="[VARURL]adminuser">مدیریت کاربران</a></li>
        <li><a href="[VARURL]adminphoto">تصاویر</a></li>
        <li><a href="[VARURL]admincomp">مسابقات</a></li>
        <li><a href="[VARURL]adminupload" class="active">تنظیمات آپلود</a></li>
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
<div class="row regdiv mgbtmz">

    <div class="container">
        <form action="#" id="frmupload" method="post" autocomplete="off" class="col s12 m8 offset-m2 mgtop z-depth-1 reltive minsh mgbtm bgblur bdr">
            <h4 class="flow-text blue-grey darken-3 hdreg white-text">تنظیمات آپلود</h4>
            <div class="row mgbtmz">
                <div class="input-field col s12 right mgtop">
                    <i class="mdi-action-perm-media prefix"></i>
                    <label>حداقل سایز تصویر : ( مگابایت )</label>
                    <p class="range-field  mgtop">
                        <input type="range" id="minsize" name="minsize" value="[VARVALUE1]" min="1" max="50" step="1">
                    </p>
                </div>
                <div class="input-field col s12 right">
                    <i class="mdi-action-perm-media prefix"></i>
                    <label>حداکثر سایز تصویر : ( مگابایت )</label>
                    <p class="range-field  mgtop">
                        <input type="range" id="maxsize" name="maxsize" value="[VARVALUE2]" min="1" max="50" step="1">
                    </p>
                </div>
            </div>
            <div class="divider"></div>
            <div class="row mgbtmz">
                <div class="input-field col s12 right">
                    <i class="mdi-social-person prefix"></i>
                    <label>حداکثر سایز آواتار : ( کیلوبایت )</label>
                    <p class="range-field  mgtop">
                        <input type="range" id="maxavatar" name="maxavatar" value="[VARVALUE3]" min="50" max="500" step="10">
                    </p>
                </div>
            </div>
            <div class="divider"></div>
            <div class="row">
                <h5 class="col s12 teal-text text-darken-3 flow-text">فرمت های مجاز :</h5>
                <div class="col s12 ">
                    <span class="right-align right mgleft fnttahoma teal-text text-darken-3">jpg , jpeg :</span>
                    <div class="switch right">
                        <label>
                            بله
                            <input type="checkbox" [VARVALUE7] id="jpg" name="jpg" >
                            <span class="lever"></span>
                            خیر
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 ">
                    <span class="right-align right mgleft fnttahoma teal-text text-darken-3">png :</span>
                    <div class="switch right">
                        <label>
                            بله
                            <input type="checkbox" [VARVALUE8] id="png" name="png">
                            <span class="lever"></span>
                            خیر
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 ">
                    <span class="right-align right mgleft fnttahoma teal-text text-darken-3">gif :</span>
                    <div class="switch right">
                        <label>
                            بله
                            <input type="checkbox" [VARVALUE9] id="gif" name="gif" >
                            <span class="lever"></span>
                            خیر
                        </label>
                    </div>
                </div>
            </div>
            <div class="divider"></div>
            <div class="row">
                <h5 class="col s12 teal-text text-darken-3 flow-text">سایز تصویر :</h5>
                <div class="input-field col s6 m3 right">
                    <i class="mdi-image-filter prefix"></i>
                    <input id="widthimg" name="widthimg" type="text" class="validate ltr" value="[VARVALUE5]">
                    <label for="widthimg" >طول</label>
                </div>
                <div class="input-field col s6 m3 right">
                    <i class="mdi-image-filter prefix"></i>
                    <input id="heightimg" name="heightimg" type="text" class="validate ltr" value="[VARVALUE6]">
                    <label for="heightimg">عرض</label>
                </div>
            </div>
            <div class="divider"></div>
            <div class="row">
                <br />
                <div class="col s12 ">
                    <span class="right-align right mgleft teal-text text-darken-3">ایجاد واترمارک روی تصویر :</span>
                    <div class="switch right">
                        <label>
                            بله
                            <input type="checkbox" [VARVALUE10] id="iswatermark" name="iswatermark">
                            <span class="lever"></span>
                            خیر
                        </label>
                    </div>
                </div>
            </div>
            <div class="divider mgbtm"></div>
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
</div>
