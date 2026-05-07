<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Author extends Model
{

    use HasFactory;

    protected $fillable = [
        'fullname',
        'biography',
        'languages',
        'date_of_birth',
        'date_of_death',
        'portrait_img'
    ];


    protected $casts = [
        'languages' => 'array',
    ];


    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }

    public function files(): MorphMany
    {
        return $this->morphMany(File::class, 'fileable');
    }
}
