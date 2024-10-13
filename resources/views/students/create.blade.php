@extends('master')

@section('title')
    Thêm mới sinh viên
@endsection

@section('content')
    <div class="container">
        <h1>Thêm mới sinh viên</h1>

        @if (session()->has('success') && !session()->get('success'))
            <div class="alert alert-danger">
                {{ session()->get('error') }}
            </div>
        @endif


        <style>
            input[type="number"]::-webkit-inner-spin-button,
            input[type="number"]::-webkit-outer-spin-button {
                -webkit-appearance: none;
                margin: 0;
            }
        </style>

        <!-- Form POST để thêm sinh viên -->
        <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Tên sinh viên</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}"
                    required>
            </div>
            <div class="mb-3">
                <label for="classroom_id" class="form-label">Chọn lớp học</label>
                <select class="form-select" name="classroom_id" id="classroom_id" required>
                    <option value="">Chọn lớp học</option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="passport_number" class="form-label">Số hộ chiếu</label>
                <input type="number" class="form-control" name="passport_number" id="passport_number"
                    value="{{ old('passport_number') }}" required>
            </div>

            <div class="mb-3">
                <label for="issue_date" class="form-label">Ngày cấp hộ chiếu</label>
                <input type="date" class="form-control" name="issue_date" id="issue_date" value="{{ old('issue_date') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="expiry_date" class="form-label">Ngày hết hạn hộ chiếu</label>
                <input type="date" class="form-control" name="expiry_date" id="expiry_date"
                    value="{{ old('expiry_date') }}" required>
            </div>

            <button type="submit" class="btn btn-success">Thêm mới</button>
            <a class="btn btn-secondary" href="{{ route('students.index') }}" role="button">Quay về</a>
        </form>
    </div>
@endsection
