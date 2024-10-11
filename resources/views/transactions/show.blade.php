@extends('masters')

@section('title')
    Giao dịch
@endsection

@section('content')
    
<div class="card">
    <div class="card-header bg-primary text-white">
        <h3>Thông tin phiên giao dịch của bạn</h3>
    </div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item">
                <strong>Số tiền:</strong> {{ $transaction['amount'] }} VND
            </li>
            <li class="list-group-item">
                <strong>Tài khoản đích:</strong> {{ $transaction['target_account'] }}
            </li>
            <li class="list-group-item">
                <strong>Trạng thái:</strong> {{ $transaction['status'] }}
            </li>
            <li class="list-group-item">
                <strong>Số bước đã hoàn thành:</strong> {{ $transaction['steps_completed'] }}
            </li>
        </ul>
    </div>
    <div class="card-footer">
        <a href="/" class="btn btn-secondary">Trở về trang chủ</a>
    </div>
</div>

@endsection