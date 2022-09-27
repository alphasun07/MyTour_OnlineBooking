$(function () {
    $('.js-modal-open').each(function () {
        $(this).on('click', function () {
            var target = $(this).data('target');
            var modal = document.getElementById(target);
            $(modal).fadeIn();
            return false;
        });
    });
    $('.js-modal-close').on('click', function () {
        $('.js-modal').fadeOut();
        return false;
    });
});
$(function () {
    var topBtn = $('#js-cart-btn_wrap');
    topBtn.hide();
    $(window).scroll(function () {
        if ($(this).scrollTop() > 500) {
            topBtn.fadeIn();
        } else {
            topBtn.fadeOut();
        }
    });
});

$(function () {
    $('.p-cart-radio').on('click', function () {
        $(this).prev('input[type=radio]').attr("checked", true);
    });
});

//削除する商品IDをモーダルの削除に送る
$(function () {
    $('#js-delete-id-click').on('click', function () {
        $('#delete-do').val($('#js-delete-id-put').val());
    });
});

function cartCustomerAddressPut($customer_address){
    $('#delete-do').val($customer_address);
}

//お届け先選択　ラジオボタンのvalueを渡す
function selectedCustomerAddressRadioId($customer_address_radio_id){
    $('#select-id').val($customer_address_radio_id);
}

//カート数量変更
function quantitySelect($item_number){
    //ローディングアニメーション開始
    $(document).ajaxSend(function() {
        $("#js-overlay").fadeIn(300);
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    //カート画面選択個数
    var item = document.getElementById('js-quantity'+$item_number);
    var quantity = item.value;

    $.ajax({
        type: "post", //HTTP通信の種類
        url:'/cart/quantity/select', //通信したいURL
        dataType: 'json',
        data: {
            quantity: quantity,
            product_id: $item_number
        },
    })
    //通信が成功したとき
    .done((res)=>{
        //ローディングアニメーション終了
        setTimeout(function(){
            $("#js-overlay").fadeOut(300);
        },500);

        if(!res['over_message']){
            //現在のページをリロード
            location.reload(true);
        }else{
            //購入可能数量を超えていることを表示
            var over_message = document.getElementById('js-quantity_over_message');
            over_message.innerHTML = res['over_message'];
            //変更される前の数を表示
            item.value = res['quantity'];
            $('#js-quantity_over_message').fadeIn(1000).delay(2000).fadeOut(2000);
        }
    })
    //通信が失敗したとき
    .fail((error)=>{
        //ローディングアニメーション終了
        setTimeout(function(){
            $("#js-overlay").fadeOut(300);
        },500);

        console.log(error.statusText)
    })
};

//カートから商品削除
function cartProductDelete($item_number){
    $(document).ajaxSend(function() {
        $("#js-overlay").fadeIn(300);
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "post", //HTTP通信の種類
        url:'/cart/product/delete', //通信したいURL
        dataType: 'json',
        data: {
            product_id: $item_number,
        },
    })

    //通信が成功したとき
    .done((res)=>{
        setTimeout(function(){
            $("#js-overlay").fadeOut(300);
        },500);

        //現在のページをリロード
        location.reload(true);
    })
    //通信が失敗したとき
    .fail((error)=>{
        setTimeout(function(){
            $("#js-overlay").fadeOut(300);
        },500);

        console.log(error.statusText)
    })
};

//お届け先住所から削除
function cartCustomerAddressDelete($cart_address_choice_id){
    $(document).ajaxSend(function() {
        $("#js-overlay").fadeIn(300);
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $.ajax({
        type: "post", //HTTP通信の種類
        url:'/cart/address/choice/delete', //通信したいURL
        dataType: 'json',
        data: {
            cart_address_choice_id: $cart_address_choice_id,
        },
    })

    //通信が成功したとき
    .done((res)=>{
        setTimeout(function(){
            $("#js-overlay").fadeOut(300);
        },500);

        //現在のページをリロード
        location.reload(true);
    })
    //通信が失敗したとき
    .fail((error)=>{
        setTimeout(function(){
            $("#js-overlay").fadeOut(300);
        },500);

        console.log(error.statusText)
    })
};

//利用ポイント入力
function pointCheck($use_point_type){
    $('input:radio[name=point]').val([$use_point_type]);
    var point_quantity = $('#is-point__quantity').val();
    var point = $('#js-point').html();
    if(Number(point_quantity) > Number(point)){
        $('#is-point__quantity').val(0);
    }
    pointDisplay();
}

//ポイント利用表示
function pointDisplay($use_point_type){
    if($('#p-cart_point_03').val() == $use_point_type){
        //使わない
        $('#use_point').val(0);
        $('#is-point__quantity').val(0);
    } else if($('#p-cart_point_02').val() == $use_point_type){
        //すべて使う
        $('#use_point').val($('#js-point').html());
        $('#is-point__quantity').val($('#js-point').html());
    } else {
        //利用ポイント選択
        $('#use_point').val($('#is-point__quantity').val());
    }
    //合計金額からポイント・クーポンの利用分を引く
    TotalPriceSub();
}

//クーポンコード入力時
function couponCheck(){
    $(document).ajaxSend(function() {
        $("#js-overlay").fadeIn(300);
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var coupon_code = $('#coupon_code').val();
    $.ajax({
        type: "post", //HTTP通信の種類
        url:'/cart/coupon/check', //通信したいURL
        dataType: 'json',
        data: {
            coupon_code: coupon_code,
        },
    })

    //通信が成功したとき
    .done((res)=>{
        setTimeout(function(){
            $("#js-overlay").fadeOut(300);
        },500);
        //クーポンID
        $("#coupon_id").val(res['coupon_id']);
        if(res['discount_rate'] == 0){
            $('#coupon_code').val("");
            alert('こちらのクーポンコードは使用できません。');
        }
        //クーポン割引適応
        $("#use_coupon").val(res['discount_rate']);
        //合計金額からポイント・クーポンの利用分を引く
        TotalPriceSub();
    })
    //通信が失敗したとき
    .fail((error)=>{
        setTimeout(function(){
            $("#js-overlay").fadeOut(300);
        },500);
        $('#coupon_code').val("");
        alert('こちらのクーポンコードは使用できません。');
    })
};

//合計金額からポイント・クーポンの利用分を引く
function TotalPriceSub() {
    var total_price = Number($('#origin_cart_total').val()) - Number($('#use_point').val()) - Number($('#use_coupon').val());
    //マイナスの時0
    if(Math.sign(total_price) == -1){
        //クーポンを優先して使う
        var coupon_price = Number($('#origin_cart_total').val()) - Number($('#use_coupon').val());
        var use_point = Number($('#use_point').val());
        if(Math.sign(coupon_price) == -1){
            $('#use_point').val(0);
            $('#is-point__quantity').val(0);
        }else if(coupon_price <= use_point){
            //クーポン価格を引いた値までしかポイントが使えない
            $('#use_point').val(coupon_price);
            $('#is-point__quantity').val(coupon_price);
            if(coupon_price == 0){
                $('input[name=point]').val([0]);
            }else{
                $('input[name=point]').val([2]);
            }
        }
        total_price = 0;
    }

    $('#cart_total').val(total_price);
    //付与ポイントの計算
    pointAddChange();
}

//radioボタンのチェックを２回押すと消す
var remove = 0;

function radioDeselection(already, numeric) {
    if(remove == numeric) {
        already.checked = false;
        remove = 0;
    } else {
        remove = numeric;
    }
}

//ポイント・クーポン入力時のポイント付与変更
function pointAddChange(){
    $(document).ajaxSend(function() {
        $("#js-overlay").fadeIn(300);
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    var origin_cart_total = $('#origin_cart_total').val();
    var cart_total = $('#cart_total').val();
    $.ajax({
        type: "post", //HTTP通信の種類
        url:'/cart/add/point/change', //通信したいURL
        dataType: 'json',
        data: {
            origin_cart_total: origin_cart_total,
            cart_total: cart_total,
        },
    })

    //通信が成功したとき
    .done((res)=>{
        setTimeout(function(){
            $("#js-overlay").fadeOut(300);
        },500);

        //ポイント付与
        $("#add_point").val(res);
    })
    //通信が失敗したとき
    .fail((error)=>{
        setTimeout(function(){
            $("#js-overlay").fadeOut(300);
        },500);

    })
};