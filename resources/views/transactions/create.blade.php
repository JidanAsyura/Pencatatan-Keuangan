<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Tambah Transaksi - Catatan Keuangan</title>

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
        /* Smooth transitions for conditional containers */
        .fade-in {
            animation: fadeIn 0.25s ease-in-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-4px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-slate-100 to-indigo-50/40 min-h-screen text-slate-800 antialiased py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-xl mx-auto">
        <!-- Header / Navigation Bar -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-md shadow-indigo-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">Catatan Keuangan</h1>
                    <p class="text-xs text-slate-500 font-medium">Tambah & Kelola Transaksi Baru</p>
                </div>
            </div>

            @if (Route::has('dashboard'))
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-xs font-semibold text-slate-600 hover:text-indigo-600 bg-white border border-slate-200 hover:border-indigo-300 rounded-lg px-3 py-2 transition-all shadow-sm">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            @endif
        </div>

        <!-- Success Message Banner -->
        @if (session('success'))
            <div id="alert-success" class="mb-5 flex items-start p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 shadow-sm fade-in">
                <svg class="w-5 h-5 text-emerald-600 mt-0.5 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1 text-sm font-medium">
                    {{ session('success') }}
                </div>
                <button type="button" onclick="document.getElementById('alert-success').remove()" class="text-emerald-500 hover:text-emerald-700 ml-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        @endif

        <!-- Validation Errors Alert -->
        @if (isset($errors) && $errors->any())
            <div id="alert-errors" class="mb-5 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 shadow-sm fade-in">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-rose-600 mt-0.5 mr-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-rose-900 mb-1">Terdapat kesalahan pada formulir:</h3>
                        <ul class="list-disc list-inside text-xs space-y-1 text-rose-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" onclick="document.getElementById('alert-errors').remove()" class="text-rose-500 hover:text-rose-700 ml-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif

        <!-- Main Card Form -->
        <div class="bg-white rounded-2xl shadow-xl shadow-slate-200/70 border border-slate-200/80 overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-lg font-bold text-slate-800">Form Transaksi</h2>
                <p class="text-xs text-slate-500 mt-0.5">Lengkapi data transaksi di bawah ini dengan benar</p>
            </div>

            <form action="{{ route('transactions.store') }}" method="POST" class="p-6 space-y-5" id="transactionForm">
                @csrf

                <!-- Date & Type (2 Columns) -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Date Input -->
                    <div>
                        <label for="date" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Tanggal <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <input 
                                type="date" 
                                name="date" 
                                id="date" 
                                value="{{ old('date', date('Y-m-d')) }}" 
                                required
                                class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border @error('date') border-rose-300 ring-1 ring-rose-300 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium"
                            >
                        </div>
                        @error('date')
                            <p class="text-rose-600 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type Select -->
                    <div>
                        <label for="type" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                            Jenis Transaksi <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                                </svg>
                            </div>
                            <select 
                                name="type" 
                                id="type" 
                                required
                                class="w-full pl-10 pr-9 py-2.5 bg-slate-50 border @error('type') border-rose-300 ring-1 ring-rose-300 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium appearance-none cursor-pointer"
                            >
                                <option value="income" {{ old('type') == 'income' ? 'selected' : '' }}>Income (Pemasukan)</option>
                                <option value="expense" {{ old('type', 'expense') == 'expense' ? 'selected' : '' }}>Expense (Pengeluaran)</option>
                                <option value="transfer" {{ old('type') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </div>
                        @error('type')
                            <p class="text-rose-600 text-xs mt-1 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Amount Input with Rupiah Format -->
                <div>
                    <label for="amount_display" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Nominal / Jumlah <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none font-bold text-slate-400 text-sm">
                            Rp
                        </div>
                        <!-- User-facing formatted input (displays 1.000.000) -->
                        <input 
                            type="text" 
                            id="amount_display" 
                            inputmode="numeric"
                            placeholder="0"
                            value="{{ old('amount') ? number_format((float)old('amount'), 0, ',', '.') : '' }}" 
                            required
                            class="w-full pl-11 pr-4 py-2.5 bg-slate-50 border @error('amount') border-rose-300 ring-1 ring-rose-300 @else border-slate-200 @enderror rounded-xl text-base font-semibold text-slate-900 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all placeholder-slate-300"
                        >
                        <!-- Hidden input storing pure numbers for backend Laravel validation -->
                        <input 
                            type="hidden" 
                            name="amount" 
                            id="amount" 
                            value="{{ old('amount') }}"
                        >
                    </div>
                    @error('amount')
                        <p class="text-rose-600 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Conditional Section: Income / Expense Fields -->
                <div id="standardFields" class="space-y-4 fade-in">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Wallet / Method -->
                        <div>
                            <label for="method_id" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Dompet / Akun <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                    </svg>
                                </div>
                                <select 
                                    name="method_id" 
                                    id="method_id" 
                                    class="w-full pl-10 pr-9 py-2.5 bg-slate-50 border @error('method_id') border-rose-300 ring-1 ring-rose-300 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium appearance-none cursor-pointer"
                                >
                                    <option value="" disabled {{ old('method_id') ? '' : 'selected' }}>-- Pilih Dompet / Akun --</option>
                                    @foreach ($methods as $method)
                                        <option value="{{ $method->id }}" {{ old('method_id') == $method->id ? 'selected' : '' }}>
                                            {{ $method->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('method_id')
                                <p class="text-rose-600 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Kategori <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                    </svg>
                                </div>
                                <select 
                                    name="category_id" 
                                    id="category_id" 
                                    class="w-full pl-10 pr-9 py-2.5 bg-slate-50 border @error('category_id') border-rose-300 ring-1 ring-rose-300 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium appearance-none cursor-pointer"
                                >
                                    <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>-- Pilih Kategori --</option>
                                    @foreach ($categories as $category)
                                        <option 
                                            value="{{ $category->id }}" 
                                            data-type="{{ strtolower($category->type ?? '') }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                                        >
                                            {{ $category->name }} {{ !empty($category->type) ? '('.ucfirst($category->type).')' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('category_id')
                                <p class="text-rose-600 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Conditional Section: Transfer Fields -->
                <div id="transferFields" class="space-y-4 hidden fade-in">
                    <div class="p-3.5 bg-indigo-50/70 border border-indigo-100 rounded-xl flex items-center space-x-2 text-xs text-indigo-700 font-medium">
                        <svg class="w-4 h-4 shrink-0 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Transfer akan memindahkan saldo dari dompet asal ke dompet tujuan.</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- From Method -->
                        <div>
                            <label for="from_method_id" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Dari Dompet / Akun <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-rose-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                    </svg>
                                </div>
                                <select 
                                    name="from_method_id" 
                                    id="from_method_id" 
                                    class="w-full pl-10 pr-9 py-2.5 bg-slate-50 border @error('from_method_id') border-rose-300 ring-1 ring-rose-300 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium appearance-none cursor-pointer"
                                >
                                    <option value="" disabled {{ old('from_method_id') ? '' : 'selected' }}>-- Pilih Dompet Asal --</option>
                                    @foreach ($methods as $method)
                                        <option value="{{ $method->id }}" {{ old('from_method_id') == $method->id ? 'selected' : '' }}>
                                            {{ $method->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('from_method_id')
                                <p class="text-rose-600 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- To Method -->
                        <div>
                            <label for="to_method_id" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                                Ke Dompet / Akun <span class="text-rose-500">*</span>
                            </label>
                            <div class="relative rounded-xl shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-emerald-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                    </svg>
                                </div>
                                <select 
                                    name="to_method_id" 
                                    id="to_method_id" 
                                    class="w-full pl-10 pr-9 py-2.5 bg-slate-50 border @error('to_method_id') border-rose-300 ring-1 ring-rose-300 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium appearance-none cursor-pointer"
                                >
                                    <option value="" disabled {{ old('to_method_id') ? '' : 'selected' }}>-- Pilih Dompet Tujuan --</option>
                                    @foreach ($methods as $method)
                                        <option value="{{ $method->id }}" {{ old('to_method_id') == $method->id ? 'selected' : '' }}>
                                            {{ $method->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </div>
                            </div>
                            @error('to_method_id')
                                <p class="text-rose-600 text-xs mt-1 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Description Input (Optional) -->
                <div>
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">
                        Deskripsi / Keterangan <span class="text-xs font-normal text-slate-400 lowercase">(opsional)</span>
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                            </svg>
                        </div>
                        <input 
                            type="text" 
                            name="description" 
                            id="description" 
                            placeholder="Contoh: Makan siang nasi padang, Gaji bulanan..." 
                            value="{{ old('description') }}"
                            class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border @error('description') border-rose-300 ring-1 ring-rose-300 @else border-slate-200 @enderror rounded-xl text-sm text-slate-800 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all font-medium placeholder-slate-300"
                        >
                    </div>
                    @error('description')
                        <p class="text-rose-600 text-xs mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit & Action Buttons -->
                <div class="pt-4 border-t border-slate-100 flex flex-col sm:flex-row items-center gap-3">
                    <button 
                        type="submit" 
                        class="w-full sm:flex-1 py-3 px-6 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold text-sm shadow-md shadow-indigo-200 hover:shadow-lg hover:shadow-indigo-300 active:scale-[0.99] transition-all flex items-center justify-center space-x-2 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        <span>Simpan Transaksi</span>
                    </button>

                    @if (Route::has('dashboard'))
                        <a 
                            href="{{ route('dashboard') }}" 
                            class="w-full sm:w-auto py-3 px-5 rounded-xl border border-slate-200 hover:bg-slate-50 text-slate-600 hover:text-slate-800 font-medium text-sm text-center transition-all cursor-pointer"
                        >
                            Batal
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Footer / Tips -->
        <p class="text-center text-xs text-slate-400 mt-6 font-medium">
            Pastikan data transaksi sudah sesuai sebelum menekan tombol simpan.
        </p>
    </div>

    <!-- Vanilla JavaScript for Dynamic Form Behavior -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('type');
            const standardFields = document.getElementById('standardFields');
            const transferFields = document.getElementById('transferFields');

            const methodSelect = document.getElementById('method_id');
            const categorySelect = document.getElementById('category_id');
            const fromMethodSelect = document.getElementById('from_method_id');
            const toMethodSelect = document.getElementById('to_method_id');

            function toggleFormFields() {
                const selectedType = (typeSelect.value || '').toLowerCase();

                if (selectedType === 'transfer') {
                    // Hide standard fields and disable inputs so they are not validated/submitted as empty
                    standardFields.classList.add('hidden');
                    methodSelect.disabled = true;
                    categorySelect.disabled = true;

                    // Show transfer fields and enable inputs
                    transferFields.classList.remove('hidden');
                    fromMethodSelect.disabled = false;
                    toMethodSelect.disabled = false;
                } else {
                    // Show standard fields (Income / Expense) and enable inputs
                    standardFields.classList.remove('hidden');
                    methodSelect.disabled = false;
                    categorySelect.disabled = false;

                    // Hide transfer fields and disable inputs
                    transferFields.classList.add('hidden');
                    fromMethodSelect.disabled = true;
                    toMethodSelect.disabled = true;

                    // Optional: Filter categories based on income / expense type
                    filterCategoriesByType(selectedType);
                }
            }

            function filterCategoriesByType(currentType) {
                if (!categorySelect) return;
                const options = categorySelect.querySelectorAll('option[data-type]');
                options.forEach(opt => {
                    const optType = opt.getAttribute('data-type');
                    // If option has type defined, display only matching type or all if blank
                    if (!optType || optType === currentType) {
                        opt.style.display = '';
                    } else {
                        opt.style.display = 'none';
                    }
                });
            }

            // Rupiah Formatting for Amount Input
            const amountDisplay = document.getElementById('amount_display');
            const amountHidden = document.getElementById('amount');
            const transactionForm = document.getElementById('transactionForm');

            function formatRupiah(value) {
                const cleanDigits = (value || '').toString().replace(/[^0-9]/g, '');
                if (!cleanDigits) return { formatted: '', raw: '' };
                const formatted = new Intl.NumberFormat('id-ID').format(cleanDigits);
                return { formatted, raw: cleanDigits };
            }

            if (amountDisplay && amountHidden) {
                // Initialize if old value exists
                if (amountHidden.value) {
                    const initData = formatRupiah(amountHidden.value);
                    amountDisplay.value = initData.formatted;
                    amountHidden.value = initData.raw;
                }

                // Format on user typing / pasting
                amountDisplay.addEventListener('input', function () {
                    const { formatted, raw } = formatRupiah(this.value);
                    this.value = formatted;
                    amountHidden.value = raw;
                });

                // Ensure pure integer digits are submitted
                if (transactionForm) {
                    transactionForm.addEventListener('submit', function () {
                        const { raw } = formatRupiah(amountDisplay.value);
                        amountHidden.value = raw;
                    });
                }
            }

            // Listen for changes on type dropdown
            typeSelect.addEventListener('change', toggleFormFields);

            // Run on initial page load to restore state (e.g., when validation error occurs)
            toggleFormFields();
        });
    </script>
</body>
</html>
