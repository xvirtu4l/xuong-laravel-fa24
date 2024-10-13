@extends('master')

@section('title')
    Cập nhật nhân viên
@endsection

@section('content')
    <div class="container">
        <h1>Cập nhật nhân viên</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form cập nhật nhân viên -->
        <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Tên -->
            <div class="mb-3">
                <label for="first_name" class="form-label">Tên</label>
                <input type="text" class="form-control" name="first_name" id="first_name"
                    value="{{ old('first_name', $employee->first_name) }}" required>
            </div>

            <!-- Họ -->
            <div class="mb-3">
                <label for="last_name" class="form-label">Họ</label>
                <input type="text" class="form-control" name="last_name" id="last_name"
                    value="{{ old('last_name', $employee->last_name) }}" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email"
                    value="{{ old('email', $employee->email) }}" required>
            </div>

            <!-- Số điện thoại -->
            <div class="mb-3">
                <label for="phone" class="form-label">Số điện thoại</label>
                <input type="text" class="form-control" name="phone" id="phone"
                    value="{{ old('phone', $employee->phone) }}">
            </div>

            <!-- Lương -->
            <div class="mb-3">
                <label for="salary" class="form-label">Lương</label>
                <input type="number" class="form-control" name="salary" id="salary" step="0.01"
                    value="{{ old('salary', $employee->salary) }}">
            </div>

            <!-- Trạng thái hoạt động -->
            <div class="mb-3">
                <label for="is_active" class="form-label">Trạng thái hoạt động</label>
                <input type="checkbox" class="form-check" name="is_active" id="is_active" value="1"
                    {{ old('is_active', $employee->is_active) ? 'checked' : '' }}>
            </div>

            <!-- Dropdown Phòng Ban -->
            <div class="mb-3">
                <label for="department_id" class="form-label">Chọn Phòng Ban</label>
                <select class="form-select" name="department_id" id="department_id" onchange="filterManagers()">
                    <option value="">Chọn phòng ban</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}"
                            {{ old('department_id', $selectedDepartmentId) == $department->id ? 'selected' : '' }}>
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
                            {{ old('manager_id', $employee->manager_id) == $manager->id ? 'selected' : '' }}>
                            {{ $manager->first_name }} {{ $manager->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>



            <!-- Địa chỉ -->
            <div class="mb-3">
                <label for="address" class="form-label">Địa chỉ</label>
                <textarea class="form-control" name="address" id="address">{{ old('address', $employee->address) }}</textarea>
            </div>

            <!-- Ảnh đại diện -->
            <div class="mb-3">
                <label for="profile_picture" class="form-label">Ảnh đại diện</label>
                <input type="file" class="form-control" name="profile_picture" id="profile_picture">
                @if ($employee->profile_picture)
                    <img src="data:image/jpeg;base64,{{ base64_encode($employee->profile_picture) }}" width="100px"
                        alt="Profile Picture">
                @endif
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">Cập nhật nhân viên</button>
                <a class="btn btn-secondary" href=" {{ route('employees.index') }} " role="button">Quay về</a>
            </div>

        </form>

        <!-- Script để reload trang khi chọn phòng ban -->
        <script>
            function filterManagers() {
                var departmentId = document.getElementById('department_id').value;
                window.location.href = "{{ route('employees.edit', $employee->id) }}" + "?department_id=" + departmentId;
            }
        </script>
    </div>
@endsection
