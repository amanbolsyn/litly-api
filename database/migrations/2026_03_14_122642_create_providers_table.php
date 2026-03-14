<?php

use App\Models\Book;
use App\Models\Provider;
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
        Schema::create('providers', function (Blueprint $table) {
            $table->id();
            $table->string('provider');
            $table->string('city');
            $table->string('address');
            $table->boolean('allow_purchase')->default(false);
            $table->boolean('allow_borrow')->default(false);
            $table->integer('allow_borrow_days')->default(14);
            $table->timestamps();
        });

        Schema::create('book_providers', function (Blueprint $table) {
            $table->foreignIdFor(Book::class, 'book_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Provider::class, 'provider_id')->constrained()->cascadeOnDelete();
            $table->primary(['book_id', 'provider_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('providers');
        Schema::dropIfExists('book_providers');
    }
};
