<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
{
    $transactions = DB::table('transactions')
        ->join('categories', 'transactions.category_id', '=', 'categories.id')
        ->select('transactions.date', 'transactions.description', 'transactions.amount', 'categories.icon')
        ->orderBy('transactions.date', 'desc') // Urutkan berdasarkan tanggal
        ->get();

    return response()->json($transactions);
}

}
