<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model,
    SoftDeletes
};
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;
class Blog extends Model
{
    use HasFactory, HasTranslations, SoftDeletes, HasSlug;

    protected $fillable = [
        'slug',
        'views',
        'title',
        'desc',
        'published_at',
        'last_viewed_at',
        'type',
        'img',
        'alt_img',
        'category_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'last_viewed_at' => 'datetime'
    ];

    public $translatable = [
        'slug',
        'title',
        'desc',
        'alt_img'
    ];

    // Relations
    public function contents() : HasMany
    {
        return $this->hasMany(BlogContent::class);
    }

    public function category() : BelongsTo
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    // Attributes
    public function getImgUrlAttribute() : string
    {
        return $this->img ? asset('storage/' . $this->img) : '';
    }

    public function getShortContentAttribute() : string
    {
        return substr($this->content, 0, 100);
    }

    public function getShortContentWithDotsAttribute() : string
    {
        return $this->short_content . '...';
    }

    public function getPublishedAtFormattedAttribute() : string
    {
        return $this->published_at ? $this->published_at->format('d/m/Y') : '';
    }

    public function getLastViewedAtFormattedAttribute() : string
    {
        return $this->last_viewed_at ? $this->last_viewed_at->format('d/m/Y') : '';
    }

    public function getPublishedAtFormattedForInputAttribute() : string
    {
        return $this->published_at ? $this->published_at->format('Y-m-d') : '';
    }

    public function getLastViewedAtFormattedForInputAttribute() : string
    {
        return $this->last_viewed_at ? $this->last_viewed_at->format('Y-m-d') : '';
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }
}
