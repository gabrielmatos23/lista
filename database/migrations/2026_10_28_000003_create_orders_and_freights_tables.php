<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained()->restrictOnDelete();
            $table->foreignId('product_id')->constrained()->restrictOnDelete();
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 10, 2);
            $table->string('status')->default('Recebido');
            $table->timestamps();
        });

        Schema::create('freights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();
            $table->text('address');
            $table->decimal('fee', 10, 2);
            $table->date('expected_date');
            $table->string('tracking_code')->nullable();
            $table->string('status')->default('Preparando');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('freights');
        Schema::dropIfExists('orders');
    }
};
