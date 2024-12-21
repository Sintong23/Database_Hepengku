<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function getExpenseData()
    {
        $expenses = DB::table('transactions')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->select(
                'categories.name as category_name',
                DB::raw('SUM(transactions.amount) as total') // Totalkan amount berdasarkan kategori
            )
            ->where('transactions.type', 'expense') // Hanya data pengeluaran
            ->groupBy('categories.name') // Kelompokkan berdasarkan nama kategori
            ->get();

        return response()->json($expenses); // Kembalikan data sebagai JSON
    }
}
