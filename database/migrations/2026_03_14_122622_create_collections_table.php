<?php

use App\Models\Book;
use App\Models\Collection;
use App\Models\User;
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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id');
            $table->string('collection');
            $table->text('description')->nullable();
            $table->boolean('is_public')->default(true);
            $table->timestamps();
        });


        Schema::create('book_collections', function (Blueprint $table) {
            $table->foreignIdFor(Book::class, 'book_id');
            $table->foreignIdFor(Collection::class, 'collection_id');
            $table->primary(['book_id', 'collection_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
        Schema::dropIfExists('book_collections');
    }
};
