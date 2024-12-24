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



public function getCategories()
{
    $categories = DB::table('categories')
        ->select('id', 'name', 'icon')
        ->get();

    return response()->json($categories);
}



public function store(Request $request)
{
    \Log::info('Incoming Request:', $request->all());

    $validated = $request->validate([
        'date' => 'required|date',
        'amount' => 'required|integer|min:0',
        'type' => 'required|in:income,expense',
        'category_id' => 'required|exists:categories,id',
        'note' => 'nullable|string',
    ]);

    $transaction = Transaction::create($validated);

    \Log::info('Transaction Created:', $transaction->toArray());

    return response()->json([
        'success' => true,
        'message' => 'Transaction saved successfully',
        'data' => $transaction,
    ], 201);
}
   

public function getExpenseSummary()
{
    $expenses = \DB::table('transactions')
        ->join('categories', 'transactions.category_id', '=', 'categories.id')
        ->select(
            'categories.name as category_name',
            \DB::raw('SUM(transactions.amount) as total_amount')
        )
        ->where('transactions.type', 'expense')
        ->groupBy('categories.name')
        ->get();

    $totalExpense = $expenses->sum('total_amount');

    $summary = $expenses->map(function ($expense) use ($totalExpense) {
        return [
            'category_name' => $expense->category_name,
            'percentage' => round(($expense->total_amount / $totalExpense) * 100, 2),
        ];
    });

    return response()->json($summary, 200);
}

public function getIncomeSummary()
{
    $incomes = \DB::table('transactions')
        ->join('categories', 'transactions.category_id', '=', 'categories.id')
        ->select(
            'categories.name as category_name',
            \DB::raw('SUM(transactions.amount) as total_amount')
        )
        ->where('transactions.type', 'income')
        ->groupBy('categories.name')
        ->get();

    $totalIncome = $incomes->sum('total_amount');

    $summary = $incomes->map(function ($income) use ($totalIncome) {
        return [
            'category_name' => $income->category_name,
            'percentage' => round(($income->total_amount / $totalIncome) * 100, 2),
        ];
    });

    return response()->json($summary, 200);
}

public function destroy($id)
{
    $transaction = Transaction::find($id);

    if (!$transaction) {
        return response()->json([
            'success' => false,
            'message' => 'Transaction not found'
        ], 404);
    }

    $transaction->delete();

    return response()->json([
        'success' => true,
        'message' => 'Transaction deleted successfully'
    ], 200);
}


}