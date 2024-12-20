<?php

    namespace App\Http\Controllers;

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use App\Models\Transaction;

    class TransactionController extends Controller
    {
        public function index()
    {
        // Ambil data transaksi bergabung dengan tabel categories
        $transactions = DB::table('transactions')
        ->join('categories', 'transactions.category_id', '=', 'categories.id')
        ->select(
            'transactions.id',
            'transactions.date',
            'categories.name as category_name', // Ambil kolom name sebagai category_name
            'transactions.amount',
            'categories.icon', // Ambil kolom icon
            'transactions.type', // Tambahkan kolom type
            'transactions.note' // Tambahkan kolom note
        )
        ->orderBy('transactions.date', 'desc') // Urutkan berdasarkan tanggal
        ->get();

        return response()->json($transactions); // Kembalikan data sebagai JSON

        

        
    }

    public function updateAmount(Request $request, $id)
    {
        $request->validate([
            'amount' => 'required|integer|min:0',
        ]);

        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        $transaction->amount = $request->amount;
        $transaction->save();

        return response()->json([
            'message' => 'Amount updated successfully',
            'transaction' => $transaction,
        ]);
    }


    public function getTransactionsByDate($date)
{
    $transactions = DB::table('transactions as t')
        ->leftJoin('categories as c', 't.category_id', '=', 'c.id')
        ->select(
            't.id',
            't.date',
            'c.name as category_name',
            'c.icon',
            't.amount',
            't.type',
            't.note'
        )
        ->whereDate('t.date', '=', $date)
        ->get();

    $totalIncome = $transactions->where('type', 'income')->sum('amount');
    $totalExpense = $transactions->where('type', 'expense')->sum('amount');

    return response()->json([
        'transactions' => $transactions,
        'total_income' => $totalIncome,
        'total_expense' => $totalExpense,
    ]);
}

   

}