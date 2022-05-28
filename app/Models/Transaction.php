<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        return $this->belongsToMany(Category::class, 'category_transaction', 'transaction_id', 'category_id');
    }

    public function subcategories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_transaction', 'transaction_id', 'category_id');
        //i tried to select subcategory based on the selected category 
        // ->whereHas('category.parnt', function ($query){
        //     $query->where('parent_id',Category::id());
        // });
    }


    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
