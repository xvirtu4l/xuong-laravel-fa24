@extends('master')

@section('title')
    Cập nhật sinh viên
@endsection

@section('content')
    <div class="container">
        <h1>Cập nhật sinh viên</h1>

        @if (session()->has('success') && !session()->get('success'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif

        @if (session()->has('success') && session()->get('success'))
            <div class="alert alert-success">
                Thao tác thành công
            </div>
        @endif

        <!-- Form POST để cập nhật sinh viên -->
        <form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Method spoofing for PUT request -->
            <div class="mb-3">
                <label for="name" class="form-label">Tên sinh viên</label>
                <input type="text" class="form-control" name="name" id="name"
                    value="{{ old('name', $student->name) }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email"
                    value="{{ old('email', $student->email) }}" required>
            </div>
            <div class="mb-3">
                <label for="classroom_id" class="form-label">Chọn lớp học</label>
                <select class="form-select" name="classroom_id" id="classroom_id" required>
                    <option value="">Chọn lớp học</option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}"
                            {{ $student->classroom_id == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="passport_number" class="form-label">Số hộ chiếu</label>
                <input type="text" class="form-control" name="passport_number" id="passport_number"
                    value="{{ old('passport_number', $student->passport->passport_number ?? '') }}">
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật sinh viên</button>
            <a class="btn btn-secondary" href="{{ route('students.index') }}" role="button">Quay về</a>
        </form>
    </div>
@endsection
