@extends('master')

@section('title')
    Thêm mới nhân viên
@endsection

@section('content')
    <div class="container">
        <h1>Thêm mới nhân viên</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form POST để thêm nhân viên -->
        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="first_name" class="form-label">Tên</label>
                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name') }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Họ</label>
                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name') }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}">
            </div>
            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Ngày sinh</label>
                <input type="date" class="form-control" name="date_of_birth" id="date_of_birth"
                    value="{{ old('date_of_birth') }}">
            </div>
            <div class="mb-3">
                <label for="hire_date" class="form-label">Ngày vào làm</label>
                <input type="date" class="form-control" name="hire_date" id="hire_date" value="{{ old('hire_date') }}">
            </div>
            <div class="mb-3">
                <label for="salary" class="form-label">Lương</label>
                <input type="number" class="form-control" name="salary" id="salary" step="0.01"
                    value="{{ old('salary') }}">
            </div>
            <div class="mb-3">
                <label for="is_active" class="form-label">Trạng thái hoạt động</label>
                <input type="checkbox" class="form-check" name="is_active" id="is_active" value="1">
            </div>

            <!-- Dropdown Phòng Ban -->
            <div class="mb-3">
                <label for="department_id" class="form-label">Chọn Phòng Ban</label>
                <select class="form-select" name="department_id" id="department_id" onchange="filterManagers()">
                    <option value="">Chọn phòng ban</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}"
                            {{ old('department_id', request('department_id')) == $department->id ? 'selected' : '' }}>
                            {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Dropdown Quản Lý -->
            <div class="mb-3">
                <label for="manager_id" class="form-label">Chọn Quản Lý</label>
                <select class="form-select" name="manager_id" id="manager_id">
                    <option value="">Chọn quản lý</option>
                    @foreach ($managers as $manager)
                        <option value="{{ $manager->id }}"
                            {{ old('manager_id', request('manager_id')) == $manager->id ? 'selected' : '' }}>
                            {{ $manager->first_name }} {{ $manager->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ</label>
                <textarea class="form-control" name="address" id="address">{{ old('address') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Ảnh đại diện</label>
                <input type="file" class="form-control" name="profile_picture" id="profile_picture">
            </div>
            <button type="submit" class="btn btn-primary">Thêm nhân viên</button>
        </form>

        <script>
            function filterManagers() {
                var departmentId = document.getElementById('department_id').value;
                window.location.href = "{{ route('employees.create') }}" + "?department_id=" + departmentId;
            }
        </script>
    </div>
@endsection
