<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;

    class TransactionController extends Controller
    {
        public function index()
    {
        // Ambil data transaksi bergabung dengan tabel categories
        $transactions = DB::table('transactions')
        ->join('categories', 'transactions.category_id', '=', 'categories.id')
        ->select(
            'transactions.date',
            'categories.name as category_name', // Ambil kolom name sebagai category_name
            'transactions.amount',
            'categories.icon', // Ambil kolom icon
            'categories.icon', // Ambil kolom icon
            'transactions.type', // Tambahkan kolom type
            'transactions.note' // Tambahkan kolom note
        )
        ->orderBy('transactions.date', 'desc') // Urutkan berdasarkan tanggal
        ->get();

        return response()->json($transactions); // Kembalikan data sebagai JSON

        
    }

    }
