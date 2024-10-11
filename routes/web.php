<?php

use App\Http\Controllers\EmployeeController;
use App\Models\Expense;
use App\Models\Financial_report;
use App\Models\Sale;
use App\Models\Tax;
use App\Models\users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {

//     // $users = DB::table('users')->get();

//     // foreach ($users as $user) {
//     //     dd($user->name);
//     // }

//     $query = DB::table('users');

//     $first = $query->first();

//     // dd($first);

//     return view('welcome');
// });

// Route::get('buoi1', function() {


// });


// Route::get('buoi2', function () {

//     $cau1 = Sale::select(
//         DB::raw("SUM(total) as total_sales, EXTRACT(MONTH FROM sale_date) as sale_month, EXTRACT(YEAR FROM sale_date) as sale_year")
//     )
//         ->groupBy(
//             DB::raw("EXTRACT(MONTH FROM sale_date)"),
//             DB::raw("EXTRACT(YEAR FROM sale_date)")
//         )->get();
//     // dd($cau1->toRawSql());

//     $cau2 = Expense::select(DB::raw("SUM(amount) as total_expenses, EXTRACT(MONTH FROM expense_date) as sale_month, EXTRACT(YEAR FROM expense_date) as sale_year"))
//         ->groupBy(
//             DB::raw("EXTRACT(MONTH FROM expense_date)"),
//             DB::raw("EXTRACT(YEAR FROM expense_date)")
//         )->get();
//     // dd($cau2->toRawSql());



//     $year = 2024;
//     $month = 9;
//     $totalSales = Sale::whereMonth('sale_date', $month)
//         ->whereYear('sale_date', $year)
//         ->sum('total');

//     $totalExpenses = Expense::whereMonth('expense_date', $month)
//         ->whereYear('expense_date', $year)
//         ->sum('amount');

//     $profitBeforeTax = $totalSales - $totalExpenses;

//     $vatRate = Tax::where('tax_name', 'VAT')->value('rate');

//     $taxAmount = $profitBeforeTax * ($vatRate / 100);

//     $profitAfterTax = $profitBeforeTax - $taxAmount;

//     $cau3 = Financial_report::create([
//         'month' => $month,
//         'year' => $year,
//         'total_sales' => $totalSales,
//         'total_expenses' => $totalExpenses,
//         'profit_before_tax' => $profitBeforeTax,
//         'tax_amount' => $taxAmount,
//         'profit_after_tax' => $profitAfterTax,
//     ]);

//     return view('welcome');
// });

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Route::group(['middleware' => 'RoleMiddleware'], function () {
    Route::resource('employees', EmployeeController::class);
    Route::delete('employees/{employee}/forceDestroy', [EmployeeController::class, 'forceDestroy'])->name('employees.forceDestroy');
});


Route::get('/movies', function () {
    return view('movies');
})->middleware('checkAge');
