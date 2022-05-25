<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'payer',
        'amount',
        'status',
        'due_on'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'payer', 'id');
    }


    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_transaction');
    }
}
