var tag;
var fledahanam;
$(function() {

    // getElementById
    function $id(id) {
        return document.getElementById(id);
    }
//    $('#frmupload').on('keydown', 'input', function(e) {
//        var key = e.which;
//        if (key == 13) {
//            $('#send').trigger('click');
//            return false;
//        }
//    })

    $('#send').on('click', function(e) {
        if ($('#send').hasClass('hidden')) {
            return;
        }
        $('#send').addClass('hidden');
        $('#progs').removeClass('none');
        $('#msgerrup').hide();
        $('#msgsucup').html('درحال آپلود...');
        $('#msgsucup').show();
        var hashtag = '';
        var onetag = '';
        $('.bootstrap-tagsinput').find('.tag').each(function() {
            onetag = $(this).text();
            tag = onetag;
            if (onetag.substr(0, 1) == '#') {
                hashtag += ',' + onetag.substr(1);
            } else {
                hashtag += ',' + onetag;
            }
        })

        hashtag = hashtag.substr(1);
        $.ajax({
            url: siteurl + 'upload/uppic',
            type: "POST",
            dataType: 'json',
            success: function(result) {
                if (result.id == 2) {
                    var agree = confirm('عکس شما باید در سایز اصلی باشد در غیر این صورت به مرحله داوری راه نخواهد یافت! ');
                    if (agree) {
                        e.preventDefault();
                        $('#prgs').css({
                            width: '0'
                        });
                        $('#prgs').removeClass('hideprog');
                        if (!fledahanam) {
                            $('#send').removeClass('hidden');
                            $('#msgerrup').html('لطفا عکس مورد نظر را انتخاب نمایید');
                            $('#msgerrup').show();
                            $('#msgsucup').hide();
                            return;
                        }
                        var data = new FormData();
                        $.each(fledahanam, function(key, value)
                        {
                            data.append(key, value);
                        });
                        if (!parseInt($('#competition').val())) {
                            $('#send').removeClass('hidden');
                            $('#msgerrup').html('لطفا مسابقه مورد نظر را انتخاب نمایید');
                            $('#msgerrup').show();
                            $('#msgsucup').hide();
                            return;
                        }
                        var location;
                        if (parseInt($('#slctghaza').val()) < 1) {
                            location = 32;
                        } else {
                            location = parseInt($('#slctghaza').val());
                        }
                        data.append('competition', $('#competition').val());
                        data.append('hashtag', hashtag);
                        data.append('name', $('#name').val());
                        data.append('comment', $('#Comment').val());
                        data.append('location', location);
                        data.append('date', $('#date_input_1').val());
                        $.ajax({
                            xhr: function() {
                                var xhr = new window.XMLHttpRequest();
                                xhr.upload.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {
                                        var percentComplete = evt.loaded / evt.total;
                                        console.log(percentComplete);
                                        $('#prgs').css({
                                            width: percentComplete * 100 + '%'
                                        });
                                        $('#prgs').html(Math.trunc(percentComplete * 100) + '%');
                                        if (percentComplete === 1) {
                                            $('#prgs').html('');
                                            $('#prgs').addClass('hideprog');
                                        }
                                    }
                                }, false);
                                xhr.addEventListener("progress", function(evt) {
                                    if (evt.lengthComputable) {
                                        var percentComplete = evt.loaded / evt.total;
                                        console.log(percentComplete);
                                        $('#prgs').css({
                                            width: percentComplete * 100 + '%'
                                        });
                                        $('#prgs').html(Math.trunc(percentComplete * 100) + '%');
                                    }
                                }, false);
                                return xhr;
                            },
                            url: siteurl + 'upload/uploadpic',
                            data: data,
                            contentType: 'multipart/form-data',
                            type: 'POST',
                            dataType: 'json',
                            processData: false, // Don't process the files
                            contentType: false,
                                    success: function(result) {
//                                        alert('show send btn1')
                                        $('#send').removeClass('hidden');
                                        if (result.id > 0) {
                                            $('#msgsucup').html(result.msg);
                                            $('#frmupload')[0].reset();
                                            $('#maininput').val('');
                                            $("#imagePreview").css("background-image", "");
                                            $("#filedrag").html('انداختن تصویر در اینجا');
                                            $('#msgerrup').hide();
                                            $('.bootstrap-tagsinput .tag').each(function() {
                                                if ($(this).hasClass('tag')) {
                                                    $(this).remove();
                                                }
                                            })
                                            setTimeout(function() {
                                                $('#progs').addClass('none');
                                            }, 2000);
//                                            $('#msgsucup').show();
                                        } else {
                                            $('#progs').addClass('none');
                                            //alert($('select-wrapper').html())
                                            $('#msgerrup').html(result.msg);
                                            $('#msgerrup').show();
                                            $('#msgsucup').hide();
                                        }
                                    }});
                    } else {
                        return false;
                    }
                } else if (result.id == 3) {
                    e.preventDefault();
                    $('#prgs').css({
                        width: '0'
                    });
                    $('#prgs').removeClass('hideprog');
                    if (!fledahanam) {
                        $('#send').removeClass('hidden');
                        $('#msgerrup').html('لطفا عکس مورد نظر را انتخاب نمایید');
                        $('#msgerrup').show();
                        $('#msgsucup').hide();
                        return;
                    }
                    var data = new FormData();
                    $.each(fledahanam, function(key, value)
                    {
                        data.append(key, value);
                    });
                    if (!parseInt($('#competition').val())) {
                        $('#send').removeClass('hidden');
                        $('#msgerrup').html('لطفا مسابقه مورد نظر را انتخاب نمایید');
                        $('#msgerrup').show();
                        $('#msgsucup').hide();
                        return;
                    }
                    var location;
                    if (parseInt($('#slctghaza').val()) < 1) {
                        location = 32;
                    } else {
                        location = parseInt($('#slctghaza').val());
                    }
                    data.append('competition', $('#competition').val());
                    data.append('hashtag', hashtag);
                    data.append('name', $('#name').val());
                    data.append('comment', $('#Comment').val());
                    data.append('location', $('#slctghaza :selected').val());
                    data.append('date', $('#date_input_1').val());
                    $.ajax({
                        xhr: function() {
                            var xhr = new window.XMLHttpRequest();
                            xhr.upload.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    console.log(percentComplete);
                                    $('#prgs').css({
                                        width: percentComplete * 100 + '%'
                                    });
                                    $('#prgs').html(Math.trunc(percentComplete * 100) + '%');
                                    if (percentComplete === 1) {
                                        $('#prgs').html('');
                                        $('#prgs').addClass('hideprog');
                                    }
                                }
                            }, false);
                            xhr.addEventListener("progress", function(evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = evt.loaded / evt.total;
                                    console.log(percentComplete);
                                    $('#prgs').css({
                                        width: percentComplete * 100 + '%'
                                    });
                                    $('#prgs').html(Math.trunc(percentComplete * 100) + '%');
                                }
                            }, false);
                            return xhr;
                        },
                        url: siteurl + 'upload/uploadpic',
                        data: data,
                        contentType: 'multipart/form-data',
                        type: 'POST',
                        dataType: 'json',
                        processData: false, // Don't process the files
                        contentType: false,
                                success: function(result) {
                                    $('#send').removeClass('hidden');
                                    if (result.id > 0) {
                                        $('#msgsucup').html(result.msg);
                                        $('#frmupload')[0].reset();
                                        $('#maininput').val('');
                                        $('.bootstrap-tagsinput .tag').each(function() {
                                            if ($(this).hasClass('tag')) {
                                                $(this).remove();
                                            }
                                        })

                                        $("#imagePreview").css("background-image", "");
                                        $("#filedrag").html('انداختن تصویر در اینجا');
                                        $('#msgerrup').hide();
                                        setTimeout(function() {
                                            $('#progs').addClass('none');
                                        }, 2000);
//                                        $('#msgsucup').show();
                                    } else {
                                        $('#progs').addClass('none');
                                        $('#msgerrup').html(result.msg);
                                        $('#msgerrup').show();
                                        $('#msgsucup').hide();
                                    }
                                }});


                }
            }});
    });



    // output information
    function Output(msg) {
        var m = $id("messages");
        m.innerHTML = msg;
    }


    // file drag hover
    function FileDragHover(e) {
        e.stopPropagation();
        e.preventDefault();
        e.target.className = (e.type == "dragover" ? "hover" : "");
    }


    // file selection
    function FileSelectHandler(e) {

        // cancel event and hover styling
        FileDragHover(e);
        // fetch FileList object
        var files = e.target.files || e.dataTransfer.files;
        fledahanam = files;
        if (!files.length || !window.FileReader)
            return; // no file selected, or no FileReader support
        if (/^image/.test(files[0].type)) { // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file

            reader.onloadend = function() { // set image data as background of div
                $("#imagePreview").css("background-image", "url(" + this.result + ")");
                $("#filedrag").html('');
            }
        }


        // process all File objects
        for (var i = 0, f; f = files[i]; i++) {
            ParseFile(f);
        }

    }


    // output file information
    function ParseFile(file) {

        Output(
                "<p>File information: <strong>" + file.name +
                "</strong> type: <strong>" + file.type +
                "</strong> size: <strong>" + file.size +
                "</strong> bytes</p>"
                );

    }


    // initialize
    function Init() {

        var fileselect = $id("fileselect"),
                filedrag = $id("filedrag"),
                submitbutton = $id("submitbutton");

        // file select
        fileselect.addEventListener("change", FileSelectHandler, false);

        // is XHR2 available?
        var xhr = new XMLHttpRequest();
        if (xhr.upload) {

            // file drop
            filedrag.addEventListener("dragover", FileDragHover, false);
            filedrag.addEventListener("dragleave", FileDragHover, false);
            filedrag.addEventListener("drop", FileSelectHandler, false);
            filedrag.style.display = "block";

            // remove submit button
            submitbutton.style.display = "none";
        }

    }

    // call initialization file
    if (window.File && window.FileList && window.FileReader) {
        Init();
    }


})();
