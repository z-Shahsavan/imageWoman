<div class="container-fluid bg-whiting">
    <div class="upload-image row">
        <div class="regdiv mgbtmz" style="background-image:url('[VARURL]/publicuser/style1/images/bg-reg.jpg') ">
            <div class="container">
                <form id="frmupload" action="upload.php" enctype="multipart/form-data"  method="post" autocomplete="off" class="form-s col-xs-12 col-md-5 col-md-offset-3 mgtop z-depth-1 reltive minsh mgbtm bgblur bdr marginbottom40 hide-one-tag">
                    <input type="hidden" id="MAX_FILE_SIZE" name="MAX_FILE_SIZE" value="300000" />
                    <h4 class="flow-text blue-grey darken-3 hdreg white-text" style="padding: 10px;">آپلود تصویر</h4>
                    <div class="row margintop60">
                        <div class="input-field col-xs-12 right">
                            <label for="name">عنوان تصویر</label>
                            <input id="name" name="name" type="text" class="validate form-control" length="50">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col-xs-12 margintop15">
                            <label> مسابقه</label>
                            <select id="competition" name="competition" class="col-xs-11 form-control">
                                <option value="" disabled selected>انتخاب مسابقه  </option>
                                [VARCOMPS]
                            </select>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div id="divcomp" class="input-field col-xs-12 none margintop15">
                                <i class="mdi-image-blur-on prefix"></i>
                                <select id="competition" name="competition" class="col-xs-11 form-control">
                                    <option value="" disabled selected>انتخاب مسابقه  </option>
                                    [VARCOMPS]
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div id="divcomp" class="input-field col-xs-12 none margintop15">
                                <select id="competition" name="competition" class="col-xs-11 form-control">
                                    <option value="" disabled selected>انتخاب مسابقه</option>
                                    [VARCOMPS]
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col-xs-12 right margintop15">
                            <label for="location">مکان</label>
                            <select class="form-control rtl col-xs-11" id="slctghaza" name="droptbl" >
                                <option value="" disabled selected>انتخاب استان</option>
                                [VARCITY]
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col-xs-12 right margintop15">
                            <label for="Comment">توضیحات</label>
                            <textarea id="Comment" name="Comment" class="form-control validate" length="120"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col-xs-12 col-md-6 floatright margintop15">
                            <label id="lbldate" for="date">تاریخ</label>
                            <input onchange="makeactive()" id="date_input_1" type="text" class="form-control-inp form-control" name="tarikh" />
                        </div>
                        <div class="date-control2 col-xs-1 margintop48">
                            <img id="date_btn_1" src="[VARURL]/images/icons/cal.png" />
                        </div>
                    </div>
                    <div id="divtag" class="row">
                        <div class="input-field col-xs-12 right margintop15">تگ ها</div>
                        <div id="divtagha" class="input-field col-xs-12 right">
                            <input type="text" value="" data-role="tagsinput" placeholder="تگ مورد نظر را اضافه کنید" style="padding-top: 5px;" />
<!--                                <select id="select3" name="select3">

                            </select> -->
                        </div>
                    </div>
                    <div class="row reltive margintop15">
                        <div class="input-field col-xs-12 center-align">
                            <div id="imagePreview"></div>
                        </div>
                        <div class="dropdiv" id="filedrag" name="fileselect">انداختن تصویر در اینجا</div>
                        <div class="file-field input-field col-xs-12 center-align">
                            <input class="file-path validate" type="text"/>
                            <div class="btn purple darken-3 padding0 btn-darken">
                                <span class="">انتخاب فایل</span>
                                <input type="file" id="fileselect" name="fileselect" class="file-fileselect" />
                            </div>
                        </div>
                    </div>
                    <div class="row reltive margintopbottom20">
                        <div class="col-xs-12">
                            <div id="progs" class="progress none">
                                <div id="prgs" class="progress-bar progress-bar-striped active floatright" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width:0%">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="submitbutton" class="col-xs-12 marginbottom20">
                        <button class="btn waves-effect waves-light pdbtn btn-upload" type="submit"><i class="glyphicon glyphicon-upload right vertical-i"></i>آپلود تصویر</button>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 marginbottom20">
                            <button  id="send" class="btn waves-effect waves-light pdbtn btn-upload" type="button"><i class="glyphicon glyphicon-upload right vertical-i"></i>آپلود تصویر</button>
                        </div>
                    </div>
                    <div class="row">
                        <div id="msgerrup" class="col-xs-12 pink-text text-darken-3" style="display: none">این یک پیام است</div>
                        <div id="msgsucup" class="col-xs-12 teal-text text-darken-1" style="display: none">این یک پیام است</div>
                    </div>
                </form>
            </div>
        </div>  
    </div>
</div>