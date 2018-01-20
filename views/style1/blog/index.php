<div class="fluid-container bg-whiting">
    <div class="container">
        <div class="row">
            <div id="followersmodal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content mystyle1">
                        <div class="modal-body">
                            <h4>دنبال کنندگان</h4>
                            <ul class="collection">
                                [VARFOLLOWERINFO]
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <a href="#" data-dismiss="modal" class="decorationnone">بستن</a>
                        </div>
                    </div>
                </div>
            </div>

            <div id="followingsmodal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content mystyle1">
                        <div class="modal-body">
                            <h4>دنبال شوندگان</h4>
                            <ul class="collection">
                                [VARFOLLOWINGINFO]
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <a href="#!" data-dismiss="modal" class="decorationnone">بستن</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="imgModal" class="modal fade" role="dialog">
                <div  class="modal-dialog modal-lg">
                    <!-- Modal content-->
                    <div id="imgrate" class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title"></h4>
                            <div class="img-details col-md-12 col-sm-12 col-xs-12 paddingright0">
                                <!--                            <div class="photographer-name col-sm-3 col-md-3 paddingright0">
                                                                <img src="[VARURL]images/icons/profile-icon.png" class="img-circle" />
                                                                <span class="us">محمد بلدی</span>
                                                            </div>-->
                                <div class="competition-name col-md-3 col-sm-3 col-xs-12 paddingright0">
                                    <i class="glyphicon glyphicon-bullhorn"></i>
                                    <a class="cmp" href="">مسابقه شماره یک</a>
                                </div>
                                <div class="upload-date col-md-3 col-sm-3  col-xs-12 paddingright0">
                                    <i class="glyphicon glyphicon-calendar"></i>
                                    <span class="dt span">12 بهمن 1394</span>
                                </div>
                                <div class="rating-img onestar col-md-3 col-sm-3 col-xs-12 paddingright0 paddingleft0 none">
                                    <span class="padding3"></span>
                                    <span class="glyphicon glyphicon-star star-icon"></span>
                                </div>
                                <div  id="itemrate" class="rating-img col-md-3 col-sm-3 col-xs-12 paddingright0 paddingleft0">
                                    <span>امتیاز: </span>
                                    <input id="input-1" class="rating" data-min="0" data-max="5" data-step="0.5">
                                </div>

                                <!--                                    <div class="rating-img col-md-3 col-sm-3 col-xs-12 paddingright0 paddingleft0">
                                                                        <span>امتیاز: </span>
                                                                        <span class="padding3">14.44</span>
                                                                        <span class="glyphicon glyphicon-star star-icon"></span>
                                                                        <input id="input-20" class="rating" data-rtl="true">
                                                                    </div>-->
                            </div>
                        </div>

                        <div class="modal-body">
                            <img id="bigimg" class="img-responsive" />
                            <p class="cmt">
                                فیل
                            </p>
                        </div>
                        <div  class="modal-footer">
                            <button type="button" class="btn btn-takhalof" id="modal-launcher">گزارش تخلف</button>
                            <div id="modal-background"></div>
                            <div id="modal-content"  class="violationimg">
                                <form class="form-group" action="#" enctype="multipart/form-data" id="formreport" method="post" autocomplete="off">
                                    <label for="violationtype">نوع تخلف:</label>
                                    <input type="text" id="subjectrep" name="subject" class="form-control" />

                                    <label for="violationcomments">توضیحات:</label>
                                    <textarea id="comment" name="comment" rows="5" class="form-control"></textarea>

                                    <div class="btn-group btn-group-justified">
                                        <div class="btn-group">
                                            <button id="btnregrep" type="button" class="btn btn-primary">
                                                <span class="glyphicon glyphicon-ok"></span>
                                                ثبت
                                            </button>
                                            <button  type="button" class="btn btn-primary" id="modal-close">
                                                <span class="glyphicon glyphicon-remove"></span>
                                                بستن
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="msgerrmod" class="text-right paddingtopbottom5 alert-error" style="display: none">لطفا اطلاعات را وارد کنید.</div>
                                            <div id="msgsucmod" class="text-right paddingtopbottom5 alert-ok" style="display: none">اطلاعات با موفقیت ثبت شد.</div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div id="modalreport" class="modal">
                <div class="modal-content">
                    <form action="#" enctype="multipart/form-data" id="formreport" method="post" autocomplete="off" class="col s12 m5 offset-m3 container">
                        <div class="row mgtop">
                            <div class="input-field col s12 right">
                                <i class="mdi-action-toc prefix"></i>
                                <input id="subjectrep" name="subject" type="text" class="validate" length="50">
                                <label for="subjectrep">نوع تخلف</label>
                            </div>
                        </div>
                        <div class="row mgbtmz">
                            <div class="input-field col s12 right">
                                <i class="mdi-action-subject prefix"></i>
                                <textarea id="comment" name="comment" class="materialize-textarea validate" length="250"></textarea>
                                <label for="comment">توضیحات</label>
                            </div>
                        </div>
                        <div class="row mgbtm">
                            <div class="col s12">
                                <button id="btnregrep" class="btn waves-effect waves-light right" type="button" name="action">
                                    ثبت
                                    <i class="mdi-navigation-check right"></i>
                                </button>
                                <button id="btncloserep" class="btn waves-effect waves-light pink darken-4 right mgright" type="reset" name="reset">
                                    بستن
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
            </div> -->
            <!--<div id="modalgallery">
                <div id="bgdark"></div>
                <div id="imgrate" class="reltive center-align">
                    <div class="id none"></div>
                    <div class="cnt row container">
                        <img id="bigimg" class="col s12 m7 mgbtm" />
                        <div class="col s12 m5">
                            <h5 class="tl"></h5>
                            <h6 class="cmp teal-text text-lighten-1"></h6>
                            <div id="typebarande" class="right"> </div>
                            <div class="clearfix">
                                <img class="av right" />
                                <div class="us pdus"></div>
                            </div>
    
                            <div class="dt clear"><i class="mdi-image-filter-5 lgico grey-text "></i><span></span></div>
                             ********************************************************* 
    
                            <div id="itemrate" class="ltr"></div> <input type="text" id="ratevalue" class="none" />
                             ********************************************************* 
                            <div class="right-align clear">
                                <a id="btnshowrep" class="waves-effect waves-light btn">گزارش کردن</a>
                            </div>
                        </div>
                        <div class="cmt right-align col s12"></div>
                    </div>
                    <a class="bwaves-effect waves-white closemd"><i class="mdi-navigation-close"></i></a>
                </div>
            </div>-->
            <!--<div id="modalgallery">
                <div id="bgdark"></div>
                <div id="imgrate" class="reltive center-align">
                    <div class="id none"></div>
                    <div class="cnt row container">
                        <img id="bigimg" class="col s12 m5 mgbtm" />
                        <div class="col s12 m7">
                            <h5 class="tl" id="modtl"></h5>
                            <h6 class="cmp teal-text text-lighten-1" id="modcmp"></h6>
                            <img class="av right" id='modav' />
                            <div class="us pdus" id='modus'></div>
                            <div class="dt clear" id='moddt'></div>
                            <div class="dt clear" id='moddt'></div>
                            ********************************************************* 
                            <div id="itemrate" class="ltr none"></div> <input type="text" id="ratevalue" class="none" />
                            ********************************************************* 
                            <div class="right-align clear">
                                <a id="btnshowrep" class="waves-effect waves-light btn">گزارش کردن</a>
                            </div>
    
                        </div>
                        <div class="cmt right-align col s12" id="modcmt"></div>
                    </div>
                    <a class="bwaves-effect waves-white closemd"><i class="mdi-navigation-close"></i></a>
                </div>
            </div>-->
            <div class="row mgbtmz">
                <!--    <div class="col s12">
                        <img id="hdimg" src="[VARHEADER]" />
                    </div>-->
            </div>
            <div class="col-md-12">
                <div class="col-md-2 center-align details-usering">
                    <img id="avatarus" src="[VARAVATAR]" alt="" class="img-circle" />
                    <h5 class="flow-text teal-text text-darken-3" style="padding: 10px 0px 20px 0px;">[VARUSERNAME]</h5>
                    [VARFLWLINK]
                    <div class="divider marginbottom10"></div>        
                    <p class="grey-text text-darken-4 justify">‌[VARUSERINFO]</p>
                    <div class="card">
                        <div id="infouser" class="card-content">
                            <div class="mgbtm padding-style1">آمار</div>
                            <div class="divider"></div>
                            <p class="padding-style2">آپلود : [VARUSERPHOTONUMBER]</p>
                            <p class="padding-style2"><a data-toggle="modal" data-target="#followersmodal" style="color: #ffffff;text-decoration:none;" class="cursorp">دنبال کنندگان: [VARFOLLOWING]</a></p>
                            <p class="padding-style2"><a class="padding-style1 cursorp" data-toggle="modal" data-target="#followingsmodal" style="color: #ffffff;text-decoration:none;">دنبال شوندگان: [VARFOLLOWER]</a></p>
                            <!--<p>کامنت : [VARUSERCOMNUMBER]</p>-->
                            <!--<p>پاسخ : [VARUSERSUBCOMNUMBER]</p>-->
                        </div>
                    </div>
                    <div class="card margintop20 margin-bottom40">
                        <div class="card-content infother">
                            <div class="mgbtm padding-style1">فعالیت ها</div>
                            <div class="divider"></div>
                            [VARSCORE]

                            [VARWINS]
                        </div>
                    </div>
                </div>
                <div class="col-md-10">
                    <div class="grey lighten-3 mgbtmz blog-new-style">
                        <div class="col-md-12 arrow_box"></div>
                        <div class="colmd-12 mgtop reltive center-align">
                            <i class="mdi-image-filter-hdr purple-text icosec lgico"></i>
                            <div class="subject-competitions text-center" style="padding: 20px 0px 0px 0px;">
                                <img src="[VARURL]publicuser/style1/images/subject-ribbon.png" />
                                <div class="subject-match-head">
                                    <span>گالری تصاویر</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="gallery-control">
                                    <div class="col-md-12">
                                        <div class="col-md-6 col-xs-6" >
                                            <div class="circle-border">
                                                <div id="populer" class="filter" data-filter=".populer" data-index="1">
                                                    <a>محبوب ترین</a>
                                                    <div class="line-select"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-xs-6" >
                                            <div class="circle-border">
                                                <div id="latest" class="filter active" data-filter=".latest" data-index="2">
                                                    <a>جدیدترین ها</a>
                                                    <div class="line-select"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--                                <div class="active col-md-6 col-xs-12" id="populer" data-filter=".populer" data-index="1"><a>محبوب ترین</a></div>-->
                                        <!--                                <div class="col-md-6 col-xs-12" id="latest" data-filter=".latest" data-index="2"><a>جدیدترین ها</a></div>-->
                                        <!--<li class="filter col s12 m4 right" data-filter=".viewed" data-index="3"><a>پربازدیدترین </a></li>-->
                                    </div>
                                </div>

                                <div class="border-toping col-md-12">
                                    <div id="freewall" class="free-wall home" >
                                        <!--<div class="clear" id="blogimg">-->
                                        [VARGALIMAGES]
                                        <!--</div>-->
                                    </div>
                                </div>

                                <!--wait $ more were here-->
                            </div>
                            <div id="paging1" class="center-align mgtops load-more-image">
                                <a id="btnmore" class="bwaves-effect waves-white  btn purple darken-3 more-img">
                                    <img src="[VARURL]images/icons/refresh.png" />
                                </a>
                            </div>
                            <div id="waiting" class="center-align mgtops load-more-image" style="display: none">
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
</div>