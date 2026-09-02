<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Method;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Data Metode / Dompet sesuai gambar pertama
        $methods = [
            'CASH', 'BCA', 'SEABANK', 'SHOPEEPAY', 'BANK JAGO', 'GOPAY', 'DANA'
        ];

        foreach ($methods as $method) {
            Method::create(['name' => $method]);
        }

        // Data Kategori sesuai gambar kedua
        $categories = [
            // Pemasukan
            ['name' => 'Kerja', 'type' => 'income'],
            ['name' => 'Pribadi (Pemasukan)', 'type' => 'income'],
            
            // Pengeluaran
            ['name' => 'Makan', 'type' => 'expense'],
            ['name' => 'Transportasi', 'type' => 'expense'],
            ['name' => 'Pribadi (Pengeluaran)', 'type' => 'expense'],
            ['name' => 'Tabungan', 'type' => 'expense'], // Dimasukkan sebagai kategori sesuai gambar
            ['name' => 'Minjamin Uang', 'type' => 'expense'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}