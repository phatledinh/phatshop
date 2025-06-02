@extends('admin.layouts.main')

@section('content')
    <main>
        <div class="container-fluid px-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Danh sách danh mục
                    <a href="{{ route('categories.create') }}" class="btn btn-primary float-end">Thêm danh mục</a>
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
                                        @if ($category->thumbnail)
                                            <img src="{{ asset($category->thumbnail) }}" alt=""
                                                style="width: 60px; height: 80px; object-fit: contain;" />
                                        @else
                                            <span>Không có ảnh</span>
                                        @endif
                                    </td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->parent ? $category->parent->name : 'Không có' }}</td>
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <a href="{{ route('categories.edit', $category->id) }}"
                                                class="btn btn-warning text-white ms-2">
                                                <i class="fa-solid fa-user-pen"></i> Sửa
                                            </a>
                                            <button type="button" class="btn btn-danger ms-2 delete-btn"
                                                data-id="{{ $category->id }}" data-name="{{ $category->name }}"
                                                data-url="{{ route('categories.destroy', $category->id) }}">
                                                <i class="fa-solid fa-trash-can"></i> Xóa
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

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('click', function(e) {
            const button = e.target.closest('.delete-btn');
            if (!button) return;

            const categoryId = button.getAttribute('data-id');
            const categoryName = button.getAttribute('data-name');
            const deleteUrl = button.getAttribute('data-url');

            Swal.fire({
                title: 'Xác nhận xóa',
                html: `Bạn có chắc chắn muốn xóa danh mục <strong>${categoryName}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Có, xóa!',
                cancelButtonText: 'Hủy',
                buttonsStyling: false,
                customClass: {
                    confirmButton: 'btn btn-danger me-2',
                    cancelButton: 'btn btn-secondary'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(deleteUrl, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Thành công!',
                                    text: 'Danh mục đã được xóa thành công.',
                                    icon: 'success',
                                    confirmButtonText: 'OK',
                                    buttonsStyling: false,
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    }
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire({
                                    title: 'Lỗi!',
                                    text: data.message || 'Xóa danh mục thất bại!',
                                    icon: 'error',
                                    confirmButtonText: 'OK',
                                    buttonsStyling: false,
                                    customClass: {
                                        confirmButton: 'btn btn-primary'
                                    }
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi:', error);
                            Swal.fire({
                                title: 'Lỗi!',
                                text: 'Đã xảy ra lỗi khi xóa danh mục!',
                                icon: 'error',
                                confirmButtonText: 'OK',
                                buttonsStyling: false,
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                }
                            });
                        });
                }
            });
        });
    </script>
@endsection
