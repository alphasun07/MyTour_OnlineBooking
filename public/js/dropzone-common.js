$(function() {
    var defaultOption = {
        url: dropzoneOptions.urlUploadImage,
        acceptedFiles: '.jpeg,.jpg,.png',
        maxFilesSize: 10,
        addRemoveLinks: !0,
        dictFileTooBig: 'Kích thước tệp lên đến 10MB.',
        dictInvalidFileType: 'Vui lòng tải lên dưới dạng tệp định dạng jpg hoặc png.',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    };
    function addedFileFunction(dzFile) {
        $(this.previewsContainer).removeClass('error').parent().find('.error-message ul').empty(),
        $(dzFile.previewElement).find('.dz-remove').html('<span class="btn btn-danger btn-sm mt-1"><i class="fa fa-trash"></i> xóa bỏ </span>')
    }
    function removeFileFunction(paramIdDz) {
        $('#' + paramIdDz).parent().find('.error-message ul').empty()
        $(this.previewsContainer).removeClass('error').parent().find('.error-message ul').empty()
    }
    function errorFileFunction(dzFile, errorMess, n) {
        $(dzFile.previewElement).remove(),
        $(this.previewsContainer).addClass('error').parent().find('.error-message ul').html($('<li/>').addClass('parsley-required').text(errorMess))
    }

    function removeImage(file, idInput, idImageDz) {
        // remove main_image
        if (file.status == 'success') {
            var file_name = $('input[name='+ idInput +']').val();
            removeImageAjax(file_name, idInput);
        }
        if (!file.status && file.name) {
            $('input[name='+ idInput +']').val('')
            idImageDz[0].dropzone.options.maxFiles = idImageDz[0].dropzone.options.maxFiles + 1;
        }
    }

    function removeImageAjax(fileName, idInput, folder = dropzoneOptions.imageFolder) {
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: dropzoneOptions.urlRemoveImage,
            type:'POST',
            dataType: 'json',
            data: {
                image: fileName,
                folder: folder,
            },
            cache : false,
            success: (response) => {
                if (response.success) {
                    $('#' + idInput).val('');
                }
            },
            error: function(response){
            }
        });
    }

    window.showImageOnServer = function showImageOnServer(fileName, ImageDz, idInput, folder = dropzoneOptions.imageFolder){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: dropzoneOptions.urlGetImage,
            type: 'POST',
            dataType: 'json',
            data: {
                image: fileName,
                folder: folder,
            },
            cache : false,
            success: (response) => {
                if (response.success) {
                    var mockImage = {
                        name: response.imageInfo.name,
                        idInput: idInput,
                        accepted: true,
                        size: response.imageInfo.size
                    };
                    ImageDz.emit('addedfile', mockImage);
                    ImageDz.emit("thumbnail", mockImage, response.imageInfo.path);
                    ImageDz.emit("complete", mockImage);
                }
            }
        });
    }

    window.runDropzone = function runDropzone(dropzoneOptions) {
        if(dropzoneOptions) {
            $('.dropzone').each(function(index){
                var paramIdDz = $(this).attr('id');
                var dropOption = {
                    url: dropzoneOptions.urlUploadImage,
                    maxFiles: dropzoneOptions.maxFiles[index],
                    paramName: paramIdDz,
                    maxFilesSize: defaultOption.maxFilesSize,
                    acceptedFiles: defaultOption.acceptedFiles,
                    addRemoveLinks: defaultOption.addRemoveLinks,
                    dictFileTooBig: defaultOption.dictFileTooBig,
                    dictInvalidFileType: defaultOption.dictInvalidFileType,
                    dictMaxFilesExceeded: dropzoneOptions.dictMaxFilesExceeded[index],
                    headers: defaultOption.headers,
                    init: function () {
                        this.on('addedfile', function (file) {
                            addedFileFunction(file)
                        });
                        this.on('complete', function(file) {
                            addedFileFunction(file)
                        });
                        this.on('removedfile', function(file) {
                            removeFileFunction(paramIdDz)
                            removeImage(file, dropzoneOptions.nameInput[index], $('#' + paramIdDz + ''))
                        });
                        this.on('error', errorFileFunction);
                        this.on('success', function(file, response) {
                            if (response.success) { // upload success
                                $('form #' + dropzoneOptions.nameInput[index] + '').val(response.file_name);
                                removeFileFunction(paramIdDz)
                            }
                        });
                    }
                }
                $(this).dropzone(dropOption);
            });
        }
        $.each(dropzoneOptions.nameInput, function(index, nameInput) {
            if(dropzoneOptions.required[index]) {
                // window.Parsley.on('form:validate', function() {
                //     !$('#'+ nameInput +'').val() && 0 == $('#'+ dropzoneOptions.idDz[index] +'')[0].dropzone.getAcceptedFiles().length && ($('#' + dropzoneOptions.idDz[index] + '').addClass('error'),
                //     $('#error-' + dropzoneOptions.idDz[index] + ' ul').text(dropzoneOptions.required[index]),
                //     location.hash = '#' + dropzoneOptions.idDz[index] + '')
                // })
            }
        });
    }

    window.showImageObject = function checkValidateDz(dropzoneOptions, imageNameObj) {
        if(imageNameObj) {
            $.each(imageNameObj, function(index, imageName) {
                if(imageName) {
                    showImageOnServer(imageName, $('#'+ dropzoneOptions.idDz[index] +'')[0].dropzone, dropzoneOptions.nameInput[index])
                    $('#' + dropzoneOptions.idDz[index] + '')[0].dropzone.options.maxFiles = $('#' + dropzoneOptions.idDz[index] + '')[0].dropzone.options.maxFiles - 1;
                }
            });
        }
    }

    window.checkValidateDz = function checkValidateDz(dropzoneOptions) {
        var submitForm = true;
        if(dropzoneOptions.nameInput){
            $.each(dropzoneOptions.nameInput, function(index, input) {
                if(dropzoneOptions.required[index] && !$('#' + input + '').val()) {
                    submitForm = false;
                    ($('#' + dropzoneOptions.idDz[index] + '').addClass('error'),
                    $('#error-' + dropzoneOptions.idDz[index] + ' ul').text(dropzoneOptions.required[index]),
                    location.hash = '#' + dropzoneOptions.idDz[index] + '')
                }
            });
        }
        return submitForm;
    }

});
