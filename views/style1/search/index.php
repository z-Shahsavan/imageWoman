<div class="fluid-container bg-whiting" style="height: initial;padding: 50px 0px 150px 0px;background-color: #ffffff;background-image: url(../../../../images/fabric.png);border-top: 2px solid #E4E4E4;">
    <div class="container">
        
        <!-- <div class="row grey lighten-3 mgbtmz">
             <div class="col s12 arrow_box"></div>
             <div class="col s12 reltive center-align">
             <i class="mdi-action-settings purple-text icosec lgico"></i>
        </div> -->
        <!-- imgModal -->
        <div id="imgModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div id="imgrate" class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">نام عکس: عکس شماره یک</h4>
                        <div class="img-details col-md-12 col-sm-12 col-xs-12 paddingright0">
                            <div class="photographer-name col-sm-3 col-md-3 paddingright0">
                                <img src="" class="img-circle" />
                                <span class="us">محمد بلدی</span>
                            </div>
                            <div class="competition-name col-md-3 col-sm-3 col-xs-12 paddingright0">
                                <i class="glyphicon glyphicon-bullhorn"></i>
                                <a href="#" id="cmp"></a>
                            </div>
                            <div class="upload-date col-md-3 col-sm-3  col-xs-12 paddingright0">
                                <i class="glyphicon glyphicon-calendar"></i>
                                <span class="dt">12 بهمن 1394</span>
                            </div>
                            <div class="rating-img onestar col-md-3 col-sm-3 col-xs-12 paddingright0 paddingleft0 none">
                                <span class="padding3"></span>
                                <span class="glyphicon glyphicon-star star-icon"></span>
                            </div>
                            <div id="itemrate" class="rating-img col-md-3 col-sm-3 col-xs-12 paddingright0 paddingleft0">
                                <span>امتیاز: </span>
                                <input id="input-1" class="rating" data-min="0" data-max="5" data-step="0.5">
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <img id="bigimg" src="images/image0.jpg" class="img-responsive" />
                        <p class="cmt">
                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته، حال و آینده شناخت فراوان جامعه و متخصصان را می طلبد تا با نرم افزارها شناخت بیشتری را برای طراحان رایانه ای علی الخصوص طراحان خلاقی و فرهنگ پیشرو در زبان فارسی ایجاد کرد. در این صورت می توان امید داشت که تمام و دشواری موجود در ارائه راهکارها و شرایط سخت تایپ به پایان رسد وزمان مورد نیاز شامل حروفچینی دستاوردهای اصلی و جوابگوی سوالات پیوسته اهل دنیای موجود طراحی اساسا مورد استفاده قرار گیرد.
                        </p>
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
        <!--</div>-->
        <div class="fluid-container">
            <div class="row">
                <div class="col s12 mgtop120" style="margin-top: 50px;">
                    <a id="" class="bwaves-effect waves-white right btn purple darken-3 btn-search serach-icon-section" data-toggle="collapse" data-target="#demo1" ><i class="glyphicon glyphicon-search" style="vertical-align:middle;padding:0px 10px;"></i>جستجوی پیشرفته</a>
                </div>
            </div>
            <div id="demo1" class="collapse frm-search-advance">
                <form action="[VARURL]search/index" enctype="multipart/form-data" id="formchangerole" method="post" autocomplete="off" >
                    <div class="panel-group" id="accordion">
                        <p class="clear clear-both">
                        <div class="panel" style="background-color: transparent;">
                            <div class="right-align" data-toggle="collapse" data-parent="#accordion" data-target="#demo2">
                                <input class="with-gap" name="searchby" type="radio" id="radiocomp" value="2"/>
                                <label for="radiocomp">جستجو بر اساس مسابقه</label>
                            </div>
                            <div id="demo2" class="collapse demo2">
                                <div class="input-field col-md-4 right input-text float-right margin-control">
                                    <input id="searchnamecmp" name="searchcompname" type="text" class="height44 validate blue-grey-text form-control col-md-4" placeholder="موضوع تصویر">
                                </div>
                                <div class="input-field col-md-4 right float-right clear-both">
                                    <select id="compmatch" name="dropcomptype" class="form-control height44">
                                        <option name="0" value="0" selected>انتخاب نوع جستجو</option>
                                        <option name="1" value="1">جدیدترین</option>
                                        <option name="2" value="2">محبوب ترین</option>
                                        <option name="3" value="3">نام</option>
                                        <option name="4" value="4">بازه ی زمانی</option>
                                    </select>
                                </div>
                                <div class="col-md-4"></div>
                                <div class="input-field right col-md-4" id="date-search">
                                    از تاریخ : 
                                    <input id="date_input_1" type="text" class="height44 form-control" name="tarikh1" />
                                    تا تاریخ : 
                                    <input id="date_input_2" type="text" class="height44 form-control" name="tarikh2" />
                                </div>
                                <div class="input-field right col-md-4" id="name-search">
                                    <select name="dropcomp" class="height44 form-control">
                                        <option value="0" selected>انتخاب نوع جستجو</option>
                                        [VARCOMPNAME]
                                    </select>
                                </div>
                            </div>
                        </div>
                        </p>
                        <p class="clear clear-both">
                        <div class="panel" style="background-color: transparent;">
                            <div class="right-align" data-toggle="collapse" data-parent="#accordion" data-target="#demo3">
                                <input class="with-gap" name="searchby" type="radio" id="radiohashtag" value="4" />
                                <label for="radiohashtag">جستجو بر اساس هشتگ</label>
                            </div>
                            <div id="demo3" class="row collapse" id="divhashtag">
                                <div class="input-field col-md-4 float-right margin-control">
                                    <input id="searchhashtag" name="searchhashtag" type="text" class="height44 form-control validate blue-grey-text" placeholder="هشتگ تصویر">
                                </div>
                            </div>
                        </div>
                        </p>
                        <p class="clear clear-both">
                        <div class="panel" style="background-color: transparent;">
                            <div class="right-align" data-toggle="collapse" data-parent="#accordion" data-target="#demo4">
                                <input class="with-gap" name="searchby" type="radio" id="radiousers" value="5" />
                                <label for="radiousers">جستجو بر اساس کاربران</label>
                            </div>
                            <div id="demo4" class="collapse row" id="divuser">
                                <div class="input-field col-md-4 float-right right margin-control">
                                    <input id="searchuser" name="searchuser" type="text" class="height44 form-control validate blue-grey-text" placeholder="نام کاربری">
                                </div>
                            </div>
                        </div>
                        </p>
                        <p class="clear clear-both">
                        <div class="panel" style="background-color: transparent;">
                            <div class="right-align" data-toggle="collapse" data-parent="#accordion" data-target="#demo5">
                                <input class="with-gap" name="searchby" type="radio" id="radioplace" value="6" />
                                <label for="radioplace">جستجو بر اساس مکان</label>
                            </div>
                            <div id="demo5"  class="row collapse" id="divplace">
                                <div class="input-field col-md-4 float-right offset-m8 right margin-control">
                                    <input id="searchplace" name="searchplace" type="text" class="height44 form-control validate blue-grey-text" placeholder="موضوع تصویر">
                                </div>
                                <div class="input-field col-md-4 right float-right clear-both">
                                    <select id="dropplace" name="dropplace" class="form-control height44">
                                        <option value="0"  [VARTITLESTATES] selected>انتخاب مکان جستجو</option>
                                        [VARSTATES]
                                    </select>
                                </div>
                            </div>
                        </div>
                        </p>
                        <p>
                            <a id="submituser" class="btn waves-effect waves-light right pdz teal darken-3 search-click" onclick="advancesearch()" >
                                <i class="glyphicon glyphicon-search" style="vertical-align:middle;padding:0px 10px;"></i>
                                جستجو
                            </a>
                        </p>
                    </div>
                </form>
            </div>
            <div class="divider z-depth-1 mgbtm"></div>
            <div class="row center-align result-text" >
                <div class="col-md-12 mgtop">
                    [VARINF]
                </div>
            </div>

            <div class="row bg-img">
                <div id="freewall" class="free-wall">
                    [VARSEARCH]
                    <!--<div class="brick">-->
                    <!--                    <div class="image-head">
                                            <div class="score-image1">
                                                <img src="images/score-icon.png" />
                                                <span>4,25</span>
                                            </div>
                                            <a href="#">
                                                <div class="details-image1">
                                                    <img src="images/profile-icon.png" />
                                                    <span>عنوان عکس 1</span>
                                                </div>
                                            </a>
                                        </div>
                                        <a href="#" data-toggle="modal" data-target="#imgModal"><img src="images/image1.jpg" width="100%"></a>-->

                    <!--                <div class="brick">
                                        <div class="image-head">
                                            <div class="score-image1">
                                                <img src="images/score-icon.png" />
                                                <span>4,25</span>
                                            </div>
                                            <a href="#">
                                                <div class="details-image1">
                                                    <img src="images/profile-icon.png" />
                                                    <span>عنوان عکس</span>
                                                </div>
                                            </a>
                                        </div>
                                        <a href="#"><img src="images/image2.jpg" width="100%"></a>
                                    </div>
                                    <div class="brick">
                                        <div class="image-head">
                                            <div class="score-image1">
                                                <img src="images/score-icon.png" />
                                                <span>4,25</span>
                                            </div>
                                            <a href="#">
                                                <div class="details-image1">
                                                    <img src="images/profile-icon.png" />
                                                    <span>عنوان عکس</span>
                                                </div>
                                            </a>
                                        </div>
                                        <a href="#"><img src="images/image3.jpg" width="100%"></a>
                                    </div>
                                    <div class="brick">
                                        <div class="image-head">
                                            <div class="score-image1">
                                                <img src="images/score-icon.png" />
                                                <span>4,25</span>
                                            </div>
                                            <a href="#">
                                                <div class="details-image1">
                                                    <img src="images/profile-icon.png" />
                                                    <span>عنوان عکس</span>
                                                </div>
                                            </a>
                                        </div>
                                        <a href="#"><img src="images/image4.jpg" width="100%"></a>
                                    </div>
                                    <div class="brick">
                                        <div class="image-head">
                                            <div class="score-image1">
                                                <img src="images/score-icon.png" />
                                                <span>4,25</span>
                                            </div>
                                            <a href="#">
                                                <div class="details-image1">
                                                    <img src="images/profile-icon.png" />
                                                    <span>عنوان عکس</span>
                                                </div>
                                            </a>
                                        </div>
                                        <a href="#"><img src="images/image5.jpg" width="100%"></a>
                                    </div>
                                    <div class="brick">
                                        <div class="image-head">
                                            <div class="score-image1">
                                                <img src="images/score-icon.png" />
                                                <span>4,25</span>
                                            </div>
                                            <a href="#">
                                                <div class="details-image1">
                                                    <img src="images/profile-icon.png" />
                                                    <span>عنوان عکس</span>
                                                </div>
                                            </a>
                                        </div>
                                        <a href="#"><img src="images/image6.jpg" width="100%"></a>
                                    </div>
                                    <div class="brick">
                                        <div class="image-head">
                                            <div class="score-image1">
                                                <img src="images/score-icon.png" />
                                                <span>4,25</span>
                                            </div>
                                            <a href="#">
                                                <div class="details-image1">
                                                    <img src="images/profile-icon.png" />
                                                    <span>عنوان عکس</span>
                                                </div>
                                            </a>
                                        </div>
                                        <a href="#"><img src="images/image7.jpg" width="100%"></a>
                                    </div>
                                    <div class="brick">
                                        <div class="image-head">
                                            <div class="score-image1">
                                                <img src="images/score-icon.png" />
                                                <span>4,25</span>
                                            </div>
                                            <a href="#">
                                                <div class="details-image1">
                                                    <img src="images/profile-icon.png" />
                                                    <span>عنوان عکس</span>
                                                </div>
                                            </a>
                                        </div>
                                        <a href="#"><img src="images/image8.jpg" width="100%"></a>
                                    </div>
                                    <div class="brick">
                                        <div class="image-head">
                                            <div class="score-image1">
                                                <img src="images/score-icon.png" />
                                                <span>4,25</span>
                                            </div>
                                            <a href="#">
                                                <div class="details-image1">
                                                    <img src="images/profile-icon.png" />
                                                    <span>عنوان عکس</span>
                                                </div>
                                            </a>
                                        </div>
                                        <a href="#"><img src="images/image1.jpg" width="100%"></a>
                                    </div>-->
                </div>
            </div>
        </div>
        <div class="divider clear"></div>
        <div id="pagingsearch" class="row center-align mgtop clear load-more-image">
            <a id="btnmore" class="bwaves-effect waves-white  btn purple darken-3 more-img"><i class="mdi-action-search"></i>
                <img src="[VARURL]images/icons/refresh.png" />
            </a>
        </div>
        <div id="waiting" class="row center-align mgtops load-more-image" style="display: none">
            <a id="wait" class="bwaves-effect waves-white  btn purple darken-3 load-img">
                <img src="[VARURL]images/icons/refresh-wait.png" />
            </a>
        </div>
        
    </div>
</div>