<div class="bg-image">
    <div class="fluid-container bg-whiting">
        <div class="container">
            <!-- STATR SUBJECT COMPETITIONS -->
            <div class="subject-competitions text-center" style="padding: 20px 0px 0px 0px;">
                <img class="img-head" src="[VARURL]publicuser/style1/images/subject-ribbon.png" />
                <div class="subject-match-head">
                    <span>گالری</span>
                </div>
            </div>
        </div>
        <div class="fluid-container">
            <!-- END SUBJECT COMPETITIONS -->
            <div class="tab-content tab-content2">
                <div id="home" class="tab-pane fade in active">
                    <div id="freewall" class="free-wall home">
                        [VARGALIMAGES]
                    </div>                     
                </div>  
                <!--                <div id="paging" class="btn-div-more">
                                    <input type="hidden" name="whichpg" id="whichpg" value="1">
                                    <button type="button" name="more" id="more" class="btn-more-image">عکس های بیشتر</button>
                                </div>
                                <div id="waiting" class="none" class="btn-div-more">
                                    <button type="button" name="more" id="more" class="btn-load-more-image" >در حال بارگزاری...</button>
                                </div>-->
                <!-- imgModal -->
                <div id="imgModal" class="modal fade" role="dialog">
                    <div  class="modal-dialog modal-lg">
                        <!-- Modal content-->
                        <div id="imgrate" class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title"></h4>
                                <div class="img-details col-md-12 col-sm-12 col-xs-12 paddingright0">
                                    <div class="photographer-name col-sm-3 col-md-3 paddingright0">
                                        <img src="" class="img-circle" />
                                        <span class="us">محمد بلدی</span>
                                    </div>
                                    <div class="competition-name col-md-3 col-sm-3 col-xs-12 paddingright0">
                                        <i class="glyphicon glyphicon-bullhorn"></i>
                                        <a class="cmp" href="#">مسابقه شماره یک</a>
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
                                    <form class="form-group" id="formreport">
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
            </div>
            <div class="divider clear"></div>
            <div id="pagingsearch" class="row center-align mgtop clear load-more-image">
                <a id="btnmore" class="bwaves-effect waves-white  btn purple darken-3 more-img"><i class="mdi-action-search"></i><img src="[VARURL]images/icons/refresh.png" /></a>
            </div>
            <div id="waiting" class="row center-align mgtops load-more-image" style="display: none">
                <a id="wait" class="bwaves-effect waves-white  btn purple darken-3 load-img"><img src="[VARURL]images/icons/refresh-wait.png" /></a>
            </div>
        </div>
    </div>
</div>