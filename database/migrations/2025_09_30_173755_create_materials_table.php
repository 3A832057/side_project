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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('material_code')->comment('材料代碼');
            $table->integer('quantity')->comment('材料所剩數量');
            $table->integer('cost')->comment('成本價');
            $table->integer('low_danger')->comment('最低警告量');
            $table->boolean('is_enabled')->default(true)->comment('0:停用, 1:啟用');
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
        Schema::dropIfExists('materials');
    }
};
