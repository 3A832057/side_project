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
        Schema::create('material_quantity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('material_code')->comment('材料代碼');
            $table->integer('before')->comment('原始數量');
            $table->integer('quantity')->comment('變動數量');
            $table->integer('after')->comment('變動後數量');
            $table->integer('description')->comment('變動說明');
            $table->string('admin_account')->comment('變動人員帳號');
            $table->string('admin_name')->comment('變動人員姓名');
            $table->timestamps();
        });

    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_quantity_logs');
    }
};
