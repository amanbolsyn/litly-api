<?php

use App\Models\Publisher;
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
        Schema::create('publishers', function (Blueprint $table) {
            $table->id();
            $table->string('publisher');
            $table->timestamps();
        });

        Schema::create('book_publishers', function (Blueprint $table) {
            $table->foreignIdFor(Publisher::class, 'book_id');
            $table->foreignIdFor(Publisher::class, 'publisher_id');
            $table->primary(['book_id', 'publisher_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publishers');
        Schema::dropIfExists('book_publishers');
    }
};
