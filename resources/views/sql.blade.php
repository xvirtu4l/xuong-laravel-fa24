@extends('master')

@section('title')
    Các câu truy vấn
@endsection

@section('content')
    <h1>Các câu truy vấn SQL</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên Câu Truy Vấn</th>
                <th>Câu Truy Vấn SQL</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($queries as $key => $query)
                <tr>
                    <td>{{ $key }}</td>
                    <td><code>{{ $query }}</code></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
