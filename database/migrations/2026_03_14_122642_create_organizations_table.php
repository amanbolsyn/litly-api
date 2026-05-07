<?php

use App\Models\Book;
use App\Models\Organization;
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
        Schema::create('organizations', function (Blueprint $table) {
            $table->id();
            $table->string('organization');
            $table->string('city');
            $table->string('address');
            $table->boolean('allow_purchase')->default(false);
            $table->boolean('allow_borrow')->default(false);
            $table->integer('allow_borrow_days')->default(14);
            $table->timestamps();
        });

        Schema::create('book_organization', function (Blueprint $table) {
            $table->primary(['book_id', 'organization_id']);
            $table->foreignIdFor(Book::class, 'book_id')->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Organization::class, 'organization_id')->constrained()->cascadeOnDelete();
            $table->integer('stock')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
        Schema::dropIfExists('book_organization');
    }
};
