<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{

    use HasFactory;


    public const STATUS_LEVELS = ['returned', 'pending', 'rejected'];
    public const ORDER_TYPE = ['purchase', 'borrow'];

    protected $fillable = ['status', 'due_date', 'order_type', 'returned_at'];

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }
}
