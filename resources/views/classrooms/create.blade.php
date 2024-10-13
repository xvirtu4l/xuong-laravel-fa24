@extends('master')

@section('title')
    Thêm mới lớp học
@endsection

@section('content')
    <div class="container">
        <h1>Thêm mới lớp học</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form POST để thêm lớp học -->
        <form action="{{ route('classrooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tên lớp học</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="teacher_name" class="form-label">Giáo viên phụ trách</label>
                <input type="text" class="form-control" name="teacher_name" id="teacher_name"
                    value="{{ old('teacher_name') }}" required>
            </div>


            <div class="text-center">
                <button type="submit" class="btn btn-primary">Thêm lớp học</button>
                <a class="btn btn-primary" href=" {{ route('classrooms.index') }} " role="button">Quay về</a>
            </div>

        </form>

    </div>
@endsection
