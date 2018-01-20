$(function() {
    $('.row,nav,form').addClass('rtl');



});

var fledahanam;
$(function() {

    // getElementById
    function $id(id) {
        return document.getElementById(id);
    }
    $('#frmupload').on('keydown', 'input', function(e) {
        var key = e.which;
        if (key == 13) {
            $('#send').trigger('click');
            return false;
        }
    })

    $('#send').on('click', function(e) {
        e.preventDefault();
        $('#prgs').css({
            width: '0'
        });
        $('#prgs').removeClass('hideprog');
        var data = new FormData();
        if (!fledahanam) {
            $('#msgerr').html("لطفا عکس را انتخاب کنید.");
            $('#msgerr').show();
            return;
        }
        $.each(fledahanam, function(key, value)
        {
            data.append(key, value);
        });
        checkischach = $("#ischach").is(":checked");
        if (checkischach) {
            data.append('ischach', 'yes');
            data.append('cachtime', $('#cachtime').val());
        } else {
            data.append('ischach', 'no');
        }
        data.append('sitename', $('#sitename').val());
        data.append('siteaddress', $('#siteaddress').val());
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
            url: siteurl + 'adminconfig/saveconfig',
            data: data,
            contentType: 'multipart/form-data',
            type: 'POST',
            dataType: 'json',
            processData: false, // Don't process the files
            contentType: false,
                    success: function(result) {
                        if (result.id > 0) {
                            $("#imagePreview").css("background-image", "");
                            $('#msgsuc').html(result.msg);
                            $('#msgerr').hide();
                            $('#msgsuc').show();
                        } else {
                            $('#msgerr').html(result.msg);
                            $('#msgerr').show();
                            $('#msgsuc').hide();
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
