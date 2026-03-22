<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Organization extends Model
{
    use HasFactory;

    protected $fillable = ['organization', ',city', 'address', 'allow_borrow', 'allow_purchase', 'allow_borrow_days'];

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class);
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }
}
