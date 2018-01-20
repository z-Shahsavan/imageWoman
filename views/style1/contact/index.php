<div class="fluid-container bg-whiting">
    <div class="container contact-pro">
        <div class="row grey lighten-3 mgbtmz">
            <div class="col-xs-12 arrow_box arrow_boxtp"></div>
            <div class="col-xs-12 mgtop reltive center-align">
                <i class="mdi-action-account-circle purple-text icosec lgico"></i>
                <div class="container right-align" style="direction: rtl;">
                    <div class="fluid-container">
                        <div class="fluid-container">
                            <div class="subject-competitions text-center" style="padding: 20px 0px 0px 0px;">
                                <img class="img-head" src="[VARURL]publicuser/style1/images/subject-ribbon.png" />
                                <div class="subject-match-head">
                                    <span>تماس با ما</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="divider"></div>
                    <div class="row mgtop">
                        <form class=" col-xs-12 col-md-6" id="frmupload" action="#" autocomplete="off">
                            <div class="row">
                                <div class="input-field col-xs-12 pull-right">
                                    <i class="mdi-action-account-circle prefix"></i>
                                    <label for="name">نام و نام خانوادگی</label>
                                    <input id="name" name="name" type="text" class="form-control validate" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-xs-12 right">
                                    <i class="mdi-communication-phone prefix"></i>
                                    <label for="tel">شماره تماس</label>
                                    <input id="tel" name="tel" type="tel" class="form-control validate" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-xs-12 right">
                                    <i class="mdi-communication-phone prefix"></i>
                                    <label for="mobile">شماره موبایل</label>
                                    <input id="mobile" name="mobile" type="tel" class="form-control validate" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-xs-12 right">
                                    <i class="mdi-communication-email prefix"></i>
                                    <label for="email">ایمیل</label>
                                    <input id="email" type="email" name="email" class="form-control validate left-align ltr" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-xs-12 right">
                                    <i class="mdi-editor-mode-edit prefix"></i>
                                    <label for="message">متن پیام شما</label>
                                    <textarea id="message" name="message" class="form-control materialize-textarea"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field">
                                    <div class="col-xs-12 col-md-4" style="margin-top: 22px;">
                                        <img src="[VARURL]captcha/captcha.php" id="captcha" alt="Click for new image" title="Click for new image" style="cursor: pointer; width: 100px; height: 45px; float: left; margin-top: 2px; font-size: 10px" onclick="this.src = '[VARURL]captcha/captcha.php?' + Math.random()" />
                                    </div>
                                    <div class="col-xs-12 col-md-8">
                                        <i class="mdi-action-autorenew prefix"></i>
                                        <label for="Captcha1Edit">کد امنیتی</label>
                                        <input id="Captcha1Edit" type="text" class="form-control validate left-align ltr" name="captcha_code" />
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col-xs-12" style="margin: 20px 0px;">
                                    <button class="form-control btn-primary btn" id="send" type="button" name="action">
                                        ارسال پیام
                                        <i class="mdi-content-send right"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="row">
                                <div id="msgerr2" class="col-xs-12 pink-text text-darken-3" style="display: none">این یک پیام است</div>
                                <div id="msgsuc2" class="col-xs-12 teal-text text-darken-1" style="display: none">این یک پیام است</div>
                            </div>
                            <!--                        <div class="row">
                                                        <div id="msgsuc" class="input-field col s12 right msg" style="display: none">
                                                            این یک پیام است
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div id="msgerr" class="input-field col s12 right msgerr" style="display: none">
                                                            این یک پیام است
                                                        </div>
                                                    </div>-->
                        </form>
                        [VARADDRESS]
                        <hr />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>