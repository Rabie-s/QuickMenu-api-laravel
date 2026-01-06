<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class Menu extends Model
{
    use HasUuids;
    protected $fillable = [
        'name',
        'cover_image',
        'user_id',
        'is_available',
    ];

    
    public function uniqueIds(): array
    {
        return ['uuid'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}
