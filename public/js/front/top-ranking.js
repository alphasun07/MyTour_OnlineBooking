$(function () {
    $('.top-tab02__label').click(function(){
        $('.tab02_active').removeClass('tab02_active');
        $(this).addClass('tab02_active');
        $('.content__show02').removeClass('content__show02');
        // クリックしたタブからインデックス番号を取得
        const index = $(this).index();
        // クリックしたタブと同じインデックス番号をもつコンテンツを表
        $('.top-ranking__content').eq(index).addClass('content__show02');
    });

    var slider = $('.top-ranking__card').slick({
        arrows: true,
        autoplay: false,
        autoplaySpeed: 5000,
        dots: false,
        slidesToShow: 5,
        variableWidth: false,
        responsive: [{
            breakpoint: 600,
            settings: {
                arrows: false,
                centerMode: false,
                slidesToShow: 2
            }
        }]
    });

    $('.top-tab02__label').on('click', function() {
        slider.slick('setPosition');
    });
});