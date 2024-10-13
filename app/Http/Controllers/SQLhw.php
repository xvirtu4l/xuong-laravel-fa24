<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SQLhw extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bai1 = DB::table('users as u')
        ->join('orders as o', 'u.id', 'o.user_id')
        ->select('u.name', DB::raw("SUM(o.amount) as total_spent"))
        ->groupBy('u.name')
        ->having('total_spent', '>', 1000);



        $bai2 = DB::table('orders')
        ->select(
            DB::raw("DATE(order_date) as date"),
            DB::raw("COUNT(*) as order_count"),
            DB::raw("SUM(total_amount) as total_sales")
        )
        ->whereBetween('order_date', ['2024-01-01', '2024-09-30'])
        ->groupByRaw('DATE(order_date)');


        $bai3 = DB::table('products as p')
        ->select('product_name')
        ->whereRaw('NOT EXISTS (SELECT 1 FROM order as o WHERE o.product_id = p.id)');



        $cte = DB::table('sales')
        ->select('product_id', DB::raw("SUM(quantity) as total_sold"))
        ->groupBy('product_id');

        $bai4 = DB::table('products as p')
        ->joinSub($cte, 's', function($join){
            $join->on('p.id', 's.product_id');
        })
        ->select('p.product_name', 's.total_sold')
        ->where('s.total_sold', '>', 100);


        $bai5 = DB::table('users')
        ->join('orders', 'users.id', 'orders.user_id')
        ->join('order_items', 'orders.id', 'order_items.order_id')
        ->join('products', 'order_items.product_id', 'products.id')
        ->select('users.name', 'products.product_name', 'orders.order_date')
        ->where('order_date', '>=', DB::raw("NOW() - INTERVAL 30 DAY"));

        $bai6 = DB::table('orders')
        ->join('order_items', 'orders.id', 'order_items.order_id')
        ->selectRaw(
            "DATE_FORMAT(orders.order_date, '%Y-%m') as order_month, SUM(order_items.quantity * order_items.price) as total_revenue")
        ->where('orders.status', 'completed')
        ->groupBy('order_month')
        ->orderByDesc('order_month');

        $bai7 = DB::table('products')
        ->leftJoin('order_items', 'products.id', 'order_items.product_id')
        ->select('products.product_name')
        ->whereNull('order_items.product_id');

        $sub = DB::table('order_items')
        ->select('product_id', DB::raw("SUM(quantity * price) as total"))
        ->groupBy('product_id') ;

        $bai8 = DB::table('products as p')
        ->joinSub($sub, 'oi', function($join){
            $join->on('p.id', 'oi.product_id');
        })
        ->select('p.category_id', 'p.product_name', DB::raw("MAX(oi.total) as max_revenue"))
        ->groupBy('p.category_id', 'p.product_name')
        ->orderByDesc('max_revenue');

        $bai9 = DB::table('orders')
        ->join('users', 'users.id', 'orders.user_id')
        ->join('order_items', 'orders.id', 'order_items.order_id')
        ->select('orders.id', 'users.name', 'orders.order_date', DB::raw("SUM(order_items.quantity * order_items.price) as total_value"))
        ->groupBy('orders.id', 'users.name', 'orders.order_date')
        ->havingRaw('total_value > (SELECT AVG(total) FROM (SELECT SUM(quantity * price) AS total FROM order_items GROUP BY order_id) AS avg_order_value)');


        $sub2 = DB::table('order_items')
        ->join('products', 'order_items.product_id', 'products.id')
        ->select('products.product_name', DB::raw("SUM(quantity) as total_sold"))
        ->whereRaw('products.category_id = p.category_id')
        ->groupBy('products.product_name');

        $combine = DB::table(DB::raw("({$sub2->toSql()}) as sub"))
        ->select(DB::raw("MAX(sub.total_sold)"));

        $bai10 = DB::table('products as p')
        ->join('order_items as oi', 'p.id', 'oi.product_id')
        ->select('p.category_id', 'p.product_name', DB::raw("SUM(oi.quantity) as total_sold"))
        ->groupBy('p.category_id', 'p.product_name')
        ->havingRaw("total_sold = ({$combine->toSql()})");


        $queries = [
            'bai1' => $bai1->toSql(),
            'bai2' => $bai2->toSql(),
            'bai3' => $bai3->toSql(),
            'bai4' => $bai4->toSql(),
            'bai5' => $bai5->toSql(),
            'bai6' => $bai6->toSql(),
            'bai7' => $bai7->toSql(),
            'bai8' => $bai8->toSql(),
            'bai9' => $bai9->toSql(),
            'bai10' => $bai10->toSql(),
        ];
    
        // Truyền các câu truy vấn đến view
        return view('sql', compact('queries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
