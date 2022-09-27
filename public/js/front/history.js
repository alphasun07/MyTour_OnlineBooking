$(function() {
	$(".o-history__wrap").slick({
		arrows: true,
		autoplay: true,
		autoplaySpeed: 5000,
		centerMode: true,
		centerPadding: "20px",
		dots: false,
		slidesToShow: 8,
		variableWidth: false,
		responsive: [{
			breakpoint: 600,
			settings: {
				centerPadding: "0",
				slidesToShow: 3,
			}
		}]
	});
});