<?php

use App\Models\Book;
use App\Models\Cart;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->primary(['book_id', 'cart_id']);
            $table->foreignIdFor(Cart::class, 'cart_id');
            $table->foreignIdFor(Book::class, 'book_id');
            $table->string('status');
            $table->string('order_type');
            $table->date('due_at');
            $table->date('returned_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
