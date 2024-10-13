@extends('master')

@section('title')
    Welcome!
@endsection

@section('content')
    <h1>Thông tin môn học có id là: {{ $subject->id }}

        

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
                @foreach ($subject->toArray() as $key => $value)
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
            <a class="btn btn-primary" href="{{ route('subjects.index') }}" role="button">Quay về</a>
        </div>
    </div>
@endsection
