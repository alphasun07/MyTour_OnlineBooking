$(document).ready(function () {

  $('#login').validate({
    rules: {
      username: {
          required: true,
      },
      password: {
          required: true,
          /* minlength: 8 */
      },
  },
  messages: {
      username: {
          required: "Không thể để trống trường này",
      },
      password: {
          required: "Không thể để trống trường này",
          minlength: jQuery.validator.format("Mật khẩu gồm ít nhất {0} ký tự")
      },
  }
});

  $('#register').validate({
      rules: {
          email: {
              required: true,
              email: true,
          },
          user_name: {
              required: true,
          },
          password: {
              required: true,
              minlength: 8
          },
          password2: {
              required: true,
              minlength: 8,
              equalTo: "#input-password"
          },
      },
      messages: {
          email: {
              required: "Không thể để trống trường này",
              minlength: "Nhập địa chỉ Email có hiệu lực"
          },
          user_name: {
              required: "Không thể để trống trường này",
          },
          password: {
              required: "Không thể để trống trường này",
              minlength: jQuery.validator.format("Mật khẩu gồm ít nhất {0} ký tự")
          },
          password2: {
              required: "Không thể để trống trường này",
              minlength: jQuery.validator.format("Mật khẩu gồm ít nhất {0} ký tự"),
              equalTo: "Mật khẩu chưa khớp"
          },
      }
  })

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
$("#people_select").on("change", function(){
  let value = this.value;
  let priceDom = $("#price");
  let price = priceDom.attr("price");
  price = Number(price);
  let totalPrice = Number(value) * price;
  priceDom.html(value);
  totalPrice = String(totalPrice);
  let k = 0;
  for(let i = totalPrice.length; i >= 0; i--){
      if(k%3==0 && k!= 0){
        totalPrice = totalPrice.substr(0, i) + "," + totalPrice.substr(i);
      }
      k++;
  }
  $("#totalPrice").html(totalPrice + "đ");
});
$("#date_start").on("change", function(){
  let input = this.value;
  let dateEntered = new Date(input);
  let now = new Date();
  let month = now.getMonth() + 1;
  if(month < 10){
    month = "0" + month;
  }
  let day = now.getDate();
  if(day < 10){
    day = "0" + day;
  }
  let enterdTime = dateEntered.getTime();
  let nowTime = now.getTime();
  if(enterdTime - nowTime < 172800000){
    alert("Xin vui lòng chọn ngày khởi hành sau 3 ngày kể từ ngày hôm nay");
    this.value = now.getFullYear() + "-" + month + "-" + day;
  }else{
    $("#date_start").attr("isValid", "1");
    $("#date_start").attr("date_data", input);
    let dayCount =  Number($("#date_start").attr("day_count"));
    let endDate = new Date(dateEntered.setDate(dateEntered.getDate() + dayCount));
    let endDateDom = $("#date_end");
    let month = endDate.getMonth() + 1;
    if(month < 10){
      month = "0" + month;
    }
    let day = endDate.getDate();
    if(day < 10){
      day = "0" + day;
    }
    let endDateStr = day + " Tháng " + month + ", " +  endDate.getFullYear();
    endDateDom.html(endDateStr);
  }
});

$("#order_now").click(function(){
  let dateDom = $("#date_start");
  let valid = dateDom.attr("isValid");
  $orderDom = $("#order_now");
  let tour_id = $orderDom.attr("tour_id");
  let people = $("#price").text();
  let dateEntered = new Date(dateDom.attr("date_data"));
  let month = dateEntered.getMonth() + 1;
  if(month < 10){
    month = "0" + month;
  }
  let day = dateEntered.getDate();
  if(day < 10){
    day = "0" + day;
  }
  let dateStr = dateEntered.getFullYear() + "-" + month + "-" + day;
  if(valid == 1){
    $("#order_now").prop('disabled', true);
    $.post("ajax/ajax.php",
    {
      mode: "order",
      tour_id: tour_id,
      people: people,
      date_start : dateStr
    },
    function(data, status){
      if(data == "ok"){
        alert("Đặt tour thành công, xin quý khách chờ email để thanh toán");
        setTimeout(function(){ location.replace("index.php"); },1500);
      }else{
        alert(data);
      }
    });
  }else{
    alert("Xin mời chọn ngày!");
  }
});

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
    let order_id = $("#pay_button").attr("order_id");
    $.post("ajax/ajax.php",
    {
      mode: "payment",
      order_id: order_id,
    },
    function(data, status){
      if(data == "ok"){
        alert("Thanh toán thành công, chúc quý khách tận hưởng chuyến đi vui vẻ!");
        setTimeout(function(){ location.replace("index.php"); },1000);
      }else{
        alert(data);
      }
    });
  }else{
    alert("Hãy đồng ý với các điều khoản để tiếp tục!");
  }
});

});