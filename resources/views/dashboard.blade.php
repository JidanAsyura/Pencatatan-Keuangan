<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard Keuangan - Catatan Keuangan</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS (Vite & CDN Fallback) -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen text-slate-800 antialiased py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto space-y-6">

        <!-- Flash Message -->
        @if (session('success'))
            <div id="alert-success" class="flex items-center justify-between p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-sm transition-all">
                <div class="flex items-center space-x-3">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm font-medium">{{ session('success') }}</span>
                </div>
                <button type="button" onclick="document.getElementById('alert-success').remove()" class="text-emerald-500 hover:text-emerald-700">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Header Section -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center space-x-3.5">
                <div class="w-12 h-12 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-md shadow-indigo-200 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-900 tracking-tight">Dashboard Keuangan</h1>
                    <p class="text-xs sm:text-sm text-slate-500 font-medium">Pantau arus kas, sisa saldo dompet, dan riwayat transaksi</p>
                </div>
            </div>

            <div>
                <a 
                    href="{{ route('transactions.create') }}" 
                    class="inline-flex items-center justify-center space-x-2 w-full sm:w-auto px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white text-sm font-semibold shadow-md shadow-indigo-200 hover:shadow-lg hover:shadow-indigo-300 active:scale-[0.98] transition-all cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span>Tambah Transaksi</span>
                </a>
            </div>
        </div>

        <!-- Summary Cards (Grid Layout) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
            <!-- Card 1: Total Pemasukan -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Pemasukan</span>
                    <div class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-2xl sm:text-3xl font-extrabold text-emerald-600 tracking-tight">
                        Rp {{ number_format($totalIncome ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Total seluruh dana masuk</p>
                </div>
            </div>

            <!-- Card 2: Total Pengeluaran -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Total Pengeluaran</span>
                    <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    <p class="text-2xl sm:text-3xl font-extrabold text-rose-600 tracking-tight">
                        Rp {{ number_format($totalExpense ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Total seluruh pengeluaran</p>
                </div>
            </div>

            <!-- Card 3: Total Sisa Saldo / Net Balance -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-500">Sisa Saldo Bersih</span>
                    <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-3">
                    @php
                        $netBalance = $balance ?? (($totalIncome ?? 0) - ($totalExpense ?? 0));
                    @endphp
                    <p class="text-2xl sm:text-3xl font-extrabold @if($netBalance < 0) text-rose-600 @else text-slate-900 @endif tracking-tight">
                        Rp {{ number_format($netBalance, 0, ',', '.') }}
                    </p>
                    <p class="text-xs text-slate-400 mt-1 font-medium">Akumulasi saldo saat ini</p>
                </div>
            </div>
        </div>

        <!-- Wallet Balances (Sisa Saldo per Dompet) -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-2.5">
                    <div class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Sisa Saldo Dompet & Rekening</h2>
                    </div>
                </div>
                <span class="text-xs text-slate-400 font-medium">{{ count($methods ?? []) }} Metode Tersedia</span>
            </div>

            <div class="p-4 sm:p-6">
                @if (isset($methods) && count($methods) > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3.5">
                        @foreach ($methods as $method)
                            <div class="flex items-center justify-between p-3.5 rounded-xl bg-slate-50 border border-slate-100 hover:border-indigo-200 hover:bg-indigo-50/30 transition-all">
                                <div class="flex items-center space-x-3">
                                    <div class="w-8 h-8 rounded-lg bg-white border border-slate-200/80 flex items-center justify-center text-slate-600 font-bold text-xs shadow-2xs">
                                        {{ strtoupper(substr($method->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ $method->name }}</p>
                                        <p class="text-[11px] text-slate-400 font-medium">Metode Pembayaran</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-extrabold @if(($method->balance ?? 0) < 0) text-rose-600 @else text-slate-900 @endif">
                                        Rp {{ number_format($method->balance ?? 0, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6 text-slate-400 text-xs font-medium">
                        Belum ada metode/dompet yang terdaftar.
                    </div>
                @endif
            </div>
        </div>

        <!-- Transaction History Table -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center space-x-2.5">
                    <div class="w-7 h-7 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Riwayat Transaksi</h2>
                    </div>
                </div>
                <span class="text-xs text-slate-400 font-medium">{{ count($transactions ?? []) }} Transaksi</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-500">
                            <th scope="col" class="py-3 px-6">Tanggal</th>
                            <th scope="col" class="py-3 px-6">Kategori</th>
                            <th scope="col" class="py-3 px-6">Tipe</th>
                            <th scope="col" class="py-3 px-6">Metode</th>
                            <th scope="col" class="py-3 px-6">Detail</th>
                            <th scope="col" class="py-3 px-6 text-right">Nominal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($transactions as $transaction)
                            @php
                                $typeLower = strtolower($transaction->type ?? '');
                                $isIncome = in_array($typeLower, ['income', 'transfer_in']);
                                $isExpense = in_array($typeLower, ['expense', 'transfer_out']);
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition-colors">
                                <!-- Tanggal -->
                                <td class="py-3.5 px-6 whitespace-nowrap text-xs font-semibold text-slate-700">
                                    {{ $transaction->date ? \Carbon\Carbon::parse($transaction->date)->translatedFormat('d M Y') : '-' }}
                                </td>

                                <!-- Kategori -->
                                <td class="py-3.5 px-6 whitespace-nowrap">
                                    @if ($transaction->category)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-700">
                                            {{ $transaction->category->name }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700">
                                            Transfer
                                        </span>
                                    @endif
                                </td>

                                <!-- Tipe -->
                                <td class="py-3.5 px-6 whitespace-nowrap">
                                    @if ($typeLower === 'income')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                            Income
                                        </span>
                                    @elseif ($typeLower === 'expense')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-700">
                                            Expense
                                        </span>
                                    @elseif ($typeLower === 'transfer_in')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-cyan-100 text-cyan-700">
                                            Transfer In
                                        </span>
                                    @elseif ($typeLower === 'transfer_out')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                            Transfer Out
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                            {{ ucfirst($transaction->type) }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Metode -->
                                <td class="py-3.5 px-6 whitespace-nowrap text-xs font-semibold text-slate-800">
                                    {{ $transaction->method->name ?? '-' }}
                                </td>

                                <!-- Detail -->
                                <td class="py-3.5 px-6 text-xs text-slate-500 max-w-xs truncate">
                                    {{ $transaction->description ?: '-' }}
                                </td>

                                <!-- Nominal (Amount) -->
                                <td class="py-3.5 px-6 whitespace-nowrap text-right text-sm font-bold">
                                    @if ($isIncome)
                                        <span class="text-emerald-600">
                                            + Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>
                                    @elseif ($isExpense)
                                        <span class="text-rose-600">
                                            - Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="text-slate-800">
                                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 px-6 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-2.5">
                                        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <p class="text-sm font-semibold text-slate-700">Belum ada data transaksi</p>
                                        <p class="text-xs text-slate-400">Silakan tambahkan transaksi baru untuk mulai melacak keuangan.</p>
                                        <div class="pt-2">
                                            <a href="{{ route('transactions.create') }}" class="inline-flex items-center space-x-1.5 text-xs font-semibold text-indigo-600 hover:text-indigo-700 bg-indigo-50 hover:bg-indigo-100 px-3.5 py-2 rounded-lg transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                                </svg>
                                                <span>Tambah Transaksi Pertama</span>
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
</html>