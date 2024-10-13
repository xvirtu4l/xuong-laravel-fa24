@extends('master')

@section('title')
    Bắt đầu giao dịch
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h1>Bắt đầu Giao dịch</h1>
    </div>
    <div class="card-body">
        <form action="{{ route('confirm-transaction') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="amount" class="form-label">Số tiền:</label>
                <input type="number" id="amount" name="amount" class="form-control" step="0.01" min="0" required>
            </div>
            <div class="mb-3">
                <label for="to_account" class="form-label">Tài khoản đích:</label>
                <input type="text" id="to_account" name="to_account" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Xác nhận</button>
        </form>
    </div>
</div>
@endsection
