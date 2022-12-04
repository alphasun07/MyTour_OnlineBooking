$(document).ready(function () {

  $('.items').slick({
      infinite: true,
      slidesToShow: 3,
      slidesToScroll: 3,
      autoplay: true,
      responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
  });
  $('.items2').slick({
      infinite: false,
      slidesToShow: 5,
      slidesToScroll: 5,
      autoplay: true,
      responsive: [
          {
            breakpoint: 1024,
            settings: {
              slidesToShow: 3,
              slidesToScroll: 3,
              infinite: true,
              dots: true
            }
          },
          {
            breakpoint: 600,
            settings: {
              slidesToShow: 2,
              slidesToScroll: 2
            }
          },
          {
            breakpoint: 480,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1
            }
          }
          // You can unslick at a given breakpoint now by adding:
          // settings: "unslick"
          // instead of a settings object
        ]
  });

});

function check_login(){
  return confirm("Bạn cần đăng nhập để có thể đặt tour.");
}



$(document).ready(function(){

$("#agree").change(function(){
  if(this.checked){
    $("#agree").attr("agree", "1");
  }else{
    $("#agree").attr("agree", "0");
  }
});
$("#pay_button").click(function(){
  let value = $("#agree").attr("agree");
  if(value == 1){
    $("#pay_button").prop('disabled', true);
    $('[name="payment_form"]').submit();
  }else{
    alert("Hãy đồng ý với các điều khoản để tiếp tục!");
  }
});

});
