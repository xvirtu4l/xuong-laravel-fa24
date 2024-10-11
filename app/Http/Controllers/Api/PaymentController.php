<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function startTransaction(Request $request)
    {
        $amount = $request->input('amount');
        $targetAccount = $request->input('target_account');

        $transaction = [
            'amount' => $amount,
            'target_account' => $targetAccount,
            'status' => 'in_progress',
            'steps_completed' => 0
        ];

        session(['transaction' => $transaction]);

        return response()->json(['message' => 'Transaction started!', 'transaction' => $transaction]);
    }

    // Cập nhật phiên giao dịch
    public function updateTransaction(Request $request)
    {
        if (session()->has('transaction')) {
            $transaction = session('transaction');
            $transaction['steps_completed'] += 1;

            session(['transaction' => $transaction]);

            return response()->json(['message' => 'Transaction updated!', 'transaction' => $transaction]);
        } else {
            return response()->json(['message' => 'No transaction found!'], 404);
        }
    }

    // Hoàn thành giao dịch
    public function completeTransaction()
    {
        if (session()->has('transaction')) {
            $transaction = session('transaction');

            // Giả sử lưu thông tin giao dịch vào database (cần thêm model Transaction)
            // Transaction::create($transaction);

            session()->forget('transaction');

            return response()->json(['message' => 'Transaction completed!']);
        } else {
            return response()->json(['message' => 'No transaction found!'], 404);
        }
    }

    // Hủy giao dịch
    public function cancelTransaction()
    {
        if (session()->has('transaction')) {
            session()->forget('transaction');
            return response()->json(['message' => 'Transaction cancelled!']);
        } else {
            return response()->json(['message' => 'No transaction found!'], 404);
        }
    }
}
