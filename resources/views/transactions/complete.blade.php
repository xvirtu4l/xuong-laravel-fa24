@extends('master')

@section('title')
    Xác Nhận Giao Dịch
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h1>Giao dịch Hoàn tất</h1>
    </div>
    <div class="card-body">
        <p>Giao dịch của bạn đã được hoàn tất thành công.</p>
        <a href="{{ route('home') }}" class="btn btn-primary">Trở về trang chủ</a>
    </div>
</div>
@endsection
