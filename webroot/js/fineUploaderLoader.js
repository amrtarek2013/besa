$(document).ready(function() {

    $(':file[type=file]').each(function() {
        var uploaderId = makeRandomStr(7);
        var hashId = makeRandomStr(7);

        $(this)
            .after($('<div class="uploadBox"></div>')
                .append(
                    $('<input type="hidden" class="hiddenHash ' + hashId + '" data-id=""/>')
                    .attr('id', hashId)
                    .attr('name', $(this).attr('name')))
                .append($('<div class="uploader" id="' + uploaderId + '" data-hash="' + hashId + '"></div>')))
            .remove();
    });


    $('form input.hiddenHash').each(function() {
        var md5 = /^[a-f0-9]{32}$/;
        var filename = $('div.file-upload span.file-name', $(this).parent().parent());
        if (filename.length) {
            if (filename.size() && md5.test(filename.html())) {
                $(this).val(filename.html());
                filename.html('<i>using last submitted file...</i>');
                $('div.file-upload a').remove();
            }
        }

    });

    function makeRandomStr(len) {
        var chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        var result = "",
            rand;
        for (var i = 0; i < len; i++) {
            rand = Math.floor(Math.random() * chars.length);
            result += chars.charAt(rand);
        }
        return result;
    }

    $('form div.uploadBox div.uploader').each(function() {

        var devid = $(this).attr('id');
        var hashId = $(this).data('hash');
        var hashInput = document.getElementById(hashId);

        var DivElem = document.getElementById(devid);
           var sessionUrl = BASE_URL + 'temp-files/initial?token=' + ajaxToken; 
           var deleteUrl='';
        if (typeof sessionKey != 'undefined') {
            sessionUrl = BASE_URL + 'temp-files/initial?token=' + ajaxToken+'&sessionKey='+sessionKey+'&inputName='+hashInput.name; 
        }
        if (typeof sessionKey != 'undefined') {
            deleteUrl = BASE_URL + 'temp-files/main-delete?token=' + ajaxToken+'&sessionKey='+sessionKey+'&inputName='+hashInput.name; 
        }
        var uploader = new qq.FineUploader({
            debug: false,
            element: DivElem,
            request: {
                customHeaders: {
                    'X-CSRF-Token': _csrfToken
                },
                endpoint: BASE_URL + 'temp-files/upload',
                inputName: hashInput.name
            },
            //  deleteFile: { // to delete the image
            //     customHeaders: {
            //         'X-CSRF-Token': _csrfToken
            //     },
            //     enabled: true, // defaults to false
            //     endpoint: deleteUrl
            // },
            session: {
            endpoint: sessionUrl
            },
            retry: {
                enableAuto: false,
                showButton: true
            },
            multiple: false,
            failedUploadTextDisplay: {
                mode: 'custom',
                responseProperty: 'error'
            },
            callbacks: {
                onComplete: function(id, name, responseJSON, xhr) {
                    $('#' + hashId).val(responseJSON.uuid);                
                },
                onStatusChange: function(id, OldStatus, NewStatus) {

                }

            }

        });
    });


});