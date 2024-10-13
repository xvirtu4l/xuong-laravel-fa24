@extends('master')

@section('title')
    Thông tin sinh viên
@endsection

@section('content')
    <h1>Thông tin sinh viên có id là: {{ $student->id }}

        

    </h1>

    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">Tên trường</th>
                    <th scope="col">Giá trị</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($student->toArray() as $key => $value)
                <tr>
                    <td scope="row">{{ strtoupper($key) }}</td>
                    <td>
                        @if (is_array($value))
                            {{ implode(', ', $value) }}
                        @else
                            {{ $value }}
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center">
            <a class="btn btn-primary" href=" {{ route('students.index') }} " role="button">Quay về</a>
        </div>
    </div>
@endsection
