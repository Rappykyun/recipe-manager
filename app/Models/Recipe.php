<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recipe extends Model
{
    protected $primaryKey = 'recipe_id';
    protected $fillable = [
        'title',
        'description',
        'category',
        'prep_time',
        'is_public',
        'image_path',
    ];

    public function user(): BelongsTo
{
        return $this->belongsTo(User::class);
}

public function ingredients(): HasMany{
    return $this->hasMany(Ingredient::class);
}
public function tags(): BelongsToMany{
    return $this->belongsToMany(Tag::class);
}
}
