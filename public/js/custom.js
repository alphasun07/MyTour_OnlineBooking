function slideToggleCategory(eThis) {
    var categoryId = $(eThis).data('id');
    if ($('.js-slideToggle' + categoryId).hasClass("show")) {
        $(eThis).children().attr('class', 'fas fa-plus p-1 border border-dark');
    } else {
        $(eThis).children().attr('class', 'fas fa-minus p-1 border border-dark');
    }
}

function selectCategory(categoryId, single, eThis, inputNumber) {
    if (single) {
        if ($('.js-li_' + categoryId).hasClass("o-li_selected")) {
            $('.js-li_' + categoryId).removeClass('o-li_selected');
            $("input[name='categoryId_selected_tmp_" + inputNumber + "']").val('');
            $("input[name='categoryLabel_selected_tmp_" + inputNumber + "']").val('');
        } else {
            $("#js-category_"+inputNumber+" ul li").removeClass('o-li_selected');
            $('.js-li_' + categoryId).toggleClass('o-li_selected');
            $("input[name='categoryId_selected_tmp_" + inputNumber + "']").val(categoryId);
            const listTree = $(eThis).data('tree');
            $("input[name='categoryLabel_selected_tmp_" + inputNumber + "']").val(listTree);
        }
    } else {
        $('.js-li_' + categoryId).toggleClass('o-li_selected');
        var dataIds = [];
        $("#js-category_"+inputNumber+" ul li").each(function () {
            if ($(this).hasClass("o-li_selected")) {
                dataIds.push($(this).data('id'));
            }
        })
        $("input[name='categoryId_selected_tmp_" + inputNumber + "']").val(dataIds.join(','));
    }
}

function choiceCategory(single, inputNumber) {
    if (single) {
        const categoryLabel = $("input[name='categoryLabel_selected_tmp_" + inputNumber + "']").val();
        const categoryId = $("input[name='categoryId_selected_tmp_" + inputNumber + "']").val();
        $("input[name='category_label_selected_" + inputNumber + "']").val(categoryLabel);
        $("#js-parent_id_" + inputNumber).val(categoryId);
        $('#js-category_'+ inputNumber).modal('hide');
    } else {
        const categoryIds = $("input[name='categoryId_selected_tmp_" + inputNumber + "']").val();
        $("#js-parent_id_" + inputNumber).val(categoryIds);
        $('#js-category_'+ inputNumber).modal('hide');
    }
}

function showPopupCategory(single, inputNumber) {
    $("#js-category_"+inputNumber+" ul li").removeClass('o-li_selected');
    if (single) {
        const currentParent = $('#js-parent_id_' + inputNumber).val();
        $('.js-li_' + currentParent).addClass('o-li_selected');
    } else {
        const currentParent = $('#js-parent_id_' + inputNumber).val();
        console.log('currentParent', currentParent);
        var arrCategoryIds = currentParent.split(',');
        arrCategoryIds.forEach((categoryId) => {
            $('.js-li_' + categoryId).addClass('o-li_selected');
        })
    }
}

function getTitleByCategory() {

    var id = $('select[name=category_id').val();
    $.ajax({
        url: url,
        type: 'POST',
        data:{
            id : id,
        },
        success: function(data) {
            $('select[name=category_id_title]').html(data.html);
        },
    });
}

