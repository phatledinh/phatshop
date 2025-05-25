@extends('admin.layouts.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Danh sách danh mục
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ảnh</th>
                                <th>Tên danh mục</th>
                                <th>Danh mục cha</th>
                                <th>Tùy chọn</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>STT</th>
                                <th>Ảnh</th>
                                <th>Tên danh mục</th>
                                <th>Danh mục cha</th>
                                <th>Tùy chọn</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($categories as $index => $category)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <img src="{{ asset($category->thumbnail) }}" alt=""
                                            style="
                                                        width: 60px;
                                                        height: 80px;
                                                        object-fit: contain;
                                                    " />
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->parent ? $category->parent->name : 'Không có' }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <a href="editEmployee.html" class="btn btn-warning text-white"><i
                                                    class="fa-solid fa-user-pen"></i>
                                                Sửa</a>

                                            <button type="button" class="btn btn-danger ms-2">
                                                <i class="fa-solid fa-trash-can"></i>
                                                Xóa
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
