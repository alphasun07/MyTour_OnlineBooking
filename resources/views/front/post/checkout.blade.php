@php
use Carbon\Carbon;
$now = Carbon::now();
@endphp
@extends('front.common.app')
@section("content")
<div class="mr-auto ml-auto" style="max-width: 1300px">
    <div class="col-12 mt-2">
      <small class="text-muted"><a href="#" style="color: #282365;"><u>Du lịch</u></a><small><i
            class="fas fa-chevron-right ml-3 mr-3"></i></small><a href="#" style="color: #282365;"><u>Đặt tour trong
            nước</u></a></small>
    </div>
    <hr>

    <div class="col-12 mt-2">
      <span href="#" style="color:#4D4AEF; font-weight: 500;">1. Nhập thông tin</span><i
        class="fas fa-chevron-right ml-3 mr-3"></i><span href="#" style="color: #4D4AEF; font-weight: 500;">2. Thanh
        toán</span>
    </div>
    <hr>


    <!-- card thanh toán -->
    <div class="col d-flex flex-row-reverse justify-content-between">
      <div class="card" style="width: 30rem;">
            <div class="card-body justify-content-center">
              <h5 class="card-title" style="color: #282365;">Hóa đơn thanh toán</h5>
              <p class="card-text mb-2"><span class="ml-1" style="color: #282365; font-weight: 500; font-size: normal;">{{ $tour->category_id ?? '' }}</span> </p>
              <img src="{{ asset('storage/tours/' . $tour->thumbnail) }}" class="img-thumbnail mr-2"
                style="width:25%; border: none; border-radius: 10px; float: left;">
              <p class="card-text mr-4" style="color: #282365; font-weight: 500;">{{ $tour->name ?? '' }}</p>
              <br>
              <p class="card-text mb-0"><span class="ml-1" style="color: #282365;">Bắt đầu chuyến đi</span> </p>
              <p class="card-text mb-4"><span class="ml-1" style="color: #282365; font-weight: 500; font-size: normal;">
              {{ $now->addDay(7)->format('d - n - Y') }}</span></p>
              <p class="card-text mb-0"><span class="ml-1" style="color: #282365;">Kết thúc chuyến đi</span> </p>
              <p class="card-text mb-5"><span class="ml-1" style="color: #282365; font-weight: 500; font-size: normal;">
                {{ $now->addDay(7 + $tour->tour_time)->format('d - n - Y') }}</span></p>
              <p class="card-text mb-4"><span class="ml-1"
                  style="color: #282365; font-weight: 500; font-size: normal; float: left;">Hành khách</span></p>
              <p class="card-text mb-4"><span class="ml-1"
                  style="color: #282365; font-weight: 500; font-size: normal; float: right;">{{ $dataGet['order_number'] ?? $tour->max_person }}</span>
              </p>
              <br>
              <br>
              <p class="card-text mb-0"><span class="ml-1"
                  style="color: #282365; font-weight: 500; font-size: normal; float: left;">Giá vé</span></p>
              <p class="card-text mb-4"><span class="ml-1"
                  style="color: #282365; font-weight: 500; font-size: normal; float: right;">{{ $dataGet['order_number'] ?? $tour->max_person }}&#160;x&#160;{{ number_format(($tour->price_per_person ?? 0), 0, "", ",") }}₫</span>
              </p>

              <br><br><br>
              <hr>
              <p class="card-text mb-0"><span class="ml-1"
                  style="color: #282365; font-weight: 500; font-size: normal; float: left;">TỔNG CỘNG</span></p>
              <p class="card-text mb-4"><span class="ml-1"
                  style="color: #FD5056; font-weight: 500; font-size: x-large; float: right;">{{ number_format((($dataGet['order_number'] ?? $tour->max_person) * $tour->price_per_person), 0, "", ",") }}₫</span></p>
              <br><br><br>
              <button type="button" id="pay_button" order_id = "'.$order["order_id"].'" class="btn btn-danger col d-flex justify-content-center p-3"
                style="background-color: #FD5056; font-size:large; font-weight: 500; border-radius: 10px;">THANH TOÁN</button>
            </div>

      </div>
      <div class="col-8 mt-2 pl-0">
        <h2 style="color: #282365;">Thanh toán</h2>
        <br>
        <form name="payment_form" method='post' action="{{ route('home.tour.checkout_ing') }}">
            @csrf
            <div class="col-10 mb-2">
                <input type="text" class="form-control m-2" required name="phone" placeholder="Số điện thoại của bạn" value="{{ old('phone', '') }}">
                <input type="email" class="form-control m-2" required name="email" placeholder="Email của bạn" value="{{ old('email', '') }}">
                <textarea  class="form-control ml-2" name="comment" cols="70" rows="5" placeholder="Chú thích của bạn"></textarea>
            </div>
            <h4 style="color: #282365; font-weight: 600;">Các hình thức thanh toán</h4>
            <input type="hidden" name="order_number" value="{{ $dataGet['order_number'] ?? $tour->max_person }}">
            <input type="hidden" name="total_ammount" value="{{ ($dataGet['order_number'] ?? $tour->max_person) * $tour->price_per_person }}">
            <input type="hidden" name="payment_currency	" value="VND">
            <input type="hidden" name="published" value="1">
            <input type="hidden" name="tour_id" value="{{ $tour->id ?? 0 }}">
          <div class="card-deck mb-2">
            <div class="card" style="border:transparent; background-color: #F9F9F9;">
              <div class="card-body">
                <div class="form-check d-flex flex-row-reverse">
                  <input class="form-check-input" value="2" type="radio" name="payment_method" checked id="flexRadioDefault1" style="width: 20px;
                  height: 20px;">
                </div>
                <label class="form-check-label" style="float: left; color:#282365;">
                  Tiền mặt
                </label>
              </div>
            </div>
            <div class="card" style="border:transparent; background-color: #F9F9F9;">
              <div class="card-body">
                <div class="form-check d-flex flex-row-reverse">
                  <input class="form-check-input" value="3" type="radio" name="payment_method" id="flexRadioDefault1" style="width: 20px;
                  height: 20px;">
                </div>
                <label class="form-check-label" style="float: left; color:#282365;">
                  Thẻ tín dụng
                </label>
              </div>
            </div>
          </div>
          <div class="card-deck mb-2">
            <div class="card" style="border:transparent; background-color: #F9F9F9;">
              <div class="card-body">
                <div class="form-check d-flex flex-row-reverse">
                  <input class="form-check-input" value="1" type="radio" name="payment_method" id="flexRadioDefault1" style="width: 20px;
                  height: 20px;">
                </div>
                <label class="form-check-label" style="float: left; color:#282365;">
                  Chuyển khoản
                </label>
              </div>
            </div>
            <div class="card" style="border:transparent; background-color: #F9F9F9;">
              <div class="card-body">
                <div class="form-check d-flex flex-row-reverse">
                  <input class="form-check-input" value="1" type="radio" name="payment_method" id="flexRadioDefault1" style="width: 20px;
                  height: 20px;">
                </div>
                <label class="form-check-label" style="float: left; color:#282365;">
                  Thanh toán bằng mã QRCode
                </label>
              </div>
            </div>
          </div>
          <div class="card-deck mb-2">
            <div class="card" style="border:transparent; background-color: #F9F9F9;">
              <div class="card-body">
                <div class="form-check d-flex flex-row-reverse">
                  <input class="form-check-input" value="1" type="radio" name="payment_method" id="flexRadioDefault1" style="width: 20px;
                  height: 20px;">
                </div>
                <label class="form-check-label" style="float: left; color:#282365;">
                  ATM / Internet Banking
                </label>
              </div>
            </div>
            <div class="card" style="border:transparent; background-color: #F9F9F9;">
              <div class="card-body">
                <div class="form-check d-flex flex-row-reverse">
                  <input class="form-check-input" value="1" type="radio" name="payment_method" id="flexRadioDefault1" style="width: 20px;
                  height: 20px;">
                </div>
                <label class="form-check-label" style="float: left; color:#282365;">
                  Thanh toán bằng Momo
                </label>
              </div>
            </div>
          </div>
        </form>

        <!-- điều khoản -->
        <br>
        <br>
        <h4 style="color: #282365; font-weight: 600;">Điều khoản bắt buộc khi đăng ký online</h4>
        <div class="overflow-auto p-3" style="max-height: 275px; border: 1px solid rgb(226, 223, 223)">
          <p class="mb-2"><small style="color: #282365; font-weight: bold;">ĐIỀU KIỆN BÁN VÉ CÁC CHƯƠNG TRÌNH DU LỊCH TRONG NƯỚC</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: bold;">I.&#160;&#160;&#160;GIÁ VÉ DU LỊCH</small></p>
          <p class="mb-2"><small style="color: #282365; ">Giá vé du lịch được tính theo tiền Đồng (Việt Nam - VNĐ). Trường hợp khách thanh toán bằng USD sẽ được quy đổi ra VNĐ theo tỉ giá của ngân hàng Đầu Tư và Phát Triển Việt Nam - Chi nhánh TP.HCM tại thời điểm thanh toán.</small></p>
          <p class="mb-2"><small style="color: #282365; ">Giá vé chỉ bao gồm những khoản được liệt kê một cách rõ ràng trong phần “Bao gồm” trong các chương trình du lịch. Vietravel không có nghĩa vụ thanh toán bất cứ chi phí nào không nằm trong phần “Bao gồm”.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: bold;">II.&#160;&#160;&#160;GIÁ DÀNH CHO TRẺ EM</small></p>
          <p class="mb-2"><small style="color: #282365; ">- Trẻ em dưới 5 tuổi:  không thu phí dịch vụ, bố mẹ tự lo cho bé và thanh toán các chi phí phát sinh (đối với các dịch vụ tính phí theo chiều cao…). Hai người lớn chỉ được kèm 1 trẻ em dưới 5 tuổi, trẻ em thứ 2 sẽ đóng phí theo qui định dành cho độ tuổi từ 5 đến dưới 12 tuổi và phụ thu phòng đơn. Vé máy bay, tàu hỏa, phương tiện vận chuyển công cộng mua vé theo qui định của các đơn vị vận chuyển (nếu có)</small></p>
          <p class="mb-2"><small style="color: #282365; ">- Trẻ em từ 5 tuổi đến dưới 12 tuổi:  50% giá tour người lớn đối với tuyến xe, 75% giá tour người lớn đối với tuyến có vé máy bay (không có chế độ giường riêng). Hai người lớn chỉ được kèm 1 trẻ em từ 5 - dưới 12 tuổi, em thứ hai trở lên phải mua 1 suất giường đơn.</small></p>
          <p class="mb-2"><small style="color: #282365; ">- Trẻ em từ 12 tuổi trở lên: mua một vé như người lớn.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: bold;">III.&#160;&#160;&#160;THANH TOÁN</small></p>
          <p class="mb-2"><small style="color: #282365; ">Khi thanh toán, Quý khách vui lòng cung cấp đầy đủ thông tin và đặt cọc ít nhất 50% tổng số tiền tour để giữ chỗ, số tiền còn lại Quý khách sẽ thanh toán trước ngày khởi hành 05 ngày làm việc (tour ngày thường) và trước 10 ngày làm việc (tour dịp Lễ, Tết)”.</small></p>
          <p class="mb-2"><small style="color: #282365; ">Thanh toán bằng tiền mặt hoặc chuyển khoản tới tài khoản ngân hàng của Vietravel.</small></p>
          <p class="mb-2"><small class="text-danger" style="color: #282365; ">Tên Tài Khoản : <b style="font-weight:750; color: #C00000;">Công ty CP Du lịch và Tiếp thị GTVT Việt Nam – Vietravel</b></small></p>
          <p class="mb-2"><small class="text-danger" style="color: #282365; ">Tên tài khoản viết tắt : <b style="font-weight:750; color: #C00000;">VIETRAVEL</b></small></p>
          <p class="mb-2"><small class="text-danger" style="color: #282365; ">Số Tài khoản : <b style="font-weight:750; color: #C00000;">007 100 115 1480</b></small></p>
          <p class="mb-2"><small class="text-danger" style="color: #282365; ">Ngân hàng :  <b style="font-weight:750; color: #C00000;">Vietcombank – CN Tp.HCM</b></small></p>
          <p class="mb-2"><small style="color: #282365; ">Việc thanh toán được xem là hoàn tất khi Vietravel nhận được đủ tiền vé du lịch trước lúc khởi hành hoặc theo hợp đồng thỏa thuận giữa hai bên. Bất kỳ mọi sự thanh toán chậm trễ dẫn đến việc hủy dịch vụ không thuộc trách nhiệm của Vietravel.</small></p>
          <p class="mb-2"><small style="color: #282365; ">Khách hàng có nhu cầu xuất hóa đơn, vui lòng cung cấp thông tin xuất hóa đơn ngay tại thời điểm đăng ký. Vietravel có trách nhiệm xuất hóa đơn cho khách hàng trong vòng 7 ngày sau khi tour kết thúc.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">DÀNH CHO KHÁCH HÀNG ĐĂNG KÝ TRÊN TRANG WWW.TRAVEL.COM.VN THANH TOÁN CHUYỂN KHOẢN:</small></p>
          <p class="mb-2"><small style="color: #282365; ">Khi thực hiện việc chuyển khoản, Quý khách <b style="font-weight: 750;">vui lòng ghi rõ Tên họ, Số điện thoại và Nội dung chuyển</b>  cho chương trình du lịch cụ thể đã được Quý khách chọn đăng ký. Sau khi thực hiện việc chuyển khoản, Quý khách vui lòng gửi Ủy Nhiệm Chi về công ty Vietravel theo địa chỉ email sales@vietravel.com và liên hệ với nhân viên phụ trách tuyến để nhận được Vé du lịch chính thức từ công ty Vietravel. Vietravel sẽ không giải quyết các trường hợp hệ thống tự động hủy phiếu đăng ký nếu Quý khách không thực hiện đúng qui định trên.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">IV.&#160;&#160;&#160;HỦY VÉ VÀ PHÍ HỦY VÉ DU LỊCH</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">1.&#160;&#160;&#160;Trường hợp bị hủy bỏ do Vietravel:</small></p>
          <p class="mb-2"><small style="color: #282365; ">Nếu Vietravel không thực hiện được chuyến du lịch, Vietravel phải báo ngay cho khách hàng biết và thanh toán lại cho khách hàng toàn bộ số tiền khách hàng đã đóng trong vòng 3 ngày kể từ lúc việc thông báo hủy chuyến du lịch bằng tiền mặt hoặc chuyển khoản.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">2.&#160;&#160;&#160;Trường hợp bị hủy bỏ do khách hàng:</small></p>
          <p class="mb-2"><small style="color: #282365; ">Sau khi đóng tiền, nếu Quý khách muốn chuyển/hủy tour xin vui lòng mang Vé Du Lịch đến văn phòng đăng ký tour để làm thủ tục chuyển/hủy tour và chịu mất phí theo quy định của Vietravel. Không giải quyết các trường hợp liên hệ chuyển/hủy tour qua điện thoại.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">•&#160;&#160;&#160;Đối với ngày thường:</small></p>
          <p class="mb-2"><small style="color: #282365; ">-&#160;&#160;Được chuyển sang các tuyến du lịch khác trước ngày khởi  hành 20 ngày : Không mất chi phí.</small></p>
          <p class="mb-2"><small style="color: #282365; ">-&#160;&#160;Hủy hoặc chuyển sang các chuyến du lịch khác ngay sau khi đăng ký đến từ 15 - 19 ngày trước ngày khởi hành: Chi phí chuyển/hủy tour: 50% tiền cọc tour.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">* Các tour ngày Lễ, Tết là các tour có thời gian diễn ra rơi vào một trong các ngày lễ, tết theo qui định.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">* Thời gian hủy tour được tính cho ngày làm việc, không tính thứ 7, Chủ Nhật và các ngày Lễ, Tết.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">DÀNH CHO KHÁCH HÀNG ĐĂNG KÝ TRÊN TRANG WWW.TRAVEL.COM.VN THANH TOÁN TRỰC TUYẾN:</small></p>
          <p class="mb-2"><small style="color: #282365; ">Khách hàng hủy Vé du lịch trong thời điểm ngày Thường và Lễ Tết theo đúng những qui định trên, trong trường hợp khách thanh toán trực tuyến, nếu hủy Vé du lịch khách hàng sẽ chịu toàn bộ phí ngân hàng cho việc thanh toán tiền Vé du lịch. Việc hoàn trả tiền cho khách sẽ được Vietravel thực hiện ngay sau khi ngân hàng thông báo tiền đã vào tài khoản của Vietravel.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">3.&#160;&#160;&#160;Trường hợp bất khả kháng:</small></p>
          <p class="mb-2"><small style="color: #282365; ">Nếu chương trình du lịch bị hủy bỏ hoặc thay đổi bởi một trong hai bên vì một lý do bất khả kháng (hỏa hoạn, thời tiết, tai nạn, thiên tai, chiến tranh, dịch bệnh, hoãn, dời, hủy chuyến hoặc thay đổi khác của các phương tiện vận chuyển công cộng hoặc các sự kiến bất khả kháng khác theo quy định pháp luật…), thì hai bên sẽ không chịu bất kỳ nghĩa vụ bồi hoàn các tổn thất đã xảy ra và không chịu bất kỳ trách nhiệm pháp lý nào. Tuy nhiên mỗi bên có trách nhiệm cố gắng tối đa để giúp đỡ bên bị thiệt hại nhằm giảm thiểu các tổn thất gây ra vì lý do bất khả kháng. Thời gian hoàn tiền dịch vụ do hủy tour vì trường hợp bất khả kháng sẽ được hoàn tất trong vòng 60 – 90 ngày phụ thuộc điều kiện các đối tác cung ứng dịch vụ.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">4.&#160;&#160;&#160;Thay đổi lộ trình: </small></p>
          <p class="mb-2"><small style="color: #282365; ">Tùy theo tình hình thực tế, Vietravel giữ quyền thay đổi lộ trình, sắp xếp lại thứ tự các điểm tham quan hoặc hủy bỏ chuyến đi du lịch bất cứ lúc nào mà Vietravel thấy cần thiết vì sự thuận tiện hoặc an toàn cho khách hàng.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">V.&#160;&#160;&#160;NHỮNG YÊU CẦU ĐẶC BIỆT TRONG CHUYẾN DU LỊCH</small></p>
          <p class="mb-2"><small style="color: #282365; ">Các yêu cầu đặc biệt của Quý khách phải được báo trước cho Vietravel ngay tại thời điểm đăng ký. Vietravel sẽ cố gắng đáp ứng những yêu cầu này trong khả năng của mình song sẽ không chịu trách nhiệm về bất kỳ sự từ chối cung cấp dịch vụ từ phía các nhà vận chuyển, khách sạn, nhà hàng và các nhà cung cấp dịch vụ độc lập khác.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">VI.&#160;&#160;&#160;KHÁCH SẠN</small></p>
          <p class="mb-2"><small style="color: #282365; ">Khách sạn được cung cấp trên cơ sở những phòng có hai giường đơn (TWN) hoặc một giường đôi (DBL) tùy theo cơ cấu phòng của các khách sạn. Khách sạn do Vietravel đặt cho các chương trình tham quan có tiêu chuẩn tương ứng với các mức giá vé mà khách chọn khi đăng ký đi du lịch. Nếu cần thiết thay đổi về bất kỳ lý do nào, khách sạn thay thế sẽ tương đương với tiêu chuẩn của khách sạn ban đầu và sẽ được báo cho du khách trước khi khởi hành. Những yêu cầu đặc biệt của khách hàng nếu thông báo trước cho Vietravel sẽ được đáp ứng tùy theo khả năng cung cấp của khách sạn và khách hàng phải trả thêm tiền đối với các yêu cầu này (nếu có). Vietravel có quyền không đáp ứng những yêu cầu này nếu khách sạn từ chối cung cấp dịch vụ. Thời gian nhận phòng theo qui định tại các khách sạn là sau 14:00 và phải trả phòng trước 12:00. Đối với các trường hợp khách lưu trú tại hệ thống khách sạn/Resort 5 sao (Vinpearl, FLC, Grand Ho Tram Strip…) tuân thủ theo điều kiện hủy phạt của khách sạn/Resort cho từng thời điểm.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">VII.&#160;&#160;&#160;VẬN CHUYỂN</small></p>
          <p class="mb-2"><small style="color: #282365; ">Phương tiện vận chuyển tùy thuộc theo từng chương trình du lịch.</small></p>
          <p class="mb-2"><small style="color: #282365; ">Với chương trình đi bằng xe: xe máy lạnh (4, 7, 15, 25, 35, 45 chỗ) sẽ được Vietravel sắp xếp tùy theo số lượng khách từng đoàn, phục vụ suốt chương trình tham quan.</small></p>
          <p class="mb-2"><small style="color: #282365; ">Với chương trình đi bằng xe lửa - máy bay - tàu cánh ngầm (phương tiện vận chuyển công cộng), trong một số chương trình các nhà cung cấp dịch vụ có thể thay đổi giờ khởi hành mà không báo trước, việc thay đổi này sẽ được Vietravel thông báo cho khách hàng nếu thời gian cho phép.</small></p>
          <p class="mb-2"><small style="color: #282365; ">Vietravel không chịu trách nhiệm bồi hoàn và trách nhiệm pháp lý với những thiệt hại về vật chất lẫn tinh thần do việc chậm trễ, thay đổi giờ giấc khởi hành của các phương tiện vận chuyển công cộng hoặc sự chậm trễ do chính hành khách gây ra. Vietravel chỉ thực hiện hành vi giúp đỡ để giảm bớt tổn thất cho hành khách.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">VIII.&#160;&#160;&#160;HÀNH LÝ</small></p>
          <p class="mb-2"><small style="color: #282365; ">Hành lý gọn nhẹ, với các chương trình sử dụng dịch vụ hàng không, hành lý miễn cước sẽ do các hãng hàng không qui định. Vietravel không chịu trách nhiệm về sự thất lạc, hư hỏng hành lý hoặc bất kỳ vật dụng gì của du khách trong suốt chuyến đi, du khách tự bảo quản hành lý của mình. Nếu khách hàng bị mất hay thất lạc hành lý thì Vietravel sẽ giúp hành khách liên lạc và khai báo với các bộ phận liên quan truy tìm hành lý bị mất hay thất lạc. Việc bồi thường hành lý bị mất hay thất lạc sẽ theo qui định của các đơn vị cung cấp dịch vụ hoặc các đơn vị bảo hiểm (nếu có).</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">IX.&#160;&#160;&#160;BẢO HIỂM DU LỊCH</small></p>
          <p class="mb-2"><small style="color: #282365; ">Giá dịch vụ du lịch trọn gói đã bao gồm bảo hiểm du lịch trong nước với mức đền bù cao nhất là 120.000.000đ/khách Việt Nam/vụ cho nhân mạng và 12.000.000 VNĐ/khách Việt Nam/vụ cho hành lý .</small></p>
          <p class="mb-2"><small style="color: #282365; ">Điều kiện, điều khoản bảo hiểm: Theo quy tắc bảo hiểm khách du lịch trong nước QĐ số: 001321/2006 – BM/BHCN.</small></p>
          <p class="mb-2"><small style="color: #282365; ">Số hotline tư vấn về các điều kiện, điều khoản bảo hiểm 0938 30 1234</small></p>
          <p class="mb-2"><small style="color: #282365;"><span style="font-weight: 750;">X.&#160;&#160;&#160;</span>Trong quá trình thực hiện, nếu xảy ra tranh chấp sẽ được giải quyết trên cơ sở thương lượng trong thời hạn 30 ngày kể từ ngày một trong hai bên đưa tranh chấp ra thương lượng. Hết thời hạn này nếu tranh chấp không được giải quyết hoặc một trong hai bên không đồng ý với kết quả thương lượng thì có quyền đưa tranh chấp ra giải quyết tại Tòa án thẩm quyền.</small></p>
          <p class="mb-2"><small style="color: #282365; font-weight: 750;">* Vé du lịch được xem như Hợp đồng lữ hành và được lập thành 2 bản, mỗi bên giữ một bản, có giá trị như nhau.</small></p>
          <br>
          <br>
          <br>


        </div>
        <div class="form-check mt-2">
          <input class="form-check-input" type="checkbox" id="agree" a="hoang" style="width:25px; height: 25px;">
          <label class="form-check-label" for="agree">
            <p class="ml-3 mt-1"><small style="color: #282365; font-size:15px ; ">Tôi đồng ý với các điều kiện trên</small></p>
          </label>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script>
    $(document).ready(function(){
    })
</script>
@endsection

