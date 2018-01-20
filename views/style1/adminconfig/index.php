<div class="row" >
    <ul class="adminmnu col-xs-12">
        <li><a href="[VARURL]adminuser">مدیریت کاربران</a></li>
        <li><a href="[VARURL]adminphoto">تصاویر</a></li>
        <li><a href="[VARURL]admincomp">مسابقات</a></li>
        <li><a href="[VARURL]adminupload">تنظیمات آپلود</a></li>
        <li><a href="[VARURL]adminconfig" class="active">تنظیمات سایت</a></li>
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
        <form action="" id="frmupload" method="post" autocomplete="off" class="col s12 m5 offset-m3 mgtop z-depth-1 reltive minsh mgbtm bgblur bdr">
            <h4 class="flow-text blue-grey darken-3 hdreg white-text">تنظیمات</h4>
            <div class="row">
                <div class="input-field col s12 right mgtop">
                    <i class="mdi-action-speaker-notes prefix active"></i>
                    <input id="sitename" name="sitename" type="text" class="validate" value="[VARSITENAME]">
                    <label for="sitename" class="active">نام وب سایت</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12 right">
                    <i class="mdi-maps-layers prefix active"></i>
                    <input id="siteaddress" name="siteaddress" type="text" class="validate ltr" value="[VARSITEADDRESS]">
                    <label for="siteaddress" class="active">آدرس وب سایت</label>
                </div>
            </div>
            <div class="divider"></div>
            <div class="row">
                <br />
                <div class="col s12 mgbtm">
                    <span class="right-align right mgleft teal-text text-darken-3">کش سایت :</span>
                    <div class="switch right">
                        <label>
                            بله
                            <input type="checkbox" [VARSITECACHEBTN] id="ischach" name="ischach">
                            <span class="lever"></span>
                            خیر
                        </label>
                    </div>
                </div>
                <div class="input-field col s8 m5 right">
                    <i class="mdi-device-access-time prefix active"></i>
                    <input id="cachtime" name="cachtime" type="text" class="validate ltr" value="[VARSITECACHEVAL]">
                    <label for="cachtime" class="active">زمان کش</label>
                </div>
            </div>
            <div class="row reltive">
                <div class="input-field col s12 center-align">
                    <div id="imagePreview"></div>
                </div>
                <div class="dropdiv" id="filedrag" name="fileselect">انداختن لوگو در اینجا</div>
                <div class="file-field input-field col s12 center-align">
                    <input class="file-path validate none" type="text" />
                    <div class="btn purple darken-3">
                        <span>انتخاب لوگو</span>
                        <input type="file" id="fileselect" name="fileselect" />
                    </div>
                </div>
            </div>
            <div class="row mgtop reltive">
                <div class="col s12">
                    <div id="prgs"></div>
                </div>
            </div>
            <div class="row mgtop">
                <div  class="col s12 mgtop">
                    <button id="send" class="btn waves-effect waves-light pdbtn" type="button" name="action">
                        ثبت اطلاعات
                        <i class="mdi-maps-beenhere right"></i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div id="msgerrco"  class="col s12 pink-text text-darken-3" style="display: none">خطا</div>
                <div id="msgsucco" class="col s12 teal-text text-darken-1" style="display: none">اطلاعات با موفقیت ثبت شد</div>
            </div>
        </form>
    </div>
</div>
