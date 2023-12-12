<?php

namespace App\Models;

use Illuminate\Database\Eloquent\{
    Factories\HasFactory,
    Model
};
use Illuminate\Database\Eloquent\Relations\HasMany;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'views',
        'title',
        'desc',
        'published_at',
        'last_viewed_at',
        'type',
        'img',
        'alt_img'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'last_viewed_at' => 'datetime'
    ];

    public function contents() : HasMany
    {
        return $this->hasMany(BlogContent::class);
    }

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
}
