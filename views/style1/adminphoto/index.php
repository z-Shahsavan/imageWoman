<div class="row">
    <ul class="adminmnu col-xs-12">
        <li><a href="[VARURL]adminuser">مدیریت کاربران</a></li>
        <li><a href="[VARURL]adminphoto"  class="active">تصاویر</a></li>
        <li><a href="[VARURL]admincomp">مسابقات</a></li>
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
<div id="modalgallery">
    <div id="galleryaddr" class="none">[VARBIGIMG]</div>
    <div id="bgdark"></div>
    <div id="imgrate" class="reltive center-align">
        <img id="bigimg" />
        <a class="bwaves-effect waves-white closemd"><i class="mdi-navigation-close"></i></a>
    </div>
</div>
<div id="modalwinner" class="modal">
    <div class="modal-content">
        <form id="formwinner" method="post" autocomplete="off" class="col s12" onsubmit="return false">
            <input type="hidden" id="idformwinner" name="id" />
            <input type="hidden" id="winstatus" name="winstatus" />
            <div class="col s12">
                <div class="row container right">
                    <div class="input-field col s12 right">
                        <i class="mdi-action-subject prefix"></i>
                        <textarea id="comment" name="comment" class="materialize-textarea validate" length="120"></textarea>
                        <label for="comment">توضیحات</label>
                    </div>
                    <div id="grd" class="input-field col s12 right">
                        <i class="mdi-image-grain prefix"></i>
                        <input id="grade" name="grade" type="text" class="validate" length="40">
                        <label for="grade">رتبه</label>
                    </div>
                    <div class="input-field col s12 right">
                        <i class="mdi-image-grain prefix"></i>
                        <input id="jayeze" name="jayeze" type="text" class="validate" length="100">
                        <label for="jayeze">جایزه</label>
                    </div>
                    <p class="clear">
                        <button id="submitwinner" class="btn waves-effect waves-light right pdz" type="submit" name="action">
                            تایید
                            <i class="mdi-navigation-check right"></i>
                        </button>
                        <button id="btnclosewinner" class="btn waves-effect waves-light pink darken-4 right btncancel" type="reset" name="reset">
                            بستن
                            <i class="mdi-navigation-cancel right"></i>
                        </button>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col s12 pink-text text-darken-3 right-align msgerr">این یک پیام است</div>
                <div class="col s12 teal-text text-darken-1 right-align msgok">این یک پیام است</div>
            </div>
        </form>
    </div>
</div>
<div id="modaldeny" class="modal">
    <div class="modal-content">
        <form id="formdeny" method="post" autocomplete="off" class="col s12" onsubmit="return false">
            <input type="hidden" id="idformdeny" name="id" />
            <div class="col s12">
                <div class="row container right">
                    <div class="col s12 " id="selwhydeny">
                        <p class="right-align">
                            <input class="with-gap" name="whydeny" type="radio" id="notsite" value="3"/>
                            <label for="notsite">عدم ارتباط با سایت</label>
                        </p>
                        <p class="right-align">
                            <input class="with-gap" name="whydeny" type="radio" id="notcomp" value="2" />
                            <label for="notcomp">عدم ارتباط با مسابقه</label>
                        </p>
                        <br/><br/>
                    </div>
                    <p class="clear">
                        <button id="submitdeny" class="btn waves-effect waves-light right pdz" type="button" name="action">
                            تایید
                            <i class="mdi-navigation-check right"></i>
                        </button>
                        <button id="btnclosedeny" class="btn waves-effect waves-light pink darken-4 right btncancel" type="reset" name="reset">
                            بستن
                            <i class="mdi-navigation-cancel right"></i>
                        </button>
                    </p>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row grey lighten-3 mgbtmz">
    <div class="clearfix">
        <ul id="sidemenu">
            <li><a href="#cat-content" class="tooltipped open" data-position="bottom" data-delay="50" data-tooltip="طبقه بندی"><i class="mdi-action-dashboard Medium"></i></a></li>
            <li><a href="#taeednashode-content" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="برندگان داوری"><i class="mdi-editor-insert-photo Medium"></i></a></li>
            <li><a href="#competition-content" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="برندگان مردمی"><i class="mdi-image-style Medium"></i></a></li>
        </ul>
        <div id="content">
            <div id="cat-content" class="contentblock">
                <div class="row container">
                    <form action=""  id="formsearchphoto" method="post" autocomplete="off" class="col s12">
                        <div class="col s12">
                            <div class="input-field col s12 m4 right">
                                <input id="searchuser" name="searchphoto" type="text" class="validate" placeholder="جستجو بر اساس نام عکس">
                            </div>
                            <input type="hidden" name="pidhide" value="catall" id="pidhide">
                            <p>
                                <button id="submitphotosearch" class="btn waves-effect waves-light right pdz" type="button" name="action">
                                    جستجو
                                    <i class="mdi-action-search right"></i>
                                </button>
                            </p>
                        </div>
                    </form>
                    <div class="divider clear"></div>
                    <div id="searchresult" class="col s12 m10 offset-m1 searchdiv">
                    </div>
                    <ul class="col s12 mgtopcmp">
                        <li>
                            <a id="catall" class="cattab waves-effect waves-teal btn-flat active">منتشر شده ها</a>
                        </li>
                        <li>
                            <a id="catviewd" class="cattab waves-effect waves-teal btn-flat">در انتظار تایید</a>
                        </li>
                        <li>
                            <a id="norelateweb" class="cattab waves-effect waves-teal btn-flat"> نامرتبط با سایت</a>
                        </li>

                        <li>
                            <a id="norelatecomp" class="cattab waves-effect waves-teal btn-flat"> نامرتبط با مسابقه</a>
                        </li>
                    </ul>
                    <div id="divcatitems" class="col s12 catdiv mgtopcmp">
                        [VARITEMPHOTO]
                    </div>
                </div>
                <div class="divider clear"></div>
                <div id="pagingall" class="row center-align mgtop clear">
                    <a id="btnmore" class="bwaves-effect waves-white  btn purple darken-3">بیشتر</a>
                </div>
                <div id="waiting" class="row center-align mgtops" style="display: none">
                    <a id="wait" class="bwaves-effect waves-white  btn purple darken-3">انتظار</a>
                </div>
            </div>
            <div id="taeednashode-content" class="contentblock hidden">
                <div class="row container">
                    <div class="col s12 m8 mgtopcmp center-align mgbtm">
                        <a id="downimagestn" class="waves-effect waves-light btn"><i class="mdi-file-file-download right"></i>دانلود تصاویر</a>
                        <a id="linkdownimagestn" class="none waves-light">لینک دانلود</a>
                    </div>
                    <div class="input-field col s12 m4 mgtopcmp">
                        <select id="davaricomp" name="davaricomp" class="col s11 teal-text text-darken-3" onchange="changeDavComp()">

                        </select>
                        <label>انتخاب مسابقه</label>
                    </div>
                    <div id="divtaeednashode" class="col s12 clear mgtopcmp">
                        <!-- Item -->
                    </div>
                </div>
                <div class="divider clear"></div>
                <div id="pagingtaeednashode" class="row center-align mgtop clear">
                </div>
            </div>
            <div id="competition-content" class="contentblock hidden">
                <div class="row container">
                    <div class="col s12 m8 mgtopcmp center-align mgbtm">
                        <a id="downimages" class="waves-effect waves-light btn"><i class="mdi-file-file-download right"></i>دانلود تصاویر</a>
                        <a id="linkdownimages" class="none waves-light">لینک دانلود</a>
                    </div>
                    <div class="input-field col s12 m4 mgtopcmp">
                        <select id="competition" name="competition" class="col s11 teal-text text-darken-3" onchange="changeCompatition()">

                        </select>
                        <label>انتخاب مسابقه</label>
                    </div>
                    <div id="divcompetition" class="col s12 clear mgtopcmp">
                        <!-- Item -->
                    </div>
                </div>
                <div class="divider clear"></div>
                <div id="pagingcompetition" class="row center-align mgtop clear">
                </div>
            </div>
        </div>
    </div>
</div>