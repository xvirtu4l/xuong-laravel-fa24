@extends('master')

@section('title')
    Danh sách lớp học
@endsection

@section('content')
    <h1>
        Danh sách lớp học

        <a class="btn btn-success" href="{{ route('classrooms.create') }}">Thêm mới</a>

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
                    <th scope="col">Name</th>
                    <th scope="col">Teacher Name</th>
                    <th scope="col">created_at</th>
                    <th scope="col">updated_at</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $classroom)
                    <tr>
                        <td>{{ $classroom->id }}</td>
                        <td>{{ $classroom->name }}</td>
                        <td>{{ $classroom->teacher_name }}</td>
                        <td>{{ $classroom->created_at }}</td>
                        <td>{{ $classroom->updated_at }}</td>

                        <td>
                            {{-- TO-DO Action --}}
                            <a class="btn btn-secondary" href="{{ route('classrooms.show', $classroom) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('classrooms.edit', $classroom) }}">Edit</a>
                            <form action="{{ route('classrooms.destroy', $classroom) }}" method="post"
                                style="display: inline;">
                                {{-- Xoá mềm --}}
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
