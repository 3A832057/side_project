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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('product_code')->comment('產品代碼');
            $table->boolean('is_enabled')->default(true)->comment('0:停用, 1:啟用');
            $table->integer('price')->default(0)->comment('產品價格(以最低為主)');
            $table->integer('sort_order')->default(0)->comment('排列順序');
            $table->boolean('can_choose')->default(false)->comment('可以做選擇');
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
        Schema::dropIfExists('products');
    }
};
