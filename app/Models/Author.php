<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Author extends Model
{

    use HasFactory;

    protected $fillable = ['fullname', 'biography', 'language', 'date_of_birth', 'date_of_death'];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }
}
