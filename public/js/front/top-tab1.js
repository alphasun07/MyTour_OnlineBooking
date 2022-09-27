$(function () {
    $('.top-tab01__label').click(function(){
        $('.tab01_active').removeClass('tab01_active');
        $(this).addClass('tab01_active');
        $('.content__show01').removeClass('content__show01');
        // クリックしたタブからインデックス番号を取得
        const index = $(this).index();
        // クリックしたタブと同じインデックス番号をもつコンテンツを表
        $('.top-tab01__content').eq(index).addClass('content__show01');
    });

	var slider = $('.top-new__card').slick({
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

    $('.top-tab01__label').on('click', function() {
        slider.slick('setPosition');
    });
});