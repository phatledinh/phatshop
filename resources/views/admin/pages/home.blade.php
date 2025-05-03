@extends('admin.layouts.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row mb-4">
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card board1 fill1">
                        <div class="card-body bg-info d-flex align-items-center justify-content-between">
                            <div class="card_widget_header">
                                <label class="fw-bold fs-3">Khách hàng</label>
                                <h4>700</h4>
                            </div>
                            <div class="card_widget_img">
                                <i class="fa-solid fa-users fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card board1 fill2">
                        <div class="card-body bg-danger d-flex align-items-center justify-content-between">
                            <div class="card_widget_header">
                                <label class="fw-bold fs-3">Danh mục</label>
                                <h4>30</h4>
                            </div>
                            <div class="card_widget_img">
                                <i class="fa-solid fa-list fs-1"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card board1 fill3">
                        <div class="card-body bg-warning d-flex align-items-center justify-content-between">
                            <div class="card_widget_header">
                                <label class="fw-bold fs-3">Nghỉ phép</label>
                                <h4>9</h4>
                            </div>
                            <div class="card_widget_img">
                                <img src="assets/img/dash3.png" alt="card-img" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 col-12">
                    <div class="card board1 fill4">
                        <div class="card-body bg-success d-flex align-items-center justify-content-between">
                            <div class="card_widget_header">
                                <label class="fw-bold fs-3">Lương</label>
                                <h4>$5.8M</h4>
                            </div>
                            <div class="card_widget_img">
                                <img src="assets/img/dash4.png" alt="card-img" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Biểu đồ lượt truy cập theo ngày (Tháng
                            3)
                        </div>
                        <div class="card-body">
                            <canvas id="myAreaChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Biểu đồ Doanh thu theo Tháng (2024)
                        </div>
                        <div class="card-body">
                            <canvas id="myBarChart" width="100%" height="40"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Danh sách nhân viên
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Mã nhân viên</th>
                                <th>Ảnh</th>
                                <th>Tên nhân viên</th>
                                <th>Giới tính</th>
                                <th>Ngày sinh</th>
                                <th>Tuổi</th>
                                <th>Chức vụ</th>
                                <th>Phòng ban</th>
                                <th>Nơi sinh</th>
                                <th>CCCD</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>STT</th>
                                <th>Mã nhân viên</th>
                                <th>Ảnh</th>
                                <th>Tên nhân viên</th>
                                <th>Giới tính</th>
                                <th>Ngày sinh</th>
                                <th>Tuổi</th>
                                <th>Chức vụ</th>
                                <th>Phòng ban</th>
                                <th>Nơi sinh</th>
                                <th>CCCD</th>
                                <th>Trạng thái</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>MNV01</td>
                                <td>
                                    <img src="../dist/assets/img/nv-1.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Nguyễn Thị Lan</td>
                                <td>Nữ</td>
                                <td>01/01/1995</td>
                                <td>26</td>
                                <td>Nhân viên</td>
                                <td>Phòng Kinh doanh</td>
                                <td>Hà Nội</td>
                                <td>001204039991</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-danger">
                                        Đang làm việc
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>MNV02</td>
                                <td>
                                    <img src="../dist/assets/img/nv-2.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Trần Văn Minh</td>
                                <td>Nam</td>
                                <td>02/02/1994</td>
                                <td>27</td>
                                <td>Quản lý</td>
                                <td>Phòng Nhân sự</td>
                                <td>Hồ Chí Minh</td>
                                <td>001204039992</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-info">
                                        Đã nghỉ
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>MNV03</td>
                                <td>
                                    <img src="../dist/assets/img/nv-3.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Lê Thị Hương</td>
                                <td>Nữ</td>
                                <td>03/03/1993</td>
                                <td>28</td>
                                <td>Nhân viên</td>
                                <td>Phòng Kế toán</td>
                                <td>Đà Nẵng</td>
                                <td>001204039993</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-danger">
                                        Đang làm việc
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>MNV04</td>
                                <td>
                                    <img src="../dist/assets/img/nv-4.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Phạm Văn Dũng</td>
                                <td>Nam</td>
                                <td>04/04/1992</td>
                                <td>29</td>
                                <td>Quản lý</td>
                                <td>Phòng Marketing</td>
                                <td>Hải Phòng</td>
                                <td>001204039994</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-danger">
                                        Đang làm việc
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>5</td>
                                <td>MNV05</td>
                                <td>
                                    <img src="../dist/assets/img/nv-5.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Đỗ Thị Mai</td>
                                <td>Nữ</td>
                                <td>05/05/1991</td>
                                <td>30</td>
                                <td>Nhân viên</td>
                                <td>Phòng Tài chính</td>
                                <td>Cần Thơ</td>
                                <td>001204039995</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-danger">
                                        Đang làm việc
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>6</td>
                                <td>MNV06</td>
                                <td>
                                    <img src="../dist/assets/img/nv-6.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Ngô Văn Huy</td>
                                <td>Nam</td>
                                <td>06/06/1990</td>
                                <td>31</td>
                                <td>Nhân viên</td>
                                <td>Phòng Marketing</td>
                                <td>Nha Trang</td>
                                <td>001204039996</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-info">
                                        Đã nghỉ
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>7</td>
                                <td>MNV07</td>
                                <td>
                                    <img src="../dist/assets/img/nv-7.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Vũ Thị Ngọc</td>
                                <td>Nữ</td>
                                <td>07/07/1989</td>
                                <td>32</td>
                                <td>Nhân viên</td>
                                <td>Phòng Kinh doanh</td>
                                <td>Huế</td>
                                <td>001204039997</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-danger">
                                        Đang làm việc
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>8</td>
                                <td>MNV08</td>
                                <td>
                                    <img src="../dist/assets/img/nv-8.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Bùi Văn Lâm</td>
                                <td>Nam</td>
                                <td>08/08/1988</td>
                                <td>33</td>
                                <td>Quản lý</td>
                                <td>Phòng Tổ chức</td>
                                <td>Vũng Tàu</td>
                                <td>001204039998</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-info">
                                        Đã nghỉ
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>9</td>
                                <td>MNV09</td>
                                <td>
                                    <img src="../dist/assets/img/nv-9.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Hoàng Thị Thu</td>
                                <td>Nữ</td>
                                <td>09/09/1987</td>
                                <td>34</td>
                                <td>Nhân viên</td>
                                <td>Phòng Kinh doanh</td>
                                <td>Biên Hòa</td>
                                <td>001204039999</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-info">
                                        Đã nghỉ
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>10</td>
                                <td>MNV10</td>
                                <td>
                                    <img src="../dist/assets/img/nv-10.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Trịnh Văn Khoa</td>
                                <td>Nam</td>
                                <td>10/10/1986</td>
                                <td>35</td>
                                <td>Nhân viên</td>
                                <td>Phòng Kế toán</td>
                                <td>Buôn Ma Thuột</td>
                                <td>001204040000</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-danger">
                                        Đang làm việc
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>11</td>
                                <td>MNV11</td>
                                <td>
                                    <img src="../dist/assets/img/nv-11.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Nguyễn Thị Hòa</td>
                                <td>Nữ</td>
                                <td>11/11/1985</td>
                                <td>36</td>
                                <td>Nhân viên</td>
                                <td>Phòng Kế toán</td>
                                <td>Thái Nguyên</td>
                                <td>001204040001</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-danger">
                                        Đang làm việc
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>12</td>
                                <td>MNV12</td>
                                <td>
                                    <img src="../dist/assets/img/nv-12.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Phan Văn Quang</td>
                                <td>Nam</td>
                                <td>12/12/1984</td>
                                <td>37</td>
                                <td>Nhân viên</td>
                                <td>Phòng Kinh doanh</td>
                                <td>Hạ Long</td>
                                <td>001204040002</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-info">
                                        Đã nghỉ
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>13</td>
                                <td>MNV13</td>
                                <td>
                                    <img src="../dist/assets/img/nv-13.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Đặng Thị Tuyết</td>
                                <td>Nữ</td>
                                <td>13/01/1983</td>
                                <td>38</td>
                                <td>Quản lý</td>
                                <td>Phòng Nhân sự</td>
                                <td>Quy Nhơn</td>
                                <td>001204040003</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-danger">
                                        Đang làm việc
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>14</td>
                                <td>MNV14</td>
                                <td>
                                    <img src="../dist/assets/img/nv-14.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Mai Văn Phúc</td>
                                <td>Nam</td>
                                <td>14/02/1982</td>
                                <td>39</td>
                                <td>Nhân viên</td>
                                <td>Phòng Kế toán</td>
                                <td>Thanh Hóa</td>
                                <td>001204040004</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-danger">
                                        Đang làm việc
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>15</td>
                                <td>MNV15</td>
                                <td>
                                    <img src="../dist/assets/img/nv-15.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Trương Thị Yến</td>
                                <td>Nữ</td>
                                <td>15/03/1981</td>
                                <td>40</td>
                                <td>Quản lý</td>
                                <td>Phòng Marketing</td>
                                <td>Nam Định</td>
                                <td>001204040005</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-danger">
                                        Đang làm việc
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>16</td>
                                <td>MNV16</td>
                                <td>
                                    <img src="../dist/assets/img/nv-16.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Hồ Văn Long</td>
                                <td>Nam</td>
                                <td>16/04/1980</td>
                                <td>41</td>
                                <td>Nhân viên</td>
                                <td>Phòng Nhân sự</td>
                                <td>Ninh Bình</td>
                                <td>001204040006</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-info">
                                        Đã nghỉ
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>17</td>
                                <td>MNV17</td>
                                <td>
                                    <img src="../dist/assets/img/nv-17.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Nguyễn Thị Sen</td>
                                <td>Nữ</td>
                                <td>17/05/1979</td>
                                <td>42</td>
                                <td>Nhân viên</td>
                                <td>Phòng Kế toán</td>
                                <td>Lào Cai</td>
                                <td>001204040007</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-danger">
                                        Đang làm việc
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>18</td>
                                <td>MNV18</td>
                                <td>
                                    <img src="../dist/assets/img/nv-18.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Trần Văn Khánh</td>
                                <td>Nam</td>
                                <td>18/06/1978</td>
                                <td>43</td>
                                <td>Nhân viên</td>
                                <td>Phòng Kinh doanh</td>
                                <td>Vĩnh Long</td>
                                <td>001204040008</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-info">
                                        Đã nghỉ
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>19</td>
                                <td>MNV19</td>
                                <td>
                                    <img src="../dist/assets/img/nv-19.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Lý Thị Nhung</td>
                                <td>Nữ</td>
                                <td>19/07/1977</td>
                                <td>44</td>
                                <td>Nhân viên</td>
                                <td>Phòng Tài chính</td>
                                <td>Hưng Yên</td>
                                <td>001204040009</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-danger">
                                        Đang làm việc
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>20</td>
                                <td>MNV20</td>
                                <td>
                                    <img src="../dist/assets/img/nv-20.jpg" alt=""
                                        style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                </td>
                                <td>Phạm Văn Thái</td>
                                <td>Nam</td>
                                <td>20/08/1976</td>
                                <td>45</td>
                                <td>Nhân viên</td>
                                <td>Phòng Nhân sự</td>
                                <td>Long An</td>
                                <td>001204040010</td>
                                <td>
                                    <div
                                        class="rounded p-1 d-flex align-items-center justify-content-center text-white bg-info">
                                        Đã nghỉ
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/demo/chart-area-demo.js') }}"></script>
    <script src="{{ asset('js/demo/chart-bar-demo.js') }}"></script>
@endsection
