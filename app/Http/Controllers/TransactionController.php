<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TransactionController extends Controller
{

    public function startTransaction(Request $request)
    {
        $request->session()->put('transaction', [
            'step' => 1,
            'data' => [
                'amount' => $request->input('amount'),
                'to_account' => $request->input('to_account'),
            ]
        ]);
        return view('transactions.step1');
    }

    public function confirmTransaction(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'to_account' => 'required|string',
        ]);
    
        // Lưu dữ liệu vào session
        $request->session()->put('transaction', [
            'step' => 2,
            'data' => [
                'amount' => number_format((float)$request->input('amount'), 2, '.', ''),
                'to_account' => $request->input('to_account'),
            ]
        ]);

        return view('transactions.confirm', [
            'transaction' => $request->session()->get('transaction')
        ]);
    }

    public function completeTransaction(Request $request)
    {
        $transaction = $request->session()->get('transaction');
        // Lưu vào cơ sở dữ liệu hoặc thực hiện các bước hoàn tất giao dịch
        DB::table('transactions')->insert([
            'amount' => $transaction['data']['amount'],
            'to_account' => $transaction['data']['to_account'],
            'status' => 'completed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Xóa thông tin giao dịch khỏi session
        $request->session()->forget('transaction');

        return view('transactions.complete');
    }

    public function cancelTransaction(Request $request)
    {
        $request->session()->forget('transaction');
        return redirect()->route('home')->with('message', 'Giao dịch đã bị hủy');
    }

}
