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
        <form action="{{ route('subjects.update', $subject->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Method spoofing for PUT request -->
            <div class="mb-3">
                <label for="name" class="form-label">Tên môn học</label>
                <input type="text" class="form-control" name="name" id="name"
                    value="{{ old('name', $subject->name) }}" required>
            </div>
            <div class="mb-3">
                <label for="credits" class="form-label">Số tín chỉ</label>
                <input type="credits" class="form-control" name="credits" id="credits"
                    value="{{ old('credits', $subject->credits) }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a class="btn btn-secondary" href="{{ route('subjects.index') }}" role="button">Quay về</a>
        </form>
    </div>
@endsection
