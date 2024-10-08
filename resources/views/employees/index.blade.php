@extends('master')

@section('title')
    Danh sách nhân viên
@endsection

@section('content')
    <h1>Danh sách nhân viên</h1>

    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">first name</th>
                    <th scope="col">last name</th>
                    <th scope="col">email</th>
                    <th scope="col">phone</th>
                    <th scope="col">date_of_birth</th>
                    <th scope="col">hire_date</th>
                    <th scope="col">salary</th>
                    <th scope="col">is_active</th>
                    <th scope="col">department_id </th>
                    <th scope="col">manager_id </th>
                    <th scope="col">address</th>
                    <th scope="col">profile_picture</th>
                    <th scope="col">deleted_at</th>
                    <th scope="col">created_at</th>
                    <th scope="col">updated_at</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $employee)
                    <tr>
                        <td>{{ $employee->id }}</td>
                        <td>{{ $employee->first_name }}</td>
                        <td>{{ $employee->last_name }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->phone }}</td>
                        <td>{{ $employee->date_of_birth }}</td>
                        <td>{{ $employee->hire_date }}</td>
                        <td>{{ $employee->salary }}</td>
                        <td>

                            @if ($employee->is_active)
                                <span class="badge bg-primary">YES</span>
                            @else
                                <span class="badge bg-danger">NO</span>
                            @endif
                        </td>
                        <td>{{ $employee->department_id }}</td>
                        <td>{{ $employee->manager_id }}</td>
                        <td>{{ $employee->address }}</td>

                        <td>
                            @if ($employee->profile_picture)
                                <img src="{{ Storage::url($employee->profile_picture) }}" width="100px">
                            @endif
                        </td>

                        <td>{{ $employee->deleted_at }}</td>
                        <td>{{ $employee->created_at }}</td>
                        <td>{{ $employee->updated_at }}</td>

                        <td>
                            {{-- TO-DO Action --}}
                            <a class="btn btn-primary" href="{{ route('employees.show', $employee) }}">Show</a>
                            <a class="btn btn-primary" href="{{ route('employees.edit', $employee) }}">Edit</a>
                            <a class="btn btn-primary" href="#">Soft Delete</a>
                            <a class="btn btn-primary" href="#">Force Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
