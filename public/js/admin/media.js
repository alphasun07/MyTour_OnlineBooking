$(document).ready(function($) {
    $('.js-media').click(function() {
        reloadFile()
        $(".is-image__url").val('');
        $("#is-image__create").text('');
        $("#is-image__size").text('');
        $("#is-image__name").text('');
    })

    Dropzone.autoDiscover = false;
    $('#is-image__url').dropzone({
        url:  dropzoneOptions.urlUploadImage,
        paramName: 'image_url',
        maxFilesSize: 10,
        acceptedFiles: '.jpeg,.jpg,.png',
        addRemoveLinks: false,
        dictFileTooBig: 'ファイルのサイズは10MBまでです。',
        dictInvalidFileType: 'jpgまたはpng形式のファイルでアップロードしてください。',
        timeout: 60000,
        thumbnailWidth: 0,
        thumbnailHeight: 0,
        params: {
            folder: dropzoneOptions.imageFolder
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        init: function () {
            this.on('addedfile', function (file) {
                $('#is-image__url .dz-default').removeClass('flex-row d-flex');
                $('.dz-preview').remove();
                $('.o_hide--screen').show();
            });
            this.on('complete', function(file) {
                if(file.status === 'success') {
                    // this.removeFile(file);
                }
            });
            this.on('error', function(file, mess) {
                this.removeFile(file);

                $(this.previewsContainer).addClass('error').parent().find('.error-message ul').html($('<li/>').addClass('parsley-required').text(mess))
            });
            this.on('success', function(file, response) {
                console.log('yes');
                if(response.success){
                    console.log('yesyes');
                    $('#is-image__url').parent().find('.error-message ul').empty()
                    $('#is-image__url .dz-default').addClass('flex-row d-flex');
                    $('.o_hide--screen').hide()
                    reloadFile()
                }
            });
        }
    });


    //Remove image
    function removeImageAjax(arrFileName, folder = '') {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: dropzoneOptions.urlRemoveImage,
            type:'POST',
            dataType: 'json',
            data: {
                arrFileName: arrFileName,
                folder: folder,
            },
            cache : false,
            success: (response) => {
                if (response.success) {
                    reloadFile()
                    $(".is-insertImage").attr("disabled")
                    $(".is-image__url").val('');
                    $("#is-image__create").text('');
                    $("#is-image__size").text('');
                    $("#is-image__name").text('');
                }
            },
            error: function(response){
            }
        });
    }

    $('.js-image__delete').click(function() {
        var arrayImageDelete = []
        $('input.is-checkboxImage:checkbox:checked').each(function () {
            arrayImageDelete.push((jQuery("#is-image-" + $(this).val())).attr("is-image__name"))
        });

        if(arrayImageDelete.length == 0) {
            commonAlert('画像を選択してください。');
        } else {
            commonConfirm('選択した画像を削除してもよろしいですか。', function (result) {
                if(result){
                    removeImageAjax(arrayImageDelete, folder = dropzoneOptions.imageFolder)
                }
            });
        }
    });

    function reloadFile() {
        var numOfCols = 5;
        var rowCount = 0;
        var bootstrapColWidth = 12 / numOfCols;
        var publicPath = dropzoneOptions.publicPath;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: dropzoneOptions.urlReloadFile,
            type: 'POST',
            data: {
                path_image: dropzoneOptions.imageFolder
            },
            success: function(data) {
                console.log(data);
                if (data.status) {
                    var html = ''
                    data.image_info.forEach((image, index) => {
                        if (rowCount % numOfCols == 0) {
                            html += '<div class="d-flex flex-row scroll">'
                        }
                        rowCount++;
                        html += '<div  class="p-modal__checkbox custom-control custom-checkbox mt-3 w-20">';
                        html += '<input onClick="checkboxImage('+ index +')" value="'+ index +'" type="checkbox" class="is-checkboxImage custom-control-input btn-dark" relative_file="'+ image.relative_file +'" is-image__size="' + image.size +'" is-image__name="' + image.image_name +'" id="is-image-' + index + '" name="image[' + index + ']">';
                        html += '<label class="p-modal__checkbox--color" for="is-image-' + index + '"><img src="'+ publicPath + '\\' + image.relative_file + '" alt="画像" class="w-100 p-modal__img--height"></label>';
                        html += '</div>';
                        if (rowCount % numOfCols == 0) {
                            html += '</div>'
                        }
                    })

                    $('#is-listImage__preview').html(html);
                    button = '<div class="o-iconCenter mt-5">'
                    button += '<button type="button" data-dismiss="modal" class="btn btn-dark btn-sm rounded font-weight-bold is-insertImage" disabled onClick="insertImage()">画像を挿入</button>'
                    button += '</div>'
                    $('#is-listImage__preview').append(button);
                    $('#btn_insert_image').html(button);
                } else {
                    $('#is-listImage__preview').html('');
                    button = '<div class="o-iconCenter mt-5">'
                    button += '<button type="button" data-dismiss="modal" class="btn btn-dark btn-sm rounded font-weight-bold is-insertImage" disabled onClick="insertImage()">画像を挿入</button>'
                    button += '</div>'
                    $('#is-listImage__preview').append(button);
                    $('#btn_insert_image').html(button);
                }
            },
            error: function() {
                console.log(data);
            }
        });
    }

    $("#editor-one").change(function() {
        $("#text").val($("#editor-one").text())
    });

})

function checkboxImage(index) {
    $(".is-insertImage").removeAttr("disabled")
    jQuery('.is-checkboxImage').prop('checked', false)
    jQuery('#is-image-' + index).prop('checked', true)
    if(jQuery("#is-image-" + index).is(':checked')) {
        jQuery(".is-image__url").val(jQuery("#is-image-" + index).attr("relative_file"))
        var date = jQuery("#is-image-" + index).attr("is-image__name").split('_')[0]
        var year = date.slice(0, 4)
        var month = date.slice(4, 6)
        var day = date.slice(6, 8)
        jQuery("#is-image__create").text(year + '/' + month + '/' + day)
        jQuery("#is-image__size").text(jQuery("#is-image-" + index).attr("is-image__size") + 'KB')
        jQuery("#is-image__name").text(jQuery("#is-image-" + index).attr("is-image__name"))
    }
}

function insertImage() {
    var publicPath = dropzoneOptions.publicPath;
    if (dropzoneOptions.imageFolder == 'images/image_new' || dropzoneOptions.imageFolder == 'images/image_content_management' || dropzoneOptions.imageFolder == 'images/image_free_pages') {
        var contentDescript = ''
        $('input.is-checkboxImage:checkbox:checked').each(function () {
            contentDescript += '<span class="is-rowImage__insert p-insert-image"><input type="hidden" value="'+ (jQuery("#is-image-" + $(this).val())).attr("is-image__name") +'" name="image_url_insert"><span style="width:120px"><img src="'+ publicPath + '\\' + (jQuery("#is-image-" + $(this).val())).attr("relative_file") + '" alt="'+ $(".is-altImage").val() +'" class="p-image-inserted p-modal__img--height"></span><span class="remove ml-2" onClick="removeInsertImage()" style="cursor:pointer"> <i class="fa fa-times p-icon-remove" style="font-size:30px; color:red"></i></span></span>'
        });
        jQuery("#is-add_media").html(contentDescript)
    } else {
        var contentDescript = jQuery("textarea[name=message]").val()
        if (contentDescript.indexOf('class="p-image-inserted w-100 p-modal__img--height">') == -1) {
            $('input.is-checkboxImage:checkbox:checked').each(function () {
                contentDescript += '<img src="'+ publicPath + '\\' + (jQuery("#is-image-" + $(this).val())).attr("relative_file") + '" alt="'+ $(".is-altImage").val() +'" class="p-image-inserted w-100 p-modal__img--height">'
            });
            jQuery("textarea[name=message]").val(contentDescript)
        }
    }
    $("#js-media").find(".close").click();
}