<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('sku', 15);
            $table->decimal('price');
            $table->timestamps();
        });

        DB::table('products')->insert([
            [
                'name' => 'Product 1',
                'sku' => 'PROD01',
                'price' => 15.21,
            ],
            [
                'name' => 'Product 2',
                'sku' => 'PROD02',
                'price' => 5.21,
            ],
            [
                'name' => 'Product 3',
                'sku' => 'PROD03',
                'price' => 12.26,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
