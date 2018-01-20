<div class="fluid-container bg-whiting">
    <div class="container">    
        <div class="row regdiv mgbtmz forgotpass margintop15">
            <form action="#" id="formreg" method="post" autocomplete="off" class="paddingform col-xs-12 col-md-6 col-md-offset-3 mgtop z-depth-1 reltive minsh mgbtm bgblur bdr">
                <h4 class="flow-text blue-grey darken-3 white-text text-center padding10">فراموش کردن رمز عبور</h4>
                <div class="row mgtop">
                    <div class="input-field col-xs-12 col-md-8 floatright mgtop paddingtop10">
                        <i class="mdi-hardware-phone-iphone prefix"></i>
                        <label class="colora" for="mobile">موبایل</label>
                        <input id="mobile" name="mobile" type="text" class="validate ltr form-control" length="11">
                    </div>
                </div>
                <div class="row mgtoptxt">
                    <div class="col-xs-12 col-md-4">
                        <img src="[VARURL]captcha/captcha.php" id="captcha" alt="Click for new image" title="Click for new image" style="cursor: pointer; width: 100px; height: 43px; margin-top: 2px; font-size: 10px;border: 1px solid #A7A7A7;margin-top: 23px;" onclick="this.src = '[VARURL]captcha/captcha.php?' + Math.random()" />
                    </div>
                    <div class="input-field col-xs-12 col-md-8 paddingtop10">
                        <i class="mdi-communication-dialpad prefix"></i>
                        <label class="colora" for="Captcha1Edit">کد امنیتی</label>
                        <input autocomplete="off" id="Captcha1Edit" type="text" class="validate en form-control" name="captcha_code" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button id="send" class="btn waves-effect waves-light pdbtn btnsending"  type="button" name="action">
                            ارسال کد فعال سازی
                            <i class="mdi-maps-beenhere right"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div id="msgerr4" class="col-xs-12 pink-text text-darken-3" style="display: none;">این یک پیام است</div>
                    <div id="msgsuc4" class="col-xs-12 teal-text text-darken-1" style="display: none;">این یک پیام است</div>
                </div>
            </form>
        </div>
    </div>
</div>