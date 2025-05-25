@extends('layouts.main')

@section('content')
    <section class="news py-4">
        <div class="container">
            <x-breadcrumb-wrapper :breadcrumbs="[
                ['label' => 'Trang chủ', 'url' => route('home')],
                ['label' => 'Câu hỏi thường gặp', 'url' => route('ask')],
            ]" />
        </div>
        <div class="container py-3" style="background-color: #ffffff; border-radius: 25px">
            <h4>Câu hỏi thường gặp</h4>
            <div>
                <h2 style="margin-top: -10px;"><span style="font-size:18px;">1. Mua sản phẩm PhatShop được bảo hành như thế
                        nào?</span>
                    <o:p></o:p>
                </h2>
                <p>Để đảm bảo quyền lợi của Quý khách hàng khi mua sản
                    phẩm tại các cửa hàng thuộc hệ thống cửa hàng PhatShop. Chúng tôi cam kết tất cả các sản phẩm
                    được tuân theo các điều khoản bảo hành của sản phẩm tại thời điểm xuất hóa đơn cho Quý khách
                    hàng. Các sản phẩm điện thoại sẽ có chính sách bảo hành khác nhau tùy thuộc vào hãng sản xuất.
                    Khách hàng có thể bảo hành máy tại các cửa hàng PhatShop trên toàn quốc cũng như các trung tâm
                    bảo hành chính hãng sản phẩm.<o:p></o:p>
                </p>
                <p>Khách hàng có thể truy cập các đường dẫn sau để tìm
                    kiếm địa chỉ trung tâm bảo hoặc cửa hàng PhatShop gần nhất và tham khảo chính sách bảo hành:
                    <o:p></o:p>
                </p>
                <p><strong>Chính sách bảo hành: </strong>Quý khách vui
                    lòng <a target="_blank" rel="nofollow" href="/ho-tro/chinh-sach-bao-hanh"><span
                            style="color:rgba(173,24,29,1);"><strong>Xem tại đây</strong></span></a>.&nbsp;<o:p>
                    </o:p>
                </p>
                <p><strong>Cửa hàng PhatShop gần nhất:</strong> Quý
                    khách vui lòng <a target="_blank" rel="nofollow" href="/cua-hang"><span
                            style="color:rgba(173,24,29,1);"><strong>Xem tại đây</strong></span></a>.&nbsp;<o:p>
                    </o:p>
                </p>
                <p>Để <strong>tra cứu thông tin máy gửi bảo
                        hành</strong>, Quý khách hàng vui lòng tra cứu tại <a target="_blank" rel="nofollow"
                        href="/kiem-tra-bao-hanh"><span style="color:rgba(173,24,29,1);"><strong>Trang kiểm tra bảo
                                hành</strong></span></a>.</p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">2. Mua sản phẩm tại
                        PhatShop có được đổi trả không? Nếu được thì phí đổi trả sẽ được tính như thế nào?</span>
                    <o:p></o:p>
                </h2>
                <p>Đối với các sản phẩm ĐTDĐ, MTB, MTXT, SMARTWATCH
                    (Áp dụng bao gồm các sản phẩm Apple), sản phẩm cùng model, cùng màu, cùng dung lượng. Trong tình
                    huống sản phẩm đổi hết hàng, khách hàng có thể đổi sang một sản phẩm khác tương đương hoặc cao
                    hơn về giá trị so với sản phẩm lỗi. Trường hợp khách hàng muốn trả sản phẩm: PhatShop sẽ kiểm tra
                    tình trạng máy và thông báo đến Khách hàng về giá trị thu lại sản phẩm ngay tại cửa hàng.<o:p>
                    </o:p>
                </p>
                <p>Để biết thêm thông tin chi tiết, Quý khách hàng có
                    thể tra cứ phí đổi trả chi tiết <a target="_blank" rel="nofollow"
                        href="/ho-tro/chinh-sach-doi-san-pham"><span style="color:rgba(173,24,29,1);"><strong>Tại
                                đây</strong></span></a>.</p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">3. PhatShop có chính
                        sách giao hàng tận nhà không? Nếu giao hàng tại nhà mà không ưng sản phẩm có được trả lại
                        không?</span>
                    <o:p></o:p>
                </h2>
                <p PhatShop cam kết giao hàng toàn bộ 63 tỉnh thành, PhatShop nhận giao đơn hàng có thời gian hẹn giao tại
                    nhà trước 20h00. Miễn phí giao hàng với các đơn hàng trong bán kính 20km có đặt shop (Với đơn hàng có
                    giá trị nhỏ hơn 100.000đ sẽ thu phí 10.000đ) nhân viên PhatShop sẽ tư vấn chi tiết về cách thức giao
                    nhận thuận tiện nhất.<o:p>
                    </o:p>
                </p>
                <p>Nếu Quý khách hàng không ưng ý với sản phẩm khi
                    nhận hàng, Quý khách có thể từ chối mua hàng mà không mất bất cứ chi phí nào. Để biết thêm thông
                    tin, Quý khách có thể tham khảo Chính sách giao hàng <a target="_blank" rel="nofollow"
                        href="/ho-tro/chinh-sach-giao-hang"><span style="color:rgba(173,24,29,1);"><strong>Tại
                                đây</strong></span></a>.<o:p></o:p>
                </p>
                <p>
                    <o:p></o:p>
                </p>
                <p><i><strong><u>Lưu ý:</u></strong></i>
                    <o:p></o:p>
                </p>
                <p>Đối với các sản phẩm còn nguyên seal, khách hàng
                    muốn bóc seal sẽ phải thanh toán 100% giá trị sản phẩm. Nếu không ưng, PhatShop sẽ hỗ trợ đổi
                    sản phẩm cho khách hàng theo chính sách đổi trả.<o:p></o:p>
                </p>
                <p>Đối với các sản phẩm không seal, Quý khách hàng có
                    thể kiểm tra máy mà không phải chịu bất cứ chi phí nào nếu không mua.</p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">4. Làm thế nào để
                        được mua hàng theo chính sách F.Friends?</span>
                    <o:p></o:p>
                </h2>
                <p>Để được mua hàng và hưởng quyền lợi theo chính sách
                    mua hàng F.Friends, Quý khách hàng phải là hội viên. Để biết bạn có là hội viên hay không, bạn
                    cần biết doanh nghiệp bạn đang công tác đã ký hợp đồng tham gia chương trình F.Friends hay chưa.
                    Điều kiện tiếp theo là bạn đã ký hợp đồng chính thức với doanh nghiệp đó chưa.<o:p></o:p>
                </p>
                <p>Nếu bạn đã là hội viên của chương trình này, bạn sẽ
                    được hưởng ưu đãi trả thẳng giảm 3% khi mua sản phẩm. Để được trả góp bạn phải đủ 8 tháng công
                    tác tại doanh nghiệp.<o:p></o:p>
                </p>
                <p>Quý khách có thể tham khảo chi tiết về Chính sách
                    F. Friends <a target="_blank" rel="nofollow" href="/ho-tro/ffriends"><span
                            style="color:rgba(173,24,29,1);"><strong>Tại đây</strong></span></a>.</p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">5. Làm thế nào để
                        kiểm tra được tình trạng máy đã gửi đi bảo hành tại PhatShop?</span>
                    <o:p></o:p>
                </h2>
                <p>Để tra cứu thông tin máy gửi bảo hành, Quý khách
                    hàng có thể truy cập <a target="_blank" rel="nofollow" href="/kiem-tra-bao-hanh"><span
                            style="color:rgba(173,24,29,1);"><strong>Tại đây</strong></span></a>.<o:p></o:p>
                </p>
                <p>
                    <o:p></o:p>
                </p>
                <p>→ Chọn mục "<strong>Tra cứu thông tin
                        máy</strong>".</p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">6. Muốn kiểm tra
                        sản phẩm đã mua từ PhatShop có chính hãng của Apple thì xem như thế nào?</span>
                    <o:p></o:p>
                </h2>
                <p>Để tra cứu thông tin sản phẩm chính hãng của
                    Apple, Quý khách hàng có thể truy cập <a target="_blank" rel="nofollow"
                        href="https://checkcoverage.apple.com/"><span style="color:rgba(173,24,29,1);"><strong>Tại
                                đây</strong></span></a>.<o:p></o:p>
                </p>
                <p>
                    <o:p></o:p>
                </p>
                <p>→ Nhập số sê-ri của thiết bị.</p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">7. Cần hướng dẫn
                        cách sử dụng về sản phẩm thì liên hệ hoặc xem ở đâu được?</span>
                    <o:p></o:p>
                </h2>
                <p>Quý khách có thể tham khảo sách hướng dẫn sử dụng
                    kèm theo sản phẩm hoặc gọi vào tổng đài 1800.6601 nhánh số 2 để gặp điện thoại viên hướng dẫn
                    thêm.</p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">8. Muốn xem giá
                        thay thế linh kiện cho sản phẩm đã mua tại PhatShop thì xem ở đâu?</span>
                    <o:p></o:p>
                </h2>
                <p>Quý khách tham khảo bảng giá sửa chữa <a href="https://Phatshop.com.vn/ho-tro/bang-gia-sua-chua"
                        target="_blank" rel="nofollow"><span style="color:rgba(173,24,29,1);"><strong>Tại
                                đây</strong></span></a><span style="color:rgba(173,24,29,1);"><strong>.</strong></span>
                </p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">9. Đặt đơn hàng
                        thành công và muốn theo dõi tiến độ đơn hàng đã được đi giao chưa thì xem ở đâu?</span>
                    <o:p></o:p>
                </h2>
                <p>Để tra cứu thông tin đơn hàng đã đặt thành công
                    và tiến độ xử lý đơn hàng, Quý khách hàng có thể truy cập <a target="_blank" rel="nofollow"
                        href="/tai-khoan/don-hang-cua-toi"><span style="color:rgba(173,24,29,1);"><strong>Tại
                                đây</strong></span></a>.</p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">10. Sản phẩm mới
                        mua về bị lỗi không sử dụng được thì liên hệ ai để xử lý nhanh mà không bị mất thời gian di
                        chuyển nhiều lần?</span>
                    <o:p></o:p>
                </h2>
                <p>Khách hàng có thể mang máy đến tại các cửa hàng
                    PhatShop trên toàn quốc cũng như các trung tâm bảo hành chính hãng sản phẩm nơi gần nhà khách
                    hàng nhất.<o:p></o:p>
                </p>
                <p>Khách hàng có thể truy cập <a target="_blank" rel="nofollow" href="/cua-hang"><span
                            style="color:rgba(173,24,29,1);"><strong>Tại
                                đây</strong></span></a> để tìm kiếm địa chỉ cửa hàng PhatShop gần nhất.</p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">11. Làm thế nào
                        để tra cứu về hóa đơn đã mua hàng tại PhatShop?</span>
                    <o:p></o:p>
                </h2>
                <p>Quý khách thực hiện tra cứu <a target="_blank" rel="nofollow" href="https://hddt.Phatshop.com.vn/"><span
                            style="color:rgba(173,24,29,1);"><strong>Tại
                                đây</strong></span></a>.</p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">12. Cần hướng dẫn
                        vấn đề điều chỉnh hoặc xuất lại hóa đơn do bị sai thông tin khách hàng?</span>
                    <o:p></o:p>
                </h2>
                <p>Quý khách vui lòng liên hệ tổng đài 1800.6616 để
                    gặp điện thoại viên tư vấn hỗ trợ hoặc Quý khách tham khảo qua hướng dẫn <a target="_blank"
                        rel="nofollow" href="https://hddt.Phatshop.com.vn/bien-ban-huy"><span
                            style="color:rgba(173,24,29,1);"><strong>Tại đây</strong></span></a>
                    <o:p></o:p>nếu liên quan đến hóa đơn công ty.
                </p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">13. Điện thoại
                        mua tại PhatShop bị lỗi và gửi đi bảo hành nhưng muốn mượn một máy khác để dùng trong thời
                        gian chờ bảo hành thì có được không và liên hệ đến ai để hỗ trợ vấn đề này?</span>
                    <o:p></o:p>
                </h2>
                <p PhatShop sẽ hỗ trợ cho khách hàng mượn điện thoại khác sử dụng theo quy định của công ty, mời Quý khách
                    liên hệ tại cửa hàng PhatShop nơi khách hàng gửi máy đi bảo hành để được tư vấn hỗ trợ.</p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">14. Muốn thanh
                        toán tiền thu hộ qua kênh online thì thực hiện bằng cách nào?</span>
                    <o:p></o:p>
                </h2>
                <p>Quý khách thực hiện truy cập <a target="_blank" rel="nofollow" href="/dich-vu"><span
                            style="color:rgba(173,24,29,1);"><strong>Tại
                                đây</strong></span></a> vào đường dẫn sau để thực hiện thanh toán.</p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">15. Cần tra cứu
                        điểm mua hàng tại PhatShop đã tích điểm được bao nhiêu thì xem ở đâu?</span>
                    <o:p></o:p>
                </h2>
                <p>Quý khách thực hiện tra cứu <a target="_blank" rel="nofollow" href="/tai-khoan/lich-su-tich-diem"><span
                            style="color:rgba(173,24,29,1);"><strong>Tại
                                đây</strong></span></a> và đăng nhập số
                    điện thoại mua hàng của Quý khách.</p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">16. Muốn cập nhật
                        máy Apple có thời gian bảo hành không đúng hoặc chưa kích hoạt bảo hành trên hệ thống
                        Website của Apple thì làm thế nào?</span>
                    <o:p></o:p>
                </h2>
                <p>Quý khách vui lòng chờ thêm và kiểm tra lại thông
                    tin bảo hành sau 72h kể từ khi kích hoạt máy (không tính lễ, Tết, Thứ 7, CN). Nếu sau thời gian
                    này vẫn chưa cập nhật thời gian bảo hành thì Quý khách vui lòng liên hệ tổng đài 1800.6616 để
                    gặp tổng đài viên hỗ trợ.</p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">17. Cách tra cứu
                        về thông tin trúng thưởng của PhatShop khi tham gia các chương trình mini game?</span>
                    <o:p></o:p>
                </h2>
                <p>Quý khách thực hiện tra cứu <a target="_blank" rel="nofollow"
                        href="/khuyen-mai/thong-tin-trao-thuong"><span style="color:rgba(173,24,29,1);"><strong>Tại
                                đây</strong></span></a>.</p>
                <p>&nbsp;</p>
                <p>
                    <o:p></o:p>
                </p>
                <p>
                    <o:p></o:p>
                </p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">18. Máy gửi đi
                        sửa dịch vụ và đã nhận thông tin báo phí nhưng muốn thanh toán phí online thì thực hiện bằng
                        cách nào?</span>
                    <o:p></o:p>
                </h2>
                <p>Quý khách vui lòng liên hệ tổng đài 1800.6616 để
                    gặp điện thoại viên tư vấn hỗ trợ.</p>
                <p>&nbsp;</p>
                <h2 style="margin-top: -50px;"><span style="font-size:18px;">19. </span>
                    <o:p></o:p><span style="font-size:18px;">Phụ kiện nhập khẩu Apple đã hết hạn bảo hành và muốn
                        gửi sửa chữa dịch vụ tại PhatShop thì có được không?</span>
                    <o:p></o:p>
                </h2>
                <p>Đối với Phụ kiện nhập khẩu nếu Quý khách có nhu
                    cầu gửi hãng để làm dịch vụ PhatShop tiếp nhận sản phẩm gửi về TTBH kiểm tra, có chi phí báo lại
                    Quý khách sau.<o:p></o:p>
                </p>
            </div>
        </div>
    </section>
@endsection
