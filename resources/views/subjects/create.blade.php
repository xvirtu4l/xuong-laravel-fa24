@extends('master')

@section('title')
    Thêm mới môn học
@endsection

@section('content')
    <div class="container">
        <h1>Thêm mới môn học</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form POST để thêm môn học -->
        <form action="{{ route('subjects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Tên môn học</label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="credits" class="form-label">Credits</label>
                <input type="number" min="1" class="form-control" name="credits" id="credits" value="{{ old('credits') }}" required>
            </div>
        

            <button type="submit" class="btn btn-success">Thêm mới</button>
            <a class="btn btn-secondary" href="{{ route('students.index') }}" role="button">Quay về</a>
        </form>
    </div>
@endsection