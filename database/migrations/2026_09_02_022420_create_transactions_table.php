<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('transactions', function (Blueprint $table) {
        $table->id();
        $table->date('date');
        $table->enum('type', ['income', 'expense', 'transfer_in', 'transfer_out']);
        $table->decimal('amount', 15, 2); // Nominal transaksi (bisa menampung angka besar)
        $table->string('description')->nullable(); // Detail Transaksi
        
        // Relasi ke tabel methods
        $table->foreignId('method_id')->constrained('methods')->cascadeOnDelete();
        
        // Relasi ke tabel categories (boleh kosong kalau tipenya transfer)
        $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
