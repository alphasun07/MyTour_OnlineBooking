$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function commonAlert(message) {
    bootbox.alert({
        message: message,
        backdrop: true,
        buttons: {
            ok: {
                label: 'OK',
                className: 'btn btn-danger'
            }
        }
    });
}

function commonConfirm(message, callback) {
    bootbox.confirm({
        message: message,
        backdrop: true,
        buttons: {
            confirm: {
                label: 'Có',
                className: 'btn btn-danger'
            },
            cancel: {
                label: 'Không',
                className: 'btn btn-default'
            }
        },
        callback: callback
    });
}

function showOverlay(msg) {
    var msg = msg ? msg : '';
    var html = '<div class="is-overlay o-overlay">'
        html += '<button class="btn btn-default" type="button" disabled>'
        html += '<span class="spinner-border text-light" role="status" aria-hidden="true"></span>'
        html += '<span class="o-overlay__msg">'+msg+'</span>'
      html += '</button>'
    html += '</div>'
    $('body').prepend(html);
}

function hideOverlay() {
    $('body').find('.is-overlay').remove();
}

const LoadCommon = {
    init: function() {
        var global = this;
        $("body").on("click", ".js-delete--ajax", function(e) {
            var eThis = this;
            global.delete(eThis)
        });

        $("body").on("mouseover", ".js-delete--ajax", function(e) {
            $(this).css('cursor','pointer');
        });

        $("body").on("click", ".js-delete-custom--ajax", function(e) {
            var eThis = this;
            global.deleteCustom(eThis)
        });
        $("body").on("click", ".js-delete-custom--ajax1", function(e) {
            e.preventDefault();
            var eThis = this;
            global.deletedCustom(eThis)
        });
        $("body").on("click", ".js-delete-custom-status--ajax", function(e) {
            e.preventDefault();
            var eThis = this;
            global.deleteStatusCustom(eThis)
        });

        $("body").on("mouseover", ".js-delete-custom--ajax", function(e) {
            $(this).css('cursor','pointer');
        });

        $("body").on("click", ".js-showHide--plusMinus", function(e) {
            var eThis = this;
            global.clickTreeCategory(eThis)
        });

        $("body").on("click", ".js-copy--form", function(e) {
            var eThis = this;
            global.copy(eThis)
        });
        $("body").on("click", ".js-delete-multi--ajax", function(e) {
            var eThis = this;
            global.deleteMulti(eThis)
        });

    },

    delete: function(eThis){
        commonConfirm('Ban có chắc chắn muốn xóa không?', function (result) {
            if (result) {
                var eRemove = ($(eThis).data('remove')) ? $($(eThis).data('remove')) : $(eThis).parents('dl:first');
                $.ajax({
                    url: $(eThis).data('action'),
                    type: 'post',
                    beforeSend: function() {
                    },
                    success: function (data) {
                        if (data.success === true) {
                            eRemove.remove()
                            commonAlert(data.message);
                        }
                    },
                    error: function (error) {
                        console.log(error)
                    }
                });
            }
        });
    },

    deleteCustom: function(eThis) {
        var customMessage = $(eThis).data('message');
        var confirm = customMessage ? customMessage : 'Ban có chắc chắn muốn xóa không?';
        commonConfirm(confirm, function (result) {
            if(result)  {
                showOverlay()
                $.ajax({
                    url: $(eThis).data('action'),
                    type: 'POST',
                    data: {id: $(eThis).data('id')},
                    success: function (data) {
                        $('.is-spinner').hide()
                        if (data.success === true) {
                            if (data.redirectTo) {
                                console.log(data.redirectTo);
                                window.location.href = data.redirectTo;
                            } else if (data.isReload) {
                                location.reload();
                            } else if (data.message) {
                                commonAlert(data.message);
                            }
                        }
                    },
                    error: function (error) {
                        console.log(error)
                    }
                });
            }
        });
    },

    deletedCustom: function(eThis) {
        var customMessage = $(eThis).data('message');
        var confirm = customMessage ? customMessage : 'Ban có chắc chắn muốn xóa không?';
        commonConfirm(confirm, function (result) {
            if(result)  {
                ids = [$(eThis).data('id')];
                showOverlay()
                $.ajax({
                    url: $(eThis).data('action'),
                    type: 'POST',
                    data: 'filesArr=' + ids,
                    success: function (data) {
                        $('.is-spinner').hide();
                        if (data.success === true) {
                            if (data.redirectTo) {
                                console.log(data.redirectTo);
                                window.location.href = data.redirectTo;
                            } else if (data.isReload) {
                                location.reload();
                            } else if (data.message) {
                                commonAlert(data.message);
                            }
                        }
                    },
                    error: function (error) {
                        console.log(error)
                    }
                });
            }
        });
    },

    deleteStatusCustom: function(eThis) {
        var customMessage = $(eThis).data('message');
        var confirm = customMessage ? customMessage : 'Ban có chắc chắn muốn xóa không?';
        commonConfirm(confirm, function (result) {
            if(result)  {
                console.log($(eThis).data('id'));
                ids = [$(eThis).data('id')];
                showOverlay()
                $.ajax({
                    url: $(eThis).data('action'),
                    type: 'POST',
                    data: 'Arr=' + ids,
                    success: function (data) {
                        $('.is-spinner').hide();
                        console.log(data.success)
                        if (data.success === true) {
                            if (data.redirectTo) {
                                console.log(data.redirectTo);
                                window.location.href = data.redirectTo;
                            } else if (data.isReload) {
                                location.reload();
                            } else if (data.message) {
                                commonAlert(data.message);
                            }
                        }
                        console.log(data.errorMessage);
                    },
                    error: function (error) {
                        console.log(error)
                    }
                });
            }
        });
    },

    deleteMulti: function(eThis){
        var arr = $('input[name="ids[]"]:checked').map(function () {
            return this.value;
        }).get();
        if (arr.length == 0) {
            commonAlert('Please select a page');
            return false;
        }
        commonConfirm('Ban có chắc chắn muốn xóa không?', function (result) {
            if (result) {
                $.ajax({
                    url: $(eThis).data('action'),
                    type: 'post',
                    data: {
                        ids: arr,
                        delete: 'delete'
                    },
                    beforeSend: function() {
                    },
                    success: function (data) {
                        if (data.redirectTo) {
                            window.location.href = data.redirectTo;
                        } else if (data.message) {
                            commonAlert(data.message);
                        }
                    },
                    error: function (error) {
                        console.log(error)
                    }
                });
            }
        });
    },

    clickTreeCategory: function(eThis){
        if($(eThis).hasClass('collapsed')) {
            $(eThis).find('.fa-plus').hide()
            $(eThis).find('.fa-minus').css('display', 'block')
        } else {
            $(eThis).find('.fa-plus').css('display', 'block')
            $(eThis).find('.fa-minus').hide()
        }
    }

};

$(document).ready(function($) {
    const GetCommonClass = Object.create(LoadCommon);
    GetCommonClass.init();

    $('.js-reload').on('click', function() {
        location.reload();
    })

    // Format number
    function formatMoney(value){
        if (value == '') {
            return;
        }
        var value2 = value.replaceAll(',','');
        if (false == (/^[0-9]+$/.test(value2))) {
            return value;
        }
        var value = parseInt(value2,10);
        var format = new Intl.NumberFormat('ja-JP', { style: 'currency', currency: 'JPY' }).format(value)
        return format.replace(new RegExp('\\￥', 'g'), '');
    }

    $(".js-money").each(function( index ) {
        var value = $(this).val().trim();
        $(this).val(formatMoney(value));
    });

    $(".js-money").on('keyup', function(){
        var value = $(this).val().trim();
        $(this).val(formatMoney(value));
    });

    $('.js-length__input').bind('keyup',function() {
        let fieldName = $(this).data('field');
        $('.is-length__input--' + fieldName).html('<strong>'+$(this).val().length+' ký tự</strong>')
    });

    function lengthStringInput() {
        $('.js-length__input').each(function( index ) {
            let fieldName = $(this).data('field');
            $('.is-length__input--' + fieldName).html('<strong>'+$(this).val().length+' ký tự</strong>')
        });
    }
    setTimeout(lengthStringInput, 200);

});
