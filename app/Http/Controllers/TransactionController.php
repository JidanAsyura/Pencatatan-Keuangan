<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Method;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    // Tampilkan halaman utama
    public function index()
    {
        $transactions = Transaction::with(['method', 'category'])
            ->orderBy('date', 'desc')
            ->get();

        // Hitung total pemasukan dan pengeluaran
        $totalIncome = Transaction::whereIn('type', ['income', 'transfer_in'])->sum('amount');
        $totalExpense = Transaction::whereIn('type', ['expense', 'transfer_out'])->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // Ambil methods dan hitung saldo tiap dompet
        $methods = Method::with('transactions')->get()->map(function ($method) {
            $in = $method->transactions->whereIn('type', ['income', 'transfer_in'])->sum('amount');
            $out = $method->transactions->whereIn('type', ['expense', 'transfer_out'])->sum('amount');
            $method->balance = $in - $out;
            return $method;
        });

        return view('dashboard', compact('transactions', 'totalIncome', 'totalExpense', 'methods', 'balance'));
    }

    // Tampilkan form tambah transaksi
    public function create()
    {
        $methods = Method::all();
        $categories = Category::all();
        return view('transactions.create', compact('methods', 'categories'));
    }

    // Simpan transaksi baru
    public function store(Request $request)
    {
        // Validasi tipe transaksi utama
        $request->validate([
            'type' => 'required|in:income,expense,transfer',
        ]);

        if ($request->type === 'transfer') {
            $request->validate([
                'date' => 'required|date',
                'amount' => 'required|numeric|min:1',
                'from_method_id' => 'required|exists:methods,id|different:to_method_id',
                'to_method_id' => 'required|exists:methods,id',
                'description' => 'nullable|string|max:255',
            ], [
                'from_method_id.required' => 'Dompet asal wajib dipilih.',
                'to_method_id.required' => 'Dompet tujuan wajib dipilih.',
                'from_method_id.different' => 'Dompet asal dan tujuan tidak boleh sama.',
            ]);

            $fromMethod = Method::find($request->from_method_id);
            $toMethod = Method::find($request->to_method_id);

            DB::transaction(function () use ($request, $fromMethod, $toMethod) {
                $descSuffix = ' (Transfer: ' . ($fromMethod?->name ?? '-') . ' -> ' . ($toMethod?->name ?? '-') . ')';
                $description = $request->description ? $request->description . $descSuffix : 'Transfer ke ' . ($toMethod?->name ?? '-');

                // 1. Dana keluar dari dompet asal
                Transaction::create([
                    'date' => $request->date,
                    'type' => 'transfer_out',
                    'amount' => $request->amount,
                    'method_id' => $request->from_method_id,
                    'category_id' => null,
                    'description' => $description,
                ]);

                // 2. Dana masuk ke dompet tujuan
                Transaction::create([
                    'date' => $request->date,
                    'type' => 'transfer_in',
                    'amount' => $request->amount,
                    'method_id' => $request->to_method_id,
                    'category_id' => null,
                    'description' => $description,
                ]);
            });

            return redirect()->route('dashboard')->with('success', 'Transfer antar dompet berhasil dicatat!');
        }

        // Jika income atau expense
        $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:1',
            'method_id' => 'required|exists:methods,id',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:255',
        ], [
            'method_id.required' => 'Dompet / Metode pembayaran wajib dipilih.',
            'category_id.required' => 'Kategori transaksi wajib dipilih.',
        ]);

        Transaction::create([
            'date' => $request->date,
            'type' => $request->type,
            'amount' => $request->amount,
            'method_id' => $request->method_id,
            'category_id' => $request->category_id,
            'description' => $request->description,
        ]);

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil ditambahkan!');
    }

    // Tampilkan form edit transaksi
    public function edit(Transaction $transaction)
    {
        $methods = Method::all();
        $categories = Category::all();
        return view('form_transaksi', compact('transaction', 'methods', 'categories'));
    }

    // Update transaksi
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'date' => 'required|date',
            'type' => 'required|in:income,expense,transfer_in,transfer_out',
            'amount' => 'required|numeric|min:0',
            'method_id' => 'required|exists:methods,id',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:255',
        ]);

        $transaction->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil diupdate!');
    }

    // Hapus transaksi
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('dashboard')->with('success', 'Transaksi berhasil dihapus!');
    }
}
