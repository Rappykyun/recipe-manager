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
        'image_url',
        'user_id',
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'prep_time' => 'integer',
    ];

    // Accessor for backward compatibility with image_url
    public function getImageUrlAttribute()
    {
        return $this->image_path;
    }

    // Mutator for backward compatibility with image_url
    public function setImageUrlAttribute($value)
    {
        $this->attributes['image_path'] = $value;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function ingredients(): HasMany
    {
        return $this->hasMany(Ingredient::class, 'recipe_id', 'recipe_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'recipe_tag', 'recipe_id', 'tag_id');
    }
}
