<div class="row" >
    <ul class="adminmnu col-xs-12">
        <li><a href="[VARURL]adminuser">مدیریت کاربران</a></li>
        <li><a href="[VARURL]adminphoto">تصاویر</a></li>
        <li><a href="[VARURL]admincomp">مسابقات</a></li>
        <li><a href="[VARURL]adminupload">تنظیمات آپلود</a></li>
        <li><a href="[VARURL]adminconfig">تنظیمات سایت</a></li>
        <li><a href="[VARURL]adminabout" class="active"> درباره ی ما</a></li>
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
        <form action="#" id="formreg" method="post" autocomplete="off" class="col s12 m8 offset-m2 mgtop z-depth-1 reltive minsh mgbtm bgblur bdr">
            <h4 class="flow-text blue-grey darken-3 hdreg white-text">تنظیمات درباره ما</h4>
            <div class="row mgbtmz mgtop">
                <div class="input-field col s12 right">
                    <i class="mdi-action-subject prefix"></i>
                    <textarea id="comment" name="comment" class="materialize-textarea validate" length="250">[VARVALUEABOUT]</textarea>
                    <label for="comment">توضیحات</label>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <button  id="send" class="btn waves-effect waves-light pdbtn" type="button" name="action">
                        ثبت اطلاعات
                        <i class="mdi-maps-beenhere right"></i>
                    </button>
                </div>
            </div>
            <div class="row">
                <div id="msgerr"  class="col s12 pink-text text-darken-3" style="display: none">این یک پیام است</div>
                <div id="msgsuc" class="col s12 teal-text text-darken-1" style="display: none">این یک پیام است</div>
            </div>
        </form>
    </div>
</div>