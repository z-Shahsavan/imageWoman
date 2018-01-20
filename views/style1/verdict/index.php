<div class="container">
    <div class="row">
        <div class="verdict">
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div class="col-md-4 col-xs-12 selecting">
                        [VARCOMPNAME]
                        <!--                        <label>مسابقه</label>-->
                        <!--                        <select id="competition" name="competition" class="form-control">
                                                    <option value="" disabled="" selected="">انتخاب مسابقه</option>
                                                    <option value="">مسابقه 1</option>
                                                    <option value="">مسابقه 2</option>
                                                </select>-->
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xs-12">
                <div class="row">
                    <div id="freewall" class="free-wall">
                        [VARTHISCOMPIMG]
                        <!-- imgModal -->               
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
                    <div id="imgModal" class="modal fade marginleftright20" role="dialog">
                        <div class="modal-dialog modal-lg ">
                            <!-- Modal content-->
                            <div id="imgrate" class="modal-content">
                                <div class="id none"></div>
                                <div id="galleryaddr" class="none">[VARGALIMAGESFOLDER]</div>
                                <div class="modal-header modal-header2">
                                    <div class="details-verdicting">
                                        <!-- ban image wite class="banning" -->
                                        <a class="issize" href="#"><span class="glyphicon glyphicon-ban-circle vertical-middle"></span>عکس سایز اصلی نیست</a>
                                        <a class="down" href="#"><span class="glyphicon glyphicon-download-alt vertical-middle"></span>دانلود</a>
                                        <a href="#" data-dismiss="modal"><span class="glyphicon glyphicon-remove vertical-middle"></span>بستن</a>
                                    </div>
                                    <h4 class="modal-title">عکس شماره یک</h4>

                                </div>
                                <div class="modal-body modal-body2">
                                    <img id="bigimg" src="" class="img-responsive" />
                                    <div id="divrate" class="rate-modal col-md-12 col-xs-12">
                                        <input id="input-2a" class="rating" data-min="0" data-max="10" data-step="1" data-stars="10" data-glyphicon="true">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>     
        </div>
    </div>
</div>