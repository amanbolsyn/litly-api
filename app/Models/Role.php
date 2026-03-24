<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    

    public const ROLES = ['user', 'admin', 'owner', 'support'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function organizatons(): BelongsToMany
    {
        return $this->belongsToMany(Organization::class);
    }
}
