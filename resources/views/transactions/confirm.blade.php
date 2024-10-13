@extends('master')

@section('title')
    Xác Nhận Giao Dịch
@endsection

@section('content')
<div class="card">
    <div class="card">
        <div class="card-header">
            <h1>Xác nhận Giao dịch</h1>
        </div>
        <div class="card-body">
            <p><strong>Số tiền:</strong> {{ $transaction['data']['amount'] }}</p>
            <p><strong>Tài khoản đích:</strong> {{ $transaction['data']['to_account'] }}</p>
            <form action="{{ route('complete-transaction') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-success">Hoàn tất Giao dịch</button>
            </form>
            <form action="{{ route('cancel-transaction') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger">Hủy Giao dịch</button>
            </form>
        </div>
    </div>
</div>
@endsection
