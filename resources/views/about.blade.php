@extends('layouts.main')

@section('content')
    <section class="about py-4">
        <div class="container">
            <x-breadcrumb-wrapper :breadcrumbs="[
                ['label' => 'Trang chủ', 'url' => route('home')],
                ['label' => 'Giới thiệu', 'url' => route('about')],
            ]" />
            <h3>Giới thiệu về PhatShop</h3>
            <img src="{{ asset('images/about-1.jpg') }}" alt="">
            <h4 class="py-2">1. Về chúng tôi</h4 class="py-2">
            <p>PhatShop là chuỗi chuyên bán lẻ các sản phẩm kỹ thuật số di động bao gồm điện thoại di động, máy tính bảng,
                laptop, phụ kiện và dịch vụ công nghệ… cùng các mặt hàng gia dụng, điện máy chính hãng, chất lượng cao đến
                từ các thương hiệu lớn, với mẫu mã đa dạng và mức giá tối ưu nhất cho khách hàng.</p>
            <p>PhatShop là hệ thống bán lẻ đầu tiên ở Việt Nam được cấp chứng chỉ ISO 9001:2000 về quản lý chất lượng theo
                tiêu chuẩn quốc tế. Hiện nay, PhatShop là chuỗi bán lẻ lớn thứ 2 trên thị trường bán lẻ hàng công nghệ.</p>
            <h4 class="py-2">2. Sứ mệnh</h4 class="py-2">
            <p>Hệ thống PhatShop kỳ vọng mang đến cho khách hàng những trải nghiệm mua sắm tốt nhất thông qua việc cung cấp
                các sản phẩm chính hãng, dịch vụ chuyên nghiệp cùng chính sách hậu mãi chu đáo. PhatShop không ngừng cải
                tiến và phát triển, hướng tới việc trở thành nhà bán lẻ công nghệ hàng đầu Việt Nam, đồng thời mang lại giá
                trị thiết thực cho cộng đồng.</p>
            <h4 class="py-2">3. Giá trị cốt lõi</h4 class="py-2">
            <img src="{{ asset('images/about-2.jpg') }}" alt="">
            <ul>
                <li>Chất lượng và Uy tín: PhatShop cam kết cung cấp các sản phẩm chính hãng, chất lượng cao với chính sách
                    bảo hành uy tín và dịch vụ chăm sóc khách hàng chu đáo, nhằm đem đến cho khách hàng sự an tâm tuyệt đối
                    khi mua sắm các sản phẩm công nghệ, điện máy - gia dụng.</li>
                <li>Khách hàng là trọng tâm: Phục vụ khách hàng luôn là ưu tiên số 1. PhatShop luôn chú trọng hoàn thiện
                    chất lượng dịch vụ, bồi dưỡng đội ngũ nhân viên nhiệt tình, trung thực, chân thành, mang lại lợi ích và
                    sự hài lòng tối đa cho khách hàng.</li>
                <li> Đổi mới và phát triển: PhatShop luôn cập nhật và đổi mới sản phẩm, công nghệ cũng như dịch vụ để đáp
                    ứng nhu cầu thay đổi liên tục của thị trường và khách hàng. </li>
                <li>Đồng hành cùng cộng đồng: PhatShop không chỉ tập trung vào phát triển kinh doanh mà còn chú trọng đến
                    các hoạt động xã hội, đóng góp tích cực cho sự phát triển của cộng đồng và xã hội.</li>
            </ul>
            <h4 class="py-2">4. Định hướng phát triển</h4 class="py-2">
            <p>Với mục tiêu “Tạo trải nghiệm xuất sắc cho khách hàng”, PhatShop tiếp tục đẩy mạnh chuyển đổi số để ứng dụng
                vào công tác bán hàng, quản lý và đào tạo nhân sự... theo chiến lược tận tâm phục vụ nhằm gia tăng trải
                nghiệm khách hàng. Đầu tư mạnh mẽ kinh doanh trực tuyến đa nền tảng, khai thác và ứng dụng công nghệ để thấu
                hiểu và tiếp cận khách hàng một cách linh hoạt và hiệu quả nhất, không ngừng khẳng định vị thế là một trong
                những thương hiệu bán lẻ uy tín tại Việt Nam.</p>
            <h4 class="py-2">5. Cột mốc phát triển</h4 class="py-2">
            <ul>
                <li>2013: PhatShop chính thức đạt mốc 100 cửa hàng.</li>
                <li>2014: Trở thành nhà nhập khẩu trực tiếp của iPhone chính hãng.</li>
                <li>2015: Đạt mức tăng trưởng nhanh nhất so với các công ty trực thuộc cùng Công ty Cổ phần FPT.</li>
                <li>2016: Doanh thu online tăng gấp đôi. Khai trương 80 khu trải nghiệm Apple corner trên toàn quốc.</li>
                <li>08/2024: Đồng loạt khai trương 10 cửa hàng điện máy trên toàn quốc, đánh dấu việc mở rộng lĩnh vực kinh
                    doanh sang điện máy, gia dụng.</li>
            </ul>
        </div>
    </section>
@endsection
