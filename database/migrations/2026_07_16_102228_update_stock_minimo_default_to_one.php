<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('inventario')->where('stock_minimo', 5)->update(['stock_minimo' => 1]);
    }

    public function down(): void
    {
        DB::table('inventario')->where('stock_minimo', 1)->update(['stock_minimo' => 5]);
    }
};
