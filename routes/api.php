<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Transaction;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CategoryController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/summary', function () {
    $totalIncome = Transaction::where('type', 'income')->sum('amount');
    $totalExpense = Transaction::where('type', 'expense')->sum('amount');
    $balance = $totalIncome - $totalExpense;

    return response()->json([
        'income' => $totalIncome,
        'expense' => $totalExpense,
        'balance' => $balance
    ]);
});

Route::get('/transactions', [TransactionController::class, 'index']);

Route::get('/chart/income', [ChartController::class, 'getIncomeData']);

Route::get('/chart/expense', [ChartController::class, 'getExpenseData']);
Route::put('/transactions/{id}/amount', [TransactionController::class, 'updateAmount']);
Route::get('transactions/date/{date}', [TransactionController::class, 'getTransactionsByDate']);

Route::get('/categories', [CategoryController::class, 'getCategories']);

Route::post('/transactions', [TransactionController::class, 'store']);

Route::delete('/transactions/{id}', [TransactionController::class, 'destroy']);

Route::get('/transactions/expense-summary', [TransactionController::class, 'getExpenseSummary']);
Route::get('/transactions/income-summary', [TransactionController::class, 'getIncomeSummary']);