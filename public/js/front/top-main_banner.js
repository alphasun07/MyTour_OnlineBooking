$(function () {
    $('.tab__item').click(function(){
        $('.active').removeClass('active');
        $(this).addClass('active');
        $('.content__show').removeClass('content__show');
        // クリックしたタブからインデックス番号を取得
        const index = $(this).index();
        // クリックしたタブと同じインデックス番号をもつコンテンツを表
        $('.t-mainbnr__content').eq(index).addClass('content__show');

    });

    var slider = $('.t-mainbnr__wrap').slick({
    	dots: true,
        infinite: true,
        arrows: false,
        autoplaySpeed: 3000,
        slidesToShow: 1,
        autoplay: true,
        adaptiveHeight: false
    });

    $('.tab__item').on('click', function() {
            slider.slick('setPosition');
    });
});