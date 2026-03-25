<?php

use App\Models\Author;
use App\Models\Book;
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
        Schema::create('authors', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->text('biography')->nullable();
            $table->json('languages')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_death')->nullable();
            $table->string('portrait')->nullable();
            $table->timestamps();
        });

        Schema::create('author_book', function (Blueprint $table) {
            $table->foreignIdFor(Book::class, 'book_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Author::class, 'author_id')->constrained()->cascadeOnDelete();
            $table->primary(['book_id', 'author_id']);
        });
    }




    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authors');
        Schema::dropIfExists('author_book');
    }
};
