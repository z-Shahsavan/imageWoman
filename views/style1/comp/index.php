<div class="bg-image">
    <div class="fluid-container">
        <div class="comp-new-style">
            <div class="head-match">
<!--                <img src="[VARURL]publicuser/style1/images/head-match.png" />-->
                <h5 class="col-xs-12 mgtop center-align subject-h5">[VARSUBJECTNAME]</h5>
                <div class="detailul">
                    [VARPGHEADER]
                </div>
            </div>
            <div class="">
                <div id="thissubid" class="none">[VARTHISSUBID]</div>
                <div class="grey lighten-3 mgbtmz clear-boo">
                    <!--    <div class="col s12 arrow_box arrow_boxtp">
                            <i class="mdi-image-filter-hdr purple-text icosec lgico cmp"></i>
                        </div>-->
                    <div id="cat-content" class="col-md-12 margintop35" >
                        <div class="container width100circle">
                            <div class="row">
                                <div class="gallery-control col-md-12">
                                    [VARHEADPRICE]
                                    [VARHEADBARANDE]
                                    [VARHEADMARDOMI]
                                    <div class="col-md-2 col-sm-2 col-xs-6" >
                                        <div class="circle-border">
                                            <div id="davari" class="filter" >
                                                <a>منتخب داوری</a>
                                                <div class="line-select"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-6">
                                        <div class="circle-border">
                                            <div id="davari" class="filter" >
                                                <a style="padding-top: 31%;">راه یافته به <br> داوری</a>
                                                <div class="line-select"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-2 col-xs-12">
                                        <div class="circle-border">
                                            <div id="allpic" class="filter active" >
                                                <a>همه عکس ها</a>
                                                <div class="line-select"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- prizeModal -->
                        <div id="prizeModal1" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg width100">
                                <div class="modal-content hidepromodal">
                                    <div class="modal-header bordernone">
                                        <button type="button" class="close opacity8 fontsize44 floatright" data-dismiss="modal"><span class="colorf glyphicon glyphicon-remove"></span></button>
                                    </div>
                                    <div class="modal-body">
                                        <img src="" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- imgModal -->
                        <div id="imgModal" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <!-- Modal content-->
                                <div id="imgrate" class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        <h4 class="modal-title"></h4>
                                        <div class="img-details col-md-12 col-sm-12 col-xs-12 paddingright0">
                                            <div class="photographer-name col-sm-3 col-md-3 paddingright0">
                                                <img src="[VARURL]images/icons/user-profile-icon.png" class="img-circle" />
                                                <span class="us"></span>
                                            </div>
                                            <div class="competition-name col-md-3 col-sm-3 col-xs-12 paddingright0">
                                                <i class="glyphicon glyphicon-bullhorn"></i>
                                                <a href="#" id="cmp"></a>
                                            </div>
                                            <div class="upload-date col-md-3 col-sm-3  col-xs-12 paddingright0">
                                                <i class="glyphicon glyphicon-calendar"></i>
                                                <span class="dt"></span>
                                            </div>
                                            <div class="rating-img onestar col-md-3 col-sm-3 col-xs-12 paddingright0 paddingleft0 none">
                                                <span class="padding3"></span>
                                                <span class="glyphicon glyphicon-star star-icon"></span>
                                            </div>
                                            <div class="competition-name wname col-md-3 col-sm-3 col-xs-12 paddingright0 none">
                                                <!--<i class="glyphicon glyphicon-bullhorn"></i>-->
                                                <a href="#" id="winnername"></a>
                                            </div>
                                            <div id="itemrate" class="rating-img col-md-3 col-sm-3 col-xs-12 paddingright0 paddingleft0">
                                                <span>امتیاز: </span>
                                                <input id="input-1" class="rating" data-min="0" data-max="5" data-step="0.5">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <img id="bigimg" src="" class="img-responsive" />
                                        <p class="cmt"></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-takhalof" id="modal-launcher">گزارش تخلف</button>
                                        <div id="modal-background"></div>
                                        <div id="modal-content" class="violationimg">
                                            <form id="formreport" class="form-group">
                                                <label for="violationtype">نوع تخلف:</label>
                                                <input type="text" name="subject"  class="form-control" />

                                                <label for="violationcomments">توضیحات:</label>
                                                <textarea name="comment" rows="5" class="form-control"></textarea>

                                                <div class="btn-group btn-group-justified">
                                                    <div class="btn-group">
                                                        <button id="btnregrep" type="button" class="btn btn-primary">
                                                            <span class="glyphicon glyphicon-ok"></span>
                                                            ثبت
                                                        </button>
                                                        <button type="button" class="btn btn-primary" id="modal-close">
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
                        <div class="row border-toping">
                            <div class="container-fluid">

                                <div class="one-section col-xs-12 col-md-12 col-sm-12 col-xs-12 hidddddvid [VARHIDEVIDEO]">

                                    <!--                                    <div class="text-gallery col-xs-12 col-md-6">hi text prize</div>
                                                                        <div class="video-gallery col-xs-12 col-md-6">
                                                                            <video width="100%" controls>
                                                                                <source src="[VARURL]/prize/film/68c2b2aef5594ce8f5cea462f2de42cb.mp4" type="video/mp4">
                                                                            </video>
                                                                        </div>  -->
                                </div>

                                <div id="freewall" class="free-wall col-md-12">
                                    [VARGALIMAGES]

                                </div>
                            </div>
                            <div id="paging1" class="center-align mgtops load-more-image ">
                                <a id="btnmore" class="bwaves-effect waves-white btn more-img">
                                    <img src="[VARURL]images/icons/refresh.png" />
                                </a>
                            </div>
                            <div id="waiting" class="center-align mgtops load-more-image" style="display: none">
                                <a id="wait" class="bwaves-effect waves-white load-img">
                                    <img src="[VARURL]images/icons/refresh-wait.png" />
                                </a>
                            </div>
                        </div><!-- end of container-fluid -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
