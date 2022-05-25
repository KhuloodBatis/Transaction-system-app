<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use HasFactory;

    public function transactions(): BelongsToMany
    {
        return $this->belongsToMany(Transaction::class, 'category_transaction');
    }

    public function subcategories(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
}
