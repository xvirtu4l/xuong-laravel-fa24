@extends('master')

@section('title')
    Welcome!
@endsection

@section('content')
    <h1>Thông tin lớp có id là: {{ $classroom->id }}

        

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
                @foreach ($classroom->toArray() as $key => $value)
                    <tr>
                        <td scope="row">{{ strtoupper($key) }}</td>
                            
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center">
            <a class="btn btn-primary" href=" {{ route('classrooms.index') }} " role="button">Quay về</a>
        </div>
    </div>
@endsection
