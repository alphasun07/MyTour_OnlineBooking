$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

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

        $("body").on("click", ".js-showHide--plusMinus", function(e) {
            var eThis = this;
            global.clickTreeCategory(eThis)
        });

        $("body").on("click", ".js-copy--form", function(e) {
            var eThis = this;
            global.copy(eThis)
        });

    },

    delete: function(eThis){
        var confirm = $(eThis).data('confirm') == undefined || $(eThis).data('confirm') == '' ? '削除してもよろしいですか。' : $(eThis).data('confirm');
        commonConfirm(confirm, function (result) {
            if(result)  {
                showOverlay()
                $.ajax({
                    url: $(eThis).data('action'),
                    type: 'POST',
                    data: {id: $(eThis).data('id')},
                    success: function (data) {
                        console.log('data', data)
                        if (data.status === true && data.redirectTo) {
                            console.log(data.redirectTo);
                            window.location.href = data.redirectTo;
                        }
                    },
                    error: function (error) {
                        console.log(error)
                    }
                });
            }
        });
    },

    copy: function(eThis){
        var frm = $(eThis).parents('form:first')
        var divParents = $(eThis).parents('li:first')
        var confirm = $(eThis).data('confirm');
        commonConfirm(confirm, function (result) {
            if(result){
                var formData = new FormData(frm[0]);
                $(eThis).prop('disabled', true)
                $.ajax({
                    url: $(eThis).data('action'),
                    type: 'post',
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function () {
                    },
                    success: function (data) {
                        $(eThis).prop('disabled', false)
                        console.log('data', data)
                        if (data.success === true) {
                            divParents.append('<div>'+ data.message +'</div><div>URL: <a target="_blank" href='+ data.url +'>'+ data.url +'</a></div>')
                        }
                    },
                    error: function (error) {
                        $(eThis).prop('disabled', false)
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
});