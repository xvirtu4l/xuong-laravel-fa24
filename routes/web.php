<?php

use App\Http\Controllers\EmployeeController;
use App\Models\Expense;
use App\Models\Financial_report;
use App\Models\Sale;
use App\Models\Tax;
use App\Models\users;
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

Route::get('/', function () {

    // $users = DB::table('users')->get();

    // foreach ($users as $user) {
    //     dd($user->name);
    // }

    $query = DB::table('users');

    $first = $query->first();

    // dd($first);

    return view('welcome');
});

// Route::get('buoi1', function() {

//         $bai1 = DB::table('users as u')
//         ->join('orders as o', 'u.id', 'o.user_id')
//         ->select('u.name', DB::raw("SUM(o.amount) as total_spent"))
//         ->groupBy('u.name')
//         ->having('total_spent', '>', 1000);



//         $bai2 = DB::table('orders')
//         ->select(
//             DB::raw("DATE(order_date) as date"),
//             DB::raw("COUNT(*) as order_count"),
//             DB::raw("SUM(total_amount) as total_sales")
//         )
//         ->whereBetween('order_date', ['2024-01-01', '2024-09-30'])
//         ->groupByRaw('DATE(order_date)');


//         $bai3 = DB::table('products as p')
//         ->select('product_name')
//         ->whereRaw('NOT EXISTS (SELECT 1 FROM order as o WHERE o.product_id = p.id)');



//         $cte = DB::table('sales')
//         ->select('product_id', DB::raw("SUM(quantity) as total_sold"))
//         ->groupBy('product_id');

//         $bai4 = DB::table('products as p')
//         ->joinSub($cte, 's', function($join){
//             $join->on('p.id', 's.product_id');
//         })
//         ->select('p.product_name', 's.total_sold')
//         ->where('s.total_sold', '>', 100);


//         $bai5 = DB::table('users')
//         ->join('orders', 'users.id', 'orders.user_id')
//         ->join('order_items', 'orders.id', 'order_items.order_id')
//         ->join('products', 'order_items.product_id', 'products.id')
//         ->select('users.name', 'products.product_name', 'orders.order_date')
//         ->where('order_date', '>=', DB::raw("NOW() - INTERVAL 30 DAY"));

//         $bai6 = DB::table('orders')
//         ->join('order_items', 'orders.id', 'order_items.order_id')
//         ->selectRaw(
//             "DATE_FORMAT(orders.order_date, '%Y-%m') as order_month, SUM(order_items.quantity * order_items.price) as total_revenue")
//         ->where('orders.status', 'completed')
//         ->groupBy('order_month')
//         ->orderByDesc('order_month');

//         $bai7 = DB::table('products')
//         ->leftJoin('order_items', 'products.id', 'order_items.product_id')
//         ->select('products.product_name')
//         ->whereNull('order_items.product_id');

//         $sub = DB::table('order_items')
//         ->select('product_id', DB::raw("SUM(quantity * price) as total"))
//         ->groupBy('product_id') ;

//         $bai8 = DB::table('products as p')
//         ->joinSub($sub, 'oi', function($join){
//             $join->on('p.id', 'oi.product_id');
//         })
//         ->select('p.category_id', 'p.product_name', DB::raw("MAX(oi.total) as max_revenue"))
//         ->groupBy('p.category_id', 'p.product_name')
//         ->orderByDesc('max_revenue');

//         $bai9 = DB::table('orders')
//         ->join('users', 'users.id', 'orders.user_id')
//         ->join('order_items', 'orders.id', 'order_items.order_id')
//         ->select('orders.id', 'users.name', 'orders.order_date', DB::raw("SUM(order_items.quantity * order_items.price) as total_value"))
//         ->groupBy('orders.id', 'users.name', 'orders.order_date')
//         ->havingRaw('total_value > (SELECT AVG(total) FROM (SELECT SUM(quantity * price) AS total FROM order_items GROUP BY order_id) AS avg_order_value)');


//         $sub2 = DB::table('order_items')
//         ->join('products', 'order_items.product_id', 'products.id')
//         ->select('products.product_name', DB::raw("SUM(quantity) as total_sold"))
//         ->whereRaw('products.category_id = p.category_id')
//         ->groupBy('products.product_name');

//         $combine = DB::table(DB::raw("({$sub2->toSql()}) as sub"))
//         ->select(DB::raw("MAX(sub.total_sold)"));

//         $bai10 = DB::table('products as p')
//         ->join('order_items as oi', 'p.id', 'oi.product_id')
//         ->select('p.category_id', 'p.product_name', DB::raw("SUM(oi.quantity) as total_sold"))
//         ->groupBy('p.category_id', 'p.product_name')
//         ->havingRaw("total_sold = ({$combine->toSql()})");


//         dd($bai10->toRawSql());
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

Route::resource('employees', EmployeeController::class);
Route::delete('employees/{employee}/forceDestroy', [EmployeeController::class, 'forceDestroy'])->name('employees.forceDestroy');    

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
