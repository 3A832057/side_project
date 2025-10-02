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
        Schema::create('product_materials', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->comment('主產品id');
            $table->integer('material')->comment('產品材料id');
            $table->integer('price')->comment('總定價');
            $table->integer('sort_order')->default(0)->comment('排列順序');
 
            $table->boolean('is_hidden')->default(false)->comment('當作刪除使用');
            $table->timestamp('hidden_at')->nullable()->comment('刪除時間');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_materials');
    }
};
