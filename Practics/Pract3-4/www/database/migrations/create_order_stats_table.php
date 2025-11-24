<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_stats', function (Blueprint $table)
        {
            $table->id();
            $table->string('customer_name');
            $table->string('service_category');
            $table->date('order_date');
            $table->decimal('revenue', 10, 2);
            $table->enum('status', ['completed', 'canceled', 'refunded']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_stats');
    }
};