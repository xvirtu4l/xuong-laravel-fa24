@extends('master')

@section('title')
    Danh sách môn học
@endsection

@section('content')
    <h1>
        Danh sách môn học

        <a class="btn btn-success" href="{{ route('subjects.create') }}">Thêm mới</a>

    </h1>

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

    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Môn học</th>
                    <th scope="col">Số tín chỉ</th>
                    <th scope="col">created_at</th>
                    <th scope="col">updated_at</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $subject)
                    <tr>
                        <td>{{ $subject->id }}</td>
                        <td>{{ $subject->name }}</td>
                        <td>{{ $subject->credits }}</td>
                        <td>{{ $subject->created_at }}</td>
                        <td>{{ $subject->updated_at }}</td>

                        <td>
                            {{-- TO-DO Action --}}
                            <a class="btn btn-secondary" href="{{ route('subjects.show', $subject) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('subjects.edit', $subject) }}">Edit</a>

                            <form action="{{ route('subjects.destroy', $subject) }}" method="post"
                                style="display: inline;">
                                {{-- Xoá cứng --}}
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Are you sure?')">Xoá</button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $data->links() }}
    </div>
@endsection
