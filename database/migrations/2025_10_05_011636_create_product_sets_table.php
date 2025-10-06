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
        Schema::create('product_sets', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->comment('產品id');
            $table->integer('price')->comment('定價');
            $table->string('name')->comment('組合名稱 ex:A類(300ml)');
            $table->integer('parent_id')->nullable();
            $table->tinyInteger('level')->default(1);
            $table->integer('image_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_sets');
    }
};
