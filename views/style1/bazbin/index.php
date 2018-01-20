<div class="container-fluid">
    <div class="row bazbin-match">
        <div id="modaldeny" class="modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <form id="formdeny" method="post" autocomplete="off" class="col-xs-12" onsubmit="return false">
                                <input type="hidden" id="idformdeny" name="id" />
                                <div class="col-xs-12">
                                    <div class="input-field col-md-12 col-xs-12 right" id="modcomm">
                                        <label for="comment">توضیحات</label>
                                        <textarea id="comment" name="comment" class="validate form-control col-ms-12 col-xs-12"></textarea>
                                    </div>
                                    <div class="col-xs-12 none" id="selwhydeny">
                                        <p class="right-align">
                                            <input class="with-gap vertical-middle" name="whydeny" type="radio" id="notsite" value="3"/>
                                            <label for="notsite">عدم ارتباط با سایت</label>
                                        </p>
                                        <p class="right-align">
                                            <input class="with-gap vertical-middle" name="whydeny" type="radio" id="notcomp" value="2" />
                                            <label for="notcomp">عدم ارتباط با مسابقه</label>
                                        </p>
                                        <br/><br/>
                                    </div>
                                    <p class="clear">
                                        <button id="submitdeny" class="btn btn-enteshar right pdz" type="submit" name="action">
                                            تایید
                                            <i class="glyphicon glyphicon-ok right marginleft15"></i>
                                        </button>
                                        <button id="btnclosedeny" class="btn btn-noenteshar right btncancel" type="reset" name="reset" >
                                            انصراف
                                            <i class="glyphicon glyphicon-remove right marginleft15"></i>
                                        </button>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modalgallery2" class="modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" id="closemodaling" class="closemd closing">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>                        
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <!-- <div id="galleryaddr" class="none">[VARGALIMAGESFOLDER]</div>
                            <div id="bgdark"></div>
                            <div class="id none"></div> -->
                            <div class="cnt">
                                <img id="bigimg1" class="img-responsive" src="" />
                            </div>                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default closemd" >بستن</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="grey lighten-3 mgbtmz">
            <div class="col-xs-12 arrow_box"></div>
            <div class="col-xs-12 reltive text-center">
                <i class="mdi-image-photo-camera purple-text icosec lgico"></i>
            </div>
            <div class="clearfix">
                <ul id="sidemenu">
                    <!--[VARSIDEMENU]-->
                    <li id="pubsm"><a href="#cat-content" class="tooltipped open" data-position="bottom" data-delay="50" data-tooltip="طبقه بندی"><i class="glyphicon glyphicon-th-list iconvertical"></i></a></li>
                    <li><a href="#all-content" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="همه عکس ها"><i class="glyphicon glyphicon-picture iconvertical"></i></a></li>
                    <li><a href="#accepted-content" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="تایید شده ها"><i class="glyphicon glyphicon-ok iconvertical"></i></a></li>
                    <li><a href="#deny-content" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="تایید نشده ها"><i class="glyphicon glyphicon-trash iconvertical"></i></a></li>
                </ul>
                <div id="content">
                    <div id="cat-content" class="contentblock">
                        <div class="container">
                            <div class="input-field col-xs-12 col-md-5 col-md-offset-7 mgtopcmp">
                                <label class="right">انتخاب مسابقه</label>
                                <select id="pubcmp" name="pubcmp" class="col-xs-12 dir-rtl" onchange="changepubComp()">
                                    [VARPUBCOMPS]
                                </select>
                            </div>
                            <div class="col-xs-12 mgtopcmp text-center margintop25bottom15">
                                <a id="catall" class="cattab waves-effect waves-teal btn-flat active">همه عکسها</a>
                                <a id="catviewd" class="cattab waves-effect waves-teal btn-flat">منتشر شده ها</a>
                                <a id="catarchive" class="cattab waves-effect waves-teal btn-flat">آرشیو شده</a>
                            </div>
                            <div id="divcatitems" class="col-xs-12 catdiv mgtopcmp">
                                <!-- Item -->
                                [VARPHOTPUB]
                            </div>
                        </div>
                        <div class="divider clear"></div>
                        <div id="pagingall" class="row center-align mgtop clear load-more-image">
                            <a id="btnmore" class="bwaves-effect waves-white  btn purple darken-3 more-img">
                                <img src="[VARURL]images/icons/refresh.png" />
                            </a>
                        </div>
                        <div id="waiting1" class="row center-align mgtops load-more-image" style="display: none">
                            <a id="wait" class="bwaves-effect waves-white  btn purple darken-3 load-img">
                                <img src="[VARURL]images/icons/refresh-wait.png" />
                            </a>
                        </div>
                    </div>

                    <div id="all-content" class="contentblock hidden">
                        <div class="container">
                            <div class="input-field col-xs-12 col-md-6 mgtopcmp center-align">
                                <span id="remdiv" class="teal-text text-darken-3">[VARIMGDIV]</span>
                                <span>: تعداد باقیمانده</span>
                            </div>
                            <div id="compsforbaz" class="input-field col-xs-12 col-md-6 mgtopcmp">
                                <label class="right">انتخاب مسابقه</label>
                                <select id="competition" name="competition" class="col-xs-12 teal-text text-darken-3 dir-rtl" onchange="changeCompatition()">
                                    [VARCOMPS]
                                </select>
                            </div>
                            <div class="col-xs-12 alldiv margintop25" id="axs">
                                [VARNOTINBAZ]
                            </div>
                        </div>
                        <div class="divider clear"></div>
                        <div id="pagingallcomp" class="row center-align mgtop clear load-more-image">
                            <a id="btnmorecomp" class="bwaves-effect waves-white  btn purple darken-3 more-img">
                                <img src="[VARURL]images/icons/refresh.png" />
                            </a>
                        </div>
                        <div id="waiting2" class="row center-align mgtops load-more-image" style="display: none">
                            <a id="wait" class="bwaves-effect waves-white  btn purple darken-3 load-img">
                                <img src="[VARURL]images/icons/refresh-wait.png" />
                            </a>
                        </div>
                    </div>

                    <div id="accepted-content" class="contentblock hidden">
                        <div class="container">
                            <div id="accepteddivres" class="col-xs-12 accepteddiv">
                                [VAROKPHOTO]
                            </div>
                        </div>
                        <div class="divider clear"></div>
                        <div id="pagingaccepted" class="row center-align mgtop clear load-more-image">
                            <a id="btnmoreaccepted" class="bwaves-effect waves-white btn purple darken-3 more-img">
                                <img src="[VARURL]images/icons/refresh.png" />
                            </a>
                        </div>
                        <div id="waiting3" class="row center-align mgtops load-more-image" style="display: none">
                            <a id="wait" class="bwaves-effect waves-white  btn purple darken-3 load-img">
                                <img src="[VARURL]images/icons/refresh-wait.png" />
                            </a>
                        </div>
                    </div>

                    <div id="deny-content" class="contentblock hidden">
                        <div class="container">
                            <div class="col-xs-12 denydiv " id="deny">
                                [VARNOTOK]
                            </div>
                        </div>
                        <div class="divider clear"></div>
                        <div id="pagingsearch" class="row text-center mgtop clear load-more-image load-more-image">
                            <a id="btnmore" class="bwaves-effect waves-white  btn purple darken-3 more-img "><i class="mdi-action-search"></i>
                                <img src="[VARURL]images/icons/refresh.png" />
                            </a>
                        </div>
                        <div id="waiting" class="row text-center mgtops load-more-image load-more-image" style="display: none">
                            <a id="wait" class="bwaves-effect waves-white  btn purple darken-3 load-img">
                                <img src="[VARURL]images/icons/refresh-wait.png" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</div>
