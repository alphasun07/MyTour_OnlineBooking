// クラス変更
window.onload = function() {
    const spinner = document.getElementById('loading');
    spinner.classList.add('loaded');
}

//safari対策
window.onpageshow = function(event) {
    if (event.persisted) {
        window.location.reload();
    }
};

//お気に入りボタン
function changeFavorite($flag, $image, $product_id){
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    if($flag == 'fav'){
        //登録
        $.ajax({
            type: "post", //HTTP通信の種類
            url:'product/add/favorite', //通信したいURL
            dataType: 'json',
            data: {
                product_id: $product_id,
            },
        })
        //通信が成功したとき
        .done((res)=>{
            var favorite = $('.js-favorite__'+$product_id).children('img');
            var favorite_img = favorite.attr("src");
            favorite.attr("src", $image);
            favorite.attr("alt", "fav_no");
            favorite.attr("id", favorite_img);
        })
        //通信が失敗したとき
        .fail((error)=>{
            console.log(error.statusText)
        })
    }else{
        //削除
        $.ajax({
            type: "post", //HTTP通信の種類
            url:'product/delete/favorite', //通信したいURL
            dataType: 'json',
            data: {
                product_id: $product_id,
            },
        })
        //通信が成功したとき
        .done((res)=>{
            var favorite = $('#js-favorite__'+$product_id).children('img');
            var favorite_img = favorite.attr("src");
            favorite.attr("src", $image);
            favorite.attr("alt", "fav");
            favorite.attr("id", favorite_img);
        })

        //通信が失敗したとき
        .fail((error)=>{
            console.log(error.statusText)
        })
    }
};

//カートに入れる
function inCartProduct($this, $quantity){
    //ローディングアニメーション開始
    $(document).ajaxSend(function() {
        $("#js-overlay").fadeIn(300);
    });

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    var product_id = $this.split(" ")[0];//$('#is-products-id').nextAll('#is-products-id:first').val();
    var price = $this.split(" ")[1];//$('#is-tax-price'.).val();

    $.ajax({
        type: "post", //HTTP通信の種類
        url:'product/in/cart', //通信したいURL
        dataType: 'json',
        data: {
            product_id: product_id,
            price: price,
            quantity: $quantity
        },
    })
    //通信が成功したとき
    .done((res)=>{
        //ローディングアニメーション終了
        setTimeout(function(){
            $("#js-overlay").fadeOut(300);
        },500);

        var cart_quantity_pc = $("#js-cart-quantity-pc");
        var cart_quantity_pc_login = $("#js-cart-quantity-pc-login");
        var cart_quantity_sp = $("#js-cart-quantity-sp");
        var cart_num = Number(cart_quantity_pc.html()) + Number($quantity);
        cart_quantity_pc.html(cart_num);
        cart_quantity_pc_login.html(cart_num);
        cart_quantity_sp.html(cart_num);
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