@extends('master')

@section('title')
    Welcome!
@endsection

@section('content')
    <h1>Thông tin nhân viên có id là: {{ $employee->id }}

        

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
                @foreach ($employee->toArray() as $key => $value)
                    <tr>
                        <td scope="row">{{ strtoupper($key) }}</td>
                        <td>
                            @if ($key == 'profile_picture' && $value)
                                <img src="data:image/jpeg;base64,{{ base64_encode($value) }}" width="100px"
                                    alt="Profile Picture">
                            @elseif ($key == 'is_active')
                                {!! $value ? '<span class="badge bg-success">yes</span>' : '<span class="badge bg-danger">nah</span>' !!}
                            @else
                                {{ $value }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="text-center">
            <a class="btn btn-primary" href=" {{ route('employees.index') }} " role="button">Quay về</a>

            <form action="{{ route('employees.forceDestroy', $employee) }}" method="post" style="display:inline;">
                {{-- Xoá cứng --}}
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Xoá</button>
            </form>

            @if($employee->deleted_at)
                <form action="{{ route('employees.restore', $employee) }}" method="post" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-info" onclick="return confirm('Khôi phục bản ghi?')">Khôi phục</button>
                </form>
            @endif
        </div>
    </div>
@endsection
